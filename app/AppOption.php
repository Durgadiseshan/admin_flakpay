<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class AppOption extends Model
{

    protected $table = "app_option";

    protected $primarykey = "id";


   public static function get_business_expenditure()
   {    
        return DB::table("app_option")->select("id","option_value")->where("module","merchant_business")->get();
   }

   public static function get_merchant_feedback()
   {    
        return DB::table("app_option")->select("id","option_value")->where("module","merchant_feedback")->get();
   }

   public static function get_blog_category()
   {    
        return DB::table("app_option")->select("id","option_value")->where("module","blog_category")->get();
   }

   public static function get_global_tax_type()
   {    
        return DB::table("app_option")->select("id","option_value")->where("module","global_tax_type")->get();
   }

   public static function get_category_post_count(){

     $query = "SELECT option_value AS blog_category,count(post_category) no_of_posts FROM app_option LEFT JOIN ryapay_blog ON ryapay_blog.post_category = app_option.id  WHERE module='blog_category' AND ryapay_blog.post_status='active' GROUP BY option_value";

     return DB::select($query);

   }

   public static function get_banned_products()
   {    
        return DB::table("app_option")->select("id","option_value")->where("module","banned_products")->get();
   }

   public static function get_customer_support()
   {    
        return DB::table("app_option")->select("id","option_value")->where("module","customer_support")->get();
   }

   public static function get_ryapay_cdr()
   {    
        return DB::table("app_option")->select("id","option_value")->where("module","ryapay_cdr")->get();
   }

   public static function get_paymode()
   {    
        return DB::table("app_option")->select("id","option_value")->where("module","payment_mode")->get();
   }

   public static function get_merchant_emptype()
   {    
        return DB::table("app_option")->select("id","option_value")->where("module","mer_emp_type")->get();
   }

   public static function get_gallery_option()
   {    
        return DB::table("app_option")->select("id","option_value")->where("module","gallery")->get();
   }

   public static function get_job_category()
   {    
        return DB::table("app_option")->select("id","option_value")->where("module","career")->get();
   }
}
