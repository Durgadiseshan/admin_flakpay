<?php

namespace App\Http\Controllers;


use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use App\Imports\InvItemImport;
use App\Imports\PaylinkImport;
use App\Imports\PayoutContactsImport;
use App\Imports\PayoutBeneficiariesImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Notifications\Messages\MailMessage;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Schema;
use App\Exports\MerchantTransactionExport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Hash;
use App\Classes\GenerateLogs;
use Carbon\Carbon;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\NotiMessController;
use App\Mail\SendMail;
use App\User;
use App\Payment;
use App\Order;
use App\Refund;
use App\Dispute;
use App\PayoutContacts;
use App\PayoutBeneficiaries;
use App\PayoutTransaction;
use App\PayoutBeneficiaryGroup;
use App\PayoutAccount;
use App\PayoutWallet;
use App\AddFund;
use App\Payout;
use App\Settlement;
use App\Invoice;
use App\Item;
use App\Paylink;
use App\Customer;
use App\CustomerAddress;
use App\BusinessType;
use App\BusinessCategory;
use App\BusinessSubCategory;
use App\MerchantBusiness;
use App\State;
use App\InvoiceItem;
use App\MerchantApi;
use App\Reminder;
use App\Webhook;
use App\MerchantSupport;
use App\MerchantFeedback;
use App\MerchantServices;
use App\MerchantVendorBank;
use DB;
use App\MerchantLogActivity;
use App\Product;
use App\CustomerCase;
use App\CaseComment;
use App\CouponOption;
use App\Currency;
use App\MerchantCoupon;
use App\MerchantDocument;
use App\PaymentPage;
use App\PaymentPageInput;
use App\AppOption;
use App\MerchantEmployee;
use App\Classes\EmailSmsLogs;
use App\Classes\CashfreeApi;
use App\TransactionReportLog;
use Auth;
use File;
//use Illuminate\Support\Facades\Http;






class MerchantController extends Controller
{

    private $filter_applied = FALSE;

    protected $date_time;

    private $invoice_count;

    private $invoice_date;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        

 
        // $this->middleware('auth');
        $this->middleware('TwoFA');
        $this->middleware('SessionTimeOut');
        $this->date_time = date("Y-m-d H:i:s");
        $this->today = date('d-m-Y');
        $this->invoice_date = date("Ymd");
        //$this->date_time = Carbon::now();
    }

    public function sendSmstest(){
        $OTP=1234;
        $mobilemessage = "Hi Aditya tadas, Use this OTP ".$OTP." for changing PAYFLASH account password. -PAYFLASH";

        $sms =  sendSMS("8668246493",$mobilemessage,"1707165208028776517");


            die();
    }


    public function graph_success_rate($from_date = "", $to_date = "")
    {
        // dd(Carbon::parse('2023-05-06')->format('Y-m-d H:i:s'));

        $data = DB::table('live_payment');


        $data = $data->where('transaction_date', '>=',  Carbon::parse('2022-05-13')->format('Y-m-d'));


        $data = $data->where('transaction_date', '<=',  Carbon::parse('2022-07-12')->format('Y-m-d'));


        $data = $data->select('transaction_status', DB::raw('count(*) as total'))
            ->groupBy('transaction_status')
            ->get();

        dd($data);

        return $data;
    }

    public function apitest(Request $request)
    {
        $api = new CashfreeApi();
        //$api_res=$api->get_order_info('YBBUzp7FvRnL0QkI21H5cJjs');
        // $api_res=$api->get_order_status('YBBUzp7FvRnL0QkI21H5cJjs');
        // $data = array(
        //     "refund_amount" => 1.00,
        //     "refund_id" => "refund_" . Str::random(16) . time(),
        //     "refund_note" => "test",
        //     "merchant_id" => 1,
        //     "payment_id" => 1,
        //     "order_id" => 'YB42a50650020220916030824041111',
        //     'user_id' => Auth::user()->id
        // );
        // $r = $api->initiate_refund($data);
        
        //  $api->get_order_refunds('YBBUzp7FvRnL0QkI21H5cJjs');
        $api->get_order_settlements('YBBUzp7FvRnL0QkI21H5cJjs');
        dd($r);
        echo 43636;
        die();
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {



        $dashboard = array();
        

        $module = "";
 
        if ($request->ajax()) {
            $dates = $request->except("_token");

            $module = $request->module;

            $perpage = $request->perpage;

            if (empty($request->dash_date_range) && empty($request->dash_date_range_summary)) {

                $startDate = time();

                $dates["dash_from_date"] = date('Y-m-d', strtotime('-6 days', $startDate));

                $dates["dash_to_date"] = date("Y-m-d");
            }
            session(['dash_from_date' => $dates["dash_from_date"], 'dash_to_date' => $dates["dash_to_date"]]);

            switch ($module) {

                case 'dash_graph':

                    $transaction = new Payment();
                    $settlement = new Settlement();
                    $transactions['payment_amount'] = $transaction->graph_amount_of_payments($dates["dash_from_date"], $dates["dash_to_date"]);
                    $transactions['success_rate'] = $transaction->graph_success_rate($dates["dash_from_date"], $dates["dash_to_date"]);
                    $transactions['payment_mode'] = $transaction->graph_payment_mode();
                    $transactions['payment_number'] = $transaction->graph_no_of_payments($dates["dash_from_date"], $dates["dash_to_date"]);
                    $transactions['settlement_number'] = $settlement->graph_no_of_settlements($dates["dash_from_date"], $dates["dash_to_date"]);
                    echo json_encode($transactions);
                    break;

                case 'dash_summary':

                    $transaction = new Payment();
                    $settlement = new Settlement();
                    $transactions['payment_amount'] = $transaction->graph_amount_of_payments($dates["dash_from_date"], $dates["dash_to_date"]);
                    $transactions['success_rate'] = $transaction->summary_data_count($dates["dash_from_date"], $dates["dash_to_date"]);
                    $transactions['payment_mode'] = $transaction->summary_payment_mode($dates["dash_from_date"], $dates["dash_to_date"]);
                    $transactions['payment_number'] = $transaction->graph_no_of_payments($dates["dash_from_date"], $dates["dash_to_date"]);
                    $transactions['settlement_number'] = $settlement->graph_no_of_settlements($dates["dash_from_date"], $dates["dash_to_date"]);
                    $transactions['bar_line_graph'] = $this->bar_line_graph($dates["dash_from_date"], $dates["dash_to_date"]);
                    return array(
                        'status' => 0,
                        'data' => $transactions,
                        'summary_view' => view('.merchant.merchantDashboardSummary', compact('transactions'))->render()
                    );
                    break;


                case 'dash_payment':

                    $transaction = new Payment();
                    $transactions = $transaction->get_dashboard_payments($dates["dash_from_date"], $dates["dash_to_date"]);
                    session(['dash-payments-search' => $transactions]);
                    $trans_page = $this->_arrayPaginator($transactions, $request, "dash_payment", $perpage);
                    return View::make(".merchant.pagination")->with(["transactions" => $trans_page, "module" => $module])->render();
                    break;

                case 'dash_refund':

                    $refund = new Refund();
                    $refunds = $refund->get_dashboard_refunds($dates["dash_from_date"], $dates["dash_to_date"]);
                    session(['dash-refunds-search' => $refunds]);
                    $refunds_page = $this->_arrayPaginator($refunds, $request, "dash_refund", $perpage);
                    return View::make(".merchant.pagination")->with(["refunds" => $refunds_page, "module" => $module])->render();
                    break;

                case 'dash_setllement':

                    $settlement = new Settlement();
                    $settlements = $settlement->get_dashboard_settlements($dates["dash_from_date"], $dates["dash_to_date"]);
                    session(['dash-settlements-search' => $settlements]);
                    $settlements_page = $this->_arrayPaginator($settlements, $request, "dash_setllement", $perpage);
                    return View::make(".merchant.pagination")->with(["settlements" => $settlements_page, "module" => $module])->render();
                    break;

                case 'dash_logactivities':

                    $log_activity = new MerchantLogActivity();
                    $logactivities = $log_activity->get_merchant_log($dates["dash_from_date"], $dates["dash_to_date"]);
                    session(['dash-logactivities-search' => $logactivities]);
                    $logactivities_page = $this->_arrayPaginator($logactivities, $request, "dash_logactivities", $perpage);
                    return View::make(".merchant.pagination")->with(["logactivity" => $logactivities_page, "module" => $module])->render();
                    break;
            }
            exit;
        }

        return view('/merchant/dashboard')->with("dashboard", $dashboard);
    }

    private function bar_line_graph($from_date = "", $to_date = "")
    {

        try {
            $startDate = new Carbon($from_date);
            $endDate = new Carbon($to_date);
            $all_dates = array();
            while ($startDate->lte($endDate)) {
                $all_dates[] = $startDate->toDateString();

                $startDate->addDay();
            }

            $graphData = [];
            $linegraphData = [];
            $graph_json = [];

            foreach ($all_dates as $key => $date) {
                $amount = Payment::whereDate('created_date', $date)->where('created_merchant', Auth::user()->id)->where('transaction_status', 'success')->sum('transaction_amount');
                $count = Payment::whereDate('created_date', $date)->where('created_merchant', Auth::user()->id)->where('transaction_status', 'success')->count();
                $graph_json[$key] = array(
                    "gtv_date" => $date,
                    "gtv_amount" => $amount,
                    "tran_count" => $count,
                    "line_colour" => "#000000"
                );
                $graphData[$key] = $amount;


                $linegraphData[$key] = $count;
            }


            $graph = new \stdClass();
            $graph->headers = $all_dates;
            $graph->keys = $graphData;
            $graph->line = $linegraphData;

            return ($graph_json);
        } catch (\Throwable $e) {

            dd($e->getMessage());
        }
    }

    private function _arrayPaginator($array, $request, $module = "", $perPage = 10)
    {
        //$page = Input::get('page', 1);
		$page = $request->Input('page',1);
        $offset = ($page * $perPage) - $perPage;
        return new LengthAwarePaginator(
            array_slice($array, $offset, $perPage, true),
            count($array),
            $perPage,
            $page,
            ['path' => '/merchant/pagination/' . $module . '-' . $perPage, 'query' => $request->query()]
        );
    }

    public static function current_amount()
    {
        $payment = new Payment();
        $amount = $payment->current_transaction_amount()[0];
        return $amount->current_amount;
    }

    public static function transaction_amount($merchant_id)
    {
        $payment = new Payment();
        $amount = $payment->total_transaction_amount($merchant_id)[0];
        return $amount->current_amount;
    }

    public function change_appmode(Request $request, $id)
    {
        // dd('test');
        if ($request->ajax()) {
            $field = $request->except('_token');
            $user = new User();

            $docverified = $user->select_query(["change_app_mode"], ["id" => Auth::user()->id]);
            // dd($docverified);
            if (!empty($docverified)) {
                if ($docverified[0]->change_app_mode == "Y") {
                    $appmode_status = $user->update_merchant(["app_mode" => $id]);
                    if ($appmode_status) {
                        echo json_encode(array("status" => TRUE, "message" => "App Mode updated successfully"));
                    } else {
                        echo json_encode(array("status" => FALSE, "message" => "Unable to update App Mode"));
                    }
                } else {
                    echo json_encode(array("status" => FALSE));
                }
            }
        }
    }

    public function get_notifications(Request $request)
    {

        $notifies = new NotiMessController();
        $notifications = $notifies->get_notifications();
        echo json_encode($notifications);
    }

    public function get_messages(Request $request)
    {
        $notifies = new NotiMessController();
        $messages = $notifies->get_messages();
        echo json_encode($messages);
    }

    public function show_notification_table(Request $request, $perpage)
    {

        if ($request->ajax()) {
            $notifies = new NotiMessController();
            $notifications = $notifies->get_table_notifications();
            session(['notifications-search' => $notifications]);
            $notifications_page = $this->_arrayPaginator($notifications, $request, "notification", $perpage);
            return View::make(".merchant.pagination")->with(["notifications" => $notifications_page, "module" => "notification"])->render();
        }
    }


    public function show_message_table(Request $request, $perpage)
    {

        if ($request->ajax()) {
            $notifies = new NotiMessController();
            $messages = $notifies->get_table_messages();
            session(['messages-search' => $messages]);
            $messages_page = $this->_arrayPaginator($messages, $request, "message", $perpage);
            return View::make(".merchant.pagination")->with(["messages" => $messages_page, "module" => "message"])->render();
        }
    }


    public function update_notification(Request $request, $id)
    {
        $notifies = new NotiMessController();
        $notifications = $notifies->update_notification(Auth::user()->id, $id);
        echo json_encode($notifications);
    }


    public function enable_reminders(Request $request)
    {
        if ($request->ajax()) {
            $field = $request->except('_token');
            $user = new User();
            $appmode_status = $user->update_merchant($field);
            if ($appmode_status) {
                echo json_encode(array("status" => TRUE, "message" => "Reminders updated successfully"));
            } else {
                echo json_encode(array("status" => FALSE, "message" => "Unable to update Reminders"));
            }
        }
    }

    public function disable_popup()
    {
        $user = new User();
        return $user->update_merchant(["show_modal" => 'N']);
    }


    public static function get_merchant_state()
    {
        $merchant_business = new MerchantBusiness();
        return $merchant_business->get_state();
    }

    public function activate_forms(Request $request, $form)
    {

        return View::make(".merchant.activateform")->with(["form" => $form])->render();
    }

    public function merchant_transaction(Request $request)
    {
        
        

        return view('/merchant/transaction');
    }

    public function merchant_invoice(Request $request)
    {

        $state = new State();

        $merchant_business = new MerchantBusiness();

        $states = $state->get_state_list();

        $this->invoice_count = Invoice::count() + 1;

        $merchant_details['info'] = $merchant_business->get_requested_columns(['business_name', 'mer_name', 'mer_pan_number', 'comp_gst']);

        $merchant_details['invoice_no'] = date("Ymd") . "-" . $this->invoice_count;

        $invoices_pages = array(
            "states" => $states
        );
        return view('/merchant/invoices')->with(["invoices_pages" => $invoices_pages, "merchant_details" => $merchant_details]);
    }

    public function business_info()
    {
        $state = new State();
        if (Auth::user()->merchant_business == "Y") {
            return redirect('/merchant/dashboard');
        }
        $states = $state->get_state_list();
        return view('/merchant/business')->with("states", $states);
    }

    public function merchant_settings()
    {
        $business_type = new BusinessType();
        $business_category = new BusinessCategory();
        $merchant_business =  new MerchantBusiness();
        $business_subcategory = new BusinessSubCategory();
        $webhook = new Webhook();

        $states = new State();


        $merchantapi = new MerchantApi();

        $merchant_business = $merchant_business->get_merchant_business_details();
        $business_sub_category = array();
        $formdata["merchant_business"] =  $merchant_business;
        $formdata["btype"] = $business_type->get_business_type();
        $formdata["bcategory"] = $business_category->get_business_category();
        foreach ($merchant_business as $key => $value) {
            if (property_exists($value, "business_category_id")) {
                $business_sub_category["id"] = $value->business_category_id;
            }
        }
        if (!empty($business_sub_category)) {
            $formdata["bsubcategory"] = $business_subcategory->get_business_subcategory($business_sub_category);
        }
        $formdata["statelist"] = $states->get_state_list();
        $webhookdata = $webhook->get_merchant_webhook();
        $api_info = $merchantapi->get_merchant_api();

        $services=MerchantServices::where('merchant_id',Auth::user()->id)->first();
        $bank=new MerchantVendorBank();  
        $payment_modes=$bank->get_merchant_route_by_merchant_id(Auth::user()->id);
        if(count($payment_modes)){
            $payment_modes=$payment_modes[0];
        }else{
            $payment_modes=[];
        }

            
        return view("/merchant/settings")->with(["formdata" => $formdata, "api_info" => $api_info, "webhookdata" => $webhookdata,
        'service'=>$services,'payment_mode'=>$payment_modes]);
    }

    public function merchant_paylink(Request $request)
    {
        return view('/merchant/paylinks');
    }
     
     

    public function invoice(Request $request, $perpage)
    {

        if ($request->ajax()) {

            $invoice = new Invoice();
            $invoices =  $invoice->get_all_invoices();
            session(['invoices-search' => $invoices]);
            $invoices_page = $this->_arrayPaginator($invoices, $request, "invoice", $perpage);
            return View::make(".merchant.pagination")->with(["invoices" => $invoices_page, "module" => "invoice"])->render();
        }
    }


    public function payment(Request $request, $perPage)
    {
        // $userId = Auth::id();
        // dd($userId);

       $appmode = Auth::user()->app_mode;
    //    dd($appmode);

        $transaction = new Payment();
        $id = Auth::user()->id;
        $merchant = DB::table('merchant')
                ->select('fpay_id')
                ->where('merchant.id', $id)
                ->first();
        $merchantid = $merchant->fpay_id;


        $livemerchant = DB::table('user_keys')
        ->select('prod_mid')
        ->where('user_keys.mid', $id)
        ->first();
        $livemerchantid = $livemerchant->prod_mid;


        if($appmode == '1'){
        $payinTransactions = DB::table('payin_transactions')
        ->select('payin_transactions.*') 
        ->join('user_keys', 'payin_transactions.merchant_id', '=', 'user_keys.prod_mid')
        ->where('payin_transactions.merchant_id', $livemerchantid)
        ->groupBy('payin_transactions.order_id') 
        ->orderByDesc('payin_transactions.updated_at')
        ->paginate($perPage);
        // dd($payinTransactions);
    }
    else{
        $payinTransactions = DB::table('test_payintransactions')
        ->select('test_payintransactions.*') 
        ->join('merchant', 'test_payintransactions.merchant_id', '=', 'merchant.fpay_id')
        ->where('test_payintransactions.merchant_id', $merchantid)
        ->groupBy('test_payintransactions.order_id') 
        ->orderByDesc('test_payintransactions.updated_at')
        ->paginate($perPage);
    }
        // ->get();
        // dd($payinTransactions);
        // $payinTransactions = $payinTransactions->toArray();
        // $unique = array_unique($payinTransactions);
        // dd($unique);
        // dd($transaction);
        if ($request->ajax()) {
            $filters = $request->except('_token');
            session(['payments-search' => $payinTransactions]); // This is for searching
    
            return view('merchant.pagination', [
                'transactions' => $payinTransactions,
                'module' => 'payment'
            ])->render();
        }
        // if ($request->ajax()) {
        //     $filters = $request->except('_token');
        //     $transactions = $transaction->get_all_payments();
        //     session(['payments-search' => $transactions]); //This is for searching

        //     // $trans_page = $this->_arrayPaginator($transactions, $request, "payment", $perPage);
        //     $trans_page = $this->_arrayPaginator($payinTransactions, $request, "payment", $perPage);
        //     return View::make(".merchant.pagination")->with(["transactions" => $trans_page, "module" => "payment"])->render();
        // }
    }


    public function get_payment(Request $request, $id)
    {
        $transaction = new Payment();
        echo json_encode($transaction->get_payment($id));
    }

    /**
     * Show the application Transaction Refunds.
     *
     * @return \Illuminate\Http\Response
     */
    public function refund(Request $request, $perPage)
    {


        if ($request->ajax()) {
            $refund = new Refund();
            $filters = $request->except('_token');

            $refunds = $refund->get_all_refunds();
            session(['refunds-search' => $refunds]); //This is for searching
            $refunds_page = $this->_arrayPaginator($refunds, $request, "refund", $perPage);

            return View::make(".merchant.pagination")->with(["refunds" => $refunds_page, "module" => "refund"])->render();
        } else {

            $refunds = $refund->get_all_refunds();
            $refunds_with_pagination = $this->_arrayPaginator($refunds, $request);
            return view('/merchant/refund')->with("refunds", $refunds_with_pagination);
        }
    }



    /**
     * Show the application Transaction Orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function order(Request $request, $perPage)
    {


        if ($request->ajax()) {
            $order = new Order();
            $orders = $order->get_all_orders();
            session(['orders-search' => $orders]);

            array_map(function ($row) {
                $dateTime = DateTime::createFromFormat('d-m-Y h:i:s A', $row->created_date);
                $row->created_date = $dateTime->format('d-m-Y');
                $row->created_time = $dateTime->format('h:i:s A');
                return $row;
            }, $orders);

            $orders_page = $this->_arrayPaginator($orders, $request, "order", $perPage);
            return View::make(".merchant.pagination")->with(["orders" => $orders_page, "module" => "order"])->render();
        } else {

            $orders = $order->get_all_orders();
            $order_with_pagination = $this->_arrayPaginator($orders, $request);
            return view('/merchant/order')->with("orders", $order_with_pagination);
        }
    }

    public function get_order(Request $request, $id)
    {
        $order = new Order();
        echo json_encode($order->get_order($id));
    }


    /**
     * Show the application Transaction Dispute.
     *
     * @return \Illuminate\Http\Response
     */
    public function dispute(Request $request, $perPage)
    {

        if ($request->ajax()) {
            $dispute = new Dispute();
            $disputes = $dispute->get_all_disputes();
            session(['disputes-search' => $disputes]);
            $disputes_page = $this->_arrayPaginator($disputes, $request, "dispute", $perPage);
            return View::make(".merchant.pagination")->with(["disputes" => $disputes_page, "module" => "dispute"])->render();
        }
    }

    public function settlement(Request $request)
    {

        $settlement = new Settlement();

        if ($request->ajax()) {
            $filters = $request->except('_token');
            $applyfilters = array(
                'created_merchant' => Auth::user()->id,
            );
            foreach ($filters as $index => $value) {
                if ($value != "" && $index != "limit") {

                    $applyfilters[$index] = $value;
                }
            }
            $settlement_search = $settlement->get_all_settlements($applyfilters);
            echo json_encode($settlement_search);
        } else {

            $settlements =  $settlement->get_all_settlements();
            $settlements_with_pagination = $this->_arrayPaginator($settlements, $request);
            return view('/merchant/settlements')->with("settlements", $settlements_with_pagination);
        }
    }

    public function create_invoice()
    {
        $merchant_business = new MerchantBusiness();
        $this->invoice_count = Invoice::count() + 1;

        $merchant_details['info'] = $merchant_business->get_requested_columns(['business_name', 'pan_holder_name', 'pan_number']);
        $merchant_details['invoice_no'] = date("Ymd") . "-" . $this->invoice_count;
        return view('/merchant/invoiceadd')->with("merchant_details", $merchant_details);
    }

    public function show_invoice(Request $request)
    {

        $state = new State();

        $merchant_business = new MerchantBusiness();

        $states = $state->get_state_list();

        $this->invoice_count = Invoice::count() + 1;

        $merchant_details['info'] = $merchant_business->get_requested_columns(['business_name', 'mer_name', 'mer_pan_number', 'comp_gst']);

        $merchant_details['invoice_no'] = date("Ymd") . "-" . $this->invoice_count;

        $invoices_pages = array(
            "states" => $states
        );

        return view('/merchant/invoiceadd')->with(["invoices_pages" => $invoices_pages, "merchant_details" => $merchant_details]);
    }

    public function store_invoice(Request $request)
    {

        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'invoice_receiptno' => 'required',
                'merchant_company' => 'required',
                'merchant_panno' => 'required',
                "merchant_gstno" => 'required',
                "invoice_issue_date" => 'required',
                "invoice_billing_to" => 'required',
                "customer_email" => 'required',
                "customer_phone" => 'required',
                "invoice_billing_address" => 'required',
                "invoice_shipping_address" => 'required',
            ]);

            if ($validator->fails()) {
                echo json_encode($validator->errors());
            } else {


                $invoice = new Invoice();

                $invoiceitem = new InvoiceItem();

                $item_array = $request->only('item_name', 'item_amount', 'item_quantity', 'item_total');

                $invoice_sendvia = $request->only('send_email', 'send_message');

                $invoice_data = $request->except('outer_state', 'inner_state', 'customer_state', 'merchant_state', '_token', 'item_name', 'item_amount', 'item_quantity', 'item_total', 'customer_gst_code', 'send_email', 'send_message');

                $invoice_item_array = array();

                $invoice_payid = Str::random(6);

                if (Auth::user()->app_mode) {
                    $invoice_paylink = url('/') . "/i/s-p/" . $invoice_payid;
                } else {

                    $invoice_paylink = url('/') . "/t/i/s-p/" . $invoice_payid;
                }


                $invoice_data["invoice_issue_date"] = date('Y-m-d H:i:s', strtotime($request->invoice_issue_date));
                $invoice_data["invoice_payid"] = $invoice_payid;
                $invoice_data["invoice_paylink"] = $invoice_paylink;
                $invoice_data["invoice_gid"] = "inv_" . Str::random(16);
                $invoice_data["created_date"] = $this->date_time;
                $invoice_data["created_merchant"] = Auth::user()->id;

                $invoice_id = $invoice->add_invoice($invoice_data);


                foreach ($item_array["item_name"] as $key => $value) {



                    $invoice_item_array[$key]["invoice_id"] = $invoice_id;
                    $invoice_item_array[$key]["item_id"] = $value;
                    $invoice_item_array[$key]["item_amount"] = $item_array["item_amount"][$key];
                    $invoice_item_array[$key]["item_quantity"] = $item_array["item_quantity"][$key];
                    $invoice_item_array[$key]["item_total"] = $item_array["item_total"][$key];
                    $invoice_item_array[$key]["created_date"] = $this->date_time;
                    $invoice_item_array[$key]["created_merchant"] = Auth::user()->id;
                }
                $invoice_item_status = $invoiceitem->add_invoice_item($invoice_item_array);
                if ($invoice_item_status) {
                    if ($invoice_sendvia["send_email"] == "Y") {
                        $business_name = MerchantBusiness::get_business_name();

                        $data = array(
                            "from" => env("MAIL_USERNAME", ""),
                            "subject" => "Invoice from " . $business_name,
                            "view" => "/maillayouts/invoicemail",
                            "htmldata" => array(
                                "amount" => $invoice_data["invoice_amount"],
                                "email" => $invoice_data["customer_email"],
                                "invoice_url" => $invoice_paylink,
                                "business_name" => $business_name,
                                "paylink_id" => $invoice_payid
                            ),
                        );

                        if (Mail::to($invoice_data["customer_email"])->send(new SendMail($data))) {
                            $emailsmsObject = new EmailSmsLogs();
                            $emailsmsObject->email_logs($app = "Merchant", $module = "Password Reset Successful Email", $email_to = $invoice_data["customer_email"], $email_cc = "", $email_bcc = "", $email_status = "Success");
                        } else {

                            $emailsmsObject = new EmailSmsLogs();
                            $emailsmsObject->email_logs($app = "Merchant", $module = "Password Reset Successful Email", $email_to = $invoice_data["customer_email"], $email_cc = "", $email_bcc = "", $email_status = "Failed");
                        }
                    }

                    if ($invoice_sendvia["send_message"] == "Y") {
                        $message = ucfirst(Auth::user()->name) . " has requesting payment for INR " . $invoice_data["invoice_amount"] . "\nYou can pay through this link " . $invoice_paylink;
                        $sms = new SmsController($message, $invoice_data["customer_phone"]);
                        $sms->sendMessage();
                    }

                    echo json_encode(array("status" => TRUE, "message" => "Invoice added successfully"));
                } else {
                    echo json_encode(array("status" => FALSE, "message" => "Unable to add Invoice"));
                }
            }
        }
    }

    public function update_invoice(Request $request)
    {

        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'invoice_receiptno' => 'required',
                'merchant_company' => 'required',
                'merchant_panno' => 'required',
                "merchant_gstno" => 'required',
                "invoice_issue_date" => 'required',
                "invoice_billing_to" => 'required',
                "customer_email" => 'required',
                "customer_phone" => 'required',
                "invoice_billing_address" => 'required',
                "invoice_shipping_address" => 'required',
            ]);

            if ($validator->fails()) {
                echo json_encode($validator->errors());
            } else {


                $invoice = new Invoice();

                $invoiceitem = new InvoiceItem();

                $invoice_item_array = array();


                $item_array = $request->only('item_name', 'item_amount', 'item_quantity', 'item_total');

                $invoice_id = $request->only('invoice_id');

                $invoice_sendvia = $request->only('send_email', 'send_message');

                $invoice_data = $request->except('outer_state', 'inner_state', 'customer_state', 'merchant_state', '_token', 'item_name', 'item_amount', 'item_quantity', 'item_total', 'invoice_id', 'customer_gst_code', 'send_email', 'send_message');

                $invoice_status = $invoice->update_invoice($invoice_data, $invoice_id["invoice_id"]);

                $invoice_paylink_details = $invoice->get_invoice_paylink($invoice_id["invoice_id"])[0];

                foreach ($item_array["item_name"] as $key => $value) {
                    $invoice_item_array[$key]["invoice_id"] = $invoice_id["invoice_id"];
                    $invoice_item_array[$key]["item_id"] = $value;
                    $invoice_item_array[$key]["item_amount"] = $item_array["item_amount"][$key];
                    $invoice_item_array[$key]["item_quantity"] = $item_array["item_quantity"][$key];
                    $invoice_item_array[$key]["item_total"] = $item_array["item_total"][$key];
                    $invoice_item_array[$key]["created_date"] = $this->date_time;
                    $invoice_item_array[$key]["created_merchant"] = Auth::user()->id;
                }

                $invoiceitem->delete_invoice_items($invoice_id);

                $invoice_item_status = $invoiceitem->add_invoice_item($invoice_item_array);
                

                if ($invoice_item_status || $invoice_status) {
                    if ($invoice_sendvia["send_email"] == "Y") {
                        $business_name = MerchantBusiness::get_business_name();

                        $data = array(
                            "from" => env("MAIL_USERNAME", ""),
                            "subject" => "Invoice from " . $business_name,
                            "view" => "/maillayouts/invoicemail",
                            "htmldata" => array(
                                "amount" => $invoice_data["invoice_amount"],
                                "email" => $invoice_data["customer_email"],
                                "invoice_url" => $invoice_paylink_details->invoice_paylink,
                                "business_name" => $business_name,
                                "paylink_id" => $invoice_paylink_details->invoice_payid
                            ),
                        );

                        if (Mail::to($invoice_data["customer_email"])->send(new SendMail($data))) {
                            $emailsmsObject = new EmailSmsLogs();
                            $emailsmsObject->email_logs($app = "Merchant", $module = "Password Reset Successful Email", $email_to = $invoice_data["customer_email"], $email_cc = "", $email_bcc = "", $email_status = "Success");
                        } else {

                            $emailsmsObject = new EmailSmsLogs();
                            $emailsmsObject->email_logs($app = "Merchant", $module = "Password Reset Successful Email", $email_to = $invoice_data["customer_email"], $email_cc = "", $email_bcc = "", $email_status = "Failed");
                        }
                    }

                    if ($invoice_sendvia["send_message"] == "Y") {
                        $message = ucfirst(Auth::user()->name) . " has requesting payment for INR " . $invoice_data["invoice_amount"] . "\nYou can pay through this link " . $invoice_paylink_details->invoice_paylink;
                        $sms = new SmsController($message, $invoice_data["customer_phone"]);
                        $sms->sendMessage();
                    }

                    echo json_encode(array("status" => TRUE, "message" => "Invoice updated successfully"));
                } else {
                    echo json_encode(array("status" => FALSE, "message" => "Nothing is changed to updated invoice"));
                }
            }
        }
    }

    public function edit_invoice(Request $request, $id)
    {


        $invoice = new Invoice();

        $customer = new Customer();

        $customer_address = new CustomerAddress();

        $state = new State();

        $item = new Item();

        $invoice_query_data = $invoice->get_invoice($id);


        $invoice_details = array();
        $items_details = array();
        $customer_details = array();
        $customer_addresses = array();
        $customers = $customer->get_all_customers();

        foreach ($invoice_query_data as $index => $data_array) {

            $arrayelements_count = 0;
            foreach ($data_array as $key => $value) {
                if ($arrayelements_count < 18) {
                    $invoice_details[$key] = $value;
                } else if ($arrayelements_count < 22) {
                    $items_details[$index][$key] = $value;
                } else {
                    $customer_details[$key] = $value;
                }

                $arrayelements_count = $arrayelements_count + 1;
            }
        }

        $customer_addresses = $customer_address->get_customer_address($customer_details["customer_id"]);

        $items = $item->get_all_items();
        $states = $state->get_state_list();
        return view("/merchant/invoiceedit")->with(["invoice_details" => $invoice_details, "items_details" => $items_details, "customer_details" => $customer_details, "customers" => $customers, "customer_addresses" => $customer_addresses, "items" => $items, "states" => $states]);
    }


    public function item(Request $request, $perpage)
    {

        if ($request->ajax()) {
            $item = new Item();
            $items = $item->get_all_items();
            session(['items-search' => $items]);
            $items_page = $this->_arrayPaginator($items, $request, "item", $perpage);
            return View::make(".merchant.pagination")->with(["items" => $items_page, "module" => "item"])->render();
        }
    }

    public function get_all_items(Request $request)
    {
        $item = new Item();
        $applyfilters = array();
        if ($request->ajax()) {
            $items = $item->get_dropdown_items();
            echo json_encode($items);
        }
    }

    public function customers(Request $request, $perpage)
    {

        if ($request->ajax()) {
            $customer  = new Customer();
            $customers = $customer->get_all_customers();
            session(['customers-search' => $customers]);
            $customers_page = $this->_arrayPaginator($customers, $request, "customer", $perpage);
            return View::make(".merchant.pagination")->with(["customers" => $customers_page, "module" => "customer"])->render();
        }
    }

    public function get_all_customers(Request $request)
    {
        $customer  = new Customer();
        if ($request->ajax()) {
            $customers = $customer->get_all_customers();
            echo json_encode($customers);
        }
    }

    public function get_customer_details(Request $request, $id)
    {
        $customer  = new Customer();
        $customer_address =  new CustomerAddress();
        if ($request->ajax()) {
            $customer_details["info"] = $customer->get_selected_customer_info($id);
            $customer_details["address"] =  $customer_address->get_customer_address($id);
            echo json_encode($customer_details);
        }
    }

    public function store_customer_address(Request $request)
    {
        if ($request->ajax()) {

            $rules = [
                "address" => "required|string",
                "city" => "required|string|regex:/^[a-zA-Z ]+$/u",
                "pincode" => "required|digits:6|regex:/^[0-9]*$/",
            ];

            $messages = [
                "city.regex" => "Invalid city name",
                "pincode.regex" => "Invalid pincode",
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {

                echo json_encode(["status" => FALSE, "errors" => $validator->errors()]);
            } else {


                $customer_address =  new CustomerAddress();

                $customer_data = $request->except("_token");
                $customer_data["status"] = "active";
                $customer_data["created_date"] = $this->date_time;
                $customer_data["created_merchant"] = Auth::user()->id;

                $insert_status = $customer_address->add_customer_address($customer_data);

                if ($insert_status) {
                    echo json_encode(array("status" => TRUE, "message" => "Address added successfully"));
                } else {
                    echo json_encode(array("status" => FALSE, "message" => "Unable to add address"));
                }
            }
        }
    }


    public function update_customer_address(Request $request)
    {
        if ($request->ajax()) {

            $rules = [
                "address" => "required",
                "city" => "required|string|regex:/^[a-zA-Z]+$/u",
                "pincode" => "required|digits:6|regex:/^[0-9]*$/",
            ];

            $messages = [
                "city.regex" => "Invalid city name",
                "pincode.regex" => "Invalid pincode",
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {

                echo json_encode(["status" => FALSE, "errors" => $validator->errors()]);
            } else {

                $customer_address =  new CustomerAddress();
                $address_id =  $request->only("id");
                $customer_data = $request->except("_token", "id");

                if (!empty($request->id)) {
                    $update_status = $customer_address->update_customer_address($customer_data, $address_id);

                    if ($update_status) {
                        echo json_encode(array("status" => TRUE, "message" => "Address updated successfully"));
                    } else {
                        echo json_encode(array("status" => TRUE, "message" => "Nothing changed to update address"));
                    }
                } else {

                    $customer_data["status"] = "active";
                    $customer_data["created_date"] = $this->date_time;
                    $customer_data["created_merchant"] = Auth::user()->id;

                    $insert_status = $customer_address->add_customer_address($customer_data);

                    if ($insert_status) {
                        echo json_encode(array("status" => TRUE, "message" => "Address added successfully"));
                    } else {
                        echo json_encode(array("status" => FALSE, "message" => "Unable to add address"));
                    }
                }
            }
        }
    }


    public function delete_customer_address(Request $request)
    {
        if ($request->ajax()) {
            $customer_address =  new CustomerAddress();

            $address_id = $request->only("id", "customer_id");

            $update_status = $customer_address->update_customer_address(["status" => "inactive"], $address_id);

            if ($update_status) {
                echo json_encode(array("status" => TRUE, "message" => "Address Deleted successfully"));
            } else {
                echo json_encode(array("status" => FALSE, "message" => "Unable to delete customer address"));
            }
        }
    }

    public function get_customer_address(Request $request, $id)
    {
        $customer_address =  new CustomerAddress();
        if ($request->ajax()) {
            $customer_addresses = $customer_address->get_customer_address($id);
            echo json_encode($customer_addresses);
        }
    }

    public function get_customer_gst_state_code(Request $request, $state_id)
    {
        $gstcode = State::state_gstcode($state_id);
        echo json_encode(["status" => true, "state_gstcode" => $gstcode]);
    }

    public function store_item(Request $request)
    {


        if ($request->ajax()) {

            $rules = [
                "item_name"    => "required|array",
                "item_name.*"  => "required|string",
                "item_amount"  => "required|array",
                "item_amount.*"  => "required|string",
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                echo json_encode(array("status" => FALSE, "errors" => $validator->errors()));
            } else {

                $item = new Item();
                $fields = $request->except('_token');
                $itemsdata = array();
                foreach ($fields["item_name"] as $key => $value) {

                    $itemsdata[$key]["item_name"] = $fields["item_name"][$key];
                    $itemsdata[$key]["item_amount"] = $fields["item_amount"][$key];
                    $itemsdata[$key]["item_description"] = $fields["item_description"][$key];
                    $itemsdata[$key]["item_gid"] = "itm_" . Str::random(16);
                    $itemsdata[$key]["created_date"] = $this->date_time;
                    $itemsdata[$key]["created_merchant"] = Auth::user()->id;
                }
                $insert_status = $item->add_item($itemsdata);
                if ($insert_status) {
                    echo json_encode(array("status" => TRUE, "message" => "Item added successfully"));
                } else {
                    echo json_encode(array("status" => FALSE, "message" => "Unable to add item"));
                }
            }
        }
    }

    public function store_bulk_items(Request $request)
    {
        $item = new Item();
        $import_data = Excel::toArray(new InvItemImport(), $request->file('import_items_file'));
        $itemsdata = array();
        foreach ($import_data[count($import_data) - 1] as $key => $value) {
            $itemsdata[$key]["item_name"] = $value[0];
            $itemsdata[$key]["item_amount"] = $value[1];
            $itemsdata[$key]["item_description"] = $value[2];
            $itemsdata[$key]["item_gid"] = "itm_" . Str::random(16);
            $itemsdata[$key]["created_date"] = $this->date_time;
            $itemsdata[$key]["created_merchant"] = Auth::user()->id;
        }

        $insert_status = $item->add_item($itemsdata);
        if ($insert_status) {
            echo json_encode(array("status" => TRUE, "message" => "Items added successfully"));
        } else {
            echo json_encode(array("status" => FALSE, "message" => "Unable to add items"));
        }
    }

    public function edit_item(Request $request, $itemid)
    {
        if ($request->ajax()) {
            $item = new Item();
            $item_edit = $item->edit_item($itemid);
            echo json_encode($item_edit);
        }
    }

    public function item_update(Request $request)
    {
        $where_data = array();
        if ($request->ajax()) {
            $validator =  Validator::make($request->all(), [
                "item_name" => "required",
                "item_amount" => ['required', 'numeric'],
            ]);

            if ($validator->fails()) {
                echo json_encode(["status" => FALSE, "error" => $validator->errors()]);
            } else {

                $where_data = $request->only('id');
                $where_data['created_merchant'] = Auth::user()->id;
                $fileds_data = $request->except('_token', 'id');
                $item = new Item();
                $update_status = $item->update_item($where_data, $fileds_data);
                if ($update_status) {
                    echo json_encode(array("status" => TRUE, "message" => "Item updated successfully"));
                } else {
                    echo json_encode(array("status" => FALSE, "message" => "Unable to update item"));
                }
            }
        }
    }

    public function destroy_item(Request $request)
    {

        if ($request->ajax()) {
            $item = new Item();
            $fields = $request->except('_token');
            $remove_status = $item->remove_item($fields);
            if ($remove_status) {
                echo json_encode(array("status" => TRUE, "message" => "Item deleted successfully"));
            } else {
                echo json_encode(array("status" => FALSE, "message" => "Unable to delete item"));
            }
        }
    }

    public function paylink(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $paylink = new Paylink();
            $paylinks = $paylink->get_all_paylinks();
            session(['paylinks-search' => $paylinks]);
            $paylinks_page = $this->_arrayPaginator($paylinks, $request, "paylink", $perpage);
            return View::make("merchant.pagination")->with(["paylinks" => $paylinks_page, "module" => "paylink"])->render();
        }
    }

    public function store_paylink(Request $request)
    {

        if ($request->ajax()) {
            $validator = Validator::make(
                $request->all(),
                [
                    'paylink_amount' => 'required|numeric',
                    'paylink_for' => 'required',
                ]
            );

            if ($validator->fails()) {
                echo json_encode(["status" => FALSE, "errors" => $validator->errors()]);
            } else {

                $paylink = new Paylink();
                $paylink_payid = Str::random(6);
                $paylink_link = "";

                if (Auth::user()->app_mode) {
                    $paylink_link = url('/') . "/p/s-p/" . $paylink_payid;
                } else {

                    $paylink_link = url('/') . "/t/p/s-p/" . $paylink_payid;
                }


                $fields = $request->except('_token');
                $fields["paylink_gid"]   = "plnk_" . Str::random(16);
                $fields["paylink_payid"] = $paylink_payid;
                $fields["paylink_link"]  = $paylink_link;
                $fields["created_date"]  = $this->date_time;
                $fields["created_merchant"] = Auth::user()->id;

                $insert_status = $paylink->add_paylink($fields);

                if ($insert_status) {
                    if ($fields["email_paylink"] == "Y") {
                        $business_name = MerchantBusiness::get_business_name();
                        $data = array(
                            "from" => env("MAIL_USERNAME", ""),
                            "subject" => "Requesting payment of INR " . number_format($fields["paylink_amount"], 2) . " From " . ucfirst($business_name),
                            "view" => "/maillayouts/rpaylinkmail",
                            "htmldata" => array(
                                "paylink_for" => $fields["paylink_for"],
                                "amount" => $fields["paylink_amount"],
                                "email" => $fields["paylink_customer_email"],
                                "paylink_url" => $paylink_link,
                                "business_name" => $business_name,
                                "paylink_id" => $paylink_payid
                            ),
                        );

                        if (Mail::to($fields["paylink_customer_email"])->send(new SendMail($data))) {
                            $emailsmsObject = new EmailSmsLogs();
                            $emailsmsObject->email_logs($app = "Merchant", $module = "Password Reset Successful Email", $email_to = $fields["paylink_customer_email"], $email_cc = "", $email_bcc = "", $email_status = "Success");
                        } else {

                            $emailsmsObject = new EmailSmsLogs();
                            $emailsmsObject->email_logs($app = "Merchant", $module = "Password Reset Successful Email", $email_to = $fields["paylink_customer_email"], $email_cc = "", $email_bcc = "", $email_status = "Failed");
                        }
                    }

                    if ($fields["mobile_paylink"] == "Y") {
                        $message = ucfirst(Auth::user()->name) . " has requesting payment for INR " . $fields["paylink_amount"] . "\nYou can pay through this link " . $paylink_link;

                        $sms = new SmsController($message, $fields["paylink_customer_mobile"]);

                        $sms->sendMessage();
                    }

                    echo json_encode(array("status" => TRUE, "message" => "Paylink added successfully"));
                } else {
                    echo json_encode(array("status" => FALSE, "message" => "Unable to add Paylink"));
                }
            }
        }
    }

    public function store_bulk_paylink(Request $request)
    {

        if ($request->ajax()) {
            $paylink = new Paylink();
            $import_data = Excel::toArray(new PaylinkImport(), $request->file('import_paylinks_file'));
            $paylink_bulk_data = array();
            $insert_failed_data = array();
            $paylink_status = false;

            foreach ($import_data[count($import_data) - 1] as $key => $value) {
                $rowcount = 2;
                if (!empty($value[0]) && !empty($value[1])) {
                    $paylink_payid = Str::random(6);
                    $paylink_link = "";
                    if (Auth::user()->app_mode) {
                        $paylink_link = url('/') . "/p/s-p/" . $paylink_payid;
                    } else {

                        $paylink_link = url('/') . "/t/p/s-p/" . $paylink_payid;
                    }

                    $paylink_bulk_data[$key]["paylink_link"]  = $paylink_link;
                    $paylink_bulk_data[$key]["paylink_amount"] = $value[0];
                    $paylink_bulk_data[$key]["paylink_for"] = $value[1];
                    $paylink_bulk_data[$key]["paylink_customer_email"] = $value[2];
                    $paylink_bulk_data[$key]["paylink_customer_mobile"] = $value[3];
                    $paylink_bulk_data[$key]["paylink_receipt"] = $value[4];
                    $paylink_bulk_data[$key]["paylink_payid"] = $paylink_payid;
                    $paylink_bulk_data[$key]["paylink_expiry"] = (!empty($value[5])) ? $this->_excel_to_phpdate($value[5]) : $value[5];
                    $paylink_bulk_data[$key]["paylink_notes"] = $value[6];
                    $paylink_bulk_data[$key]["paylink_partial"] = $value[7];
                    $paylink_bulk_data[$key]["email_paylink"] = $value[8];
                    $paylink_bulk_data[$key]["mobile_paylink"] = $value[9];
                    $paylink_bulk_data[$key]["paylink_auto_reminder"] = $value[10];
                    $paylink_bulk_data[$key]["paylink_gid"] = "plnk_" . Str::random(16);
                    $paylink_bulk_data[$key]["created_merchant"] = Auth::user()->id;
                    $paylink_bulk_data[$key]["created_date"] = $this->date_time;
                } else {
                    array_push($insert_failed_data, $rowcount + $key);
                }
            }

            if (!empty($paylink_bulk_data)) {
                $paylink_status = $paylink->add_paylink($paylink_bulk_data);
            }
            if ($paylink_status) {
                echo json_encode(array("status" => TRUE, "message" => "Paylink added successfully"));
            } else {
                echo json_encode(array("status" => FALSE, "message" => "Unable to add Paylink"));
            }
        }
    }

    public function get_quicklinks(Request $request, $perPage)
    {

        if ($request->ajax()) {
            $paylink = new Paylink();
            $quick_links = $paylink->get_all_quicklinks();
            session(['quicklinks-search' => $quick_links]);
            $paylinks_page = $this->_arrayPaginator($quick_links, $request, "quicklink", $perPage);
            return View::make(".merchant.pagination")->with(["quicklinks" => $paylinks_page, "module" => "quicklink"])->render();
        }
    }

    public function store_quicklink(Request $request)
    {

        if ($request->ajax()) {
            $validate = Validator::make($request->all(), [
                'paylink_amount' => 'required|numeric|regex:/^[1-9][0-9]*$/',
                'paylink_for' => 'required'
            ]);

            if ($validate->fails()) {

                echo json_encode(["status" => FALSE, "errors" => $validate->errors()]);
            } else {
                $paylink = new Paylink();
                $paylink_payid = Str::random(6);
                $paylink_link = "";

                if (Auth::user()->app_mode) {
                    $paylink_link = url('/') . "/p/s-p/" . $paylink_payid;
                } else {

                    $paylink_link = url('/') . "/t/p/s-p/" . $paylink_payid;
                }


                $fields = $request->except('_token');
                $fields["paylink_gid"]   = "plnk_" . Str::random(16);
                $fields["paylink_expiry"] = date('Y-m-d H:i:s', strtotime($this->date_time . '+ 1 days'));
                $fields["paylink_type"]  = "quick";
                $fields["paylink_payid"] = $paylink_payid;
                $fields["paylink_link"]  = $paylink_link;
                $fields["created_date"]  = $this->date_time;
                $fields["created_merchant"] = Auth::user()->id;

                $insert_status = $paylink->add_paylink($fields);


                if ($insert_status) {
                    echo json_encode(array("status" => TRUE, "message" => "Quick paylink added successfully"));
                } else {
                    echo json_encode(array("status" => FALSE, "message" => "Unable to add Paylink"));
                }
            }
        }
    }

    public function paylink_edit($id)
    {
        $paylink  = new Paylink();
        $paylink_edit = $paylink->edit_paylink($id);
        echo json_encode($paylink_edit);
    }


    private function _excel_to_phpdate($value)
    {

        $UNIX_DATE = ($value - 25569) * 86400;

        $EXCEL_DATE = 25569 + ($UNIX_DATE / 86400);

        $UNIX_DATE = ($EXCEL_DATE - 25569) * 86400;

        return gmdate("Y-m-d H:i:s", $UNIX_DATE);
    }

    public function paylink_update(Request $request)
    {
        $paylink = new Paylink();
        if ($request->ajax()) {
            $validator = Validator::make(
                $request->all(),
                [
                    'paylink_amount' => 'required|numeric',
                    'paylink_for' => 'required',
                ]
            );

            if ($validator->fails()) {
                echo json_encode(["status" => FALSE, "errors" => $validator->errors()]);
            } else {

                $update_array = $request->only('id');
                $fields = $request->except('_token', 'id');

                $update_array["created_merchant"] = Auth::user()->id;

                $update_status = $paylink->update_paylink($fields, $update_array);

                if ($update_status) {
                    echo json_encode(array("status" => TRUE, "message" => "Paylink updated successfully"));
                } else {
                    echo json_encode(array("status" => TRUE, "message" => "Nothing has changed to update paylink"));
                }
            }
        }
    }

    public function merchant_feedback()
    {

        $feed_form["subject"] = $this->feedback_subject();
        $merchant_feedback = new MerchantFeedback();
        $feedbacks = $merchant_feedback->get_feedback_details();
        return view('/merchant/feedback')->with(["feed_form" => $feed_form, "feedbacks" => $feedbacks]);
    }

    public function merchant_helpsupport()
    {

        $sup_form["category"] = $this->support_category();
        return view('/merchant/helpsupport')->with("sup_form", $sup_form);
    }

    public function merchant_referearn()
    {
        return view('/merchant/referearn');
    }

    public function get_business_subcategory(Request $request)
    {

        if ($request->ajax()) {
            $category = $request->except('_token');
            $business_subcategory = new BusinessSubCategory();
            $subcategory = $business_subcategory->get_business_subcategory($category);
            echo json_encode($subcategory);
        }
    }


    public function merchant_info()
    {

        $business_type = new BusinessType();
        $business_category = new BusinessCategory();
        $merchant_business =  new MerchantBusiness();
        $business_subcategory = new BusinessSubCategory();
        $states = new State();
        $merchantinfo = new User();

        $formdata["basicinfo"] = $merchantinfo->get_merchant_details();
        $merchant_business = $merchant_business->get_merchant_business_details();
        $business_sub_category = array();
        $formdata["merchant_business"] =  $merchant_business;
        $formdata["btype"] = $business_type->get_business_type();
        $formdata["bcategory"] = $business_category->get_business_category();
        foreach ($merchant_business as $key => $value) {
            if (array_key_exists("business_category_id", $value)) {
                $business_sub_category["id"] = $value->business_category_id;
            }
        }
        if (!empty($business_sub_category)) {
            $formdata["bsubcategory"] = $business_subcategory->get_business_subcategory($business_sub_category);
        }
        $formdata["statelist"] = $states->get_state_list();

        return view('/merchant/personaldetails')->with("formdata", $formdata);
    }

    public function store_merchant_info(Request $request)
    {

        if ($request->ajax()) {

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required',
                'mobile_no' => 'required',
                "business_type_id" => 'required',
                "business_category_id" => 'required',
                "business_sub_category_id" => 'sometimes|required',
                "business_sub_category" => "sometimes|required",
                "billing_label" => 'required',
                "webapp_exist" => 'required',
                "pan_number" => 'required',
                "address" => 'required',
                "pincode" => 'required',
                "city" => 'required',
                "state" => 'required'
            ]);
            if ($validator->fails()) {
                echo json_encode($validator->errors());
            } else {

                $merchant = new User();

                $merchant_business = new MerchantBusiness();

                $user_data = $request->only('name', 'email', 'mobile_no');
                $where = $request->only('id');
                $merchant_business_data =  $request->except('_token', 'name', 'email', 'mobile_no', 'id');

                if (!empty($merchant_business)) {
                    if ($where["id"] != "") {
                        $where["created_merchant"] = Auth::user()->id;
                        $merchant_business_status = $merchant_business->update_merchant_business($where, $merchant_business_data);
                        $message = "Merchant Business Details Update Successfully";
                    } else {

                        $merchant_business_data["created_date"] = $this->date_time;
                        $merchant_business_data["created_merchant"] = Auth::user()->id;
                        $merchant_business_status = $merchant_business->add_merchant_business($merchant_business_data);
                        $message = "Merchant Business Details Insert Successfully";
                    }
                }
                if (!empty($user_data)) {
                    $merchant->update_merchant($user_data);
                }

                if ($merchant_business_status) {
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {
                    echo json_encode(array("status" => TRUE, "message" => "Nothing is to Update"));
                }
            }
        }
    }
    public function update_business_info(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                "business_type_id" => "required",
                "business_category_id" => "required",
                "business_sub_category_id" => "sometimes|required",
                "business_sub_category" => "sometimes|required",
                "webapp_url" => "string|url",
                "bank_name" => "required|regex:/^[A-Za-z ]+$/",
                "bank_acc_no" => "required|digits_between:9,18'|numeric",
                "bank_ifsc_code" => "required|string|min:11"
            ], [
                "business_type_id.required" => "Business type field is required",
                "business_category_id.required" => "Business category field is required",
                "business_sub_category_id.required" => "Business sub category field is required",
                "business_sub_category.required" => "Business sub category field is required",
                "webapp_url.url" => "valid format are https://mywebsite.com"
            ]);


            if ($validator->fails()) {
                echo json_encode(["status" => false, "errors" => $validator->errors()]);
            } else {

                $business_info = $request->except("_token");
                $merchant_business = new MerchantBusiness();
                $update_status = $merchant_business->update_merchant_business(["created_merchant" => Auth::user()->id], $business_info);

                if ($update_status) {
                    echo json_encode(["status" => true, "message" => "Business info update successfully"]);
                } else {
                    echo json_encode(["status" => true, "message" => "Nothing has changed to update"]);
                }
            }
        }
    }

    public function update_business_logo(Request $request)
    {
        if ($request->ajax()) {

            $validator = Validator::make($request->all(), [
                'business_logo' => 'sometimes|required|mimes:jpg,jpeg,png|max:2048',
            ], [
                "business_logo.mimes" => "Only jpg,jpeg,png are allowed.",
                "business_logo.max" => "Image size must be 2mb or below 2MB."
            ]);
            if ($validator->fails()) {
                echo json_encode(["status" => false, "errors" => $validator->errors()]);
            } else {

                $logo = $request->file('business_logo');
                $name = md5($logo->getClientOriginalName()) . "." . $logo->getClientOriginalExtension();
                $destinationPath = public_path('/storage/merchantlogos');
                $logo->move($destinationPath, $name);
                $business_info["business_logo"] = env("APP_URL", "") . "/storage/merchantlogos/" . $name;
                $merchant_business = new MerchantBusiness();
                $update_status = $merchant_business->update_merchant_business(["created_merchant" => Auth::user()->id], $business_info);

                echo json_encode(["status" => true, "message" => "Logo updated successfully"]);
            }
        }
    }

    public function remove_business_logo(Request $request)
    {
        if ($request->ajax()) {

            $destinationPath = public_path('/storage/merchantlogos');
            if (file_exists($destinationPath . "/" . $request->business_logo)) {
                unlink($destinationPath . "/" . $request->business_logo);
                $business_info["business_logo"] = "";
                $merchant_business = new MerchantBusiness();
                $update_status = $merchant_business->update_merchant_business(["created_merchant" => Auth::user()->id], $business_info);
                echo json_encode(["status" => true, "message" => "Logo removed successfully"]);
            }
        }
    }

    public function update_company_info(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                "business_expenditure" => "required",
                "business_name" => "required|string|regex:/^[a-zA-Z& ]+$/u",
                "address" => "required|string",
                "pincode" => "required|numeric|digits:6",
                "city" => "required|string|regex:/^[a-zA-Z ]+$/u"
            ], [
                'business_name.regex' => "Company name doesn't allow special characters only alphabets",
                "city.regex" => "City field doesn't allow special characters or numbers only alphabets"
            ]);

            if ($validator->fails()) {
                echo json_encode(["status" => false, "errors" => $validator->errors()]);
            } else {

                $business_info = $request->except("_token");

                $merchant_business = new MerchantBusiness();
                $update_status = $merchant_business->update_merchant_business(["created_merchant" => Auth::user()->id], $business_info);

                if ($update_status) {
                    echo json_encode(["status" => true, "message" => "Company info update successfully"]);
                } else {
                    echo json_encode(["status" => true, "message" => "Nothing has changed to update"]);
                }
            }
        }
    }



    public function store_business_details_info(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                "comp_pan_number" => "required",
                "mer_pan_number" => "required",
                "mer_aadhar_number" => "required|digits:12",
                "mer_name" => "required",
            ], [
                "comp_pan_number.required" => "Company pan no field is required",
                "mer_pan_number.required" => "Authorized Signatory  pan no field is required",
                "mer_aadhar_number.required" => "Authorized Signatory aadhar no field is required",
                "mer_name.required" => "Authorized Signatory name field is required",
                "mer_aadhar_number.digits" => "Aadhar no should not be more than or less than 12 digits"
            ]);

            if ($validator->fails()) {
                echo json_encode(["status" => false, "errors" => $validator->errors()]);
            } else {

                $business_details_info = $request->except("_token");
                $merchant_business = new MerchantBusiness();
                $update_status = $merchant_business->update_merchant_business(["created_merchant" => Auth::user()->id], $business_details_info);

                if ($update_status) {
                    echo json_encode(["status" => true, "message" => "Business details update successfully"]);
                } else {
                    echo json_encode(["status" => true, "message" => "Nothing has changed to update"]);
                }
            }
        }
    }

    public function pagination(Request $request, $module)
    {
        $item = new Item();
        if ($module == "item") {
            $items = $item->get_all_items();
            $items_pagination = $this->_arrayPaginator($items, $request, "item");
            echo json_encode($items_pagination);
        }
    }

    public function store_customer(Request $request)
    {

        if ($request->ajax()) {

            $rules = [
                "customer_name" => "required|string|regex:/^[a-zA-Z ]+$/u",
                "customer_email" => "required|email",
                "customer_phone" => "required|digits:10|numeric",
                "customer_gstno" => "required|string"
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                echo json_encode(array("status" => FALSE, "errors" => $validator->errors()));
            } else {


                $customer = new Customer();
                $customer_details = $request->only('customer_email', 'customer_phone', 'customer_gstno');

                $existing_customer = $customer->get_customer_by_fields($customer_details);

                if ($existing_customer[0]->customer_count == 0) {
                    $customer_data = $request->except('_token', 'city', 'state', 'pincode', 'address');
                    $customer_data["customer_gid"] = 'cust_' . Str::random(16);
                    $customer_data["created_merchant"] = Auth::user()->id;
                    $customer_data["created_date"] =  $this->date_time;

                    $customer_status = $customer->add_customer($customer_data);
                    if ($customer_status) {
                        echo json_encode(array("status" => TRUE, "message" => "customer added successfully"));
                    } else {
                        echo json_encode(array("status" => TRUE, "message" => "unable to add customer"));
                    }
                } else {
                    echo json_encode(array("status" => FALSE, "message" => "Already customer exists with these details"));
                }
            }
        }
    }

    public function edit_customer(Request $request, $id)
    {
        if ($request->ajax()) {
            $customer = new Customer();
            $edit_customer = $customer->edit_customer_info($id);
            echo json_encode($edit_customer);
        }
    }

    public function update_customer(Request $request)
    {
        $customer = new Customer();
        $customer_id = $request->only("id");
        $customer_data = $request->except("_token", "id");
        $update_customer = $customer->update_customer_info($customer_data, $customer_id);
        if ($update_customer) {
            echo json_encode(array("status" => TRUE, "message" => "customer updated successfully"));
        } else {
            echo json_encode(array("status" => TRUE, "message" => "Nothing has changed to update"));
        }
    }


    public function delete_customer(Request $request)
    {
        $customer = new Customer();
        $invoice = new Invoice();
        $customer_id = $request->only("id");
        $saved_invoices = $invoice->get_saved_invoice_count($customer_id["id"]);
        if ($saved_invoices[0]->no_of_saved_invoices == 0) {
            $customer_data = $request->except("_token", "id");
            $customer_data["status"] = "inactive";
            $update_customer = $customer->update_customer_info($customer_data, $customer_id);
            if ($update_customer) {
                echo json_encode(array("status" => TRUE, "message" => "customer deleted successfully"));
            }
        } else {
            echo json_encode(array("status" => FALSE, "message" => "You can't delete this customer,<br> customer has active saved invoices"));
        }
    }

    public function store_merchant_api()
    {
        $merchantapi = new MerchantApi();
        $api_insert_id = $merchantapi->add_newapi();

        if ($api_insert_id != "") {
            $mechantapi_result = $merchantapi->edit_merchant_api($api_insert_id);

            echo json_encode($mechantapi_result);
        }
    }

    public function get_merchant_api()
    {
        $merchantapi = new MerchantApi();
        $api_info = $merchantapi->get_merchant_api();
        return view('/merchant/api')->with("api_info", $api_info);
    }

    public function update_merchant_api(Request $request, $api_id)
    {
        if ($request->ajax()) {
            $merchantapi = new MerchantApi();
            $update_status = $merchantapi->update_merchant_api($api_id);
            if ($update_status) {
                $mechantapi_result = $merchantapi->edit_merchant_api($api_id);
                echo json_encode($mechantapi_result);
            }
        }
    }

    public function get_api_details(Request $request, $api_id)
    {
        if ($request->ajax()) {
            $merchantapi = new MerchantApi();
            $mechantapi_result = $merchantapi->edit_merchant_api($api_id);
            echo json_encode($mechantapi_result);
        }
    }


    public function get_merchant_reminder()
    {
        $reminder = new Reminder();
        $merchant_reminder = $reminder->get_reminder();
        echo json_encode($merchant_reminder);
    }

    public function store_merchant_reminder(Request $request)
    {

        if ($request->ajax()) {
            $reminder = new Reminder();
            $reminder_data =  $request->except("_token");
            $reminder_insert = array();


            if ($request->exists("plwed")) {
                foreach ($reminder_data["plwed"] as $key => $value) {
                    $reminder_insert[$key]["reminder_days"] = $value;
                    $reminder_insert[$key]["reminder_for"] = "plwed";
                    $reminder_insert[$key]["send_sms"] = ($request->send_sms ? $request->send_sms : 'N');
                    $reminder_insert[$key]["send_email"] = ($request->send_email ? $request->send_email : 'N');
                    $reminder_insert[$key]["create_date"] = $this->date_time;
                    $reminder_insert[$key]["created_merchant"] = Auth::user()->id;
                }
            }

            if ($request->exists("plwoed")) {
                foreach ($reminder_data["plwoed"] as $key => $value) {
                    $index = count($reminder_insert);
                    $reminder_insert[$index]["reminder_days"] = $value;
                    $reminder_insert[$index]["reminder_for"] = "plwoed";
                    $reminder_insert[$index]["send_sms"] = ($request->send_sms ? $request->send_sms : 'N');
                    $reminder_insert[$index]["send_email"] = ($request->send_email ? $request->send_email : 'N');
                    $reminder_insert[$index]["create_date"] = $this->date_time;
                    $reminder_insert[$index]["created_merchant"] = Auth::user()->id;
                }
            }

            $insert_status = $reminder->add_reminder($reminder_insert);
            if ($insert_status) {
                echo json_encode(array("status" => TRUE, "message" => "Reminders added successfully"));
            } else {
                echo json_encode(array("status" => TRUE, "message" => "Unable to add reminders"));
            }
        }
    }

    public function show_document_form(Request $request, $id)
    {

        if ($request->ajax()) {
            $docs_list = [];
            $bussiness_id =  $id;
            $merchat_docs = new MerchantDocument();
            if (!empty($merchat_docs->documents()[0])) {
                $docs_list = $merchat_docs->documents()[0];
            }
            $merchat_docs = new MerchantDocument();
            return View::make(".merchant.merchantdocumet")->with(["bussiness_id" => $bussiness_id, "docs_list" => $docs_list])->render();
        }
    }

    public function verify_documents(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'comp_pan_card' => 'file|mimes:pdf,jpg,jpeg|max:5000',
            'comp_gst_doc' => 'file|mimes:pdf,jpg,jpeg|max:5000',
            'bank_statement' => 'file|mimes:pdf,jpg,jpeg|max:5000',
            'cin_doc' => 'file|mimes:pdf,jpg,jpeg|max:5000',
            'mer_pan_card' => 'file|mimes:pdf,jpg,jpeg|max:5000',
            'mer_aadhar_card' => 'file|mimes:pdf,jpg,jpeg|max:5000',
            'moa_doc' => 'file|mimes:pdf,jpg,jpeg|max:5000',
            'aoa_doc' => 'file|mimes:pdf,jpg,jpeg|max:5000',
            'cancel_cheque' => 'file|mimes:pdf,jpg,jpeg|max:5000',
            'partnership_deed' => 'file|mimes:pdf,jpg,jpeg|max:5000',
            'llp_agreement' => 'file|mimes:pdf,jpg,jpeg|max:5000',
            'registration_doc' => 'file|mimes:pdf,jpg,jpeg|max:5000',
            'trust_constitutional' => 'file|mimes:pdf,jpg,jpeg|max:5000',
            'income_tax_doc' => 'file|mimes:pdf,jpg,jpeg|max:5000',
            'ccrooa_doc' => 'file|mimes:pdf,jpg,jpeg|max:5000',
            'current_trustees' => 'file|mimes:pdf,jpg,jpeg|max:5000',
            'no_objection_doc' => 'file|mimes:pdf,jpg,jpeg|max:5000',
        ], [
            "comp_pan_card.mimes" => 'The company pan card must be a file of type: pdf, jpg, jpeg.',
            'comp_gst_doc.mimes' => 'The company GST must be a file of type: pdf, jpg, jpeg.',
            'bank_statement.mimes' => 'The bank statement must be a file of type: pdf, jpg, jpeg.',
            'cin_doc.mimes' => 'The cin doc must be a file of type: pdf, jpg, jpeg.',
            'aoa_doc.mimes' => 'The moa & aoa doc must be a file of type: pdf, jpg, jpeg.',
            'mer_pan_card.mimes' => 'The authorized signatory pan card must be a file of type: pdf, jpg, jpeg.',
            'mer_aadhar_card.mimes' => 'The authorized signatory aadhar card must be a file of type: pdf, jpg, jpeg.',
            'moa_doc.mimes' => 'The moa doc must be a file of type: pdf, jpg, jpeg.',
            'cancel_cheque.mimes' => 'Cancel Cheque doc must be a file of type: pdf, jpg, jpeg.',
            'partnership_deed.mimes' => 'Partnership doc must be a file of type: pdf, jpg, jpeg.',
            'llp_agreement.mimes' => 'LLP agreement doc must be a file of type: pdf, jpg, jpeg.',
            'registration_doc.mimes' => 'Registration doc must be a file of type: pdf, jpg, jpeg.',
            'trust_constitutional.mimes' => 'Trust/Constitutional doc must be a file of type: pdf, jpg, jpeg.',
            'income_tax_doc.mimes' => 'Income Tax doc must be a file of type: pdf, jpg, jpeg.',
            'ccrooa_doc.mimes' => 'Opening and Operating of the account doc must be a file of type: pdf, jpg, jpeg.',
            'current_trustees.mimes' => 'Current Trustees doc must be a file of type: pdf, jpg, jpeg.',
            'no_objection_doc' => 'No Objection Document must be a file of type: pdf, jpg, jpeg.',

            "comp_pan_card.max" => 'The company pan card file size must be 5mb or below 5MB',
            'comp_gst_doc.max' => 'The company GST file size must be 5mb or below 5MB',
            'bank_statement.max' => 'The bank statement file size must be 5mb or below 5MB',
            'cin_doc.max' => 'The cin doc file size must be 5mb or below 5MB',
            'aoa_doc.max' => 'The moa & aoa doc file size must be 5mb or below 5MB',
            'mer_pan_card.max' => 'The authorized signatory pan card file size must be 5mb or below 5MB',
            'mer_aadhar_card.max' => 'The authorized signatory aadhar card file size must be 5mb or below 5MB',
            'moa_doc.max' => 'The moa doc file size must be 5mb or below 5MB',
            'cancel_cheque.max' => 'Cancel Cheque doc file size must be 5mb or below 5MB',
            'partnership_deed.max' => 'Partnership doc file size must be 5mb or below 5MB',
            'llp_agreement.max' => 'LLP agreement doc file size must be 5mb or below 5MB',
            'registration_doc.max' => 'Registration doc file size must be 5mb or below 5MB',
            'trust_constitutional.max' => 'Trust/Constitutional doc file size must be 5mb or below 5MB',
            'income_tax_doc.max' => 'Income Tax doc file size must be 5mb or below 5MB',
            'ccrooa_doc.max' => 'Opening and Operating of the account doc file size must be 5mb or below 5MB',
            'current_trustees.max' => 'Current Trustees doc file size must be 5mb or below 5MB',
            'no_objection_doc' => 'No Objection Document file size must be 5mb or below 5MB.',

        ]);

        if ($validate->fails()) {
            echo json_encode(["status" => FALSE, "error" => $validate->errors()]);
        } else {

            //
            $merchant_doc = new MerchantDocument();
            $path_to_upload = "/public/merchant/documents/" . Auth::user()->merchant_gid;
            $files = Storage::files($path_to_upload);
            // if(count($files)>0)
            // {
            //     foreach ($files as $key => $value) {
            //         Storage::delete($value);
            //     }
            // }
            $documents = array();

            foreach ($request->file() as $key => $value) {
                $file = $request->file($key);
                $file_extension = $file->getClientOriginalExtension();
                $file_name = str_replace("_", "", $key) . "." . $file_extension;
                $file->storeAs($path_to_upload, $file_name);
                $documents[$key] = $file_name;
            }

            $where = array(
                "created_merchant" => Auth::user()->id
            );

            if (!empty($request->id)) {
                $where = $request->only("id");
                $upload_status = $merchant_doc->update_documents($where, $documents);

                //$this->_check_docs_status($merchant_doc);

                if ($upload_status) {
                    echo json_encode(array("status" => TRUE, "message" => "Document Uploaded Successfully"));
                } else {
                    echo json_encode(array("status" => FALSE, "message" => "Unable to upload documents"));
                }
            } else {

                $documents["created_date"] = $this->date_time;
                $documents["created_merchant"] = Auth::user()->id;
                $upload_status = $merchant_doc->add_documents($documents);

                //$this->_check_docs_status($merchant_doc);

                if ($upload_status) {
                    echo json_encode(array("status" => TRUE, "message" => "Document Uploaded Successfully"));
                } else {
                    echo json_encode(array("status" => FALSE, "message" => "Unable to upload documents"));
                }
            }
        }
    }

    public function remove_document(Request $request, $field, $id)
    {
        if ($request->ajax()) {
            $merchant_doc = new MerchantDocument();
            $file = $merchant_doc->get_doc_name($field);
            $upload_status = $merchant_doc->remove_document($id, $field);
            if ($upload_status) {
                if (file_exists(storage_path('/app/public/merchant/documents/' . Auth::user()->merchant_gid . "/" . $file))) {
                    unlink(storage_path('app/public/merchant/documents/' . Auth::user()->merchant_gid . "/" . $file));
                    echo json_encode(array("status" => TRUE, "message" => "Document Removed Successfully"));
                }
            } else {
                echo json_encode(array("status" => FALSE, "message" => "Unable to remove documents"));
            }
        }
    }


    public function update_activate_docs(Request $request)
    {
        $user = new User();
        $upload["documents_upload"] = "Y";
        $upload_status = $user->update_merchant($upload);
        $merchantdocObject = new MerchantDocument();
        $document_status["verified_status"] = "pending";
        $where["created_merchant"] = Auth::user()->id;
        $document_result = $merchantdocObject->update_documents($where, $document_status);
        echo json_encode(array("status" => TRUE));
    }



    public function get_webhook_details()
    {
        $webhook = new Webhook();
        $webhook_data = $webhook->get_merchant_webhook();
        echo json_encode($webhook_data);
    }
    public function store_merchant_webhook(Request $request)
    {

        if ($request->ajax()) {
            $webhook_id = $request->only("id");
            $webhook_data = $request->except("_token", "id");
            $webhook_data["is_active"] = $request->is_active ? $request->is_active : 'N';
            $webhook_data["payment_failed"] = $request->payment_failed ? $request->payment_failed : 'N';
            $webhook_data["payment_captured"] = $request->payment_captured ? $request->payment_captured : 'N';
            $webhook_data["transfer_processed"] = $request->transfer_processed ? $request->transfer_processed : 'N';
            $webhook_data["refund_processed"] = $request->refund_processed ? $request->refund_processed : 'N';
            $webhook_data["refund_created"] = $request->refund_created ? $request->refund_created : 'N';
            $webhook_data["refund_speed_changed"] = $request->refund_speed_changed ? $request->refund_speed_changed : 'N';
            $webhook_data["order_paid"] = $request->order_paid ? $request->order_paid : 'N';
            $webhook_data["dispute_created"] = $request->dispute_created ? $request->dispute_created : 'N';
            $webhook_data["dispute_won"] = $request->dispute_won ? $request->dispute_won : 'N';
            $webhook_data["dispute_lost"] = $request->dispute_lost ? $request->dispute_lost : 'N';
            $webhook_data["dispute_closed"] = $request->dispute_closed ? $request->dispute_closed : 'N';
            $webhook_data["settlement_processed"] = $request->settlement_processed ? $request->settlement_processed : 'N';
            $webhook_data["invoice_paid"] = $request->invoice_paid ? $request->invoice_paid : 'N';
            $webhook_data["invoice_partially_paid"] = $request->invoice_partially_paid ? $request->invoice_partially_paid : 'N';
            $webhook_data["invoice_expired"] = $request->invoice_expired ? $request->invoice_expired : 'N';
            $webhook_data["paylink_paid"] = $request->paylink_paid ? $request->paylink_paid : 'N';
            $webhook_data["paylink_partially_paid"] = $request->paylink_partially_paid ? $request->paylink_partially_paid : 'N';
            $webhook_data["paylink_expired"] = $request->paylink_expired ? $request->paylink_expired : 'N';
            $webhook_data["paylink_cancelled"] = $request->paylink_cancelled ? $request->paylink_cancelled : 'N';
            $webhook_data["created_date"] =  $this->date_time;
            $webhook_data["created_merchant"] = Auth::user()->id;

            $webhook = new Webhook();

            if ($request->id && !empty($request->id)) {
                $update_status = $webhook->update_webhook($webhook_id, $webhook_data);
                if ($update_status) {
                    echo json_encode(array("status" => TRUE, "message" => "Webhook updated successfully"));
                } else {
                    echo json_encode(array("status" => FALSE, "message" => "Unable to update webhook"));
                }
            } else {
                $insert_status = $webhook->add_webhook($webhook_data);

                if ($insert_status) {
                    echo json_encode(array("status" => TRUE, "message" => "Webhook added successfully"));
                } else {
                    echo json_encode(array("status" => FALSE, "message" => "Unable to add webhook"));
                }
            }
        }
    }

    public function resolution_center()
    {

        $support = new SupportController();
        $stype = $support->support_type();
        return view("/merchant/resolutioncenter")->with("stype", $stype);
    }


    public function customer_case(Request $request, $perpage)
    {

        if ($request->ajax()) {
            $customer_case = new CustomerCase();
            $case_details = $customer_case->get_case();
            session(['case-search' => $case_details]);
            $case_details_page = $this->_arrayPaginator($case_details, $request, "casedetail", $perpage);
            return View::make(".merchant.pagination")->with(["casedetails" => $case_details_page, "module" => "casedetail"])->render();
        }
    }

    public function case_details(Request $request, $caseid)
    {

        $custcaseObject = new CustomerCase();
        $case_details = $custcaseObject->get_custcase_merchant($caseid);

        if (!empty($case_details[0]->id)) {
            return view('.merchant.case')->with(["case_details" => $case_details[0]]);
        } else {
            return redirect()->back();
        }
    }

    public function merchant_comment(Request $request)
    {
        if ($request->ajax()) {
            $case_comment = new CaseComment();
            $comment_data = $request->except("_token");
            $comment_data["commented_date"] = $this->date_time;
            $comment_data["user_type"] = 'merchant';
            $insert_status = $case_comment->add_comment($comment_data);
            if ($insert_status) {
                echo json_encode(array("status" => TRUE, "message" => "Your comment added successfully"));
            } else {
                echo json_encode(array("status" => FALSE, "message" => "Unable to add your comment"));
            }
        }
    }

    public static function feedback_subject()
    {
        $feedback_subject = array(
            "1" => "Marketing",
            "2" => "Merchant Portal",
            "3" => "Support",
            "4" => "Others",
        );
        return $feedback_subject;
    }

    public static function page_limit()
    {
        $per_page = array(
            "10" => "10",
            "25" => "25",
            "50" => "50",
            "75" => "75",
            "100" => "100"
        );
        return $per_page;
    }

    public function get_merchant_feedback(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $merchant_feedback = new MerchantFeedback();

            $feedback_details =  $merchant_feedback->get_feedback_details();
            session(['feedback-search' => $feedback_details]);
            $feedback_details_page = $this->_arrayPaginator($feedback_details, $request, "feedbackdetail", $perpage);
            return View::make(".merchant.pagination")->with(["feedbackdetails" => $feedback_details_page, "module" => "feedbackdetail"])->render();
        }
    }

    public function store_merchant_feedback(Request $request)
    {

        if ($request->ajax()) {
            $validate = Validator::make($request->all(), [
                'feed_subject' => 'required',
                'feed_rating' => 'required',
            ]);

            if ($validate->fails()) {
                echo json_encode(["status" => FALSE, "error" => $validate->errors()]);
            } else {

                $merchant_feedback = new MerchantFeedback();

                $feedback = $request->except("_token");

                $feedback["created_date"] =  $this->date_time;
                $feedback["created_merchant"] = Auth::user()->id;

                $insert_status = $merchant_feedback->add_feedback($feedback);

                if ($insert_status) {
                    echo json_encode(array("status" => TRUE, "message" => "Feedback added successfully"));
                } else {
                    echo json_encode(array("status" => FALSE, "message" => "Unable to add feedback"));
                }
            }
        }
    }


    public static function support_category()
    {
        $sup_category = array(
            "1" => "Bug",
            "2" => "Complaint",
            "3" => "Change Request",
            "4" => "Query Reuest",
            "5" => "Spam Ticket",
            "6" => "No Information"
        );
        return $sup_category;
    }


    public function get_merchant_support(Request $request, $perpage)
    {

        if ($request->ajax()) {
            $merchant_support = new MerchantSupport();

            $support_details = $merchant_support->get_support_details();
            session(['support-search' => $support_details]);
            $merchant_support_page = $this->_arrayPaginator($support_details, $request, "merchantsupport", $perpage);
            return View::make(".merchant.pagination")->with(["merchantsupports" => $merchant_support_page, "module" => "merchantsupport"])->render();
        }
    }

    public function store_merchant_support(Request $request)
    {

        if ($request->ajax()) {
            $validate = Validator::make($request->all(), [
                'title' => 'required',
                'sup_category' => 'required',
                'support_image' => 'file|mimes:jpg,jpeg,png|max:2000'
            ]);

            if ($validate->fails()) {
                echo json_encode(["status" => FALSE, "error" => $validate->errors()]);
            } else {

                $merchant_support = new MerchantSupport();

                $path_to_upload = Auth::user()->merchant_gid . "/support";

                $support = $request->except("_token", "support_image");

                foreach ($request->file() as $key => $value) {
                    $file = $request->file($key);
                    $support["sup_file_path"] = $file->store($path_to_upload);
                }
                $support["sup_gid"] = 'suprt_' . Str::random(16);
                $support["sup_from"] = Auth::user()->app_mode ? 'live' : 'test';
                $support["sup_status"] = "open";
                $support["created_date"] =  $this->date_time;
                $support["merchant_id"] = Auth::user()->id;


                $insert_status = $merchant_support->add_support($support);

                if ($insert_status) {
                    echo json_encode(array("status" => TRUE, "message" => "Support added successfully"));
                } else {
                    echo json_encode(array("status" => FALSE, "message" => "Unable to add support"));
                }
            }
        }
    }

    public function get_merchant_product(Request $request, $perpage)
    {

        if ($request->ajax()) {
            $product = new Product();
            if ($perpage == "all") {
                $products = $product->get_products();
                echo json_encode(["status" => TRUE, "products" => $products]);
            } else {

                $products = $product->get_products();
                session(['products-search' => $products]);
                $product_page = $this->_arrayPaginator($products, $request, "product", $perpage);
                return View::make(".merchant.pagination")->with(["products" => $product_page, "module" => "product"])->render();
            }
        }
    }

    public function store_merchant_product(Request $request)
    {

        if ($request->ajax()) {

            $rules = [
                "product_title" => "required|regex:/^[a-zA-Z ]+$/u",
                "product_price" => "required|numeric",
            ];
            $messages = [
                "product_title.regex" => "Product name doesn't allow special characters",
            ];

            $validator = Validator::make($request->all(), $rules, $messages);


            if ($validator->fails()) {
                echo json_encode(["status" => FALSE, "errors" => $validator->errors()]);
            } else {

                $product = new Product();

                $product_data = $request->except("_token");
                $product_data["product_gid"] = 'prod_' . Str::random(16);
                $product_data["created_date"] =  $this->date_time;
                $product_data["created_merchant"] = Auth::user()->id;

                $insert_status = $product->add_product($product_data);

                if ($insert_status) {
                    echo json_encode(array("status" => TRUE, "message" => "Product added successfully"));
                } else {
                    echo json_encode(array("status" => FALSE, "message" => "Unable to add product"));
                }
            }
        }
    }

    public function edit_merchant_product(Request $request, $id)
    {

        if ($request->ajax()) {
            $product = new Product();

            $products = $product->edit_product($id);

            echo json_encode($products);
        }
    }


    public function update_merchant_product(Request $request)
    {

        if ($request->ajax()) {
            $rules = [
                "product_title" => "required|regex:/^[a-zA-Z ]+$/u",
                "product_price" => "required|numeric",
            ];
            $messages = [
                "product_title.regex" => "Product name doesn't allow special characters",
            ];

            $validator = Validator::make($request->all(), $rules, $messages);


            if ($validator->fails()) {
                echo json_encode(["status" => FALSE, "errors" => $validator->errors()]);
            } else {

                $product_id = $request->only("id");
                $product_data = $request->except("_token", "id");
                $product = new Product();

                $update_status = $product->update_product($product_data, $product_id);

                if ($update_status) {
                    echo json_encode(array("status" => TRUE, "message" => "Product updated successfully"));
                } else {
                    echo json_encode(array("status" => FALSE, "message" => "Unable to update product"));
                }
            }
        }
    }

    public function delete_merchant_product(Request $request)
    {

        if ($request->ajax()) {
            $product_id = $request->only("id");
            $product_data = ["status" => "inactive"];
            $product = new Product();

            $product->update_product($product_data, $product_id);
        }
    }

    public function utilities(Request $request)
    {


        return view('merchant.utilities');
    }

    public function coupon(Request $request)
    {
        $currency = new Currency();
        return view('.merchant.couponnewedit')->with(["currencies" => $currency->get_currency(), "mode" => "add"]);
    }

    public function new_coupon_id(Request $request)
    {
        if ($request->ajax()) {
            echo json_encode(array("coupon_gid", strtoupper("Ryapaycoup" . Str::random(8))));
        }
    }

    public function get_all_coupon(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $coupon = new MerchantCoupon();
            $coupons = $coupon->get_coupons();
            session(['coupons-search' => $coupons]);
            $coupons_page = $this->_arrayPaginator($coupons, $request, "coupon", $perpage);
            return View::make(".merchant.pagination")->with(["coupons" => $coupons_page, "module" => "coupon"])->render();
        }
    }


    public function store_coupon(Request $request)
    {
        if ($request->ajax()) {
            $coupon = new MerchantCoupon();


            if (isset($request->id)) {
                $coupon_id = $request->only("id");
                $edit_coupondata = $request->except("id", "_token");

                $update_status = $coupon->update_coupon($edit_coupondata, $coupon_id);

                if ($update_status) {
                    echo json_encode(array("status" => TRUE, "message" => "Coupon updated successfully"));
                } else {
                    echo json_encode(array("status" => FALSE, "message" => "Nothing has changed to update"));
                }
            } else {

                $coupon_data = $request->except("_token");
                $coupon_data["created_date"] = $this->date_time;
                $coupon_data["created_merchant"] = Auth::user()->id;

                $insert_status = $coupon->add_coupon($coupon_data);

                if ($insert_status) {
                    echo json_encode(array("status" => TRUE, "message" => "Coupon added successfully"));
                } else {
                    echo json_encode(array("status" => FALSE, "message" => "Unable to add coupon"));
                }
            }
        }
    }

    public function edit_coupon(Request $request, $couponid)
    {
        $coupon = new MerchantCoupon();
        $currency = new Currency();
        $option = new CouponOption();
        $product = new Product();

        $products = $product->get_products();
        $coupon_data = $coupon->get_coupon($couponid);

        return view('.merchant.couponnewedit')->with([
            "currencies" => $currency->get_currency(), "mode" => "edit", "coupon_data" => $coupon_data, "coupon_types" => $option->get_types_subtypes(), "products" => $products
        ]);
    }

    public function employees(Request $request)
    {
        if (Auth::user()->app_mode == "1") {
            return view('merchant.users');
        } else {
            return redirect()->back();
        }
    }

    public function employeeTypes(Request $request)
    {
        if (Auth::user()->app_mode == "1") {
            $emp_type = AppOption::get_merchant_emptype();

            return view('merchant.usertypes')->with([
                "emp_types" => $emp_type
            ]);
        } else {
            return redirect()->back();
        }
    }


    public function get_employee_permissions(Request $request, $empid)
    {

        $merchantMenus = \App\MerchantMenus::get();

        $emp_type = AppOption::get_merchant_emptype();

        $employee = \App\MerchantEmployee::where('employee_gid', $empid)->first();

        return view('merchant.merchantEmployeeMenuPermission')->with([
            "emp_types" => $emp_type, 'employee' => $employee, 'merchantMenus' => $merchantMenus
        ]);
        //$merchantSubmenus=\App\MerchantSubmenus::get();

        // return View::make(".merchant.merchantEmployeeMenuPermission")->with(["typeid" => $typeid,"merchantMenus"=>$merchantMenus, "module" => "type"]);
    }


    public function store_type_permissions(Request $request)
    {
        $insert_status = 0;
        $typeid = 0;
        if ($request->ajax() || $request->post()) {
            $validator = Validator::make($request->all(), [
                'merchant_employee_id' => 'required'

            ]);

            if ($validator->fails()) {
                echo json_encode($validator->errors());
            } else {

                $post_data = $request->only('merchant_employee_id', 'menus', 'submenus');
                $submenus = $menus = '';
                if (isset($post_data['menus'])) {
                    $menus = json_encode($post_data['menus']);
                }
                if (isset($post_data['submenus'])) {
                    $submenus = json_encode($post_data['submenus']);
                }


                $menus = is_null($menus) ? '' : $menus;
                $submenus = is_null($submenus) ? '' : $submenus;



                $typeid = $post_data['merchant_employee_id'];

                $permissions = new \App\MerchantTypePermissions();

                $existType = $permissions->where('merchant_employee_id', $typeid)->first();

                if (($existType)) {

                    $existType->menus = $menus;
                    $existType->submenus = $submenus;
                    $existType->updated_date = $this->date_time;
                    $existType->updated_by = Auth::user()->id;
                    $existType->save();

                    $insert_status = 1;
                } else {

                    $perm['menus'] = $menus;
                    $perm['submenus'] = $submenus;
                    $perm['merchant_employee_id'] = $typeid;
                    $perm['created_date'] = $this->date_time;
                    $perm['created_by'] = Auth::user()->id;

                    $permissions->saveData($perm);

                    $insert_status = 1;
                }
            }
        }
        if ($insert_status) {
            echo json_encode(array("status" => TRUE, "message" => "Permissions added successfully", 'emp' => $typeid));
        } else {
            echo json_encode(array("status" => FALSE, "message" => "Unable to add Permissions"));
        }
    }



    public function create_employee(Request $request)
    {
        if (Auth::user()->app_mode == "1") {
            $emp_type = AppOption::get_merchant_emptype();
            return view('merchant.useraddedit')->with(["form" => "create", "emp_type" => $emp_type]);
        } else {
            return redirect()->back();
        }
    }

    public function get_employees(Request $request, $perpage)
    {

        $merchantempObject = new MerchantEmployee();
        $emplyee_data = $merchantempObject->get_merchant_employees();
        session(['employees-search' => $emplyee_data]);
        $paginate_employee = $this->_arrayPaginator($emplyee_data, $request, "employees", $perpage);
        return View::make(".merchant.pagination")->with(["employees" => $paginate_employee, "module" => "employee"])->render();
    }

    public function store_employee(Request $request)
    {

        if ($request->ajax()) {

            $merchant = User::where('email', $request['employee_email'])->first();
            if (empty($merchant)) {

                $employee_data = $request->except("_token");

                $rules = [
                    "employee_name" => "required|regex:/^[a-zA-Z ]+$/u|max:50",
                    "employee_email" => "required|string|email|max:50|unique:merchant_employee",
                    "employee_mobile" => "required|digits:10|numeric|unique:merchant_employee",
                    "employee_type" => "required|numeric",
                    "employee_password" => ['required', 'string', 'min:8', 'max:20', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'],
                ];

                $messages = [
                    'employee_password.regex' => 'Password should contain at least 1 Uppercase,1 Lowercase,1 Numeric & 1 Special character)'
                ];

                $validator = Validator::make($employee_data, $rules, $messages);

                if ($validator->fails()) {
                    echo json_encode(["status" => FALSE, "errors" => $validator->errors()]);
                } else {

                    $merchantempObject = new MerchantEmployee();

                    $merchantempcount = $merchantempObject->get_merchant_empcount();

                    $employee_data["employee_gid"] = "emp" . str_replace("rppay", "", Auth::user()->merchant_gid) . $merchantempcount[0]->emp_count;
                    $employee_data["employee_password"] = bcrypt($employee_data["employee_password"]);
                    $employee_data["created_date"] = $this->date_time;
                    $employee_data["created_merchant"] = Auth::user()->id;

                    $insert_status = $merchantempObject->add_merchant_employee($employee_data);
                    if ($insert_status) {
                        echo json_encode(array("status" => TRUE, "message" => "Employee added successfully"));
                    } else {
                        echo json_encode(array("status" => FALSE, "message" => "Unable to add employee"));
                    }
                }
            } else {

                echo json_encode(array("status" => FALSE, "message" => "This email address already taken please use another"));
            }
        }
    }

    public function edit_employee(Request $request, $employeeId)
    {
        $employee_info = [];
        $emp_type = AppOption::get_merchant_emptype();
        $merchantempObject = new MerchantEmployee();
        $employee_data = $merchantempObject->get_merchant_employee_info($employeeId);
        if (!empty($employee_data)) {
            $employee_info = $employee_data[0];
        }
        return view('merchant.useraddedit')->with(["form" => "edit", "emp_type" => $emp_type, "employee_info" => $employee_info]);
    }

    public function update_employee(Request $request)
    {
        if ($request->ajax()) {

            $employee_id = $request->only("id");

            $employee_data = $request->except("_token", "id");

            $rules = [
                "employee_name" => "required|regex:/^[a-zA-Z ]+$/u|max:50",
                "employee_email" => "required|string|email|max:50|unique:merchant_employee,id," . $employee_id["id"],
                "employee_mobile" => "required|digits:10|numeric|unique:merchant_employee,id," . $employee_id["id"],
                "employee_type" => "required|numeric",
            ];

            $validator = Validator::make($employee_data, $rules);

            if ($validator->fails()) {
                echo json_encode(["status" => FALSE, "errors" => $validator->errors()]);
            } else {

                $merchantempObject = new MerchantEmployee();

                $update_status = $merchantempObject->update_merchant_employee($employee_id, $employee_data);
                if ($update_status) {
                    echo json_encode(array("status" => TRUE, "message" => "Employee updated successfully"));
                } else {
                    echo json_encode(array("status" => TRUE, "message" => "Nothing has changed to update"));
                }
            }
        }
    }

    public function reset_employee_password(Request $request)
    {
        if ($request->json()) {

            $employee_id = $request->only("id");
            $reset_data = $request->except("_token");

            $rules = [
                "employee_password" => ['required', 'string', 'min:8', 'max:20', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'],
            ];

            $messages = [
                'employee_password.regex' => 'Password should contain at least 1 Uppercase,1 Lowercase,1 Numeric & 1 Special character)'
            ];

            $validator = Validator::make($reset_data, $rules, $messages);

            if ($validator->fails()) {

                echo json_encode(["status" => FALSE, "errors" => $validator->errors()]);
            } else {

                $merchantempObject = new MerchantEmployee();

                $reset_data["employee_password"] = bcrypt($request->employee_password);
                $update_status = $merchantempObject->update_merchant_employee($employee_id, $reset_data);

                if ($update_status) {
                    echo json_encode(array("status" => TRUE, "message" => "Employee password reset successfully"));
                } else {
                    echo json_encode(array("status" => TRUE, "message" => "Unable to reset password"));
                }
            }
        }
    }

    public function update_employee_status(Request $request)
    {
        if ($request->ajax()) {

            $employee_id = $request->only("id");
            $form_data = $request->except("_token", "id");

            $merchantempObject = new MerchantEmployee();
            $update_status = $merchantempObject->update_merchant_employee($employee_id, $form_data);

            if ($update_status) {
                echo json_encode(array("status" => TRUE, "message" => "Employee status changed successfully"));
            } else {
                echo json_encode(array("status" => FALSE, "message" => "Already employee status got change"));
            }
        }
    }

    public function unlock_employee(Request $request, $employee_id)
    {
        if ($request->ajax()) {
            $merchantempObject = new MerchantEmployee();
            $update_status = $merchantempObject->unlock_merchant_employee($employee_id);

            if ($update_status) {
                echo json_encode(array("status" => TRUE, "message" => "Employee account got unlock successfully"));
            } else {
                echo json_encode(array("status" => TRUE, "message" => "Already employee account is in unlock status"));
            }
        }
    }


    public function get_types_subtypes()
    {
        $option = new CouponOption();
        echo json_encode($option->get_types_subtypes());
    }

    public function my_account(Request $request)
    {
        $merchantinfo = new User();
        $basicinfo = $merchantinfo->get_merchant_details();
        return view(".merchant.myaccount")->with(["basicinfo" => $basicinfo, "activetab" => ""]);
    }

    public function my_account_tab(Request $request, $id)
    {
        $merchantinfo = new User();
        $basicinfo = $merchantinfo->get_merchant_details();
        return view(".merchant.myaccount")->with(["basicinfo" => $basicinfo, "activetab" => $id]);
    }

    public function change_password(Request $request)
    {

        if ($request->has("password") && $request->has("password_confirmation")) {
            $validator = Validator::make($request->all(), [
                'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'],
            ], ['password.regex' => 'Password should contain at-least 1 Uppercase,1 Lowercase,1 Numeric & 1 Special character)']);

            if ($validator->fails()) {
                return redirect()->back()->with(["errors" => $validator->errors(), 'tab-active' => true, "current-password-form" => true, "change-password-form" => true]);
            } else {

                $user = new User();
                $field["password"] = bcrypt($request->password);
                $user->update_merchant($field);
                $set_notification = new NotiMessController();
                $set_notification->password_change_notification();
                GenerateLogs::password_reset(Auth::user()->name, "Change password");
                Auth::logout();
                $request->session()->invalidate();
                session()->flash('password-change-message', 'Your password has changed successfully! Please Login');
                return redirect('/login');
            }
        } else {

            $rules = [
                "password" => "required|string",
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->with(["errors" => $validator->errors(), 'tab-active' => true]);
            } else {

                $merchant = User::where('email', Auth::user()->email)->first();

                $validCredentials = Hash::check($request['password'], $merchant->getAuthPassword());

                if ($validCredentials) {
                    return redirect()->back()->with(["message" => "You can change your password", 'tab-active' => true, "current-password-form" => true, "change-password-form" => true]);
                } else {
                    return redirect()->back()->with(["wrong-password" => "You have entered wrong password", 'tab-active' => true, "current-password-form" => false]);
                }
            }
        }
    }

    public function update_mydetails(Request $request)
    {

        if ($request->ajax()) {

            if (!empty($request->email)) {
                $validator = Validator::make($request->all(), [
                    'email' => 'required|string|email|max:50|unique:merchant',
                ], ['email.unique' => 'This email has already been taken.']);

                if ($validator->fails()) {
                    echo json_encode(["errors" => $validator->errors(), 'email' => false]);
                } else {

                    $OTP = mt_rand(99999, 1000000);

                    $data = array(
                        "from" => env("MAIL_USERNAME", ""),
                        "subject" => "Request For Changing Email Address",
                        "view" => "/maillayouts/changeemail",
                        "htmldata" => array(
                            "name" => Auth::user()->name,
                            "otp" => $OTP,
                            "email" => $request->email,
                        ),
                    );
                    session(['sent_otp' => $OTP, 'email_address' => $request->email]);

                    if (Mail::to($request->email)->send(new SendMail($data))) {
                        $emailsmsObject = new EmailSmsLogs();
                        $emailsmsObject->email_logs($app = "Merchant", $module = "Password Reset Successful Email", $email_to = $request->email, $email_cc = "", $email_bcc = "", $email_status = "Success");
                    } else {

                        $emailsmsObject = new EmailSmsLogs();
                        $emailsmsObject->email_logs($app = "Merchant", $module = "Password Reset Successful Email", $email_to = $request->email, $email_cc = "", $email_bcc = "", $email_status = "Failed");
                    }
                    echo json_encode(['status' => true, 'message' => 'An email has sent to given email address', 'otp' => true]);
                }
            } else if (!empty($request->email_otp)) {
                if (session('sent_otp') == $request->email_otp) {
                    $user = new User();
                    $field["email"] = session('email_address');
                    session()->forget('email_address');
                    session()->forget('sent_otp');
                    $user->update_merchant($field);
                    Auth::logout();
                    $request->session()->invalidate();
                    session()->flash('password-change-message', 'Your Email has changed successfully! Please Login');
                    echo json_encode(['status' => true, 'message' => 'Your Email has changed successfully! Please Login', 'email_change' => true]);
                } else {

                    echo json_encode(['status' => true, 'message' => 'please enter a valid OTP', 'email_change' => false]);
                }
            } else if (isset($request->mobile_no) && !empty($request->mobile_no)) {
                $validator = Validator::make($request->all(), [
                    'mobile_no' => 'required|numeric|digits:10|unique:merchant',
                ], ['mobile.unique' => 'This Mobile number has already been taken.']);

                if ($validator->fails()) {
                    echo json_encode(["errors" => $validator->errors(), 'mobile' => false]);
                } else {

                    $OTP = mt_rand(99999, 1000000);

                    $message = "Dear " . Auth::user()->name . " ,\nYou are receiving this sms because we received a Mobile no change request for your account.\nPlease use this OTP " . $OTP . " for changing your Mobile number.";

                    $sms = new SmsController($message, $request->mobile_no);

                    $sms->sendMessage();
                    session(['mobile_otp' => $OTP, 'mobileno' => $request->mobile_no]);
                    echo json_encode(['status' => true, 'message' => 'A sms has sent to given Mobile', 'mobile' => true]);
                }
            } else if (!empty($request->mobile_otp)) {
                if (session('mobile_otp') == $request->mobile_otp) {
                    $user = new User();
                    $field["mobile_no"] = session('mobileno');
                    $user->update_merchant($field);
                    session()->forget('mobileno');
                    session()->forget('mobile_otp');
                    echo json_encode(['status' => true, 'message' => 'Your Mobile no has changed successfully!', 'mobile_change' => true, 'mobile_no' => $field["mobile_no"]]);
                } else {

                    echo json_encode(['status' => false, 'message' => 'please enter a valid OTP', 'mobile_change' => false]);
                }
            } else if (isset($request->name) && !empty($request->name)) {

                $user = new User();
                $field["name"] = $request->name;
                $user->update_merchant($field);
                echo json_encode(['status' => true, 'message' => 'Your Name has changed successfully!', 'name_change' => true]);
            } else {

                if ($request->has("email_otp") && empty($request->email_otp)) {
                    echo json_encode(['status' => true, 'message' => 'OTP field is empty', 'email_change' => false]);
                } else if ($request->has("mobile_otp") && empty($request->mobile_otp)) {

                    echo json_encode(['status' => true, 'message' => 'OTP field is empty', 'mobile_change' => false]);
                } else if ($request->has("name") && empty($request->name)) {

                    echo json_encode(['status' => true, 'message' => 'Name field is empty', 'name_change' => false]);
                }
            }
        }
    }

    public function resend_changeemail(Request $request)
    {
        if ($request->ajax()) {
            if (!empty(session('email_address'))) {
                $OTP = mt_rand(99999, 1000000);

                $data = array(
                    "from" => env("MAIL_USERNAME", ""),
                    "subject" => "Request For Changing Email Address",
                    "view" => "/maillayouts/changeemail",
                    "htmldata" => array(
                        "name" => Auth::user()->name,
                        "otp" => $OTP,
                        "email" => session('email_address'),
                    ),
                );

                session(['sent_otp' => $OTP, 'email_address' => session('email_address')]);
                if (Mail::to(session('email_address'))->send(new SendMail($data))) {
                    $emailsmsObject = new EmailSmsLogs();
                    $emailsmsObject->email_logs($app = "Merchant", $module = "Password Reset Successful Email", $email_to = session('email_address'), $email_cc = "", $email_bcc = "", $email_status = "Success");
                } else {

                    $emailsmsObject = new EmailSmsLogs();
                    $emailsmsObject->email_logs($app = "Merchant", $module = "Password Reset Successful Email", $email_to = session('email_address'), $email_cc = "", $email_bcc = "", $email_status = "Failed");
                }
                echo json_encode(['status' => true, 'message' => 'An email has sent again to given email address']);
            }
        }
    }

    public function resend_changemobile(Request $request)
    {
        if ($request->ajax()) {

            if (!empty(session('mobileno'))) {

                if (session()->has("resend_message_attempt_count")) {
                    session(["resend_message_attempt_count" => session("resend_message_attempt_count") + 1]);
                } else {
                    session(["resend_message_attempt_count" => 1]);
                }

                if (session("resend_message_attempt_count") < 4) {

                    $OTP = mt_rand(99999, 1000000);

                    $message = "Dear " . Auth::user()->name . " ,\nYou are receiving this sms because we received a Mobile no change request for your account.\nPlease use this OTP " . $OTP . " for changing your Mobile number.";

                    $sms = new SmsController($message, session('mobileno'));

                    $sms->sendMessage();

                    session(['mobile_otp' => $OTP, 'mobileno' => session('mobileno')]);

                    echo json_encode(['status' => true, 'message' => 'An sms has sent again to given Mobile number']);
                } else {

                    echo json_encode(['status' => true, 'message' => 'You have completed maximum no of attempts']);
                }
            }
        }
    }

    public function payment_page(Request $request, $page)
    {

        $variable = $page;
        switch ($variable) {
            case 'single-product':
                return view(".merchant.paymentpages.singleproductpage")->with(["form" => "create", "loadcss" => "single-product", "loadscript" => "single-product"]);
                break;
            case 'charity':
                return view(".merchant.paymentpages.charitypage")->with(["form" => "create", "loadcss" => "charity", "loadscript" => "charity"]);
                break;

            default:
                # code...
                break;
        }
    }

    public function get_all_page_details(Request $request, $perpage)
    {
        if ($request->ajax()) {

            $payment_pageObject = new PaymentPage();

            $page_details = $payment_pageObject->get_page_details();
            session(['page-details' => $page_details]);
            $pagedetails_page = $this->_arrayPaginator($page_details, $request, "pagedetail", $perpage);
            return View::make(".merchant.pagination")->with(["pagedetails" => $pagedetails_page, "module" => "pagedetail"])->render();
        }
    }


    public function store_pagedetail(Request $request)
    {
        if ($request->ajax()) {


            if ($request->has("id")) {
                $record_id = $request->only("id");
                $payment_page = $request->except("_token", "id");
                if ($request->file('page_logo')) {

                    $pagelogo = $request->file('page_logo');
                    $name = md5($pagelogo->getClientOriginalName()) . "." . $pagelogo->getClientOriginalExtension();
                    $destinationPath = public_path('/storage/paymentpagelogos/' . Auth::user()->merchant_gid . '/');
                    $pagelogo->move($destinationPath, $name);
                    $payment_page["page_logo"] = $name;
                }

                $payment_pageObject = new PaymentPage();

                $payment_pageObject->update_page_details($record_id, $payment_page);
                $payment_page_id = $request->id;
            } else {

                $name = "";
                if ($request->file('page_logo')) {

                    $pagelogo = $request->file('page_logo');
                    $name = md5($pagelogo->getClientOriginalName()) . "." . $pagelogo->getClientOriginalExtension();
                    $destinationPath = public_path('/storage/paymentpagelogos/' . Auth::user()->merchant_gid . '/');
                    $pagelogo->move($destinationPath, $name);
                }
                $payment_page = $request->except("_token");
                $payment_page["page_logo"] = $name;
                $payment_page["page_gid"] = Str::random(6);
                $payment_page["page_url"] = Str::random(8);
                $payment_page["created_date"] = $this->date_time;
                $payment_page["created_merchant"] = Auth::user()->id;

                $payment_pageObject = new PaymentPage();

                $payment_page_id = $payment_pageObject->add_page_details($payment_page);
            }
            echo json_encode(["status" => TRUE, "paymentpageId" => $payment_page_id]);
        }
    }

    public function store_page_inputdetail(Request $request)
    {
        if ($request->ajax()) {

            $payment_inputObject = new PaymentPageInput();

            $payement_page_inputcount = $payment_inputObject->get_page_inputs_count($request->paymentpageId);

            $success_message = "Page added successfully";
            $fail_message = "Unable to add Page";

            if ($payement_page_inputcount[0]->no_of_inputs > 0) {

                $payment_inputObject->remove_page_inputs($request->paymentpageId);
                $success_message = "Page updated successfully";
                $fail_message = "Nothing has changed to update";
            }

            $payment_page_inputs = [];

            $page_data = $request->only("input_detail");

            $payment_page_id = $request->paymentpageId;

            foreach ($page_data["input_detail"]["input_label"] as $key => $value) {

                $payment_page_inputs[$key]["payment_page_id"] = $payment_page_id;
                $payment_page_inputs[$key]["input_label"] = $value;
                $payment_page_inputs[$key]["input_type"] = $page_data["input_detail"]["input_type"][$key];
                $payment_page_inputs[$key]["input_name"] = $page_data["input_detail"]["input_name"][$key];
                $payment_page_inputs[$key]["input_value"] = isset($page_data["input_detail"]["input_value"][$key]) ? $page_data["input_detail"]["input_value"][$key] : '';
                $payment_page_inputs[$key]["input_option"] = isset($page_data["input_detail"]["input_option"][$key]) ? $page_data["input_detail"]["input_option"][$key] : '';
                $payment_page_inputs[$key]["input_mandatory"] = isset($page_data["input_detail"]["input_mandatory"][$key]) ? $page_data["input_detail"]["input_mandatory"][$key] : 'false';
            }

            $payment_status = $payment_inputObject->add_page_inputs($payment_page_inputs);

            if ($payment_status) {
                echo json_encode(array("status" => TRUE, "message" => $success_message));
            } else {
                echo json_encode(array("status" => FALSE, "message" => $fail_message));
            }
        }
    }

    public function edit_page_details(Request $request, $pageid)
    {
        if (!empty($pageid)) {

            $payment_pageObject = new PaymentPage();
            $page_details = $payment_pageObject->edit_page_detail($pageid);
            $inputs = ['input_label', 'input_name', 'input_type', 'input_value', 'input_option', 'input_mandatory'];
            $page_inputs = [];
            $page_detail = [];
            $page_load = "";
            foreach ($page_details as $index => $object) {
                foreach ($object as $key => $value) {
                    if (in_array($key, $inputs)) {
                        $page_inputs[$index][$key] = $value;
                    } else {
                        if ($index == 0) {
                            $page_detail[$key] = $value;
                            $page_load = $object->page_name;
                        }
                    }
                }
            }

            $page_detail["page_inputs"] = $page_inputs;

            switch ($page_detail["page_name"]) {
                case 'singleproductpage':
                    $loadcss = "single-product";
                    $loadscript = "single-product";
                    break;
                case 'charitypage':
                    $loadcss = "charity";
                    $loadscript = "charity";
                    break;
            }
            return view("merchant.paymentpages." . $page_load)->with(["form" => "edit", "loadcss" => $loadcss, "loadscript" => $loadscript, "page_details" => $page_detail]);
        } else {
            return redirect()->back();
        }
    }

    public function change_page_status(Request $request)
    {

        $payment_pageObject = new PaymentPage();
        $page_status = $request->only("page_status");
        $pageId = $request->except("_token", "page_status");

        $message = "Page is activated successfully";

        if ($page_status["page_status"] == "inactive") {
            $message = "Page is deactivated successfully";
        }

        $update_status = $payment_pageObject->update_page_details($pageId, $page_status);

        if ($update_status) {
            echo json_encode(array("status" => TRUE, "message" => $message));
        } else {
            echo json_encode(array("status" => FALSE, "message" => "Unable to change page status"));
        }
    }

    public function merchant_pagination(Request $request, $module, $perpage)
    {

        switch ($module) {

            case 'dash_payment':

                $transaction = new Payment();
                $transactions = $transaction->get_dashboard_payments(session('dash_from_date'), session('dash_to_date'));
                $trans_page = $this->_arrayPaginator($transactions, $request, "dash_payment", $perpage);
                return View::make(".merchant.pagination")->with(["transactions" => $trans_page, "module" => $module])->render();
                break;

            case 'dash_refund':

                $refund = new Refund();
                $refunds = $refund->get_dashboard_refunds(session('dash_from_date'), session('dash_to_date'));
                $refunds_page = $this->_arrayPaginator($refunds, $request, "dash_refund", $perpage);
                return View::make(".merchant.pagination")->with(["refunds" => $refunds_page, "module" => $module])->render();
                break;

            case 'dash_setllement':

                $settlement = new Settlement();
                $settlements = $settlement->get_dashboard_settlements(session('dash_from_date'), session('dash_to_date'));
                $settlements_page = $this->_arrayPaginator($settlements, $request, "dash_setllement", $perpage);
                return View::make(".merchant.pagination")->with(["settlements" => $settlements_page, "module" => $module])->render();
                break;

            case 'dash_logactivities':

                $log_activity = new MerchantLogActivity();
                $logactivities = $log_activity->get_merchant_log(session('dash_from_date'), session('dash_to_date'));
                $logactivities_page = $this->_arrayPaginator($logactivities, $request, "dash_logactivities", $perpage);
                return View::make(".merchant.pagination")->with(["logactivity" => $logactivities_page, "module" => $module])->render();
                break;

            case 'payment':

                $transaction = new Payment();
                $transactions = $transaction->get_all_payments();
                $trans_page = $this->_arrayPaginator($transactions, $request, "payment", $perpage);
                return View::make(".merchant.pagination")->with(["transactions" => $trans_page, "module" => $module])->render();
                break;

            case 'refund':

                $refund = new Refund();
                $refunds = $refund->get_all_refunds();
                $refunds_page = $this->_arrayPaginator($refunds, $request, "refund", $perpage);
                return View::make("merchant.pagination")->with(["refunds" => $refunds_page, "module" => $module])->render();
                break;

            case 'order':

                $order = new Order();
                $orders = $order->get_all_orders();
                $orders_page = $this->_arrayPaginator($orders, $request, "order", $perpage);
                return View::make("merchant.pagination")->with(["orders" => $orders_page, "module" => $module])->render();
                break;


            case 'dispute':

                $dispute = new Dispute();
                $disputes = $dispute->get_all_disputes();
                $disputes_page = $this->_arrayPaginator($disputes, $request, "dispute", $perpage);
                return View::make("merchant.pagination")->with(["disputes" => $disputes_page, "module" => $module])->render();
                break;

            case 'paylink':

                $paylink = new Paylink();
                $paylinks = $paylink->get_all_paylinks();
                $paylinks_page = $this->_arrayPaginator($paylinks, $request, "paylink", $perpage);
                return View::make("merchant.pagination")->with(["paylinks" => $paylinks_page, "module" => $module])->render();
                break;

            case 'quicklink':

                $paylink = new Paylink();
                $quick_links = $paylink->get_all_quicklinks();
                $paylinks_page = $this->_arrayPaginator($quick_links, $request, "quicklink", $perpage);
                return View::make(".merchant.pagination")->with(["quicklinks" => $paylinks_page, "module" => "quicklink"])->render();
                break;

            case 'invoice':

                $invoice = new Invoice();
                $invoices =  $invoice->get_all_invoices();
                $invoices_page = $this->_arrayPaginator($invoices, $request, "invoice", $perpage);
                return View::make(".merchant.pagination")->with(["invoices" => $invoices_page, "module" => "invoice"])->render();
                break;


            case 'item':

                $item = new Item();
                $items = $item->get_all_items();
                $items_page = $this->_arrayPaginator($items, $request, "item", $perpage);
                return View::make("merchant.pagination")->with(["items" => $items_page, "module" => $module])->render();
                break;

            case 'customer':

                $customer  = new Customer();
                $customers = $customer->get_all_customers();
                $customers_page = $this->_arrayPaginator($customers, $request, "customer", $perpage);
                return View::make(".merchant.pagination")->with(["customers" => $customers_page, "module" => "customer"])->render();
                break;

            case 'casedetail':

                $customer_case = new CustomerCase();
                $case_details = $customer_case->get_case();
                $case_details_page = $this->_arrayPaginator($case_details, $request, "casedetail", $perpage);
                return View::make(".merchant.pagination")->with(["casedetails" => $case_details_page, "module" => "casedetail"])->render();
                break;

            case 'feedbackdetail':

                $merchant_feedback = new MerchantFeedback();
                $feedback_details =  $merchant_feedback->get_feedback_details();
                $feedback_details_page = $this->_arrayPaginator($feedback_details, $request, "feedbackdetail", $perpage);
                return View::make(".merchant.pagination")->with(["feedbackdetails" => $feedback_details_page, "module" => "feedbackdetail"])->render();
                break;

            case 'merchantsupport':

                $merchant_support = new MerchantSupport();
                $merchat_data = $merchant_support->get_support_details();
                $merchant_support_page = $this->_arrayPaginator($merchat_data, $request, "merchantsupport", $perpage);
                return View::make(".merchant.pagination")->with(["merchantsupports" => $merchant_support_page, "module" => "merchantsupport"])->render();
                break;

            case 'notification':
                $notifies = new NotiMessController();
                $notifications = $notifies->get_table_notifications();
                $notifications_page = $this->_arrayPaginator($notifications, $request, "notification", $perpage);
                return View::make(".merchant.pagination")->with(["notifications" => $notifications_page, "module" => "notification"])->render();
                break;

            case 'message':
                $notifies = new NotiMessController();
                $messages = $notifies->get_table_messages();
                $messages_page = $this->_arrayPaginator($messages, $request, "message", $perpage);
                return View::make(".merchant.pagination")->with(["messages" => $messages_page, "module" => "message"])->render();
                break;

            case 'coupon':

                $coupon = new MerchantCoupon();
                $coupons = $coupon->get_coupons();
                $coupons_page = $this->_arrayPaginator($coupons, $request, "coupon", $perpage);
                return View::make(".merchant.pagination")->with(["coupons" => $coupons_page, "module" => "coupon"])->render();
                break;

            case 'product':

                $product = new Product();
                $products = $product->get_products();
                $product_page = $this->_arrayPaginator($products, $request, "product", $perpage);
                return View::make(".merchant.pagination")->with(["products" => $product_page, "module" => "product"])->render();
                break;

            default:

                break;
        }
    }

    public function merchant_search(Request $request, $module, $search_value, $perpage = 10)
    {

        $searched_array = array();

        switch ($module) {

            case 'dash_payment':

                $searched_array = $this->_search_algorithm($request->session()->get('dash-payments-search'), $search_value);
                $trans_page = $this->_arrayPaginator($searched_array, $request, "dash_payment", $perpage);
                return View::make(".merchant.pagination")->with(["transactions" => $trans_page, "module" => $module])->render();
                break;

            case 'dash_refund':

                $searched_array = $this->_search_algorithm($request->session()->get('dash-refunds-search'), $search_value);
                $refunds_page = $this->_arrayPaginator($searched_array, $request, "dash_refund", $perpage);
                return View::make(".merchant.pagination")->with(["refunds" => $refunds_page, "module" => $module])->render();
                break;

            case 'dash_settlement':

                $searched_array = $this->_search_algorithm($request->session()->get('dash-settlements-search'), $search_value);
                $settlements_page = $this->_arrayPaginator($searched_array, $request, "dash_setllement", $perpage);
                return View::make(".merchant.pagination")->with(["settlements" => $settlements_page, "module" => $module])->render();
                break;

            case 'dash_logactivities':

                $searched_array = $this->_search_algorithm($request->session()->get('dash-logactivities-search'), $search_value);
                $logactivities_page = $this->_arrayPaginator($searched_array, $request, "dash_logactivities", $perpage);
                return View::make(".merchant.pagination")->with(["logactivity" => $logactivities_page, "module" => $module])->render();
                break;

            case 'payment':

                $searched_array = $this->_search_algorithm($request->session()->get('payments-search'), $search_value);
                $trans_page = $this->_arrayPaginator($searched_array, $request, "payment", $perpage);
                return View::make(".merchant.pagination")->with(["transactions" => $trans_page, "module" => $module])->render();
                break;

            case 'refund':

                $searched_array = $this->_search_algorithm($request->session()->get('refunds-search'), $search_value);
                $refunds_page = $this->_arrayPaginator($searched_array, $request, "refund", $perpage);
                return View::make("merchant.pagination")->with(["refunds" => $refunds_page, "module" => $module])->render();
                break;

            case 'order':

                $searched_array = $this->_search_algorithm($request->session()->get('orders-search'), $search_value);
                $orders_page = $this->_arrayPaginator($searched_array, $request, "order", $perpage);
                return View::make("merchant.pagination")->with(["orders" => $orders_page, "module" => $module])->render();
                break;


            case 'dispute':

                $searched_array = $this->_search_algorithm($request->session()->get('disputes-search'), $search_value);
                $disputes_page = $this->_arrayPaginator($searched_array, $request, "dispute", $perpage);
                return View::make("merchant.pagination")->with(["disputes" => $disputes_page, "module" => $module])->render();
                break;

            case 'paylink':

                $searched_array = $this->_search_algorithm($request->session()->get('paylinks-search'), $search_value);
                $paylinks_page = $this->_arrayPaginator($searched_array, $request, "paylink", $perpage);
                return View::make("merchant.pagination")->with(["paylinks" => $paylinks_page, "module" => $module])->render();
                break;

            case 'quicklink':

                $searched_array = $this->_search_algorithm($request->session()->get('quicklinks-search'), $search_value);
                $paylinks_page = $this->_arrayPaginator($searched_array, $request, "quicklink", $perpage);
                return View::make(".merchant.pagination")->with(["quicklinks" => $paylinks_page, "module" => "quicklink"])->render();
                break;

            case 'invoice':

                $searched_array = $this->_search_algorithm($request->session()->get('invoices-search'), $search_value);
                $invoices_page = $this->_arrayPaginator($searched_array, $request, "invoice", $perpage);
                return View::make(".merchant.pagination")->with(["invoices" => $invoices_page, "module" => "invoice"])->render();
                break;


            case 'item':

                $searched_array = $this->_search_algorithm($request->session()->get('items-search'), $search_value);
                $items_page = $this->_arrayPaginator($searched_array, $request, "item", $perpage);
                return View::make("merchant.pagination")->with(["items" => $items_page, "module" => $module])->render();
                break;

            case 'customer':

                $searched_array = $this->_search_algorithm($request->session()->get('customers-search'), $search_value);
                $customers_page = $this->_arrayPaginator($searched_array, $request, "customer", $perpage);
                return View::make(".merchant.pagination")->with(["customers" => $customers_page, "module" => "customer"])->render();
                break;

            case 'casedetail':

                $searched_array = $this->_search_algorithm($request->session()->get('case-search'), $search_value);
                $case_details_page = $this->_arrayPaginator($searched_array, $request, "casedetail", $perpage);
                return View::make(".merchant.pagination")->with(["casedetails" => $case_details_page, "module" => "casedetail"])->render();
                break;

            case 'feedbackdetail':

                $searched_array = $this->_search_algorithm($request->session()->get('feedback-search'), $search_value);
                $feedback_details_page = $this->_arrayPaginator($searched_array, $request, "feedbackdetail", $perpage);
                return View::make(".merchant.pagination")->with(["feedbackdetails" => $feedback_details_page, "module" => "feedbackdetail"])->render();
                break;

            case 'merchantsupport':

                $searched_array = $this->_search_algorithm($request->session()->get('support-search'), $search_value);
                $merchant_support_page = $this->_arrayPaginator($searched_array, $request, "merchantsupport", $perpage);
                return View::make(".merchant.pagination")->with(["merchantsupports" => $merchant_support_page, "module" => "merchantsupport"])->render();
                break;

            case 'notification':

                $searched_array = $this->_search_algorithm($request->session()->get('notifications-search'), $search_value);
                $notifications_page = $this->_arrayPaginator($searched_array, $request, "notification", $perpage);
                return View::make(".merchant.pagination")->with(["notifications" => $notifications_page, "module" => "notification"])->render();
                break;

            case 'message':

                $searched_array = $this->_search_algorithm($request->session()->get('messages-search'), $search_value);
                $messages_page = $this->_arrayPaginator($searched_array, $request, "message", $perpage);
                return View::make(".merchant.pagination")->with(["messages" => $messages_page, "module" => "message"])->render();
                break;

            case 'coupon':

                $searched_array = $this->_search_algorithm($request->session()->get('coupons-search'), $search_value);
                $coupons_page = $this->_arrayPaginator($searched_array, $request, "coupon", $perpage);
                return View::make(".merchant.pagination")->with(["coupons" => $coupons_page, "module" => "coupon"])->render();
                break;

            case 'product':

                $searched_array = $this->_search_algorithm($request->session()->get('products-search'), $search_value);
                $product_page = $this->_arrayPaginator($searched_array, $request, "product", $perpage);
                return View::make(".merchant.pagination")->with(["products" => $product_page, "module" => "product"])->render();
                break;

            default:

                break;
        }
    }

    private function _search_algorithm($search_array, $search_key)
    {
        $search_result = [];
        foreach ($search_array as $index => $object) {
            foreach ($object as $key => $value) {
                if (preg_match("/{$search_key}/i", $value)) {
                    $search_result[$index] = $object;
                }
            }
        }

        return $search_result;
    }

    public function download_transaction(Request $request)
    {

        $fromdate = $this->today;
        $todate = $this->today;
        if (!empty($request->trans_from_date) && !empty($request->trans_to_date)) {
            $fromdate = $request->trans_from_date;
            $todate = $request->trans_to_date;
            $perpage = $request->perpage;
        }
        $payment = new Payment();
        $transactions_result = $payment->get_transactions_bydaterange($fromdate, $todate);
        //$transactions = $this->transaction_setup($transactions_result);
        $transactionObject = collect($transactions_result)->map(function ($item) {
            return (object) $item;
        });
// dd($transactions_result);
        $filename = "Transactions-" . $fromdate . "_" . $todate . ".xlsx";
        return Excel::download(new MerchantTransactionExport($transactions_result), $filename);
    }

    public function gstinvoicereport(Request $request)
    {



        if ($request->ajax()) {
            $dates = $request->except("_token");

            $module = $request->module;

            $perpage = $request->perpage;

            if (empty($request->gst_report_from_date) && empty($request->gst_report_to_date)) {

                $startDate = time();

                $dates["gst_report_from_date"] = date('Y-m-d', strtotime('-6 days', $startDate));

                $dates["gst_report_to_date"] = date("Y-m-d");
            } else {
                $dates["gst_report_from_date"] = $request->gst_report_from_date;

                $dates["gst_report_to_date"] = $request->gst_report_to_date;
            }
            session(['gst_report_from_date' => $dates["gst_report_from_date"], 'gst_report_to_date' => $dates["gst_report_to_date"]]);

            $settlements = Settlement::select(
                "id",
                "settlement_receiptno",
                DB::raw("(sum(settlement_fee)) as total_fee"),
                DB::raw("(sum(settlement_tax)) as total_tax"),
                DB::raw("(DATE_FORMAT(settlement_date, '%d-%m-%Y')) as my_date")
            )
                ->where('created_merchant', Auth::user()->id)
                ->groupBy(DB::raw("DATE_FORMAT(settlement_date, '%d-%m-%Y')"))
                ->get();

            return array(
                'status' => 1,
                'gst_invoice_report' => view('.merchant.report.gst_invoice_report', compact('settlements'))->render()
            );
        }

        if ($request->isMethod('post')) {


            $report_filter = array(
                'mode' => 'all',
                'status' => 1,
                'from' => $request->gst_excel_from_date,
                'to' => $request->gst_excel_to_date,
                'app_mode' => 1

            );

            $filename = "GST-INVOICE" . $report_filter['from'] . "-to-" . $report_filter['to'] . ".xlsx";
            return Excel::download(new \App\Exports\ReportGstExport($report_filter), $filename);
        }


        $settlements = Settlement::select(
            "id",
            "settlement_receiptno",
            DB::raw("(sum(settlement_fee)) as total_fee"),
            DB::raw("(sum(settlement_tax)) as total_tax"),
            DB::raw("(DATE_FORMAT(settlement_date, '%d-%m-%Y')) as my_date")
        )
            ->where('created_merchant', Auth::user()->id)
            ->groupBy(DB::raw("DATE_FORMAT(settlement_date, '%d-%m-%Y')"))
            ->get();

        $data = DB::table('live_settlement')->where('created_merchant', Auth::user()->id)->get();

        return view('merchant.gstinvoicereport', compact('data', 'settlements'));
    }

    public function gstdetailExcel(Request $request)
    {

        if ($request->isMethod('get')) {

            $report_filter = array(
                'mode' => 'all',
                'status' => 1,
                'date' => $request->date,

                'app_mode' => 1

            );

            $filename = "GST-INVOICE-detail" . $report_filter['date'] . ".xlsx";
            return Excel::download(new \App\Exports\ReportGstDetailsExport($report_filter), $filename);
        }
    }

    public function gstinvoicereportdetails(Request $request)
    {

        if ($request->isMethod('post')) {

            $db = Settlement::where('created_merchant', Auth::user()->id);

            if ($request['filter_date'] != null) {
                $db->whereDate('settlement_date', Carbon::parse($request['filter_date'])->format('Y-m-d'));
            }

            $data = $db->get();


            return array(
                'status' => 1,

                'detail_view' => view('.merchant.report.gstreportdetails', compact('data'))->render()
            );
        }
    }


    public function gstinvoiceId()
    {
        $settlement = new \App\Settlement('live');

        $results = $settlement->select(
            "id",
            "created_merchant",
            "settlement_date",
            "settlement_receiptno",
            DB::raw("(sum(settlement_fee)) as total_fee"),
            DB::raw("(sum(settlement_tax)) as total_tax"),
            DB::raw("(DATE_FORMAT(settlement_date, '%d-%m-%Y')) as my_date")
        )
            //->where('created_merchant',Auth::user()->id)
            ->where('settlement_receiptno', "=", NULL)
            ->groupBy([DB::raw("DATE_FORMAT(settlement_date, '%d-%m-%Y')"), "created_merchant"])
            ->orderBy('id', 'asc')

            ->get();

        foreach ($results as $result) {
            // sleep(3);
            //check if alreay entry for date and merchant
            $db = $settlement->where('created_merchant', $result->created_merchant);
            $db->whereDate('settlement_date', Carbon::parse($result->my_date)->format('Y-m-d'));
            $db->where('settlement_receiptno', "!=", NULL);
            $data = $db->first();

            if ($data) {
                $settlement_receiptno = $data->settlement_receiptno;
                $splitArray = explode('-', $settlement_receiptno);
                $count = $splitArray[1];

                $updateDataQuery = $settlement->where('created_merchant', $result->created_merchant)->whereDate('settlement_date', Carbon::parse($result->my_date)->format('Y-m-d'))
                    ->update([
                        'settlement_receiptno' => $data->settlement_receiptno,
                        'settlement_receiptno_count' => $count
                    ]);
            } else {


                $newdb = $settlement->where('settlement_receiptno', "!=", NULL);
                $newdb->orderBy('settlement_receiptno_count', 'desc');
                $lastEntry = $newdb->first();

                $gbid = 0;
                if ($lastEntry) {
                    $settlement_receiptno = $lastEntry->settlement_receiptno;
                    $splitArray = explode('-', $settlement_receiptno);
                    $gbid = $splitArray[1];
                }

                $gbid1 = $gbid + 1;

                $bid = 'IND' . date('dmy') . "-" . str_pad($gbid1, 3, "0", STR_PAD_LEFT);


                $updateDataQuery = $settlement->where('created_merchant', $result->created_merchant)->whereDate('settlement_date', Carbon::parse($result->my_date)->format('Y-m-d'))
                    ->update([
                        'settlement_receiptno' => $bid,
                        'settlement_receiptno_count' => $gbid1
                    ]);
            }
        }
    }

    public function transactionreport()
    {


        return view('merchant.transactionreport');
    }

    public function paymentreport()
    {
        return view('merchant.paymentreport');
    }

    public function salesreport()
    {
        return view('merchant.salesreport');
    }

    public function datatableExport()
    {
        return view('merchant.datatableExport');
    }

    public function miscellaneous()
    {
        return view('merchant.miscellaneous');
    }




    ///under report sidemenu -> transaction
    public function transactionReportData(Request $request)
    {

        $table_name = $request->table_name;
        $mode = $request->mode;
        $status = $request->status;
        $from = $request->from_date;
        $to = $request->to_date;
        $app_mode = Auth::user()->app_mode;

        $report_filter = array(
            'mode' => $mode,
            'status' => $status,
            'from' => $from,
            'to' => $to,
            'app_mode' => $app_mode

        );
        $transaction_report_log = new TransactionReportLog();
        $type = '';
        if ($request->table_name) {
            list($test, $type) = explode("_", $request->table_name);
        }


        $log_data = array(
            'created_date' => Carbon::now(),
            'from' => $from,
            'to' => $to,
            'payment_mode' => $mode ?? 'all',
            'transaction_status' => $status ?? 'all',
            'report_type' => $type,
            'mode' => $app_mode
        );
        $insert_status = $transaction_report_log->add_transaction_log($log_data);






        if (isset($request->table_name)) {

            if ($table_name == 'test_payment') {

                $transaction = DB::table($table_name)->join('merchant', 'test_payment.created_merchant', 'merchant.id');

                if ($mode != null) {
                    $transaction = $transaction->where('test_payment.transaction_mode', $mode);
                }

                if ($status != null) {
                    $transaction = $transaction->where('test_payment.transaction_status', $status);
                }

                if ($from != null) {
                    $transaction = $transaction->where('transaction_date', '>=',  Carbon::parse($from)->format('Y-m-d'));
                }

                if ($to != null) {

                    $transaction = $transaction->where('transaction_date', '<=',  Carbon::parse($to)->format('Y-m-d'));
                }


                $transaction = $transaction->get();

                return view('merchant.transactionreport', compact('transaction'));
            }

            if ($table_name == 'test_settlement') {
                $settlement = DB::table($table_name)->join('merchant', 'test_settlement.created_merchant', 'merchant.id')->get();
                return view('merchant.transactionreport', compact('settlement'));
            }

            if ($table_name == 'test_refund') {
                $refund = DB::table($table_name)->join('merchant', 'test_refund.created_merchant', 'merchant.id')
                    ->join('test_payment', 'test_refund.payment_id', 'test_payment.id');

                if ($mode != null) {
                    $refund = $refund->where('test_payment.transaction_mode', $mode);
                }

                if ($status != null) {
                    $refund = $refund->where('test_payment.transaction_status', $status);
                }

                $refund = $refund->get();


                return view('merchant.transactionreport', compact('refund'));
            }
        }
    }

    public function ReportDownloadlink(Request $request)
    {

        $res = array(
            "from_date" => $request->from_date,
            "to_date" => $request->to_date,
            "mode" => $request->mode,
            "status" => $request->status,
            "table_name" => $request->table_name
        );
        return array(
            'status' => 1,
            'res' => $res,
            // 'summary_view'=>view('.merchant.merchantDashboardSummary', compact('transactions'))->render()
        );
    }


    public function transactionReportDownload(Request $request)
    {
        $table_name = $request->table_name;
        $mode = $request->mode;
        $status = $request->status;
        $from = $request->from_date;
        $to = $request->to_date;
        $app_mode = Auth::user()->app_mode;

        $report_filter = array(
            'mode' => $mode,
            'status' => $status,
            'from' => $from,
            'to' => $to,
            'app_mode' => $app_mode

        );
        $transaction_report_log = new TransactionReportLog();
        $type = '';
        if ($request->table_name) {
            list($test, $type) = explode("_", $request->table_name);
        }

        $log_data = array(
            'created_date' => Carbon::now(),
            'from' => $from,
            'to' => $to,
            'payment_mode' => $mode ?? 'all',
            'transaction_status' => $status ?? 'all',
            'report_type' => $type,
            'mode' => $app_mode
        );
        $insert_status = $transaction_report_log->add_transaction_log($log_data);

        if ($type == 'payment') {
            $filename = "Transactions_" . $from . "-to-" . $to . ".xlsx";
            return Excel::download(new \App\Exports\ReportPaymentExport($report_filter), $filename);
        } elseif ($type == 'settlement') {
            $filename = "Settlements_" . $from . "-to-" . $to . ".xlsx";
            return Excel::download(new \App\Exports\ReportSettlementExport($report_filter), $filename);
        } elseif ($type == 'refund') {
            $filename = "Refunds_" . $from . "-to-" . $to . ".xlsx";
            return Excel::download(new \App\Exports\ReportRefundExport($report_filter), $filename);
        } elseif ($type == 'paylink') {
            $filename = "Paylink_" . $from . "-to-" . $to . ".xlsx";
            return Excel::download(new \App\Exports\ReportPaylinkExport($report_filter), $filename);
        } elseif ($type == 'invoice') {
            $filename = "Invoice_" . $from . "-to-" . $to . ".xlsx";
            return Excel::download(new \App\Exports\ReportInvoiceExport($report_filter), $filename);
        } elseif ($type == 'customer') {
            $filename = "Customer_" . $from . "-to-" . $to . ".xlsx";
            return Excel::download(new \App\Exports\ReportCustomerExport($report_filter), $filename);
        }
    }
    public function transactionReportLog(Request $request)
    {

        $transactions = [];
        $is_datatable = isset($request['is_datatable']) ? $request['is_datatable'] : 0;
        return array(
            'status' => 1,

            'log_view' => view('.merchant.report.reportlog', compact('transactions', 'is_datatable'))->render()
        );
    }



    public function payoutdashboard(Request $request)
    {

        $checkModuleActivation = DB::table('merchant_services')->where('merchant_id', Auth::user()->id)->first();

        if (empty($checkModuleActivation->payout) || $checkModuleActivation->payout == 0) {
            return view('merchant.payoutactivation');
        } else {
            if ($request->ajax()) {




                $startDate = time();

                $dates["dash_from_date"] = date('Y-m-d', strtotime('-61 days', $startDate));

                $dates["dash_to_date"] = date('Y-m-d', strtotime('30 days', $startDate));
                $module = $request->module;

                switch ($module) {



                    case 'dash_payout':

                        $transactions['bar_line_graph'] = $this->bar_line_graph($dates["dash_from_date"], $dates["dash_to_date"]);

                        return array(
                            'status' => 0,
                            'data' => $transactions
                        );
                        break;
                }
                exit;
            }
            try {
                $payoutDashboard = new \stdClass();
                $payoutDashboard->numberofTransaction = PayoutTransaction::whereDate('created_at', Carbon::now()->format('Y-m-d'))->count();
                $payoutDashboard->totalAmount = PayoutTransaction::whereDate('created_at', Carbon::now()->format('Y-m-d'))->sum('amount');
                $payoutDashboard->totalSuccessTransaction = PayoutTransaction::whereDate('created_at', Carbon::now()->format('Y-m-d'))->Where('status', '!=', 'FAILED')->count();
                $payoutDashboard->totalFailedTransaction = PayoutTransaction::whereDate('created_at', Carbon::now()->format('Y-m-d'))->Where('status', 'FAILED')->count();
            } catch (\Throwable $e) {

                dd($e->getMessage());
            }
            return view('merchant.payoutdashboard', compact('payoutDashboard'));
        }
    }

    public function contacts()
    {
        $checkModuleActivation = DB::table('merchant_services')->where('merchant_id', Auth::user()->id)->first();

        if (empty($checkModuleActivation->payout) || $checkModuleActivation->payout == 0) {
            return view('merchant.payoutactivation');
        } else {

            try {
                $contacts = PayoutContacts::where('merchant_id', Auth::user()->id)->where('is_deleted', 0)->with('statedata')->get();
            } catch (\Throwable $e) {

                dd($e->getMessage());
            }
            $states = State::get();
            return view('merchant.contacts', compact('states', 'contacts'));
        }
    }

    public function beneficiaries()
    {
        $checkModuleActivation = DB::table('merchant_services')->where('merchant_id', Auth::user()->id)->first();

        if (empty($checkModuleActivation->payout) || $checkModuleActivation->payout == 0) {
            return view('merchant.payoutactivation');
        } else {

            //forcontacts select box
            $contacts = PayoutContacts::get();

            //stateslist
            $states = State::get();

            $groups = PayoutBeneficiaryGroup::with('beneficiaries')->get();

            
            //beneficiary table data
            $beneficiaries = PayoutBeneficiaries::with('contacts', 'group')->where('is_deleted', 0)->orderBy('created_at', 'DESC')->get();
        }

        return view('merchant.beneficiaries', compact('contacts', 'beneficiaries', 'states','groups'));
    }

    public function newbeneficiaries()
    {
        //forcontacts select box
        $contacts = PayoutContacts::get();

        //stateslist
        $states = State::get();

        //beneficiary table data
        $beneficiaries = PayoutBeneficiaries::orderBy('created_at', 'DESC')->get();

        foreach ($beneficiaries as $index => $beneficiary) {
            $beneficiaries[$index]->contact_name =  PayoutContacts::where('id', $beneficiary->contact_id)->pluck('name')->first();
            $beneficiaries[$index]->contact_mobile =  PayoutContacts::where('id', $beneficiary->contact_id)->pluck('mobile')->first();
        }

        return view('merchant.newbeneficiaries', compact('contacts', 'beneficiaries', 'states'));
    }

    public function addsinglebeneficiary(Request $request)
    {
        
      //dd($request->all());
      
        $csrf_token = $request->input('_token');
        
        $auth_id = Auth::user()->id;
        
        $endpoint = 'https://payhotshopping.com/verifyVA';
        
        $data = [
            'auth_id' => $auth_id,
          'token'=> $csrf_token ,
      
        ];
        //dd($data);
        $ch = curl_init($endpoint);
        
        $headers = array(
           'Content-Type: application/json',
           'Accept:*/*',
           'Connection: keep-alive');
        
           curl_setopt($ch, CURLOPT_URL,$endpoint);
           curl_setopt($ch, CURLOPT_POST, 1);
           curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); 
           curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); 
           curl_setopt($ch, CURLOPT_CAINFO, public_path("/storage/CA Bundle.txt")); 
           curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
           curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        
        $response = curl_exec($ch);
        // dd($response);
        if (curl_errno($ch)) {
            // Handle error
            echo 'Curl error: ' . curl_error($ch);
        }
        
        curl_close($ch);



        $max_id = PayoutBeneficiaries::max('id');

        $beneficiary_id = "";
        if ($max_id === null) {
            $beneficiary_id = 'BEN1001';
        } else {
            $getmaxBenid = PayoutBeneficiaries::where('id', $max_id)->first();
            // $createBenid = substr($max_id->beneficiary_id, 4);
            preg_match_all('!\d+!', $getmaxBenid->beneficiary_id, $createBenid);
            $converttonumber = (int)$createBenid[0][0];
            $increment = $converttonumber + 1;
            $beneficiary_id = "BEN" . $increment;
        }

        //condition when adding new contact with beneficiary
        if ($request->contact_id == "addnew") {

            $addContacts = PayoutContacts::create([
                "name" => $request->contact_name,
                "mobile" => $request->contact_mobile,
                "contact" => $request->contact_email,
                "address" => $request->contact_address,
                "state" => $request->contact_state,
                "pincode" => $request->contact_pincode,
                "merchant_id" => Auth::user()->id
            ]);


            //inserting beneficiary
            $insert = PayoutBeneficiaries::create([
                "beneficiary_id" => $beneficiary_id,
                "upi_id" => $request->ben_upi_id,
                "account_number" => $request->ben_acc_no,
                "ifsc_code" => $request->ben_ifsc_no,
                "group_id" => $request->ben_groupid ?? null,
                "contact_id" => $addContacts->id,
                "merchant_id" => Auth::user()->id
            ]);
        } else {
            //inserting beneficiary
            $insert = PayoutBeneficiaries::create([
                "beneficiary_id" => $beneficiary_id,
                "upi_id" => $request->ben_upi_id,
                "account_number" => $request->ben_acc_no,
                "ifsc_code" => $request->ben_ifsc_no,
                "group_id" => $request->ben_groupid ?? null,
                "contact_id" => $request->contact_id,
                "merchant_id" => Auth::user()->id
            ]);
        }


       
        return redirect()->back()->with('message', 'Beneficiary Added Successfully');
    }

    public function deleteBeneficiaries(Request $request)
    {
        $idArray = explode(',', $request->delete_ids);
        foreach ($idArray as $id) {
            $delete = PayoutBeneficiaries::where('id', $id)->update([
                'is_deleted' => 1
            ]);
        }
        return redirect()->back()->with('message', 'Deleted Successfully');
    }

    public function editBeneficiaries(Request $request)
    {
        try {

            $idArray = explode(',', $request->edit_ids);

            $Beneficiaries = PayoutBeneficiaries::whereIn('id', $idArray)->get();
        } catch (\Throwable $e) {

            // dd($e->getMessage());
        }

        return view('merchant.editbeneficiaries', compact('Beneficiaries'));
    }

    public function updateBeneficiaries(Request $request)
    {
        try {
            $idArray = $request->id;
            $benidArray = $request->ben;
            $upiArray = $request->upi;
            $accArray = $request->acc_no;
            $ifscArray = $request->ifsc;

            $ben = [];
            foreach ($idArray as $index => $id) {
                $ben[$index] = new \stdClass();
                $ben[$index]->id = $id;
            }

            foreach ($benidArray as $index => $benid) {
                $ben[$index]->ben_id = $benid;
            }

            foreach ($upiArray as $index => $upi) {
                $ben[$index]->upi = $upi;
            }

            foreach ($accArray as $index => $acc) {
                $ben[$index]->account_no = $acc;
            }

            foreach ($ifscArray as $index => $ifsc) {
                $ben[$index]->ifsc = $ifsc;
            }

            foreach ($ben as $beneficiary) {

                $update = PayoutBeneficiaries::where('id', $beneficiary->id)->update([
                    'upi_id' => $beneficiary->upi,
                    'account_number' => $beneficiary->account_no,
                    'ifsc_code' => $beneficiary->ifsc
                ]);
            }

            return redirect('/merchant/beneficiaries')->with('message', 'Edited Successfully');
        } catch (\Throwable $e) {

            // dd($e->getMessage());
        }
    }

    public function storebulkbeneficiaries(Request $request)
    {
        $user_id = Auth::user()->id;
        $store = Excel::import(new PayoutBeneficiariesImport($user_id), $request->file('beneficiaries'));

        return redirect()->back();
    }

    public function makeBeneficiariesGroup(Request $request)
    {
        try {

            $idArray = explode(',', $request->ben_ids);

            $Beneficiaries = PayoutBeneficiaries::whereIn('id', $idArray)->get();
        } catch (\Throwable $e) {

            dd($e->getMessage());
        }

        return view('merchant.makebengroup', compact('Beneficiaries'));
    }

    public function postmakeBeneficiariesGroup(Request $request)
    {
        try {
            $idArray = $request->id;
            $insert = DB::table('payout_benificiary_group')->insertGetId([
                'group_name' => $request->group_name,
                'merchant_id' => Auth::user()->id,
                'created_at' => Carbon::now()
            ]);


            $Beneficiaries = PayoutBeneficiaries::whereIn('id', $idArray)->update([
                'group_id' => $insert
            ]);
        } catch (\Throwable $e) {

            // dd($e->getMessage());
        }

        return redirect('/merchant/beneficiaries')->with('message', 'Beneficiaries Added to Group Successfully');
    }


    public function addsinglecontact(Request $request)
    {

        $insert = PayoutContacts::create([
            "name" => $request->contact_name,
            "mobile" => $request->contact_mobile,
            "contact" => $request->contact_email,
            "address" => $request->contact_address,
            "state" => $request->contact_state,
            "pincode" => $request->contact_pincode,
            "merchant_id" => Auth::user()->id
        ]);
        return redirect()->back()->with('message', 'Contact Added Successfully');;
    }

    public function storebulkcontacts(Request $request)
    {
        $user_id = Auth::user()->id;
        $store = Excel::import(new PayoutContactsImport($user_id), $request->file('contacts'));

        return redirect()->back();
    }

    public function deleteContacts(Request $request)
    {

        $idArray = explode(',', $request->delete_ids);
        foreach ($idArray as $id) {
            $delete = PayoutContacts::where('id', $id)->update([
                'is_deleted' => 1
            ]);
        }


        return redirect()->back()->with('message', 'Deleted Successfully');
    }

    public function editContacts(Request $request)
    {
        try {

            $idArray = explode(',', $request->edit_ids);

            $Contacts = PayoutContacts::whereIn('id', $idArray)->get();
        } catch (\Throwable $e) {

            // dd($e->getMessage());
        }

        //state list
        $states = State::get();

        return view('merchant.editcontacts', compact('Contacts', 'states'));
    }

    public function updateContacts(Request $request)
    {
        try {
            $idArray = $request->id;
            $nameArray = $request->name;
            $mobileArray = $request->mobile;
            $emailArray = $request->email;
            $addressArray = $request->address;
            $stateArray = $request->state;
            $pincodeArray = $request->pincode;

            $contact = [];
            foreach ($idArray as $index => $id) {
                $contact[$index] = new \stdClass();
                $contact[$index]->id = $id;
            }

            foreach ($nameArray as $index => $name) {
                $contact[$index]->name = $name;
            }

            foreach ($mobileArray as $index => $mobile) {
                $contact[$index]->mobile = $mobile;
            }

            foreach ($emailArray as $index => $email) {
                $contact[$index]->email = $email;
            }

            foreach ($addressArray as $index => $address) {
                $contact[$index]->address = $address;
            }

            foreach ($stateArray as $index => $state) {
                $contact[$index]->state = $state;
            }

            foreach ($pincodeArray as $index => $pincode) {
                $contact[$index]->pincode = $pincode;
            }


            foreach ($contact as $con) {

                $update = PayoutContacts::where('id', $con->id)->update([
                    'name' => $con->name,
                    'mobile' => $con->mobile,
                    'contact' => $con->email,
                    'address' => $con->address,
                    'state' => $con->state,
                    'pincode' => $con->pincode
                ]);
            }

            return redirect('/merchant/contacts')->with('message', 'Edited Successfully');
        } catch (\Throwable $e) {

            // dd($e->getMessage());
        }
    }

    public function checkContacts(request $request)
    {
        try {

            $idArray = explode(',', $request->id);

            $find = PayoutContacts::whereIn('id', $idArray)->with('beneficiaries')->orderBy('id')->get();
        } catch (\Throwable $e) {

            // dd($e->getMessage());
        }

        return $find;
    }


    public function payout(Request $request)
    {
        // dd('sdbjsdjs');
        $checkModuleActivation = DB::table('merchant_services')->where('merchant_id', Auth::user()->id)->first();

        if (empty($checkModuleActivation->payout) || $checkModuleActivation->payout == 0) {
            return view('merchant.payoutactivation');
        } else {

            $beneficiaries = PayoutBeneficiaries::get();

            $payoutaccounts = PayoutAccount::where('merchant_id', Auth::user()->id)->get();
            try {
                $transactions = PayoutTransaction::with('beneficiary.contacts')->get();
            } catch (\Exception $e) {

                return $e->getMessage();
            }


            //forcontacts select box
            $contacts = PayoutContacts::get();

            //stateslist
            $states = State::get();

            return view('merchant.payout', compact('beneficiaries', 'payoutaccounts', 'transactions', 'contacts', 'states'));
        }
    }


    public function payoutTransferMoney(Request $request)
    {


        $beneficiaries = PayoutBeneficiaries::where('id', $request->ben_id)->first();

        $contacts = PayoutContacts::where('id', $beneficiaries->contact_id)->first();

        $state = State::where('id', $contacts->state)->first();



        $beneDetails = new \stdClass();
        $beneDetails->beneId = $beneficiaries->beneficiary_id;
        $beneDetails->name = $contacts->name;
        $beneDetails->email = $contacts->contact;
        $beneDetails->phone = $contacts->mobile;
        $beneDetails->bankAccount = $beneficiaries->account_number;
        $beneDetails->ifsc = $beneficiaries->ifsc_code;
        $beneDetails->address1 = $contacts->address;
        $beneDetails->city =  $state->state_name;
        $beneDetails->state = $state->state_name;
        $beneDetails->pincode = $contacts->pincode;

        //generate order id
        $now = Carbon::now();
        $order_id = $now->format('YmdHisu');


        //Generate Token
        // $clientid = "CF157153CBOAL8VCM6H5GVH11DO0";
        // $clientsecret = "de1e416550780af45375dc3608b6ecf49fbc8e2c";
        // $opts = array(
        //     'http' =>
        //     array(
        //         'method'  => 'POST',
        //         'header'  => array("Content-Type: application/json", "X-Client-Id:" . $clientid, "X-Client-Secret:" . $clientsecret),
        //     )
        // );
        // $context  = stream_context_create($opts);
        // $result_json = file_get_contents('https://payout-gamma.cashfree.com/payout/v1/authorize', false, $context);

        // $result =  json_decode($result_json, true);

        // // dd($result);

        // $token = $result['data']['token'];


        //End

        //Verify token

        // $opts = array(
        //     'http' =>
        //     array(
        //         'method'  => 'POST',
        //         'header'  => array("Content-Type: application/json", "Authorization:Bearer " . $token),
        //     )
        // );
        // $context  = stream_context_create($opts);
        // $result_json = file_get_contents('https://payout-gamma.cashfree.com/payout/v1/verifyToken', false, $context);
        // $result =  json_decode($result_json, true);



        // if ($result['status'] == "SUCCESS") {
        // }

        //End

        //Send Money
        // $postdata = new \stdClass();
        // $postdata->amount = $request->amount;
        // $postdata->transferId = $request->transferId;
        // $postdata->transferMode = $request->transferMode;
        // $postdata->beneDetails = $beneDetails;

        // $postdata_json =  json_encode($postdata);



        // $opts = array(
        //     'http' =>
        //     array(
        //         'method'  => 'POST',
        //         'header'  => array("Content-Type: application/json", "Authorization:Bearer " . $token),
        //         'content' => $postdata_json
        //     )
        // );

        // $context  = stream_context_create($opts);
        // $result_json = file_get_contents('https://payout-gamma.cashfree.com/payout/v1/directTransfer', false, $context);
        // $result =  json_decode($result_json, true);

        //end Money 




        $insertTransaction = PayoutTransaction::create([
            "reference_id" => $result['data']['referenceId'],
            "merchant_id" => Auth::user()->id,
            "utr" => $result['data']['utr'],
            "transfer_id" => $postdata->transferId,
            "ben_id" =>  $beneDetails->beneId,
            "ben_name" =>  $beneDetails->name,
            "ben_phone" => $beneDetails->phone,
            "ben_email" => $beneDetails->email,
            "ben_upi" => null,
            "ben_card_no" => null,
            "ben_ifsc" => $beneDetails->ifsc,
            "ben_bank_acc" =>  $beneDetails->bankAccount,
            "amount" =>  $postdata->amount,
            "transfer_mode" => $postdata->transferMode,
            "status" => $result['status'],
            "remarks" => null,
            "purpose" => null,
            "transfer_desc" => null,
            "vendor_charges" => null,
            "goods_service_tax" => null,
            "created_at" => Carbon::now(),
            "transfer_type" => null
        ]);



        return redirect()->back()->with('message', 'Payout Successfully Done . Transer ID:' . $postdata->transferId);
    }


    public function payoutsetting(Request $request)
    {
        $checkModuleActivation = DB::table('merchant_services')->where('merchant_id', Auth::user()->id)->first();

        if (empty($checkModuleActivation->payout) || $checkModuleActivation->payout == 0) {
            return view('merchant.payoutactivation');
        } else {
            $apikeys = DB::table("merchant_payout_apikeys")->where('merchant_id', Auth::user()->id)->get();

            $ipaddress = DB::table("merchant_payout_ipwhitelist")->where('merchant_id', Auth::user()->id)->get();

            return view("merchant.payoutsetting", compact('apikeys', 'ipaddress'));
        }
    }

    public function getapikeys()
    {
        $apikeys = DB::table("merchant_payout_apikeys")->where('merchant_id', Auth::user()->id)->get();
        return $apikeys;
    }


    public function payoutApiKey()
    {

        try {
            $cleintIdPool = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

            $clientid = substr(str_shuffle(str_repeat($cleintIdPool, 5)), 0, 28);

            $hashKey = substr(str_shuffle(str_repeat($cleintIdPool, 5)), 0, 10);

            $secretKeyPool = '0123456789abcdefghijklmnopqrstuvwxyz';

            $secretKey = substr(str_shuffle(str_repeat($secretKeyPool, 5)), 0, 40);

            $insert = DB::table("merchant_payout_apikeys")->insert([
                "merchant_id" => Auth::user()->id,
                "client_id" => $clientid,
                "secret_key" => $secretKey,
                'hash_key' => $hashKey,
                "created_at" => Carbon::now(),
            ]);


            return response()->json(['clientid' =>  $clientid, 'secretKey' =>  $secretKey, 'hashKey' =>  $hashKey], 200);
        } catch (\Throwable $e) {

            dd($e->getMessage());
        }
    }


    public function payoutIpWhitelist(Request $request)
    {
        $insert = DB::table("merchant_payout_ipwhitelist")->insert([
            "merchant_id" => Auth::user()->id,
            "ipwhitelist" => $request->ipaddress,
            "created_at" => Carbon::now(),
        ]);

        return redirect()->back()->with('message', 'Ip Address Added Successfully');
    }

    public function deleteApiKey($id)
    {
        $deleteapikey = DB::table("merchant_payout_apikeys")->where('merchant_id', Auth::user()->id)->where('id', $id)->delete();
        return redirect()->back()->with('message', 'Successfully Deleted');
    }

    public function deleteIpAdress($id)
    {
        $insert = DB::table("merchant_payout_ipwhitelist")->where('merchant_id', Auth::user()->id)->where('id', $id)->delete();
        return redirect()->back()->with('message', 'Ip Address Deleted Successfully');
    }

    public function payoutaccount()
    {
        $checkModuleActivation = DB::table('merchant_services')->where('merchant_id', Auth::user()->id)->first();

        if (empty($checkModuleActivation->payout) || $checkModuleActivation->payout == 0) {
            return view('merchant.payoutactivation');
        } else {
            $merchant = Auth::user();
            $merchant_businesses = DB::table('merchant_business')->where('created_merchant', Auth::user()->id)->get();

            return view("merchant.payoutaccount", compact('merchant', 'merchant_businesses'));
        }
    }

    public function payoutreport(Request $request)
    {
        $checkModuleActivation = DB::table('merchant_services')->where('merchant_id', Auth::user()->id)->first();

        if (empty($checkModuleActivation->payout) || $checkModuleActivation->payout == 0) {
            return view('merchant.payoutactivation');
        } else {
            try {
                $transactions = PayoutTransaction::with('beneficiary.contacts');
                if ($request->status) {
                    // $transactions = $transactions->where('status', $request->status);

                    $str_arr = explode("-", $request->datetimes);

                    $from = str_replace("/", "-", $str_arr[0]);
                    $to = str_replace("/", "-", $str_arr[1]);
                    $trim_from = trim($from, " ");
                    $trim_to = trim($to, " ");

                    $transactions = $transactions->where('created_at', '>=',  $trim_from)->where('created_at', '<=',  $trim_to);
                }


                $transactions = $transactions->get();
            } catch (\Throwable $e) {

                dd($e->getMessage());
            }


            return view('merchant.payoutreport', compact('transactions'));
        }
    }

    public function validateUpiId(Request $request)
    {
        $check = PayoutBeneficiaries::where('upi_id', $request->upi)->first() ?? "Not Found";

        return $check;
    }

    public function validateAccountNumber(Request $request)
    {
        
        $check = PayoutBeneficiaries::where('account_number', $request->acc)->first() ?? "Not Found";

        return $check;
    }

    public function editvalidateUpiId(Request $request)
    {
        try {
            $getid = PayoutBeneficiaries::where('id', $request->id)->first();

            if ($getid) {
                $check = PayoutBeneficiaries::where('upi_id', $request->upi)->where('id', '!=', $getid->id)->first() ?? "Not Found";
            }

            return $check;
        } catch (\Throwable $e) {

            return $e->getMessage();
        }
    }

    public function editvalidateAccountNumber(Request $request)
    {
        try {
            $getid = PayoutBeneficiaries::where('id', $request->id)->first();

            if ($getid) {
                $check = PayoutBeneficiaries::where('account_number', $request->acc)->where('id', '!=', $getid->id)->first() ?? "Not Found";
            }

            return $check;
        } catch (\Throwable $e) {

            return $e->getMessage();
        }
    }


    //beneficiarygroup

    public function beneficiaryGroups()
    {
        $checkModuleActivation = DB::table('merchant_services')->where('merchant_id', Auth::user()->id)->first();

        if (empty($checkModuleActivation->payout) || $checkModuleActivation->payout == 0) {
            return view('merchant.payoutactivation');
        } else {
            $groups = PayoutBeneficiaryGroup::with('beneficiaries')->get();

            return view('merchant.payoutbeneficiarygroup', compact('groups'));
        }
    }

    public function showMembers($id)
    {
        $beneficiaries = PayoutBeneficiaries::where('group_id', $id)->get();

        return $beneficiaries;
    }

    public function removeMember()
    {
        return 1;
    }

    public function fundTransfer()
    {
        $checkModuleActivation = DB::table('merchant_services')->where('merchant_id', Auth::user()->id)->first();

        if (empty($checkModuleActivation->payout) || $checkModuleActivation->payout == 0) {
            return view('merchant.payoutactivation');
        } else {
            $funds = AddFund::where('merchant_id', Auth::user()->id)->get();

            return view('merchant.fundtransfer', compact('funds'));
        }
    }

    public function addsinglerefund(Request $request)
    {

        $amount = AddFund::where('merchant_id', Auth::user()->id)->orderBy('id', 'dec')->first();
        $prev_balance = 0;
        if ($amount) {
            $prev_balance = $amount->prev_balance;
        }

        $insert = AddFund::create([
            "amount" => $request->amount,
            "mode" => $request->transferMode,
            "prev_balance" => $prev_balance,
            "current_balance" => $prev_balance + $request->amount,
            "credit_date" => $this->date_time,
            "merchant_id" => Auth::user()->id
        ]);
        return redirect()->back()->with('message', 'Fund Added Successfully');;
    }

    public function transactionInfo(Request $request)
    {


        $info['transaction_info'] = Payment::where('transaction_gid', $request->transactionID)->first();

        $info['merchant_info'] = User::where('id', $info['transaction_info']->created_merchant)->first();



        return array(
            'status' => 0,
            'data' => $info,
            'tran_details_view' => view('.merchant.details.transactions', compact('info'))->render()
        );
    }

    public function transactionRefundInitiate(Request $request)
    {


        $info['transaction_info'] = Payment::where('id', $request->transactionID)->first();

        $info['merchant_info'] = User::where('id', $info['transaction_info']->created_merchant)->first();

        $stype=\App\Classes\Helpers::support_type();
        
        return array(
            'status' => 0,
            'data' => $info,
            'tran_details_view' => view('.merchant.details.payment_refund_initiate', compact('info','stype'))->render()
        );
    }
    public function payoutTransactionInfo(Request $request)
    {
        $info['transaction_info'] = PayoutTransaction::where('transfer_id', $request->transferId)->first();

        $info['merchant_info'] = User::where('id', $info['transaction_info']->merchant_id)->first();

        return array(
            'status' => 0,
            'data' => $info,
            'tran_details_view' => view('.merchant.details.payout_transactions', compact('info'))->render()
        );
    }

    public function merchantRequest(Request $request)
    {
        $save = DB::table('merchant_requests')->insert([
            'request' => $request->requestString,
            'status' => 0,
            'merchant_id' => Auth::user()->id,
            'created_at' => Carbon::now()

        ]);

        return redirect()->back();
    }

    public function two_factor_auth(){
        if (Auth::guard("merchantemp")->check()) {
            $userId = Auth::guard("merchantemp")->user()->id;
            $user = MerchantEmployee::where('id',$userId)->first();
            $name=$user->employee_gid;
        }else{
            $userId = Auth::user()->id;
            $user = User::where('id',$userId)->first();
            $name=$user->merchant_gid;
        }

         $tfa = new \App\Packages\Authenticator\Authenticator();

    if ($user->tf_auth == '0' || empty($user->tf_auth)) {

            $tf_auth_secret = $tfa->createSecret();
        } else {

            $tf_auth_secret = $user->tf_auth_secret;
        }
           $qr_link = $tfa->GetQR("PAYFLASH (" . $name . ")", $tf_auth_secret);

        // return $qr_link;

        if (!empty($user->tf_auth_codes)) {

            $codes_arr = explode(',', $user->tf_auth_codes);
        } else {

            $codes_arr = [];
        }

        return view('merchant.two_factor.two_factor_auth', compact('user', 'qr_link', 'codes_arr', 'tf_auth_secret','userId'));
         
    }

     public function UpdatetwoFactor(Request $request)
    {
        if (Auth::guard("merchantemp")->check()) {
            $userId = Auth::guard("merchantemp")->user()->id;
            $user = MerchantEmployee::where('id',$userId)->first();
            $name=$user->employee_gid;
        }else{
            $userId = Auth::user()->id;
            $user = User::where('id',$userId)->first();
            $name=$user->merchant_gid;
        }
       
        if (isset($request->user_id) && isset($request->tfa_secret)) {

            if ($request->user_id != $userId) {

                return redirect('/merchant/two-factor-auth')->with('error', 'Token mismatch !!');
            }

            if (isset($request->tfa_status) && $request->tfa_status == '1') {

                if ($request->otp == "") {

                    return redirect('/merchant/two-factor-auth')->with('error', 'Invalid OTP !!');
                }

                $ga = new \App\Packages\Authenticator\Authenticator();

                $backup_pass = false;

                $otp = $request->otp ?? "0";

                $checkResult = $ga->verify($request->tfa_secret, $request->otp);
                
                if (!$checkResult) {

                    return redirect('/merchant/two-factor-auth')->with('error', 'OTP Expired !!');
                }

                $codes = array();

                for ($i = 1; $i <= 5; $i++) {

                    $codes[] = $this->get_random_num(6);
                }

                $user->tf_auth = '1';

                $user->tf_auth_codes = implode(',', $codes);

                $user->tf_auth_secret = $request->tfa_secret;
            } else {

                if (!isset($request->tfa_status)) {
                    $user->tf_auth = '0';

                    $user->tf_auth_codes = "";

                    $user->tf_auth_secret = "";

                }

                
            }
           
            $response = $user->save();

            if ($response) {

                return redirect('/merchant/two-factor-auth')->with('success', 'Updated Successfully !!');
            } else {

                return redirect('/merchant/two-factor-auth')->with('error', 'Something went wrong1 !!');
            }
        }

        return redirect('merchant/two-factor-auth')->with('error', 'Something went wrong2 !!');
    }

     public function get_random_num($length = 0)
    {

        $characters = str_shuffle('0123456789');

        $string = '';

        for ($p = 0; $p < $length; $p++) {

            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }

        return $string;
    }


    public function MerchantConfigSettings(){

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://pg.flakpay.com/getMerchantConfigs');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            $response = curl_exec($ch);
            $dta=json_decode($response);
            if (curl_errno($ch)) {
                echo 'Curl error: ' . curl_error($ch);
            }
            curl_close($ch);
            echo json_encode($dta);

    }

    public function websiteinsertapi(){


    

}

}
