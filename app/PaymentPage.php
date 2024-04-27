<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class PaymentPage extends Model
{
    protected $table;
    protected $jointableone;
    protected $table_prefix = "test";

    public function __construct(){

        if(Auth::user()->app_mode)
        {
            $this->table_prefix = "live";
        }   

        $this->table = $this->table_prefix."_payment_page";
        $this->jointableone = $this->table_prefix."_payment_page_input";
    }

    public function add_page_details($page_data){

        return DB::table($this->table)->insertGetId($page_data);
    }

    public function get_page_details(){

        $where_condition = "created_merchant=:id";
        $apply_condition["id"] = Auth::user()->id;

        $query = "SELECT id,page_gid,page_title,page_url,page_status,IF(page_status = 'active','inactive','active') as change_status,DATE_FORMAT(created_date,'%Y-%m-%d %H:%i:%s %p') as created_date
        FROM $this->table WHERE $where_condition ORDER BY $this->table.created_date DESC";

        return DB::select($query,$apply_condition);
    }

    public function get_page_detail($pagelink){

        $where_condition = "page_url=:url AND page_status='active'";
        $apply_condition["url"] = $pagelink; 

        $query = "SELECT id,page_title,page_url,contactus_email,payment_total,term_condition,page_logo,social_enable,contactus_enable,term_condition_enable,contactus_mobile,page_name,input_label,input_name,input_type,input_value,input_option FROM  $this->table
        LEFT JOIN $this->jointableone ON $this->jointableone.payment_page_id = $this->table.id
        WHERE $where_condition";

        return DB::select($query,$apply_condition);

    }

    public function edit_page_detail($pageid){

        $where_condition = "id=:pageid";
        $apply_condition["pageid"] = $pageid; 

        $query = "SELECT id,page_title,contactus_email,payment_total,term_condition,page_logo,social_enable,contactus_enable,term_condition_enable,contactus_mobile,page_name,input_label,input_name,input_type,input_value,input_option,input_mandatory FROM  $this->table
        INNER JOIN $this->jointableone ON $this->jointableone.payment_page_id = $this->table.id
        WHERE $where_condition";
        //DB::enableQueryLog();
        return DB::select($query,$apply_condition);
        //dd(DB::getQueryLog());
    }

    public function update_page_details($id,$page_data){

        return DB::table($this->table)->where($id)->update($page_data);
    }

    public function get_merchant_id($page_url){

        return DB::table($this->table)->where($page_url)->value("created_merchant");
    }

}
