<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Custom;
use App\Classes\RupayapaySecureData;
use App\PaymentPage;
use App\User;

class DynamicLinkController extends Controller
{


    public $datetime;

    public function __construct()
    {
        $this->datetime = date('Y-m-d H:i:s');
    }
    
    public function test_smartpay(Request $request,$payid) 
    {
        $custome = new Custom();
        
        $payment_details = $custome->get_test_paylink_details($payid);

        
        if(!empty($payment_details[0]))
        {
            session(["merchant_id"=>$payment_details[0]->created_merchant,"paylink_amount"=>$payment_details[0]->paylink_amount]);//Using this for merchant id
            return view('.linklayouts.testsmartpay')->with(["pay_details"=>$payment_details[0],"module"=>"paylink","link_expired"=>FALSE,"load_paylink_styles"=>TRUE]);

        }else{

            return view('.linklayouts.testsmartpay')->with(["module"=>"paylink","link_expired"=>TRUE,"load_paylink_styles"=>TRUE]);
        }
       
    }

    private function _get_merchantkeys($app_mode,$merchant_id){


        if($app_mode == "test")
        {
            $custome = new Custom("test_merchantapi");
            $merchant_details = $custome->select_query(["id","api_key","api_secret","request_hashkey","request_salt_key","encryption_request_key","response_salt_key","encryption_response_key"]
            ,["created_merchant"=>$merchant_id]);

        }else{

            $custome = new Custom("live_merchantapi");
            $merchant_details = $custome->select_query(["id","api_key","api_secret","request_hashkey","request_salt_key","encryption_request_key","response_salt_key","encryption_response_key"]
            ,["created_merchant"=>$merchant_id]);
        }

        return $merchant_details;

    }

    public function test_invsmartpay(Request $request,$invpayid)
    {

        $invoice_data = [];
        $item_details = [];
        $item_keys = ["item_name","item_amount","item_quantity","item_total"];

        $custome = new Custom();
        
        $invoice_details = $custome->get_test_invoice_details($invpayid); 

        if(!empty($invoice_details))
        {   
            foreach ($invoice_details as $index => $data) {
                foreach ($data as $key => $value) {
                    if(in_array($key,$item_keys))
                    {
                        $item_details[$index][$key] = $value;
                    }else{
                        $invoice_data[$key] = $value;
                    }
                }
            }
            if($invoice_data['invoice_status'] == 'issued'){

                session(["merchant_id"=>$invoice_data['created_merchant']]);
                return view('.linklayouts.testinvoicepay')->with(["inv_details"=>$invoice_data,"module"=>"invoice","item_details"=>$item_details,"link_expired"=>FALSE]);
                
            }else{

                return view('.linklayouts.testinvoicepay')->with(["link_expired"=>TRUE,"module"=>"invoice","load_paylink_styles"=>TRUE,"inv_paid"=>TRUE]);
            }
            

        }else{

            return view('.linklayouts.testinvoicepay')->with(["link_expired"=>TRUE,"module"=>"invoice","load_paylink_styles"=>TRUE,"inv_paid"=>FALSE]);
        }
        
    }

    public function test_request_payment(Request $request)
    {

        $validator = Validator::make($request->all(),[
            "customer_email"=>"required",
            "customer_amount"=>"required|numeric|min:1|max:".session()->get("paylink_amount"),
            "customer_mobile"=>"required",
            "customer_username"=>"required"
        ],[
            "customer_amount.min"=>"Amount Should be atleast 1 rupee",
            "customer_amount.max"=>"Amount Should not exceed ".session()->get("paylink_amount"),
            "customer_username.required"=>"Usename field is required"
        ]);
    
        if($validator->fails())
        {
            return redirect()->back()->with("errors",$validator->errors());

        }else{

            $form_url = env('PROD_RUPAYAPAY_TEST'); 

            $paymentdetails = $request->except("_token");

            $merchant_details = $this->_get_merchantkeys($request->app_mode,session("merchant_id"));
            
            if(!empty($merchant_details))
            {
                
                $message = $merchant_details->api_key.$merchant_details->api_secret."INR".$request->customer_amount.$request->customer_email.$request->customer_mobile;

                $signature = hash_hmac('sha256',$message,$merchant_details->request_hashkey);

                $payment_details = [
                    "clientId"=>$merchant_details->api_key,
                    "clientSecret"=>$merchant_details->api_secret,
                    "txnCurr"=>"INR",
                    "amount"=>$request->customer_amount,
                    "emailId"=>$request->customer_email,
                    "prodId"=>"",
                    "mobileNumber"=>$request->customer_mobile,
                    "signature"=>$signature,
                    "username"=>$paymentdetails["customer_username"],
                    "transaction_response"=>$request->transaction_response,
                    "transaction_method_id"=>$request->transaction_method_id,
                    "created_employee"=>$request->created_employee
                ];
                                
                $securedata = new RupayapaySecureData();
                $jsonObject = json_encode($payment_details);
                $encryption = $securedata->encrypt($jsonObject,$merchant_details->request_salt_key,$merchant_details->encryption_request_key);
                
                session(["response_salt_key"=>$merchant_details->response_salt_key,"encryption_response_key"=>$merchant_details->encryption_response_key]);

                return view('.linklayouts.requestpay')->with(["form_url"=>$form_url,"merchant_details"=>$merchant_details,"encryption"=>$encryption]);

            }else{

                return redirect()->back()->with('no_api',"Contact your merchant");
            }
        }
        
    }

    public function live_request_payment(Request $request)
    {

        $validator = Validator::make($request->all(),[
            "customer_email"=>"required",
            "customer_amount"=>"required|numeric|min:1|max:".session()->get("paylink_amount"),
            "customer_mobile"=>"required",
            "customer_username"=>"required"
        ],[
            "customer_amount.min"=>"Amount Should be atleast 1 rupee",
            "customer_amount.max"=>"Amount Should not exceed ".session()->get("paylink_amount"),
            "customer_username.required"=>"Usename field is required"
        ]);
        
        if($validator->fails())
        {
            return redirect()->back()->with("errors",$validator->errors());

        }else{

            $form_url = env('PROD_RUPAYAPAY_LIVE'); 

            $paymentdetails = $request->except("_token");

            $merchant_details = $this->_get_merchantkeys($request->app_mode,session("merchant_id"));
            
            if(!empty($merchant_details))
            {
                
                $message = $merchant_details->api_key.$merchant_details->api_secret."INR".$request->customer_amount.$request->customer_email.$request->customer_mobile;

                $signature = hash_hmac('sha256',$message,$merchant_details->request_hashkey);

                $payment_details = [
                    "clientId"=>$merchant_details->api_key,
                    "clientSecret"=>$merchant_details->api_secret,
                    "txnCurr"=>"INR",
                    "amount"=>$request->customer_amount,
                    "emailId"=>$request->customer_email,
                    "prodId"=>"",
                    "mobileNumber"=>$request->customer_mobile,
                    "signature"=>$signature,
                    "username"=>$paymentdetails["customer_username"],
                    "transaction_response"=>$request->transaction_response,
                    "transaction_method_id"=>$request->transaction_method_id,
                    "created_employee"=>$request->created_employee
                ];
                
                $securedata = new RupayapaySecureData();
                $jsonObject = json_encode($payment_details);
                $encryption = $securedata->encrypt($jsonObject,$merchant_details->request_salt_key,$merchant_details->encryption_request_key);
                
                session(["response_salt_key"=>$merchant_details->response_salt_key,"encryption_response_key"=>$merchant_details->encryption_response_key]);

                return view('.linklayouts.requestpay')->with(["form_url"=>$form_url,"merchant_details"=>$merchant_details,"encryption"=>$encryption]);

            }else{

                return redirect()->back()->with('no_api',"Contact your merchant");
            }
        }
        
    }

    public function test_smartpay_response(Request $request){
            
            $securedata = new RupayapaySecureData();

            $decryption = $securedata->decrypt($request->secureData,$request->session()->get("response_salt_key"),$request->session()->get("encryption_response_key"));
            
            $response = json_decode($decryption,true);
            
            if($response["status"] == 200){

                $custom = new Custom();

                $where["id"] = $response["transaction_method_id"];

                
                if(session()->get("paylink_amount") == $response["amount"]){
                    $update_data = [
                        "paylink_status"=>"paid",
                        "paylink_customer_email"=>$response["emailId"],
                        "paylink_customer_mobile"=>$response["mobileNumber"]
                    ];
                }else{
                    $update_data = [
                        "paylink_status"=>"partially_paid",
                        "paylink_customer_email"=>$response["emailId"],
                        "paylink_customer_mobile"=>$response["mobileNumber"],
                        "paylink_partial_amount"=>$response["amount"]
                    ];
                }
                
                
                $update_status =  $custom->update_test_paylink_details($update_data,$where);

                return view('.linklayouts.paysuccess')->with(["load_paylink_styles"=>TRUE,"response"=>$response]);
                
            }else if($response["status"] == 400){
                
                $custom = new Custom();

                $where["id"] = $response["transaction_method_id"];

                $update_data = [
                    "paylink_status"=>"failed",
                    "paylink_customer_email"=>$response["emailId"],
                    "paylink_customer_mobile"=>$response["mobileNumber"]
                ];
                
                $update_status =  $custom->update_test_paylink_details($update_data,$where);

                return view('.linklayouts.paysuccess')->with(["load_paylink_styles"=>TRUE,"response"=>$response]);
            
            }else if($response["status"] == 402){

                $custom = new Custom();

                $where["id"] = $response["transaction_method_id"];

                $update_data = [
                    "paylink_status"=>"cancelled",
                    "paylink_customer_email"=>$response["emailId"],
                    "paylink_customer_mobile"=>$response["mobileNumber"]
                ];
                
                $update_status =  $custom->update_test_paylink_details($update_data,$where);

                return view('.linklayouts.paysuccess')->with(["load_paylink_styles"=>TRUE,"response"=>$response]);
            }


    }

    public function test_invsmartpay_response(Request $request){

        $securedata = new RupayapaySecureData();

        $decryption = $securedata->decrypt($request->secureData,$request->session()->get("response_salt_key"),$request->session()->get("encryption_response_key"));
        
        $response = json_decode($decryption,true);
        
        if($response["status"] == 200){

            $custom = new Custom();

            $where["id"] = $response["transaction_method_id"];

            $update_data = [
                "invoice_status"=>"paid", 
            ];
            
            $custom->update_test_invoice_details($update_data,$where);

            return view('.linklayouts.paysuccess')->with(["load_paylink_styles"=>TRUE,"response"=>$response]);
           
        }else if($response["status"] == 400){
                
            $custom = new Custom();

            $where["id"] = $response["transaction_method_id"];

            $update_data = [
                "invoice_status"=>"failed",
            ];
            
            $update_status =  $custom->update_test_invoice_details($update_data,$where);

            return view('.linklayouts.paysuccess')->with(["load_paylink_styles"=>TRUE,"response"=>$response]);
        
        }else if($response["status"] == 402){

            $custom = new Custom();

            $where["id"] = $response["transaction_method_id"];

            $update_data = [
                "invoice_status"=>"cancelled",
            ];
            
            $update_status =  $custom->update_test_invoice_details($update_data,$where);

            return view('.linklayouts.paysuccess')->with(["load_paylink_styles"=>TRUE,"response"=>$response]);

        }

    }

    public function live_smartpay(Request $request,$payid)
    {
        $custome = new Custom();
        
        $payment_details = $custome->get_live_paylink_details($payid); 


        if(!empty($payment_details))
        {
            session(["merchant_id"=>$payment_details[0]->created_merchant,"paylink_amount"=>$payment_details[0]->paylink_amount]);//Using this for merchant id
           
            return view('.linklayouts.livesmartpay')->with(["pay_details"=>$payment_details[0],"module"=>"paylink","link_expired"=>FALSE,"load_paylink_styles"=>TRUE]);

        }else{

            return view('.linklayouts.livesmartpay')->with(["module"=>"paylink","link_expired"=>TRUE,"load_paylink_styles"=>TRUE]);
        }
       
    }


    public function live_smartpay_response(Request $request){
            
        $securedata = new RupayapaySecureData();

        $decryption = $securedata->decrypt($request->secureData,$request->session()->get("response_salt_key"),$request->session()->get("encryption_response_key"));
       
        $response = json_decode($decryption,true);
        
        if($response["status"] == 200){

            $custom = new Custom();

            $where["id"] = $response["transaction_method_id"];

            $update_data = [
                "paylink_status"=>"paid",
                "paylink_customer_email"=>$response["emailId"],
                "paylink_customer_mobile"=>$response["mobileNumber"]
            ];
            
            $custom->update_live_paylink_details($update_data,$where);
            return view('.linklayouts.paysuccess')->with(["load_paylink_styles"=>TRUE,"response"=>$response]);
                
        }else if($response["status"] == 400){
            
            $custom = new Custom();

            $where["id"] = $response["transaction_method_id"];

            $update_data = [
                "paylink_status"=>"failed",
                "paylink_customer_email"=>$response["emailId"],
                "paylink_customer_mobile"=>$response["mobileNumber"]
            ];
            
            $update_status =  $custom->update_live_paylink_details($update_data,$where);

            return view('.linklayouts.payfailed')->with(["load_paylink_styles"=>TRUE,"response"=>$response]);
        
        }else if($response["status"] == 402){

            $custom = new Custom();

            $where["id"] = $response["transaction_method_id"];

            $update_data = [
                "paylink_status"=>"cancelled",
                "paylink_customer_email"=>$response["emailId"],
                "paylink_customer_mobile"=>$response["mobileNumber"]
            ];
            
            $update_status =  $custom->update_live_paylink_details($update_data,$where);

            return view('.linklayouts.payfailed')->with(["load_paylink_styles"=>TRUE,"response"=>$response]);
        }

    }

    public function live_invsmartpay(Request $request,$invpayid)
    {

        $invoice_data = [];
        $item_details = [];
        $item_keys = ["item_name","item_amount","item_quantity","item_total"];

        $custome = new Custom();
        
        $invoice_details = $custome->get_live_invoice_details($invpayid);

        if(!empty($invoice_details))
        {   
            foreach ($invoice_details as $index => $data) {
                foreach ($data as $key => $value) {
                    if(in_array($key,$item_keys))
                    {
                        $item_details[$index][$key] = $value;
                    }else{
                        $invoice_data[$key] = $value;
                    }
                }
            }
            if($invoice_data['invoice_status'] == 'issued')
            {
                session(["merchant_id"=>$invoice_data['created_merchant']]);
                return view('.linklayouts.liveinvoicepay')->with(["inv_details"=>$invoice_data,"module"=>"invoice","item_details"=>$item_details,"link_expired"=>FALSE]);
            }else{

                return view('.linklayouts.liveinvoicepay')->with(["link_expired"=>TRUE,"module"=>"invoice","load_paylink_styles"=>TRUE,"inv_paid"=>TRUE]); 
            }
            
        }else{

            return view('.linklayouts.liveinvoicepay')->with(["link_expired"=>TRUE,"module"=>"invoice","load_paylink_styles"=>TRUE,"inv_paid"=>FALSE]); 
        }
        
    }

    public function live_invsmartpay_response(Request $request){
        $securedata = new RupayapaySecureData();

        $decryption = $securedata->decrypt($request->secureData,$request->session()->get("response_salt_key"),$request->session()->get("encryption_response_key"));

        $response = json_decode($decryption,true);

        if($response["status"] == 200){

            $custom = new Custom();

            $where["id"] = $response["transaction_method_id"];

            $update_data = [
                "invoice_status"=>"paid",
            ];
            
            $custom->update_live_invoice_details($update_data,$where);

            return view('.linklayouts.paysuccess')->with(["load_paylink_styles"=>TRUE,"response"=>$response]);

        }else if($response["status"] == 400){
                
            $custom = new Custom();

            $where["id"] = $response["transaction_method_id"];

            $update_data = [
                "invoice_status"=>"failed",
            ];
            
            $update_status =  $custom->update_test_invoice_details($update_data,$where);

            return view('.linklayouts.payfailed')->with(["load_paylink_styles"=>TRUE,"response"=>$response]);
        
        }else if($response["status"] == 402){

            $custom = new Custom();

            $where["id"] = $response["transaction_method_id"];

            $update_data = [
                "invoice_status"=>"cancelled",
            ];
            
            $update_status =  $custom->update_test_invoice_details($update_data,$where);

            return view('.linklayouts.payfailed')->with(["load_paylink_styles"=>TRUE,"response"=>$response]);

        }

    }

    public function test_payment_pagelink(Request $request,$pageid){
        if(!empty($pageid)){

            $payment_pageObject = new Custom();
            $page_details = $payment_pageObject->get_test_page_detail($pageid);

            if(!empty($page_details))
            {
                $inputs = ['input_label','input_name','input_type','input_value','input_option'];
                $page_inputs = [];
                $page_detail = [];
                $page_load = "";
                foreach ($page_details as $index => $object) {
                    foreach ($object as $key => $value) {
                        if(in_array($key,$inputs)){
                            $page_inputs[$index][$key] = $value;
                        }else{
                            if($index == 0){
                                $page_detail[$key] = $value;
                                $page_load = $object->page_name;
                            }
                        }
                    }
                }

                $page_detail["page_inputs"] = $page_inputs;
                switch ($page_detail["page_name"]) {
                    case 'singleproductpage':
                        $loadcss = "single-product";
                        $loadscript = "single-product";
                        break;
                    case 'charitypage':
                        $loadcss = "charity";
                        $loadscript = "charity";
                        break;
                }

                $merchant_id = $page_detail["created_merchant"];

                session(["merchant_id"=>$merchant_id,"app_mode"=>"test"]);

                $response = [
                    "form"=>"active",
                    "loadcss"=>$loadcss,
                    "loadscript"=>$loadscript,
                    "page_details"=>$page_detail,
                    "page_response"=>"test-payment-pageresponse",
                    "app_mode"=>"test",
                    "merchant_gid"=>User::get_merchant_gid($merchant_id)

                ];

                return view("merchant.paymentpages.".$page_load)->with($response);
            }else{

                return view('.linklayouts.testsmartpay')->with(["module"=>"paylink","link_expired"=>TRUE,"load_paylink_styles"=>TRUE]);
            }

        }else{
            return redirect()->back();
        }
    }

    public function live_payment_pagelink(Request $request,$pageid){
        if(!empty($pageid)){

            $payment_pageObject = new Custom();
            $page_details = $payment_pageObject->get_live_page_detail($pageid);
            if(!empty($page_details)){

                $inputs = ['input_label','input_name','input_type','input_value','input_option','input_mandatory'];
                $page_inputs = [];
                $page_detail = [];
                $page_load = "";
                foreach ($page_details as $index => $object) {
                    foreach ($object as $key => $value) {
                        if(in_array($key,$inputs)){
                            $page_inputs[$index][$key] = $value;
                        }else{
                            if($index == 0){
                                $page_detail[$key] = $value;
                                $page_load = $object->page_name;
                            }
                        }
                    }
                }
                $page_detail["page_inputs"] = $page_inputs;
                switch ($page_detail["page_name"]) {
                    case 'singleproductpage':
                        $loadcss = "single-product";
                        $loadscript = "single-product";
                        break;
                    case 'charitypage':
                        $loadcss = "charity";
                        $loadscript = "charity";
                        break;
                }

                $merchant_id = $page_detail["created_merchant"];

                session(["merchant_id"=>$merchant_id,"app_mode"=>"live"]);

                $response = [
                    "form"=>"active",
                    "loadcss"=>$loadcss,
                    "loadscript"=>$loadscript,
                    "page_details"=>$page_detail,
                    "page_response"=>"payment-pageresponse",
                    "app_mode"=>"live",
                    "merchant_gid"=>User::get_merchant_gid($merchant_id)
                ];

                return view("merchant.paymentpages.".$page_load)->with($response);
                
            }else{
                return view('.linklayouts.testsmartpay')->with(["module"=>"paylink","link_expired"=>TRUE,"load_paylink_styles"=>TRUE]); 
            }
        
        }else{
            return redirect()->back();
        }
    }

    public function do_payment(Request $request){

        
        $page_id = $request->only("transaction_method_id");
        $app_mode = $request->session()->get('app_mode');

        $form_fields = $this->_get_mandatory_field($page_id,$app_mode);

        $messages = [
            "input_username.required"=>"Please enter valid name",
            "input_amount.required"=>"Please enter valid amount",
            "input_email.required"=>"Please enter valid email",
            "input_mobile.required"=>"Mobile no should be 10 digit in length",
            "input_amount.regex"=>"Please enter valid amount",
            "input_amount.min"=>"Entered amount souble be atleast 50 ₹",
            "input_mobile.regex"=>"Please enter valid mobile no",
            "input_mobile.min"=>"Mobile no should be 10 digit in length",
        ];

        $rules = [
            "input_username"=>"required",
            "input_email"=>"required|email",
            "input_amount"=>"required|numeric|regex:/^\d+(\.\d{1,2})?$/|min:50",
            "input_mobile"=>"required|regex:/^([0-9\s\-\+\(\)]*)$/|digits:10"
        ];


        if(!empty($form_fields["rules"])){
            $rules = array_merge($rules,$form_fields["rules"]);
            $messages = array_merge($messages,$form_fields["message"]);
        }

        $validator = Validator::make($request->all(),$rules,$messages);
        
        if($validator->fails())
        {
            return redirect()->back()->withInput($request->input())->withErrors($validator->errors()); 

        }else{

            $form_url = env('PROD_RUPAYAPAY_TEST');

            $page_url = $request->only("page_url");

            $request_data = $request->except("_token","page_url");

            $payment_pageObject = new Custom();

            $merchant_id = $request->session()->get('merchant_id');

            $merchant_details = $this->_get_merchantkeys($app_mode,$merchant_id);

            if(!empty($merchant_details))
            {
                
                $message = $merchant_details->api_key.$merchant_details->api_secret."INR".$request->input_amount.$request->input_email.$request->input_mobile;

                $signature = hash_hmac('sha256',$message,$merchant_details->request_hashkey);

                $payment_details = [
                    "clientId"=>$merchant_details->api_key,
                    "clientSecret"=>$merchant_details->api_secret,
                    "txnCurr"=>"INR",
                    "amount"=>$request->input_amount,
                    "emailId"=>$request->input_email,
                    "prodId"=>"",
                    "mobileNumber"=>$request->input_mobile,
                    "signature"=>$signature,
                    "username"=>$request->input_username,
                    "transaction_response"=>$request->transaction_response,
                    "transaction_method_id"=>$request->transaction_method_id,
                    "created_employee"=>$request->created_employee
                ];

                $securedata = new RupayapaySecureData();
                $jsonObject = json_encode($payment_details);
                $encryption = $securedata->encrypt($jsonObject,$merchant_details->request_salt_key,$merchant_details->encryption_request_key);
                
                session(["response_salt_key"=>$merchant_details->response_salt_key,"encryption_response_key"=>$merchant_details->encryption_response_key,"merchant_id"=>$merchant_id,"payment_detail"=>json_encode($request_data)]);

                return view('.linklayouts.requestpay')->with(["form_url"=>$form_url,"merchant_details"=>$merchant_details,"encryption"=>$encryption]);

            }else{

                return redirect()->back()->with('no_api',"Contact your merchant");
            }
            
        }
    }

    private function _get_mandatory_field($page_id,$page_mode){

        $payment_pageObject = new Custom();
        $form_validate_fields = [];
        $form_validate_message = [];
        $mandatory_fields = $payment_pageObject->get_mandatory_fields($page_mode,$page_id);
        foreach ($mandatory_fields as $key => $value) {
            $form_validate_fields[$value->input_label] = "required";
            $form_validate_message["$value->input_label.required"] = "Field should not be empty";
        }

        return ["rules"=>$form_validate_fields,"message"=>$form_validate_message];
        
    }

    public function test_payment_page_response(Request $request){

        $securedata = new RupayapaySecureData();

        $decryption = $securedata->decrypt($request->secureData,$request->session()->get("response_salt_key"),$request->session()->get("encryption_response_key"));

        $response = json_decode($decryption,true);

        if($response["status"] == 200){

            $custom = new Custom();

            $paymentpage_info = [
                "page_id"=>$response["transaction_method_id"],
                "transaction_id"=>$response["transactionId"],
                "order_id"=>$response["orderId"],
                "payment_page_email"=>$response["emailId"],
                "payment_page_mobile"=>$response["mobileNumber"],
                "payment_page_amount"=>number_format($response["amount"],2),
                "payment_page_detail"=>$request->session()->get("payment_detail"),
                "payment_page_status"=>"paid",
                "created_date"=>$this->datetime,
                "merchant_id"=>$request->session()->get("merchant_id")
            ];
           
            $custom->add_test_paymentpage_info($paymentpage_info);            
                
        }else if($response["status"] == 400){
            
            $custom = new Custom();

            $paymentpage_info = [
                "page_id"=>$response["transaction_method_id"],
                "transaction_id"=>$response["transactionId"],
                "order_id"=>$response["orderId"],
                "payment_page_email"=>$response["emailId"],
                "payment_page_mobile"=>$response["mobileNumber"],
                "payment_page_amount"=>number_format($response["amount"],2),
                "payment_page_detail"=>$request->session()->get("payment_detail"),
                "payment_page_status"=>"paid",
                "created_date"=>$this->datetime,
                "merchant_id"=>$request->session()->get("merchant_id")
            ];
           
            $custom->add_test_paymentpage_info($paymentpage_info);
        
        }else if($response["status"] == 402){

            $custom = new Custom();

            $paymentpage_info = [
                "page_id"=>$response["transaction_method_id"],
                "transaction_id"=>$response["transactionId"],
                "order_id"=>$response["orderId"],
                "payment_page_email"=>$response["emailId"],
                "payment_page_mobile"=>$response["mobileNumber"],
                "payment_page_amount"=>number_format($response["amount"],2),
                "payment_page_detail"=>$request->session()->get("payment_detail"),
                "payment_page_status"=>"paid",
                "created_date"=>$this->datetime,
                "merchant_id"=>$request->session()->get("merchant_id")
            ];
           
            $custom->add_test_paymentpage_info($paymentpage_info);
            
        }

        return view('.linklayouts.payfailed')->with(["load_paylink_styles"=>TRUE,"response"=>$response]);
    }

    public function live_payment_page_response(Request $request){

        $securedata = new RupayapaySecureData();

        $decryption = $securedata->decrypt($request->secureData,$request->session()->get("response_salt_key"),$request->session()->get("encryption_response_key"));

        $response = json_decode($decryption,true);

        if($response["status"] == 200){

            $custom = new Custom();

            $paymentpage_info = [
                "page_id"=>$response["transaction_method_id"],
                "transaction_id"=>$response["transactionId"],
                "order_id"=>$response["orderId"],
                "payment_page_email"=>$response["emailId"],
                "payment_page_mobile"=>$response["mobileNumber"],
                "payment_page_amount"=>number_format($response["amount"],2),
                "payment_page_detail"=>$request->session()->get("payment_detail"),
                "payment_page_status"=>"paid",
                "created_date"=>$this->datetime,
                "merchant_id"=>$request->session()->get("merchant_id")
            ];
           
            $custom->add_live_paymentpage_info($paymentpage_info);
                
        }else if($response["status"] == 400){
            
            $custom = new Custom();

            $paymentpage_info = [
                "page_id"=>$response["transaction_method_id"],
                "transaction_id"=>$response["transactionId"],
                "order_id"=>$response["orderId"],
                "payment_page_email"=>$response["emailId"],
                "payment_page_mobile"=>$response["mobileNumber"],
                "payment_page_amount"=>number_format($response["amount"],2),
                "payment_page_detail"=>$request->session()->get("payment_detail"),
                "payment_page_status"=>"paid",
                "created_date"=>$this->datetime,
                "merchant_id"=>$request->session()->get("merchant_id")
            ];
           
            $custom->add_live_paymentpage_info($paymentpage_info);
        
        }else if($response["status"] == 402){

            $custom = new Custom();

            $paymentpage_info = [
                "page_id"=>$response["transaction_method_id"],
                "transaction_id"=>$response["transactionId"],
                "order_id"=>$response["orderId"],
                "payment_page_email"=>$response["emailId"],
                "payment_page_mobile"=>$response["mobileNumber"],
                "payment_page_amount"=>number_format($response["amount"],2),
                "payment_page_detail"=>$request->session()->get("payment_detail"),
                "payment_page_status"=>"paid",
                "created_date"=>$this->datetime,
                "merchant_id"=>$request->session()->get("merchant_id")
            ];
           
            $custom->add_live_paymentpage_info($paymentpage_info);
        }

        return view('.linklayouts.paysuccess')->with(["load_paylink_styles"=>TRUE,"response"=>$response]);

    }
    
}
