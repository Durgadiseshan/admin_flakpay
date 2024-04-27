<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class RyapayFixedAsset extends Model
{
    protected $table;

    protected $jointableone;

    public function __construct(){
        $this->table = "ryapay_fixed_asset";
        $this->jointableone = "chart_of_account";
    }

    public function get_all_assets(){

        $where_condition = "status='active' AND asset_status='create' ORDER BY $this->table.created_date DESC";
        
        $query = "SELECT $this->table.id,asset_gid,asset_name,$this->jointableone.account_code,$this->table.asset_amount,$this->table.remark,DATE_FORMAT($this->table.created_date,'%d-%m-%Y %H:%i:%s %p') as created_date FROM $this->table
        LEFT JOIN $this->jointableone ON $this->jointableone.id = $this->table.account_id WHERE";

        return DB::select($query." ".$where_condition);

    }

    public function add_asset($asset_data){
        return DB::table($this->table)->insert($asset_data);
    }

    public function edit_asset_info($id){

        $where_condition = "id=:id AND status='active'";
        $apply_condition["id"] = $id;

        $query = "SELECT id,asset_name,asset_description,account_id,asset_amount,asset_capital_amount,asset_depre_amount,asset_sale_amount,remark FROM $this->table WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);

    }

    public function update_asset_info($asset_data,$asset_id){
        return DB::table($this->table)->where($asset_id)->update($asset_data);
    }

    public static function get_asset_options(){
        
        $where_condition = "status='active' ORDER BY ryapay_fixed_asset.created_date DESC";
        
        $query = "SELECT id,asset_name FROM ryapay_fixed_asset WHERE";

        return DB::select($query." ".$where_condition);
    }

    public function get_all_capital_assets(){

        $where_condition = "status='active' AND asset_status='capitalization' ORDER BY $this->table.created_date DESC";
        
        $query = "SELECT $this->table.id,asset_gid,asset_name,$this->jointableone.account_code,$this->table.asset_amount,
        $this->table.asset_capital_amount,$this->table.remark,DATE_FORMAT($this->table.created_date,'%d-%m-%Y %H:%i:%s %p') as created_date FROM $this->table
        LEFT JOIN $this->jointableone ON $this->jointableone.id = $this->table.account_id WHERE";

        return DB::select($query." ".$where_condition);

    }

    public function get_all_depreciate_assets(){

        $where_condition = "status='active' AND asset_status='depreciation' ORDER BY $this->table.created_date DESC";
        
        $query = "SELECT $this->table.id,asset_gid,asset_name,$this->jointableone.account_code,$this->table.asset_amount,asset_depre_amount,$this->table.remark,DATE_FORMAT($this->table.created_date,'%d-%m-%Y %H:%i:%s %p') as created_date FROM $this->table
        LEFT JOIN $this->jointableone ON $this->jointableone.id = $this->table.account_id WHERE";

        return DB::select($query." ".$where_condition);

    }

    public function get_all_sale_assets(){

        $where_condition = "status='active' AND asset_status='sale' ORDER BY $this->table.created_date DESC";
        
        $query = "SELECT $this->table.id,asset_gid,asset_name,$this->jointableone.account_code,$this->table.asset_amount,asset_sale_amount,$this->table.remark,DATE_FORMAT($this->table.created_date,'%d-%m-%Y %H:%i:%s %p') as created_date FROM $this->table
        LEFT JOIN $this->jointableone ON $this->jointableone.id = $this->table.account_id WHERE";

        return DB::select($query." ".$where_condition);

    }
}
