<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str; 
use App\Mail\SendMail;
use Auth;
use App\Custom;
use App\Payment;
use App\Paylink;
use App\MerchantBusiness;


class MerchantEmpController extends Controller
{
    
    public $empId;
    public $merchantId;
    public $datetime;

    public function __construct()
    {
        $this->datetime = date('Y-m-d H:i:s');
    }
//test
    public static function page_limit(){
        $per_page = array(
                "10"=>"10",
                "25"=>"25",
                "50"=>"50",
                "75"=>"75",
                "100"=>"100"
            );
            return $per_page;
    }

    public function index(){
        $empId = Auth::guard('merchantemp')->user()->employee_type;
        // dd($empId);die();
        return view(".merchantemp.transaction");
    }

    private function _arrayPaginator($array,$request,$module="",$perPage=10) 
    {
        $page = Input::get('page', 1);
        $offset = ($page * $perPage) - $perPage;
        return new LengthAwarePaginator(array_slice($array, $offset, $perPage, true), count($array), $perPage, $page,
            ['path' =>'/merchant/employee/pagination/'.$module.'-'.$perPage, 'query' => $request->query()]);
    }

    private function _search_algorithm($search_array,$search_key)
    {
        $search_result = [];
        foreach ($search_array as $index => $object) {
            foreach ($object as $key => $value) {
                if(preg_match("/{$search_key}/i",$value)) {
                    $search_result[$index] = $object;
                }
            }
        }

        return $search_result;
    }

    public function get_transaction(Request $request,$perPage){


        $empId = Auth::guard('merchantemp')->user()->id;
        $merchantId = Auth::guard('merchantemp')->user()->created_merchant;

        $transaction = new Payment();
        $transactions = $transaction->get_emp_payments($merchantId,$empId);
        $request->session()->forget('payments-search');
        $transaction_paginate = $this->_arrayPaginator($transactions,$request,"transaction",$perPage);

        return View::make(".merchantemp.pagination")->with(["transactions"=>$transaction_paginate,"module"=>"transaction"])->render();
    
    }

    public function get_payment(Request $request,$id)
    {
        $transaction = new Payment();
        echo json_encode($transaction->get_payment($id));
    }

    public function showpaylink(){

        return view(".merchantemp.paylink");
    }

    public function get_paylink(Request $request,$perPage){

        if($request->ajax())
        {

            $this->empId = Auth::guard('merchantemp')->user()->id;
            $this->merchantId = Auth::guard('merchantemp')->user()->created_merchant;

            $paylink = new Paylink();
            $paylinks = $paylink->get_emp_smtpaylinks($this->merchantId,$this->empId);
            $request->session()->forget('paylinks-search');
            $paylink_paginate = $this->_arrayPaginator($paylinks,$request,"paylink",$perPage);

            return View::make(".merchantemp.pagination")->with(["paylinks"=>$paylink_paginate,"module"=>"paylink"])->render();
        }
    }

    public function store_paylink(Request $request){

        if($request->ajax())
        {

            $this->empId = Auth::guard('merchantemp')->user()->id;
            $this->merchantId = Auth::guard('merchantemp')->user()->created_merchant;

            $validator = Validator::make($request->all(),
            [
                'paylink_amount'=>'required|numeric',
                'paylink_for'=>'required',
            ]);
            
            if($validator->fails())
            {
                echo json_encode(["status"=>FALSE,"errors"=>$validator->errors()]);

            }else{

                $paylink = new Paylink();
                $paylink_payid = Str::random(6);
                $paylink_link = "";

                $paylink_link = url('/')."/p/s-p/".$paylink_payid;

                $fields = $request->except('_token');
                $fields["paylink_gid"]   = "plnk_".Str::random(16);
                $fields["paylink_payid"] = $paylink_payid;
                $fields["paylink_link"]  = $paylink_link;
                $fields["created_date"]  = $this->datetime;
                $fields["created_merchant"] = $this->merchantId;
                $fields["created_employee"] = $this->empId;
                
                $insert_status = $paylink->add_paylink($fields);

                if($insert_status)
                {
                    if($fields["email_paylink"] == "Y")
                    {  
                        $business_name = MerchantBusiness::get_business_name($this->merchantId);
                        $data = array(
                            "from" => env("MAIL_USERNAME", ""),
                            "subject" => "Requesting payment of INR ".number_format($fields["paylink_amount"],2)." From ".ucfirst($business_name),
                            "view" => "/maillayouts/rpaylinkmail",
                            "htmldata" => array(
                                "paylink_for"=>$fields["paylink_for"],
                                "amount"=>$fields["paylink_amount"],
                                "email"=>$fields["paylink_customer_email"],
                                "paylink_url"=>$paylink_link,
                                "business_name"=>$business_name,
                                "paylink_id"=>$paylink_payid
                            ),
                        );
                        Mail::to($fields["paylink_customer_email"])->send(new SendMail($data));    
                    }

                    if($fields["mobile_paylink"] == "Y")
                    {   
                        $message = ucfirst(Auth::guard('merchantemp')->user()->name)." has requesting payment for INR ".$fields["paylink_amount"]." You can pay through this link ".$paylink_link." -NeoFin";
            
                        $sms = new SmsController($message,$fields["paylink_customer_mobile"],"1307164802052353612");
                
                        $sms->sendMessage();   
                    }

                    echo json_encode(array("status"=>TRUE,"message"=>"Paylink added successfully"));
                    
                }else{
                    echo json_encode(array("status"=>FALSE,"message"=>"Unable to add Paylink"));
                }
            }
            
        }
       
    }

    public function edit_paylink(Request $request,$id)
    {
        if($request->ajax()){

            $paylink  = new Paylink();
            $paylink_edit = $paylink->edit_paylink($id);
            echo json_encode($paylink_edit);
        }
        
    }

    public function update_paylink(Request $request)
    {
        if($request->ajax())
        {
            $validator = Validator::make($request->all(),
            [
                'paylink_amount'=>'required|numeric',
                'paylink_for'=>'required',
            ]);

            if($validator->fails())
            {
                echo json_encode(["status"=>FALSE,"errors"=>$validator->errors()]);
                
            }else{

                $paylink = new Paylink();
                $update_array = $request->only('id');
                $fields = $request->except('_token','id');
        
                $update_status = $paylink->update_paylink($fields,$update_array);
            
                if($update_status)
                {
                    echo json_encode(array("status"=>TRUE,"message"=>"Paylink updated successfully"));
                    
                }else{
                    echo json_encode(array("status"=>TRUE,"message"=>"Nothing has changed to update paylink"));
                }
            }
            
        }
    }

    public function get_quick_paylink(Request $request,$perPage){

        if($request->ajax()){


            $empId = Auth::guard('merchantemp')->user()->id;
            $merchantId = Auth::guard('merchantemp')->user()->created_merchant;
            $paylink = new Paylink();
            $quick_links = $paylink->get_all_quicklinks($merchantId,$empId);
            $request->session()->forget('quicklinks-search');
            $paylinks_page = $this->_arrayPaginator($quick_links,$request,"quicklink",$perPage);
            return View::make(".merchantemp.pagination")->with(["quicklinks"=>$paylinks_page,"module"=>"quicklink"])->render();
        }
    }

    public function store_quicklink(Request $request){

        if($request->ajax())
        {
            $validate = Validator::make($request->all(), [
                'paylink_amount'=>'required|numeric|regex:/^[1-9][0-9]*$/',
                'paylink_for'=>'required'
            ]);
               
            if($validate->fails()){

                echo json_encode(["status"=>FALSE,"errors"=>$validate->errors()]);

            }else{


                $empId = Auth::guard('merchantemp')->user()->id;
                $merchantId = Auth::guard('merchantemp')->user()->created_merchant;

                $paylink = new Paylink();
                $paylink_payid = Str::random(6);
                $paylink_link = "";

                $paylink_link = url('/')."/p/s-p/".$paylink_payid;


                $fields = $request->except('_token');
                $fields["paylink_gid"]   = "plnk_".Str::random(16);
                $fields["paylink_expiry"] = date('Y-m-d H:i:s',strtotime($this->datetime.'+ 1 days'));
                $fields["paylink_type"]  = "quick";
                $fields["paylink_payid"] = $paylink_payid;
                $fields["paylink_link"]  = $paylink_link;
                $fields["created_date"]  = $this->datetime;
                $fields["created_merchant"] = $merchantId;
                $fields["created_employee"] = $empId;

                $insert_status = $paylink->add_paylink($fields);
            
                
                if($insert_status)
                {
                    echo json_encode(array("status"=>TRUE,"message"=>"Quick paylink added successfully"));
                    
                }else{
                    echo json_encode(array("status"=>FALSE,"message"=>"Unable to add Paylink"));
                }
            }

            
        }
       
    }

    public function show_merchatemp_logactivity(Request $request){

        return View::make(".merchantemp.loginactivity");        
    }

    public function merchatemp_logactivity(Request $request,$perPage){

        if($request->ajax()){

            $this->empId = Auth::guard('merchantemp')->user()->id;
            $customObject = new Custom();
            $merchantemp = $customObject->get_merchantemp_log($this->empId);
            $request->session()->forget('merchantemp-log');
            $merchantemplog_page = $this->_arrayPaginator($merchantemp,$request,"merchantemp_log",$perPage);
            return View::make(".merchantemp.pagination")->with(["merchantemp_logs"=>$merchantemplog_page,"module"=>"merchantemp_log"])->render();
        }
        
    }

    public function merchant_pagination(Request $request,$module,$perpage)
    {

        $empId = Auth::guard('merchantemp')->user()->id;
        $merchantId = Auth::guard('merchantemp')->user()->created_merchant;

        switch ($module) {
        
        case 'transaction':
            
            $transaction = new Payment();
            $transactions = $transaction->get_emp_payments($merchantId,$empId);
            $trans_page = $this->_arrayPaginator($transactions,$request,"transaction",$perpage);
            return View::make(".merchantemp.pagination")->with(["transactions"=>$trans_page,"module"=>$module])->render();
            break;
        
        case 'paylink':

            $paylink = new Paylink();
            $paylinks = $paylink->get_emp_smtpaylinks($merchantId,$empId);
            $paylinks_page= $this->_arrayPaginator($paylinks,$request,"paylink",$perpage);
            return View::make(".merchantemp.pagination")->with(["paylinks"=>$paylinks_page,"module"=>$module])->render();
            break;
        
        case 'quicklink':

            $paylink = new Paylink();
            $quick_links = $paylink->get_all_quicklinks($merchantId,$empId);
            $paylinks_page = $this->_arrayPaginator($quick_links,$request,"quicklink",$perpage);
            return View::make(".merchantemp.pagination")->with(["quicklinks"=>$paylinks_page,"module"=>"quicklink"])->render();
            break;

        case 'merchantemp_log':
            $customObject = new Custom();
            $merchantemp = $customObject->get_merchantemp_log($empId);
            $request->session()->forget('merchantemp-log');
            $merchantemplog_page = $this->_arrayPaginator($merchantemp,$request,"merchantemp_log",$perpage);
            return View::make(".merchantemp.pagination")->with(["merchantemp_logs"=>$merchantemplog_page,"module"=>$module])->render();
            break;
        
        default:
                
            break;
        }
    }

    public function merchant_search(Request $request,$module,$search_value,$perpage=10){
        
        $searched_array = array();
        
        $empId = Auth::guard('merchantemp')->user()->id;
        $merchantId = Auth::guard('merchantemp')->user()->created_merchant;


        switch ($module) {
        
            case 'transaction':
                
                if($request->session()->has('payments-search'))
                {
                    $searched_array = $this->_search_algorithm($request->session()->get('payments-search'),$search_value);
                    $trans_page = $this->_arrayPaginator($searched_array,$request,"transaction",$perpage);
                
                }else{

                    $transaction = new Payment();
                    $transactions = $transaction->get_emp_payments($merchantId,$empId);
                    session(['payments-search'=>$transactions]);
                    $searched_array = $this->_search_algorithm($request->session()->get('payments-search'),$search_value);
                    $trans_page = $this->_arrayPaginator($searched_array,$request,"transaction",$perpage);
                }

                return View::make(".merchantemp.pagination")->with(["transactions"=>$trans_page,"module"=>$module])->render();
                break;
    
            
            case 'paylink':
                
                if($request->session()->has('paylinks-search'))
                {

                    $searched_array = $this->_search_algorithm($request->session()->get('paylinks-search'),$search_value);
                    $paylinks_page= $this->_arrayPaginator($searched_array,$request,"paylink",$perpage);
                
                }else{

                    $paylink = new Paylink();
                    $paylinks = $paylink->get_emp_smtpaylinks($merchantId,$empId);
                    session(['paylinks-search'=>$paylinks]);
                    $searched_array = $this->_search_algorithm($request->session()->get('paylinks-search'),$search_value);
                    $paylinks_page= $this->_arrayPaginator($searched_array,$request,"paylink",$perpage);
                }
                return View::make("merchantemp.pagination")->with(["paylinks"=>$paylinks_page,"module"=>$module])->render();
                break;

            case 'quicklink':

                if($request->session()->has('quicklinks-search'))
                {                    
                    $searched_array = $this->_search_algorithm($request->session()->get('quicklinks-search'),$search_value);
                    $paylinks_page = $this->_arrayPaginator($searched_array,$request,"quicklink",$perpage);
                
                }else{

                    $paylink = new Paylink();
                    $quick_links = $paylink->get_all_quicklinks($merchantId,$empId);
                    session(['quicklinks-search'=>$quick_links]);
                    $searched_array = $this->_search_algorithm($request->session()->get('quicklinks-search'),$search_value);
                    $paylinks_page = $this->_arrayPaginator($searched_array,$request,"quicklink",$perpage);
                }

                return View::make(".merchantemp.pagination")->with(["quicklinks"=>$paylinks_page,"module"=>"quicklink"])->render();
                break;
        
            default:
                    
                break;
            }
    }

}
