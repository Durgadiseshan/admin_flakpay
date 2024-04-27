<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class RyapayGallery extends Model
{
    protected $table;
    protected $jointableone;

    public function __construct(){
        $this->table = "ryapay_gallery";
        $this->jointableone = "app_option";
    }

    public function add_image($gallery_data){
        return DB::table($this->table)->insert($gallery_data);
    }

    public function get_gallery_images(){

        $query="SELECT $this->table.id,IF(image_content<>'',image_content,image_heading) as  content,$this->jointableone.option_value as position,
        DATE_FORMAT($this->table.created_date,'%d-%m-%Y %H:%i:%s %p') as created_date FROM $this->table
        INNER JOIN $this->jointableone ON $this->jointableone.id = $this->table.image_position
        ORDER BY $this->table.created_date DESC";

        return DB::select($query);
    }

    public function get_gallery(){

        $query="SELECT $this->table.id,image_name,IF(image_content<>'',image_content,image_heading) as  content,image_position
        FROM $this->table  ORDER BY $this->table.created_date DESC";

        return DB::select($query);
    }

    public function get_gallery_image($id){


        $where_condition = "id=:id";
        $apply_condition["id"] = $id;

        $query="SELECT $this->table.id,image_name,image_content,image_position,image_heading FROM $this->table WHERE
        $where_condition";

        return DB::select($query,$apply_condition);
    }

    public function update_image($image_id,$gallery_data){
        return DB::table($this->table)->where($image_id)->update($gallery_data);
    }
}
