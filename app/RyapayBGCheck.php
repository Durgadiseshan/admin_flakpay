<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class RyapayBGCheck extends Model
{
    protected $table;
    protected $jointableone;
    protected $jointabletwo;
    protected $jointablethree;
    protected $jointablefour;

    public function __construct(){
        $this->table = "ryapay_bgcheck";
        $this->jointableone = "business_type";
        $this->jointabletwo = "business_category";
        $this->jointablethree = "business_sub_category";
        $this->jointablefour = "merchant";
    }

    public function get_background_info(){

        $query="SELECT $this->table.id,tele_verify,DATE_FORMAT($this->table.created_date,'%Y-%m-%h %H:%i:%s %p') as created_date,$this->jointablefour.`name`,$this->jointablefour.email,$this->jointableone.type_name,
        $this->table.ban_product,$this->table.website_exists FROM $this->table
        LEFT JOIN $this->jointablefour ON $this->jointablefour.id = $this->table.merchant_id
        LEFT JOIN $this->jointableone ON $this->jointableone.id = $this->table.business_type_id ORDER BY 
        $this->table.created_date DESC";

        return DB::select($query);
    }

    public function edit_background_info($id){

        $where_condition = "id=:id";
        $apply_condition["id"] = $id;

        $query = "SELECT id,merchant_id,tele_verify,business_type_id,business_category_id,business_sub_category_id,business_sub_category,website_exists,website_url,website_contains,ban_product,ban_product_id FROM $this->table WHERE $where_condition";

        return DB::select($query,$apply_condition);
    }

    public function add_background($bg_data){
        return DB::table($this->table)->insert($bg_data);
    }

    public function update_background($where_cond,$bg_data){
        return DB::table($this->table)->where($where_cond,)->update($bg_data);
    }
}
