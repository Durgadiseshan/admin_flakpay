<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Custom;
use App\RyapayTransTrack;

class VendorTransTrack extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vendortranstrack:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command tracks neopay transactions status with vendor paymentgatways';

    protected $merchant_id = '197';

    protected $datetime;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->datetime = date('Y-m-d h:i:s');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $custom = new Custom();
        $transactions = $custom->get_all_pending_transactions();
        $vendor_transtracking_response = [];
        $rupayapay_adjustment = [];
        if(!empty($transactions))
        {
            foreach ($transactions as $key => $value) {

                $postData = array(
                    'merchantid' => $this->merchant_id,
                    'merchanttxnid' => $value->transaction_gid,
                    'amt' => number_format($value->transaction_amount,2),
                    'tdate' => $value->transaction_date,
                );
    
                $xml_response = $this->get_tracking_data($postData);
                
                $response = simplexml_load_string($xml_response);
    
                // Convert into json 
                $json = json_encode($response); 
                
                // Convert into associative array 
                $array_response = json_decode($json, true)["@attributes"];
                
                $vendro_settlement_response[$key] = [
                      "merchant_id"  => $array_response["MerchantID"],
                      "merchant_traxn_id"  => $array_response["MerchantTxnID"],
                      "amount"  => $array_response["AMT"],
                      "verified"  => $array_response["VERIFIED"],
                      "bank_id"  => $array_response["BID"],
                      "bankname"  => $array_response["bankname"],
                      "vendor_traxn_id"  => $array_response["atomtxnId"],
                      "descriminator"  => $array_response["discriminator"],
                      "surcharge"  => $array_response["surcharge"],
                      "card_number"  => $array_response["CardNumber"],
                      "udf9"  => $array_response["UDF9"],
                      "traxn_date"  => $array_response["TxnDate"],
                      "recon_status"  => $array_response["reconstatus"],
                      "sdt"  => $array_response["sdt"],
                      "vendor_from" => "atom",
                      "created_date" => $this->datetime,
                      "created_user" => "0"
                ];
                
                if($array_response["VERIFIED"] == "NO DATA")
                {
                    $rupayapay_transtracking[$key] = [
                        "merchant_id"  => $array_response["MerchantID"],
                        "merchant_traxn_id"  => $array_response["MerchantTxnID"],
                        "traxn_amount"  => $array_response["AMT"],
                        "trans_track_status"  => $array_response["VERIFIED"],
                        "bank_id"  => $array_response["BID"],
                        "bankname"  => $array_response["bankname"],
                        "vendor" => "atom",
                        "traxn_date"  => $array_response["TxnDate"],
                        "created_date" => $this->datetime,
                        "created_user" => "0"
                    ];
                }
    
            }
    
            $custom->add_vendor_tracking_resp($vendro_settlement_response);

            if(!empty($rupayapay_transtracking))
            {
                $trans_tracking = new RyapayTransTrack();
                $trans_tracking->add_trans_tracking($rupayapay_transtracking);
            }
        }
    }

    public function get_tracking_data($postData)
    {

        //Prepare post parameters
        $postVars = '';
        foreach($postData as $key=>$value) {
            $postVars .= $key . "=" . $value . "&";
        }

        //API URL
        $url="https://payment.atomtech.in/paynetz/vfts?";
        
        // init the resource
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postVars,
            // CURLOPT_CONNECTTIMEOUT =>3,
            // CURLOPT_TIMEOUT=>20
        ));
        

        //Ignore SSL certificate verification

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        //Debug Request

        //curl_setopt($ch, CURLOPT_VERBOSE, true);
        //curl_setopt($ch, CURLINFO_HEADER_OUT, true);

        //get response
        $output = curl_exec($ch);
        
        //Print error if any
        if(curl_errno($ch))
        {
            echo curl_error($ch);
        }

        $info = curl_getinfo($ch);

        curl_close($ch);
        
        return $output;

    }
}
