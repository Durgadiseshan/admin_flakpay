<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class Reminder extends Model
{
    protected $table;

    public $primarykey = "id";

    protected $table_prefix = "test";

    public function __construct()
    {
        if(Auth::user()->app_mode)
        {
            $this->table_prefix = "live";
        }
        $this->table = $this->table_prefix."_reminder"; 
    }

    protected $fillable = ['reminder_days,reminder_for,send_sms','send_email'];

    protected $hidden = ['created_date','created_merchant'];


    public function add_reminder($reminder_data){
        DB::table($this->table)->where("created_merchant",Auth::user()->id)->delete();
        return DB::table($this->table)->insert($reminder_data);
    }

    public function get_reminder(){
        
        $where_condition = "created_merchant=:id";
        $apply_condition["id"] = Auth::user()->id;
        $query = "SELECT reminder_days,reminder_for,send_sms,send_email FROM $this->table WHERE";
        return DB::select($query." ". $where_condition,$apply_condition);
    }



}
