<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class MerchantBusiness extends Model
{
    protected $table;
    protected $jointable1;

    public function __construct()
    {
        $this->table="merchant_business";
        $this->jointable1 = "state";
    }



    public function get_merchant_business_details($id=null)
    {
        
        $apply_condition = [];
        
        $where_condition = "created_merchant=:id";

        if($id){
            
            $apply_condition["id"] = $id;

        }else{
            
            $apply_condition["id"] = Auth::user()->id;

        }
        

        // $query = "SELECT $this->table.id,IFNULL(business_type_id,'') as business_type_id,
        // IFNULL(business_category_id,'') as business_category_id,
        // IFNULL(business_sub_category_id,'') as business_sub_category_id,
        // IFNULL(business_sub_category,'') as business_sub_category,
        // IFNULL(billing_label,'') as billing_label,IFNULL(webapp_exist,'') as webapp_exist,
        // IFNULL(webapp_url,'') as webapp_url,IFNULL(business_name,'') as business_name,
        // IFNULL(llpin_number,'') as llpin_number,IFNULL(mer_pan_number,'') as mer_pan_number,
        // IFNULL(mer_name,'') as mer_name,
        // IFNULL(`address`,'') as `address`,
        // IFNULL(comp_pan_number,'') as comp_pan_number,
        // IFNULL(comp_gst,'') as comp_gst,
        // IFNULL(mer_aadhar_number,'') as mer_aadhar_number,
        // IFNULL(pincode,'') as pincode,IFNULL(city,'') as city,
        // IFNULL(`state`,'') as `state`,
        // IFNULL(bank_name,'') as bank_name,
        // IFNULL(bank_acc_no,'') as bank_acc_no,
        // IFNULL(bank_ifsc_code,'') as bank_ifsc_code,
        // IFNULL(business_expenditure,'') as business_expenditure,
        // IFNULL(business_logo,'') as business_logo,
        // $this->jointable1.state_name,
        // CONCAT_WS(' ',address,pincode,city,state_name) as mer_address FROM $this->table
        // LEFT JOIN $this->jointable1 on $this->jointable1.id = $this->table.`state`
        // WHERE";

// Define the columns you want to select
$columns = [
    'merchant_business.id',
    'merchant_business.business_type_id',
    'merchant_business.business_expenditure',
    'merchant_business.business_category_id',
    'merchant_business.business_sub_category_id',
    'merchant_business.business_sub_category',
    'merchant_business.billing_label',
    'merchant_business.webapp_url',
    'merchant_business.business_name',
    'merchant_business.webapp_exist',
    'merchant_business.mer_pan_number',
    'merchant_business.city',
    'merchant_business.llpin_number',
    'merchant_business.mer_name',
    'merchant_business.address',
    'merchant_business.comp_pan_number',
    'merchant_business.comp_gst',
    'merchant_business.mer_aadhar_number',
    'merchant_business.pincode',
    'merchant_business.state',
    'merchant_business.bank_name',
    'merchant_business.bank_acc_no',
    'merchant_business.bank_ifsc_code',
    'merchant_business.business_expenditure',
    'merchant_business.business_logo',
    'state.state_name',
    'state.gst_code',
];

$merchantTable = $this->table;      
$stateTable = $this->jointable1;    

$query = "SELECT " . implode(', ', $columns) . " FROM $merchantTable
          LEFT JOIN $stateTable ON $merchantTable.state = $stateTable.id";

// dd(DB::select($query));

        return DB::select($query);
    }



    public function add_merchant_business($insertdata)
    {
        return DB::table($this->table)->insert($insertdata);
    }

    public function update_merchant_business($where,$updatedata)
    {
        return DB::table($this->table)->where($where)->update($updatedata);
    }

    public function get_state(){

        $merchant_state = DB::table($this->table)->where('created_merchant',Auth::user()->id)->value('state');
        return $merchant_state;
    }

    public function get_requested_columns($columns_array=array())
    {
        $where_condition = "created_merchant=:id";
        $apply_condition["id"] = Auth::user()->id;

        if(!empty($columns_array))
        {
            $query = "SELECT ".implode(',',$columns_array)." FROM $this->table WHERE";

            return DB::select($query." ".$where_condition,$apply_condition);
        } 
    }


    public static function get_business_id()
    {
        return DB::table("merchant_business")->where("created_merchant" , Auth::user()->id)->value("business_type_id");
    }

    public static function get_category_id($merchantid)
    {
        return DB::table("merchant_business")->where("created_merchant" , $merchantid)->value("business_category_id");
    }

    public static function get_business_name($merchantid=""){

        if(empty($merchantid))
        {
            return DB::table("merchant_business")->where("created_merchant" ,Auth::user()->id)->value("business_name");

        }else{

            return DB::table("merchant_business")->where("created_merchant" ,$merchantid)->value("business_name");
        }
        
    }

    public static function get_merchant_business_name($merchant_id){
        return DB::table("merchant_business")->where("created_merchant" ,$merchant_id)->value("business_name");
    }

    public function get_merchant_business_info($merchant_id){

        $where_condition = "AND created_merchant=:merchant_id";
        $apply_condition["merchant_id"] = $merchant_id;

        $query = "SELECT business_type_id,business_category_id,business_sub_category_id,business_sub_category FROM merchant_business
        WHERE business_type_id<>'0' AND business_category_id<>'0' $where_condition";

        return DB::select($query,$apply_condition);
    }

    
}
