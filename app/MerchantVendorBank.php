<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class MerchantVendorBank extends Model
{
    protected $table;

    protected $jointableone;

    protected $jointabletwo;

    public function __construct(){
        $this->table = "merchant_vendor_bank";
        $this->jointableone = "business_type";
        $this->jointabletwo = "merchant";
    }

    public function get_merchant_routes(){

        $query="SELECT $this->table.id, $this->jointabletwo.merchant_gid,$this->jointabletwo.name,$this->jointableone.type_name,DATE_FORMAT($this->table.created_date,'%Y-%m-%d %H:%i:%s %p') as created_date
        FROM $this->table LEFT JOIN $this->jointableone ON $this->jointableone.id = $this->table.business_type_id
        LEFT JOIN $this->jointabletwo ON $this->jointabletwo.id = $this->table.merchant_id
        ORDER BY $this->table.created_date DESC";

        return DB::select($query);
    }

    public function add_merchant_route($route_details){

        return DB::table($this->table)->insert($route_details);
    }

    public function update_merchant_route($id,$route_details){
        return DB::table($this->table)->where($id)->update($route_details);
    }

    public function check_merchantbank_link_exists($merchant_id){

        $where_condition = "merchant_id=:merchant_id";
        $apply_condition["merchant_id"] = $merchant_id;

        $query = "SELECT COUNT(1) as merchant_bank FROM $this->table WHERE $where_condition";

        return DB::select($query,$apply_condition);

    }

    public function get_merchant_route($id){

        $where_condition = "id=:id";
        $apply_condition["id"] = $id;

        $query="SELECT id, merchant_id, cc_card, dc_card, net, upi, qrcode, wallet, business_type_id FROM $this->table
        WHERE $where_condition";

        return DB::select($query,$apply_condition);
    }

     public  function get_merchant_route_by_merchant_id($id){

        $where_condition = "merchant_id=:merchant_id";
        $apply_condition["merchant_id"] = $id;

        $query="SELECT id, merchant_id, cc_card, dc_card, net, upi, qrcode, wallet, business_type_id FROM $this->table
        WHERE $where_condition ORDER BY $this->table.id DESC limit 1";

        return DB::select($query,$apply_condition);
    }

    public function get_merchantbank_id($id,$coulumn){

        return DB::table($this->table)->where("merchant_id",$id)->value($coulumn);
    }
}
