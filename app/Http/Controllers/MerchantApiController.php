<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Payment;
use App\Order;
use App\Refund;
use App\Dispute;
use App\PayoutContacts;
use App\PayoutBeneficiaries;
use Carbon\Carbon;
use App\PayoutTransaction;
use App\PayoutBeneficiaryGroup;
use App\PayoutApiKeys;
use App\State;
use App\PayoutAccount;
use App\PayoutWallet;
use App\AddFund;
use App\Payout;
use App\Merchant;

use DB;
use App\Exports\PayoutTransactionExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;




class MerchantApiController extends Controller
{

     protected $date_time;
       public function __construct()
    {
       
        $this->date_time = date("Y-m-d H:i:s");
       
    }
    public function addBeneficiary(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'client_id' => 'required|size:28',
            'secret_key' => 'required|size:40',
            'hash_key' => 'required|size:10',
            'signature' => 'required',
            'name' => 'required',
            'mobile' => 'required',
            'email' => 'required',
            'address' => 'required',
            'state' => 'required',
            'pincode' => 'required',
            'upi_id' => 'required|regex:/^[\w.-]+@[\w.-]+$/',
            'account_number' => 'required|min:9|max:18',
            'ifsc' => 'required|regex:/^[A-Z]{4}0[A-Z0-9]{6}$/',
        ]);

        if ($validate->fails()) {
            return response()->json(['status' => 'Failed', 'message' => $validate->errors()], 400);
        }

        $merchant = PayoutApiKeys::where('client_id', $request->client_id)->where('secret_key', $request->secret_key)->first();

        //Validate clientId SecretKey
        if ($merchant == null) {
            return response()->json(['status' => 'Failed', 'message' => 'Client Id or Secret Key is Invalid'], 400);
        }

        //End Validate clientId SecretKey

        $ipaddress = DB::table("merchant_payout_ipwhitelist")->where('merchant_id', $merchant->merchant_id)->where('ipwhitelist', $request->ip())->first();



        //validations
        if ($ipaddress == null) {
            return response()->json(['status' => 'Failed', 'message' => 'Ip Address is not whitelisted'], 400);
        }

        //check if user is set to active 
        $user = User::where('id', $merchant->merchant_id)->first();

        if ($user->merchant_status != 'active') {
            return response()->json(['status' => 'Failed', 'message' => 'Merchant Restricted'], 400);
        }
        //endcheckuser

        $message = $request->client_id . $request->secret_key;
        $hashkey = $request->hash_key;
        // to lowercase hexits
        $signature = hash_hmac('sha256', $message, $hashkey);

        if ($signature == $request->signature) {



            try {

                $check_upi = PayoutBeneficiaries::where('merchant_id', $merchant->merchant_id)->where('upi_id', $request->upi_id)->first();
                $check_account_number = PayoutBeneficiaries::where('merchant_id', $merchant->merchant_id)->where('account_number', $request->account_number)->first();



                if ($check_upi != null) {
                    return response()->json(['status' => 'Failed', 'message' => 'Upi Id is already registered'], 400);
                }

                if ($check_account_number != null) {
                    return response()->json(['status' => 'Failed', 'message' => 'Account Number is already registered'], 400);
                }
                //end validations

                $max_id = PayoutBeneficiaries::max('id');

                $beneficiary_id = "";
                if ($max_id === null) {
                    $beneficiary_id = 'BEN1001';
                } else {
                    $getmaxBenid = PayoutBeneficiaries::where('id', $max_id)->first();
                    // $createBenid = substr($max_id->beneficiary_id, 4);
                    preg_match_all('!\d+!', $getmaxBenid->beneficiary_id, $createBenid);
                    $converttonumber = (int)$createBenid[0][0];
                    $increment = $converttonumber + 1;
                    $beneficiary_id = "BEN" . $increment;
                }

                $addContacts = PayoutContacts::create([
                    "name" => $request->name,
                    "mobile" => $request->mobile,
                    "contact" => $request->email,
                    "address" => $request->address,
                    "state" => $request->state,
                    "pincode" => $request->pincode,
                    "merchant_id" => $merchant->merchant_id
                ]);


                //inserting beneficiary
                $insert = PayoutBeneficiaries::create([
                    "beneficiary_id" => $beneficiary_id,
                    "upi_id" => $request->upi_id,
                    "account_number" => $request->account_number,
                    "ifsc_code" => $request->ifsc,
                    "group_id" =>  null,
                    "contact_id" => $addContacts->id,
                    "merchant_id" => $merchant->merchant_id
                ]);
                return response()->json(['status' => 'Success', 'message' => 'Beneficiary created Successfully', 'beneficiary' => $insert], 200);
            } catch (\Throwable $e) {

                dd($e->getMessage());
            }
        } else {
            return response()->json(['status' => 'Failed', 'message' => 'Signature Doesnot Match'], 400);
        }
    }


    public function payoutTransferMoney(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'client_id' => 'required|size:28',
            'secret_key' => 'required|size:40',
            'hash_key' => 'required|size:10',
            'signature' => 'required',
            'beneficiary_id' => 'required',
            'amount' => 'required',
            'transferId' => 'required',
            'transferMode' => 'required',

        ]);

        if ($validate->fails()) {
            return response()->json(['status' => 'Failed', 'message' => $validate->errors()], 400);
        }

        $merchant = PayoutApiKeys::where('client_id', $request->client_id)->where('secret_key', $request->secret_key)->first();

        //Validate clientId SecretKey
        if ($merchant == null) {
            return response()->json(['status' => 'Failed', 'message' => 'Client Id or Secret Key is Invalid'], 400);
        }

        //End Validate clientId SecretKey

        $ipaddress = DB::table("merchant_payout_ipwhitelist")->where('merchant_id', $merchant->merchant_id)->where('ipwhitelist', $request->ip())->first();




        //validations
        if ($ipaddress == null) {
            return response()->json(['status' => 'Failed', 'message' => 'Ip Address is not whitelisted'], 400);
        }

        //check if user is set to active 
        $user = User::where('id', $merchant->merchant_id)->first();

        if ($user->merchant_status != 'active') {
            return response()->json(['status' => 'Failed', 'message' => 'Merchant Restricted'], 400);
        }
        //endcheckuser


        $message = $request->client_id . $request->secret_key;
        $hashkey = $request->hash_key;
        // to lowercase hexits
        $signature = hash_hmac('sha256', $message, $hashkey);


        if ($signature == $request->signature) {



            try {

                $beneficiaries = PayoutBeneficiaries::where('beneficiary_id', $request->beneficiary_id)->first();

                $contacts = PayoutContacts::where('id', $beneficiaries->contact_id)->first();

                $state = State::where('id', $contacts->state)->first();



                $beneDetails = new \stdClass();
                $beneDetails->beneId = $beneficiaries->beneficiary_id;
                $beneDetails->name = $contacts->name;
                $beneDetails->email = $contacts->contact;
                $beneDetails->phone = $contacts->mobile;
                $beneDetails->bankAccount = $beneficiaries->account_number;
                $beneDetails->ifsc = $beneficiaries->ifsc_code;
                $beneDetails->address1 = $contacts->address;
                $beneDetails->city =  $state->state_name;
                $beneDetails->state = $state->state_name;
                $beneDetails->pincode = $contacts->pincode;

                //generate order id
                $now = Carbon::now();
                $order_id = $now->format('YmdHisu');


                //Generate Token
                $clientid = "CF157153CBOAL8VCM6H5GVH11DO0";
                $clientsecret = "de1e416550780af45375dc3608b6ecf49fbc8e2c";
                $opts = array(
                    'http' =>
                    array(
                        'method'  => 'POST',
                        'header'  => array("Content-Type: application/json", "X-Client-Id:" . $clientid, "X-Client-Secret:" . $clientsecret),
                    )
                );
                $context  = stream_context_create($opts);
                $result_json = file_get_contents('https://payout-gamma.cashfree.com/payout/v1/authorize', false, $context);

                $result =  json_decode($result_json, true);

                $token = $result['data']['token'];


                //End

                //Verify token

                $opts = array(
                    'http' =>
                    array(
                        'method'  => 'POST',
                        'header'  => array("Content-Type: application/json", "Authorization:Bearer " . $token),
                    )
                );
                $context  = stream_context_create($opts);
                $result_json = file_get_contents('https://payout-gamma.cashfree.com/payout/v1/verifyToken', false, $context);
                $result =  json_decode($result_json, true);





                if ($result['status'] == "SUCCESS") {
                }

                //End

                //Send Money
                $postdata = new \stdClass();
                $postdata->amount = $request->amount;
                $postdata->transferId = $request->transferId;
                $postdata->transferMode = $request->transferMode;
                $postdata->beneDetails = $beneDetails;

                $postdata_json =  json_encode($postdata);



                $opts = array(
                    'http' =>
                    array(
                        'method'  => 'POST',
                        'header'  => array("Content-Type: application/json", "Authorization:Bearer " . $token),
                        'content' => $postdata_json
                    )
                );

                $context  = stream_context_create($opts);
                $result_json = file_get_contents('https://payout-gamma.cashfree.com/payout/v1/directTransfer', false, $context);
                $result =  json_decode($result_json, true);


                if ($result['status'] == "ERROR") {
                    return response()->json(['status' => 'Failed', 'data' => $result], 200);
                }
                //end Money 




                $insertTransaction = PayoutTransaction::create([
                    "reference_id" => $result['data']['referenceId'],
                    "merchant_id" => $user->id,
                    "utr" => $result['data']['utr'],
                    "transfer_id" => $postdata->transferId,
                    "ben_id" =>  $beneDetails->beneId,
                    "ben_name" =>  $beneDetails->name,
                    "ben_phone" => $beneDetails->phone,
                    "ben_email" => $beneDetails->email,
                    "ben_upi" => null,
                    "ben_card_no" => null,
                    "ben_ifsc" => $beneDetails->ifsc,
                    "ben_bank_acc" =>  $beneDetails->bankAccount,
                    "amount" =>  $postdata->amount,
                    "transfer_mode" => $postdata->transferMode,
                    "status" => $result['status'],
                    "remarks" => $request->remark,
                    "purpose" => null,
                    "transfer_desc" => null,
                    "vendor_charges" => null,
                    "goods_service_tax" => null,
                    "created_at" => Carbon::now(),
                    "transfer_type" => null
                ]);


                return response()->json(['status' => 'Success', 'data' => $result['data']], 200);
            } catch (\Throwable $e) {

                dd($e->getMessage());
            }
        } else {
            return response()->json(['status' => 'Failed', 'message' => 'Signature Doesnot Match'], 400);
        }
    }

    public function transactionStatus(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'client_id' => 'required|size:28',
            'secret_key' => 'required|size:40',
            'hash_key' => 'required|size:10',
            'signature' => 'required',

        ]);

        if ($validate->fails()) {
            return response()->json(['status' => 'Failed', 'message' => $validate->errors()], 400);
        }

        $merchant = PayoutApiKeys::where('client_id', $request->client_id)->where('secret_key', $request->secret_key)->first();


        //Validate clientId SecretKey
        if ($merchant == null) {
            return response()->json(['status' => 'Failed', 'message' => 'Client Id or Secret Key is Invalid'], 400);
        }

        //End Validate clientId SecretKey

        //validations
        $ipaddress = DB::table("merchant_payout_ipwhitelist")->where('merchant_id', $merchant->merchant_id)->where('ipwhitelist', $request->ip())->first();

        if ($ipaddress == null) {
            return response()->json(['status' => 'Failed', 'message' => 'Ip Address is not whitelisted'], 400);
        }

        //check if user is set to active 
        $user = User::where('id', $merchant->merchant_id)->first();

        if ($user->merchant_status != 'active') {
            return response()->json(['status' => 'Failed', 'message' => 'Merchant Restricted'], 400);
        }
        //endcheckuser


        $message = $request->client_id . $request->secret_key;
        $hashkey = $request->hash_key;
        // to lowercase hexits
        $signature = hash_hmac('sha256', $message, $hashkey);



        if ($signature == $request->signature) {


            try {
                $Transaction = PayoutTransaction::where('transfer_id', $request->transaction_id)->first();


                if ($Transaction == null) {
                    return response()->json(['status' => 'Failed', 'message' => 'Transaction Id doesnot Exist'], 400);
                } else {
                    return response()->json(['status' => 'Success', 'data' =>  $Transaction], 200);
                }
            } catch (\Throwable $e) {

                dd($e->getMessage());
            }
        } else {
            return response()->json(['status' => 'Failed', 'message' => 'Signature Doesnot Match'], 400);
        }
    }



    public function exportReport(Request $request)
    {


        $validate = Validator::make($request->all(), [
            'client_id' => 'required|size:28',
            'secret_key' => 'required|size:40',
            'hash_key' => 'required|size:10',
            'signature' => 'required',
            'from_date' => 'required|date',
            'to_date' => 'required|date',

        ]);

        if ($validate->fails()) {
            return response()->json(['status' => 'Failed', 'message' => $validate->errors()], 400);
        }

        $merchant = PayoutApiKeys::where('client_id', $request->client_id)->where('secret_key', $request->secret_key)->first();

        //Validate clientId SecretKey
        if ($merchant == null) {
            return response()->json(['status' => 'Failed', 'message' => 'Client Id or Secret Key is Invalid'], 400);
        }

        //End Validate clientId SecretKey

        $ipaddress = DB::table("merchant_payout_ipwhitelist")->where('merchant_id', $merchant->merchant_id)->where('ipwhitelist', $request->ip())->first();

        //validations
        if ($ipaddress == null) {
            return response()->json(['status' => 'Failed', 'message' => 'Ip Address is not whitelisted'], 400);
        }

        //check if user is set to active 
        $user = User::where('id', $merchant->merchant_id)->first();

        if ($user->merchant_status != 'active') {
            return response()->json(['status' => 'Failed', 'message' => 'Merchant Restricted'], 400);
        }
        //endcheckuser


        $message = $request->client_id . $request->secret_key;
        $hashkey = $request->hash_key;
        // to lowercase hexits
        $signature = hash_hmac('sha256', $message, $hashkey);


        if ($signature == $request->signature) {



            try {
                return Excel::download(new PayoutTransactionExport($request->from_date, $request->to_date, $merchant->id), 'Payflashtransactions.xlsx');
            } catch (\Throwable $e) {

                dd($e->getMessage());
            }
        } else {
            return response()->json(['status' => 'Failed', 'message' => 'Signature Doesnot Match'], 400);
        }
    }


    public function getSignature(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'client_id' => 'required|size:28',
            'secret_key' => 'required|size:40',
            'hash_key' => 'required|size:10',
        ]);

        if ($validate->fails()) {
            return response()->json(['status' => 'Failed', 'message' => $validate->errors()], 400);
        }

        $message = $request->client_id . $request->secret_key;
        $hashkey = $request->hash_key;
        // to lowercase hexits
        $signature = hash_hmac('sha256', $message, $hashkey);

        return response()->json(['status' => 'Success', 'signature' => $signature], 200);
    }


    public function getIpAddress(Request $request){

        return response()->json(['status' => 'Success', 'Ip' => $request->ip()], 200);
    }

    public function verifyAccount(Request $request){
         $merchantapi = DB::table("test_merchantapi")->where('api_secret', $request->api_secret)->where('api_key', $request->api_key)->first();

        $success=1;
        $res=[];
        $data=[]; 
        $merchant=null;
        if($merchantapi==null){
            $merchantapi = DB::table("live_merchantapi")->where('api_secret', $request->api_secret)->where('api_key', $request->api_key)->first();

            if ($merchantapi == null) {
               $success=0;
               $res=['status' => 'Failed', 'message' => 'Api key or Secret Key is Invalid'];
           
             }else{

            $merchant = Merchant::where('app_mode',1)->where('id',$merchantapi->created_merchant)->first();
        
           if($merchant == null) {
            $success=0;
            $res=['status' => 'Failed', 'message' => 'Merchant is in test mode, please pass test account api_secret and api_key'];
            
           } 
           } 
        }else{

         $merchant = Merchant::where('app_mode',0)->where('id',$merchantapi->created_merchant)->first();
        
          if($merchant == null) {
            $success=0;
            $res=['status' => 'Failed', 'message' => 'Merchant is in Live mode, please pass live account api_secret and api_key'];

           
         }  
          
        }


        if ($merchant == null && $merchantapi == null) {
            $success=0;
            $res=['status' => 'Failed', 'message' => 'Api key or Secret Key is Invalid'];
           
        }else{

        
        $ipaddress = DB::table("merchant_payout_ipwhitelist")->where('merchant_id', $merchant->id)->where('ipwhitelist', $request->ip())->first();
        //validations
        if ($ipaddress == null) {
            $success=0;
            $res=['status' => 'Failed', 'message' => 'Ip Address is not whitelisted'];
            
        }else{

        //check if user is set to active 
        // $merchant = User::where('id', $merchant_id)->first();

        if ($merchant->merchant_status != 'active') {
            $success=0;
            $res=['status' => 'Failed', 'message' => 'Merchant Restricted'];
            
        }
    }

    }

        $result=array(
            'success'=>$success,
            'res'=>$res,
            'data'=>$merchant,
        );

        return $result;
    }



    public function addItem(Request $request)
    {
        $validate = Validator::make($request->all(), [
           'api_key' => 'required|size:28',
            'api_secret' => 'required|size:16',
            "item_name"    => "required|array",
             "item_name.*"  => "required|string",
             "item_amount"  => "required|array",
            "item_amount.*"  => "required|string",
            "item_description"  => "required|array",
            "item_description.*"  => "required|string"
         ]);

        if ($validate->fails()) {
            return response()->json(['status' => 'Failed', 'message' => $validate->errors()], 400);
        }


       
          $response=$this->verifyAccount($request);
          if($response['success']){
            $merchant=$response['data'];
          }else{
             return response()->json($response['res'], 400);
          }
            

       
         $merchant_id=($merchant->id);
        //endcheckuser

            try {

                $item = new \App\Item($merchant->app_mode);
                $fields =  $request->only('item_name', 'item_amount','item_description');

                $itemsdata = array();
                foreach ($fields["item_name"] as $key => $value) {

                    $itemsdata[$key]["item_name"] = $fields["item_name"][$key];
                    $itemsdata[$key]["item_amount"] = $fields["item_amount"][$key];
                    $itemsdata[$key]["item_description"] = $fields["item_description"][$key];
                    $itemsdata[$key]["item_gid"] = "itm_" . Str::random(16);
                    $itemsdata[$key]["created_date"] = $this->date_time;
                    $itemsdata[$key]["created_merchant"] = $merchant_id;
                }

                
                $insert_status = $item->add_item($itemsdata);

                if ($insert_status) {
                     return response()->json(['status' => 'Success', 'message' => 'Item added successfully'], 200);

                } else {
                    return response()->json(['status' => 'Failed', 'message' => 'Unable to add item'], 400);
                    
                }
                
               
            } catch (\Throwable $e) {

                dd($e->getMessage());
            }
        }



        public function addCustomer(Request $request)
    {
        $validate = Validator::make($request->all(), [
           'api_key' => 'required|size:28',
            'api_secret' => 'required|size:16',
             "customer_name" => "required|string|regex:/^[a-zA-Z ]+$/u",
            "customer_email" => "required|email",
            "customer_phone" => "required|digits:10|numeric",
            "customer_gstno" => "required|string"
         ]);

        if ($validate->fails()) {
            return response()->json(['status' => 'Failed', 'message' => $validate->errors()], 400);
        }


       
          $response=$this->verifyAccount($request);
          if($response['success']){
            $merchant=$response['data'];
          }else{
             return response()->json($response['res'], 400);
          }
            

       
         $merchant_id=($merchant->id);
        //endcheckuser

            try {

               
                $customer = new \App\Customer($merchant->app_mode);
                $customer_details = $request->only('customer_email', 'customer_phone', 'customer_gstno');

                $existing_customer = $customer->get_customer_by_fields($customer_details,$merchant_id);

                if ($existing_customer[0]->customer_count == 0) {

                    $customer_data = $request->except('_token','api_key','api_secret');
                   
                    $customer_data["customer_gid"] = 'cust_' . Str::random(16);
                    $customer_data["created_merchant"] = $merchant_id;
                    $customer_data["created_date"] =  $this->date_time;

                    $customer_status = $customer->add_customer($customer_data);

                 if ($customer_status) {
                     return response()->json(['status' => 'Success', 'message' => 'Customer added successfully'], 200);

                } else {
                    return response()->json(['status' => 'Failed', 'message' => 'Unable to add customer'], 400);
                    
                }
                    


                }else {
                     return response()->json(['status' => 'Failed', 'message' => 'Customer Already exists with these details'], 400);

                  
                }

                
                
               
            } catch (\Throwable $e) {

                dd($e->getMessage());
            }
        } 



   public function addProduct(Request $request)
    {
        $validate = Validator::make($request->all(), [
           'api_key' => 'required|size:28',
            'api_secret' => 'required|size:16',
             "product_title" => "required|regex:/^[a-zA-Z ]+$/u",
        "product_price" => "required|numeric",
         ],[
            "product_title.regex" => "Product name doesn't allow special characters"
         ]);

        if ($validate->fails()) {
            return response()->json(['status' => 'Failed', 'message' => $validate->errors()], 400);
        }


       
          $response=$this->verifyAccount($request);
          if($response['success']){
            $merchant=$response['data'];
          }else{
             return response()->json($response['res'], 400);
          }
            
        $merchant_id=($merchant->id);
        //endcheckuser

            try {

               
                $product = new \App\Product();
                $p_details = $request->only('product_title');

                $existing = $product->get_product_by_fields($p_details,$merchant_id);

                if ($existing[0]->count == 0) {

                $product_data = $request->except('_token','api_key','api_secret');
                $product_data["product_gid"] = 'prod_' . Str::random(16);
                $product_data["created_date"] =  $this->date_time;
                $product_data["created_merchant"] = $merchant_id;

                    $insert_status = $product->add_product($product_data);

                 if ($insert_status) {
                     return response()->json(['status' => 'Success', 'message' => 'Product added successfully'], 200);

                } else {
                    return response()->json(['status' => 'Failed', 'message' => 'Unable to add Product'], 400);
                    
                }
                    


                }else {
                     return response()->json(['status' => 'Failed', 'message' => 'Product Already exists with these name'], 400);

                  
                }
        
            } catch (\Throwable $e) {

                dd($e->getMessage());
            }
        }


    public function addPaylink(Request $request)
    {
        $validate = Validator::make($request->all(), [
           'api_key' => 'required|size:28',
            'api_secret' => 'required|size:16',
            'paylink_for' => 'required|regex:/^[a-zA-Z ]+$/u',
            
            "paylink_amount" => "required|numeric",
         ],[
            "paylink_for.regex" => "Paylink for doesn't allow special characters"
         ]);

        if ($validate->fails()) {
            return response()->json(['status' => 'Failed', 'message' => $validate->errors()], 400);
        }


       
          $response=$this->verifyAccount($request);
          if($response['success']){
            $merchant=$response['data'];
          }else{
             return response()->json($response['res'], 400);
          }
            
        $merchant_id=($merchant->id);
        //endcheckuser

            try {

               
               $paylink = new \App\Paylink($merchant->app_mode);
               $paylink_payid = Str::random(6);
                $paylink_link = "";

                if ($merchant->app_mode) {
                    $paylink_link = url('/') . "/p/s-p/" . $paylink_payid;
                } else {

                    $paylink_link = url('/') . "/t/p/s-p/" . $paylink_payid;
                }
               
                $fields = $request->except('_token','api_key','api_secret');

                $fields["paylink_gid"]   = "plnk_" . Str::random(16);
                $fields["paylink_payid"] = $paylink_payid;
                $fields["paylink_link"]  = $paylink_link;
                $fields["created_date"]  = $this->date_time;
                $fields["created_merchant"] = $merchant_id;

                $insert_status = $paylink->add_paylink($fields);    
                


                 if ($insert_status) {

                    if ($fields["mobile_paylink"] == "Y") {
                        $message = ucfirst($merchant->name) . " has requesting payment for INR " . $fields["paylink_amount"] . "\nYou can pay through this link " . $paylink_link;

                        $sms = new SmsController($message, $fields["paylink_customer_mobile"]);

                        $sms->sendMessage();
                    }
                     return response()->json(['status' => 'Success', 'message' => 'Paylink added successfully'], 200);

                } else {
                    return response()->json(['status' => 'Failed', 'message' => 'Unable to add Paylink'], 400);
                    
                }
                    


               
        
            } catch (\Throwable $e) {

                dd($e->getMessage());
            }
        } 



     public function addQuicklink(Request $request)
    {
        $validate = Validator::make($request->all(), [
           'api_key' => 'required|size:28',
            'api_secret' => 'required|size:16',
            'paylink_for' => 'required|regex:/^[a-zA-Z ]+$/u',
            
            "paylink_amount" => "required|numeric",
         ],[
            "paylink_for.regex" => "Purpose doesn't allow special characters"
         ]);

        if ($validate->fails()) {
            return response()->json(['status' => 'Failed', 'message' => $validate->errors()], 400);
        }


       
          $response=$this->verifyAccount($request);
          if($response['success']){
            $merchant=$response['data'];
          }else{
             return response()->json($response['res'], 400);
          }
            
        $merchant_id=($merchant->id);
        //endcheckuser

            try {

               
               $paylink = new \App\Paylink($merchant->app_mode);
               $paylink_payid = Str::random(6);
                $paylink_link = "";

                if ($merchant->app_mode) {
                    $paylink_link = url('/') . "/p/s-p/" . $paylink_payid;
                } else {

                    $paylink_link = url('/') . "/t/p/s-p/" . $paylink_payid;
                }
               
                $fields = $request->except('_token','api_key','api_secret');

                $fields["paylink_gid"]   = "plnk_" . Str::random(16);
                $fields["paylink_expiry"] = date('Y-m-d H:i:s', strtotime($this->date_time . '+ 1 days'));
                $fields["paylink_type"]  = "quick";
                $fields["paylink_payid"] = $paylink_payid;
                $fields["paylink_link"]  = $paylink_link;
                $fields["created_date"]  = $this->date_time;
                $fields["created_merchant"] = $merchant_id;
                $insert_status = $paylink->add_paylink($fields);  

                 if ($insert_status) {

                   
                     return response()->json(['status' => 'Success', 'message' => 'Paylink added successfully'], 200);

                } else {
                    return response()->json(['status' => 'Failed', 'message' => 'Unable to add Paylink'], 400);
                    
                }
                    


               
        
            } catch (\Throwable $e) {

                dd($e->getMessage());
            }
        }
    
}
