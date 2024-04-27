<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class RyaPayInvoice extends Model
{


    protected $table;

    protected $jointable1;

    protected $jointable2;

    protected $jointable3;

    protected $jointable4;

    public $primarykey = 'id';

    private $empGuard;

    public function __construct(){

        $this->table_prefix = "ryapay";
        
        $this->table = $this->table_prefix."_invoice";

        $this->jointable1 = $this->table_prefix."_invoice_item";

        $this->jointable2 = $this->table_prefix."_customer";

        $this->jointable3 = $this->table_prefix."_customer_address";

        $this->jointable4 = "state";

        $this->empGuard = auth()->guard("employee")->user();

    }


    public function get_all_invoices($filters=array()){

        $where_condition = "invoice.created_user=:id";
        $apply_condition["id"] = $this->empGuard->id;

        if(!empty($filters))
        {
            if(!empty($filters["invoice_gid"]))
            {
                $where_condition.= " AND invoice.invoice_gid=:gid";
                $apply_condition["gid"] = $filters["invoice_gid"];
            }

            if(!empty($filters["invoice_receiptno"]))
            {
                $where_condition .= " AND invoice.invoice_receiptno=:rct_no";
                $apply_condition["rct_no"] = $filters["invoice_receiptno"];
            }

            if(!empty($filters["customer_email"]))
            {
                $where_condition .= " AND customer.customer_email=:email";
                $apply_condition["email"] = $filters["customer_email"];
            }

            if(!empty($filters["customer_phone"]))
            {
                $where_condition .= " AND customer.customer_phone=:mobile";
                $apply_condition["mobile"] = $filters["customer_phone"];
            }

            if(!empty($filters["invoice_status"]))
            {
                $where_condition .= " AND invoice.invoice_status=:inv_status";
                $apply_condition["inv_status"] = $filters["invoice_status"];
            }
        }


        return DB::select('SELECT invoice.id,invoice_gid,invoice_receiptno,invoice_amount,
        CONCAT(customer.customer_name,"(",customer.customer_email,"/",customer.customer_phone,")")customer_details,
        invoice.invoice_payid,invoice.invoice_paylink,invoice_status,invoice.created_date,invoice.created_user FROM '.$this->table_prefix.'_invoice invoice
        LEFT JOIN '.$this->table_prefix.'_customer customer ON customer.id = invoice.invoice_billing_to
        WHERE '.$where_condition.' ORDER BY invoice.created_date DESC',$apply_condition);
    
    }

    public function add_invoice($invoicedetails)
    {
       return DB::table($this->table)->insertGetId($invoicedetails);
    }

    public function update_invoice($invoicedetails,$invoice_id)
    {
       return DB::table($this->table)->where("id","=",$invoice_id)->update($invoicedetails);
    }

    public function get_invoice($id)
    {

        $where_condition = "invoice.id=:id AND invoice.created_user=:emp_id AND customer.`status`='active' AND customer_bill.`status`='active' AND customer_ship.`status`='active'";
        $apply_condition["id"] = $id;
        $apply_condition["emp_id"] = $this->empGuard->id;


        $query = "SELECT invoice.id,company,gstno,panno,invoice_receiptno,invoice_subtotal,invoice_amount,invoice_tax_amount,tax_applied,invoice.customer_gstno,invoice.customer_email,invoice.customer_phone,
                invoice_billing_address,invoice_shipping_address,DATE_FORMAT(invoice_issue_date,'%Y-%m-%d') as invoice_issue_date,
                invoice_billing_to,invoice_item.item_id,invoice_item.item_amount,invoice_item.item_quantity,invoice_item.item_total,customer.id as customer_id,customer.customer_name,
                CONCAT_WS(' ',customer_bill.address,customer_bill.pincode,customer_bill.city,state_bill.state_name) as billing_address,
                CONCAT_WS(' ',customer_ship.address,customer_ship.pincode,customer_ship.city,state_ship.state_name) as shipping_address,
                state_ship.id as state_id
                FROM $this->table invoice 
                LEFT JOIN $this->jointable1 invoice_item on invoice_item.invoice_id = invoice.id
                LEFT JOIN $this->jointable2 customer on customer.id = invoice.invoice_billing_to
                LEFT JOIN $this->jointable3 customer_bill on customer_bill.id = invoice.invoice_billing_address
                LEFT JOIN $this->jointable3 customer_ship on customer_ship.id = invoice.invoice_shipping_address
                LEFT JOIN $this->jointable4 state_bill on state_bill.id = customer_bill.state_id
                LEFT JOIN $this->jointable4 state_ship on state_ship.id = customer_ship.state_id WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);
    
    }
}
