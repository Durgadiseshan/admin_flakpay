<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\GenerateLogs;
use App\Custom;
use App\MerchantVendorBank;
use App\MerchantBusiness;
use App\VendorBankInfo;

class AdjustmentController extends Controller
{

    public $datetime;

    public $date;

    private $get_bankid;

    private $bank_name;

    public function __construct(){
        $this->datetime = date('Y-m-d H:i:s');
        $this->date = date('Y-m-d');
    }


    public function __call($method, $args){
        return [];
    }

    // public function transactionType($object){

    //     switch ($object->transaction_mode) {
    //         case 'CC':

    //             $this->get_bankid = $merchantvendor_bank->get_merchantbank_id($object->created_merchant,"cc_card");
    //             $this->bank_name = $custom->get_adjustment_bank_name($this->get_bankid);
    //             break;

    //         case 'DC':
                
    //             $this->get_bankid = $merchantvendor_bank->get_merchantbank_id($object->created_merchant,"dc_card");
    //             $this->bank_name = $custom->get_adjustment_bank_name($this->get_bankid);
    //             break;

    //         case 'NB':
                
    //             $this->get_bankid = $merchantvendor_bank->get_merchantbank_id($object->created_merchant,"net");
    //             $this->bank_name = $custom->get_adjustment_bank_name($this->get_bankid); 
                
    //             break;

    //         case 'UPI':
                
    //             $this->get_bankid = $merchantvendor_bank->get_merchantbank_id($object->created_merchant,"upi");
    //             $this->bank_name = $custom->get_adjustment_bank_name($this->get_bankid); 
    //             break;

    //         default: 
    //             break;

    //     }
    // }

    public function Atom($get_bankid,$object){


        $merchantvendor_bank = new MerchantVendorBank();
        $merchantBusiness = new MerchantBusiness();
        $vendorBankInfo = new VendorBankInfo();
        
        $transaction_adjustment_responses = [];
        $vendor_settlement_response = [];
        $get_categoryid = $merchantBusiness->get_category_id($object->created_merchant);
        $bank_details = $vendorBankInfo->get_vendor_bank_detail($get_categoryid,$get_bankid);
        $transaction_adjustment_responses = $this->atom_adjustment($bank_details,$object);
        if(!empty($transaction_adjustment_responses))
        {
            foreach ($transaction_adjustment_responses as $index => $transaction_adjustment_response) {
                $json_result = $this->xmltojson($transaction_adjustment_response["result"]);
                if($json_result["VERIFIED"] == "SUCCESS"){
                    $vendor_settlement_response = [
                        "merchant_id"  => $object->created_merchant,
                        "merchant_traxn_id"  => $json_result["MerchantTxnID"],
                        "amount"  => $json_result["AMT"],
                        "verified"  => $json_result["VERIFIED"],
                        "bank_id"  => $json_result["BID"],
                        "bankname"  => $json_result["bankname"],
                        "vendor_traxn_id"  => $json_result["atomtxnId"],
                        "descriminator"  => $json_result["discriminator"],
                        "surcharge"  => $json_result["surcharge"],
                        "card_number"  => $json_result["CardNumber"],
                        "traxn_date"  => $json_result["TxnDate"],
                        "recon_status"  => $json_result["ReconStatus"],
                        "settlement_amount"  => $json_result["SettlementAmount"],
                        "settlement_date"  => ($json_result["SettlementDate"]=="NA")?$this->datetime:$json_result["SettlementDate"],
                        "vendor_from" => $transaction_adjustment_response["bank"],
                        "transaction_type"=>$object->transaction_type,
                        "created_date" => $this->datetime,
                        "created_user" => auth()->guard('employee')->user()->id
                    ];
                }
            }
        }
        return $vendor_settlement_response;
    }

    public function EaseBuzz($get_bankid,$object){
        $transaction_adjustment_responses = [];
        $vendor_settlement_response = [];
        return $vendor_settlement_response;
    }

    public function CashFree($get_bankid,$object){

        $custom = new Custom();

        $transaction_adjustment_responses = [];
        $vendor_settlement_response = [];
        $bank_details = $custom->get_cashfree_keys($object->created_merchant);
        $transaction_adjustment_responses = $this->cashfree_adjustment($bank_details,$object);
        $cashfree_response = json_decode($transaction_adjustment_responses[0]["result"],true);
        foreach ($cashfree_response["settlements"] as $key => $value) {
            print_r($value);
        }
        return $vendor_settlement_response;
    }

    public function atom_adjustment($bank_details,$object){

        $adjustment_url = "";
        $adjustment_params = [];
        $adjustment_response = [];
        if(!empty($bank_details))
        {   foreach ($bank_details as $index => $bank_detail) {
                $adjustment_url = $bank_detail->vendor_adjustment_url;
                $adjustment_params["merchantid"] = $bank_detail->vendor_secure_key;
                $adjustment_params["merchanttxnid"] = $object->transaction_gid;
                $adjustment_params["amt"] = $object->transaction_amount;
                $adjustment_params["tdate"] = $object->transaction_date;
                $adjustment_params["atomtxnid"] = $object->vendor_transaction_id;
                $adjustment_response[$index]["bank"] = $bank_detail->vendor_name;
                $adjustment_response[$index]["result"] = $this->request_vendor_adjustment($adjustment_url,$adjustment_params);
            }    
                
        }

        return $adjustment_response;
    }

    public function cashfree_adjustment($bank_details,$object){

        $adjustment_url = "https://api.cashfree.com/api/v1/settlements";
        $adjustment_params = [];
        $adjustment_response = [];
        if(!empty($bank_details))
        {   foreach ($bank_details as $index => $bank_detail) {
                $adjustment_params["appId"] = "93678cba3744497a6850fb3ad87639";
                $adjustment_params["secretKey"] = "3d78ef63e07e1f583ad7793f2586e9d2023d1df2";
                $adjustment_params["startDate"] = $object->transaction_date;
                $adjustment_params["endDate"] = $this->date;
                $adjustment_response[$index]["result"] = $this->request_vendor_adjustment($adjustment_url,$adjustment_params);
            }    
                
        }

        return $adjustment_response;
    }

    public function request_vendor_adjustment($adjustment_url,$adjustment_params){

        $url=$adjustment_url."?";

        $postVars = '';
        foreach($adjustment_params as $key=>$value) {
            $postVars .= $key . "=" . $value . "&";
        }
        
        GenerateLogs::atom_adjustment_url($url,$postVars);

        // init the resource
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postVars
            //,CURLOPT_FOLLOWLOCATION => true
        ));
        
        
        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        
        //get response
        $output = curl_exec($ch);
        
        //Print error if any
        if(curl_errno($ch))
        {
            echo curl_error($ch);
        }
        
        curl_close($ch);
        
        return $output;
    }

    public function xmltojson($xml_response){
    
        $response = simplexml_load_string($xml_response);

        // Convert into json 
        $json = json_encode($response); 
        
        // Convert into associative array 
        $json_response = json_decode($json, true)["@attributes"];

        return $json_response;
    }

}
