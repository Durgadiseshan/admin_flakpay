<?php

namespace App\Http\Controllers;
use Session;
use PDF;
use Config;
use \NumberFormatter;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use DB;
use Auth;

class InvoiceController extends Controller
{
  

    public function recipt(Request $request,$invoiceid) 
    { 
       
         $settlement = \App\Settlement::
        select(
                "id" ,
                "settlement_receiptno",
                "created_merchant",
                DB::raw("(sum(settlement_fee)) as total_fee"),
                DB::raw("(sum(settlement_tax)) as total_tax"),
                DB::raw("(DATE_FORMAT(settlement_date, '%d-%m-%Y')) as my_date")
                            )
        ->where('settlement_receiptno',$invoiceid)
        ->groupBy(DB::raw("DATE_FORMAT(settlement_date, '%d-%m-%Y')"))
        ->first();


        if($settlement){

        $invoiceId=$settlement['settlement_receiptno'];
        $deatil=new \App\MerchantBusiness();
        $merchant_details= $deatil->get_merchant_business_details($settlement['created_merchant']);   
           
        $data['page_title']='GST Invoice';
         $data['payflash_img']=\App\Classes\InvoiceImage::logo();
        $data['payflash_sign']=\App\Classes\InvoiceImage::sign();

        $data['settlement']=$settlement;
        $data['merchant_details']=$merchant_details[0];
        $transactions=[];
        $html= view('invoice.merchant.recipt', compact('data'));

         

        // return $html;
        $options = new Options();

        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        

        // Load HTML content
        $dompdf->loadHtml($html,'UTF-8');
   
        // Output the generated PDF (1 = download and 0 = preview) 
       $dompdf->setPaper('A4', 'portrait');/*landscape or portrait*/
        
        // Render the HTML as PDF
        $dompdf->render();
        
        // Output the generated PDF (1 = download and 0 = preview)
        $dompdf->stream("invoice-".$invoiceId, array("Attachment"=>0));

    }else{
        return redirect('/invoice');
    }
    } 

	public function demo() 
    { 
       
       
    	$data['page_title']='Demo pdf';
    	$transactions=[];
    	$html= view('invoice.merchant.demo', compact('data'));

         


        $options = new Options();

        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        

        // Load HTML content
        $dompdf->loadHtml($html,'UTF-8');
   
        // Output the generated PDF (1 = download and 0 = preview) 
       $dompdf->setPaper('A4', 'portrait');/*landscape or portrait*/
        
        // Render the HTML as PDF
        $dompdf->render();
        
        // Output the generated PDF (1 = download and 0 = preview)
        $dompdf->stream("welcome-".date('M')."_".date('d')."_".date('Y'), array("Attachment"=>0));
    } 

    

}