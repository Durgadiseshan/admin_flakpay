<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\VerifyAccount;
use DB;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','mobile_no','password','verify_token','app_mode','merchant_gid','created_date','last_seen_at',
        'is_mobile_verified','i_agree','virtual_id','is_email_verified','user_register'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','merchant_gid','created_date'
    ];

    protected $table = "merchant";

    protected $jointable1 = "live_payment";

    protected $jointable2 = "customer_case";

    public $timestamps = FALSE;

    public function orders(){
        return $this->hasMany('App\Order');
    }
    /**
     * 
     * @param appmode field
     * 
     */


    public function update_merchant($field){
        return DB::table($this->table)->where('id',Auth::user()->id)->update($field);
    }

    /**
     * sendAccountVerificationEmail 
     * 
     * @return void
     */
    public function sendAccountVerificationEmail(){
        $this->notify(new VerifyAccount($this));
    }


    public function getLastUserIndex(){
        $query = "SELECT count(1) as merchant_count FROM $this->table";
        return DB::select($query);
    }


    public function get_merchant_details(){
        $where_condition = "id=:id";
        $apply_condition["id"] = Auth::user()->id; 

        $query = "SELECT `name`,email,mobile_no FROM merchant WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);
        
    }

    public function get_document_status()
    {
        return DB::table($this->table)->where('id',Auth::user()->id)->select("documents_upload","app_mode")->get();
    }

    public function enable_showmodal($field)
    {
        return DB::table($this->table)->where(['id'=>Auth::user()->id,"documents_upload"=>"N"])->update($field);
    }

    public function select_query($select,$where){

        return DB::table($this->table)->where($where)->select($select)->get();
    }

    public function get_documents_status(){

        $query = "SELECT merchant_gid,`name`,email,mobile_no,IF(app_mode,'Live','Test') app_mode,
        IF(pan_card<>'',pan_card,'NA') pan_card,
        IF(aadhar_card<>'',aadhar_card,'NA') aadhar_card,IF(bank_statement<>'',bank_statement,'NA') bank_statement,
        IF(company_registration<>'',company_registration,'NA') company_registration
        FROM $this->table WHERE merchant_status = 'active'";

        //DB::enableQueryLog();
        return DB::select($query);
        //dd(DB::getQueryLog());
        //exit;
    }

    public function update_docverified_status($id,$field){

        return DB::table($this->table)->where($id)->update($field);
    }

    public function update_user_field($id,$field){

        return DB::table($this->table)->where($id)->update($field);
    }

    public static function get_merchant_gids(){

        $query = "SELECT merchant.id,IF(business_name<>'',business_name,merchant_gid) as merchant_gid FROM merchant 
        LEFT JOIN merchant_business on merchant_business.created_merchant = merchant.id
        WHERE merchant_status='active'";
        return DB::select($query);
    }

    public function get_merchant_transactions($fromdate="",$todate=""){

        $where_condition = "1=:id";
        $apply_condition["id"] = "1";

        if(!empty($fromdate)){
            $where_condition.= " AND DATE_FORMAT($this->jointable1.created_date,'%Y-%m-%d')>=:from_date";
            $apply_condition["from_date"] = $fromdate;
        }

        if(!empty($todate)){
            $where_condition.= " AND DATE_FORMAT($this->jointable1.created_date,'%Y-%m-%d')<=:to_date";  
            $apply_condition["to_date"] = $todate;
        }

        $query="SELECT merchant.name,merchant.email,merchant.mobile_no,count(1) as no_of_transaction FROM $this->jointable1 
        join merchant on merchant.id=$this->jointable1.created_merchant WHERE $where_condition GROUP BY created_merchant ORDER BY merchant.created_date DESC";

        //DB::enableQueryLog();
        return DB::select($query,$apply_condition);
        //dd(DB::getQueryLog());
        //exit;
    }

    public function get_merchant_trans_amount($fromdate="",$todate=""){


        $where_condition = "$this->jointable1.transaction_status='success'";
    
        if(!empty($fromdate)){
            $where_condition.= " AND DATE_FORMAT($this->jointable1.created_date,'%Y-%m-%d')>=:from_date";
            $apply_condition["from_date"] = $fromdate;
        }

        if(!empty($todate)){
            $where_condition.= " AND DATE_FORMAT($this->jointable1.created_date,'%Y-%m-%d')<=:to_date";  
            $apply_condition["to_date"] = $todate;
        }

        $query="SELECT merchant.name,merchant.email,merchant.mobile_no,sum($this->jointable1.transaction_amount) as transaction_amount FROM $this->jointable1 
        join merchant on merchant.id=$this->jointable1.created_merchant WHERE";
        return DB::select($query." ".$where_condition." GROUP BY created_merchant ORDER BY merchant.created_date DESC",$apply_condition);
    }

    public function get_all_merchants(){

        $query = "SELECT merchant_gid,`name`,email,mobile_no,merchant_status,DATE_FORMAT(created_date,'%Y-%m-%d %h:%i:%s %p') created_date,DATE_FORMAT(last_seen_at,'%Y-%m-%d %h:%i:%s %p') last_seen_at FROM $this->table
        ORDER BY $this->table.created_date DESC";

        return DB::select($query);
    }

    public function get_merchant_cases(){

        $query = "SELECT case_gid,transaction_gid,transaction_amount,customer_name,customer_email,customer_mobile,$this->table.`name`,`status`,DATE_FORMAT($this->jointable2.created_date,'%Y-%m-%d %H:%i:%s %p') as created_date FROM $this->jointable2 JOIN $this->table ON $this->table.id=$this->jointable2.merchant_id ORDER BY $this->jointable2.created_date DESC";

        return DB::select($query); 
    }

    public function merchant_locked(){

        $query = "SELECT id,merchant_gid,`name`,email,mobile_no,merchant_status,DATE_FORMAT(created_date,'%Y-%m-%d %h:%i:%s %p') created_date,DATE_FORMAT(last_seen_at,'%Y-%m-%d %h:%i:%s %p') last_seen_at FROM $this->table
        WHERE is_account_locked='Y' ORDER BY $this->table.created_date DESC";

        return DB::select($query);
    }

    public function get_active_merchants(){

        $query="SELECT id,name,app_mode,is_reminders_enabled,email from $this->table WHERE merchant_status='active' AND is_reminders_enabled = 'Y'";
        return DB::select($query);
    }

    public static function get_merchant_options(){

        $query = "SELECT id,name FROM merchant WHERE merchant_status='active'";
        return DB::select($query);
    }

    public static function get_tmode_bgverfied_merchants(){

        $query = "SELECT id,name FROM merchant WHERE merchant_status='active' AND app_mode='0' AND bg_verified='N'";
        return DB::select($query);
    }

    public static function get_tmode_docupload_merchants(){

        $query = "SELECT id,name FROM merchant WHERE merchant_status='active' AND app_mode='0' AND documents_upload='Y' AND doc_verified='N'";
        return DB::select($query);
    }

    public static function get_merchant_gid($merchant_id){ 
        return DB::table("merchant")->where("id",$merchant_id)->value("merchant_gid");
    }

    public function get_merchant_info($merchant_id,$column_name){
        if(!empty($merchant_id) && !empty($column_name)){
            return DB::table("merchant")->where("id",$merchant_id)->value($column_name);
        }
    }

}
