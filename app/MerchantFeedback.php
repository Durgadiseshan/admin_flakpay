<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class MerchantFeedback extends Model
{
    protected $table;

    protected $jointable1;
    public function __construct()
    { 
        $this->table = "merchant_feedback";
        $this->jointable1 = "app_option";
    }


    public function add_feedback($feedback_data){
        return DB::table($this->table)->insert($feedback_data);
    }

    public function get_feedback_details(){

        $where_condition = "created_merchant =:id ORDER BY $this->table.created_date DESC";
        $apply_condition["id"] = Auth::user()->id;

        $query = "SELECT $this->jointable1.option_value as feed_subject,feed_rating,feedback,DATE_FORMAT(created_date,'%d-%m-%Y %h:%i:%s %p')  as created_date FROM $this->table 
        LEFT JOIN $this->jointable1 ON $this->jointable1.id = $this->table.feed_subject WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);
    }
}
