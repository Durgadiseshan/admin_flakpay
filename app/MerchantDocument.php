<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use App\MerchantBusiness;

class MerchantDocument extends Model
{
    protected $table;
    protected $jointableone;
    protected $jointabletwo;
    protected $jointablethree;

    protected $primarykey = "id";

    public function __construct(){
        $this->table = "merchant_document";
        $this->jointableone = "merchant";
        $this->jointabletwo = "merchant_business";
        $this->jointablethree = "business_type";
    }

    public function add_documents($documents)
    {
        return DB::table($this->table)->insert($documents);
    }

    public function update_documents($where,$update)
    {
        return DB::table($this->table)->where($where)->update($update);
    }


    public function remove_document($id,$column){

        $where_condition = "id=:file_id";
        $apply_condition["file_id"] = $id;
        $query = "UPDATE $this->table SET $column = '' WHERE";

        return DB::statement($query." ".$where_condition,$apply_condition);
    }

    //Private Limited
    public function private_comp_docs_status()
    {
        $where_condition = "comp_pan_card <>'' AND comp_gst_doc <>'' AND bank_statement <>''
        AND cin_doc<>'' AND aoa_doc <>'' AND mer_pan_card<>''
        AND mer_aadhar_card<>'' AND moa_doc<>'' 
        AND created_merchant=:id";
        $apply_condition["id"] = Auth::user()->id;

        $query = "SELECT count(*) as all_document_uploaded FROM merchant_document WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);
    }

    //Proprietorship
    public function proprietor_comp_docs_status()
    {
        $where_condition = "bank_statement <>'' AND mer_pan_card<>''
        AND mer_aadhar_card<>'' AND moa_doc<>'' AND comp_gst_doc <>''
        AND created_merchant=:id";
        $apply_condition["id"] = Auth::user()->id;

        $query = "SELECT count(*) as all_document_uploaded FROM merchant_document WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);
    }
    // Partnership,Public Limited,LLP
    public function llp_comp_docs_status()
    {
        $where_condition = "mer_pan_card<>'' AND comp_pan_card <>''
        AND mer_aadhar_card<>'' AND comp_gst_doc <>''
        AND created_merchant=:id";
        $apply_condition["id"] = Auth::user()->id;

        $query = "SELECT count(*) as all_document_uploaded FROM merchant_document WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);
    }
    //Trust,NGO
    public function nonreg_comp_docs_status()
    {
        $where_condition = "mer_pan_card<>'' AND comp_pan_card <>''
        AND mer_aadhar_card<>''
        AND created_merchant=:id";
        $apply_condition["id"] = Auth::user()->id;

        $query = "SELECT count(*) as all_document_uploaded FROM merchant_document WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);
    }


    public function private_comp_docs()
    {
        $where_condition = "created_merchant=:id";
        $apply_condition["id"] = Auth::user()->id;

        $query = "SELECT id,comp_pan_card, comp_gst_doc, bank_statement, cin_doc, aoa_doc, 
        mer_pan_card, mer_aadhar_card, moa_doc 
        FROM merchant_document WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);
    }

    public function proprietor_comp_docs()
    {
        $where_condition = "created_merchant=:id";
        $apply_condition["id"] = Auth::user()->id;

        $query = "SELECT id,comp_pan_card, comp_gst_doc, bank_statement, cin_doc, aoa_doc, 
        mer_pan_card, mer_aadhar_card, moa_doc 
        FROM merchant_document WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);
    }

    public function documents(){

        $where_condition = "created_merchant=:id";
        $apply_condition["id"] = Auth::user()->id;

        $query = "SELECT id,comp_pan_card, comp_gst_doc, bank_statement, cin_doc, aoa_doc, 
        mer_pan_card, mer_aadhar_card, moa_doc,cancel_cheque,partnership_deed
        ,llp_agreement,registration_doc,trust_constitutional,no_objection_doc 
        FROM merchant_document WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);
    }

    public function get_doc_name($column){

        return DB::table($this->table)->where("created_merchant",Auth::user()->id)->select($column)->value($column);
    }


    private function _private_comp_docs_status($id)
    {
        $where_condition = "created_merchant=:id";
        $apply_condition["id"] = $id;

        $query = "SELECT comp_pan_card,comp_gst_doc,bank_statement,cin_doc,aoa_doc,mer_pan_card,mer_aadhar_card,moa_doc FROM merchant_document WHERE $where_condition";

        return DB::select($query,$apply_condition);
    }

    private function _proprietor_comp_docs_status($id)
    {
        $where_condition = "created_merchant=:id";
        $apply_condition["id"] = $id;

        $query = "SELECT bank_statement,mer_pan_card,mer_aadhar_card,moa_doc,comp_gst_doc FROM 
        merchant_document WHERE $where_condition";

        return DB::select($query,$apply_condition);
    }

    private function _public_comp_docs_status($id){

        $where_condition = "created_merchant=:id";
        $apply_condition["id"] = $id;

        $query = "SELECT comp_pan_card,comp_gst_doc,mer_pan_card,mer_aadhar_card,bank_statement,cancel_cheque,cin_doc,moa_doc,aoa_doc FROM 
        merchant_document WHERE $where_condition";

        return DB::select($query,$apply_condition);
    }

    private function _llp_comp_docs_status($id)
    {
        $where_condition = "created_merchant=:id";
        $apply_condition["id"] = $id;

        $query = "SELECT mer_pan_card,comp_pan_card ,mer_aadhar_card,comp_gst_doc FROM merchant_document WHERE $where_condition";

        return DB::select($query,$apply_condition);
    }

    private function _nonreg_comp_docs_status($id)
    {
        $where_condition = "created_merchant=:id";
        $apply_condition["id"] = $id;

        $query = "SELECT mer_pan_card,comp_pan_card,mer_aadhar_card FROM 
        merchant_document WHERE $where_condition";

        return DB::select($query,$apply_condition);
    }

    public function get_docs_by_bustype($typeid,$id){

        switch ($typeid) {
            case '1':
                return $this->_private_comp_docs_status($id);
                break;
            case '2':
                return $this->_proprietor_comp_docs_status($id);
                break;
            case '3':
                return $this->_llp_comp_docs_status($id);
                break;
            case '4':
                return $this->_public_comp_docs_status($id);
                break;
            case '5':
                return $this->_llp_comp_docs_status($id);
                break;
            case '6':
                return $this->_llp_comp_docs_status($id);
                break;
            case '7':
                return $this->_nonreg_comp_docs_status($id);
                break;
            case '8':
                return $this->_nonreg_comp_docs_status($id);
                break;
            case '9':
                return $this->_nonreg_comp_docs_status($id);
                break;
           
            default:
                # code...
                break;
        }
    }

    public function get_merchants_document(){
        
        // $query="SELECT $this->jointableone.name,$this->jointableone.merchant_gid,$this->jointabletwo.business_name,$this->jointablethree.type_name,
        // verified_status,$this->jointableone.id as merchant_id,DATE_FORMAT($this->table.created_date,'%Y-%m-%d %h:%i:%s %p') as created_date 
        // FROM $this->table
       
        // LEFT JOIN $this->jointableone ON $this->jointableone.id = $this->table.created_merchant
        
        // LEFT JOIN $this->jointabletwo ON $this->jointabletwo.created_merchant = $this->table.created_merchant
        
        // LEFT JOIN $this->jointablethree ON $this->jointablethree.id = $this->jointabletwo.business_type_id WHERE
        // $this->jointableone.name IS NOT NULL
        // Group BY $this->table.created_merchant ORDER BY $this->table.created_date DESC ";

        $query = "SELECT 
        m.id AS merchant_id,
        m.merchant_gid,
        m.name, 
        m.bg_verified,
        m.doc_verified,
        m.is_verified,
        m.is_email_verified,
        m.is_mobile_verified,
        m.merchant_status,
        m.created_date AS merchant_created_date,
        mb.business_name,
        md.verified_status,
        bt.type_name
      FROM merchant m
      LEFT JOIN merchant_document md ON m.id = md.created_merchant
      LEFT JOIN merchant_business mb ON md.created_merchant = mb.created_merchant
      LEFT JOIN business_type bt ON mb.business_type_id = bt.id
      ORDER BY m.created_date DESC";

    // dd(DB::select($query));

        return DB::select($query);
    } 

    public function get_approved_merchants(){
        
        $query="SELECT $this->jointableone.id,$this->jointableone.name,$this->jointableone.merchant_gid,$this->jointabletwo.business_name,$this->jointablethree.type_name,
        IF($this->jointableone.app_mode<>0,'Live','Test') as app_mode,IF($this->jointableone.change_app_mode<>'N','Enabled','Not Enabled') as change_app_mode,$this->jointableone.merchant_status,$this->jointableone.id as merchant_id,DATE_FORMAT($this->table.created_date,'%Y-%m-%d %h:%i:%s %p') as created_date FROM $this->table
        LEFT JOIN $this->jointableone ON $this->jointableone.id = $this->table.created_merchant
        LEFT JOIN $this->jointabletwo ON $this->jointabletwo.created_merchant = $this->table.created_merchant
        LEFT JOIN $this->jointablethree ON $this->jointablethree.id = $this->jointabletwo.business_type_id 
        WHERE $this->table.verified_status='approved' ORDER BY $this->table.created_date DESC";

        return DB::select($query);
    }

    

}
