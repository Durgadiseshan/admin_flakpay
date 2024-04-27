<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class MerchantCoupon extends Model
{
   protected $table;

   protected $jointable1;
   protected $jointable2;

   public function __construct()
   {
       $this->table = "merchant_coupon";
       $this->jointable1 = "coupon_option";
       $this->jointable2 = "currency";
   }

   public function add_coupon($coupon_data)
   {
        return DB::table($this->table)->insert($coupon_data);
   }

   public function get_coupons()
   {

        $where_condition = "created_merchant=:merchant_id ORDER BY m_coupon.created_date DESC";
        $apply_condition["merchant_id"] = Auth::user()->id;

        $query = "SELECT m_coupon.id,coupon_gid,c_option.coupon_option,$this->jointable2.currency,IF(coupon_type = 2,CONCAT(coupon_discount,'%'),coupon_discount) coupon_discount,coupon_maxdisc_amount,DATE_FORMAT(coupon_validto,'%d-%m-%Y') coupon_validto,coupon_status,coupon_maxuse,
        DATE_FORMAT(coupon_validfrom,'%d-%m-%Y') coupon_validfrom,DATE_FORMAT(coupon_validto,'%d-%m-%Y') coupon_validto,DATE_FORMAT(created_date,'%d-%m-%Y %h:%i:%s %p') created_date,coupon_type,coupon_on,coupon_ordermax_amount FROM $this->table m_coupon LEFT JOIN $this->jointable1 c_option on (c_option.id = m_coupon.coupon_on) LEFT JOIN $this->jointable2 on ($this->jointable2.id = m_coupon.coupon_currency) WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);

   }

   public function get_coupon($id)
   {
     $where_condition = "id=:id AND created_merchant=:merchant_id";
     $apply_condition["merchant_id"] = Auth::user()->id;
     $apply_condition["id"] = $id;

     $query = "SELECT id,coupon_gid,coupon_type,coupon_currency,coupon_discount,coupon_on,coupon_maxdisc_amount,
     coupon_ordermax_amount,coupon_onproduct,DATE_FORMAT(coupon_validfrom,'%Y-%m-%d') coupon_validfrom,DATE_FORMAT(coupon_validto,'%Y-%m-%d') coupon_validto,coupon_maxuse,coupon_usermaxuse
     FROM $this->table WHERE";

     return DB::select($query." ".$where_condition,$apply_condition);
   }

   public function update_coupon($update_data,$id)
   {
        return DB::table($this->table)->where($id)->update($update_data);
   }
}
