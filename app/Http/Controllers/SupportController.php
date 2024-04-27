<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Custom;
use App\CustomerCase;
use App\CaseComment;
use App\Http\Controllers\NotiMessController;


class SupportController extends Controller
{
    public $date_time;
    public $spt_type = [];

    public function __construct(){

        $this->date_time = date("Y-m-d H:i:s");
    }

    public function index(){

        $stype= $this->support_type();
       
        return view('/support/customersupport')->with(["stype"=>$stype,"loadcss"=>"contact","loadscript"=>"support"]);
    }


    public function support_type(){
            
            $support_type=\App\Classes\Helpers::support_type();


            return $support_type;

    }

    public function store_support(Request $request){

        $validator = Validator::make($request->all(),[
            "case_type"=>"required",
            "transaction_gid"=>"required",
            "transaction_amount"=>"required",
            "customer_name"=>"required",
            "customer_email"=>"required",
            "customer_mobile"=>"required",
        ]);

        if($validator->fails())
        {
            echo json_encode(array("status"=>FALSE,"errors"=>$validator->errors()));
            
        }else{
            
            $where_transaction = $request->only("transaction_gid","transaction_amount");
            $where_transaction["transaction_email"] = $request->only("customer_email");
            $where_transaction["transaction_contact"] = $request->only("customer_mobile");
            $where_transaction["transaction_status"] = 'success';

            $custom = new Custom("live_payment");
            $merchant_object = $custom->select_query(["transaction_gid","created_merchant"],$where_transaction);

        
            if(!empty($merchant_object))
            {

               $case_exist = CustomerCase::where("transaction_gid",$merchant_object->transaction_gid)->first();
               if(empty($case_exist))
               {    
                    $customer_case = new CustomerCase();

                    $customer_caseid = "case_".Str::random(21);
                    $merchant_caseid = "case_".Str::random(21);
                    $rupayapay_caseid = "case_".Str::random(21);

                    $case_details = $request->except('_token');
                    $case_details["case_gid"] = "case_".Str::random(16);
                    $case_details["customer_caseid"] = $customer_caseid;
                    $case_details["merchant_caseid"] = $merchant_caseid;
                    $case_details["rupayapay_caseid"] = $rupayapay_caseid;
                    $case_details["customer_url"] = url('/')."/support/case-status/customer/".$customer_caseid;
                    $case_details["merchant_url"] = url('/')."/merchant/case-status/merchant/".$merchant_caseid;
                    $case_details["rupayapay_url"] =url('/')."/rupayapay/case-status/rupayapay/".$rupayapay_caseid;
                    $case_details["created_date"] = $this->date_time;
                    $case_details["merchant_id"] = $merchant_object->created_merchant;
                    $insert_status = $customer_case->add_case($case_details);
                    if($insert_status)
                    {

                        $notimess = new NotiMessController();
                        $notimess->store_case_notification($merchant_object->created_merchant,$request);

                        $data = array(
                            "from" => env("MAIL_USERNAME", ""),
                            "subject" => "Case against transaction ".$merchant_object->transaction_gid,
                            "view" => "/maillayouts/customercase",
                            "htmldata" => array(
                                "name" => $case_details["customer_name"],
                                "transactiond_id" => $case_details["transaction_gid"],
                                "customer_url"=>$case_details["customer_url"]
                            ),
                        );
                        Mail::to($case_details["customer_email"])->send(new SendMail($data));
                        echo json_encode(array("status"=>TRUE,"message"=>"Your request has submitted"));
                    }else{
                        echo json_encode(array("status"=>FALSE,"message"=>"Unable to process your request"));
                    }
               }else{
                echo json_encode(array("status"=>FALSE,"message"=>"Your requrest already submitted"));
               }

            }else{

                echo json_encode(array("status"=>FALSE,"message"=>"No Transaction has done with this details"));
            }
        }

    }

    public function case_details(Request $request,$caseid){

        $custcaseObject = new CustomerCase();
        $case_details = $custcaseObject->get_custcase_customer($caseid);

        if(!empty($case_details[0]->id))
        {   
            $this->spt_type = $this->support_type();
            return view('.support.customercase')->with(["case_status"=>$case_details[0]]);
        }else{
            return redirect()->route('support');
            
        }
    }

    public function get_comment(Request $request,$caseid)
    {
        if($request->ajax())
        {
            $case_comment = new CaseComment();
            $case_comments = $case_comment->get_comment($caseid);

            echo json_encode($case_comments);
        }
    }


    public function customer_comment(Request $request){
        if($request->ajax())
        {
            $case_comment = new CaseComment(); 
            $comment_data = $request->except("_token");
            $comment_data["commented_date"] = $this->date_time;
            $comment_data["user_type"] = 'customer';
            $insert_status = $case_comment->add_comment($comment_data);

            if($insert_status)
            {
                echo json_encode(array("status"=>TRUE,"message"=>"Your comment added successfully"));
            }else{
                echo json_encode(array("status"=>FALSE,"message"=>"Unable to add your comment"));
            }

        }
    }

    public function terms_condition(Request $request){
        return view('termscondition');
    }

    public function privacy_policies(Request $request){
        return view('privacypolicy');
    }

    public function merchant_service(Request $request){
        return view('mserviceagree');
    }
}
