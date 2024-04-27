<?php
namespace app\Packages\Cashfree;
class CfPayout
{
    protected $token;
    protected $baseUrl;
   
    public function __construct($authParams) {
        if(!empty($authParams))
        {
            $clientId = $authParams["clientId"];
            $clientSecret = $authParams["clientSecret"];
            $stage = $authParams["stage"];
            if ($stage == "PROD") {
                $this->baseUrl = "https://payout-api.cashfree.com/payout";
            } else {
                $this->baseUrl = "https://payout-gamma.cashfree.com/payout";
            }

            $headers = [
             "X-Client-Id:" . $clientId,
             "X-Client-Secret:" . $clientSecret
            ];

            $endpoint = $this->baseUrl."/v1/authorize";      
            $curlResponse = $this->postCurl($endpoint, $headers);

            if ($curlResponse) {
               if ($curlResponse["status"] == "SUCCESS") {
                 $this->token = $curlResponse["data"]["token"];
               } else {
                  throw new \Exception("Authorization failed. Reason : ". $curlResponse["message"]);
               }
            }
         }
    }
    
    public function validateBank($accno,$ifsc) {
      $response = ["status" => "FAILED", "message" => "Authorization failed"];
      if ($this->token) {
          $request = "bankAccount=".$accno."&ifsc=".$ifsc;
        $endpoint = $this->baseUrl."/v1.2/validation/bankDetails?".$request;
        $authToken = $this->token;
        $headers = [
            "Authorization: Bearer $authToken"
            ]; 
        $curlResponse = $this->getCurl($endpoint, $headers);
        return $curlResponse;
      }
      return $response;
    }
    
    public function validateStatus($ref_id) {
      $response = ["status" => "FAILED", "message" => "Authorization failed"];
      if ($this->token) {
          $request = "bvRefId=".$ref_id;
        $endpoint = $this->baseUrl."/v1/getValidationStatus/bank?".$request;
        $authToken = $this->token;
        $headers = [
            "Authorization: Bearer $authToken"
        ]; 
        $curlResponse = $this->getCurl($endpoint, $headers);
        return $curlResponse;
      }
      return $response;
    }
    
    public function validateIfsc($ifsc) {
        $endpoint = $this->baseUrl."/v1/ifsc/".$ifsc;
        $authToken = $this->token;
        $headers = [
            "Authorization: Bearer $authToken"
        ];
        $curlResponse = $this->getCurl($endpoint, $headers);
        return $curlResponse;
    }
 
    protected function postCurl ($endpoint, $headers, $params = []) {
      $postFields = json_encode($params);
      array_push($headers,
         "Content-Type: application/json",
         "Content-Length:" . strlen($postFields)
      );

      $endpoint = $endpoint."?";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $endpoint);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_HTTPHEADER, array_values($headers));
      curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
      curl_setopt($ch, CURLOPT_TIMEOUT, 10);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $returnData = curl_exec($ch);
      curl_close($ch);
      if ($returnData != "") {
          return json_decode($returnData, true);
      }
      return NULL;
    }

    protected function getCurl ($endpoint, $headers) {
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $endpoint);
       curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       $returnData = curl_exec($ch);
       curl_close($ch);
       if ($returnData != "") {
           return json_decode($returnData, true);
       }
       return NULL;
    }

    function __destruct()
    {
      $this->token = NULL;
    }
}
?>