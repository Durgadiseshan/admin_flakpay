<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Custom extends Model
{
    
    public $table;

    protected $jointable1;

    private $date;
 
    private $halfmonth; 

    public function __construct($table=""){ 
        $this->table = $table;
        $this->jointable1 = "merchant_business";
        $this->date = date('Y-m-d');
        $this->datetime = date('Y-m-d h:i:s');
        $this->halfmonth = date('Y-m-d',strtotime($this->date. '+14 days'));
        $this->yesterday = date('Y-m-d',strtotime($this->date. '-1 day'));
    }

    public function add_merchantemp_log($logdetails){
        return DB::table('merchantemp_login_activity')->insert($logdetails);
    }

    public function get_merchantemp_log($merchantempid){

        $where_condition = "log_merchantemp=:merchantemp";
        $apply_condition["merchantemp"] = $merchantempid;

        $query = "SELECT id, log_ipaddress, log_device, log_os, log_browser, DATE_FORMAT(log_time,'%d-%m-%Y %h:%i:%s %p') as log_time, log_merchantemp FROM merchantemp_login_activity WHERE $where_condition ORDER BY log_time DESC";
        return DB::select($query,$apply_condition);
    }

    public function select_query($select,$where){
        //DB::enableQueryLog();
        return DB::table($this->table)->select($select)->where($where)->first();
        //DB::getQueryLog();
    }

    public function get_a_column($value,$where){
        //DB::enableQueryLog();
        return DB::table($this->table)->where($where)->value($value);
        //DB::getQueryLog();
    }

    public function get_test_paylink_details($id){

        $where_condition = "test_paylink.paylink_payid=:id AND test_paylink.paylink_status<>'paid'
        AND (test_paylink.paylink_expiry IS NULL OR DATE_FORMAT(test_paylink.paylink_expiry,'%Y-%m-%d %h:%i:%s')>='$this->datetime')";
        $apply_condition["id"] = $id;

        $query = "SELECT test_paylink.id,paylink_amount,paylink_customer_email,paylink_customer_mobile
        ,paylink_expiry,paylink_for,test_paylink.created_merchant,test_paylink.paylink_partial,test_paylink.paylink_partial_amount,$this->jointable1.business_name,created_employee FROM test_paylink JOIN $this->jointable1 ON
        $this->jointable1.created_merchant = test_paylink.created_merchant WHERE";
        //DB::enableQueryLog();
        return DB::select($query." ".$where_condition,$apply_condition);
        //dd(DB::getQueryLog());
    }


    public function get_test_invoice_details($id){ 

        $where_condition = "test_invoice.invoice_payid=:id AND test_invoice.invoice_status IN('issued','paid')";
        $apply_condition["id"] = $id;

        $query = "SELECT test_invoice.id,invoice_gid,invoice_amount,test_invoice.customer_email,test_invoice.customer_phone
        ,invoice_expiry_date,test_invoice.created_merchant,DATE_FORMAT(test_invoice.invoice_issue_date,'%M %d,%Y') as invoice_issue_date,invoice_terms_cond,$this->jointable1.business_name,$this->jointable1.business_logo,test_customer.customer_name
        ,test_item.item_name,test_item.item_amount,test_invoice_item.item_quantity,test_invoice_item.item_total,
        test_invoice.invoice_subtotal,test_invoice.invoice_tax_amount,test_invoice.tax_applied,tax_applied,invoice_status
        FROM test_invoice 
        LEFT JOIN $this->jointable1 ON $this->jointable1.created_merchant = test_invoice.created_merchant 
        LEFT JOIN test_customer ON test_customer.id = test_invoice.invoice_billing_to
        LEFT JOIN test_invoice_item on test_invoice_item.invoice_id = test_invoice.id
        LEFT JOIN test_item on test_item.id = test_invoice_item.item_id WHERE";
        //DB::enableQueryLog();
        return DB::select($query." ".$where_condition,$apply_condition);
        //dd(DB::getQueryLog());
    }

    public function update_test_paylink_details($update,$id){

        return DB::table("test_paylink")->where($id)->update($update);
    }

    public function update_live_paylink_details($update,$id){

        return DB::table("live_paylink")->where($id)->update($update);
    }

    public function update_test_invoice_details($update,$id){
        return DB::table("test_invoice")->where($id)->update($update);
    }

    public function update_live_invoice_details($update,$id){
        return DB::table("live_invoice")->where($id)->update($update);
    }

    public function get_live_paylink_details($id){ 

        $where_condition = "live_paylink.paylink_payid=:id AND live_paylink.paylink_status<>'paid'
        AND (live_paylink.paylink_expiry IS NULL OR DATE_FORMAT(live_paylink.paylink_expiry,'%Y-%m-%d %h:%i:%s')>='$this->datetime')";
        $apply_condition["id"] = $id;

        $query = "SELECT live_paylink.id,paylink_amount,paylink_customer_email,paylink_customer_mobile
        ,paylink_expiry,paylink_for,live_paylink.created_merchant,$this->jointable1.business_name,created_employee FROM live_paylink JOIN $this->jointable1 ON
        $this->jointable1.created_merchant = live_paylink.created_merchant WHERE $where_condition";
        //DB::enableQueryLog();
        return DB::select($query,$apply_condition);
        //dd(DB::getQueryLog());
        
    }


    public function get_live_invoice_details($id){

        $where_condition = "live_invoice.invoice_payid=:id AND live_invoice.invoice_status IN('issued','paid')";
        $apply_condition["id"] = $id;

        $query = "SELECT live_invoice.id,invoice_gid,invoice_amount,live_invoice.customer_email,live_invoice.customer_phone
        ,invoice_expiry_date,live_invoice.created_merchant,DATE_FORMAT(live_invoice.invoice_issue_date,'%M %d,%Y') as invoice_issue_date,invoice_terms_cond,$this->jointable1.business_name,$this->jointable1.business_logo,live_customer.customer_name
        ,live_item.item_name,live_item.item_amount,live_invoice_item.item_quantity,live_invoice_item.item_total,
        live_invoice.invoice_subtotal,live_invoice.invoice_tax_amount,live_invoice.tax_applied,tax_applied,invoice_status
        FROM live_invoice 
        LEFT JOIN $this->jointable1 ON $this->jointable1.created_merchant = live_invoice.created_merchant 
        LEFT JOIN live_customer ON live_customer.id = live_invoice.invoice_billing_to
        LEFT JOIN live_invoice_item on live_invoice_item.invoice_id = live_invoice.id
        LEFT JOIN live_item on live_item.id = live_invoice_item.item_id WHERE";
        //DB::enableQueryLog();
        return DB::select($query." ".$where_condition,$apply_condition);
        dd(DB::getQueryLog());
    }

    public function get_all_test_paylinks_with_expiry($merchant_id){

        $query="SELECT id,paylink_payid,paylink_for,paylink_amount,paylink_customer_email,paylink_expiry,paylink_customer_mobile,paylink_payid,paylink_link FROM test_paylink WHERE created_merchant=$merchant_id AND paylink_type='smart' AND paylink_status='issued' AND DATE_FORMAT(paylink_expiry,'%Y-%m-%d') >= '$this->date' AND DATE_FORMAT(paylink_expiry,'%Y-%m-%d') <= '$this->halfmonth' AND paylink_customer_email!= '' AND paylink_customer_mobile != '' AND paylink_auto_reminder='Y' ORDER BY test_paylink.paylink_expiry DESC";

        return DB::select($query);
    }

    public function get_all_test_reminders_with_expiry($merchant_id){

        $query="SELECT reminder_days,reminder_for,send_email,send_sms FROM test_reminder WHERE created_merchant=$merchant_id AND reminder_for='plwed' ORDER BY reminder_days DESC";

        return DB::select($query);
    }

    public function get_all_live_paylinks_with_expiry($merchant_id){

        $query="SELECT id,paylink_payid,paylink_for,paylink_amount,paylink_customer_email,paylink_expiry,paylink_customer_mobile,paylink_payid,paylink_link FROM live_paylink WHERE created_merchant=$merchant_id AND paylink_type='smart' AND paylink_status='issued' AND DATE_FORMAT(paylink_expiry,'%Y-%m-%d') >= '$this->date' AND DATE_FORMAT(paylink_expiry,'%Y-%m-%d') <= '$this->halfmonth' AND paylink_customer_email!= '' AND paylink_customer_mobile != '' AND paylink_auto_reminder='Y' ORDER BY live_paylink.paylink_expiry DESC";

        return DB::select($query);
    }

    public function get_all_live_reminders_with_expiry($merchant_id){

        $query="SELECT reminder_days,reminder_for,send_email,send_sms FROM live_reminder WHERE created_merchant=$merchant_id AND reminder_for='plwed' ORDER BY reminder_days DESC";

        return DB::select($query);
    }

    public function get_all_test_paylinks_without_expiry($merchant_id){

        $query="SELECT id,paylink_payid,paylink_for,paylink_amount,paylink_customer_email,DATE_FORMAT(created_date,'%Y-%m-%d') AS created_date,paylink_customer_mobile,paylink_payid,paylink_link FROM test_paylink WHERE created_merchant='$merchant_id' AND paylink_type='smart' AND paylink_status='issued' AND paylink_expiry IS NULL AND paylink_customer_email!= '' AND paylink_customer_mobile != '' AND paylink_auto_reminder='Y' ORDER BY test_paylink.created_date DESC";

        return DB::select($query);
    }

    public function get_all_test_reminders_without_expiry($merchant_id){

        $query="SELECT reminder_days,reminder_for,send_email,send_sms FROM test_reminder WHERE created_merchant='$merchant_id' AND reminder_for='plwoed' ORDER BY reminder_days DESC";

        return DB::select($query);
    }

    public function get_all_live_paylinks_without_expiry($merchant_id){

        $query="SELECT id,paylink_payid,paylink_for,paylink_amount,paylink_customer_email,DATE_FORMAT(created_date,'%Y-%m-%d') AS created_date,paylink_customer_mobile,paylink_payid,paylink_link FROM test_paylink WHERE created_merchant='$merchant_id' AND paylink_type='smart' AND paylink_status='issued' AND paylink_expiry IS NULL AND paylink_customer_email!= '' AND paylink_customer_mobile != '' AND paylink_auto_reminder='Y' ORDER BY test_paylink.created_date DESC";

        return DB::select($query);
    }

    public function get_all_live_reminders_without_expiry($merchant_id){

        $query="SELECT reminder_days,reminder_for,send_email,send_sms FROM live_reminder WHERE created_merchant=$merchant_id AND reminder_for='plwoed' ORDER BY reminder_days DESC";

        return DB::select($query);
    }

    public function get_all_success_transactions(){

        $query="SELECT transaction_gid,vendor_transaction_id,DATE_FORMAT(transaction_date,'%Y-%m-%d') transaction_date,transaction_amount FROM live_payment
        WHERE transaction_status='success' AND adjustment_done='N' AND DATE_FORMAT(transaction_date,'%Y-%m-%d')='$this->yesterday'";
        
        return DB::select($query);

    }


    public function get_all_pending_transactions(){

        $query="SELECT transaction_gid,DATE_FORMAT(transaction_date,'%Y-%m-%d') transaction_date,transaction_amount FROM live_payment
        WHERE transaction_status='pending' AND DATE_FORMAT(transaction_date,'%Y-%m-%d')='$this->yesterday'";
        
        return DB::select($query);

    }

    public function get_vendor_adjustment_resp($merchant_id,$merchant_traxn_id){

        $where_condition = "merchant_id=:merchant_id AND merchant_traxn_id=:merchant_traxn_id";

        $apply_condition["merchant_id"] = $merchant_id;
        $apply_condition["merchant_traxn_id"] = $merchant_traxn_id;
        
        $query = "SELECT COUNT(1) as row_exist FROM vendor_adjustment_resp WHERE $where_condition";


        return DB::select($query,$apply_condition);
    }

    public function add_vendor_adjustment_resp($response){

        return DB::table('vendor_adjustment_resp')->insert($response);
    }

    public function add_vendor_tracking_resp($response){

        return DB::table('vendor_transtrack_resp')->insert($response);
    }

    public function get_all_resetpswd_records(){

        $query = "SELECT email,token FROM password_resets";
        return DB::select($query);
    }

    public function get_risk_complaince_merchant_details($id){

        $where_condition = "AND merchant_business.created_merchant=:id";
        $apply_condition["id"] = $id;

        $query="SELECT name,email,mobile_no,type_name,category_name,app_option.option_value as expenditure,IF(business_sub_category_id=0,business_sub_category,sub_category_name) as sub_category_name,business_name,address,pincode,city,state_name,'India' as country,
        IF(webapp_exist='Y',webapp_url,'No Website') as website,bank_name,bank_acc_no,bank_ifsc_code,comp_pan_number,comp_gst,mer_pan_number,mer_aadhar_number,
        mer_name FROM merchant_business 
        LEFT JOIN business_type ON business_type.id = merchant_business.business_type_id
        LEFT JOIN app_option ON app_option.id = merchant_business.business_expenditure
        LEFT JOIN business_category ON business_category.id = merchant_business.business_category_id
        LEFT JOIN business_sub_category ON business_sub_category.id = merchant_business.business_sub_category_id
        LEFT JOIN state ON state.id = merchant_business.state
        LEFT JOIN merchant ON merchant.id = merchant_business.created_merchant WHERE app_option.module = 'merchant_business' $where_condition";

        return DB::select($query,$apply_condition);
    }

    public function get_test_page_detail($pagelink){

        $where_condition = "page_url=:url AND page_status='active'";
        $apply_condition["url"] = $pagelink; 

        $query = "SELECT id,page_title,page_url,contactus_email,payment_total,term_condition,page_logo,social_enable,contactus_enable,term_condition_enable,contactus_mobile,created_merchant,page_name,input_label,input_name,input_type,input_value,input_option,input_mandatory FROM  test_payment_page
        LEFT JOIN test_payment_page_input ON test_payment_page_input.payment_page_id = test_payment_page.id
        WHERE $where_condition"; 

        return DB::select($query,$apply_condition);

    }

    public function get_mandatory_fields($table_prefix,$id){

        $where_condition = "payment_page_id=:transaction_method_id AND input_mandatory='true' AND input_name NOT IN('input_email','input_mobile','input_amount','input_username')";

        $query = "SELECT LOWER(REPLACE(input_label,' ','_')) as input_label FROM ".$table_prefix."_payment_page_input
        WHERE $where_condition"; 

        return DB::select($query,$id);
    }

    public function get_live_page_detail($pagelink){

        $where_condition = "page_url=:url AND page_status='active'";
        $apply_condition["url"] = $pagelink; 

        $query = "SELECT id,page_title,page_url,contactus_email,payment_total,term_condition,page_logo,social_enable,contactus_enable,term_condition_enable,contactus_mobile,created_merchant,page_name,input_label,input_name,input_type,input_value,input_option,input_mandatory FROM  live_payment_page
        LEFT JOIN live_payment_page_input ON live_payment_page_input.payment_page_id = live_payment_page.id
        WHERE $where_condition"; 

        return DB::select($query,$apply_condition);

    }
    

    public function add_test_paymentpage_info($pageinfo){
        
        return DB::table("test_payment_page_info")->insert($pageinfo);
    }

    public function add_live_paymentpage_info($pageinfo){

        return DB::table("live_payment_page_info")->insert($pageinfo);
    }

    public function get_live_payment_info($ids){

        $where_condition = "id IN(".implode(',',$ids).")";
        $query = "SELECT id, transaction_gid, vendor_transaction_id, bank_ref_no, order_id, transaction_response, transaction_method_id, transaction_type, transaction_email, transaction_contact, transaction_amount, transaction_status, transaction_mode, transaction_notes, transaction_description, rupayapay_tax, goods_service_tax, android_status, adjustment_done,DATE_FORMAT(transaction_date,'%Y-%m-%d') as transaction_date, created_date, created_merchant, created_employee FROM live_payment
        WHERE $where_condition";

        return DB::select($query);
    }

    public function update_live_payment($id){

        return DB::table("live_payment")->where("id",$id)->update(["adjustment_done"=>"Y"]);
    }

    public function get_adjustment_bank_name($id){
        return DB::table("vendor_bank")->where("id",$id)->value("bank_name");
    }

    public function get_cashfree_keys($merchant_id){
        return DB::table("cf_rpay_keys")->where("merchant_id",$merchant_id)->select("app_id","secret_key")->get();
    }

    public function get_transaction($start_date,$end_date,$merchant_id=""){

        $where_condition="WHERE lp.transaction_status='success' AND DATE_FORMAT(lp.transaction_date,'%Y-%m-%d')>=:start_date AND DATE_FORMAT(lp.transaction_date,'%Y-%m-%d')<=:end_date";
        $apply_condition["start_date"] = $start_date;
        $apply_condition["end_date"] = $end_date;
        $group_by = '';
        $concatinate_column = '';
        if(!empty($merchant_id))
        {
            $where_condition.=" AND lp.created_merchant=:created_merchant";
            $apply_condition["created_merchant"] = $merchant_id;
            $group_by = ',lp.transaction_mode';
            $concatinate_column = ',IFNULL(lp.transaction_mode,"") as transaction_mode';
        }
        
        $query = "SELECT merchant.id,merchant.merchant_gid,mb.business_name,merchant.name,count(transaction_status) as no_of_transactions,sum(transaction_amount) as transaction_amount $concatinate_column
        FROM live_payment lp
        LEFT JOIN merchant on merchant.id = lp.created_merchant
        LEFT JOIN merchant_business mb on mb.created_merchant = merchant.id 
        $where_condition
        group by merchant.id $group_by
        order by merchant.id,lp.created_date desc";
        //DB::enableQueryLog();
        return DB::select($query,$apply_condition);
        //dd(DB::getQueryLog());
    }
}
