<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class RyapayEvent extends Model
{
    protected $table;

    public function __construct(){
        $this->table = "ryapay_event";
    }

    public function add_event($event_details){

        return DB::table($this->table)->insert($event_details);
    }

    public function get_all_events(){

        $query = "SELECT id,event_name,event_register,DATE_FORMAT(event_date,'%Y-%m-%d') as event_date,event_time,event_status,DATE_FORMAT(created_date,'%Y-%m-%d %H:%i:%s %p') as created_date FROM $this->table
        WHERE event_status='active' ORDER BY $this->table.created_date DESC";

        return DB::select($query);
    }

    public function get_event($id){

        $where_condition = "id=:id AND event_status='active'";
        $apply_condition["id"] = $id;

        $query = "SELECT id,event_name,event_venue,event_date,event_time,event_image,event_register,event_description,event_short_url FROM $this->table WHERE $where_condition";
        return DB::select($query,$apply_condition);
    }

    public function update_event($id,$event_details){

        return DB::table($this->table)->where($id)->update($event_details);
    }

    public function get_event_posts(){

        $query="(SELECT event_name,event_image,DATE_FORMAT(event_date,'%a, %M %d,%Y') as event_date,event_description,event_short_url,'upcoming' as type FROM $this->table WHERE DATE_FORMAT(event_date,'%Y-%m-%d') > DATE_ADD(NOW(), INTERVAL 0 DAY) ORDER BY DATE_FORMAT(event_date,'%Y-%m-%d') DESC LIMIT 3)
        UNION
        (select event_name,event_image,DATE_FORMAT(event_date,'%a, %M %d,%Y') as event_date,event_description,event_short_url,'recent' FROM $this->table WHERE DATE_FORMAT(event_date,'%Y-%m-%d') > DATE_SUB(NOW(), INTERVAL 1 MONTH) AND DATE_FORMAT(event_date,'%Y-%m-%d') < NOW() ORDER BY DATE_FORMAT(event_date,'%Y-%m-%d') DESC LIMIT 3)
        UNION
        (SELECT event_name,event_image, DATE_FORMAT(event_date,'%a, %M %d,%Y') as event_date,event_description,event_short_url,'past' as type FROM $this->table WHERE DATE_FORMAT(event_date,'%Y-%m-%d') < DATE_SUB(NOW(), INTERVAL 1 MONTH) ORDER BY DATE_FORMAT(event_date,'%Y-%m-%d') DESC LIMIT 3)";
        
        return DB::select($query);
    }

    public function get_event_post($id){

        $where_condition = "event_short_url=:id AND event_status='active'";
        $apply_condition["id"] = $id;

        $query = "SELECT id,event_name,event_venue,DATE_FORMAT(event_date,'%a, %M %d,%Y') as event_date,event_time,event_image,event_register,register_open,event_description FROM $this->table WHERE $where_condition";
        return DB::select($query,$apply_condition);
    }
}
