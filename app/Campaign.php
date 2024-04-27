<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Campaign extends Model
{
    protected $table;

    public function __construct(){
        $this->table = "campaign";
    }

    public function add_campaign($campaign){

        return DB::table($this->table)->insert($campaign);
    }

    public function get_campaign(){

        $query = "SELECT campaign_from,campaign_subject,campaign_to,campaign_status,DATE_FORMAT(campaign_sent,'%Y-%m-%d %H:%i:%s %p') as campaign_sent
        FROM $this->table ORDER BY $this->table.campaign_sent DESC";

        return DB::select($query);
    }
}
