<?php

namespace App\Classes;

use Illuminate\Http\Request;

class ApiCalls
{

    protected $post_data;

    public function __construct($post_data){

        $this->post_data = $post_data;
    }


    public function get_settlement_data()
    {

        //Prepare post parameters
        $postVars = '';
        foreach($this->post_data as $key=>$value) {
            $postVars .= $key . "=" . $value . "&";
        }

        //API URL
        $url="https://psa.atomtech.in/paynetz/vsfts?";
        
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

?>