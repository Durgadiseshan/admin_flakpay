<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\PaylinkEmail;
use DB;
use Auth;

class Paylink extends Model
{

    use Notifiable;

    protected $table;

    public $primarykey = 'id';

    protected $table_prefix = "test";

    public $timestamps = FALSE;

    public function __construct($prefix=0){

    if(Auth::check()){
        if(Auth::guard("merchantemp")->check()){
            $this->table_prefix = "live";
        }else{
                if(Auth::user()->app_mode)
            {
                $this->table_prefix = "live";
            } 
         }
       }
        if($prefix){
             $this->table_prefix = "live";
            
        }
        $this->table = $this->table_prefix."_paylink";
    }

    protected $fillable = [
        'created_merchant'
    ];


    public function get_all_paylinks($filters=array()){

        $where_condition = "$this->table.created_merchant=:id AND paylink_type='smart'";
        $apply_condition["id"] = Auth::user()->id;
        
        if(!empty($filters))
        {
            if(!empty($filters["paylink_gid"]))
            {
                $where_condition.= " AND paylink_gid=:gid";
                $apply_condition["gid"] = $filters["paylink_gid"];
            }

            if(!empty($filters["paylink_receipt"]))
            {
                $where_condition .= " AND paylink.paylink_receipt=:rct_no";
                $apply_condition["rct_no"] = $filters["paylink_receipt"];
            }

            if(!empty($filters["paylink_customer_email"]))
            {
                $where_condition .= " AND paylink_customer_email=:email";
                $apply_condition["email"] = $filters["paylink_customer_email"];
            }

            if(!empty($filters["paylink_customer_mobile"]))
            {
                $where_condition .= " AND paylink_customer_mobile=:mobile";
                $apply_condition["mobile"] = $filters["paylink_customer_mobile"];
            }

            if(!empty($filters["paylink_status"]))
            {
                $where_condition .= " AND paylink_status=:pay_status";
                $apply_condition["pay_status"] = $filters["paylink_status"];
            }
        }
        
        $query = "SELECT $this->table.id,paylink_gid,paylink_amount,IFNULL(paylink_receipt,'') as paylink_receipt,
        IFNULL(paylink_customer_mobile,'') as paylink_customer_mobile,IFNULL(paylink_customer_email,'') as paylink_customer_email,paylink_link,paylink_payid,DATE_FORMAT($this->table.created_date,'%d-%m-%Y %h:%i:%s %p') created_date,paylink_status,IF($this->table.created_employee <> 0,merchant_employee.employee_name,merchant.name) as created_merchant FROM $this->table 
        INNER JOIN
        merchant ON merchant.id = $this->table.created_merchant
        LEFT JOIN
        merchant_employee ON merchant_employee.id = $this->table.created_employee
        WHERE $where_condition ORDER BY $this->table.created_date DESC";

        return DB::select($query,$apply_condition);
    }

    public function get_all_quicklinks($merchantId="",$empId="")
    {
        if(!empty($merchantId) && !empty($empId))
        {
            $where_condition = "$this->table.created_merchant=:id AND created_employee=:empid AND paylink_type='quick'";
            $apply_condition["id"] = $merchantId;
            $apply_condition["empid"] = $empId;

        }else{

            $where_condition = "$this->table.created_merchant=:id AND paylink_type='quick'";
            $apply_condition["id"] = Auth::user()->id;
        }
        

        $query = "SELECT $this->table.id,paylink_gid,paylink_amount,DATE_FORMAT(paylink_expiry,'%d-%m-%Y %h:%i:%s %p') AS paylink_expiry,paylink_for,
        paylink_link,paylink_payid,DATE_FORMAT($this->table.created_date,'%d-%m-%Y %h:%i:%s %p') created_date,paylink_status,IF($this->table.created_employee <> 0,merchant_employee.employee_name,merchant.name) as created_merchant FROM $this->table
        INNER JOIN
        merchant ON merchant.id = $this->table.created_merchant
        LEFT JOIN
        merchant_employee ON merchant_employee.id = $this->table.created_employee
        WHERE
        $where_condition ORDER BY $this->table.created_date DESC";

        return DB::select($query,$apply_condition);
    }

    public function add_paylink($paylinkdata)
    {
        return DB::table($this->table)->insert($paylinkdata);
    }

    public function update_paylink($paylinkdata,$updatedata)
    {
        return DB::table($this->table)->where($updatedata)->update($paylinkdata);
    }

    
    public function edit_paylink($id)
    {
        $apply_condition["id"] = $id;

        $query = "SELECT id,paylink_gid,paylink_amount,IFNULL(paylink_receipt,'') as paylink_receipt,paylink_for,email_paylink,mobile_paylink,paylink_partial,IFNULL(DATE_FORMAT(paylink_expiry,'%Y-%m-%d'),'') as paylink_expiry,IFNULL(paylink_notes,'') as paylink_notes,IFNULL(paylink_customer_mobile,'') as paylink_customer_mobile,IFNULL(paylink_customer_email,'') as paylink_customer_email,paylink_auto_reminder FROM $this->table WHERE id=:id";
        
        return DB::select($query,$apply_condition);
    }

    public function send_paylink_email(){

        $this->notify(new PaylinkEmail($this));
    }

    public function get_merchant_paylinks(){

        $query="SELECT count(1) AS no_of_paylinks,merchant.name,merchant.email,merchant.mobile_no FROM live_paylink JOIN merchant ON merchant.id = live_paylink.created_merchant GROUP BY created_merchant";

        return DB::select($query);
    }

    public function get_emp_smtpaylinks($merchantId,$empId){


        $where_condition = "created_merchant=:id AND created_employee=:empid AND paylink_type='smart' ";
        $apply_condition["id"] = $merchantId;
        $apply_condition["empid"] = $empId;
                
        $query = "SELECT id,paylink_gid,paylink_amount,IFNULL(paylink_receipt,'') as paylink_receipt,
        IFNULL(paylink_customer_mobile,'') as paylink_customer_mobile,IFNULL(paylink_customer_email,'') as paylink_customer_email,paylink_link,paylink_payid,DATE_FORMAT(created_date,'%d-%m-%Y %h:%i:%s %p') created_date,paylink_status FROM $this->table WHERE $where_condition ORDER BY $this->table.created_date DESC";

        return DB::select($query,$apply_condition);
    }


    public function merchant()
    {
        return $this->belongsTo(Merchant::class,'created_merchant','id');
    }
}
