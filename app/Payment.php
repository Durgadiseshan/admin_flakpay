<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;
use Carbon\Carbon;
use Auth;
use DateTime;

class Payment extends Model
{

    protected $table;

    protected $jointable1;

    public $primarykey = 'id';

    protected $table_prefix = "live";

    protected $requestresp = "atom_response";

    protected $merchantId;

    protected $empId;

    public function __construct()
    {

        if (Auth::guard("merchantemp")->check()) {

            $this->table_prefix = "live";

            $this->merchantId = Auth::guard("merchantemp")->user()->created_merchant;

            $this->empId = Auth::guard("merchantemp")->user()->id;
        } else {

            if (Auth::check() && Auth::user()->app_mode == 1) {
                $this->table_prefix = "live";
                $this->merchantId = Auth::user()->id;
            }
        }

        $this->table = $this->table_prefix . "_payment";
        $this->jointable1 = $this->table_prefix . "_order";
    }

    public function get_all_payments($filters = array())
    {

        $where_condition = 'payment.created_merchant=:id';
        $apply_condition['id'] =  Auth::user()->id;

        if (!empty($filters)) {
            if (!empty($filters["transaction_gid"])) {
                $where_condition .=  ' AND payment.transaction_gid=:pay_gid';
                $apply_condition['pay_gid'] = $filters["transaction_gid"];
            }
            if (!empty($filters["payment_status"])) {
                $where_condition .=  ' AND payment.payment_status=:pay_status';
                $apply_condition['pay_status'] = $filters["payment_status"];
            }
            if (!empty($filters["payment_email"])) {
                $where_condition .=  ' AND payment.payment_email=:pay_email';
                $apply_condition['pay_email'] = $filters["payment_email"];
            }
        }


        // return DB::select('SELECT payment_gid,'.$this->table_prefix.'_order.order_gid,payment_method,payment_email,payment_contact,payment_amount,payment_status,'.$this->table_prefix.'_payment.created_date FROM '.$this->table_prefix.'_payment 
        // LEFT JOIN '.$this->table_prefix.'_order ON '.$this->table_prefix.'_order.id = '.$this->table_prefix.'_payment.order_id WHERE '.$this->table_prefix.'_payment.created_merchant=:id 
        // '.$where_condition,['id'=>Auth::user()->id]);
        //DB::enableQueryLog();

        $repsonse = DB::select('SELECT payment.id,transaction_gid,`order`.order_gid,transaction_email,transaction_contact,transaction_amount,transaction_status,DATE_FORMAT(payment.created_date,"%d-%m-%Y %h:%i:%s %p") as created_date,IF(payment.created_employee <> 0,merchant_employee.employee_name,merchant.name) as created_merchant  FROM ' . $this->table_prefix . '_payment payment
        LEFT JOIN ' . $this->table_prefix . '_order `order` ON `order`.id = payment.order_id 
        INNER JOIN merchant ON merchant.id = payment.created_merchant
        LEFT JOIN merchant_employee ON merchant_employee.id = payment.created_employee
        WHERE ' . $where_condition . ' ORDER BY payment.created_date DESC', $apply_condition);

        $payments = array_map(function ($row) {
            $dateTime = DateTime::createFromFormat('d-m-Y h:i:s A', $row->created_date);
            $row->created_date = $dateTime->format('d-m-Y');
            $row->created_time = $dateTime->format('h:i:s A');
            return $row;
        }, $repsonse);

        return $payments;

        //dd(DB::getQueryLog());

    }

    public function get_all_paymentsbackup()
    {
        return DB::table($this->table . ' as payment')->select(
            "payment.id",
            "transaction_gid",
            "order.order_gid",
            "transaction_email",
            "transaction_contact",
            "transaction_amount",
            "transaction_status",
            DB::raw('DATE_FORMAT(payment.created_date,"%d-%m-%Y %h:%i:%s %p") as created_date')
        )
            ->leftJoin($this->jointable1 . ' as order', 'order.id', '=', 'payment.order_id')
            ->where('payment.created_merchant', '=', Auth::user()->id)
            ->orderByDesc('payment.created_date')->simplePaginate(10);
    }


    public function get_payment($id)
    {
        $where_condition = "payment.id=:id AND payment.created_merchant=:merchant_id";
        $apply_condition["id"] = $id;
        $apply_condition["merchant_id"] = $this->merchantId;

        $query = 'SELECT transaction_gid,`order`.order_gid,transaction_email,transaction_contact,transaction_amount,IFNULL(transaction_status,"") as transaction_status,DATE_FORMAT(payment.created_date,"%d-%m-%Y %h:%i:%s %p") as created_date  FROM ' . $this->table_prefix . '_payment payment
        LEFT JOIN ' . $this->table_prefix . '_order `order` ON `order`.id = payment.order_id WHERE';

        return DB::select($query . " " . $where_condition, $apply_condition);
    }

    public function get_dashboard_payments($from_date = "", $to_date = "")
    {


        $limit_clause = "";
        $where_condition = 'payment.created_merchant=:id';
        $apply_condition['id'] =  Auth::user()->id;

        if (!empty($from_date)) {
            $where_condition .=  ' AND DATE_FORMAT(payment.created_date,"%Y-%m-%d")>=:from_date';
            $apply_condition['from_date'] = $from_date;
        }
        if (!empty($to_date)) {
            $where_condition .=  ' AND DATE_FORMAT(payment.created_date,"%Y-%m-%d")<=:to_date';
            $apply_condition['to_date'] = $to_date;
        }

        //DB::enableQueryLog();

        return DB::select('SELECT transaction_gid,transaction_email,transaction_contact,transaction_amount,transaction_status,DATEDIFF(now(),payment.created_date) as date_diff FROM ' . $this->table_prefix . '_payment payment
        WHERE ' . $where_condition . ' ORDER BY payment.created_date DESC ' . $limit_clause, $apply_condition);
        //dd(DB::getQueryLog());

    }


     

    public function graph_amount_of_payments($from_date = "", $to_date = "")
    {
            $get_user_merchant=DB::table('user_keys')->where('mid',Auth::user()->id)->first();
            $where_condition = "payment.merchant_id=:merchant_id AND txn_status='2'";
            $apply_condition['merchant_id'] =  $get_user_merchant->test_mid;//Auth::user()->id;

            if (!empty($from_date)) {
                $where_condition .=  " AND DATE_FORMAT(payment.created_at,'%Y-%m-%d')>=:from_date";
                $apply_condition['from_date'] = $from_date;
            }
            if (!empty($to_date)) {
                $where_condition .=  " AND DATE_FORMAT(payment.created_at,'%Y-%m-%d')<=:to_date";
                $apply_condition['to_date'] = $to_date;
            }
            //0 -test mode
            //1-Live mode
        if(Auth::user()->app_mode == 0){
            $total_payments_amount = "SELECT sum(amount) as amount,MONTHNAME(created_at) as month FROM test_payintransactions as payment WHERE";

            return DB::select($total_payments_amount . " " . $where_condition . " GROUP BY MONTH(created_at)", $apply_condition);
        }else{
            $total_payments_amount = "SELECT sum(amount) as amount,MONTHNAME(created_at) as month FROM payin_transactions as payment WHERE";

            return DB::select($total_payments_amount . " " . $where_condition . " GROUP BY MONTH(created_at)", $apply_condition);
        }
        

        // $where_condition = "payment.created_merchant=:id AND transaction_status='success'";
        // $apply_condition['id'] =  Auth::user()->id;

        // if (!empty($from_date)) {
        //     $where_condition .=  " AND DATE_FORMAT(payment.created_date,'%Y-%m-%d')>=:from_date";
        //     $apply_condition['from_date'] = $from_date;
        // }
        // if (!empty($to_date)) {
        //     $where_condition .=  " AND DATE_FORMAT(payment.created_date,'%Y-%m-%d')<=:to_date";
        //     $apply_condition['to_date'] = $to_date;
        // }

        // //DB::enableQueryLog();

        // $total_payments_amount = "SELECT sum(transaction_amount) as amount,MONTHNAME(created_date) as month FROM $this->table as payment WHERE";

        // return DB::select($total_payments_amount . " " . $where_condition . " GROUP BY MONTH(created_date)", $apply_condition);

        //dd(DB::getQueryLog());
        //exit;

    }


    public function graph_success_rate($from_date = "", $to_date = "")
    {
        // $convert = Carbon::parse($to_date)->format('Y-m-d H:i:s');

        $data = DB::table('live_payment');

        if (!empty($from_date)) {
            $data = $data->where('transaction_date', '>=',  Carbon::parse($from_date)->format('Y-m-d'));
        }
        if (!empty($to_date)) {
            $data = $data->where('transaction_date', '<=',  Carbon::parse($to_date)->format('Y-m-d'));
        }

        $data = $data->select('transaction_status', DB::raw('count(*) as total'))
            ->groupBy('transaction_status')
            ->get();

        return $data;
    }

    public function summary_data_count($from_date = "", $to_date = "")
    {
        //$this->table = $this->table_prefix . "_payment";
        $get_user_merchant=DB::table('user_keys')->where('mid',Auth::user()->id)->first();
        if(Auth::user()->app_mode == 0){ 
            $merchant_id=$get_user_merchant->test_mid;
        }else{
            $merchant_id=$get_user_merchant->prod_mid;
        }
        $data = DB::table('test_payintransactions');

        $data = $data->where('merchant_id','=',$merchant_id);

        $data = $data->where('txn_status','=',2);
        

        if (!empty($from_date)) {
            $data = $data->where('created_at', '>=',  Carbon::parse($from_date)->format('Y-m-d'));
        }
        if (!empty($to_date)) {
            $data = $data->where('created_at', '<=',  Carbon::parse($to_date)->format('Y-m-d'));
        }

        $data = $data->select('txn_status as transaction_status', DB::raw('count(*) as total'))
            //->groupBy('txn_status')
            ->get();

        return $data;

        // $convert = Carbon::parse($to_date)->format('Y-m-d H:i:s');
        // $this->table = $this->table_prefix . "_payment";
        // $data = DB::table($this->table);

        // $data = $data->where('created_merchant','=',Auth::user()->id);

        // $data = $data->where('transaction_description','!=',null);
        

        // if (!empty($from_date)) {
        //     $data = $data->where('transaction_date', '>=',  Carbon::parse($from_date)->format('Y-m-d'));
        // }
        // if (!empty($to_date)) {
        //     $data = $data->where('transaction_date', '<=',  Carbon::parse($to_date)->format('Y-m-d'));
        // }

        // $data = $data->select('transaction_status', DB::raw('count(*) as total'))
        //     ->groupBy('transaction_status')
        //     ->get();

        // return $data;
    }

    public function summary_payment_mode($from_date = "", $to_date = "")
    {
         $this->table = $this->table_prefix . "_payment";
        $data = DB::table($this->table);

        $data = $data->where('created_merchant','=',Auth::user()->id);

        if (!empty($from_date)) {
            $data = $data->where('transaction_date', '>=',  Carbon::parse($from_date)->format('Y-m-d'));
        }
        if (!empty($to_date)) {
            $data = $data->where('transaction_date', '<=',  Carbon::parse($to_date)->format('Y-m-d'));
        }

        $data = $data->select('transaction_mode', DB::raw('count(*) as total'))
            ->groupBy('transaction_mode')
            ->get();

        foreach ($data as $datas) {
            if ($datas->transaction_mode === 'CC') {
                $datas->transaction_mode = 'Credit Card';
            }

            if ($datas->transaction_mode === null) {
                $datas->transaction_mode = 'Cancelled';
            }


            if ($datas->transaction_mode === 'NB') {
                $datas->transaction_mode = 'Net Banking';
            }


            if ($datas->transaction_mode === 'MW') {
                $datas->transaction_mode = 'Merchant Wallet';
            }
        }



        return $data;
    }


    public function graph_payment_mode($from_date = "", $to_date = "")
    {
        $data = DB::table('live_payment');

        if (!empty($from_date)) {
            $data = $data->where('transaction_date', '>=',  Carbon::parse($from_date)->format('Y-m-d'));
        }
        if (!empty($to_date)) {
            $data = $data->where('transaction_date', '<=',  Carbon::parse($to_date)->format('Y-m-d'));
        }

        $data = $data->select('transaction_mode', DB::raw('count(*) as total'))
            ->groupBy('transaction_mode')
            ->get();

        foreach ($data as $datas) {
            if ($datas->transaction_mode === 'CC') {
                $datas->transaction_mode = 'Credit Card';
            }

            if ($datas->transaction_mode === null) {
                $datas->transaction_mode = 'Cancelled';
            }


            if ($datas->transaction_mode === 'NB') {
                $datas->transaction_mode = 'Net Banking';
            }


            if ($datas->transaction_mode === 'MW') {
                $datas->transaction_mode = 'Merchant Wallet';
            }
        }



        return $data;
    }


    public function graph_no_of_payments($from_date = "", $to_date = "")
    {


        $where_condition = "payment.created_merchant=:id AND transaction_status='success'";
        $apply_condition['id'] =  Auth::user()->id;

        if (!empty($from_date)) {
            $where_condition .=  " AND DATE_FORMAT(payment.created_date,'%Y-%m-%d')>=:from_date";
            $apply_condition['from_date'] = $from_date;
        }
        if (!empty($to_date)) {
            $where_condition .=  " AND DATE_FORMAT(payment.created_date,'%Y-%m-%d')<=:to_date";
            $apply_condition['to_date'] = $to_date;
        }

        //DB::enableQueryLog();

        $total_payments_amount = "SELECT COUNT(1) as no_of_transactions,MONTHNAME(created_date) as month FROM $this->table as payment WHERE";

        return DB::select($total_payments_amount . " " . $where_condition . " GROUP BY MONTH(created_date)", $apply_condition);

        //dd(DB::getQueryLog());
        //exit;

    }

    public function current_transaction_amount()
    {

        $query = "SELECT SUM(transaction_amount) as current_amount FROM $this->table WHERE transaction_status='success' AND adjustment_done='N'
        AND created_merchant=:merchant_id";
        $apply_condition["merchant_id"] = Auth::user()->id;
        return DB::select($query, $apply_condition);
    }

    public function total_transaction_amount($merchant_id)
    {
        $query = "SELECT SUM(transaction_amount) as current_amount FROM live_payment WHERE transaction_status='success' AND adjustment_done='N'
        AND created_merchant=:merchant_id";
        $apply_condition["merchant_id"] = $merchant_id;
        return DB::select($query, $apply_condition);
    }


    public function get_merchant_transactions($id)
    {

        $where_condition = "created_merchant=:id AND adjustment_done='N' AND transaction_status='success' ORDER BY created_date DESC";
        $apply_condition["id"] = $id;

        $query = "SELECT transaction_gid FROM live_payment WHERE";

        return DB::select($query . " " . $where_condition, $apply_condition);
    }

    public function get_transactions_details($transaction_id)
    {

        $where_condition = "transaction_gid=:id AND adjustment_done='N' AND transaction_status='success'";
        $apply_condition["id"] = $transaction_id;

        $query = "SELECT IFNULL(mmp_txn,'') as mmp_txn,IFNULL(amt,'') amt,IFNULL(bank_txn,'') bank_txn,IFNULL(bank_name,'') bank_name,IFNULL(discriminator,'') discriminator,IFNULL(DATE_FORMAT(transaction_date,'%Y-%m-%d'),'') transaction_date FROM live_payment LEFT JOIN  
        $this->requestresp ON $this->requestresp.mer_txn = live_payment.transaction_gid WHERE";

        return DB::select($query . " " . $where_condition, $apply_condition);
    }

    public function update_transaction_adjustment($transaction_id)
    {

        return DB::table("live_payment")->where(["transaction_gid" => $transaction_id])->update(["adjustment_done" => 'Y']);
    }


    public function live_success_transactions($filter)
    {

        $where_condition = "";
        $apply_condition = [];

        if (!empty($filter["transaction_date"])) {
            $where_condition .= " AND DATE_FORMAT(transaction_date,'%Y-%m-%d')=:d";
            $apply_condition["d"] = $filter["transaction_date"];
        }

        if (!empty($filter["merchant_id"])) {
            $where_condition .= " AND created_merchant=:mid";
            $apply_condition["mid"] = $filter["merchant_id"];
        }

        if (!empty($filter["transaction_gid"])) {
            $where_condition .= " AND transaction_gid=:tid";
            $apply_condition["tid"] = $filter["transaction_gid"];
        }

        //DB::enableQueryLog();

        $query = "SELECT transaction_gid,transaction_amount,DATE_FORMAT(transaction_date,'%Y-%m-%d') as transaction_date,vendor_transaction_id,transaction_mode FROM live_payment WHERE transaction_status='success' AND adjustment_done='N' $where_condition";

        //dd(DB::getQueryLog());

        return DB::select($query, $apply_condition);
    }


    public function get_emp_payments($merchantId, $empId)
    {


        $where_condition = 'payment.created_merchant=:id AND payment.created_employee=:empid';
        $apply_condition['id'] = $merchantId;
        $apply_condition['empid'] = $empId;

        //DB::enableQueryLog();

        $query = "SELECT payment.id,transaction_gid,`order`.order_gid,transaction_email,transaction_contact,transaction_amount,transaction_status,DATE_FORMAT(payment.created_date,'%d-%m-%Y %h:%i:%s %p') as created_date  FROM live_payment payment LEFT JOIN live_order `order` ON `order`.id = payment.order_id WHERE $where_condition ORDER BY payment.created_date DESC";

        return DB::select($query, $apply_condition);

        //dd(DB::getQueryLog());    

    }

    public function get_transactions_bydate($fromdate, $todate)
    {

        $where_condition = 'DATE_FORMAT(payment.transaction_date,"%Y-%m-%d")>=:fromdate AND DATE_FORMAT(payment.transaction_date,"%Y-%m-%d")<=:todate AND transaction_status ="success" AND adjustment_done="N"';
        $apply_condition['fromdate'] = $fromdate;
        $apply_condition['todate'] = $todate;

        //DB::enableQueryLog();

        $query = "SELECT merchant.merchant_gid,payment.id,transaction_gid,transaction_amount,transaction_status,DATE_FORMAT(payment.transaction_date,'%d-%m-%Y %h:%i:%s %p') as transaction_date,transaction_mode,
        transaction_type,payment.created_merchant,IF(merchant_business.state=36,'IGST&SGST(%9+%9)','GST(%18)') as transaction_gst  FROM live_payment payment 
        LEFT JOIN merchant ON merchant.id = payment.created_merchant
        LEFT JOIN merchant_business ON merchant_business.created_merchant = payment.created_merchant 
        WHERE $where_condition ORDER BY payment.transaction_date DESC";

        return DB::select($query, $apply_condition);

        //dd(DB::getQueryLog());
    }

    public function get_transactions_bydaterange($fromdate, $todate)
    {

        // $where_condition = 'DATE_FORMAT(p.created_date,"%Y-%m-%d")>=:fromdate AND DATE_FORMAT(p.created_date,"%Y-%m-%d")<=:todate AND p.created_merchant=:id';
        // $apply_condition['fromdate'] = $fromdate;
        // $apply_condition['todate'] = $todate;
        // $apply_condition['id'] = Auth::user()->id;;

        // //DB::enableQueryLog();

        // $query = 'SELECT p.transaction_gid,`order`.order_gid,p.transaction_type,p.transaction_username,p.transaction_email,p.transaction_contact,p.transaction_amount,p.transaction_status,p.transaction_mode,p.created_date  FROM ' . $this->table_prefix . '_payment p
        // LEFT JOIN ' . $this->table_prefix . '_order `order` ON `order`.id = p.order_id WHERE';

        // return DB::select($query . " " . $where_condition, $apply_condition);
        // //return DB::select($query,$apply_condition);

        // //dd(DB::getQueryLog());
        $fromdate = date('Y-m-d', strtotime($fromdate));
        $todate = date('Y-m-d', strtotime($todate));

        $id = Auth::user()->id;
        $merchant = DB::table('merchant')
                ->select('fpay_id')
                ->where('merchant.id', $id)
                ->first();
                $merchantid = $merchant->fpay_id;

        $query = DB::table('payin_transactions')
            ->select('payin_transactions.customer_name', 'payin_transactions.mobile_no', 'payin_transactions.amount', 'payin_transactions.email', 'payin_transactions.upi_id', 'payin_transactions.order_id', 'payin_transactions.fpay_trxnid','payin_transactions.txn_status', 'payin_transactions.created_at', 'payin_transactions.updated_at') 
            ->join('merchant', 'payin_transactions.merchant_id', '=', 'merchant.fpay_id')
            ->where('payin_transactions.merchant_id', $merchantid)
            ->whereBetween(DB::raw('DATE_FORMAT(payin_transactions.created_at, "%Y-%m-%d")'), [$fromdate, $todate])
            
            ->get();

    foreach ($query as $datas) {
        if ($datas->txn_status == '1') {
            $datas->txn_status = 'Pending';
        }

        if ($datas->txn_status == '2') {
            $datas->txn_status = 'Success';
        }


        if ($datas->txn_status == '0') {
            $datas->txn_status = 'Failed';
        }


        if ($datas->txn_status == '3') {
            $datas->txn_status = 'Tampered';
        }
    }
        return $query;
    }


    public function merchant()
    {
        return $this->belongsTo(Merchant::class,'created_merchant','id');
    }
}
