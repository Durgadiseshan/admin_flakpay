<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ContactUs extends Model
{

    protected $table;

    protected $primarykey = 'id';


    public function __construct(){

        $this->table = 'contact_us';
    }


    public function add_contactus($contactusdata){
        
        return DB::table($this->table)->insert($contactusdata);
    }

    public function get_contactus(){

        $query = "SELECT name,email,mobile_no,IFNULL(subject,'') as subject,IFNULL(message,'') as message,lead_from,
        DATE_FORMAT($this->table.created_date,'%Y-%m-%d %H:%i:%s %p') as created_date FROM $this->table ORDER BY $this->table.created_date DESC";

        return DB::select($query);
    }
}
