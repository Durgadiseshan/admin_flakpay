<?php

namespace App\Classes;
use App\CfRefund;

use Illuminate\Http\Request;

class CashfreeConfig {
    public static $appId = "246259bf176c14135ec31a6eab952642";
    public static $secret = "f1e8fd2bcd66524a0cdf39d3bbebcbad8cded4bb";
    public static $apiVersion = "2022-01-01";

    public static $V1baseUrl = "https://api.cashfree.com/api/v1";
    public static $V2baseUrl = "https://api.cashfree.com/pg";
    public static $returnHost = "https://f63818bab708.ngrok.io";

}

class CashfreeApi
 {

     protected $clientid;
     protected $clientsecret;

      public function __construct(){
         $this->date_time = date("Y-m-d H:i:s");   
         $this->clientid = "CF157153CBOAL8VCM6H5GVH11DO0";
         $this->clientsecret = "de1e416550780af45375dc3608b6ecf49fbc8e2c";
      }

      public function guzz_get($base_url,$head){

        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $base_url, [
                    'headers' =>$head,
            ]);
          $apiResponse =   json_decode($response->getBody(), true);
          return array("code" => $response->getStatusCode(), "data" => $apiResponse);
          return $apiResponse;
      }


      public function guzz_post($base_url,$head,$data){

        $client = new \GuzzleHttp\Client();
        
       try {     
        $response = $client->request('POST', $base_url, [
                'body' => json_encode($data),
                'headers' => $head,
                'http_errors' => false

                ]);


          $apiResponse =   json_decode($response->getBody(), true);
         } catch (GuzzleHttp\Exception\ClientException $e) {
                    $response = $e->getResponse();
                    $apiResponse = $response->getBody()->getContents();
                }
          return array("code" => $response->getStatusCode(), "data" => $apiResponse);
          return $apiResponse;
      }


      public function doPost($url, $headers, $data){
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

        $resp = curl_exec($curl);
        if($resp === false){
            throw new \Exception("Unable to post to cashfree");
        }
        $info = curl_getinfo($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $responseJson = json_decode($resp, true);
        curl_close($curl);
        return array("code" => $httpCode, "data" => $responseJson);
    }


    public function quickdoPost($url, $headers, $data){
             $curl = curl_init();
           curl_setopt_array($curl, array(
           CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
     ));
     
        $resp = curl_exec($curl);
        if($resp === false){
            throw new \Exception("Unable to post to cashfree");
        }
        $info = curl_getinfo($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $responseJson = json_decode($resp, true);
        curl_close($curl);
        return array("code" => $httpCode, "data" => $responseJson);
    }

     public function doGet($url, $headers){
            $curl = curl_init($url);

            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $resp = curl_exec($curl);
            if($resp === false){
                throw new \Exception("Unable to get to cashfree");
            }
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $responseJson = json_decode($resp, true);
            curl_close($curl);
            return array("code" => $httpCode, "data" => $responseJson);
         }


      public  function demo()
      {
       echo CashfreeConfig::$V2baseUrl;
      }

       public  function get_order_info($order_id)
      {

       $get_data="/orders/".$order_id;
         $headers= [
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                    'x-api-version' => CashfreeConfig::$apiVersion,
                    'x-client-id' => CashfreeConfig::$appId,
                    'x-client-secret' => CashfreeConfig::$secret,
                ];

       $res= $this->guzz_get(CashfreeConfig::$V2baseUrl.$get_data,$headers);
       dd($res);

      }

      public  function get_order_status($order_id)
      {

         $data=array(
            'appId' => CashfreeConfig::$appId,
            'secretKey' => CashfreeConfig::$secret,
            'orderId' => $order_id
          );  
         $headers = array(
                "content-type: application/json"
            ); 
           $get_data="/order/info/status";  
       
        $res=$this->quickdoPost(CashfreeConfig::$V1baseUrl.$get_data, $headers, $data);
        dd($res);
        return $res;

      }

      public  function initiate_refund($data)
      {
        $body=[];
        $output=array('status'=>false,'message'=>"error");
        $order_id=$data['order_id'];
        $merchant_id=$data['merchant_id'];
        $user_id=$data['user_id'];
        $refund1 = new \App\Refund();

                


        $body=array(
             "refund_amount"=>$data['refund_amount'],
             "refund_id"=>$data['refund_id'],
             "refund_note"=>$data['refund_note']
            );

       $get_data="/orders/".$order_id."/refunds";
         $headers= [
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                    'x-api-version' => CashfreeConfig::$apiVersion,
                    'x-client-id' => CashfreeConfig::$appId,
                    'x-client-secret' => CashfreeConfig::$secret,
                ];

                
       $res= $this->guzz_post(CashfreeConfig::$V2baseUrl.$get_data,$headers,$data);

       if($res['code']==200){

                

            $output=array('status'=>true,'message'=>"Refund initiated successfully");
            $refund= new CfRefund();
            $refund['payflash_transaction_gid']=$order_id;
            $refund['merchant_id']=$merchant_id;
            $refund['payflash_payment_id']=$data['payment_id'];
            
            
            $refund['created_user']=$user_id;
            $result=$res['data'];
            $result['cf_created_at']=\Carbon\Carbon::parse($result['created_at'])->format('Y-m-d h:i:s') ;

            $result['refund_splits']=json_encode($result['refund_splits']);
            unset($result['created_at']);
           
           
            foreach ($result as $key => $value) {
                $refund[$key]=$value;
            }

            $refund->save();

            $refund1_data["refund_gid"] =  $data['refund_id'];
                $refund1_data["created_date"] =  $this->date_time;
                $refund1_data["created_merchant"] =$user_id;
                $refund1_data["payment_id"] = $data['payment_id'];
                $refund1_data["refund_amount"] = $data['refund_amount'];
                $refund1_data["refund_notes"] = $data['refund_note'];
                $refund1_data["refund_status"] = 'processing';

                $insert_status = $refund1->add_refund($refund1_data);

       }else{
            $result=$res['data'];
            $output = array_unique (array_merge ( $output,$result));
       }
       return $output;

      }

      public  function get_order_refunds($order_id)
      {

       $get_data="/orders/".$order_id."/refunds";
         $headers= [
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                    'x-api-version' => CashfreeConfig::$apiVersion,
                    'x-client-id' => CashfreeConfig::$appId,
                    'x-client-secret' => CashfreeConfig::$secret,
                ];


       $res= $this->guzz_get(CashfreeConfig::$V2baseUrl.$get_data,$headers);
       dd($res);

      }


      public  function get_order_settlements($order_id)
      {

        $settlement = new \App\PaymentSettlementResponse();
         
              

       $get_data="/orders/".$order_id."/settlements";
         $headers= [
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                    'x-api-version' => CashfreeConfig::$apiVersion,
                    'x-client-id' => CashfreeConfig::$appId,
                    'x-client-secret' => CashfreeConfig::$secret,
                ];


       $res= $this->guzz_get(CashfreeConfig::$V2baseUrl.$get_data,$headers);
       if($res['code']==200){
        $data=$res['data'];
        $settlementData=$settlement
                   ->where('payflash_transaction_gid',$order_id)
                   ->where('payment_id',$data['cf_payment_id'])
                   ->where('settlement_id',$data['cf_settlement_id'])
                   ->first();
        if($settlementData){
             $settlementData->transfer_utr=$data['transfer_utr'];
             $settlementData->save();
        }else{
            $settlement->payflash_transaction_gid=$order_id;
            $settlement->payment_id=$data['cf_payment_id'];
            $settlement->settlement_id=$data['cf_settlement_id'];
            $settlement->entity=$data['entity'];
            $settlement->order_id=$order_id;
            $settlement->order_amount=$data['order_amount'];
            $settlement->order_currency=$data['order_currency'];
            $settlement->service_charge=$data['service_charge'];
            $settlement->service_tax=$data['service_tax'];
             $settlement->settlement_amount=$data['settlement_amount'];
            $settlement->settlement_currency=$data['settlement_currency'];
            $settlement->transfer_id=$data['transfer_id'];
            $settlement->transfer_utr=$data['transfer_utr'];
            $settlement->payment_time= \Carbon\Carbon::parse($data['payment_time'])->format('Y-m-d h:i:s') ;
            $settlement->transfer_time= \Carbon\Carbon::parse($data['transfer_time'])->format('Y-m-d h:i:s') ;
            $settlement->save();

        }
        
       // 
       }
        
       dd($res);

      }



        public  function refund_api()
      {

         $client = new \GuzzleHttp\Client();
         $head= [
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                    'x-api-version' => '2022-01-01',
                    'x-client-id' => $this->clientid,
                    'x-client-secret' => $this->clientsecret,
                ];
              
          $response = $client->request('POST', 'https://payout-gamma.cashfree.com/payout/v1/authorize', [
                    'headers' =>$head,
            ]);
          $apiResponse =   json_decode($response->getBody(), true);



         
      
        
      
        $token = $apiResponse['data']['token'];

        $postdata = new \stdClass();
        $postdata->refund_amount =10;
        $postdata->refund_id = "refund_".rand(1000,5000);
        $postdata->refund_note = 'test';
       

        $postdata_json =  json_encode($postdata);

        $head= [
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                    'x-api-version' => '2022-01-01',
                    'x-client-id' => '93678cba3744497a6850fb3ad87639',
                    'x-client-secret' => '3d78ef63e07e1f583ad7793f2586e9d2023d1df2',
                ];
              
          $response = $client->request('POST', 'https://sandbox.cashfree.com/pg/orders/YBBpMRV7BcOAY6PSAe61ijiT/refunds', [
                    'headers' =>$head,
                    'content' => $postdata_json
            ]);
          $apiResponse =   json_decode($response->getBody(), true);


          dd($apiResponse);

        $opts = array(
            'http' =>
            array(
                'method'  => 'POST',
                'header'  => array("Content-Type: application/json", "Authorization:Bearer " . $token),
                'content' => $postdata_json
            )
        );

        $context  = stream_context_create($opts);
        $result_json = file_get_contents('https://sandbox.cashfree.com/pg/orders/YBBpMRV7BcOAY6PSAe61ijiT/refunds', false, $context);
        $result =  json_decode($result_json, true);
        dd($result);
      }

  }
    
?>