<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Pagination\LengthAwarePaginator;
use Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use App\Classes\GenerateLogs;
use App\Classes\ApiCalls;
use App\Exports\CustRyaPayAdjustment;
use App\Exports\TransactionExport;
use App\Navigation;
use App\Employee;
use App\Merchant;
use App\EmpBgVerify;
use App\EmpDocument;
use App\CharOfAccount;
use App\Classes\ValidationMessage;
use App\EmpDetail;
use App\EmpContactDetail;
use App\EmpReference;
use App\Mail\SendMail;
use App\RyaPayItem;
use App\RyaPayCustomer;
use App\RyaPayInvoice;
use App\RyaPayCustomerAddress;
use App\RyaPayInvoiceItem;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\AdjustmentController;
use App\State;
use App\User;
use App\Paylink;
use App\Invoice;
use App\MerchantSupport;
use App\CallSupport;
use App\RyaPaySale;
use App\PayslipElement;
use App\EmpPayslip;
use App\EmpEarnDeduct;
use App\CustomerCase;
use App\Settlement;
use App\EmployeeLogActivity;
use App\RyapayBlog;
use App\RyapayFixedAsset;
use App\RyapayJournalVoucher;
use App\RyapaySupplier;
use App\RyapayPorder;
use App\RyapayaSupOrderInv;
use App\RyapayaSupOrderItem;
use App\RyapaySupExpInv;
use App\RyapaySupExpItem;
use App\RyapayPorderItem;
use App\RyapayTaxSettlement;
use App\RyapayTaxAdjustment;
use App\RyapayTaxPayment;
use App\Payment;
use App\Refund;
use App\Custom;
use App\RyapayAdjustment;
use App\ryapayAdjustmentTrans;
use App\ryapayAdjustmentDetail;
use App\RyapaySupCDNote;
use App\RyapayaCustCDNote;
use App\RyapaySorder;
use App\RyapaySorderItem;
use App\RyapayCustOrderInv;
use App\RyapayCustOrderItem;
use App\MerchantBusiness;
use App\BusinessSubCategory;
use App\RyapayBGCheck;
use App\MerchantDocument;
use App\RyapayDOCCheck;
use App\CaseComment;
use App\RyapayBankInfo;
use App\RyapayContEntry;
use App\RyapaySupPayEntry;
use App\RyapaySundPayEntry;
use App\RyapayCustRcptEntry;
use App\RyapaySundRcptEntry;
use App\RyapayCDR;
use App\NavPermission;
use App\ContactUs;
use App\RyapaySubscribe;
use App\RyapayGallery;
use App\RyapayCareer;
use App\RyapayApplicant;
use App\RyapayEvent;
use App\EmpWorkStatus;
use File;
use Image;
use Session;
use Redirect;
use App\RyapayRncCheck;
use App\MerchantChargeDetail;
use App\MerchantPayoutCharges;
use App\MerchantPayoutVendor;
use App\PayoutTransaction;
use App\RyapayAdjustmentCharge;
use App\BusinessType;
use App\MerchantVendorBank;
use App\VendorBankInfo;
use App\VendorAdjustmentResp;
use Auth;
use App\MerchantExtraDoc;
use App\CfRpayKeys;
use App\Imports\CampaignSheet;
use App\Campaign;
use DB;
use Carbon\Carbon;
use App\Exports\SuccessRatiosExport;
use App\Models\PayinTransactions;
use DataTables;

class EmployeeController extends Controller
{

    public $datetime;

    public $weekdatetime;

    private $gst_on_chargers = "18";

    public $payable_manage;

    public $receivable_manage;

    public $documents_name;

    public $next_settlement;

    public function __construct()
    {
     
        $this->middleware('prevent-back-history');
        $this->middleware('Employee');
        $this->middleware('SessionTimeOut');
        /*$this->middleware('TwoFA');
        $this->middleware('ThreeFA');*/
        $this->datetime = date('Y-m-d H:i:s');
        $this->weekdate = date('Y-m-d', strtotime('-7 days'));

        $this->next_settlement = date('Y-m-d', strtotime('+7 days'));
        $this->today = date('Y-m-d');
        $this->payable_manage = [
            '1' => 'Supplier Order based Invoice', '2' => 'Supplier Direct Invoice',
            '3' => 'Debit Note/ Credit Note'
        ];
        $this->receivable_manage = ['1' => 'Order based sale Invoice', '2' => 'Customer Debit Note/ Credit Note'];

        $this->documents_name = [

            "comp_pan_card" => "Company Pan Card",
            "comp_gst_doc" => "Company GST",
            "bank_statement" => "Bank Statement",
            "aoa_doc" => "AOA Doc",
            "mer_pan_card" => "Authorized Signatory Pan Card",
            "mer_aadhar_card" => "Authorized Signatory Aadhar Card",
            "moa_doc" => "MOA Doc",
            "cancel_cheque" => "Cancel Cheque",
            "cin_doc" => "Certificate of Incorporation",
            "partnership_deed" => "Partnership Deed",
            "llp_agreement" => "LLP Agreement",
            "registration_doc" => "Registration Doc",
            "trust_constitutional" => "Trust Constitutional",
            "income_tax_doc" => "Income Tax",
            "ccrooa_doc" => "CCROOA Doc",
            "current_trustees" => "Current Trusties"
        ];

        $this->fields_name = [

            "name" => "Name",
            "email" => "Email",
            "mobile_no" => "Mobile No",
            "type_name" => "Business Type",
            "category_name" => "Business Category",
            "expenditure" => "Company Expenditure",
            "sub_category_name" => "Business Sub Category",
            "business_name" => "Company Name",
            "address" => "Company Address",
            "pincode" => "Pincode",
            "city" => "City",
            "state_name" => "State",
            "country" => "Country",
            "website" => "Website",
            "bank_name" => "Bank Name",
            "bank_acc_no" => "Bank Account No",
            "bank_ifsc_code" => "Bank IFSC Code",
            "comp_pan_number" => "Company Pan No",
            "comp_gst" => "Company GST",
            "mer_pan_number" => "Merchant Pan No",
            "mer_aadhar_number" => "Merchant Aadhar No",
            "mer_name" => "Merchant Name"
        ];
    }
    
    

    public function index(Request $request)
    {
        $navigation = new Navigation();
        $nav_details = $navigation->get_app_navigation_links();

        $dashboard = new \stdClass();

        $startDateTime = $request->input('start');
        $endDateTime = $request->input('end');

        $startDateTime = $startDateTime ? Carbon::parse($startDateTime) : Carbon::today()->startOfDay();
        $endDateTime = $endDateTime ? Carbon::parse($endDateTime) : Carbon::today()->endOfDay();


        $dashboard->total_merchant = User::count();
        $dashboard->live_merchant = User::where('app_mode', 1)->count();
        $dashboard->active_merchant = User::where('merchant_status', 'active')->count();

        // $dashboard->total_transaction = Payment::count();
        $dashboard->total_transaction = DB::table('payin_transactions')->where('created_at','>=',Carbon::today())->get()->count();

        // $dashboard->total_transaction = DB::table('payin_transactions')
        // ->where('created_at', '>=', $startDateTime)
        // ->where('created_at', '<=', $endDateTime)
        // ->count();

        $dashboard->successful_transaction = Payment::where('transaction_status', 'success')->count();
        $dashboard->failed_transaction = Payment::where('transaction_status', 'failed')->count();

        $dashboard->gtv = Payment::where('transaction_status', 'success')->sum('transaction_amount');
        $dashboard->refund = DB::table('live_refund')->where('refund_status', 'success')->sum('refund_amount');
        $merchants = User::join('merchant_business', 'merchant_business.created_merchant', '=', 'merchant.id')
        ->select('merchant.id', 'merchant_business.business_name')->where('merchant.app_mode',1)
        ->get();

        $selectedMerchantId = $request->input('merchant_id');
        // $successRatios = DB::table('success_ratios')->get();
        $dateToQuery = now()->toDateString();
        // $dateToQuery = now()->subDay()->toDateString();

        if($request->input('merchant_id')=="") {

        $successRatios = DB::table('all_success_ratios')
            ->whereDate('start_time', $dateToQuery)
            ->get();
        } else {
            $successRatios = DB::table('success_ratios')
            ->where('merchant_id', $request->input('merchant_id'))
            ->whereDate('start_time', $dateToQuery)
            ->get();

        }

        return view('employee.dashboard', compact('dashboard', 'merchants','successRatios','selectedMerchantId'))->with("nav_details", $nav_details, 'merchants', $merchants);
    }

    public function excelExportSuccessratio(request $request)
    {
        $selectedMerchantId = $request->input('merchant_id');
        $dateToQuery = now()->toDateString();

        if($request->input('merchant_id')=="") {
        $successRatios = DB::table('all_success_ratios')
        ->select('start_time', 'end_time', 'total_transactions', 'success_transactions', 'success_ratio')
        ->whereDate('start_time', $dateToQuery)
        ->get();
        } else {
            $successRatios = DB::table('success_ratios')
            ->select('start_time', 'end_time', 'total_transactions', 'success_transactions', 'success_ratio')
            ->where('merchant_id', $request->input('merchant_id'))
            ->whereDate('start_time', $dateToQuery)
            ->get();

        }
        $todayDate = now()->format('Y-m-d');

        $fileName = 'success_ratios_' . $todayDate . '.xlsx';
    
        return Excel::download(new SuccessRatiosExport($successRatios), $fileName);
    }
       

    public function dashboardAjax(Request $request)
    {
        $merchant = '';
        $startDateTime = $request->input('start');
        $endDateTime = $request->input('end');
        $merchantId = $request->input('merchantId');


      
        // $startDateTime = $startDateTime ? Carbon::createFromFormat('m/d/Y H:i:s', $startDateTime)->startOfDay() : Carbon::today()->startOfDay();
        // $endDateTime = $endDateTime ? Carbon::createFromFormat('m/d/Y H:i:s', $endDateTime)->endOfDay() : Carbon::today()->endOfDay();

        // $startDateTime = $startDateTime ? Carbon::createFromFormat('m/d/Y H:i:s', $startDateTime) : Carbon::today()->startOfDay();
        // $endDateTime = $endDateTime ? Carbon::createFromFormat('m/d/Y H:i:s', $endDateTime) : Carbon::today()->endOfDay();
        $startDateTime = $startDateTime ? Carbon::createFromFormat('m/d/Y', $startDateTime)->startOfDay() : Carbon::today()->startOfDay();
        $endDateTime = $endDateTime ? Carbon::createFromFormat('m/d/Y', $endDateTime)->endOfDay() : Carbon::today()->endOfDay();
        // $dates = explode(' - ', $request->date_range);
        // $startDate = \Carbon\Carbon::createFromFormat('m/d/Y', $dates[0])->startOfDay();
        // $endDate = \Carbon\Carbon::createFromFormat('m/d/Y', $dates[1])->endOfDay();
        // dd($startDateTime );
        $dashboard = new \stdClass();
        // $dashboard->total_transaction = Payment::where('created_merchant', $merchant)->whereDate('created_date', '>=', $request->start)->whereDate('created_date', '<=', $request->end)->count();
         // $dashboard->successful_transaction = Payment::where('created_merchant', $merchant)->whereDate('created_date', '>=', $request->start)->whereDate('created_date', '<=', $request->end)->where('transaction_status', 'success')->count();
         // $dashboard->failed_transaction = Payment::where('created_merchant', $merchant)->whereDate('created_date', '>=', $request->start)->whereDate('created_date', '<=', $request->end)->where('transaction_status', 'failed')->count();
        //  $dashboard->total_transaction       =  PayinTransactions::where('created_at', '>=', Carbon::today())->where('created_at','<=',Carbon::tomorrow())->count();

        $dashboard->total_transaction = PayinTransactions::whereBetween('created_at', [$startDateTime, $endDateTime])
        ->join('user_keys', 'user_keys.prod_mid', '=', 'payin_transactions.merchant_id')
        ->join('merchant', 'merchant.id', '=', 'user_keys.mid')
        ->when($merchantId !== null, function ($query) use ($merchantId) {
            return $query->where('merchant.id', $merchantId);
        })
        ->count();

        //  $dashboard->successful_transaction  =  PayinTransactions::where('txn_status', '2')->where('created_at', '>=', Carbon::today())->where('created_at','<=',Carbon::tomorrow())->count();

        $dashboard->successful_transaction = PayinTransactions::where('txn_status', '2')
        ->whereBetween('created_at', [$startDateTime, $endDateTime])
        ->join('user_keys', 'user_keys.prod_mid', '=', 'payin_transactions.merchant_id')
        ->join('merchant', 'merchant.id', '=', 'user_keys.mid')
        ->when($merchantId !== null, function ($query) use ($merchantId) {
            return $query->where('merchant.id', $merchantId);
        })
        ->count();

        //  $dashboard->failed_transaction      =  "₹ ".PayinTransactions::where('txn_status', '2')->where('created_at', '>=', Carbon::today())->where('created_at','<=',Carbon::tomorrow())->sum('amount');

        $dashboard->total_collection_amount = "₹ " . PayinTransactions::where('txn_status', '2')
        ->whereBetween('created_at', [$startDateTime, $endDateTime])
        ->join('user_keys', 'user_keys.prod_mid', '=', 'payin_transactions.merchant_id')
        ->join('merchant', 'merchant.id', '=', 'user_keys.mid')
        ->when($merchantId !== null, function ($query) use ($merchantId) {
            return $query->where('merchant.id', $merchantId);
        })
        ->sum('amount');
       
        $dashboard->gtv = Payment::where('created_merchant', $merchant)
        ->whereBetween('created_date', [$startDateTime, $endDateTime])
        ->where('transaction_status', 'success')
        ->sum('transaction_amount');

    $dashboard->refund = DB::table('live_refund')
        ->where('created_merchant', $merchant)
        ->whereBetween('created_date', [$startDateTime, $endDateTime])
        ->where('refund_status', 'success')
        ->sum('refund_amount');

         return response()->json(['transactionStats' => $dashboard], 200);
    }
    public function dashboardTransactionStats(Request $request)
    {
        $start = $request->start;
        $end = $request->end;
        $merchant = $request->merchantId;

        if ($merchant == 'all') {
            $dashboard = new \stdClass();
            $dashboard->total_transaction = PayinTransactions::whereDate('created_date', '>=', Carbon::today())->whereDate('created_date', '<=', Carbon::today())->count();
            $dashboard->successful_transaction = Payment::whereDate('created_date', '>=', $request->start)->whereDate('created_date', '<=', $request->end)->where('transaction_status', 'success')->count();
            $dashboard->failed_transaction = Payment::whereDate('created_date', '>=', $request->start)->whereDate('created_date', '<=', $request->end)->where('transaction_status', 'failed')->count();

            $dashboard->gtv = Payment::whereDate('created_date', '>=', $request->start)->whereDate('created_date', '<=', $request->end)->where('transaction_status', 'success')->sum('transaction_amount');
            $dashboard->refund = DB::table('live_refund')->whereDate('created_date', '>=', $request->start)->whereDate('created_date', '<=', $request->end)->where('refund_status', 'success')->sum('refund_amount');
        } else {
            $dashboard = new \stdClass();
           // $dashboard->total_transaction = Payment::where('created_merchant', $merchant)->whereDate('created_date', '>=', $request->start)->whereDate('created_date', '<=', $request->end)->count();
            // $dashboard->successful_transaction = Payment::where('created_merchant', $merchant)->whereDate('created_date', '>=', $request->start)->whereDate('created_date', '<=', $request->end)->where('transaction_status', 'success')->count();
            // $dashboard->failed_transaction = Payment::where('created_merchant', $merchant)->whereDate('created_date', '>=', $request->start)->whereDate('created_date', '<=', $request->end)->where('transaction_status', 'failed')->count();
            $dashboard->total_transaction       =  PayinTransactions::where('created_at', '>=', Carbon::today())->where('created_at','<=',Carbon::tomorrow())->count();
            
            $dashboard->successful_transaction  =  PayinTransactions::where('txn_status', '2')->where('created_at', '>=', Carbon::today())->where('created_at','<=',Carbon::tomorrow())->count();
            $dashboard->failed_transaction      =  "₹ ".PayinTransactions::where('txn_status', '2')->where('created_at', '>=', Carbon::today())->where('created_at','<=',Carbon::tomorrow())->sum('amount');
          
            $dashboard->gtv = Payment::where('created_merchant', $merchant)->whereDate('created_date', '>=', $request->start)->whereDate('created_date', '<=', $request->end)->where('transaction_status', 'success')->sum('transaction_amount');
            $dashboard->refund = DB::table('live_refund')->where('created_merchant', $merchant)->whereDate('created_date', '>=', $request->start)->whereDate('created_date', '<=', $request->end)->where('refund_status', 'success')->sum('refund_amount');
        }




        return response()->json(['transactionStats' => $dashboard], 200);
    }



    public function dashboardTransactionGraph(Request $request)
    {


        $startDate = new Carbon($request->start);
        $endDate = new Carbon($request->end);
        $merchant = $request->merchantId;
        $all_dates = array();
        while ($startDate->lte($endDate)) {
            $all_dates[] = $startDate->toDateString();

            $startDate->addDay();
        }

        $graphData = [];

        if ($merchant == 'all') {
            foreach ($all_dates as $key => $date) {
                // DB::enableQueryLog();
                $graphData[$key] = new \stdClass();


                $graphData[$key]->gtv_amount = Payment::whereDate('created_date', $date)->sum('transaction_amount');
                // dd(DB::getQueryLog());
                $graphData[$key]->tran_count = Payment::whereDate('created_date', $date)->count() ?? 0;
                $graphData[$key]->gtv_date = $date;
            }
        } else {
            foreach ($all_dates as $key => $date) {

                $graphData[$key] = new \stdClass();


                $graphData[$key]->gtv_amount = Payment::where('created_merchant', $merchant)->whereDate('created_date', $date)->sum('transaction_amount');

                $graphData[$key]->tran_count = Payment::where('created_merchant', $merchant)->whereDate('created_date', $date)->count() ?? 0;
                $graphData[$key]->gtv_date = $date;
            }
        }




        return $graphData;
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

    private function _arrayPaginator($array, $request, $module = "", $perPage = 10)
    {
        $page = Input::get('page', 1);
        $offset = ($page * $perPage) - $perPage;
        return new LengthAwarePaginator(
            array_slice($array, $offset, $perPage, true),
            count($array),
            $perPage,
            $page,
            ['path' => '/flakpay/pagination/' . $module . '-' . $perPage, 'query' => $request->query()]
        );
    }

    private function _generate_html_content($description)
    {

        $dom = new \DomDocument();

        $dom->loadHtml($description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $k => $img) {

            $data = $img->getAttribute('src');

            $imageName = explode('.', $img->getAttribute('data-filename'));

            list($type, $data) = explode(';', $data);

            list(, $data)      = explode(',', $data);

            $data = base64_decode($data);

            $image_name = "/storage/blog/images/" . $imageName[0] . '.png';

            $path = public_path() . $image_name;


            file_put_contents($path, $data);

            $img->removeAttribute('src');

            $img->setAttribute('src', $image_name);
        }

        return $dom->saveHTML();
    }

    public static function navigation()
    {

        $links = [];
        $permissions = [];
        $permission_row = [];
        $filter_links = [];

       
        if (!session()->has('links')) {
            $naviagtion = new Navigation();
            $links = $naviagtion->navigator();
            session(['links' => $links]);
        }

        $navpermObject = new NavPermission();
        $permissions = $navpermObject->get_employee_navpermissions();
        if (!empty($permissions)) {
            $permission_row = $permissions[0];

            foreach (session('links') as $key => $link) {
                $column_name = strtolower(str_replace(" & ", "_", $link->link_name));
                if (!empty($permission_row->$column_name)) {
                    $nav_array[$link->id] = explode("+", $permission_row->$column_name);
                }
            }
            // echo "<pre>";
            // print_r($nav_array);
            foreach (session('links') as $key => $link) {

                if (array_key_exists($link->id, $nav_array)) {
                    $filter_links[$key]["link_name"] = $link->link_name;
                    $filter_links[$key]["hyperlink"] = $link->hyperlink;
                    foreach ($link->sublinks as $index => $sublink) {
                        if (in_array($sublink["id"], $nav_array[$link['id']])) {
                            $filter_links[$key]["sublinks"][$index] = [
                                'id' => $sublink['id'],
                                'link_name' => $sublink['link_name'],
                                'hyperlink' => $sublink['hyperlink'],
                                "hyperlinkid" => $sublink['hyperlinkid'],
                            ];
                        }
                    }
                }
            }
        }
        return $filter_links;
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

    public static function merchant_status()
    {
        $merchant = [
            'visited' => 'Visited Today',
            'interested' => 'Interested',
            'not interested' => 'Not Interested',
            'one more visit' => 'One More Visit',
            'final discussion' => 'Final Discussion',
            'ready to onboard' => 'Ready to Onboard'
        ];
        return $merchant;
    }

    public static function sales_status()
    {
        $status = [
            'lead' => "Lead",
            'daily' => "Daily Tracker",
            'sales' => "Sales Sheet"
        ];

        return $status;
    }

    public function get_adjustment_percentage($discriminator)
    {

        switch ($discriminator) {
            case 'CC':
                return "2.00";
                break;
            case 'DC':
                return "1.70";
                break;
            case 'NB':
                return "2.00";
                break;
            default:
                return "3.00";
                break;
        }
    }

    public function num_format($amount)
    {
        return number_format($amount, 2, '.', '');
    }

    public function get_merchant_transactions(Request $request, $id)
    {

        if ($request->ajax()) {
            $payment = new Payment();
            $transactions = $payment->get_merchant_transactions($id);
            echo json_encode($transactions);
        }
    }

    public function get_transactions_bydate(Request $request)
    {

        // $userId = Auth::id();
       
        // dd( $payinTransactions);
        if ($request->ajax()) {
            // dd($request);
            $perpage = $request->perpage;
            $fromdate = $this->today;
            $todate = $this->today;
            if (!empty($request->trans_from_date) && !empty($request->trans_to_date)) {
                $fromdate = $request->trans_from_date;
                $todate = $request->trans_to_date;
                $perpage = $request->perpage;
            }
            session(['fromdate' => $fromdate]);
            session(['todate' => $todate]);

            // dd($request->mode);
            if($request->mode=="test") {
                $payinTransactions = DB::table('test_payintransactions')
                ->join('user_keys', 'user_keys.test_mid', '=', 'test_payintransactions.merchant_id')
                ->join('merchant', 'merchant.id', '=', 'user_keys.mid')
                ->when($request->status !== null, function ($query) use ($request) {
                    return $query->where('txn_status', $request->status);
                })
                ->when($request->merchant_name !== null, function ($query) use ($request) {
                    return $query->where('merchant.id', $request->merchant_name);
                })
                ->when($request->date_range !== null, function ($query) use ($request) {
                    // Assuming your date range parameter is in the format MM/DD/YYYY - MM/DD/YYYY
                    $dates = explode(' - ', $request->date_range);
                    $startDate = \Carbon\Carbon::createFromFormat('m/d/Y', $dates[0])->startOfDay();
                    $endDate = \Carbon\Carbon::createFromFormat('m/d/Y', $dates[1])->endOfDay();
                    return $query->whereBetween('test_payintransactions.created_at', [$startDate, $endDate]);
                })
                ->orderBy('test_payintransactions.id', 'desc') 
                ->get();
            } else {
                $payinTransactions = DB::table('payin_transactions')
                
                ->join('user_keys', 'user_keys.prod_mid', '=', 'payin_transactions.merchant_id')
                ->join('merchant', 'merchant.id', '=', 'user_keys.mid')
                ->when($request->status !== null, function ($query) use ($request) {
                    return $query->where('txn_status', $request->status);
                })
                ->when($request->merchant_name !== null, function ($query) use ($request) {
                    return $query->where('merchant.id', $request->merchant_name);
                })

                ->when($request->date_range !== null, function ($query) use ($request) {
                    // Assuming your date range parameter is in the format MM/DD/YYYY - MM/DD/YYYY
                    $dates = explode(' - ', $request->date_range);
                    $startDate = \Carbon\Carbon::createFromFormat('m/d/Y', $dates[0])->startOfDay();
                    $endDate = \Carbon\Carbon::createFromFormat('m/d/Y', $dates[1])->endOfDay();
                    return $query->whereBetween('payin_transactions.created_at', [$startDate, $endDate]);
                })
                ->orderBy('payin_transactions.id', 'desc')  // Specify the table for "id"
                ->get();
                // ->paginate($perpage);
            
                // ->paginate($perpage);
            }
            // $payinTransactions = DB::table('payin_transactions')->get();

// dd($payinTransactions);
            $payment = new Payment();
            $transactions_result = $payment->get_transactions_bydate($fromdate, $todate);
            $transactions = $this->transaction_setup($transactions_result);
            $paginate_alltransaction = $this->_arrayPaginator($transactions, $request, "alltransaction", $perpage);
            return View::make('employee.pagination')->with(["module" => "alltransaction", "alltransactions" => $paginate_alltransaction, "allpayintransactions" => $payinTransactions])->render();
        }
    }


    public function getTransactionsList(Request $request)
{

    // dd($request->date_range);
    if($request->mode=="test") {
        $payinTransactions = DB::table('test_payintransactions')
        ->join('user_keys', 'user_keys.test_mid', '=', 'test_payintransactions.merchant_id')
        ->join('merchant', 'merchant.id', '=', 'user_keys.mid')
        ->when($request->status !== null, function ($query) use ($request) {
            return $query->where('txn_status', $request->status);
        })
        ->when($request->merchant_name !== null, function ($query) use ($request) {
            return $query->where('merchant.id', $request->merchant_name);
        })
        ->when($request->date_range !== null, function ($query) use ($request) {
            // Assuming your date range parameter is in the format MM/DD/YYYY - MM/DD/YYYY
            $dates = explode(' - ', $request->date_range);
            $startDate = \Carbon\Carbon::createFromFormat('m/d/Y', $dates[0])->startOfDay();
            $endDate = \Carbon\Carbon::createFromFormat('m/d/Y', $dates[1])->endOfDay();
            return $query->whereBetween('test_payintransactions.created_at', [$startDate, $endDate]);
        })
        ->orderBy('test_payintransactions.id', 'desc') 
        ->get();
    } else {
        $payinTransactions = DB::table('payin_transactions')
        
        ->join('user_keys', 'user_keys.prod_mid', '=', 'payin_transactions.merchant_id')
        ->join('merchant', 'merchant.id', '=', 'user_keys.mid')
        ->when($request->status !== null, function ($query) use ($request) {
            return $query->where('txn_status', $request->status);
        })
        ->when($request->merchant_name !== null, function ($query) use ($request) {
            return $query->where('merchant.id', $request->merchant_name);
        })

        ->when($request->date_range !== null, function ($query) use ($request) {
            // Assuming your date range parameter is in the format MM/DD/YYYY - MM/DD/YYYY
            $dates = explode(' - ', $request->date_range);
            $startDate = \Carbon\Carbon::createFromFormat('m/d/Y', $dates[0])->startOfDay();
            $endDate = \Carbon\Carbon::createFromFormat('m/d/Y', $dates[1])->endOfDay();
            return $query->whereBetween('payin_transactions.created_at', [$startDate, $endDate]);
        })
        ->orderBy('payin_transactions.id', 'desc')  // Specify the table for "id"
        ->get();

    }

        return DataTables::of($payinTransactions)
            ->addColumn('txn_status', function($transaction){
                switch ($transaction->txn_status) {
                    case 1:
                        return 'TXN not initiated';
                        break;
                    case 2:
                        return 'Success';
                        break;
                    case 0:
                        return 'Failed';
                        break;
                    case 3:
                        return 'Tampered';
                        break;
                    case 4:
                        return 'Cancelled';
                        break;
                    default:
                        return '';
                }
            })

            ->make(true);


    
}


    public function download_transaction(Request $request)
    {
// dd($request);
        $fromdate = $this->today;


        if($request->selected_mode=="test") {
            $payinTransactions = DB::table('test_payintransactions')
            ->join('user_keys', 'user_keys.test_mid', '=', 'test_payintransactions.merchant_id')
            ->join('merchant', 'merchant.id', '=', 'user_keys.mid')
            ->when($request->selected_status !== null, function ($query) use ($request) {
                return $query->where('txn_status', $request->selected_status);
            })
            ->when($request->selected_merchant !== null, function ($query) use ($request) {
                return $query->where('merchant.id', $request->selected_merchant);
            })
            ->when($request->selected_date_range !== null, function ($query) use ($request) {
                // Assuming your date range parameter is in the format MM/DD/YYYY - MM/DD/YYYY
                $dates = explode(' - ', $request->selected_date_range);
                $startDate = \Carbon\Carbon::createFromFormat('m/d/Y', $dates[0])->startOfDay();
                $endDate = \Carbon\Carbon::createFromFormat('m/d/Y', $dates[1])->endOfDay();
                return $query->whereBetween('test_payintransactions.created_at', [$startDate, $endDate]);
            })
            ->orderBy('test_payintransactions.id', 'desc') 
            ->get();
        } else {
            $payinTransactions = DB::table('payin_transactions')
            ->join('user_keys', 'user_keys.prod_mid', '=', 'payin_transactions.merchant_id')
            ->join('merchant', 'merchant.id', '=', 'user_keys.mid')
            ->when($request->selected_status !== null, function ($query) use ($request) {
                return $query->where('txn_status', $request->selected_status);
            })
            ->when($request->selected_merchant !== null, function ($query) use ($request) {
                return $query->where('merchant.id', $request->selected_merchant);
            })

            // ->when($request->selected_date_range !== null, function ($query) use ($request) {
            //     // Assuming your date range parameter is in the format MM/DD/YYYY - MM/DD/YYYY
            //     $dates = explode(' - ', $request->selected_date_range);
            //     $startDate = \Carbon\Carbon::createFromFormat('m/d/Y', $dates[0])->startOfDay();
            //     $endDate = \Carbon\Carbon::createFromFormat('m/d/Y', $dates[1])->endOfDay();
            //     return $query->whereBetween('payin_transactions.created_at', [$startDate, $endDate]);
            // })
            ->when($request->selected_date_ranges !== null, function ($query) use ($request) {
                // Assuming your date range parameter is in the format MM/DD/YYYY - MM/DD/YYYY
                $dates = explode(' - ', $request->selected_date_ranges);

                $startDate = \Carbon\Carbon::createFromFormat('m/d/Y', $dates[0])->startOfDay();
                $endDate = \Carbon\Carbon::createFromFormat('m/d/Y', $dates[1])->endOfDay();
                return $query->whereBetween('payin_transactions.created_at', [$startDate, $endDate]);
            })
            ->orderBy('payin_transactions.id', 'desc')  // Specify the table for "id"
            ->get();
        
        }

        $filename = "Transactions" . $fromdate . ".xlsx";
        return Excel::download(new TransactionExport($payinTransactions), $filename);
    }


    public function transaction_setup($transactions)
    {

        $adjustment_chargeObject = new MerchantChargeDetail();
        $merchantvendor_bank = new MerchantVendorBank();
        foreach ($transactions as $index => $object) {
            $merchant_exist = $merchantvendor_bank->check_merchantbank_link_exists($object->created_merchant);

            if ($merchant_exist[0]->merchant_bank) {

                switch ($object->transaction_mode) {
                    case 'CC':

                        $object->percentage_charge = $this->get_card_charges($object->transaction_type, $object->created_merchant, $adjustment_chargeObject);
                        $object->percentage_amount = $this->num_format($object->percentage_charge / 100 * $object->transaction_amount);
                        $object->gst_charge = $this->num_format($this->gst_on_chargers / 100 * $object->percentage_amount);
                        $object->total_amt_charged = $object->percentage_amount + $object->gst_charge;
                        $object->adjustment_total = $this->num_format($object->transaction_amount - $object->total_amt_charged);

                        break;

                    case 'DC':

                        $object->percentage_charge = $this->get_card_charges($object->transaction_type, $object->created_merchant, $adjustment_chargeObject);
                        $object->percentage_amount = $this->num_format($object->percentage_charge / 100 * $object->transaction_amount);
                        $object->gst_charge = $this->num_format($this->gst_on_chargers / 100 * $object->percentage_amount);
                        $object->total_amt_charged = $object->percentage_amount + $object->gst_charge;
                        $object->adjustment_total = $this->num_format($object->transaction_amount - $object->total_amt_charged);

                        break;

                    case 'NB':

                        $object->percentage_charge = $this->get_netbanking_charges($object->transaction_type, $object->created_merchant, $adjustment_chargeObject);
                        $object->percentage_amount = $this->num_format($object->percentage_charge / 100 * $object->transaction_amount);
                        $object->gst_charge = $this->num_format($this->gst_on_chargers / 100 * $object->percentage_amount);
                        $object->total_amt_charged = $object->percentage_amount + $object->gst_charge;
                        $object->adjustment_total = $this->num_format($object->transaction_amount - $object->total_amt_charged);
                        break;

                    case 'UPI':

                        $object->percentage_charge = $this->get_other_charges($object->transaction_type, $object->created_merchant, $adjustment_chargeObject);
                        $object->percentage_amount = $this->num_format($object->percentage_charge / 100 * $object->transaction_amount);
                        $object->gst_charge = $this->num_format($this->gst_on_chargers / 100 * $object->percentage_amount);
                        $object->total_amt_charged = $object->percentage_amount + $object->gst_charge;
                        $object->adjustment_total = $this->num_format($object->transaction_amount - $object->total_amt_charged);
                        break;

                    case 'MW':

                        $object->percentage_charge = $this->get_other_charges($object->transaction_type, $object->created_merchant, $adjustment_chargeObject);
                        $object->percentage_amount = $this->num_format($object->percentage_charge / 100 * $object->transaction_amount);
                        $object->gst_charge = $this->num_format($this->gst_on_chargers / 100 * $object->percentage_amount);
                        $object->total_amt_charged = $object->percentage_amount + $object->gst_charge;
                        $object->adjustment_total = $this->num_format($object->transaction_amount - $object->total_amt_charged);
                        break;

                    default:
                        $object->percentage_charge = "";
                        $object->percentage_amount = "";
                        $object->gst_charge = "";
                        $object->total_amt_charged = "";
                        $object->adjustment_total = "";
                        break;
                }
            } else {

                $object->percentage_charge = "";
                $object->percentage_amount = "";
                $object->gst_charge = "";
                $object->total_amt_charged = "";
                $object->adjustment_total = "";
            }
        }
        return $transactions;
    }

    public function get_transactions_details(Request $request)
    {

        if ($request->ajax()) {
            $id = $request->id;
            $custom = new Custom();
            $merchantvendor_bank = new MerchantVendorBank();
            $merchantBusiness = new MerchantBusiness();
            $vendorBankInfo = new VendorBankInfo();
            $adjustment = new AdjustmentController();
            $transactions = $custom->get_live_payment_info($id);
            $response = [];
            $adjustment_result = [];
            $transaction_adjustment_response = [];
            $vendor_settlement_response = [];
            $status = "";
            foreach ($transactions as $index => $object) {
                $merchant_exist = $merchantvendor_bank->check_merchantbank_link_exists($object->created_merchant);
                $adjustment_status = FALSE;
                $message = "Unable to process this request";
                if ($merchant_exist[0]->merchant_bank) {

                    switch ($object->transaction_mode) {
                        case 'CC':

                            $get_bankid = $merchantvendor_bank->get_merchantbank_id($object->created_merchant, "cc_card");
                            $bank_name = $custom->get_adjustment_bank_name($get_bankid);
                            $adjustment_result = $adjustment->$bank_name($get_bankid, $object);
                            break;

                        case 'DC':

                            $get_bankid = $merchantvendor_bank->get_merchantbank_id($object->created_merchant, "dc_card");
                            $bank_name = $custom->get_adjustment_bank_name($get_bankid);
                            $adjustment_result = $adjustment->$bank_name($get_bankid, $object);
                            break;

                        case 'NB':

                            $get_bankid = $merchantvendor_bank->get_merchantbank_id($object->created_merchant, "net");
                            $bank_name = $custom->get_adjustment_bank_name($get_bankid);
                            $adjustment_result = $adjustment->$bank_name($get_bankid, $object);
                            break;

                        case 'UPI':

                            $get_bankid = $merchantvendor_bank->get_merchantbank_id($object->created_merchant, "upi");
                            $bank_name = $custom->get_adjustment_bank_name($get_bankid);
                            $adjustment_result = $adjustment->$bank_name($get_bankid, $object);
                            break;

                        default:
                            break;
                    }

                    if (!empty($adjustment_result)) {
                        $record_exist = $custom->get_vendor_adjustment_resp($object->created_merchant, $object->transaction_gid);
                        if (!$record_exist[0]->row_exist) {
                            $custom->add_vendor_adjustment_resp($vendor_settlement_response);
                            $message = "Vendor Settlement Completed";
                            $adjustment_status = TRUE;
                        } else {
                            $message = "Already Vendor Settlement Completed";
                            $adjustment_status = TRUE;
                        }
                    } else {
                        $message = "Vendor Settlement Not Completed";
                        $adjustment_status = FALSE;
                    }

                    /*if(!empty($transaction_adjustment_response))
                    {

                        switch ($transaction_adjustment_response["bank"]) {
                            case 'atom':
                                $json_result = $this->xmltojson($transaction_adjustment_response["result"]);
                                
                                if($json_result["VERIFIED"] == "SUCCESS"){
                                    $vendor_settlement_response = [
                                        "merchant_id"  => $object->created_merchant,
                                        "merchant_traxn_id"  => $json_result["MerchantTxnID"],
                                        "amount"  => $json_result["AMT"],
                                        "verified"  => $json_result["VERIFIED"],
                                        "bank_id"  => $json_result["BID"],
                                        "bankname"  => $json_result["bankname"],
                                        "vendor_traxn_id"  => $json_result["atomtxnId"],
                                        "descriminator"  => $json_result["discriminator"],
                                        "surcharge"  => $json_result["surcharge"],
                                        "card_number"  => $json_result["CardNumber"],
                                        "traxn_date"  => $json_result["TxnDate"],
                                        "recon_status"  => $json_result["ReconStatus"],
                                        "settlement_amount"  => $json_result["SettlementAmount"],
                                        "settlement_date"  => ($json_result["SettlementDate"]=="NA")?$this->datetime:$json_result["SettlementDate"],
                                        "vendor_from" => $transaction_adjustment_response["bank"],
                                        "transaction_type"=>$object->transaction_type,
                                        "created_date" => $this->datetime,
                                        "created_user" => auth()->guard('employee')->user()->id
                                  ];

                                  $record_exist = $custom->get_vendor_adjustment_resp($object->created_merchant,$object->transaction_gid);

                                  if(!$record_exist[0]->row_exist){
                                    $custom->add_vendor_adjustment_resp($vendor_settlement_response);
                                    $message = "Vendor Settlement Completed";
                                    $adjustment_status = TRUE;
                                  }else{
                                    $message = "Already Vendor Settlement Completed";
                                    $adjustment_status = TRUE;
                                  }
                                }else{
                                  $message = "Vendor Settlement Not Completed";
                                  $adjustment_status = FALSE;
                                }
                                break;
                            default:
                                # code...
                                break;
                        }
                    }*/
                    $response[] = [
                        "adjustment_status" => $adjustment_status,
                        "transaction_gid" => $object->transaction_gid,
                        "transaction_status" => $message
                    ];
                } else {

                    $message = "No Merchant Vendor Link established";

                    $response[] = [
                        "adjustment_status" => $adjustment_status,
                        "transaction_gid" => $object->transaction_gid,
                        "transaction_status" => $message
                    ];
                }
            }
            echo json_encode($response);
        }
    }

    private function get_card_charges($transaction_type, $merchant_id, MerchantChargeDetail $adjustment_chargeObject)
    {

        $card_charge = "";
        if (!empty($transaction_type)) {
            switch ($transaction_type) {

                case 'VISA':
                    $card_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($merchant_id, "cc_visa");
                    break;

                case 'MASTER':
                    $card_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($merchant_id, "cc_master");
                    break;

                case 'MAESTRO':
                    $card_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($merchant_id, "cc_master");
                    break;

                case 'RUPAY':
                    $card_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($merchant_id, "cc_rupay");
                    break;

                default:
                    $card_charge = "1.00";
                    break;
            }
        }

        return $card_charge;
    }

    private function get_netbanking_charges($transaction_type, $merchant_id, MerchantChargeDetail $adjustment_chargeObject)
    {

        $net_charge = "";
        if (!empty($transaction_type)) {

            switch ($transaction_type) {

                case '1002':
                case '3022':
                case 'ICIC':
                    $net_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($merchant_id, "net_icici");
                    break;

                case '1005':
                case '1013':
                case '3033':
                case '3058':
                case 'YESB':
                case 'KTB':
                    $net_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($merchant_id, "net_yes_kotak");
                    break;

                case '1006':
                case '3021':
                case 'HDFC':
                    $net_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($merchant_id, "net_hdfc");
                    break;

                case '1014':
                case '3044':
                case 'SBIN':
                    $net_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($merchant_id, "net_sbi");
                    break;

                default:
                    $net_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($merchant_id, "net_others");
                    break;
            }
        }
        return $net_charge;
    }

    private function get_other_charges($transaction_type, $merchant_id, MerchantChargeDetail $adjustment_chargeObject)
    {
        $other_charge = "";
        if (!empty($transaction_type)) {
            switch ($transaction_type) {

                case 'qrcode':
                    $other_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($merchant_id, "qrcode");
                    break;

                case '4004':
                    $other_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($merchant_id, "wallet");
                    break;

                default:
                    $other_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($merchant_id, "upi");
                    break;
            }
        }
        return $other_charge;
    }

    public function get_vendor_adjustments(Request $request)
    {
        $perpage = $request->perpage;
        $fromdate = $this->today;
        $todate = $this->today;
    
        if (!empty($request->trans_from_date) && !empty($request->trans_to_date)) {
            $fromdate = $request->trans_from_date;
            $todate = $request->trans_to_date;
            $perpage = $request->perpage;
        }
    
        session(['fromdate' => $fromdate]);
        session(['todate' => $todate]);
    
        // Retrieve data from the vendor adjustments table
        $vendoradjustObject = new VendorAdjustmentResp();
        $vendor_adjustments = $vendoradjustObject->get_vendor_adjustments($fromdate, $todate);
        $paginate_vendoradjustments = $this->_arrayPaginator($vendor_adjustments, $request, "vendoradjustments", $perpage);
    
        // Retrieve data from the payin_transactions table
        $payinTransactions = DB::table('payin_transactions')->get();
    
        // Pass both sets of data to the view
        return View::make('employee.pagination')->with([
            "module" => "vendoradjustment",
            "vendoradjustments" => $paginate_vendoradjustments,
            "payinTransactions" => $payinTransactions
        ])->render();
    }
    

    public function get_rupayapay_adjustments(Request $request)
    {

        $perpage = $request->perpage;
        $fromdate = $this->today;
        $todate = $this->today;
        if (!empty($request->trans_from_date) && !empty($request->trans_to_date)) {
            $fromdate = $request->trans_from_date;
            $todate = $request->trans_to_date;
            $perpage = $request->perpage;
        }
        session(['fromdate' => $fromdate]);
        session(['todate' => $todate]);
        $ryapayAdjustmentObject = new ryapayAdjustmentDetail();
        $ryapay_adjustments = $ryapayAdjustmentObject->get_adjustment_detail($fromdate, $todate);
        $paginate_ryapayadjustments = $this->_arrayPaginator($ryapay_adjustments, $request, "ryapayadjustments", $perpage);
        return View::make('employee.pagination')->with(["module" => "ryapayadjustment", "ryapayadjustments" => $paginate_ryapayadjustments])->render();
    }


    public function rupayapay_adjustment(Request $request)
    {

        if ($request->ajax()) {
            $id = $request->id;
            $custom = new Custom();
            $merchantBusiness = new MerchantBusiness();
            $adjustment_chargeObject = new MerchantChargeDetail();
            $ryapayAdjustmentObject = new ryapayAdjustmentDetail();
            $ryapay_chargeObject = new RyapayAdjustmentCharge();
            $paymentObject = new Payment();
            $settlementObject = new Settlement();
            $transactions = $custom->get_live_payment_info($id);
            $response = [];
            $adjustment_result = [];
            $transaction_adjustment_response = [];
            $vendor_settlement_response = [];
            $status = "";
            foreach ($transactions as $index => $object) {
                $adjustment_charge = $adjustment_chargeObject->adjustment_charge_exist($object->created_merchant);
                $adjustment_status = FALSE;
                $message = "Unable to process this request";
                if ($adjustment_charge[0]->charge_exist) {

                    switch ($object->transaction_mode) {
                        case 'CC':

                            $merchant_adjustment_charge = $this->get_card_charges($object->transaction_type, $object->created_merchant, $adjustment_chargeObject);
                            break;

                        case 'DC':

                            $merchant_adjustment_charge = $this->get_card_charges($object->transaction_type, $object->created_merchant, $adjustment_chargeObject);
                            break;

                        case 'NB':

                            $merchant_adjustment_charge = $this->get_netbanking_charges($object->transaction_type, $object->created_merchant, $adjustment_chargeObject);
                            break;

                        case 'UPI':

                            $merchant_adjustment_charge = $this->get_other_charges($object->transaction_type, $object->created_merchant, $adjustment_chargeObject);
                            break;

                        case 'MW':

                            $merchant_adjustment_charge = $this->get_other_charges($object->transaction_type, $object->created_merchant, $adjustment_chargeObject);
                            break;

                        default:
                            $merchant_adjustment_charge = 0;
                            break;
                    }

                    if ($merchant_adjustment_charge != 0) {
                        $charges_on_transaction = $this->num_format(($merchant_adjustment_charge / 100) * $object->transaction_amount);
                        $gst_on_charges = $this->num_format(($this->gst_on_chargers / 100) * $charges_on_transaction);
                        $total_amt_charged = $charges_on_transaction + $gst_on_charges;
                        $adjustment_amount = $this->num_format($object->transaction_amount - $total_amt_charged);

                        $ryapay_adjustment = [
                            "vendor_adjustment_id" => $object->id,
                            "merchant_id" => $object->created_merchant,
                            "merchant_transaction_id" => $object->transaction_gid,
                            "transaction_mode" => $object->transaction_mode,
                            "transaction_amount" => $object->transaction_amount,
                            "charges_per" => $merchant_adjustment_charge,
                            "charges_on_transaction" => $charges_on_transaction,
                            "gst_per" => $this->gst_on_chargers,
                            "gst_on_transaction" => $gst_on_charges,
                            "total_amt_charged" => $total_amt_charged,
                            "adjustment_amount" => $adjustment_amount,
                            "created_date" => $this->datetime,
                            "created_user" => auth()->guard('employee')->user()->id
                        ];

                        $current_balance = $paymentObject->total_transaction_amount($object->created_merchant);

                        $merchant_adjustment = [

                            "settlement_gid" => "ryapay_" . Str::random(16),
                            "transaction_gid" => $object->transaction_gid,
                            "current_balance" => $current_balance[0]->current_amount,
                            "settlement_amount" => $object->transaction_amount,
                            "settlement_fee" => $charges_on_transaction,
                            "settlement_tax" => $gst_on_charges,
                            "settlement_date" => $this->datetime,
                            "created_date" => $this->datetime,
                            "created_merchant" => $object->created_merchant
                        ];

                        $settlementObject->add_live_settlement($merchant_adjustment);
                        $paymentObject->update_transaction_adjustment($object->transaction_gid);
                        $ryapayAdjustmentObject->add_adjustment_detail($ryapay_adjustment);
                        //$vendor_adjustmentObject->update_vendor_adjustment($object->merchant_id,["ryapay_adjustment_status"=>"Y"]);
                    }


                    $adjustment_status = TRUE;
                    $message = "flakpay Adjustment completed Successfully";
                    $response[] = [
                        "adjustment_status" => $adjustment_status,
                        "transaction_gid" => $object->transaction_gid,
                        "transaction_status" => $message
                    ];
                } else {

                    $message = "No Link established";

                    $response[] = [
                        "adjustment_status" => $adjustment_status,
                        "transaction_gid" => $object->transaction_gid,
                        "transaction_status" => $message
                    ];
                }
            }
            echo json_encode($response);
        }
    }

    /*public function rupayapay_adjustment(Request $request){
        if($request->ajax()){

            $id = $request->id;
            $vendor_adjustmentObject = new VendorAdjustmentResp();
            $adjustment_chargeObject = new RyapayAdjustmentCharge();
            $ryapayAdjustmentObject = new ryapayAdjustmentDetail();
            $paymentObject = new Payment();
            $settlementObject = new Settlement();
            $vendor_adjustment_detail = $vendor_adjustmentObject->get_vendor_adjustment($id);
            $response = [];
            $ryapay_adjustment = [];
            foreach ($vendor_adjustment_detail as $key => $object) {

                $adjustment_charge = $adjustment_chargeObject->adjustment_charge_exist($object->merchant_id);
                $adjustment_status = FALSE;
                $message = "Unable to process this request";

                if($adjustment_charge[0]->charge_exist){

                    $merchant_adjustment_charge = 0;
                    switch ($object->descriminator) {
                        case 'CC':

                                switch ($object->transaction_type) {

                                    case 'VISA':
                                        $merchant_adjustment_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($object->merchant_id,"cc_visa");
                                        break;
                                    
                                    case 'MASTER':
                                        $merchant_adjustment_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($object->merchant_id,"cc_master");
                                        break;

                                    case 'MAESTRO':
                                        $merchant_adjustment_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($object->merchant_id,"cc_master");
                                        break;

                                    case 'RUPAY':
                                        $merchant_adjustment_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($object->merchant_id,"cc_rupay");
                                        break;
                                    
                                    default:
                                        # code...
                                        break;
                                }

                            break;

                        case 'DC':
                            
                                switch ($object->transaction_type) {

                                    case 'VISA':
                                        $merchant_adjustment_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($object->merchant_id,"dc_visa");
                                        break;
                                    
                                    case 'MASTER':
                                        $merchant_adjustment_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($object->merchant_id,"dc_master");
                                        break;

                                    case 'MAESTRO':
                                        $merchant_adjustment_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($object->merchant_id,"dc_master");
                                        break;

                                    case 'RUPAY':
                                        $merchant_adjustment_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($object->merchant_id,"dc_rupay");
                                        break;
                                    
                                    default:
                                        # code...
                                        break;
                                }
                            break;

                        case 'NB':

                                switch ($object->transaction_type) {

                                    case '1014':
                                        $merchant_adjustment_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($object->merchant_id,"net_sbi");
                                        break;
                                    
                                    case '1006':
                                        $merchant_adjustment_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($object->merchant_id,"net_hdfc");
                                        break;

                                    case '1002':
                                        $merchant_adjustment_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($object->merchant_id,"net_icici");
                                        break;

                                    case '1005':
                                        $merchant_adjustment_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($object->merchant_id,"net_yes_kotak");
                                        break;
                                    
                                    case '1013':
                                        $merchant_adjustment_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($object->merchant_id,"net_yes_kotak");
                                        break;

                                    default:
                                        $merchant_adjustment_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($object->merchant_id,"net_others");
                                        break;
                                }

                            break;

                        case 'UPI':

                            break;
                        default:
                            # code...
                            break;
                    }
                    if($merchant_adjustment_charge != 0)
                    {
                        $charges_on_transaction = number_format(($merchant_adjustment_charge/100)*$object->amount,2);
                        $gst_on_charges = number_format(($this->gst_on_chargers/100)*$charges_on_transaction,2);
                        $total_amt_charged = $charges_on_transaction+$gst_on_charges;
                        $adjustment_amount = number_format($object->amount-$total_amt_charged,2);

                        $ryapay_adjustment=[ 
                            "vendor_adjustment_id"=>$object->id,
                            "merchant_id"=>$object->merchant_id,
                            "merchant_transaction_id"=>$object->merchant_traxn_id,
                            "transaction_mode"=>$object->descriminator,
                            "transaction_amount"=>$object->amount,
                            "charges_per"=>$merchant_adjustment_charge, 
                            "charges_on_transaction"=>$charges_on_transaction, 
                            "gst_per"=>$this->gst_on_chargers,
                            "gst_on_transaction"=>$gst_on_charges , 
                            "total_amt_charged"=> $total_amt_charged,
                            "adjustment_amount"=>$adjustment_amount, 
                            "created_date"=>$this->datetime,
                            "created_user"=>auth()->guard('employee')->user()->id
                        ];

                        $current_balance = $paymentObject->total_transaction_amount($object->merchant_id);

                        $merchant_adjustment = [

                            "settlement_gid"=>"ryapay_".Str::random(16),
                            "transaction_gid"=>$object->merchant_traxn_id,
                            "current_balance"=>$current_balance[0]->current_amount,
                            "settlement_amount"=>$object->amount,
                            "settlement_fee"=>$charges_on_transaction,
                            "settlement_tax"=>$gst_on_charges,
                            "settlement_date"=>$this->datetime,
                            "created_date"=>$this->datetime,
                            "created_merchant"=>$object->merchant_id
                        ];
                        $settlementObject->add_live_settlement($merchant_adjustment);
                        $paymentObject->update_transaction_adjustment($object->merchant_traxn_id);
                        $ryapayAdjustmentObject->add_adjustment_detail($ryapay_adjustment);
                        $vendor_adjustmentObject->update_vendor_adjustment($object->merchant_id,["ryapay_adjustment_status"=>"Y"]);
                    }

                    
                    $adjustment_status = TRUE;
                    $message = "Rupayapay Adjustment completed Successfully";
                    $response[] = [
                        "adjustment_status"=>$adjustment_status,
                        "transaction_gid" => $object->merchant_traxn_id,
                        "transaction_status"=>$message
                    ];
                }else{

                    $response[] = [
                        "adjustment_status"=>$adjustment_status,
                        "transaction_gid" => $object->merchant_traxn_id,
                        "transaction_status"=>$message
                    ];
                }
            }
        }

        echo json_encode($response);
    }*/

    public function account(Request $request, $id = "")
    {

        if (array_key_exists($id, session('sublinkNames'))) {
            $navigation = new Navigation();
            $sublinks = $navigation->get_sub_links($id);
            $sublink_name = session('sublinkNames')[$id];
            switch ($id) {
                case 'ryapay-XYFGXwnY':

                    return view("employee.account.paymanage")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
                    break;
                case 'ryapay-VfWlmhwZ':

                    return view("employee.account.receimanage")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
                    break;
                case 'ryapay-2eZDqgsL':

                    return view("employee.account.fixedasset")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
                    break;
                case 'ryapay-TZ4rElGj':

                    return view("employee.account.globaltax")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
                    break;

                case 'ryapay-6q1947ay':

                    return view("employee.account.chartaccount")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
                    break;

                case 'ryapay-T0Xk89gf':

                    return view("employee.account.bookkeeping")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
                    break;

                case 'ryapay-d6zhbMJQ':

                    return view("employee.account.invoice")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
                    break;
            }
        } else {
            return redirect()->back();
        }
    }

    //Account Payable Management Functionality starts here

    public function show_purchase_order(Request $request)
    {
        return view("employee.account.createeditporder")->with("form", "create");
    }

    public function get_purchase_order(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $porderObject = new RyapayPorder();
            $porders = $porderObject->get_all_porder();
            $paginate_porder = $this->_arrayPaginator($porders, $request, "porders", $perpage);
            return View::make('employee.pagination')->with(["module" => "porder", "porders" => $paginate_porder])->render();
        }
    }

    public static function porder_items_options()
    {
        $ryapay_items = new RyapayItem();
        $items_options = $ryapay_items->get_dropdown_items();
        return $items_options;
    }


    public function edit_purchase_order(Request $request, $id)
    {
        $porderObject = new RyapayPorder();
        $porder = $porderObject->edit_porder($id);
        $item_columns = ["item_id", "item_amount", "item_quantity", "item_total"];
        $items = [];
        $porder_details = [];
        foreach ($porder as $index => $object) {
            foreach ($object as $key => $value) {
                if (in_array($key, $item_columns)) {
                    $items[$index][$key] = $value;
                } else {
                    $porder_details[$key] = $value;
                }
            }
        }
        $porder_details["items"] = $items;

        return view("employee.account.createeditporder")->with(["form" => "edit", "edit_data" => $porder_details]);
    }

    public function store_purchase_order(Request $request)
    {
        if ($request->ajax()) {
            $porder_items = $request->only('item_id', 'item_amount', 'item_quantity', 'item_total');
            $porder_data = $request->except(
                '_token',
                'item_amount',
                'item_quantity',
                'item_total',
                'supplier_email',
                'supplier_phone',
                'supplier_address',
                'supplier_company',
                'supplier_name',
                'item_id'
            );
            $item_data = [];

            $porderObject = new RyapayPorder();
            $porderitemObject = new RyapayPorderItem();
            $porder_data["created_date"] = $this->datetime;
            $porder_data["created_user"] = auth()->guard('employee')->user()->id;

            $insert_id = $porderObject->add_porder($porder_data);
            if ($insert_id) {
                foreach ($porder_items as $key => $itemarray) {
                    foreach ($itemarray as $index => $value) {
                        $item_data[$index][$key] = $value;
                        $item_data[$index]["porder_id"] = $insert_id;
                        $item_data[$index]["created_date"] = $this->datetime;
                        $item_data[$index]["created_user"] = auth()->guard('employee')->user()->id;
                    }
                }
                $insert_status = $porderitemObject->add_porder_item($item_data);

                if ($insert_status) {
                    $message = ValidationMessage::$validation_messages["porder_insert_success"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {
                    $message = ValidationMessage::$validation_messages["porder_insert_failed"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                }
            }
        }
    }

    public function update_purchase_order(Request $request)
    {
        if ($request->ajax()) {
            $porder_id = $request->id;
            $porder_items = $request->only('item_id', 'item_amount', 'item_quantity', 'item_total');
            $porder_data = $request->except(
                '_token',
                'item_amount',
                'item_quantity',
                'item_total',
                'supplier_email',
                'supplier_phone',
                'supplier_address',
                'supplier_company',
                'supplier_name',
                'item_id',
                'id'
            );
            $item_data = [];

            $porderObject = new RyapayPorder();
            $porderitemObject = new RyapayPorderItem();

            $update_status = $porderObject->update_porder($porder_id, $porder_data);
            if (!empty($porder_items)) {
                foreach ($porder_items as $key => $itemarray) {
                    foreach ($itemarray as $index => $value) {
                        $item_data[$index][$key] = $value;
                        $item_data[$index]["porder_id"] = $porder_id;
                        $item_data[$index]["created_date"] = $this->datetime;
                        $item_data[$index]["created_user"] = auth()->guard('employee')->user()->id;
                    }
                }

                $porderitemObject->remove_porder_item($porder_id);

                $insert_status = $porderitemObject->add_porder_item($item_data);

                if ($insert_status) {
                    $message = ValidationMessage::$validation_messages["porder_update_success"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {
                    $message = ValidationMessage::$validation_messages["porder_update_failed"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                }
            }
        }
    }

    public function get_purchase_order_items(Request $request, $id)
    {
        if ($request->ajax()) {
            $porderitemObject = new RyapayPorderItem();
            $porder_items =  $porderitemObject->get_porder_items($id);
            return View::make('employee.pagination')->with(["module" => "porder_item", "porder_items" => $porder_items])->render();
        }
    }

    public function get_suporder_invoice(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $suporderObject = new RyapayaSupOrderInv();
            $suporders = $suporderObject->get_all_suporder();
            $paginate_suporder = $this->_arrayPaginator($suporders, $request, "suporders", $perpage);
            return View::make('employee.pagination')->with(["module" => "suporder", "suporders" => $paginate_suporder])->render();
        }
    }


    public function show_suporder_invoice()
    {
        return view("employee.account.addeditsupplierinvoice")->with("form", "create");
    }



    public function store_suporder_invoice(Request $request)
    {
        if ($request->ajax()) {
            $suporder_items = $request->only('item_id', 'item_amount', 'item_quantity', 'item_total');
            $suporder_data = $request->except('_token', 'item_amount', 'item_quantity', 'item_total', 'item_id');
            $item_data = [];

            $suporderObject = new RyapayaSupOrderInv();
            $suporderitemObject = new RyapayaSupOrderItem();
            $suporder_data["created_date"] = $this->datetime;
            $suporder_data["created_user"] = auth()->guard('employee')->user()->id;

            $insert_id = $suporderObject->add_suporder_invoice($suporder_data);
            if ($insert_id) {
                foreach ($suporder_items as $key => $itemarray) {
                    foreach ($itemarray as $index => $value) {
                        $item_data[$index][$key] = $value;
                        $item_data[$index]["suporder_id"] = $insert_id;
                        $item_data[$index]["created_date"] = $this->datetime;
                        $item_data[$index]["created_user"] = auth()->guard('employee')->user()->id;
                    }
                }
                $insert_status = $suporderitemObject->add_suporder_item($item_data);

                if ($insert_status) {
                    $message = ValidationMessage::$validation_messages["suporder_insert_success"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {
                    $message = ValidationMessage::$validation_messages["suporder_insert_failed"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                }
            }
        }
    }


    public function edit_suporder_invoice(Request $request, $id)
    {
        $suporderObject = new RyapayaSupOrderInv();
        $supporder = $suporderObject->edit_suporder($id);
        $item_columns = ["item_id", "item_amount", "item_quantity", "item_total"];
        $items = [];
        $suporder_details = [];
        foreach ($supporder as $index => $object) {
            foreach ($object as $key => $value) {
                if (in_array($key, $item_columns)) {
                    $items[$index][$key] = $value;
                } else {
                    $suporder_details[$key] = $value;
                }
            }
        }
        $suporder_details["items"] = $items;

        return view("employee.account.addeditsupplierinvoice")->with(["form" => "edit", "edit_data" => $suporder_details]);
    }

    public function update_suporder_invoice(Request $request)
    {

        if ($request->ajax()) {
            $suporder_id = $request->id;
            $suporder_items = $request->only('item_id', 'item_amount', 'item_quantity', 'item_total');
            $suporder_data = $request->except('_token', 'item_amount', 'item_quantity', 'item_total', 'item_id', 'id');
            $item_data = [];

            $suporderObject = new RyapayaSupOrderInv();
            $suporderitemObject = new RyapayaSupOrderItem();

            $update_status = $suporderObject->update_supporder($suporder_id, $suporder_data);

            if (!empty($suporder_items)) {

                foreach ($suporder_items as $key => $itemarray) {
                    foreach ($itemarray as $index => $value) {
                        $item_data[$index][$key] = $value;
                        $item_data[$index]["suporder_id"] = $suporder_id;
                        $item_data[$index]["created_date"] = $this->datetime;
                        $item_data[$index]["created_user"] = auth()->guard('employee')->user()->id;
                    }
                }

                $suporderitemObject->remove_suporder_item($suporder_id);

                $insert_status = $suporderitemObject->add_suporder_item($item_data);

                if ($insert_status) {
                    $message = ValidationMessage::$validation_messages["suporder_update_success"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {
                    $message = ValidationMessage::$validation_messages["suporder_update_failed"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                }
            }
        }
    }


    public function get_supexp_invoice(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $supexpObject = new RyapaySupExpInv();
            $supexps = $supexpObject->get_all_supexp();
            $paginate_supexp = $this->_arrayPaginator($supexps, $request, "supexps", $perpage);
            return View::make('employee.pagination')->with(["module" => "supexp", "supexps" => $paginate_supexp])->render();
        }
    }

    public function show_supexp_invoice()
    {
        return view("employee.account.addeditsuppexpinvoice")->with("form", "create");
    }

    public function store_supexp_invoice(Request $request)
    {
        if ($request->ajax()) {

            $supexp_items = $request->only('item_id', 'item_amount', 'item_quantity', 'item_total', 'expense_code');
            $supexp_data = $request->except('_token', 'item_amount', 'item_quantity', 'item_total', 'item_id', 'expense_code');
            $item_data = [];

            $supexpObject = new RyapaySupExpInv();
            $supexpitemObject = new RyapaySupExpItem();
            $supexp_data["created_date"] = $this->datetime;
            $supexp_data["created_user"] = auth()->guard('employee')->user()->id;

            $insert_id = $supexpObject->add_supexp_invoice($supexp_data);
            if ($insert_id) {
                foreach ($supexp_items as $key => $itemarray) {
                    foreach ($itemarray as $index => $value) {
                        $item_data[$index][$key] = $value;
                        $item_data[$index]["supexp_id"] = $insert_id;
                        $item_data[$index]["created_date"] = $this->datetime;
                        $item_data[$index]["created_user"] = auth()->guard('employee')->user()->id;
                    }
                }
                $insert_status = $supexpitemObject->add_supexp_item($item_data);

                if ($insert_status) {
                    $message = ValidationMessage::$validation_messages["supexp_insert_success"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {
                    $message = ValidationMessage::$validation_messages["supexp_insert_failed"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                }
            }
        }
    }

    public function edit_supexp_invoice(Request $request, $id)
    {

        $supexpObject = new RyapaySupExpInv();
        $suppexp = $supexpObject->edit_supexp($id);
        $item_columns = ["item_id", "item_amount", "item_quantity", "item_total", "expense_code"];
        $items = [];
        $supexp_details = [];
        foreach ($suppexp as $index => $object) {
            foreach ($object as $key => $value) {
                if (in_array($key, $item_columns)) {
                    $items[$index][$key] = $value;
                } else {
                    $supexp_details[$key] = $value;
                }
            }
        }
        $supexp_details["items"] = $items;
        return view("employee.account.addeditsuppexpinvoice")->with(["form" => "edit", "edit_data" => $supexp_details]);
    }


    public function update_supexp_invoice(Request $request)
    {
        if ($request->ajax()) {
            $supexp_id = $request->id;
            $supexp_items = $request->only('item_id', 'item_amount', 'item_quantity', 'item_total', 'expense_code');
            $supexp_data = $request->except('_token', 'item_amount', 'item_quantity', 'item_total', 'item_id', 'id', 'expense_code');
            $item_data = [];

            $supexpObject = new RyapaySupExpInv();
            $supexpitemObject = new RyapaySupExpItem();

            $update_status = $supexpObject->update_supexp($supexp_id, $supexp_data);

            if (!empty($supexp_items)) {

                foreach ($supexp_items as $key => $itemarray) {
                    foreach ($itemarray as $index => $value) {
                        $item_data[$index][$key] = $value;
                        $item_data[$index]["supexp_id"] = $supexp_id;
                        $item_data[$index]["created_date"] = $this->datetime;
                        $item_data[$index]["created_user"] = auth()->guard('employee')->user()->id;
                    }
                }

                $supexpitemObject->remove_supexp_item($supexp_id);

                $insert_status = $supexpitemObject->add_supexp_item($item_data);

                if ($insert_status) {
                    $message = ValidationMessage::$validation_messages["supexp_update_success"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {
                    $message = ValidationMessage::$validation_messages["supexp_update_failed"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                }
            }
        }
    }


    public function show_debit_note(Request $request)
    {
        return view("employee.account.createeditdebitnote")->with("form", "create");
    }

    public function get_supcd_note(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $supnoteObject = new RyapaySupCDNote();
            $supnotes = $supnoteObject->get_all_supplier_note();
            $paginate_supnote = $this->_arrayPaginator($supnotes, $request, "supnotes", $perpage);
            return View::make('employee.pagination')->with(["module" => "supnote", "supnotes" => $paginate_supnote])->render();
        }
    }

    public function store_supcd_note(Request $request)
    {
        if ($request->ajax()) {

            $supnote_data = $request->except('_token');

            $supnoteObject = new RyapaySupCDNote();

            $supnote_data["created_date"] = $this->datetime;
            $supnote_data["created_user"] = auth()->guard('employee')->user()->id;

            $insert_status = $supnoteObject->add_supplier_note($supnote_data);

            if ($insert_status) {
                $message = ValidationMessage::$validation_messages["supnote_insert_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["supnote_insert_failed"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            }
        }
    }

    public function edit_supcd_note(Request $request, $id)
    {

        $supexpObject = new RyapaySupCDNote();
        $supnote = $supexpObject->edit_supnote($id)[0];

        return view("employee.account.createeditdebitnote")->with(["form" => "edit", "edit_data" => $supnote]);
    }

    public function update_supcd_note(Request $request)
    {

        if ($request->ajax()) {
            $sup_note_id = $request->id;
            $supnote_data = $request->except('_token', 'id');

            $supnoteObject = new RyapaySupCDNote();

            $update_status = $supnoteObject->update_supplier_note($sup_note_id, $supnote_data);

            if ($update_status) {
                $message = ValidationMessage::$validation_messages["supnote_update_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["supnote_update_failed"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            }
        }
    }

    //Account Payable Management Functionality ends here

    //Account Receivable Management functionality starts here

    //Account Sales Order Functionality starts here

    public function show_sales_order(Request $request)
    {
        return view("employee.account.addeditsorder")->with("form", "create");
    }

    public function get_selected_customer_info(Request $request, $id)
    {
        if ($request->ajax()) {
            $customerObject = new RyaPayCustomer();
            $customer_info = $customerObject->get_sales_customer_info($id);
            echo json_encode($customer_info);
        }
    }

    public function get_sales_order(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $sorderObject = new RyapaySorder();
            $sorders = $sorderObject->get_all_sorder();
            $paginate_sorder = $this->_arrayPaginator($sorders, $request, "sorders", $perpage);
            return View::make('employee.pagination')->with(["module" => "sorder", "sorders" => $paginate_sorder])->render();
        }
    }

    public function edit_sales_order(Request $request, $id)
    {
        $sorderObject = new RyapaySorder();
        $sorder = $sorderObject->edit_sorder($id);
        $item_columns = ["item_id", "item_amount", "item_quantity", "item_total"];
        $items = [];
        $sorder_details = [];
        foreach ($sorder as $index => $object) {
            foreach ($object as $key => $value) {
                if (in_array($key, $item_columns)) {
                    $items[$index][$key] = $value;
                } else {
                    $sorder_details[$key] = $value;
                }
            }
        }

        $sorder_details["items"] = $items;

        return view("employee.account.addeditsorder")->with(["form" => "edit", "edit_data" => $sorder_details]);
    }

    public function store_sales_order(Request $request)
    {
        if ($request->ajax()) {
            $sorder_items = $request->only('item_id', 'item_amount', 'item_quantity', 'item_total');
            $sorder_data = $request->except(
                '_token',
                'item_amount',
                'item_quantity',
                'item_total',
                'customer_email',
                'customer_phone',
                'customer_name',
                'item_id'
            );
            $item_data = [];

            $sorderObject = new RyapaySorder();
            $sorderitemObject = new RyapaySorderItem();
            $sorder_data["created_date"] = $this->datetime;
            $sorder_data["created_user"] = auth()->guard('employee')->user()->id;

            $insert_id = $sorderObject->add_sorder($sorder_data);
            if ($insert_id) {
                foreach ($sorder_items as $key => $itemarray) {
                    foreach ($itemarray as $index => $value) {
                        $item_data[$index][$key] = $value;
                        $item_data[$index]["sorder_id"] = $insert_id;
                        $item_data[$index]["created_date"] = $this->datetime;
                        $item_data[$index]["created_user"] = auth()->guard('employee')->user()->id;
                    }
                }
                $insert_status = $sorderitemObject->add_sorder_item($item_data);

                if ($insert_status) {
                    $message = ValidationMessage::$validation_messages["sorder_insert_success"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {
                    $message = ValidationMessage::$validation_messages["sorder_insert_failed"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                }
            }
        }
    }



    public function update_sales_order(Request $request)
    {
        if ($request->ajax()) {
            $sorder_id = $request->id;
            $sorder_items = $request->only('item_id', 'item_amount', 'item_quantity', 'item_total');
            $sorder_data = $request->except(
                '_token',
                'item_amount',
                'item_quantity',
                'item_total',
                'customer_email',
                'customer_phone',
                'customer_name',
                'item_id',
                'id'
            );
            $item_data = [];

            $sorderObject = new RyapaySorder();
            $sorderitemObject = new RyapaySorderItem();

            $update_status = $sorderObject->update_sorder($sorder_id, $sorder_data);
            if (!empty($sorder_items)) {
                foreach ($sorder_items as $key => $itemarray) {
                    foreach ($itemarray as $index => $value) {
                        $item_data[$index][$key] = $value;
                        $item_data[$index]["sorder_id"] = $sorder_id;
                        $item_data[$index]["created_date"] = $this->datetime;
                        $item_data[$index]["created_user"] = auth()->guard('employee')->user()->id;
                    }
                }

                $sorderitemObject->remove_sorder_item($sorder_id);

                $insert_status = $sorderitemObject->add_sorder_item($item_data);

                if ($insert_status) {
                    $message = ValidationMessage::$validation_messages["sorder_update_success"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {
                    $message = ValidationMessage::$validation_messages["sorder_update_failed"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                }
            }
        }
    }

    //Customer Order Invoice Booking
    public function get_sales_order_items(Request $request, $id)
    {
        if ($request->ajax()) {
            $sorderitemObject = new RyapaySorderItem();
            $sorder_items =  $sorderitemObject->get_sorder_items($id);
            return View::make('employee.pagination')->with(["module" => "sorder_item", "sorder_items" => $sorder_items])->render();
        }
    }

    public function get_custorder_invoice(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $custorderObject = new RyapayCustOrderInv();
            $custorders = $custorderObject->get_all_custorder();
            $paginate_custorder = $this->_arrayPaginator($custorders, $request, "custorders", $perpage);
            return View::make('employee.pagination')->with(["module" => "custorder", "custorders" => $paginate_custorder])->render();
        }
    }


    public function show_custorder_invoice()
    {
        return view("employee.account.addeditcustomerinvoice")->with("form", "create");
    }



    public function store_custorder_invoice(Request $request)
    {
        if ($request->ajax()) {
            $custorder_items = $request->only('item_id', 'item_amount', 'item_quantity', 'item_total');
            $custorder_data = $request->except('_token', 'item_amount', 'item_quantity', 'item_total', 'item_id');
            $item_data = [];

            $custorderObject = new RyapayCustOrderInv();
            $custorderitemObject = new RyapayCustOrderItem();
            $custorder_data["created_date"] = $this->datetime;
            $custorder_data["created_user"] = auth()->guard('employee')->user()->id;

            $insert_id = $custorderObject->add_custorder_invoice($custorder_data);
            if ($insert_id) {
                foreach ($custorder_items as $key => $itemarray) {
                    foreach ($itemarray as $index => $value) {
                        $item_data[$index][$key] = $value;
                        $item_data[$index]["custorder_id"] = $insert_id;
                        $item_data[$index]["created_date"] = $this->datetime;
                        $item_data[$index]["created_user"] = auth()->guard('employee')->user()->id;
                    }
                }
                $insert_status = $custorderitemObject->add_custorder_item($item_data);

                if ($insert_status) {
                    $message = ValidationMessage::$validation_messages["custorder_insert_success"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {
                    $message = ValidationMessage::$validation_messages["custorder_insert_failed"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                }
            }
        }
    }


    public function edit_custorder_invoice(Request $request, $id)
    {
        $custorderObject = new RyapayCustOrderInv();
        $custorder = $custorderObject->edit_custorder($id);
        $item_columns = ["item_id", "item_amount", "item_quantity", "item_total"];
        $items = [];
        $custorder_details = [];
        foreach ($custorder as $index => $object) {
            foreach ($object as $key => $value) {
                if (in_array($key, $item_columns)) {
                    $items[$index][$key] = $value;
                } else {
                    $custorder_details[$key] = $value;
                }
            }
        }
        $custorder_details["items"] = $items;

        return view("employee.account.addeditcustomerinvoice")->with(["form" => "edit", "edit_data" => $custorder_details]);
    }

    public function update_custorder_invoice(Request $request)
    {

        if ($request->ajax()) {
            $custorder_id = $request->id;
            $custorder_items = $request->only('item_id', 'item_amount', 'item_quantity', 'item_total');
            $custorder_data = $request->except('_token', 'item_amount', 'item_quantity', 'item_total', 'item_id', 'id');
            $item_data = [];

            $custorderObject = new RyapayCustOrderInv();
            $custorderitemObject = new RyapayCustOrderItem();

            $update_status = $custorderObject->update_custorder($custorder_id, $custorder_data);

            if (!empty($custorder_items)) {

                foreach ($custorder_items as $key => $itemarray) {
                    foreach ($itemarray as $index => $value) {
                        $item_data[$index][$key] = $value;
                        $item_data[$index]["custorder_id"] = $custorder_id;
                        $item_data[$index]["created_date"] = $this->datetime;
                        $item_data[$index]["created_user"] = auth()->guard('employee')->user()->id;
                    }
                }

                $custorderitemObject->remove_custorder_item($custorder_id);

                $insert_status = $custorderitemObject->add_custorder_item($item_data);

                if ($insert_status) {
                    $message = ValidationMessage::$validation_messages["custorder_update_success"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {
                    $message = ValidationMessage::$validation_messages["custorder_update_failed"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                }
            }
        }
    }


    public function show_custcd_note(Request $request)
    {
        return view("employee.account.addeditcustnote")->with("form", "create");
    }

    public function get_custcd_note(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $custnoteObject = new RyapayaCustCDNote();
            $custnotes = $custnoteObject->get_all_customer_note();
            $paginate_custnote = $this->_arrayPaginator($custnotes, $request, "custnotes", $perpage);
            return View::make('employee.pagination')->with(["module" => "custnote", "custnotes" => $paginate_custnote])->render();
        }
    }

    public function store_custcd_note(Request $request)
    {
        if ($request->ajax()) {

            $custnote_data = $request->except('_token');

            $custnoteObject = new RyapayaCustCDNote();

            $custnote_data["created_date"] = $this->datetime;
            $custnote_data["created_user"] = auth()->guard('employee')->user()->id;

            $insert_status = $custnoteObject->add_customer_note($custnote_data);

            if ($insert_status) {
                $message = ValidationMessage::$validation_messages["custnote_insert_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["custnote_insert_failed"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            }
        }
    }

    public function edit_custcd_note(Request $request, $id)
    {

        $custnoteObject = new RyapayaCustCDNote();
        $custnote = $custnoteObject->edit_custnote($id)[0];

        return view("employee.account.addeditcustnote")->with(["form" => "edit", "edit_data" => $custnote]);
    }

    public function update_custcd_note(Request $request)
    {

        if ($request->ajax()) {
            $cust_note_id = $request->id;
            $custnote_data = $request->except('_token', 'id');

            $custnoteObject = new RyapayaCustCDNote();

            $update_status = $custnoteObject->update_customer_note($cust_note_id, $custnote_data);

            if ($update_status) {
                $message = ValidationMessage::$validation_messages["custnote_update_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["custnote_update_failed"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            }
        }
    }

    //Account Receivable Management Functionality ends here


    //Account asset sub menu functionality code starts here
    public function store_asset(Request $request)
    {

        if ($request->ajax()) {
            $assetObject = new RyapayFixedAsset();

            $asset_data = $request->except('_token');
            $asset_data["asset_gid"] = 'asset_' . Str::random(8);
            $asset_data["created_user"] = auth()->guard('employee')->user()->id;
            $asset_data["asset_status"] =  'create';
            $asset_data["created_date"] =  $this->datetime;

            $asset_status = $assetObject->add_asset($asset_data);
            if ($asset_status) {
                $message = ValidationMessage::$validation_messages["asset_insert_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["asset_insert_failed"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            }
        }
    }

    public function edit_asset(Request $request, $id)
    {
        if ($request->ajax()) {
            $assetObject = new RyapayFixedAsset();
            $edit_asset = $assetObject->edit_asset_info($id);
            echo json_encode($edit_asset);
        }
    }

    public function update_asset(Request $request)
    {
        $assetObject = new RyapayFixedAsset();
        $asset_id = $request->only("id");
        $asset_data = $request->except("_token", "id");
        $update_asset = $assetObject->update_asset_info($asset_data, $asset_id);
        if ($update_asset) {
            $message = ValidationMessage::$validation_messages["asset_update_success"];
            echo json_encode(array("status" => TRUE, "message" => $message));
        } else {
            $message = ValidationMessage::$validation_messages["asset_update_failed"];
            echo json_encode(array("status" => TRUE, "message" => $message));
        }
    }

    public function destroy_asset(Request $request)
    {
        $customerObject = new RyaPayCustomer();
        $customer_id = $request->only("id");
        $customer_data = $request->except("_token", "id");
        $customer_data["status"] = "inactive";
        $update_customer = $customerObject->update_customer_info($customer_data, $customer_id);
        if ($update_customer) {
            $message = ValidationMessage::$validation_messages["customer_delete_success"];
            echo json_encode(array("status" => TRUE, "message" => $message));
        } else {
            $message = ValidationMessage::$validation_messages["customer_delete_failed"];
            echo json_encode(array("status" => TRUE, "message" => $message));
        }
    }

    public function get_all_assets(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $assetObject = new RyapayFixedAsset();
            $asset = $assetObject->get_all_assets();
            $paginate_asset = $this->_arrayPaginator($asset, $request, "assets", $perpage);
            return View::make('employee.pagination')->with(["module" => "asset", "assets" => $paginate_asset])->render();
        }
    }

    public function update_capital_asset(Request $request)
    {
        $assetObject = new RyapayFixedAsset();
        $asset_id = $request->only("id");
        $asset_data = $request->except("_token", "id");
        $asset_data["asset_status"] = "capitalization";
        $asset_data["asset_depre_amount"] = "0";
        $asset_data["asset_sale_amount"] = "0";
        $update_asset = $assetObject->update_asset_info($asset_data, $asset_id);
        if ($update_asset) {
            $message = ValidationMessage::$validation_messages["capital_asset_insert_success"];
            echo json_encode(array("status" => TRUE, "message" => $message));
        } else {
            $message = ValidationMessage::$validation_messages["capital_asset_insert_failed"];
            echo json_encode(array("status" => TRUE, "message" => $message));
        }
    }

    public function get_all_capital_assets(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $assetObject = new RyapayFixedAsset();
            $capitalasset = $assetObject->get_all_capital_assets();
            $paginate_capitalasset = $this->_arrayPaginator($capitalasset, $request, "capitalassets", $perpage);
            return View::make('employee.pagination')->with(["module" => "capitalasset", "capitalassets" => $paginate_capitalasset])->render();
        }
    }


    public function get_all_depreciate_assets(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $assetObject = new RyapayFixedAsset();
            $depreciateasset = $assetObject->get_all_depreciate_assets();
            $paginate_depreciateasset = $this->_arrayPaginator($depreciateasset, $request, "depreciateassets", $perpage);
            return View::make('employee.pagination')->with(["module" => "depreciateasset", "depreciateassets" => $paginate_depreciateasset])->render();
        }
    }

    public function update_depreciate_asset(Request $request)
    {
        $assetObject = new RyapayFixedAsset();
        $asset_id = $request->only("id");
        $asset_data = $request->except("_token", "id");
        $asset_data["asset_status"] = "depreciation";
        $asset_data["asset_sale_amount"] = "0";
        $update_asset = $assetObject->update_asset_info($asset_data, $asset_id);
        if ($update_asset) {
            $message = ValidationMessage::$validation_messages["depreciate_asset_insert_success"];
            echo json_encode(array("status" => TRUE, "message" => $message));
        } else {
            $message = ValidationMessage::$validation_messages["depreciate_asset_insert_failed"];
            echo json_encode(array("status" => TRUE, "message" => $message));
        }
    }

    public function get_all_sale_assets(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $assetObject = new RyapayFixedAsset();
            $saleasset = $assetObject->get_all_sale_assets();
            $paginate_saleasset = $this->_arrayPaginator($saleasset, $request, "saleassets", $perpage);
            return View::make('employee.pagination')->with(["module" => "saleasset", "saleassets" => $paginate_saleasset])->render();
        }
    }

    public function update_sale_asset(Request $request)
    {
        $assetObject = new RyapayFixedAsset();
        $asset_id = $request->only("id");
        $asset_data = $request->except("_token", "id");
        $asset_data["asset_status"] = "sale";
        $update_asset = $assetObject->update_asset_info($asset_data, $asset_id);
        if ($update_asset) {
            $message = ValidationMessage::$validation_messages["sale_asset_insert_success"];
            echo json_encode(array("status" => TRUE, "message" => $message));
        } else {
            $message = ValidationMessage::$validation_messages["sale_asset_insert_failed"];
            echo json_encode(array("status" => TRUE, "message" => $message));
        }
    }

    //Account asset sub menu functionality code end here

    //Account Global Tax sub menu functionality starts end here

    public function show_tax_settlement(Request $request)
    {
        return view("employee.account.addedittaxsettle")->with("form", "create");
    }

    public function show_tax_adjustment(Request $request)
    {
        return view("employee.account.addedittaxadjust")->with("form", "create");
    }

    public function show_tax_payment(Request $request)
    {
        return view("employee.account.addedittaxpay")->with("form", "create");
    }

    public function get_tax_settlement(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $tax_settlement_object = new RyapayTaxSettlement();
            $taxsettlement = $tax_settlement_object->get_all_taxsettlement();
            $paginate_taxsettlement = $this->_arrayPaginator($taxsettlement, $request, "taxsettlements", $perpage);
            return View::make('employee.pagination')->with(["module" => "taxsettlement", "taxsettlements" => $paginate_taxsettlement])->render();
        }
    }

    public function get_tax_adjustment(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $tax_adjustment_object = new RyapayTaxAdjustment();
            $taxadjustment = $tax_adjustment_object->get_all_taxadjustment();
            $paginate_taxadjustment = $this->_arrayPaginator($taxadjustment, $request, "taxadjustments", $perpage);
            return View::make('employee.pagination')->with(["module" => "taxadjustment", "taxadjustments" => $paginate_taxadjustment])->render();
        }
    }

    public function get_tax_payment(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $tax_payment_object = new RyapayTaxPayment();
            $taxpayment = $tax_payment_object->get_all_taxpayment();
            $paginate_taxpayment = $this->_arrayPaginator($taxpayment, $request, "taxpayments", $perpage);
            return View::make('employee.pagination')->with(["module" => "taxpayment", "taxpayments" => $paginate_taxpayment])->render();
        }
    }

    public function store_tax_settlement(Request $request)
    {

        if ($request->ajax()) {

            $tax_settlement_object = new RyapayTaxSettlement();
            $tax_settlement = $request->except("_token");
            $tax_settlement["created_date"] = $this->datetime;
            $tax_settlement["created_user"] = auth()->guard('employee')->user()->id;

            $insert_status = $tax_settlement_object->add_taxsettlement($tax_settlement);

            if ($insert_status) {
                $message = ValidationMessage::$validation_messages["taxsettlement_insert_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {

                $message = ValidationMessage::$validation_messages["taxsettlement_insert_failed"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            }
        }
    }

    public function store_tax_adjustment(Request $request)
    {
        if ($request->ajax()) {


            $tax_adjustment_object = new RyapayTaxAdjustment();
            $tax_adjustment = $request->except("_token");
            $tax_adjustment["created_date"] = $this->datetime;
            $tax_adjustment["created_user"] = auth()->guard('employee')->user()->id;

            $insert_status = $tax_adjustment_object->add_taxadjustment($tax_adjustment);

            if ($insert_status) {
                $message = ValidationMessage::$validation_messages["taxadjustment_insert_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {

                $message = ValidationMessage::$validation_messages["taxadjustment_insert_failed"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            }
        }
    }

    public function store_tax_payment(Request $request)
    {
        if ($request->ajax()) {

            $tax_payment_object = new RyapayTaxPayment();
            $tax_payment = $request->except("_token");
            $tax_payment["created_date"] = $this->datetime;
            $tax_payment["created_user"] = auth()->guard('employee')->user()->id;

            $insert_status = $tax_payment_object->add_taxpayment($tax_payment);

            if ($insert_status) {
                $message = ValidationMessage::$validation_messages["taxpayment_insert_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {

                $message = ValidationMessage::$validation_messages["taxpayment_insert_failed"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            }
        }
    }

    //Account Global Tax sub menu functionality code end here


    //Account account Chart Functionality starts here
    public function get_chart_options(Request $request)
    {
        if ($request->ajax()) {
            echo json_encode(CharOfAccount::get_code_options());
        }
    }

    public function get_allchart_details(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $chart_of_account = new CharOfAccount();
            $account_charts = $chart_of_account->get_account_details();
            $paginate_account_charts = $this->_arrayPaginator($account_charts, $request, "accountcharts", $perpage);
            return View::make("employee.pagination")->with(["module" => "accountchart", "accountcharts" => $paginate_account_charts])->render();
        }
    }

    public function edit_chart_record(Request $request, $chart_id)
    {
        if ($request->ajax()) {
            $chart_of_account = new CharOfAccount();
            echo json_encode($chart_of_account->get_chart_details($chart_id));
        }
    }

    public function store_accountchart(Request $request)
    {
        if ($request->ajax()) {

            $validator = Validator::make($request->all(), [
                "account_code" => "required",
                "description" => "required",
                "account_group" => "required",
                "main_grouping" => "required",
                "note_no" => "required",
                "note_description" => "required",
            ]);

            if ($validator->fails()) {
                echo json_encode(["status" => FALSE, "errors" => $validator->errors()]);
            } else {

                $chart_accountObject = new CharOfAccount();

                if (isset($request->id) && !empty($request->id)) {
                    $record_id = $request->only("id");
                    $update_data =  $request->except("_token", "id");

                    $update_status = $chart_accountObject->update_chart_details($update_data, $record_id);

                    if ($update_status) {
                        $message = ValidationMessage::$validation_messages["chart_update_success"];
                        echo json_encode(array("status" => TRUE, "message" => $message));
                    } else {
                        $message = ValidationMessage::$validation_messages["chart_update_failed"];
                        echo json_encode(array("status" => TRUE, "message" => $message));
                    }
                } else {

                    $chart_data = $request->except("_token");
                    $chart_data["created_date"] = $this->datetime;

                    $insert_status = $chart_accountObject->add_account_chart($chart_data);

                    if ($insert_status) {
                        $message = ValidationMessage::$validation_messages["chart_insert_success"];
                        echo json_encode(array("status" => TRUE, "message" => $message));
                    } else {
                        $message = ValidationMessage::$validation_messages["chart_insert_failed"];
                        echo json_encode(array("status" => TRUE, "message" => $message));
                    }
                }
            }
        }
    }
    //Account account Chart Functionality ends here

    //Account Book Keeping Functionality Starts Here

    public function get_all_vouchers(Request $request, $perpage)
    {

        if ($request->ajax()) {
            $voucherObject = new RyapayJournalVoucher();
            $vouchers = $voucherObject->get_all_vouchers();
            $paginate_vouchers = $this->_arrayPaginator($vouchers, $request, "vouchers", $perpage);
            return View::make('employee.pagination')->with(["module" => "voucher", "vouchers" => $paginate_vouchers])->render();
        }
    }

    public function store_voucher(Request $request)
    {

        if ($request->ajax()) {
            $voucherObject = new RyapayJournalVoucher();

            $voucher_data = $request->except('_token');
            $voucher_data["created_user"] = auth()->guard('employee')->user()->id;
            $voucher_data["created_date"] =  $this->datetime;
            $voucher_data["voucher_date"] = date_format(date_create($request->voucher_date), "Y-m-d");

            $voucher_status = $voucherObject->add_voucher($voucher_data);
            if ($voucher_status) {
                $message = ValidationMessage::$validation_messages["voucher_insert_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["voucher_insert_failed"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            }
        }
    }

    public function edit_voucher(Request $request, $id)
    {
        if ($request->ajax()) {
            $voucherObject = new RyapayJournalVoucher();
            $voucher_data = $voucherObject->edit_voucher_info($id);
            echo json_encode($voucher_data);
        }
    }

    public function update_voucher(Request $request)
    {

        if ($request->ajax()) {
            $voucherObject = new RyapayJournalVoucher();
            $voucher_id = $request->only("id");
            $voucher_data = $request->except("_token", "id");
            $update_voucher = $voucherObject->update_voucher_info($voucher_data, $voucher_id);
            if ($update_voucher) {
                $message = ValidationMessage::$validation_messages["voucher_update_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["voucher_update_failed"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            }
        }
    }


    //Account Book Keeping Functionality Ends Here

    //Account Menu code starts here

    public function show_invoice(Request $request)
    {
        return view("employee.account.addeditinvoice")->with(["form" => "new"]);
    }

    public function get_all_invoices(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $invoiceObject = new RyaPayInvoice();
            $invoices = $invoiceObject->get_all_invoices();
            $pagination = $this->_arrayPaginator($invoices, $request, "invoices", $perpage);
            return View::make('employee.pagination')->with(["module" => "invoice", "invoices" => $pagination])->render();
        }
    }

    public function get_all_item_options(Request $request)
    {
        if ($request->ajax()) {
            $itemObject = new RyaPayItem();
            $items = $itemObject->get_all_items();
            echo json_encode($items);
        }
    }

    public function get_all_customer_options(Request $request)
    {
        if ($request->ajax()) {
            $customerObject = new RyaPayCustomer();
            $customers = $customerObject->get_all_customers();
            echo json_encode($customers);
        }
    }

    public function get_customer_details(Request $request, $id)
    {
        $customerObject  = new RyaPayCustomer();
        $customer_addressObject =  new RyaPayCustomerAddress();
        if ($request->ajax()) {
            $customer_details["info"] = $customerObject->get_selected_customer_info($id);
            $customer_details["address"] =  $customer_addressObject->get_customer_address($id);
            echo json_encode($customer_details);
        }
    }

    public function get_all_items(Request $request)
    {
        if ($request->ajax()) {
            $itemObject = new RyaPayItem();
            $items = $itemObject->get_all_items();
            $pagination = $this->_arrayPaginator($items, $request, "items");
            return View::make('employee.pagination')->with(["module" => "item", "items" => $pagination])->render();
        }
    }

    public function store_customer_address(Request $request)
    {
        if ($request->ajax()) {
            $customer_addressObject =  new RyaPayCustomerAddress();

            $customer_data = $request->except("_token");
            $customer_data["status"] = "active";
            $customer_data["address_module"] = "customer";
            $customer_data["created_date"] = $this->datetime;
            $customer_data["created_user"] = auth()->guard('employee')->user()->id;

            $insert_status = $customer_addressObject->add_customer_address($customer_data);

            if ($insert_status) {
                $message = ValidationMessage::$validation_messages["address_insert_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["address_insert_failed"];
                echo json_encode(array("status" => FALSE, "message" => $message));
            }
        }
    }

    public function store_invoice(Request $request)
    {

        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'invoice_receiptno' => 'required',
                'company' => 'required',
                'panno' => 'required',
                "gstno" => 'required',
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


                $invoice = new RyaPayInvoice();

                $invoiceitem = new RyaPayInvoiceItem();

                $item_array = $request->only('item_name', 'item_amount', 'item_quantity', 'item_total');

                $invoice_data = $request->except('outer_state', 'inner_state', 'customer_state', 'state', '_token', 'item_name', 'item_amount', 'item_quantity', 'item_total');

                $invoice_item_array = array();

                $invoice_payid = Str::random(21);

                $invoice_paylink = url('/') . "/inv/smart-pay/" . $invoice_payid;

                $invoice_data["invoice_issue_date"] = date('Y-m-d H:i:s', strtotime($request->invoice_issue_date));
                $invoice_data["invoice_payid"] = $invoice_payid;
                $invoice_data["invoice_paylink"] = $invoice_paylink;
                $invoice_data["invoice_gid"] = "inv_" . Str::random(16);
                $invoice_data["created_date"] = $this->datetime;
                $invoice_data["created_user"] = auth()->guard('employee')->user()->id;

                $invoice_id = $invoice->add_invoice($invoice_data);

                foreach ($item_array["item_name"] as $key => $value) {



                    $invoice_item_array[$key]["invoice_id"] = $invoice_id;
                    $invoice_item_array[$key]["item_id"] = $value;
                    $invoice_item_array[$key]["item_amount"] = $item_array["item_amount"][$key];
                    $invoice_item_array[$key]["item_quantity"] = $item_array["item_quantity"][$key];
                    $invoice_item_array[$key]["item_total"] = $item_array["item_total"][$key];
                    $invoice_item_array[$key]["created_date"] = $this->datetime;
                    $invoice_item_array[$key]["created_user"] = auth()->guard('employee')->user()->id;
                }
                $invoice_item_status = $invoiceitem->add_invoice_item($invoice_item_array);
                if ($invoice_item_status) {
                    $message = ValidationMessage::$validation_messages["invoice_insert_success"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {
                    $message = ValidationMessage::$validation_messages["invoice_insert_failed"];
                    echo json_encode(array("status" => FALSE, "message" => $message));
                }
            }
        }
    }

    public function edit_invoice(Request $request, $id)
    {

        $invoice = new RyaPayInvoice();

        $customer = new RyaPayCustomer();

        $customer_address = new RyaPayCustomerAddress();

        $item = new RyaPayItem();

        $invoice_query_data = $invoice->get_invoice($id);

        $invoice_details = array();
        $items_details = array();
        $customer_details = array();
        $customers = $customer->get_all_customers();

        foreach ($invoice_query_data as $index => $data_array) {

            $arrayelements_count = 0;
            foreach ($data_array as $key => $value) {
                if ($arrayelements_count < 16) {
                    $invoice_details[$key] = $value;
                } else if ($arrayelements_count < 20) {
                    $items_details[$index][$key] = $value;
                } else {
                    $customer_details[$key] = $value;
                }

                $arrayelements_count = $arrayelements_count + 1;
            }
        }

        $customer_addresses = $customer_address->get_customer_address($customer_details["customer_id"]);
        $items = $item->get_all_items();
        return view("employee.account.addeditinvoice")->with(["form" => "edit", "invoice_details" => $invoice_details, "items_details" => $items_details, "customer_details" => $customer_details, "customers" => $customers, "customer_addresses" => $customer_addresses, "items" => $items]);
    }

    public function update_invoice(Request $request)
    {

        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'invoice_receiptno' => 'required',
                'company' => 'required',
                'panno' => 'required',
                "gstno" => 'required',
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

                $invoice = new RyaPayInvoice();

                $invoiceitem = new RyaPayInvoiceItem();

                $invoice_item_array = array();


                $item_array = $request->only('item_name', 'item_amount', 'item_quantity', 'item_total');

                $invoice_id = $request->only('invoice_id');

                $invoice_data = $request->except('outer_state', 'inner_state', 'customer_state', 'state', '_token', 'item_name', 'item_amount', 'item_quantity', 'item_total', 'invoice_id');

                $invoice_status = $invoice->update_invoice($invoice_data, $invoice_id["invoice_id"]);



                foreach ($item_array["item_name"] as $key => $value) {
                    $invoice_item_array[$key]["invoice_id"] = $invoice_id["invoice_id"];
                    $invoice_item_array[$key]["item_id"] = $value;
                    $invoice_item_array[$key]["item_amount"] = $item_array["item_amount"][$key];
                    $invoice_item_array[$key]["item_quantity"] = $item_array["item_quantity"][$key];
                    $invoice_item_array[$key]["item_total"] = $item_array["item_total"][$key];
                    $invoice_item_array[$key]["created_date"] = $this->datetime;
                    $invoice_item_array[$key]["created_user"] = auth()->guard('employee')->user()->id;
                }

                $invoiceitem->delete_invoice_items($invoice_id);

                $invoice_item_status = $invoiceitem->add_invoice_item($invoice_item_array);

                if ($invoice_item_status || $invoice_status) {
                    $message = ValidationMessage::$validation_messages["invoice_update_success"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {
                    $message = ValidationMessage::$validation_messages["invoice_update_failed"];
                    echo json_encode(array("status" => FALSE, "message" => $message));
                }
            }
        }
    }

    public function update_customer_address(Request $request)
    {
        if ($request->ajax()) {
            $customer_addressObject =  new RyaPayCustomerAddress();
            $address_id =  $request->only("id");
            $address_id["address_module"] = "customer";
            $customer_data = $request->except("_token", "id");

            if (!empty($request->id)) {
                $update_status = $customer_addressObject->update_customer_address($customer_data, $address_id);

                if ($update_status) {
                    $message = ValidationMessage::$validation_messages["address_update_success"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {

                    $message = ValidationMessage::$validation_messages["address_update_failed"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                }
            } else {

                $customer_data["status"] = "active";
                $customer_data["created_date"] = $this->datetime;
                $customer_data["created_user"] = auth()->guard('employee')->user()->id;

                $insert_status = $customer_addressObject->add_customer_address($customer_data);

                if ($insert_status) {
                    $message = ValidationMessage::$validation_messages["address_insert_success"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {
                    $message = ValidationMessage::$validation_messages["address_insert_failed"];
                    echo json_encode(array("status" => FALSE, "message" => $message));
                }
            }
        }
    }

    public function get_item_options(Request $request)
    {
        if ($request->ajax()) {
            $itemObject = new RyaPayItem();
            $items = $itemObject->get_dropdown_items();
            echo json_encode($items);
        }
    }


    public function store_item(Request $request)
    {
        if ($request->ajax()) {
            $itemObject = new RyaPayItem();
            $fields = $request->except('_token');
            $itemsdata = array();
            foreach ($fields["item_name"] as $key => $value) {

                $itemsdata[$key]["item_name"] = $fields["item_name"][$key];
                $itemsdata[$key]["item_amount"] = $fields["item_amount"][$key];
                $itemsdata[$key]["item_description"] = $fields["item_description"][$key];
                $itemsdata[$key]["item_gid"] = "itm_" . Str::random(16);
                $itemsdata[$key]["created_date"] = $this->datetime;
                $itemsdata[$key]["created_user"] = auth()->guard('employee')->user()->id;
            }
            $insert_status = $itemObject->add_item($itemsdata);
            if ($insert_status) {
                $message = ValidationMessage::$validation_messages["item_insert_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["item_insert_failed"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            }
        }
    }

    public function edit_item(Request $request, $itemid)
    {

        if ($request->ajax()) {
            $itemObject = new RyaPayItem();
            $item_edit = $itemObject->edit_item($itemid);
            echo json_encode($item_edit);
        }
    }

    public function update_item(Request $request)
    {
        $where_data = array();
        if ($request->ajax()) {
            $this->validate($request, [
                "item_name" => "required",
                "item_amount" => "required|numeric"
            ]);

            $fileds_data = $request->except('_token', 'id');
            $itemObject = new RyaPayItem();
            $update_status = $itemObject->update_item($fileds_data);
            if ($update_status) {
                $message = ValidationMessage::$validation_messages["item_update_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["item_update_failed"];
                echo json_encode(array("status" => FALSE, "message" => $message));
            }
        }
    }

    public function destroy_item(Request $request)
    {

        if ($request->ajax()) {
            $itemObject = new RyaPayItem();
            $fields = $request->except('_token');
            $remove_status = $itemObject->remove_item($fields);
            if ($remove_status) {
                $message = ValidationMessage::$validation_messages["item_deleted_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["item_deleted_failed"];
                echo json_encode(array("status" => FALSE, "message" => $message));
            }
        }
    }

    public function store_customer(Request $request)
    {

        if ($request->ajax()) {
            $customerObject = new RyaPayCustomer();

            $customer_data = $request->except('_token');
            $customer_data["customer_gid"] = 'cust_' . Str::random(16);
            $customer_data["created_user"] = auth()->guard('employee')->user()->id;
            $customer_data["created_date"] =  $this->datetime;

            $customer_status = $customerObject->add_customer($customer_data);
            if ($customer_status) {
                $message = ValidationMessage::$validation_messages["customer_insert_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["customer_insert_failed"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            }
        }
    }

    public function edit_customer(Request $request, $id)
    {
        if ($request->ajax()) {
            $customerObject = new RyaPayCustomer();
            $edit_customer = $customerObject->edit_customer_info($id);
            echo json_encode($edit_customer);
        }
    }

    public function update_customer(Request $request)
    {
        $customerObject = new RyaPayCustomer();
        $customer_id = $request->only("id");
        $customer_data = $request->except("_token", "id");
        $update_customer = $customerObject->update_customer_info($customer_data, $customer_id);
        if ($update_customer) {
            $message = ValidationMessage::$validation_messages["customer_update_success"];
            echo json_encode(array("status" => TRUE, "message" => $message));
        } else {
            $message = ValidationMessage::$validation_messages["customer_update_failed"];
            echo json_encode(array("status" => TRUE, "message" => $message));
        }
    }

    public function destroy_customer(Request $request)
    {
        $customerObject = new RyaPayCustomer();
        $customer_id = $request->only("id");
        $customer_data = $request->except("_token", "id");
        $customer_data["status"] = "inactive";
        $update_customer = $customerObject->update_customer_info($customer_data, $customer_id);
        if ($update_customer) {
            $message = ValidationMessage::$validation_messages["customer_delete_success"];
            echo json_encode(array("status" => TRUE, "message" => $message));
        } else {
            $message = ValidationMessage::$validation_messages["customer_delete_failed"];
            echo json_encode(array("status" => TRUE, "message" => $message));
        }
    }

    public function get_all_customers(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $customerObject = new RyaPayCustomer();
            $customer = $customerObject->get_all_customers();
            $pagination = $this->_arrayPaginator($customer, $request, "customers", $perpage);
            return View::make('employee.pagination')->with(["module" => "customer", "customers" => $pagination])->render();
        }
    }

    public function get_all_suppliers(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $supplierObject = new RyapaySupplier();
            $supplier_info = $supplierObject->get_all_suppliers();
            $supplier_pagination = $this->_arrayPaginator($supplier_info, $request, "suppliers", $perpage);
            return View::make('employee.pagination')->with(["module" => "supplier", "suppliers" => $supplier_pagination])->render();
        }
    }

    public function get_selected_supplier_info(Request $request, $id)
    {

        if ($request->ajax()) {
            $supplierObject = new RyapaySupplier();
            $supplier_info = $supplierObject->get_selected_supplier_info($id);
            echo json_encode($supplier_info);
        }
    }

    public function store_supplier(Request $request)
    {

        if ($request->ajax()) {
            $supplierObject = new RyapaySupplier();

            $supplier_data = $request->except('_token');
            $supplier_data["supplier_gid"] = 'supplier_' . Str::random(8);
            $supplier_data["created_user"] = auth()->guard('employee')->user()->id;
            $supplier_data["created_date"] =  $this->datetime;

            $supplier_status = $supplierObject->add_supplier($supplier_data);
            if ($supplier_status) {
                $message = ValidationMessage::$validation_messages["supplier_insert_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["supplier_insert_failed"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            }
        }
    }

    public function edit_supplier(Request $request, $id)
    {
        if ($request->ajax()) {
            $supplierObject = new RyapaySupplier();
            $edit_supplier = $supplierObject->edit_supplier_info($id);
            echo json_encode($edit_supplier);
        }
    }

    public function update_supplier(Request $request)
    {
        $supplierObject = new RyapaySupplier();
        $supplier_id = $request->only("id");
        $supplier_data = $request->except("_token", "id");
        print_r($supplier_id);
        exit;
        $update_supplier = $supplierObject->update_supplier_info($supplier_data, $supplier_id);
        if ($update_supplier) {
            $message = ValidationMessage::$validation_messages["supplier_update_success"];
            echo json_encode(array("status" => TRUE, "message" => $message));
        } else {
            $message = ValidationMessage::$validation_messages["supplier_update_failed"];
            echo json_encode(array("status" => TRUE, "message" => $message));
        }
    }

    public function destroy_supplier(Request $request)
    {
        $supplierObject = new RyapaySupplier();
        $supplier_id = $request->only("id");
        $supplier_data = $request->except("_token", "id");
        $supplier_data["status"] = "inactive";
        $update_supplier = $supplierObject->update_supplier_info($supplier_data, $supplier_id);
        if ($update_supplier) {
            $message = ValidationMessage::$validation_messages["supplier_delete_success"];
            echo json_encode(array("status" => TRUE, "message" => $message));
        } else {
            $message = ValidationMessage::$validation_messages["supplier_delete_failed"];
            echo json_encode(array("status" => TRUE, "message" => $message));
        }
    }

    //Account Menu code starts here

    public function finance(Request $request, $id = "")
    {
        if (array_key_exists($id, session('sublinkNames'))) {
            $navigation = new Navigation();
            if (!empty($id)) {
                $sublinks = $navigation->get_sub_links($id);
            }
            $sublink_name = session('sublinkNames')[$id];
            switch ($id) {
                case 'ryapay-fRg1gbzX':

                    return view("employee.finance.fpaymanage")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
                    break;
                case 'ryapay-yKzVIkqM':

                    return view("employee.finance.freceimanage")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
                    break;
            }
        } else {
            return redirect()->back();
        }
    }

    //Finance >> Payable Management >> Supplier Pay Batch Entry

    public function get_invoice_no(Request $request, $id)
    {
        if ($request->ajax()) {
            $variable = $id;
            switch ($variable) {
                case '1':
                    $options = RyapayaSupOrderInv::suporder_invoice_options();
                    break;
                case '2':
                    $options = RyapaySupExpInv::supexp_options();
                    break;
                case '3':
                    $options = RyapaySupCDNote::supplier_note_options();
                    break;
            }
            echo json_encode($options);
        }
    }
    public function get_supp_paybatch(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $supp_pay_Object = new RyapaySupPayEntry();
            $supp_pay_info = $supp_pay_Object->get_sup_entries();
            $suppaybatch_pagination = $this->_arrayPaginator($supp_pay_info, $request, "suppaybatches", $perpage);
            return View::make('employee.pagination')->with(["module" => "suppaybatch", "suppaybatches" => $suppaybatch_pagination])->render();
        }
    }

    public function show_supp_paybatch(Request $request)
    {
        return view("employee.finance.addeditsuppbatch")->with(["form" => "create", "payable_options" => $this->payable_manage]);
    }

    public function store_supp_paybatch(Request $request)
    {
        if ($request->ajax()) {
            $supp_data = $request->except('_token');
            $supp_data["created_date"] = $this->datetime;
            $supp_data["created_user"] = auth()->guard('employee')->user()->id;
            $supp_pay_Object = new RyapaySupPayEntry();
            $insert_status = $supp_pay_Object->add_sup_payentry($supp_data);
            if ($insert_status) {
                $message = ValidationMessage::$validation_messages["suppayentry_insert_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["suppayentry_insert_failed"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            }
        }
    }

    public function edit_supp_paybatch(Request $request, $id)
    {
        $supp_pay_Object = new RyapaySupPayEntry();
        $supp_pay_info = $supp_pay_Object->get_sup_entry($id);
        if (!empty($supp_pay_info)) {
            $info = $supp_pay_info[0];

            switch ($info->batch_invtype) {
                case '1':
                    $options = RyapayaSupOrderInv::suporder_invoice_options();
                    break;
                case '2':
                    $options = RyapaySupExpInv::supexp_options();
                    break;
                case '3':
                    $options = RyapaySupCDNote::supplier_note_options();
                    break;
            }

            return view("employee.finance.addeditsuppbatch")->with(["form" => "edit", "edit_data" => $info, "payable_options" => $this->payable_manage, "options" => $options]);
        }
    }

    public function update_supp_paybatch(Request $request)
    {
        if ($request->ajax()) {
            $supp_id = $request->only('id');
            $supp_data = $request->except('_token', 'id');
            $supp_pay_Object = new RyapaySupPayEntry();
            $update_status = $supp_pay_Object->update_sup_payentry($supp_id, $supp_data);
            if ($update_status) {
                $message = ValidationMessage::$validation_messages["suppayentry_update_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["suppayentry_update_failed"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            }
        }
    }

    //Finance >> Payable Management >> Sundry Payment Entry 

    public function get_sundry_payment(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $sund_pay_Object = new RyapaySundPayEntry();
            $sund_pay_info = $sund_pay_Object->get_sund_payentries();
            $sundpaybatch_pagination = $this->_arrayPaginator($sund_pay_info, $request, "sundpaybatches", $perpage);
            return View::make('employee.pagination')->with(["module" => "sundpaybatch", "sundpaybatches" => $sundpaybatch_pagination])->render();
        }
    }

    public function show_sundry_payment(Request $request)
    {
        return view("employee.finance.addeditsundpay")->with("form", "create");
    }

    public function store_sundry_payment(Request $request)
    {
        if ($request->ajax()) {
            $sund_data = $request->except('_token');
            $sund_data["created_date"] = $this->datetime;
            $sund_data["created_user"] = auth()->guard('employee')->user()->id;
            $sund_pay_Object = new RyapaySundPayEntry();
            $insert_status = $sund_pay_Object->add_sund_payentry($sund_data);
            if ($insert_status) {
                $message = ValidationMessage::$validation_messages["sundpayentry_insert_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["sundpayentry_insert_failed"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            }
        }
    }

    public function edit_sundry_payment(Request $request, $id)
    {
        $sund_pay_Object = new RyapaySundPayEntry();
        $sund_pay_info = $sund_pay_Object->get_sund_payentry($id);
        if (!empty($sund_pay_info)) {
            $info = $sund_pay_info[0];
            return view("employee.finance.addeditsundpay")->with(["form" => "edit", "edit_data" => $info]);
        }
    }

    public function update_sundry_payment(Request $request)
    {
        if ($request->ajax()) {
            $sund_data_id = $request->only('id');
            $sund_data = $request->except('_token', 'id');
            $sund_pay_Object = new RyapaySundPayEntry();
            $update_status = $sund_pay_Object->update_sund_payentry($sund_data_id, $sund_data);
            if ($update_status) {
                $message = ValidationMessage::$validation_messages["sundpayentry_update_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["sundpayentry_update_failed"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            }
        }
    }

    //Finance >> Payable Management >> Contra Entry 
    public function get_contra_entry(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $contraObject = new RyapayContEntry();
            $contra_info = $contraObject->get_contras_info();
            $contra_pagination = $this->_arrayPaginator($contra_info, $request, "contras", $perpage);
            return View::make('employee.pagination')->with(["module" => "contra", "contras" => $contra_pagination])->render();
        }
    }

    public function show_contra_entry(Request $request)
    {
        return view("employee.finance.addeditconpay")->with("form", "create");
    }

    public function store_contra_entry(Request $request)
    {
        if ($request->ajax()) {
            $contradata = $request->except('_token');
            $contradata["created_date"] = $this->datetime;
            $contradata["created_user"] = auth()->guard('employee')->user()->id;
            $contraObject = new RyapayContEntry();
            $insert_status = $contraObject->add_contra_entry($contradata);
            if ($insert_status) {
                $message = ValidationMessage::$validation_messages["contra_insert_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["contra_insert_failed"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            }
        }
    }

    public function edit_contra_entry(Request $request, $id)
    {
        $contraObject = new RyapayContEntry();
        $contra_info = $contraObject->get_contra_info($id);
        if (!empty($contra_info)) {
            $info = $contra_info[0];
            return view("employee.finance.addeditconpay")->with(["form" => "edit", "edit_data" => $info]);
        }
    }

    public function update_contra_entry(Request $request)
    {
        if ($request->ajax()) {
            $contra_id = $request->only('id');
            $contradata = $request->except('_token', 'id');
            $contraObject = new RyapayContEntry();
            $update_status = $contraObject->update_contra_info($contra_id, $contradata);
            if ($update_status) {
                $message = ValidationMessage::$validation_messages["contra_update_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["contra_update_failed"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            }
        }
    }

    //Finance >> Receivable Management >> Customer Direct Receipt Entry 

    public function get_saleinvoice_no(Request $request, $id)
    {
        if ($request->ajax()) {
            $variable = $id;
            switch ($variable) {
                case '1':
                    $options = RyapayCustOrderInv::custorder_options();
                    break;
                case '2':
                    $options = RyapayaCustCDNote::custnote_options();
                    break;
            }
            echo json_encode($options);
        }
    }

    public function get_cust_dreceipt_entry(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $custrcpt_object = new RyapayCustRcptEntry();
            $custrcpt_info = $custrcpt_object->get_custrcpt_entries();
            $custrcpt_pagination = $this->_arrayPaginator($custrcpt_info, $request, "custrcptentries", $perpage);
            return View::make('employee.pagination')->with(["module" => "custrcptentry", "custrcptentries" => $custrcpt_pagination])->render();
        }
    }

    public function show_cust_dreceipt_entry(Request $request)
    {
        return view("employee.finance.addeditcustreceiptentry")->with(["form" => "create", "receivable_options" => $this->receivable_manage]);
    }

    public function store_cust_dreceipt_entry(Request $request)
    {
        if ($request->ajax()) {
            $custrcptdata = $request->except('_token');
            $custrcptdata["created_date"] = $this->datetime;
            $custrcptdata["created_user"] = auth()->guard('employee')->user()->id;
            $custrcpt_object = new RyapayCustRcptEntry();
            $insert_status = $custrcpt_object->add_custrcpt_entry($custrcptdata);
            if ($insert_status) {
                $message = ValidationMessage::$validation_messages["custrcpt_insert_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["custrcpt_insert_failed"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            }
        }
    }

    public function edit_cust_dreceipt_entry(Request $request, $id)
    {
        $custrcpt_object = new RyapayCustRcptEntry();
        $custrcpt_info = $custrcpt_object->get_custrcpt_entry($id);
        if (!empty($custrcpt_info)) {
            $info = $custrcpt_info[0];

            switch ($info->receipt_invtype) {
                case '1':
                    $options = RyapayCustOrderInv::custorder_options();
                    break;
                case '2':
                    $options = RyapayaCustCDNote::custnote_options();
                    break;
            }
            return view("employee.finance.addeditcustreceiptentry")->with(["form" => "edit", "edit_data" => $info, "receivable_options" => $this->receivable_manage, "options" => $options]);
        }
    }

    public function update_cust_dreceipt_entry(Request $request)
    {
        if ($request->ajax()) {
            $custrcpt_id = $request->only('id');
            $custrcptdata = $request->except('_token', 'id');
            $custrcpt_object = new RyapayCustRcptEntry();
            $update_status = $custrcpt_object->update_custrcpt_entry($custrcpt_id, $custrcptdata);
            if ($update_status) {
                $message = ValidationMessage::$validation_messages["custrcpt_update_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["custrcpt_update_failed"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            }
        }
    }

    //Finance >> Receivable Management >> Sundry Receipt Entry  

    public function get_sundry_receipt(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $sundrcpt_object = new RyapaySundRcptEntry();
            $sundrcpt_info = $sundrcpt_object->get_sund_rcpt_entries();
            $sundrcpt_pagination = $this->_arrayPaginator($sundrcpt_info, $request, "sundrcptentries", $perpage);
            return View::make('employee.pagination')->with(["module" => "sundrcptentry", "sundrcptentries" => $sundrcpt_pagination])->render();
        }
    }

    public function show_sundry_receipt(Request $request)
    {
        return view("employee.finance.addeditsundreceiptentry")->with("form", "create");
    }

    public function store_sundry_receipt(Request $request)
    {
        if ($request->ajax()) {
            $sundrcptdata = $request->except('_token');
            $sundrcptdata["created_date"] = $this->datetime;
            $sundrcptdata["created_user"] = auth()->guard('employee')->user()->id;
            $sundrcpt_object = new RyapaySundRcptEntry();
            $insert_status = $sundrcpt_object->add_sundrcpt_entry($sundrcptdata);
            if ($insert_status) {
                $message = ValidationMessage::$validation_messages["sundrcpt_insert_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["sundrcpt_insert_failed"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            }
        }
    }

    public function edit_sundry_receipt(Request $request, $id)
    {

        $sundrcpt_object = new RyapaySundRcptEntry();
        $sund_receipt_info = $sundrcpt_object->get_sund_rcpt_entry($id);
        if (!empty($sund_receipt_info)) {
            $info = $sund_receipt_info[0];
            return view("employee.finance.addeditsundreceiptentry")->with(["form" => "edit", "edit_data" => $info]);
        }
    }

    public function update_sundry_receipt(Request $request)
    {
        if ($request->ajax()) {
            $sundrcpt_id = $request->only('id');
            $sundrcptdata = $request->except('_token');
            $sundrcpt_object = new RyapaySundRcptEntry();
            $update_status = $sundrcpt_object->update_sundrcpt_entry($sundrcpt_id, $sundrcptdata);
            if ($update_status) {
                $message = ValidationMessage::$validation_messages["custrcpt_update_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["custrcpt_update_failed"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            }
        }
    }

    //Finance >> Payable Management >> Bank

    public function get_banks_info(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $bankObject = new RyapayBankInfo();
            $bank_info = $bankObject->get_banks_info();
            $bank_pagination = $this->_arrayPaginator($bank_info, $request, "banks", $perpage);
            return View::make('employee.pagination')->with(["module" => "bank", "banks" => $bank_pagination])->render();
        }
    }

    public function store_bank_info(Request $request)
    {
        if ($request->ajax()) {
            $bankObject = new RyapayBankInfo();
            $bank_info = $request->except('_token');
            $bank_info["created_date"] = $this->datetime;
            $bank_info["created_user"] = auth()->guard('employee')->user()->id;
            $insert_status = $bankObject->add_bank_info($bank_info);
            if ($insert_status) {
                $message = ValidationMessage::$validation_messages["bank_insert_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["bank_insert_failed"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            }
        }
    }

    public function edit_bank_info(Request $request, $id)
    {
        if ($request->ajax()) {
            $bankObject = new RyapayBankInfo();
            $bank_info = $bankObject->get_bank_info($id);
            echo json_encode($bank_info);
        }
    }

    public function update_bank_info(Request $request)
    {
        if ($request->ajax()) {
            $bankObject = new RyapayBankInfo();
            $sno = $request->only('id');
            $bank_info = $request->except('_token', 'id');
            $update_status = $bankObject->update_bank_info($sno, $bank_info);
            if ($update_status) {
                $message = ValidationMessage::$validation_messages["bank_update_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["bank_update_failed"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            }
        }
    }

    public function adjustment(Request $request, $id = "")
    {
       
        // dd('asdfad');
        if (array_key_exists($id, session('sublinkNames'))) {
            $navigation = new Navigation();
            if (!empty($id)) {

                $sublinks = $navigation->get_sub_links($id);

            }
            $sublink_name = session('sublinkNames')[$id];

            switch ($id) {

                case 'ryapay-YBxqOZ30':
                    return view("employee.settlement.transaction")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
                    break;
                case 'ryapay-DlcU03aC':

                    return view("employee.settlement.cdr")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
                    break;
            }
        } else {
            return redirect()->back();
        }
    }

    public function get_cdr_info(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $cdrObject = new RyapayCDR();
            $cdr_info = $cdrObject->get_cdr_transactions();
            $cdr_pagination = $this->_arrayPaginator($cdr_info, $request, "cdrtransactions", $perpage);
            return View::make('employee.pagination')->with(["module" => "cdrtransaction", "cdrtransactions" => $cdr_pagination])->render();
        }
    }

    public function show_cdr_info(Request $request)
    {
        return view("employee.settlement.addeditcdr")->with("form", "create");
    }

    public function store_cdr_info(Request $request)
    {
        if ($request->ajax()) {
            $cdr_info = $request->except('_token');
            $cdr_info["created_date"] = $this->datetime;
            $cdr_info["created_user"] = auth()->guard('employee')->user()->id;
            $cdrObject = new RyapayCDR();
            $insert_status = $cdrObject->add_cdr_transaction($cdr_info);
            if ($insert_status) {
                $message = ValidationMessage::$validation_messages["cdr_insert_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["cdr_insert_failed"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            }
        }
    }

    public function edit_cdr_info(Request $request, $id)
    {
        $cdrObject = new RyapayCDR();
        $cdr_info = $cdrObject->get_cdr_transaction($id);
        if (!empty($cdr_info)) {
            $info = $cdr_info[0];
            return view("employee.settlement.addeditcdr")->with(["form" => "edit", "edit_data" => $info]);
        }
    }

    public function update_cdr_info(Request $request)
    {
        if ($request->ajax()) {
            $cdr_id = $request->only('id');
            $cdr_info = $request->except('_token', 'id');
            $cdrObject = new RyapayCDR();
            $update_status = $cdrObject->update_cdr_transaction($cdr_id, $cdr_info);
            if ($update_status) {
                $message = ValidationMessage::$validation_messages["cdr_update_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["cdr_update_failed"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            }
        }
    }

    public function generate_adjustment(Request $request)
    {
        if ($request->ajax()) {

            $row_id = "";
            $card_details = [];
            $adjustment_details = $request->only("transaction_mode", "basic_amount", "charges_per", "charges_on_basic", "gst_per", "gst_on_charges", "total_amt_charged");

            $adjustment_tran = $request->except("_token", "transaction_mode", "basic_amount", "charges_per", "charges_on_basic", "gst_per", "gst_on_charges", "total_amt_charged");

            $adjustment_tran["created_date"] = $this->datetime;
            $adjustment_tran["created_user"] = auth()->guard('employee')->user()->id;

            $adjustment_trans = new ryapayAdjustmentTrans();

            $adjustment_detail = new ryapayAdjustmentDetail();

            $row_id = $adjustment_trans->add_adjustment_transaction($adjustment_tran);

            if (!empty($row_id)) {
                for ($i = 0; $i < 5; $i++) {
                    $card_details[$i]["adjustment_trans_id"] = $row_id;
                    $card_details[$i]["transaction_mode"] = $adjustment_details["transaction_mode"][$i];
                    $card_details[$i]["basic_amount"] = $adjustment_details["basic_amount"][$i];
                    $card_details[$i]["charges_per"] = $adjustment_details["charges_per"][$i];
                    $card_details[$i]["charges_on_basic"] = $adjustment_details["charges_on_basic"][$i];
                    $card_details[$i]["gst_per"] = $adjustment_details["gst_per"][$i];
                    $card_details[$i]["gst_on_charges"] = $adjustment_details["gst_on_charges"][$i];
                    $card_details[$i]["total_amt_charged"] = $adjustment_details["total_amt_charged"][$i];
                }
            }

            $insert_status = $adjustment_detail->add_adjustment_detail($card_details);

            if ($insert_status) {
                $message = ValidationMessage::$validation_messages["adjusttrans_insert_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["adjusttrans_delete_failed"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            }
        }
    }

    public function store_adjustment_view(Request $request)
    {

        return view("employee.settlement.addeditsettlement");
    }

    public function store_adjustment(Request $request)
    {

        if ($request->ajax()) {
            $settlement_data = $request->except('_token');
            $ryapay_adjustment = new RyapayAdjustment();
            $settlement_data["created_date"] = $this->datetime;
            $settlement_data["adjustment_status"] = "save";
            $settlement_data["created_user"] = Auth::guard("employee")->user()->id;

            $insert_status = $ryapay_adjustment->add_adjustment($settlement_data);

            if ($insert_status) {
                $transaction =  new Payment();
                $transaction->update_transaction_adjustment($request->merchant_traxn_id);
                $message = ValidationMessage::$validation_messages["settlement_save_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["settlement_save_failed"];
                echo json_encode(array("status" => FALSE, "message" => $message));
            }
        }
    }

    public function proceed_adjustment(Request $request)
    {

        if ($request->ajax()) {

            $adjustment = new RyapayAdjustment();

            $mer_adjustment = new Settlement();
            $settlement_data = $request->except('_token');

            $adjustments = $adjustment->get_adjustment_row($request->id);

            $merchant_adjustment = [];
            if (!empty($adjustments)) {
                foreach ($adjustments as $key => $row) {
                    $merchant_adjustment[$key] = [
                        "settlement_gid" => Str::random(16),
                        "current_balance" => MerchantController::transaction_amount($request->merchant_id),
                        "settlement_amount" => $row->adjustment_amount,
                        "settlement_fee" => $row->total_charge,
                        "settlement_tax" => "0.00",
                        "created_date" => $this->datetime,
                        "created_merchant" => $row->merchant_id,
                    ];
                }
                $insert_status = $mer_adjustment->add_live_merchant($merchant_adjustment);

                if ($insert_status) {
                    $message = ValidationMessage::$validation_messages["settlement_process_success"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {
                    $message = ValidationMessage::$validation_messages["settlement_process_failed"];
                    echo json_encode(array("status" => FALSE, "message" => $message));
                }
            } else {
                $message = ValidationMessage::$validation_messages["settlement_process_done"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            }
        }
    }

    public function get_adjustment_detail(Request $request)
    {
        if ($request->ajax()) {
            $ryapay_adjustment = new RyapayAdjustment();
            $ryapay_adjustments = $ryapay_adjustment->get_adjustment();
            $ryapay_adjustment = $this->_arrayPaginator($ryapay_adjustments, $request, "ryapay_adjustment");
            return View::make("employee.pagination")->with(["module" => "ryapay_adjustment", "ryapay_adjustments" => $ryapay_adjustment])->render();
        }
    }

    public function technical(Request $request, $id = "")
    {


        if (array_key_exists($id, session('sublinkNames'))) {
            $navigation = new Navigation();
            if (!empty($id)) {
                $sublinks = $navigation->get_sub_links($id);
            }

            $sublink_name = session('sublinkNames')[$id];

            switch ($id) {

                case 'ryapay-9hAosQ4C':

                    $grezpay = DB::table('grezpay_mid_keys')->join('merchant', 'grezpay_mid_keys.merchant_id', 'merchant.id')->select('*', 'grezpay_mid_keys.created_date as date', 'grezpay_mid_keys.id as key_id')->get();
                    $worldline = DB::table('worldline_mid_keys')->join('merchant', 'worldline_mid_keys.merchant_id', 'merchant.id')->select('*', 'worldline_mid_keys.created_date as date', 'worldline_mid_keys.id as key_id')->get();
                    $payu = DB::table('payu_mid_keys')->join('merchant', 'payu_mid_keys.merchant_id', 'merchant.id')->select('*', 'payu_mid_keys.created_date as date', 'payu_mid_keys.id as key_id')->get();
                    $razorpay = DB::table('mid_keys_razorpay')->join('merchant', 'mid_keys_razorpay.merchant_id', 'merchant.id')->select('*', 'mid_keys_razorpay.created_date as date', 'mid_keys_razorpay.id as key_id')->get();
                    $paytm = DB::table('mid_keys_paytm')->join('merchant', 'mid_keys_paytm.merchant_id', 'merchant.id')->select('*', 'mid_keys_paytm.created_date as date', 'mid_keys_paytm.id as key_id')->get();
                    $atom = DB::table('mid_keys_atom')->join('merchant', 'mid_keys_atom.merchant_id', 'merchant.id')->select('*', 'mid_keys_atom.created_date as date', 'mid_keys_atom.id as key_id')->get();
                    $cashfree = DB::table('cf_rpay_keys')->join('merchant', 'cf_rpay_keys.merchant_id', 'merchant.id')->select('*', 'cf_rpay_keys.created_date as date', 'cf_rpay_keys.id as key_id')->get();



                    return view("employee.technical.merchantcharge", compact('grezpay', 'cashfree', 'worldline', 'payu', 'razorpay', 'paytm', 'atom'))->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
                    break;

                case 'ryapay-UJMw4ZWp':

                    return view("employee.technical.livemerchant")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
                    break;

                default:
                    return view("employee.sublink")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
            }
        } else {

            return redirect()->back();
        }
    }

    public function transactions(Request $request)
    {
        return view('employee.technical.transactions');
    }

    public function gettransactions(Request $request)
    {
        $search = $request->search;
        $startdate = $request->startdate;
        $enddate = $request->enddate;


        $transactions = Payment::join('live_order', 'live_order.id', 'live_payment.order_id')->whereDate('live_payment.created_date', '>=', $request->startdate)->whereDate('live_payment.created_date', '<=', $request->enddate)
            ->where(function ($query) use ($search) {
                $query->where('transaction_gid', 'LIKE', '%' . $search . '%')->orWhere('order_id', 'LIKE', '%' . $search . '%')->orWhere('transaction_username', 'LIKE', '%' . $search . '%')->orWhere('transaction_email', 'LIKE', '%' . $search . '%')->orWhere('transaction_contact', 'LIKE', '%' . $search . '%');
            })->select('live_payment.transaction_gid', 'live_payment.transaction_username', 'live_payment.transaction_email', 'live_payment.transaction_contact', 'live_payment.transaction_amount', 'live_payment.transaction_status', 'live_payment.created_date', 'live_payment.transaction_mode', 'live_payment.created_merchant', 'live_order.order_gid')
            ->get();

        return $transactions;
    }


    public function findvendortransactionstatus(Request $request)
    {

        $transactionId = $request->transactionid;
        $transactionMode = $request->transactionmode;
        $merchantId = $request->merchantid;

        $MerchantModeBank = MerchantVendorBank::where('merchant_id', $request->merchantid)->first();


        if ($transactionMode == 'UPI') {
            $vendorBank = DB::table('vendor_bank')->where('id', $MerchantModeBank->upi)->first();
        } else  if ($transactionMode == 'CC') {
            $vendorBank = DB::table('vendor_bank')->where('id', $MerchantModeBank->cc_card)->first();
        } else  if ($transactionMode == 'QRCODE') {
            $vendorBank = DB::table('vendor_bank')->where('id', $MerchantModeBank->qrcode)->first();
        } else  if ($transactionMode == 'MW') {
            $vendorBank = DB::table('vendor_bank')->where('id', $MerchantModeBank->wallet)->first();
        } else  if ($transactionMode == 'NB') {
            $vendorBank = DB::table('vendor_bank')->where('id', $MerchantModeBank->net)->first();
        } else  if ($transactionMode == 'DC') {
            $vendorBank = DB::table('vendor_bank')->where('id', $MerchantModeBank->dc_card)->first();
        }

        $transactioninfo = new \stdClass();

        if ($vendorBank->bank_name == 'CashFree') {
            $vendorTransactionStatus = DB::table('cashfree_response')->where('orderId', $transactionId)->first();


            if ($vendorTransactionStatus == null) {
                $found = false;
            } else {
                $transactioninfo->order_id = $vendorTransactionStatus->orderId;
                $transactioninfo->amount = $vendorTransactionStatus->orderAmount;
                $transactioninfo->status = $vendorTransactionStatus->txStatus;
                $transactioninfo->msg = $vendorTransactionStatus->txMsg;
                $transactioninfo->date = $vendorTransactionStatus->txTime;
                $found = true;
            }
        } else if ($vendorBank->bank_name == 'Grezpay') {
            $vendorTransactionStatus = DB::table('grezpay_response')->where('order_id', $transactionId)->first();

            if ($vendorTransactionStatus == null) {
                $found = false;
            } else {
                $transactioninfo->order_id = $vendorTransactionStatus->order_id;
                $transactioninfo->amount = $vendorTransactionStatus->amount;
                $transactioninfo->status = $vendorTransactionStatus->status;
                $transactioninfo->msg = $vendorTransactionStatus->response_message;
                $transactioninfo->date = $vendorTransactionStatus->created_date;
                $found = true;
            }
        } else if ($vendorBank->bank_name == 'Worldline') {
            $vendorTransactionStatus = DB::table('worldline_response')->where('order_id', $transactionId)->first();

            if ($vendorTransactionStatus == null) {
                $found = false;
            } else {
                $transactioninfo->order_id = $vendorTransactionStatus->order_id ?? null;
                $transactioninfo->amount = $vendorTransactionStatus->txn_amount;
                $transactioninfo->status = $vendorTransactionStatus->txn_status;
                $transactioninfo->msg = $vendorTransactionStatus->txn_message;
                $transactioninfo->date = $vendorTransactionStatus->created_date;
                $found = true;
            }
        }



        return Response()->json([
            'Found' => $found,
            'data' => $transactioninfo,

        ], 201);
    }

    public function merchantServices(Request $request)
    {
        $storedIds = DB::table('merchant_services')->pluck('merchant_id')->toArray();

        $merchants = User::whereNotIn('id', $storedIds)->get();
        $storedPermissions = DB::table('merchant_services')->join('merchant', 'merchant.id', 'merchant_services.merchant_id')->get();
        return view('employee.technical.merchanttransactionpermission', compact('merchants', 'storedPermissions'));
    }

    public function addMerchantServices(Request $request)
    {
        $insert = DB::table('merchant_services')->insert([
            'merchant_id' => $request->merchant,
            'payout' => $request->payout,
            'payin' => $request->payin,
            'pennydrop' => $request->pennydrop,
            'created_user' => Auth::guard("employee")->user()->id
        ]);

        return redirect()->back();
    }

    public function editMerchantServices(Request $request)
    {

        $insert = DB::table('merchant_services')->where('merchant_id', $request->merchant)->update([
            'payout' => $request->payout,
            'payin' => $request->payin,
            'pennydrop' => $request->pennydrop,
            'created_user' => Auth::guard("employee")->user()->id
        ]);

        return redirect()->back();
    }

    public function updateTransactionStatus(Request $request)
    {

        $clientid = "246259bf176c14135ec31a6eab952642";
        $clientsecret = "f1e8fd2bcd66524a0cdf39d3bbebcbad8cded4bb";

        $getdata = http_build_query(
            array(
                'appId' =>  "246259bf176c14135ec31a6eab952642",
                'secretKey' => "f1e8fd2bcd66524a0cdf39d3bbebcbad8cded4bb",
                'orderId' =>  $request->orderId,

            )
        );

        $opts = array(
            'http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $getdata
            )
        );


        $context  = stream_context_create($opts);
        $result_json = file_get_contents("https://api.cashfree.com/api/v1/order/info/status?.$getdata", false, $context);
        $result =  json_decode($result_json, true);

        $updateStatus = DB::table('live_payment')->where('transaction_gid', $request->orderId)->update([
            'transaction_status' => $result["txStatus"]
        ]);

        return $result;
    }

    public function transactionInfo(Request $request)
    {
        $info =    $pricing = new \stdClass();

        $info->transaction_info = Payment::where('transaction_gid', $request->transactionID)->first();

        $info->merchant_info = User::where('id', $info->transaction_info->created_merchant)->first();

        // $info->response_info = DB::table('cashfree_response')->where('id',$info->transaction_info->created_merchant)->first();

        return response()->json(['status' => 'Success', 'data' => $info], 200);
    }

    public function get_merchant_charges(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $mcdetailsObject = new MerchantChargeDetail();
            $merchantcharge =  $mcdetailsObject->get_charges();
            $merchantcharges = $this->_arrayPaginator($merchantcharge, $request, "merchantcharge", $perpage);
            return View::make("employee.pagination")->with(["module" => "merchantcharge", "merchantcharges" => $merchantcharges])->render();
        }
    }

    public function show_merchant_charges(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $mcdetailsObject = new MerchantChargeDetail();
            $merchantcharge =  $mcdetailsObject->get_charges();
            $merchantcharges = $this->_arrayPaginator($merchantcharge, $request, "merchantcommercial", $perpage);
            return View::make("employee.pagination")->with(["module" => "merchantcommercial", "merchantcommercials" => $merchantcharges])->render();
        }
    }

    public function addupdate_merchant_charge(Request $request)
    {
        if ($request->ajax()) {
            $charge_details = $request->except("_token", "charge_enabled");

            $rules = [
                "dc_visa" => "required|numeric",
                "dc_master" => "required|numeric",
                "dc_rupay" => "required|numeric",
                "cc_visa" => "required|numeric",
                "cc_master" => "required|numeric",
                "cc_rupay" => "required|numeric",
                "amex" => "required|numeric",
                "upi" => "required|numeric",
                "net_sbi" => "required|numeric",
                "net_hdfc" => "required|numeric",
                "net_axis" => "required|numeric",
                "net_icici" => "required|numeric",
                "net_yes_kotak" => "required|numeric",
                "net_others" => "required|numeric",
            ];


            if (empty($charge_details["id"])) {
                $rules["merchant_id"] = "sometimes|required|unique:merchant_charge_detail";
            }

            $messages = [
                "merchant_id.unique" => "A record is already existing with this details",
                "dc_visa.numeric" => "This field accepts only numeric value",
                "dc_master.numeric" => "This field accepts only numeric value",
                "dc_rupay.numeric" => "This field accepts only numeric value",
                "cc_visa.numeric" => "This field accepts only numeric value",
                "cc_master.numeric" => "This field accepts only numeric value",
                "cc_rupay.numeric" => "This field accepts only numeric value",
                "amex.numeric" => "This field accepts only numeric value",
                "upi.numeric" => "This field accepts only numeric value",
                "net_sbi.numeric" => "This field accepts only numeric value",
                "net_hdfc.numeric" => "This field accepts only numeric value",
                "net_axis.numeric" => "This field accepts only numeric value",
                "net_icici.numeric" => "This field accepts only numeric value",
                "net_yes_kotak.numeric" => "This field accepts only numeric value",
                "net_others.numeric" => "This field accepts only numeric value",
            ];

            $validate = Validator::make($request->all(), $rules, $messages);

            if ($validate->fails()) {
                echo json_encode(["status" => FALSE, "errors" => $validate->errors()]);
            } else {
                $id["id"] = $request->merchant_id;

                if (empty($charge_details["id"])) {
                    $mcdetailsObject = new MerchantChargeDetail();
                    $charge_details["created_date"] = $this->datetime;
                    $charge_details["created_user"] = Auth::guard("employee")->user()->id;
                    $insert_status =  $mcdetailsObject->add_charge($charge_details);

                    $userObject = new User();
                    $id["id"] = $request->merchant_id;
                    $field["charge_enabled"] = $request->charge_enabled;
                    $update_user = $userObject->update_user_field($id, $field);

                    if ($insert_status) {
                        $message = ValidationMessage::$validation_messages["merchant_charge_success"];
                        echo json_encode(array("status" => TRUE, "message" => $message));
                    } else {
                        $message = ValidationMessage::$validation_messages["merchant_charge_failed"];
                        echo json_encode(array("status" => FALSE, "message" => $message));
                    }
                } else {

                    $id["id"] = $request->merchant_id;
                    $charge_id = $request->only("id");
                    $charge_enable = $request->only("charge_enabled");
                    $charge_details = $request->except("id", "_token", "charge_enabled", "merchant_id");
                    $mcdetailsObject = new MerchantChargeDetail();
                    $update_status =  $mcdetailsObject->update_charges($charge_id, $charge_details);

                    $userObject = new User();
                    $field["charge_enabled"] = $request->charge_enabled;
                    $update_user = $userObject->update_user_field($id, $field);

                    if ($update_status || $update_user) {
                        $message = ValidationMessage::$validation_messages["merchant_charge_update_success"];
                        echo json_encode(array("status" => TRUE, "message" => $message));
                    } else {
                        $message = ValidationMessage::$validation_messages["merchant_charge_update_failed"];
                        echo json_encode(array("status" => FALSE, "message" => $message));
                    }
                }
            }
        }
    }

    public function get_merchant_bussinesstype(Request $request, $id)
    {
        if ($request->ajax()) {
            $business_type_object = new BusinessType();
            $business_name = $business_type_object->business_typename($id);
            echo json_encode($business_name);
        }
    }


    public function get_merchant_charge(Request $request, $id)
    {
        if ($request->ajax()) {
            $mcdetailsObject = new MerchantChargeDetail();
            $merchantcharge =  $mcdetailsObject->get_merchant_charge($id);
            echo json_encode($merchantcharge);
        }
    }

    public function get_adjustment_charges(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $macdetailsObject = new RyapayAdjustmentCharge();
            $adjustmentcharge =  $macdetailsObject->get_adjustment_charges();
            $adjustmentcharges = $this->_arrayPaginator($adjustmentcharge, $request, "adjustmentcharge", $perpage);
            return View::make("employee.pagination")->with(["module" => "adjustmentcharge", "adjustmentcharges" => $adjustmentcharges])->render();
        }
    }

    public function addupdate_adjustment_charge(Request $request)
    {
        if ($request->ajax()) {
            $adjustment_details = $request->except("_token");

            $rules = [
                "dc_visa" => "required|numeric",
                "dc_master" => "required|numeric",
                "dc_rupay" => "required|numeric",
                "cc_visa" => "required|numeric",
                "cc_master" => "required|numeric",
                "cc_rupay" => "required|numeric",
                "amex" => "required|numeric",
                "upi" => "required|numeric",
                "net_sbi" => "required|numeric",
                "net_hdfc" => "required|numeric",
                "net_axis" => "required|numeric",
                "net_icici" => "required|numeric",
                "net_yes_kotak" => "required|numeric",
                "net_others" => "required|numeric",
            ];

            if (empty($adjustment_details["id"])) {
                $rules["merchant_id"] = "sometimes|required|unique:ryapay_adjustment_charge";
            }

            $messages = [
                "merchant_id.unique" => "A record is already existing with this details",
                "dc_visa.numeric" => "This field accepts only numeric value",
                "dc_master.numeric" => "This field accepts only numeric value",
                "dc_rupay.numeric" => "This field accepts only numeric value",
                "cc_visa.numeric" => "This field accepts only numeric value",
                "cc_master.numeric" => "This field accepts only numeric value",
                "cc_rupay.numeric" => "This field accepts only numeric value",
                "amex.numeric" => "This field accepts only numeric value",
                "upi.numeric" => "This field accepts only numeric value",
                "net_sbi.numeric" => "This field accepts only numeric value",
                "net_hdfc.numeric" => "This field accepts only numeric value",
                "net_axis.numeric" => "This field accepts only numeric value",
                "net_icici.numeric" => "This field accepts only numeric value",
                "net_yes_kotak.numeric" => "This field accepts only numeric value",
                "net_others.numeric" => "This field accepts only numeric value",
            ];


            $validate = Validator::make($request->all(), $rules, $messages);

            if ($validate->fails()) {
                echo json_encode(["status" => FALSE, "errors" => $validate->errors()]);
            } else {
                $id["id"] = $request->merchant_id;

                if (empty($adjustment_details["id"])) {
                    $adjustChargeObject = new RyapayAdjustmentCharge();
                    $adjustment_details["created_date"] = $this->datetime;
                    $adjustment_details["created_user"] = Auth::guard("employee")->user()->id;
                    $insert_status =  $adjustChargeObject->add_adjustment_charge($adjustment_details);

                    if ($insert_status) {
                        $message = ValidationMessage::$validation_messages["merchant_adjustment_success"];
                        echo json_encode(array("status" => TRUE, "message" => $message));
                    } else {
                        $message = ValidationMessage::$validation_messages["merchant_adjustment_failed"];
                        echo json_encode(array("status" => FALSE, "message" => $message));
                    }
                } else {

                    $id["id"] = $request->merchant_id;
                    $adjustment_id = $request->only("id");
                    $adjustment_details = $request->except("id", "_token", "merchant_id");
                    $adjustChargeObject = new RyapayAdjustmentCharge();
                    $update_status =  $adjustChargeObject->update_adjustment_charge($adjustment_id, $adjustment_details);

                    if ($update_status) {
                        $message = ValidationMessage::$validation_messages["merchant_adjustment_update_success"];
                        echo json_encode(array("status" => TRUE, "message" => $message));
                    } else {
                        $message = ValidationMessage::$validation_messages["merchant_adjustment_update_failed"];
                        echo json_encode(array("status" => FALSE, "message" => $message));
                    }
                }
            }
        }
    }

    public function get_adjustment_charge(Request $request, $id)
    {
        if ($request->ajax()) {

            $adjustChargeObject = new RyapayAdjustmentCharge();
            $adjustcharge =  $adjustChargeObject->get_adjustment_charge($id);
            echo json_encode($adjustcharge);
        }
    }

    public function get_merchant_routes(Request $request, $perpage)
    {
        if ($request->ajax()) {

            $merchantrouteObject = new MerchantVendorBank();
            $merchantvendor =  $merchantrouteObject->get_merchant_routes();
            $merchantroutes = $this->_arrayPaginator($merchantvendor, $request, "merchantroute", $perpage);
            return View::make("employee.pagination")->with(["module" => "merchantroute", "merchantroutes" => $merchantroutes])->render();
        }
    }

    public function get_merchant_route(Request $request, $id)
    {
        if ($request->ajax()) {

            $merchantrouteObject = new MerchantVendorBank();
            $merchantvendor =  $merchantrouteObject->get_merchant_route($id);
            echo json_encode($merchantvendor);
        }
    }
    public function store_merchant_route(Request $request)
    {
        if ($request->ajax()) {
            $route_details = $request->except("_token");

            $rules = [
                "merchant_id" => "required|numeric",
                "business_type_id" => "required|numeric",
                "cc_card" => "required|numeric",
                "dc_card" => "required|numeric",
                "net" => "required|numeric",
                "upi" => "required|numeric",
                "qrcode" => "required|numeric",
                "wallet" => "required|numeric"
            ];

            if (empty($route_details["id"])) {
                $rules["merchant_id"] = "sometimes|required|unique:merchant_vendor_bank";
            }

            $messages = [
                "merchant_id.unique" => "A record is already existing with this details",
                "cc_card.numeric" => "This field accepts only numeric value",
                "dc_card.numeric" => "This field accepts only numeric value",
                "net.numeric" => "This field accepts only numeric value",
                "upi.numeric" => "This field accepts only numeric value",
                "qrcode.numeric" => "This field accepts only numeric value",
                "wallet.numeric" => "This field accepts only numeric value"
            ];


            $validate = Validator::make($request->all(), $rules, $messages);

            if ($validate->fails()) {
                echo json_encode(["status" => FALSE, "errors" => $validate->errors()]);
            } else {
                $id["id"] = $request->merchant_id;

                if (empty($route_details["id"])) {
                    $merchantrouteObject = new MerchantVendorBank();
                    $route_details["created_date"] = $this->datetime;
                    $route_details["created_user"] = Auth::guard("employee")->user()->id;
                    $insert_status =  $merchantrouteObject->add_merchant_route($route_details);

                    if ($insert_status) {
                        $message = ValidationMessage::$validation_messages["merchant_route_insert_success"];
                        echo json_encode(array("status" => TRUE, "message" => $message));
                    } else {
                        $message = ValidationMessage::$validation_messages["merchant_route_insert_failed"];
                        echo json_encode(array("status" => FALSE, "message" => $message));
                    }
                } else {

                    $id["id"] = $request->merchant_id;
                    $route_id = $request->only("id");
                    $route_details = $request->except("id", "_token", "merchant_id");
                    $merchantrouteObject = new MerchantVendorBank();
                    $update_status =  $merchantrouteObject->update_merchant_route($route_id, $route_details);

                    if ($update_status) {
                        $message = ValidationMessage::$validation_messages["merchant_route_update_success"];
                        echo json_encode(array("status" => TRUE, "message" => $message));
                    } else {
                        $message = ValidationMessage::$validation_messages["merchant_route_update_failed"];
                        echo json_encode(array("status" => FALSE, "message" => $message));
                    }
                }
            }
        }
    }

    public function get_cashfree_route(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $cfRpayKeysObject = new CfRpayKeys();
            $cfRpaykeys = $cfRpayKeysObject->get_cf_keys();
            $cfRpaykeys_result = $this->_arrayPaginator($cfRpaykeys, $request, "cashfreeroute", $perpage);
            return View::make("employee.pagination")->with(["module" => "cashfreeroute", "cashfreeroutes" => $cfRpaykeys_result])->render();
        }
    }

    public function add_cashfree_route(Request $request)
    {
        if ($request->ajax()) {
            $cashfree_data = $request->except("_token");
            $cfRpayKeysObject = new CfRpayKeys();
            $cfRpaykeys = $cfRpayKeysObject->get_cf_keys();
            $cashfree_data["created_date"] = $this->datetime;
            $cashfree_data["created_user"] = Auth::guard("employee")->user()->id;
            $insert_status =  $cfRpayKeysObject->ad_cf_keys($cashfree_data);

            if ($insert_status) {
                $message = ValidationMessage::$validation_messages["merchant_cashfree_insert_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["merchant_cashfree_insert_failed"];
                echo json_encode(array("status" => FALSE, "message" => $message));
            }
        }
    }

    public function edit_cashfree_route(Request $request, $id)
    {
        if ($request->ajax()) {
            $cfRpayKeysObject = new CfRpayKeys();
            $cfRpaykeys = $cfRpayKeysObject->get_cf_key($id);
            echo json_encode($cfRpaykeys);
        }
    }

    public function update_cashfree_route(Request $request)
    {
        if ($request->ajax()) {
            $id["id"] = $request->id;
            $cashfree_id = $request->only("id");
            $cashfree_data = $request->except("id", "_token", "merchant_id");
            $cfRpayKeysObject = new CfRpayKeys();
            $update_status =  $cfRpayKeysObject->update_cf_keys($cashfree_id, $cashfree_data);

            if ($update_status) {
                $message = ValidationMessage::$validation_messages["merchant_cashfree_update_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["merchant_cashfree_update_failed"];
                echo json_encode(array("status" => FALSE, "message" => $message));
            }
        }
    }

    public function get_approved_merchants(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $merchantObject = new MerchantDocument();
            $approvedmerchant =  $merchantObject->get_approved_merchants();
            // dd($approvedmerchant);
            $approvedmerchants = $this->_arrayPaginator($approvedmerchant, $request, "approvedmerchant", $perpage);
            return View::make("employee.pagination")->with(["module" => "approvedmerchant", "approvedmerchants" => $approvedmerchants])->render();
        }
    }


    public function payinstatusupdate(Request $request, $id)
    {
        // dd($request->status);
        // Assuming you're using the Guzzle HTTP client to make the API call
      // Prepare the data to be sent

      // Extract the status from the request
      $status = $request->status;

      // Update the payin status in the user_keys table using a raw SQL query
      $affected = DB::update('update user_keys set payin_status = ? where mid = ?', [$status, $id]);

      $prodMid = DB::table('user_keys')->where('mid', $id)->value('prod_mid');

    //   dd($prodMid);

      if (!$prodMid) {
          // If prod_mid not found, return an error response
          return response()->json(['error' => 'prod_mid not found for the provided mid'], 404);
      }

      $postData = [
        'mid' =>$prodMid, // Use the merchant ID passed in the URL
        'status' => $request->status // The status will be sent as a query parameter
    ];
 
    // dd($postData);
    // Initialize cURL session
    $curl = curl_init();

    // Set cURL options
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://paymentgateway.flakpay.com/fpay/merchantPayinStatusUpdate',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($postData),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));

    // Execute cURL request
    $response = curl_exec($curl);
    // dd($response);

    // Close cURL session
    curl_close($curl);

    // Decode the response
    $responseData = json_decode($response, true);
    // Here you can perform any additional actions based on the API response
    // For now, just return the response
    return response()->json($responseData);

    }


    public function make_approved_merchant_live(Request $request, $id)
    {
        if ($request->ajax()) {
            $user = new User();
            $field["change_app_mode"] = "Y";
            $merchantid["id"] = $id;
            $update_status = $user->update_docverified_status($merchantid, $field);
            $welcome_message = "Thank You,<br> We are glad for choosing us.rockpay Payment Gateway makes your online transaction secure and hassle free.<br> We have verified your documents and enabled live enviroment to your account.<br> Now you are eligible to make real transactions. <br> flakpay wishing you all the best for your business.";
            if ($update_status) {
                $merchantObject = new User();
                $merchant_email = $merchantObject->get_merchant_info($id, "email");
                $data = array(
                    "from" => env("MAIL_USERNAME", ""),
                    "subject" => "Welcome To rockpay",
                    "view" => "/maillayouts/welcomerupayapay",
                    "htmldata" => array(
                        "merchanName" => $merchantObject->get_merchant_info($id, "name"),
                        "welcomeMessage" => $welcome_message,
                    ),
                );
                $mail_status = Mail::to($merchant_email)->send(new SendMail($data));

                $message = ValidationMessage::$validation_messages["document_verified_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {

                $message = ValidationMessage::$validation_messages["document_verified_failed"];
                echo json_encode(array("status" => FALSE, "message" => $message));
            }
        }
    }


    public function change_approved_merchant_status(Request $request, $id, $status)
    {
        if ($request->ajax()) {
            $user = new User();
            $response_status = "active";
            $emaildata = "We've re-activated your account again.Now you can login into your account.";
            if ($status == "active") {
                $response_status = "inactive";
                $emaildata = "We've de-activated your account due to some reason,If you want to re-activate your account please contact customer support team.";
            }
            $field["merchant_status"] = $response_status;
            $merchantid["id"] = $id;
            $update_status = $user->update_user_field($merchantid, $field);

            $insertLogs = DB::table('merchant_status_log')->insert([
                'merchant_id' => $id,
                'status' => $response_status,
                'created_at' => Carbon::now()
            ]);

            if ($update_status) {
                $merchantObject = new User();
                $merchant_email = $merchantObject->get_merchant_info($id, "email");
                $data = array(
                    "from" => env("MAIL_USERNAME", ""),
                    "subject" => "flakpay Alerts You!",
                    "view" => "/maillayouts/activeinactive",
                    "htmldata" => array(
                        "merchanName" => $merchantObject->get_merchant_info($id, "name"),
                        "messagetomerchant" => $emaildata,
                        "merchantEmail" => $merchant_email,
                    ),
                );
                $mail_status = Mail::to($merchant_email)->send(new SendMail($data));
                $message = ValidationMessage::$validation_messages["merchant_status_change_success"];
                echo json_encode(array("status" => TRUE, "message" => $message, "merchant_status" => $response_status));
            } else {

                $message = ValidationMessage::$validation_messages["merchant_status_change_failed"];
                echo json_encode(array("status" => FALSE, "message" => $message, "merchant_status" => $response_status));
            }
        }
    }

    public function network(Request $request, $id = "")
    {

        if (array_key_exists($id, session('sublinkNames'))) {

            $navigation = new Navigation();
            if (!empty($id)) {
                $sublinks = $navigation->get_sub_links($id);
            }

            $sublink_name = session('sublinkNames')[$id];

            switch ($id) {
                case 'ryapay-kUMU1Xop':

                    return view("employee.networking.network")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
                    break;
            }
        } else {
            return redierct()->back();
        }
    }

    public function marketing(Request $request, $id = "")
    {

        if (array_key_exists($id, session('sublinkNames'))) {
            $navigation = new Navigation();
            if (!empty($id)) {
                $sublinks = $navigation->get_sub_links($id);
            }
            $sublink_name = session('sublinkNames')[$id];

            switch ($id) {

                case 'ryapay-Hcvg4x9i':

                    return view("employee.marketing.offlinemarket")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);

                    break;

                case 'ryapay-bqcP77Bq':

                    return view("employee.marketing.onlinemarket")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
                    break;
            }
        } else {
            return redirect()->back();
        }
    }

    public function store_post(Request $request)
    {

        if ($request->ajax()) {

            $rules = [
                "post_category" => "required",
                "title" => "required|max:255",
                "description" => "required",
                "post_gid" => "required",
                "image" => "required|image|mimes:jpeg,png,jpg|max:5000",
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                echo json_encode(["status" => FALSE, "errors" => $validator->errors()]);
            } else {

                $blog = new RyapayBlog();
                $blog_image = $request->file("image");
                $original_name = $blog_image->getClientOriginalName();
                $save_image_path = public_path() . '/storage/blog/';
                $image_size = Image::make($blog_image->getRealPath());

                $image_size->resize(350, 250, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('thumbnails/blog/' . $original_name));

                $image_size->resize(80, 50, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('small-thumbnails/blog/' . $original_name));

                $blog_image->move($save_image_path, $original_name);

                $blog_post = $request->except("_token", "files");
                $blog_post["image"] = $original_name;
                $blog_post["description"] = $this->_generate_html_content($request->description);
                $blog_post["created_date"] = $this->datetime;
                $blog_post["created_user"] = Auth::guard("employee")->user()->id;

                $insert_status = $blog->add_post($blog_post);

                if ($insert_status) {
                    $message = ValidationMessage::$validation_messages["blogpost_insert_success"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {
                    $message = ValidationMessage::$validation_messages["blogpost_insert_failed"];
                    echo json_encode(array("status" => FALSE, "message" => $message));
                }
            }
        }
    }

    public function get_all_post(Request $request)
    {

        if ($request->ajax()) {

            $blog = new RyapayBlog();
            $blog_posts = $blog->get_all_post();
            $blog_pagination = $this->_arrayPaginator($blog_posts, $request, "blogpost");
            return View::make("employee.pagination")->with(["module" => "blogpost", "blogposts" => $blog_pagination])->render();
        }
    }

    public function edit_post(Request $request, $id)
    {
        if ($request->ajax()) {

            $blog = new RyapayBlog();
            $blog_posts = $blog->get_post($id);
            echo json_encode($blog_posts);
        }
    }

    public function update_post(Request $request)
    {
        if ($request->ajax()) {

            $rules = [
                "post_category" => "required",
                "title" => "required|max:255",
                "description" => "required",
                "post_gid" => "required",
                "image" => "sometimes|required|image|mimes:jpeg,png,jpg|max:5000",
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                echo json_encode(["status" => FALSE, "errors" => $validator->errors()]);
            } else {

                $blog = new RyapayBlog();
                $post_id =  $request->only("id");
                $blog_post = $request->except("_token", "id", "files");
                if ($request->file("files")) {
                    $description = $this->_generate_html_content($request->description);
                    $blog_post["description"] = $description;
                }

                if ($request->file("image")) {
                    $blog_image = $request->file("image");
                    $original_name = $blog_image->getClientOriginalName();
                    $save_image_path = public_path() . '/storage/blog/';
                    $image_size = Image::make($blog_image->getRealPath());

                    $image_size->resize(350, 250, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(public_path('thumbnails/blog/' . $original_name));

                    $image_size->resize(80, 50, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(public_path('small-thumbnails/blog/' . $original_name));

                    $blog_image->move($save_image_path, $original_name);
                    $blog_post["image"] = $original_name;
                }


                $update_status = $blog->update_post($post_id, $blog_post);

                if ($update_status) {
                    $message = ValidationMessage::$validation_messages["blogpost_update_success"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {
                    $message = ValidationMessage::$validation_messages["blogpost_update_failed"];
                    echo json_encode(array("status" => FALSE, "message" => $message));
                }
            }
        }
    }

    public function remove_post_image(Request $request, $image_name)
    {
        if ($request->ajax()) {
            $save_image_path = public_path() . '/storage/blog/';
            if (file_exists($save_image_path . $image_name)) {
                if (unlink($save_image_path . $image_name)) {
                    unlink(public_path() . "/small-thumbnails/blog/" . $image_name);
                    unlink(public_path() . "/thumbnails/blog/" . $image_name);
                    echo json_encode(array("status" => TRUE));
                } else {
                    echo json_encode(array("status" => FALSE));
                }
            } else {
                echo json_encode(array("status" => TRUE));
            }
        }
    }

    public function remove_post(Request $request)
    {
        if ($request->ajax()) {
            $blog = new RyapayBlog();
            $post["id"] = $request->only("id");
            $update["post_status"] = "inactive";

            $update_status = $blog->update_post($post, $update);

            if ($update_status) {
                $message = ValidationMessage::$validation_messages["blogpost_delete_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {

                $message = ValidationMessage::$validation_messages["blogpost_delete_failed"];
                echo json_encode(array("status" => FALSE, "message" => $message));
            }
        }
    }

    public function get_contact_lead(Request $request, $Perpage)
    {
        if ($request->ajax()) {

            $contactObject = new ContactUs();
            $leads = $contactObject->get_contactus();
            $lead_pagination = $this->_arrayPaginator($leads, $request, "lead", $Perpage);
            return View::make("employee.pagination")->with(["module" => "lead", "leads" => $lead_pagination])->render();
        }
    }

    public function get_subscribe_list(Request $request, $Perpage)
    {
        if ($request->ajax()) {

            $subscribeObject = new RyapaySubscribe();
            $subscribers = $subscribeObject->get_subscribe_list();
            $subscribe_pagination = $this->_arrayPaginator($subscribers, $request, "subscribe", $Perpage);
            return View::make("employee.pagination")->with(["module" => "subscribe", "subscribers" => $subscribe_pagination])->render();
        }
    }

    public function get_gallery_image(Request $request, $Perpage)
    {
        if ($request->ajax()) {

            $galleryObject = new RyapayGallery();
            $images = $galleryObject->get_gallery_images();
            $image_pagination = $this->_arrayPaginator($images, $request, "image", $Perpage);
            return View::make("employee.pagination")->with(["module" => "image", "images" => $image_pagination])->render();
        }
    }

    public function store_image(Request $request)
    {
        if ($request->ajax()) {

            $rules = [
                "image_name" => "required|image|mimes:jpeg,png,jpg|max:5000",
            ];

            $messages = [
                "image_name.image" => "Only Images are accepted",
                "image_name.mimes" => "jpeg,jpg or png files are only accepted"
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {

                echo json_encode(["status" => FALSE, "errors" => $validator->errors()]);
            } else {

                if ($request->file("image_name")) {

                    $gallery_post = $request->except("_token");

                    $gallery_image = $request->file("image_name");
                    $original_name = $gallery_image->getClientOriginalName();
                    $save_image_path = public_path() . '/images/gallery/';
                    $gallery_image->move($save_image_path, $original_name);
                    $gallery_post["image_name"] = $original_name;
                    $gallery_post["created_date"] = $this->datetime;
                    $gallery_post["created_user"] = Auth::guard("employee")->user()->id;

                    $galleryObject = new RyapayGallery();

                    $insert_status = $galleryObject->add_image($gallery_post);

                    if ($insert_status) {
                        $message = ValidationMessage::$validation_messages["gallery_insert_success"];
                        echo json_encode(array("status" => TRUE, "message" => $message));
                    } else {
                        $message = ValidationMessage::$validation_messages["gallery_insert_failed"];
                        echo json_encode(array("status" => FALSE, "message" => $message));
                    }
                }
            }
        }
    }


    public function edit_image(Request $request, $id)
    {
        if ($request->ajax()) {
            $galleryObject = new RyapayGallery();
            $gallery_data = $galleryObject->get_gallery_image($id);
            echo json_encode($gallery_data);
        }
    }

    public function remove_gallery_image(Request $request, $imagename)
    {
        if ($request->ajax()) {

            $save_image_path = public_path('/images/gallery/' . $imagename);
            if (File::exists($save_image_path)) {
                File::delete($save_image_path);
            }
            echo json_encode(array("status" => TRUE));
        }
    }

    public function update_image(Request $request)
    {
        if ($request->ajax()) {
            if ($request->file("image_name")) {
                $rules = [
                    "image_name" => "required|image|mimes:jpeg,png,jpg|max:5000",
                ];

                $messages = [
                    "image_name.image" => "Only Images are accepted",
                    "image_name.mimes" => "jpeg,jpg or png files are only accepted"
                ];

                $validator = Validator::make($request->all(), $rules, $messages);

                if ($validator->fails()) {

                    echo json_encode(["status" => FALSE, "errors" => $validator->errors()]);
                } else {
                    $image_id = $request->only("id");
                    $gallery_post = $request->except("_token", "id");

                    $gallery_image = $request->file("image_name");
                    $original_name = $gallery_image->getClientOriginalName();
                    $save_image_path = public_path() . '/images/gallery/';
                    $gallery_image->move($save_image_path, $original_name);
                    $gallery_post["image_name"] = $original_name;

                    $galleryObject = new RyapayGallery();

                    $update_status = $galleryObject->update_image($image_id, $gallery_post);

                    if ($update_status) {
                        $message = ValidationMessage::$validation_messages["gallery_update_success"];
                        echo json_encode(array("status" => TRUE, "message" => $message));
                    } else {
                        $message = ValidationMessage::$validation_messages["gallery_update_failed"];
                        echo json_encode(array("status" => FALSE, "message" => $message));
                    }
                }
            } else {

                $image_id = $request->only("id");
                $gallery_post = $request->except("_token", "id");

                $galleryObject = new RyapayGallery();

                $update_status = $galleryObject->update_image($image_id, $gallery_post);

                if ($update_status) {
                    $message = ValidationMessage::$validation_messages["gallery_update_success"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {
                    $message = ValidationMessage::$validation_messages["gallery_update_failed"];
                    echo json_encode(array("status" => FALSE, "message" => $message));
                }
            }
        }
    }

    public function store_event_post(Request $request)
    {

        if ($request->ajax()) {

            $rules = [
                "event_short_url" => "required|unique:ryapay_event",
                "event_name" => "required",
                "event_date" => "required",
                "event_time" => "required",
                "event_description" => "required",
                "event_venue" => "required",
                "event_image" => "required|image|mimes:jpeg,png,jpg|max:5000",
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                echo json_encode(["status" => FALSE, "errors" => $validator->errors()]);
            } else {

                $event = new RyapayEvent();
                $event_image = $request->file("event_image");
                $original_name = $event_image->getClientOriginalName();
                $save_image_path = public_path() . '/storage/event/';
                $image_size = Image::make($event_image->getRealPath());

                $image_size->resize(350, 250, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('thumbnails/event/' . $original_name));

                $image_size->resize(80, 50, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('small-thumbnails/event/' . $original_name));

                $event_image->move($save_image_path, $original_name);

                $event_post = $request->except("_token");
                $event_post["event_image"] = $original_name;
                $event_post["event_description"] = $this->_generate_html_content($request->event_description);
                $event_post["created_date"] = $this->datetime;
                $event_post["created_user"] = Auth::guard("employee")->user()->id;

                $insert_status = $event->add_event($event_post);

                if ($insert_status) {
                    $message = ValidationMessage::$validation_messages["eventpost_insert_success"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {
                    $message = ValidationMessage::$validation_messages["eventpost_insert_failed"];
                    echo json_encode(array("status" => FALSE, "message" => $message));
                }
            }
        }
    }

    public function get_all_event_post(Request $request)
    {

        if ($request->ajax()) {

            $event = new RyapayEvent();
            $event_posts = $event->get_all_events();
            $event_pagination = $this->_arrayPaginator($event_posts, $request, "eventpost");
            return View::make("employee.pagination")->with(["module" => "eventpost", "eventposts" => $event_pagination])->render();
        }
    }

    public function edit_event_post(Request $request, $id)
    {
        if ($request->ajax()) {

            $blog = new RyapayEvent();
            $blog_posts = $blog->get_event($id);
            echo json_encode($blog_posts);
        }
    }

    public function update_event_post(Request $request)
    {
        if ($request->ajax()) {

            $rules = [
                "event_short_url" => "required",
                "event_name" => "required",
                "event_date" => "required",
                "event_time" => "required",
                "event_description" => "required",
                "event_venue" => "required",
                "event_image" => "required|sometimes|image|mimes:jpeg,png,jpg|max:5000",
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                echo json_encode(["status" => FALSE, "errors" => $validator->errors()]);
            } else {

                $event = new RyapayEvent();
                $post_id =  $request->only("id");
                $event_post = $request->except("_token", "id", "files");
                if ($request->file("files")) {
                    $description = $this->_generate_html_content($request->description);
                    $event_post["description"] = $description;
                }

                if ($request->file("event_image")) {
                    $event_image = $request->file("image");
                    $original_name = $event_image->getClientOriginalName();
                    $save_image_path = public_path() . '/storage/csr/';
                    $image_size = Image::make($event_image->getRealPath());

                    $image_size->resize(350, 290, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(public_path('thumbnails/csr/' . $original_name));

                    $image_size->resize(100, 60, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(public_path('small-thumbnails/csr/' . $original_name));

                    $event_image->move($save_image_path, $original_name);
                    $event_post["image"] = $original_name;
                }
                $update_status = $event->update_event($post_id, $event_post);

                if ($update_status) {
                    $message = ValidationMessage::$validation_messages["eventpost_update_success"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {
                    $message = ValidationMessage::$validation_messages["eventpost_update_failed"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                }
            }
        }
    }

    public function remove_event_post_image(Request $request, $image_name)
    {
        if ($request->ajax()) {
            $save_image_path = public_path() . '/storage/csr/';
            if (file_exists($save_image_path . $image_name)) {
                if (unlink($save_image_path . $image_name)) {
                    unlink(public_path() . "/small-thumbnails/csr/" . $image_name);
                    unlink(public_path() . "/thumbnails/csr/" . $image_name);
                    echo json_encode(array("status" => TRUE));
                } else {
                    echo json_encode(array("status" => FALSE));
                }
            } else {
                echo json_encode(array("status" => TRUE));
            }
        }
    }

    public function remove_event_post(Request $request)
    {
        if ($request->ajax()) {
            $blog = new RyapayEvent();
            $post["id"] = $request->only("id");
            $update["post_status"] = "inactive";

            $update_status = $blog->update_post($post, $update);

            if ($update_status) {
                $message = ValidationMessage::$validation_messages["blogpost_delete_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {

                $message = ValidationMessage::$validation_messages["blogpost_delete_failed"];
                echo json_encode(array("status" => FALSE, "message" => $message));
            }
        }
    }

    public function store_csr_post(Request $request)
    {

        if ($request->ajax()) {

            $rules = [
                "post_category" => "required",
                "title" => "required|max:255",
                "description" => "required",
                "post_gid" => "required",
                "image" => "required|image|mimes:jpeg,png,jpg|max:5000",
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                echo json_encode(["status" => FALSE, "errors" => $validator->errors()]);
            } else {

                $blog = new RyapayBlog("csr");
                $blog_image = $request->file("image");
                $original_name = $blog_image->getClientOriginalName();
                $save_image_path = public_path() . '/storage/csr/';
                $image_size = Image::make($blog_image->getRealPath());

                $image_size->resize(350, 250, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('thumbnails/csr/' . $original_name));

                $image_size->resize(80, 50, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('small-thumbnails/csr/' . $original_name));

                $blog_image->move($save_image_path, $original_name);

                $blog_post = $request->except("_token", "files");
                $blog_post["image"] = $original_name;
                $blog_post["description"] = $this->_generate_html_content($request->description);
                $blog_post["post_from"] = "csr";
                $blog_post["created_date"] = $this->datetime;
                $blog_post["created_user"] = Auth::guard("employee")->user()->id;

                $insert_status = $blog->add_post($blog_post);

                if ($insert_status) {
                    $message = ValidationMessage::$validation_messages["blogpost_insert_success"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {
                    $message = ValidationMessage::$validation_messages["blogpost_insert_failed"];
                    echo json_encode(array("status" => FALSE, "message" => $message));
                }
            }
        }
    }

    public function get_all_csr_post(Request $request)
    {

        if ($request->ajax()) {

            $blog = new RyapayBlog("csr");
            $csr_posts = $blog->get_all_post();
            $csr_pagination = $this->_arrayPaginator($csr_posts, $request, "crpost");
            return View::make("employee.pagination")->with(["module" => "csrpost", "csrposts" => $csr_pagination])->render();
        }
    }

    public function edit_csr_post(Request $request, $id)
    {
        if ($request->ajax()) {

            $blog = new RyapayBlog("csr");
            $blog_posts = $blog->get_post($id);
            echo json_encode($blog_posts);
        }
    }

    public function update_csr_post(Request $request)
    {
        if ($request->ajax()) {

            $rules = [
                "post_category" => "required",
                "title" => "required|max:255",
                "description" => "required",
                "post_gid" => "required",
                "image" => "sometimes|required|image|mimes:jpeg,png,jpg|max:5000",
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                echo json_encode(["status" => FALSE, "errors" => $validator->errors()]);
            } else {

                $blog = new RyapayBlog();
                $post_id =  $request->only("id");
                $blog_post = $request->except("_token", "id", "files");
                if ($request->file("files")) {
                    $description = $this->_generate_html_content($request->description);
                    $blog_post["description"] = $description;
                }

                if ($request->file("image")) {
                    $blog_image = $request->file("image");
                    $original_name = $blog_image->getClientOriginalName();
                    $save_image_path = public_path() . '/storage/csr/';
                    $image_size = Image::make($blog_image->getRealPath());

                    $image_size->resize(350, 250, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(public_path('thumbnails/csr/' . $original_name));

                    $image_size->resize(80, 50, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(public_path('small-thumbnails/csr/' . $original_name));

                    $blog_image->move($save_image_path, $original_name);
                    $blog_post["image"] = $original_name;
                }
                $update_status = $blog->update_post($post_id, $blog_post);

                if ($update_status) {
                    $message = ValidationMessage::$validation_messages["blogpost_update_success"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {
                    $message = ValidationMessage::$validation_messages["blogpost_update_failed"];
                    echo json_encode(array("status" => FALSE, "message" => $message));
                }
            }
        }
    }

    public function remove_csr_post_image(Request $request, $image_name)
    {
        if ($request->ajax()) {
            $save_image_path = public_path() . '/storage/csr/';
            if (file_exists($save_image_path . $image_name)) {
                if (unlink($save_image_path . $image_name)) {
                    unlink(public_path() . "/small-thumbnails/csr/" . $image_name);
                    unlink(public_path() . "/thumbnails/csr/" . $image_name);
                    echo json_encode(array("status" => TRUE));
                } else {
                    echo json_encode(array("status" => FALSE));
                }
            } else {
                echo json_encode(array("status" => TRUE));
            }
        }
    }

    public function remove_csr_post(Request $request)
    {
        if ($request->ajax()) {
            $blog = new RyapayBlog();
            $post["id"] = $request->only("id");
            $update["post_status"] = "inactive";

            $update_status = $blog->update_post($post, $update);

            if ($update_status) {
                $message = ValidationMessage::$validation_messages["blogpost_delete_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {

                $message = ValidationMessage::$validation_messages["blogpost_delete_failed"];
                echo json_encode(array("status" => FALSE, "message" => $message));
            }
        }
    }

    public function store_pr_post(Request $request)
    {

        if ($request->ajax()) {

            $rules = [
                "post_category" => "required",
                "title" => "required|max:255",
                "description" => "required",
                "post_gid" => "required",
                "image" => "required|image|mimes:jpeg,png,jpg|max:5000",
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                echo json_encode(["status" => FALSE, "errors" => $validator->errors()]);
            } else {

                $blog = new RyapayBlog();
                $blog_image = $request->file("image");
                $original_name = $blog_image->getClientOriginalName();
                $save_image_path = public_path() . '/storage/press-release/';
                $image_size = Image::make($blog_image->getRealPath());

                $image_size->resize(350, 250, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('thumbnails/press-release/' . $original_name));

                $image_size->resize(80, 50, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('small-thumbnails/press-release/' . $original_name));

                $blog_image->move($save_image_path, $original_name);

                $blog_post = $request->except("_token", "files");
                $blog_post["image"] = $original_name;
                $blog_post["description"] = $this->_generate_html_content($request->description);
                $blog_post["post_from"] = "press-release";
                $blog_post["created_date"] = $this->datetime;
                $blog_post["created_user"] = Auth::guard("employee")->user()->id;

                $insert_status = $blog->add_post($blog_post);

                if ($insert_status) {
                    $message = ValidationMessage::$validation_messages["blogpost_insert_success"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {
                    $message = ValidationMessage::$validation_messages["blogpost_insert_failed"];
                    echo json_encode(array("status" => FALSE, "message" => $message));
                }
            }
        }
    }

    public function get_all_pr_post(Request $request)
    {

        if ($request->ajax()) {

            $blog = new RyapayBlog("press-release");
            $pr_posts = $blog->get_all_post();
            $pr_pagination = $this->_arrayPaginator($pr_posts, $request, "prpost");
            return View::make("employee.pagination")->with(["module" => "prpost", "prposts" => $pr_pagination])->render();
        }
    }

    public function edit_pr_post(Request $request, $id)
    {
        if ($request->ajax()) {

            $blog = new RyapayBlog("press-release");
            $blog_posts = $blog->get_post($id);
            echo json_encode($blog_posts);
        }
    }

    public function update_pr_post(Request $request)
    {
        if ($request->ajax()) {

            $rules = [
                "post_category" => "required",
                "title" => "required|max:255",
                "description" => "required",
                "post_gid" => "required",
                "image" => "sometimes|required|image|mimes:jpeg,png,jpg|max:5000",
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                echo json_encode(["status" => FALSE, "errors" => $validator->errors()]);
            } else {

                $blog = new RyapayBlog();
                $post_id =  $request->only("id");
                $blog_post = $request->except("_token", "id", "files");
                if ($request->file("files")) {
                    $description = $this->_generate_html_content($request->description);
                    $blog_post["description"] = $description;
                }

                if ($request->file("image")) {
                    $blog_image = $request->file("image");
                    $original_name = $blog_image->getClientOriginalName();
                    $save_image_path = public_path() . '/storage/press-release/';
                    $image_size = Image::make($blog_image->getRealPath());

                    $image_size->resize(350, 250, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(public_path('thumbnails/press-release/' . $original_name));

                    $image_size->resize(80, 50, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(public_path('small-thumbnails/press-release/' . $original_name));

                    $blog_image->move($save_image_path, $original_name);
                    $blog_post["image"] = $original_name;
                }
                $update_status = $blog->update_post($post_id, $blog_post);

                if ($update_status) {
                    $message = ValidationMessage::$validation_messages["blogpost_update_success"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {
                    $message = ValidationMessage::$validation_messages["blogpost_update_failed"];
                    echo json_encode(array("status" => FALSE, "message" => $message));
                }
            }
        }
    }

    public function remove_pr_post_image(Request $request, $image_name)
    {
        if ($request->ajax()) {
            $save_image_path = public_path() . '/storage/press-release/';
            if (file_exists($save_image_path . $image_name)) {
                if (unlink($save_image_path . $image_name)) {
                    unlink(public_path() . "/small-thumbnails/press-release/" . $image_name);
                    unlink(public_path() . "/thumbnails/press-release/" . $image_name);
                    echo json_encode(array("status" => TRUE));
                } else {
                    echo json_encode(array("status" => FALSE));
                }
            } else {
                echo json_encode(array("status" => TRUE));
            }
        }
    }

    public function remove_pr_post(Request $request)
    {
        if ($request->ajax()) {
            $blog = new RyapayBlog();
            $post["id"] = $request->only("id");
            $update["post_status"] = "inactive";

            $update_status = $blog->update_post($post, $update);

            if ($update_status) {
                $message = ValidationMessage::$validation_messages["blogpost_delete_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {

                $message = ValidationMessage::$validation_messages["blogpost_delete_failed"];
                echo json_encode(array("status" => FALSE, "message" => $message));
            }
        }
    }

    public function support(Request $request, $id = "")
    {

        if (array_key_exists($id, session('sublinkNames'))) {
            $navigation = new Navigation();
            if (!empty($id)) {
                $sublinks = $navigation->get_sub_links($id);
            }
            $sublink_name = session('sublinkNames')[$id];

            switch ($id) {

                case 'ryapay-2OjYRr4O':

                    return view("employee.support.clientdesk")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
                    break;

                case 'ryapay-yp9slYdc':

                    return view("employee.support.merchantstatus")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
                    break;

                case 'ryapay-lcAKnFKA':

                    return view("employee.support.calllist")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
                    break;
            }
        } else {
            return redirect()->back();
        }
    }


    public function get_merchant_status(Request $request)
    {
        if ($request->ajax()) {
            $merchantObject = new User();
            $merchant_lists = $merchantObject->get_documents_status();
            $pagination = $this->_arrayPaginator($merchant_lists, $request, "merchantlist");
            return View::make("employee.pagination")->with(["module" => "merchantlist", "merchantlists" => $pagination])->render();
        }
    }

    public function get_merchant_support(Request $request)
    {
        if ($request->ajax()) {
            $merchantsupportObject = new MerchantSupport();
            $merchantsupport = $merchantsupportObject->get_all_merchant_support();
            $pagination = $this->_arrayPaginator($merchantsupport, $request, "merchantsupport");
            return View::make("employee.pagination")->with(["module" => "merchantsupport", "merchantsupports" => $pagination])->render();
        }
    }

    public function store_merchant_support(Request $request)
    {

        if ($request->ajax()) {
            $validate = Validator::make($request->all(), [
                'title' => 'required',
                'sup_category' => 'required',
                'sup_from' => 'required',
                'merchant_id' => 'required',
                'support_image' => 'file|mimes:jpg,jpeg,png|max:2000'
            ]);

            if ($validate->fails()) {
                echo json_encode(["status" => FALSE, "error" => $validate->errors()]);
            } else {

                $merchant_support = new MerchantSupport();

                $path_to_upload = "rockpay/" . auth()->guard('employee')->user()->official_email . "/support";

                $support = $request->except("_token", "support_image");

                foreach ($request->file() as $key => $value) {
                    $file = $request->file($key);
                    $support["sup_file_path"] = $file->store($path_to_upload);
                }
                $support["sup_gid"] = 'suprt_' . Str::random(16);
                $support["sup_status"] = "open";
                $support["created_date"] =  $this->datetime;
                $support["created_by"] = "employee";

                $insert_status = $merchant_support->add_support($support);

                if ($insert_status) {
                    $message = ValidationMessage::$validation_messages["merchantsupport_insert_success"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {
                    $message = ValidationMessage::$validation_messages["merchantsupport_insert_failed"];
                    echo json_encode(array("status" => FALSE, "message" => $message));
                }
            }
        }
    }


    public function get_callsupport(Request $request)
    {
        if ($request->ajax()) {
            $callsupportObject = new CallSupport();
            $merchantcallsupport = $callsupportObject->get_all_callsupportt();
            $pagination = $this->_arrayPaginator($merchantcallsupport, $request, "merchantcallsupport");
            return View::make("employee.pagination")->with(["module" => "merchantcallsupport", "merchantcallsupports" => $pagination])->render();
        }
    }
    public function store_callsupport(Request $request)
    {
        if ($request->ajax()) {
            $support_data = $request->except("_token");
            $support_data["next_call"] = date("Y-m-d h:i:s", strtotime($request->next_call . "00:00:00"));
            $support_data["created_date"] = $this->datetime;
            $support_data["created_user"] = auth()->guard("employee")->user()->id;
            $callsupportObject = new CallSupport();
            $insert_status = $callsupportObject->add_call_support($support_data);
            if ($insert_status) {
                $message = ValidationMessage::$validation_messages["callsupport_insert_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["callsupport_insert_failed"];
                echo json_encode(array("status" => FALSE, "message" => $message));
            }
        }
    }

    public function get_merchant_locked_accounts(Request $request)
    {
        if ($request->ajax()) {
            $user = new User();
            $locked_merchants = $user->merchant_locked();
            $lockedmerchant_pagination = $this->_arrayPaginator($locked_merchants, $request, "lockedmerchant");
            return View::make("employee.pagination")->with(["module" => "lockedmerchant", "lockedmerchants" => $lockedmerchant_pagination])->render();
        }
    }

    public function merchant_unlock(Request $request, $id)
    {
        if ($request->ajax()) {
            $user = new User();
            $field["is_account_locked"] = "N";
            $field["failed_attempts"] = "0";
            $merchant_id["id"] = $id;
            $update_status = $user->update_user_field($merchant_id, $field);
            if ($update_status) {
                $message = ValidationMessage::$validation_messages["merchant_unlock_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["merchant_unlock_failed"];
                echo json_encode(array("status" => FALSE, "message" => $message));
            }
        }
    }


    public function sales(Request $request, $id = "")
    {


        if (array_key_exists($id, session('sublinkNames'))) {

            $navigation = new Navigation();
            if (!empty($id)) {
                $sublinks = $navigation->get_sub_links($id);
            }
            $sublink_name = session('sublinkNames')[$id];

            switch ($id) {

                case 'ryapay-0wFGLU8N':

                    return view("employee.sales.insidesale")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
                    break;

                case 'ryapay-jmGcXynF':

                    return view("employee.sales.fieldsales")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
                    break;

                case 'ryapay-pLDmFs9A':

                    return view("employee.sales.merchantcom")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
                    break;

                case 'ryapay-GPKG8yPX':

                    return view("employee.sales.prodmode")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
                    break;
            }
        } else {
            return redirect()->back();
        }
    }

    public function get_lead_sales(Request $request)
    {
        if ($request->ajax()) {

            $salesheetObject = new RyaPaySale();

            $saleslist = $salesheetObject->get_lead_sales();

            $pagination = $this->_arrayPaginator($saleslist, $request, "leadsaleslist");

            return View::make("employee.pagination")->with(["module" => "leadsaleslist", "leadsaleslists" => $pagination])->render();
        }
    }

    public function get_field_lead_sales(Request $request)
    {
        if ($request->ajax()) {
            $saleslist = [];
            $fromdate = $this->today;
            $todate = $this->today;
            if (!empty($request->trans_from_date) && !empty($request->trans_to_date)) {
                $fromdate = $request->trans_from_date;
                $todate = $request->trans_to_date;
                $perpage = $request->perpage;
            }

            session(['fromdate' => $fromdate]);
            session(['todate' => $todate]);

            $customObject = new Custom();
            $saleslist = $customObject->get_transaction($fromdate, $todate);
            $pagination = $this->_arrayPaginator($saleslist, $request, "fieldleadlist");

            return View::make("employee.pagination")->with(["module" => "fieldleadlist", "fieldleadlists" => $pagination])->render();
        }
    }

    public function get_transaction_breakup(Request $request, $merchant_id)
    {
        if ($request->ajax()) {
            $customObject = new Custom();
            $merchant_transactions = $customObject->get_transaction(session('fromdate'), session('todate'), $merchant_id);
            echo json_encode($merchant_transactions);
        }
    }

    public function get_daily_sales(Request $request)
    {
        if ($request->ajax()) {

            $salesheetObject = new RyaPaySale();

            $saleslist = $salesheetObject->get_daily_sales();

            $pagination = $this->_arrayPaginator($saleslist, $request, "dailysaleslist");

            return View::make("employee.pagination")->with(["module" => "dailysaleslist", "dailysaleslists" => $pagination])->render();
        }
    }


    public function get_field_daily_sales(Request $request)
    {
        if ($request->ajax()) {

            $salesheetObject = new RyaPaySale();

            $saleslist = $salesheetObject->get_field_daily_sales();

            $pagination = $this->_arrayPaginator($saleslist, $request, "fielddailylist");

            return View::make("employee.pagination")->with(["module" => "fielddailylist", "fielddailylists" => $pagination])->render();
        }
    }

    public function get_sales(Request $request)
    {
        if ($request->ajax()) {

            $salesheetObject = new RyaPaySale();

            $saleslist = $salesheetObject->get_sales();

            $pagination = $this->_arrayPaginator($saleslist, $request, "saleslist");

            return View::make("employee.pagination")->with(["module" => "saleslist", "saleslists" => $pagination])->render();
        }
    }

    public function get_field_sales(Request $request)
    {
        if ($request->ajax()) {

            $salesheetObject = new RyaPaySale();

            $saleslist = $salesheetObject->get_field_sales();

            $pagination = $this->_arrayPaginator($saleslist, $request, "fieldsaleslist");

            return View::make("employee.pagination")->with(["module" => "fieldsaleslist", "fieldsaleslists" => $pagination])->render();
        }
    }

    public function store_sale(Request $request)
    {
        if ($request->ajax()) {


            $slessheetObject = new RyaPaySale();

            if (!empty($request->id)) {
                $record_id = $request->only("id");
                $salessheet = $request->except("_token", "id");
                $salessheet["next_call"] = date("Y-m-d h:i:s", strtotime($request->next_call));
                $insert_status = $slessheetObject->update_sale($record_id, $salessheet);

                if ($insert_status) {
                    $message = ValidationMessage::$validation_messages["salesheet_update_success"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {
                    $message = ValidationMessage::$validation_messages["salesheet_update_failed"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                }
            } else {

                $salessheet = $request->except("_token");
                $salessheet["next_call"] = date("Y-m-d h:i:s", strtotime($request->next_call));
                $salessheet["created_date"] = $this->datetime;
                $salessheet["created_user"] = auth()->guard("employee")->user()->id;

                $insert_status = $slessheetObject->add_sale($salessheet);

                if ($insert_status) {
                    $message = ValidationMessage::$validation_messages["salesheet_insert_success"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {
                    $message = ValidationMessage::$validation_messages["salesheet_insert_failed"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                }
            }
        }
    }

    public function store_daily(Request $request)
    {
        if ($request->ajax()) {


            $slessheetObject = new RyaPaySale();

            if (!empty($request->id)) {
                $record_id = $request->only("id");
                $salessheet = $request->except("_token", "id");
                $salessheet["next_call"] = date("Y-m-d h:i:s", strtotime($request->next_call));
                $insert_status = $slessheetObject->update_sale($record_id, $salessheet);

                if ($insert_status) {
                    $message = ValidationMessage::$validation_messages["daily_update_success"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {
                    $message = ValidationMessage::$validation_messages["daily_update_failed"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                }
            } else {

                $salessheet = $request->except("_token");
                $salessheet["next_call"] = date("Y-m-d h:i:s", strtotime($request->next_call));
                $salessheet["created_date"] = $this->datetime;
                $salessheet["created_user"] = auth()->guard("employee")->user()->id;

                $insert_status = $slessheetObject->add_sale($salessheet);

                if ($insert_status) {
                    $message = ValidationMessage::$validation_messages["daily_insert_success"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {
                    $message = ValidationMessage::$validation_messages["daily_insert_failed"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                }
            }
        }
    }

    public function edit_leadsale(Request $request, $id)
    {
        if ($request->ajax()) {

            $salesheetObject = new RyaPaySale();

            $saleslist = $salesheetObject->get_a_lead_sale($id);

            echo json_encode($saleslist);
        }
    }

    public function edit_dailysale(Request $request, $id)
    {
        if ($request->ajax()) {

            $salesheetObject = new RyaPaySale();

            $saleslist = $salesheetObject->get_a_daily_sale($id);

            echo json_encode($saleslist);
        }
    }

    public function edit_sales(Request $request, $id)
    {
        if ($request->ajax()) {

            $salesheetObject = new RyaPaySale();

            $saleslist = $salesheetObject->get_a_sale($id);

            echo json_encode($saleslist);
        }
    }

    public function get_fieldsales(Request $request)
    {
        if ($request->ajax()) {

            $salesheetObject = new RyaPaySale();

            $saleslist = $salesheetObject->get_all_field_sales();

            $pagination = $this->_arrayPaginator($saleslist, $request, "fieldsaleslist");

            return View::make("employee.pagination")->with(["module" => "fieldsaleslist", "fieldsaleslists" => $pagination])->render();
        }
    }

    public function store_fieldsale(Request $request)
    {
        if ($request->ajax()) {

            $slessheetObject = new RyaPaySale();

            if (!empty($request->id)) {
                $record_id = $request->only("id");
                $salessheet = $request->except("_token", "id");
                $salessheet["next_call"] = date("Y-m-d h:i:s", strtotime($request->next_call));
                $salessheet["visited"] = date("Y-m-d h:i:s", strtotime($request->visited));
                $insert_status = $slessheetObject->update_sale($record_id, $salessheet);

                if ($insert_status) {
                    $message = ValidationMessage::$validation_messages["fieldsalesheet_update_success"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {
                    $message = ValidationMessage::$validation_messages["fieldsalesheet_update_failed"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                }
            } else {

                $salessheet = $request->except("_token");
                $salessheet["next_call"] = date("Y-m-d h:i:s", strtotime($request->next_call));
                $salessheet["visited"] = date("Y-m-d h:i:s", strtotime($request->visited));
                $salessheet["sales_from"] = "field";
                $salessheet["created_date"] = $this->datetime;
                $salessheet["created_user"] = auth()->guard("employee")->user()->id;

                $insert_status = $slessheetObject->add_sale($salessheet);

                if ($insert_status) {
                    $message = ValidationMessage::$validation_messages["fieldsalesheet_insert_success"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {
                    $message = ValidationMessage::$validation_messages["fieldsalesheet_insert_failed"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                }
            }
        }
    }

    public function edit_fieldsales(Request $request, $id)
    {
        if ($request->ajax()) {

            $salesheetObject = new RyaPaySale();

            $saleslist = $salesheetObject->get_a_field_sales($id);

            echo json_encode($saleslist);
        }
    }

    public function get_campaigns(Request $request, $perpage)
    {
        if ($request->ajax()) {

            $campaignObject = new Campaign();

            $campaignlist = $campaignObject->get_campaign();

            $pagination = $this->_arrayPaginator($campaignlist, $request, "campaignlist", $perpage);

            return View::make("employee.pagination")->with(["module" => "campaignlist", "campaignlists" => $pagination])->render();
        }
    }

    public function campaign(Request $request)
    {

        if ($request->ajax()) {
            if (($request->file('campaign_file'))) {
                $compaign = new CampaignSheet();
                Excel::import($compaign, $request->file('campaign_file'));
                $campaign_details = [];
                foreach ($compaign->excel_data as $key => $value) {
                    if ($key != 0) {

                        $subject = str_replace(
                            array('@name', '@company_name', '@business_category'),
                            array($value[1], $value[2], $value[3]),
                            $request->campaign_subject
                        );

                        $message = str_replace(
                            array('@name', '@company_name', '@business_category'),
                            array($value[1], $value[2], $value[3]),
                            $request->campaign_message
                        );

                        $data = array(
                            "from" => $request->campaign_from,
                            "subject" => $subject,
                            "view" => "/maillayouts/campaign",
                            "htmldata" => array(
                                "name" => $value[1],
                                "company_name" => $value[2],
                                "category" => $value[3],
                                "message" => $message
                            ),
                        );
                        Mail::to($value[0])->send(new SendMail($data));
                        $campaign_details[$key] = [
                            "campaign_from" => $request->campaign_from,
                            "campaign_subject" => $subject,
                            "campaign_to" => $value[0],
                            "campaign_message" => $message,
                            "campaign_status" => "sent",
                            "campaign_sent" => $this->datetime
                        ];
                    } else {
                        continue;
                    }
                }
            }

            if (!empty($campaign_details)) {
                $campaignObject = new Campaign;
                $insert_status = $campaignObject->add_campaign($campaign_details);

                if ($insert_status) {
                    $message = ValidationMessage::$validation_messages["compaign_sent_success"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {
                    $message = ValidationMessage::$validation_messages["compaign_sent_failed"];
                    echo json_encode(array("status" => FALSE, "message" => $message));
                }
            } else {
                $message = ValidationMessage::$validation_messages["uploaded_empty_sheet"];
                echo json_encode(array("status" => FALSE, "message" => $message));
            }
        }
    }

    //Risk & Complaince Module Code Starts Here

    public function risk_complaince(Request $request, $id = "")
    {

        if (array_key_exists($id, session('sublinkNames'))) {

            $navigation = new Navigation();
            if (!empty($id)) {
                $sublinks = $navigation->get_sub_links($id);
            }
            $sublink_name = session('sublinkNames')[$id];
            switch ($id) {

                case 'ryapay-7WRwwggm':
                  
            
                    $businesstype = DB::table('business_type')->get();
                    $businessCategory = DB::table('business_category')->get();
                    $businessSubcategory = DB::table('business_sub_category')->get();
                    $monthlyExpenditure = DB::table('app_option')->where('module', 'merchant_business')->get();
                    $merchant = DB::table('app_option')->where('module', 'merchant_business')->get();

                    return view("employee.riskcomplaince.merchantdocument")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name,
                     "businesstype" => $businesstype, "businesscategory" => $businessCategory, "businesssubcategory" => $businessSubcategory,
                      "monthlyExpenditure" => $monthlyExpenditure]);
                    break;

                case 'ryapay-OXS3k7jc':

                    return view("employee.riskcomplaince.merchantverify")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
                    break;

                case 'ryapay-MMsTfgSk':

                    return view("employee.riskcomplaince.grevience")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
                    break;

                case 'ryapay-Q28dM8vD':

                    return view("employee.riskcomplaince.bannedproducts")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
                    break;
                    
                    case 'merchantadd':
                        // New case code...
                        // You can fetch data or perform any necessary logic here
                        return view("employee.riskcomplaince.merchantadd")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
                
                    // Add more cases as needed...
                
                    default:
                        // Default case if $id doesn't match any existing cases
                        break;

               

                 
            }
        } else {
            return redirect()->back();
        }
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

    public function get_merchant_docs(Request $request, $perPage)
    {
        if ($request->ajax()) {
          
            $merchantObject = new MerchantDocument();
            $document =  $merchantObject->get_merchants_document();
            // dd($document);
            // echo '<pre>';
            // print_r($document);
            // die();
            
            $documents = $this->_arrayPaginator($document, $request, "document", $perPage);
            return View::make("employee.pagination")->with(["module" => "document", "documents" => $documents])->render();
        }

        
    }

    public function get_merchant_docs_detail(Request $request, $id)
    {
        if ($request->ajax()) {
            $merbusiObject = new MerchantBusiness();
            $bussiness_info = $merbusiObject->get_merchant_business_info($id);
            if (!empty($bussiness_info)) {
                $merchantObject = new MerchantDocument();
                $business_type_id = $bussiness_info[0]->business_type_id;
                $documents = $merchantObject->get_docs_by_bustype($business_type_id, $id)[0];
                $folder_name = User::get_merchant_gid($id);
                return view::make("employee.dynamicpage")->with(["module" => "docscreen", "form" => "create", "documents" => $documents, "folder_name" => $folder_name, "business_type_id" => $business_type_id])->render();
            }
        }
    }
    public function show_merchant_docs_status(Request $request, $id)
    {
       
        

         $merchantname = Merchant::find($id);
         

         $merchant = $merchantname['name'];
         
         
$apiUrl = 'https://pg.flakpay.com/fpay/setmerchantConfig';

$curl = curl_init($apiUrl);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPGET, true);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST'); 
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);    

$response = curl_exec($curl);
// dd($response);

$merchants = json_decode($response);

$mid = $merchants->mid; 
// dd($mid);

// $mid ='900004';

        $merbusiObject = new MerchantBusiness();

        $bussiness_info = $merbusiObject->get_merchant_business_info($id);
        $doc_check = [];
        $rnc_details = [];
        if (!empty($bussiness_info)) {
            $merchantObject = new MerchantDocument();
            $doccheckObject = new RyapayDOCCheck();
            $rnccheckObject = new RyapayRncCheck();
            $merchant = new Custom();
            $business_type_id = $bussiness_info[0]->business_type_id;
            $documents = $merchantObject->get_docs_by_bustype($business_type_id, $id);
            $merchant_details = $merchant->get_risk_complaince_merchant_details($id);
            if (!empty($documents) && !empty($merchant_details)) {

                if ($rnccheckObject->check_existing_record($id) == 0 && $doccheckObject->check_existing_record($id) == 0) {
                    foreach (array_merge($documents, $merchant_details) as $index => $variable) {
                        foreach ($variable as $key => $value) {
                            if ($index == 0) {
                                $doc_check[] = [
                                    "merchant_id" => $id,
                                    "doc_name" => $key,
                                    "file_name" => $this->documents_name[$key],
                                    "file_ext" => $value,
                                    "doc_verified" => "N",
                                    "created_date" => $this->datetime,
                                    "created_user" => auth()->guard("employee")->user()->id
                                ];
                            } else {
                                $rnc_details[] = [
                                    "merchant_id" => $id,
                                    "field_name" => $key,
                                    "field_label" => $this->fields_name[$key],
                                    "field_value" => $value,
                                    "field_verified" => "N",
                                    "created_date" => $this->datetime,
                                    "created_user" => auth()->guard("employee")->user()->id
                                ];
                            }
                        }
                    }

                    $rnccheckObject->add_rnccheck($rnc_details);
                    $doccheckObject->add_doccheck($doc_check);
                } else {

                    foreach (array_merge($documents, $merchant_details) as $index => $variable) {
                        foreach ($variable as $key => $value) {
                            if ($index == 0) {
                                $doc_check = [
                                    "file_name" => $this->documents_name[$key],
                                    "file_ext" => $value,
                                ];
                                $where_doccondition["file_ext"] = "";
                                $where_doccondition["doc_name"] = $key;
                                $where_doccondition["merchant_id"] = $id;
                                $doccheckObject->update_bulkdoccheck($where_doccondition, $doc_check);
                            } else {
                                $rnc_details  = [
                                    "field_label" => $this->fields_name[$key],
                                    "field_value" => $value,
                                ];
                                $where_rnccondition["field_name"] = $key;
                                $where_rnccondition["merchant_id"] = $id;
                                $rnccheckObject->update_bulkrnccheck($where_rnccondition, $rnc_details);
                            }
                        }
                    }
                }
                $folder_name = User::get_merchant_gid($id);

                
                $verify_docs =  $doccheckObject->get_docheck($id);
                
                $merchant_info =  $rnccheckObject->get_rnccheck($id);

              
            }
            
        //    // Check if $verify_docs is not null before passing it to the view
        //    if (!isset($verify_docs)) {
        //     $verify_docs = []; // Initialize $verify_docs as an empty array
        // }

        //  // Check if $verify_docs is not null before passing it to the view
        //  if (!isset($folder_name)) {
        //     $folder_name = []; // Initialize $verify_docs as an empty array
        // }
        // // Check if $verify_docs is not null before passing it to the view
        // if (!isset($merchant_info)) {
        //     $merchant_info = []; // Initialize $verify_docs as an empty array
        // }
        
            return view::make("employee.riskcomplaince.addeditmerdocsstat")->with(["module" => "docscreen", 
            "form" => "create", "documents" => $verify_docs, "folder_name" => $folder_name, "business_type_id" => $business_type_id, 
            "merchant_id" => $id, "merchant_details" => $merchant_info,'mid' =>  $mid,'merchant' =>$merchant ])->render();
        }
    }

    public function show_merchant_docs($id)
    {
                
        $merchantname = Merchant::find($id);

 
        $mid = $merchantname['fpay_id'];
         
        $merbusiObject = new MerchantBusiness();

        $bussiness_info = $merbusiObject->get_merchant_business_info($id);   
      
        $doc_check = [];
        $rnc_details = [];
        if (!empty($bussiness_info)) {
            $merchantObject = new MerchantDocument();
            $doccheckObject = new RyapayDOCCheck();
            $rnccheckObject = new RyapayRncCheck();
            $merchant = new Custom();
            $business_type_id = $bussiness_info[0]->business_type_id;
            $documents = $merchantObject->get_docs_by_bustype($business_type_id, $id);
            $merchant_details = $merchant->get_risk_complaince_merchant_details($id);

            if (!empty($documents) && !empty($merchant_details)) {

                if ($rnccheckObject->check_existing_record($id) == 0 && $doccheckObject->check_existing_record($id) == 0) {
                    foreach (array_merge($documents, $merchant_details) as $index => $variable) {
                        foreach ($variable as $key => $value) {
                            if ($index == 0) {
                                $doc_check[] = [
                                    "merchant_id" => $id,
                                    "doc_name" => $key,
                                    "file_name" => $this->documents_name[$key],
                                    "file_ext" => $value,
                                    "doc_verified" => "N",
                                    "created_date" => $this->datetime,
                                    "created_user" => auth()->guard("employee")->user()->id
                                ];
                            } else {
                                $rnc_details[] = [
                                    "merchant_id" => $id,
                                    "field_name" => $key,
                                    "field_label" => $this->fields_name[$key],
                                    "field_value" => $value,
                                    "field_verified" => "N",
                                    "created_date" => $this->datetime,
                                    "created_user" => auth()->guard("employee")->user()->id
                                ];
                            }
                        }
                    }

                    $rnccheckObject->add_rnccheck($rnc_details);
                    $doccheckObject->add_doccheck($doc_check);
                } else {

                    foreach (array_merge($documents, $merchant_details) as $index => $variable) {
                        foreach ($variable as $key => $value) {
                            if ($index == 0) {
                                $doc_check = [
                                    "file_name" => $this->documents_name[$key],
                                    "file_ext" => $value,
                                ];
                                $where_doccondition["file_ext"] = "";
                                $where_doccondition["doc_name"] = $key;
                                $where_doccondition["merchant_id"] = $id;
                                $doccheckObject->update_bulkdoccheck($where_doccondition, $doc_check);
                            } else {
                                $rnc_details  = [
                                    "field_label" => $this->fields_name[$key],
                                    "field_value" => $value,
                                ];
                                $where_rnccondition["field_name"] = $key;
                                $where_rnccondition["merchant_id"] = $id;
                                $rnccheckObject->update_bulkrnccheck($where_rnccondition, $rnc_details);
                            }
                        }
                    }
                }
                $folder_name = User::get_merchant_gid($id);
                $verify_docs =  $doccheckObject->get_docheck($id);
                $merchant_info =  $rnccheckObject->get_rnccheck($id);
            }

            $livemode = DB::table('user_keys')
            ->where('mid', $id)
            ->value('prod_mid');
            
            return view::make("employee.riskcomplaince.viewmerchantdocs")->with(["module" => "docscreen", "form" => "create", "documents" => $verify_docs, "folder_name" => $folder_name, 
            "business_type_id" => $business_type_id, "merchant_id" => $id, "merchant_details" => $merchant_info,'mid' =>  $mid,
            'merchant' =>$merchant,'livemode'=>$livemode  ])->render();
        }
    }

    public function merchant_docs_report(Request $request)
    {
        // dd($request->all());
    $id = $request->merchant_id;

    $merchantnames = Merchant::find($id);

    $merhchantname = $merchantnames->name;

    $isTestMode = $request->mode;
    // dd($isTestMode);

  
    if($isTestMode == 'test'){

        $testapiUrl = "https://pg.flakpay.com/fpay/setmerchantConfig";


        $ch = curl_init($testapiUrl);
    
    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    
    
        $testresponse = curl_exec($ch);
    
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
        curl_close($ch);
    
        $responseData = json_decode($testresponse, true);
    
        $testpostData = [
    
        "mid" => $request->merchant_id,
        "test_mid" =>  $responseData['mid'],
        ];

        $userexits = DB::table('user_keys')->where('mid',$request->merchant_id)->get()->count();

        if(!$userexits){
            DB::table('user_keys')->insert($testpostData);

        }
      
        
        $postData = [
            
            "mid" => $request->mid,
            "mname" => $merhchantname,
            "secret_key" => $request->secretKey,
            "salt_key" => $request->saltKey,
            "checksum_key" => $request->checksumKey,
            "merchant_api_key" => $request->merchant_api_key
        ];

        $apiUrl = "https://pg.flakpay.com/fpay/setmerchantConfig";

        $jsonData = json_encode($postData);

        $ch = curl_init($apiUrl);


        User::where('id',$request->merchant_id)->update(['fpay_id'=>$request->mid]);

        User::where('id',$request->merchant_id)->update(['is_verified'=>'Y']);

        User::where('id',$request->merchant_id)->update(['doc_verified'=>'Y']);

        User::where('id',$request->merchant_id)->update(['change_app_mode'=>'Y']);

        // User::where('id',$request->merchant_id)->update(['documents_upload'=>'Y']);

        
        
        // $appoverdst = DB::table('merchant')->where('id', $request->merchant_id)->get();
       
    



        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData),
        ]);

        $response = curl_exec($ch);
        
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);
        }

if($isTestMode=='live')
{
        
        User::where('id',$request->merchant_id)->update(['app_mode'=>'1']);

        // User::where('id',$request->merchant_id)->update(['documents_upload'=>'Y']);

        User::where('id',$request->merchant_id)->update(['doc_verified'=>'Y']);

        User::where('id',$request->merchant_id)->update(['change_app_mode'=>'Y']);
        
        User::where('id',$request->merchant_id)->update(['is_verified'=>'Y']);

      

        $apiUrl = 'https://paymentgateway.flakpay.com/fpay/setmerchantConfig';

        // Make a cURL request to the API
        $curl = curl_init($apiUrl);
        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPGET, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($curl);
        
        
        curl_close($curl);
        
        $merchants = json_decode($response);
        
        if ($merchants) {
            $livemid = $merchants->mid;

            $userExists = DB::table('user_keys')->where('mid', $request->merchant_id)->get();
            
            if (isset($userExists[0])) {

            $prodid = $userExists[0]->prod_mid;

            if (!$prodid) {

                DB::table('user_keys')
                    ->where('mid', $request->merchant_id)
                    ->update(['prod_mid' => $livemid]);
            }

            }

            // dd($prodid);

           
        } else {
            echo 'Error decoding API response';
            exit;
        }
        

        // $apiUrl = 'https://paymentgateway.flakpay.com/fpay/setmerchantConfig';

        // $curl = curl_init($apiUrl);

        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($curl, CURLOPT_HTTPGET, true);
        // curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST'); 
        // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);    

        // $response = curl_exec($curl);

        // $merchants = json_decode($response);

        // $livemid = $merchants->mid; 
        // dd($mid);

        // function generateRandomKey($prefix) {
        //     $randomBytes = bin2hex(random_bytes(8)); 
        //     return $prefix . $randomBytes;
        // }

        // // Generate keys with prefixes
        // $secretKey = generateRandomKey("sec");  
        // $saltKey = generateRandomKey("sal"); 
        // $checksumKey = generateRandomKey("che"); 
        // $merchant_api_key = generateRandomKey("api"); 


        function generateRandomKey($prefix, $length) {
            // Calculate the number of bytes needed based on the length of the hexadecimal string
            $byteLength = ceil($length / 2);
            // Generate random bytes
            $randomBytes = bin2hex(random_bytes($byteLength)); 
            // Trim the random bytes to the desired length
            $randomBytes = substr($randomBytes, 0, $length);
            // Concatenate the prefix and random bytes
            return $prefix . $randomBytes;
        }
        
        // Generate keys with prefixes and specified lengths
        $secretKey = generateRandomKey("sec", 15);  
        $saltKey = generateRandomKey("sal", 13); 
        $checksumKey = generateRandomKey("che", 16); 
        $merchant_api_key = generateRandomKey("api", 16); 

      
       // Check if the API request has already been made for the current merchant
$apiRequestMade = DB::table('user_keys')->where('mid', $request->merchant_id)->value('api_request_made');

if (!$apiRequestMade) {
    $livepostData = [

        "mid" => $livemid,
        "mname" => $merhchantname,
        "secret_key" =>$secretKey,
        "salt_key" => $saltKey,
        "merchant_api_key" => $merchant_api_key,
        "checksum_key" => $checksumKey
    ];

    $liveapiUrl = "https://paymentgateway.flakpay.com/fpay/setmerchantConfig";

    $livejsonData = json_encode($livepostData);

    $livech = curl_init($liveapiUrl);

    curl_setopt($livech, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($livech, CURLOPT_POST, true);
    curl_setopt($livech, CURLOPT_FOLLOWLOCATION, true);

    curl_setopt($livech, CURLOPT_POSTFIELDS, $livejsonData);
    curl_setopt($livech, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($livech, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($livejsonData),
    ]);

    $liveresponse = curl_exec($livech);

    $statusCode = curl_getinfo($livech, CURLINFO_HTTP_CODE);

    curl_close($livech);

    // Update the database to mark that the API request has been made for this merchant
    DB::table('user_keys')->where('mid', $request->merchant_id)->update(['api_request_made' => true]);
}


        // $livepostData = [

        //     "mid" => $livemid,
        //     "mname" => $merhchantname,
        //     "secret_key" =>$secretKey,
        //     "salt_key" => $saltKey,
        //     "merchant_api_key" => $merchant_api_key,
        //     "checksum_key" => $checksumKey
        // ];
        
        // // dd($livepostData);
        // $liveapiUrl = "https://paymentgateway.flakpay.com/fpay/setmerchantConfig";

        // $livejsonData = json_encode($livepostData);

        // $livech = curl_init($liveapiUrl);
        
        // curl_setopt($livech, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($livech, CURLOPT_POST, true);
        // curl_setopt($livech, CURLOPT_FOLLOWLOCATION, true);

        // curl_setopt($livech, CURLOPT_POSTFIELDS, $livejsonData);
        // curl_setopt($livech, CURLOPT_SSL_VERIFYPEER, false); 
        // curl_setopt($livech, CURLOPT_HTTPHEADER, [  
        //     'Content-Type: application/json',
        //     'Content-Length: ' . strlen($livejsonData),
        // ]);
        
        // $liveresponse = curl_exec($livech);
        // // dd($liveresponse);

        // $statusCode = curl_getinfo($livech, CURLINFO_HTTP_CODE);

        // curl_close($livech);
    
        
        
}
        
        
        if ($request->ajax()) {
            $doccheckObject = new RyapayDOCCheck();
            $merchantObject = new User();
            $merchantDocObject = new MerchantDocument();
            $rnccheckObject = new RyapayRncCheck();
            $where_cond = $request->only('merchant_id');
            $where_cond["doc_verified"] = "N";
            $where_condition = $request->only('merchant_id');
            $where_condition["field_verified"] = "N";
            $docs_info = $doccheckObject->get_corrections_docs($where_cond);
            $details_info = $rnccheckObject->get_corrections_details($where_condition);
            $merchant_id = $request->only('merchant_id');
            $document_uploaded_path = storage_path('app/public/merchant/documents/');

            if (!$docs_info->isEmpty() || !$details_info->isEmpty()) {
                if (!empty($request->email_note)) {
                    $email_note = $request->email_note;
                } else {
                    $email_note = "flakpay team has verified submitted documents and we are letting you know that few documents need correction or submitted wrong so we are requesting you to resubmit the documents which we have mentioned below.";
                }
                $data = array(
                    "from" => env("MAIL_USERNAME", ""),
                    "subject" => "flakpay Activate Your Account Verification Report",
                    "view" => "/maillayouts/documentcorrection",
                    "htmldata" => array(
                        "docHeading" => "Document Vefification Report",
                        "detailHeading" => "Merchant Details Vefification Report",
                        "merchanName" => $merchantObject->get_merchant_info($merchant_id["merchant_id"], "name"),
                        "docMessage" => $email_note,
                        "docs" => $docs_info,
                        "merchant_details" => $details_info,
                        "detail_names" => $this->fields_name,
                        "docsName" => $this->documents_name
                    ),
                );

                $merchant_email = $merchantObject->get_merchant_info($merchant_id["merchant_id"], "email");
                $mail_status = Mail::to($merchant_email)->send(new SendMail($data));

                $update_details = ["documents_upload" => "N", "show_modal" => "Y"];
                $merchantObject->update_docverified_status(["id" => $merchant_id["merchant_id"]], $update_details);
                $document_status = $merchantDocObject->update_documents(["created_merchant" => $merchant_id["merchant_id"]], ["verified_status" => "correction", "doc_verified_by" => auth()->guard("employee")->user()->id]);
                if ($document_status) {
                   
                    DB::table('merchant_document')
                    ->where('created_merchant', $request->merchant_id)
                    ->update(['verified_status' => 'Approved']);
               
                    $message = ValidationMessage::$validation_messages["document_correction_success"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {
                    DB::table('merchant_document')
                    ->where('created_merchant', $request->merchant_id)
                    ->update(['verified_status' => 'Approved']);

                    $message = ValidationMessage::$validation_messages["document_correction_failed"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                }
            } else {
                $update_details = ["doc_verified" => "Y", "show_modal" => "N"];
                if ($merchantObject->update_docverified_status(["id" => $merchant_id["merchant_id"]], $update_details)) {
                    $document_status = $merchantDocObject->update_documents(["created_merchant" => $merchant_id["merchant_id"]], ["verified_status" => "Approved", "doc_verified_by" => auth()->guard("employee")->user()->id]);


                    if ($document_status) {
                        $message = ValidationMessage::$validation_messages["document_approve_success"];
                        echo json_encode(array("status" => TRUE, "message" => $message));
                    } else {
                        $message = ValidationMessage::$validation_messages["document_approve_failed"];
                        echo json_encode(array("status" => TRUE, "message" => $message));
                    }
                }
            }
        }
    }

    public function store_merchant_docs_status(Request $request)
    {
        if ($request->ajax()) {
            $bgcheck = new RyapayBGCheck();
            $bgdata = $request->except('_token');
            $insert_status = $bgcheck->add_background($bgdata);
            if ($insert_status) {
                $message = ValidationMessage::$validation_messages["bgcheck_insert_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["bgcheck_insert_failed"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            }
        }
    }

    public function update_merchant_details_status(Request $request)
    {
        if ($request->ajax()) {
            $doc_status = $request->except("_token");
            $status = $request->details_verified;
            $id = $request->id;
            $detailscheck = new RyapayRncCheck();
            return $detailscheck->update_detailscheck($id, $status);
        }
    }

    public function update_merchant_docs_status(Request $request)
    {
        if ($request->ajax()) {
            $doc_status = $request->except("_token");
            $status = $request->doc_verified;
            $id = $request->id;
            $bgcheck = new RyapayDOCCheck();
            $bgcheck->update_doccheck($id, $status);
        }
    }


    public function merchant_business_details()
    {
        if ($request->ajax()) {
            $merbusiObject = new MerchantBusiness();
            $subcateObject = new BusinessSubCategory();
            $subcategory_options = [];
            $details = [];
            $business_details = $merbusiObject->get_merchant_business_info($id);
            if (!empty($business_details)) {
                $details = $business_details[0];
                $subcategory_options = $subcateObject->get_sel_business_subcategory($business_details[0]->business_category_id);
                return View::make("employee.dynamicpage")->with(["background_verify" => TRUE, "business_details" => $details, "subcategory_options" => $subcategory_options, "form" => "existing_merchant_background"])->render();
            } else {
                return View::make("employee.dynamicpage")->with(["background_verify" => TRUE, "form" => "create"])->render();
            }
        }
    }

    public function get_verified_merchant(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $bgcheck = new RyapayBGCheck();
            $bginfo = $bgcheck->get_background_info();
            $bginfos = $this->_arrayPaginator($bginfo, $request, "bginfo", $perpage);
            return View::make("employee.pagination")->with(["module" => "bginfo", "bginfos" => $bginfos])->render();
        }
    }

    public function merchant_detail(Request $request, $id)
    {
        if ($request->ajax()) {
            $merchantObject = new Custom();
            $merchant_details = $merchantObject->get_risk_complaince_merchant_details($id);
            echo json_encode($merchant_details);
        }
    }

    public function merchant_document_upload(Request $request)
    {
        if ($request->ajax()) {

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

                $documents = [];
                $merchant_gid = User::get_merchant_gid($request->merchant_id);
                $path_to_upload = "/public/merchant/documents/" . $merchant_gid . "/";

                foreach ($request->file() as $key => $value) {
                    $file = $request->file($key);
                    $file_extension = $file->getClientOriginalExtension();
                    $file_name = str_replace("_", "", $key) . "." . $file_extension;
                    $file->storeAs($path_to_upload, $file_name);
                    $documents[$key] = $file_name;
                }

                $ryapay_docscheck = new RyapayDOCCheck();
                $update_status = $ryapay_docscheck->update_bulkdoccheck(["doc_name" => $key, "merchant_id" => $request->merchant_id], ["file_ext" => $documents[$key], "uploaded_user" => auth()->guard("employee")->user()->id]);

                if ($update_status) {
                    $message = ValidationMessage::$validation_messages["merchantdoc_update_success"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {
                    $message = ValidationMessage::$validation_messages["merchantdoc_update_failed"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                }
            }
        }
    }

    public function merchant_document_remove(Request $request)
    {
        if ($request->ajax()) {
            $merchant_gid = User::get_merchant_gid($request->merchant_id);
            $path_to_upload = "/public/merchant/documents/" . $merchant_gid . "/" . str_replace("_", "", $request->file_name);
            if (file_exists($path_to_upload)) {
                unlink($path_to_upload);
            }
            if (!empty($request->id)) {

                $ryapay_docscheck = new RyapayDOCCheck();
                $update_status = $ryapay_docscheck->update_bulkdoccheck(["id" => $request->id, "merchant_id" => $request->merchant_id], ["file_ext" => ""]);

                if ($update_status) {
                    echo json_encode(array("status" => TRUE));
                } else {
                    echo json_encode(array("status" => TRUE));
                }
            }
        }
    }

    public function merchant_extdocument_upload(Request $request)
    {
        if ($request->ajax()) {

            $file_rules = $this->_fileValidationRules($request->file());
            $file_message = $this->_fileValidationMessages($request->file());

            $validate = Validator::make($request->all(), array_merge([
                'merchant_id' => 'required',
                'doc_name' => 'required|array',
                'doc_name.*' => 'required|string|distinct|',
            ], $file_rules), array_merge([
                'comp_gst_doc.required' => 'This field is mandatory',
                'bank_statement.required' => 'This field is mandatory',
                'doc_name.*.required' => 'This field is mandatory',
            ], $file_message));

            if ($validate->fails()) {
                echo json_encode(["status" => FALSE, "error" => $validate->errors()]);
            } else {

                $path_to_upload = "/public/merchant/extradocuments/";
                $post_data = [];
                foreach ($request->file() as $index => $value) {
                    foreach ($value as $key => $value) {
                        $post_data[$key]["merchant_id"] = $request->merchant_id;
                        $file = $request->file($index);
                        $file_extension = $file[$key]->getClientOriginalExtension();
                        $original_name = $file[$key]->getClientOriginalName();
                        $file_name = md5($original_name) . "." . $file_extension;
                        $file[$key]->storeAs($path_to_upload, $file_name);
                        $post_data[$key]["doc_name"] = $request->doc_name[$key];
                        $post_data[$key]["doc_file"] = $file_name;
                        $post_data[$key]["created_user"] = auth()->guard("employee")->user()->id;
                        $post_data[$key]["created_date"] = $this->datetime;
                    }
                }

                $extraDocObject = new MerchantExtraDoc();
                $insert_status = $extraDocObject->add_extra_doc($post_data);
                if ($insert_status) {
                    $message = ValidationMessage::$validation_messages["doc_insert_success"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {
                    $message = ValidationMessage::$validation_messages["doc_insert_failed"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                }
            }
        }
    }

    private function _fileValidationRules($files)
    {
        $rules = [];
        if (isset($files["doc_file"])) {
            for ($i = 0; $i < count($files["doc_file"]); $i++) {
                $rules["doc_file." . $i] = 'required|mimes:pdf,jpg,jpeg|max:5000';
            }
        }
        return $rules;
    }

    private function _fileValidationMessages($files)
    {
        $messages = [];
        if (isset($files["doc_file"])) {
            for ($i = 0; $i < count($files["doc_file"]); $i++) {
                $messages["doc_file." . $i . ".mimes"] = 'The file of type: pdf, jpg, jpeg.';
                $messages["doc_file." . $i . ".required"] = 'The file of type: pdf, jpg, jpeg.';
                $messages["doc_file." . $i . ".max"] = 'File size must be below 5mb.';
            }
        }
        return $messages;
    }

    public function get_merchant_extdocuments(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $extraDocObject = new MerchantExtraDoc();
            $extdocs = $extraDocObject->get_merchant_docs();
            $extdocs_paginate = $this->_arrayPaginator($extdocs, $request, "extdocs", $perpage);
            return View::make("employee.pagination")->with(["module" => "extdoc", "extdocs" => $extdocs_paginate])->render();
        }
    }

    public function get_merchant_extdocument(Request $request, $id)
    {
        $extraDocObject = new MerchantExtraDoc();
        $extdocs = $extraDocObject->get_merchant_docs_list(base64_decode($id));
        $extdocs_paginate = $this->_arrayPaginator($extdocs, $request, "extmdocs", 10);
        return view("employee.riskcomplaince.merchantextdocument")->with(["module" => "extmdoc", "extmdocs" => $extdocs_paginate]);
        //return View::make("employee.pagination")->with(["module"=>"extmdoc","extmdocs"=>$extdocs_paginate])->render();
    }


    public function get_merchant_business_detail(Request $request, $id)
    {
        if ($request->ajax()) {
            $merbusiObject = new MerchantBusiness();
            $subcateObject = new BusinessSubCategory();

            $subcategory_options = [];
            $details = [];
            $business_details = $merbusiObject->get_merchant_business_info($id);
            if (!empty($business_details)) {
                $details = $business_details[0];
                $subcategory_options = $subcateObject->get_sel_business_subcategory($business_details[0]->business_category_id);
                return View::make("employee.dynamicpage")->with(["background_verify" => TRUE, "business_details" => $details, "subcategory_options" => $subcategory_options, "form" => "existing_merchant_background"])->render();
            } else {
                return View::make("employee.dynamicpage")->with(["background_verify" => TRUE, "form" => "create"])->render();
            }
        }
    }

    public function show_merchant_verify(Request $request)
    {
        return view("employee.riskcomplaince.addeditbgcheck")->with("form", "create");
    }

    public function store_merchant_verify(Request $request)
    {
        if ($request->ajax()) {
            $bgcheck = new RyapayBGCheck();
            $bgdata = $request->except('_token');
            $bgdata["created_date"] = $this->datetime;
            $bgdata["created_user"] = auth()->guard("employee")->user()->id;
            $insert_status = $bgcheck->add_background($bgdata);
            if ($insert_status) {
                $message = ValidationMessage::$validation_messages["bgcheck_insert_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["bgcheck_insert_failed"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            }
        }
    }

    public function edit_merchant_verify(Request $request, $id)
    {
        $bgcheck = new RyapayBGCheck();
        $subcateObject = new BusinessSubCategory();
        $subcategory_options = [];
        $edit_data = $bgcheck->edit_background_info($id)[0];
        $subcategory_options = $subcateObject->get_sel_business_subcategory($edit_data->business_category_id);
        return view("employee.riskcomplaince.addeditbgcheck")->with(["form" => "edit", "editdata" => $edit_data, "subcategory_options" => $subcategory_options]);
    }

    public function update_merchant_verify(Request $request)
    {
        if ($request->ajax()) {
            $bgcheck = new RyapayBGCheck();
            $where_cond["id"] = $request->id;
            $where_cond["merchant_id"] = $request->merchant_id;
            $bgdata = $request->except('_token', 'merchant_id', 'id');
            $update_status = $bgcheck->update_background($where_cond, $bgdata);
            if ($update_status) {
                $message = ValidationMessage::$validation_messages["bgcheck_update_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["bgcheck_update_failed"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            }
        }
    }


    public function get_all_cust_cases(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $custcase = new CustomerCase();
            $custcases = $custcase->get_all_cases();
            $paginate_custcases = $this->_arrayPaginator($custcases, $request, "custcase", $perpage);
            return View::make("employee.pagination")->with(["module" => "custcase", "custcases" => $paginate_custcases])->render();
        }
    }

    public function get_case_details(Request $request, $caseid)
    {

        $custcaseObject = new CustomerCase();
        $case_details = $custcaseObject->get_custcase_rupayapay($caseid);

        if (!empty($case_details[0]->id)) {
            return view('employee.riskcomplaince.case')->with(["case_details" => $case_details[0]]);
        } else {
            return redirect()->back();
        }
    }

    public function customer_comment(Request $request)
    {
        if ($request->ajax()) {
            $case_comment = new CaseComment();
            $comment_data = $request->except("_token");
            $comment_data["commented_date"] = $this->datetime;
            $comment_data["user_type"] = 'rockpay';
            $insert_status = $case_comment->add_comment($comment_data);

            if ($insert_status) {
                echo json_encode(array("status" => TRUE, "message" => "Your comment added successfully"));
            } else {
                echo json_encode(array("status" => FALSE, "message" => "Unable to add your comment"));
            }
        }
    }

    public function update_customer_case(Request $request)
    {
        if ($request->ajax()) {
            $case_id = $request->only('id');
            $case_detail = $request->except('_token', 'id');
            $custcaseObject = new CustomerCase();
            $update_status = $custcaseObject->update_case($case_id, $case_detail);
            if ($update_status) {
                $message = ValidationMessage::$validation_messages["ccase_update_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["ccase_update_failed"];
                echo json_encode(array("status" => FALSE, "message" => $message));
            }
        }
    }


    //Risk & Complaince Module Code Ends Here

    public function legal(Request $request, $id = "")
    {
        $navigation = new Navigation();
        if (!empty($id)) {
            $sublinks = $navigation->get_sub_links($id);
        }
        $sublink_name = session('sublinkNames')[$id];
        return view("employee.legal.customercase")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
    }

    public function hrm(Request $request, $id = "")
    {
        $navigation = new Navigation();
        $emp_doc = new EmpDocument();

        if (!empty($id)) {
            $sublinks = $navigation->get_sub_links($id);
        }

        $sublink_name = session('sublinkNames')[$id];
        switch ($id) {
            case 'ryapay-SXuz2t3Z':

                return view("employee.hrm.employeedetail")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
                break;
            case 'ryapay-c7lNqTsO':

                $nda_docs = $emp_doc->get_all_documents("nda");
                return view("employee.hrm.nda")->with(["sublinks" => $sublinks, "nda_docs" => $nda_docs, "sublink_name" => $sublink_name]);
                break;
            case 'ryapay-Mvrucsfy':
                $emp_bvfObject = new EmpBgVerify();
                $bgv_emp_list = $emp_bvfObject->get_emp_bgvstatus();
                return view("employee.hrm.bvf")->with(["sublinks" => $sublinks, "bgv_emp_list" => $bgv_emp_list, "sublink_name" => $sublink_name]);
                break;
            case 'ryapay-NcNaSKMw':

                return view("employee.hrm.empattend")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
                break;
            case 'ryapay-iIBwDDuu':

                return view("employee.hrm.emppayroll")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
                break;
            case 'ryapay-uS4rUYz3':

                return view("employee.hrm.performapprais")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
                break;

            case 'ryapay-aaY5sIe3':
                $ca_docs = $emp_doc->get_all_documents("ca");
                return view("employee.hrm.credagree")->with(["sublinks" => $sublinks, "ca_docs" => $ca_docs, "sublink_name" => $sublink_name]);
                break;

            case 'ryapay-7Cd8CjUY':

                return view("employee.hrm.career")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
                break;
        }
    }

    //HRM User Functionality Starts Here
    public function get_all_employees(Request $request)
    {
        if ($request->ajax()) {
            $employeeObject = new Employee();
            $employees = $employeeObject->get_all_employees();
            return View::make("employee.pagination")->with(["employees" => $employees, "module" => "hrm"])->render();
        }
    }

    public function store_employee(Request $request)
    {
        if ($request->ajax()) {

            $messages = ['employee_username.unique' => 'This username already taken'];

            $validator = Validator::make(
                $request->all(),
                [
                    "employee_username" => ['required', 'string', 'max:50', 'regex:/^[a-zA-Z ]+$/', 'unique:employee'],
                    "mobile_no" => 'required|unique:employee|digits:10|numeric',
                    "department" => 'required',
                    "user_type" => 'required',
                    "first_name" => 'required',
                    "last_name" => 'required',
                    "official_email" => 'required|unique:employee',
                    "personal_email" => 'required',
                    "designation" => 'required',
                    "password" => 'required',
                ],
                $messages
            );

            if ($validator->fails()) {
                echo json_encode(array("status" => FALSE, "errors" => $validator->errors()));
            } else {
                $employeeObject = new Employee();

                $employeeBgvObject = new EmpBgVerify();

                $employee = $request->except("_token");
                $employee["password"] = bcrypt($request->password);
                $employee["created_date"] = $this->datetime;
                $employee["created_user"] = auth()->guard('employee')->user()->id;
                $insert_id =  $employeeObject->add_employee($employee);

                //Background Verification insert data
                $employeebgv["emp_id"] = $insert_id;
                $employeebgv["created_date"] = $this->datetime;
                $employeebgv["created_user"] = auth()->guard('employee')->user()->id;

                $insert_status = $employeeBgvObject->add_emp_bgverify($employeebgv);

                if ($insert_status) {
                    $employee_name = $request->first_name . " " . $request->last_name;
                    GenerateLogs::new_employee_created($employee_name);
                    $message = ValidationMessage::$validation_messages["employee_insert_success"];
                    echo json_encode(array("status" => TRUE, "message" => $message));
                } else {
                    $message = ValidationMessage::$validation_messages["employee_insert_failed"];
                    echo json_encode(array("status" => FALSE, "message" => $message));
                }
            }
        }
    }

    public function edit_employee(Request $request, $id)
    {
        $employeeObject = new Employee();
        $employees_details = $employeeObject->get_employee_details($id);
        return view("employee.hrm.editemployee")->with("details", $employees_details);
    }

    public function update_employee(Request $request)
    {
        if ($request->ajax()) {
            $where_array = $request->only("id");
            $update_array = $request->except("_token", "id");
            $employeeObject = new Employee();
            $update_status = $employeeObject->update_employee_details($update_array, $where_array);
            if ($update_status) {
                $message = ValidationMessage::$validation_messages["employee_update_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["employee_update_failed"];
                echo json_encode(array("status" => FALSE, "message" => $message));
            }
        }
    }

    public function delete_employee(Request $request)
    {
        if ($request->ajax()) {
            $where_array = $request->only("id");
            $update_array = $request->except("_token", "id");
            $update_array["employee_status"] = "inactive";
            $employeeObject = new Employee();
            $update_status = $employeeObject->update_employee_details($update_array, $where_array);
            if ($update_status) {
                $message = ValidationMessage::$validation_messages["employee_delete_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["employee_delete_failed"];
                echo json_encode(array("status" => FALSE, "message" => $message));
            }
        }
    }

    public function store_personal(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "first_name" => "required",
            "last_name" => "required",
            "rel_first_name" => "required",
            "rel_last_name" => "required",
            "dob" => "required",
            "gender" => "required",
            "pan_no" => "required"
        ], [
            'rel_first_name.required' => 'Father/Husbands first name field is required',
            'rel_last_name.required' => 'Father/Husbands last name field is required',
            'dob.required' => 'Date of birth field is required'
        ]);

        if ($validator->fails()) {
            echo json_encode(["status" => FALSE, "errors" => $validator->errors()]);
        } else {

            $empObject = new EmpDetail();
            $personal_details = $request->except("_token");
            $personal_details["dob"] = date("Y-m-d", strtotime($request->dob . "00:00:00"));
            $personal_details["created_date"] = $this->datetime;
            $personal_details["created_user"] = auth()->guard('employee')->user()->id;


            $insert_status = $empObject->add_emp_details($personal_details);
            if ($insert_status) {
                $message = ValidationMessage::$validation_messages["Details_insert_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["Details_insert_failed"];
                echo json_encode(array("status" => FALSE, "message" => $message));
            }
        }
    }

    public function store_contact_details(Request $request)
    {

        if ($request->ajax()) {
            $empObject = new EmpContactDetail();
            foreach ($request->house_no as $key => $value) {
                $contact_details[$key]["employee_id"] = $request->employee_id;
                $contact_details[$key]["house_no"] = $value;
                $contact_details[$key]["street_name"] = $request->street_name[$key];
                $contact_details[$key]["area"] = $request->area[$key];
                $contact_details[$key]["city"] = $request->city[$key];
                $contact_details[$key]["district"] = $request->district[$key];
                $contact_details[$key]["state"] = $request->state[$key];
                $contact_details[$key]["pincode"] = $request->pincode[$key];
                $contact_details[$key]["nationality"] = $request->nationality[$key];
                $contact_details[$key]["phone_no"] = $request->phone_no[$key];
                $contact_details[$key]["primary_email"] = $request->primary_email[$key];
                $contact_details[$key]["land_line"] = ($key == 1) ? $request->land_line[0] : "";
                $contact_details[$key]["secondary_email"] = ($key == 1) ? $request->secondary_email[0] : "";
                $contact_details[$key]["is_address"] = $request->is_address[$key];
                $contact_details[$key]["created_date"] = $this->datetime;
                $contact_details[$key]["created_user"] = auth()->guard('employee')->user()->id;
            }

            $insert_status = $empObject->add_emp_contact_detail($contact_details);
            if ($insert_status) {
                $message = ValidationMessage::$validation_messages["ContactDetails_insert_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["ContactDetails_insert_failed"];
                echo json_encode(array("status" => FALSE, "message" => $message));
            }
        }
    }

    public function store_reference_details(Request $request)
    {
        if ($request->ajax()) {
            $referance_details = array();
            foreach ($request->ref_name as $key => $value) {
                $referance_details[$key]["employee_id"] = $request->employee_id;
                $referance_details[$key]["ref_name"] = $value;
                $referance_details[$key]["ref_designation"] = $request->ref_designation[$key];
                $referance_details[$key]["ref_company"] = $request->ref_company[$key];
                $referance_details[$key]["ref_mobile_no"] = $request->ref_mobile_no[$key];
                $referance_details[$key]["ref_capacity"] = $request->ref_capacity[$key];
                $referance_details[$key]["created_date"] = $this->datetime;
                $referance_details[$key]["created_user"] = auth()->guard('employee')->user()->id;
            }
            $referenceObject = new EmpReference();
            $insert_status = $referenceObject->add_emp_reference($referance_details);
            if ($insert_status) {
                $message = ValidationMessage::$validation_messages["reference_insert_success"];
                echo json_encode(array("status" => TRUE, "message" => $message));
            } else {
                $message = ValidationMessage::$validation_messages["reference_insert_failed"];
                echo json_encode(array("status" => FALSE, "message" => $message));
            }
        }
    }

    public function get_employee_nda_doc(Request $request, $id)
    {
        if ($request->ajax()) {
            $get_doc = array();
            $emp_doc = new EmpDocument();
            $get_doc = $emp_doc->get_employee_nda_document($id);
            if (!empty($get_doc)) {
                $doc_id = $get_doc[0]->id;
                return View::make("downloadlayouts.employee.download")->with(["doc_id" => $doc_id, "downloadfile" => $get_doc[0]->employee_docs, "module" => "nda"])->render();
            } else {
                return View::make("downloadlayouts.employee.download")->with(["doc_id" => "", "downloadfile" => "", "module" => "nda"])->render();
            }
        }
    }



    public function get_employee_ca_doc(Request $request, $id)
    {
        if ($request->ajax()) {
            $get_doc = array();
            $emp_doc = new EmpDocument();
            $get_doc = $emp_doc->get_employee_ca_document($id);
            if (!empty($get_doc)) {
                $doc_id = $get_doc[0]->id;
                return View::make("downloadlayouts.employee.download")->with(["doc_id" => $doc_id, "downloadfile" => $get_doc[0]->employee_docs, "module" => "ca"])->render();
            } else {
                return View::make("downloadlayouts.employee.download")->with(["doc_id" => "", "downloadfile" => "", "module" => "ca"])->render();
            }
        }
    }

    public function upload_nda_form(Request $request)
    {
        if ($request->ajax()) {
            $validate = Validator::make($request->all(), [
                'nda_doc' => 'required|file',
            ]);

            if ($validate->fails()) {
                echo json_encode(["status" => FALSE, "error" => $validate->errors()]);
            } else {

                $emp_doc = new EmpDocument();

                $get_doc = $emp_doc->get_employee_nda_document($request->employee_id);
                $path_to_upload = "/public/rockpay/documents/nda";

                if (!empty($get_doc)) {
                    $file_path = $get_doc[0]->employee_docs;
                    Storage::delete($path_to_upload . $file_path);
                }


                $files = Storage::files($path_to_upload);
                $filearray = array();
                foreach ($request->file() as $key => $value) {

                    $file = $request->file($key);
                    $file_extension = $file->getClientOriginalExtension();
                    $file_name = $request->employee_name . "_NDA" . time() . "." . $file_extension;
                    $file->storeAs($path_to_upload, $file_name);
                    $filearray["employee_docs"] = $file_name;
                }
                $filearray["employee_id"] = $request->employee_id;

                if (isset($request->id)) {
                    $where_condition = $request->only("id");
                    $update_status = $emp_doc->update_employee_document($where_condition, $filearray);

                    if ($update_status) {
                        $message = ValidationMessage::$validation_messages["nda_update_success"];
                        echo json_encode(array("status" => TRUE, "message" => $message));
                    } else {
                        $message = ValidationMessage::$validation_messages["nda_update_failed"];
                        echo json_encode(array("status" => FALSE, "message" => $message));
                    }
                } else {

                    $filearray["doc_belongs_to"] = "nda";
                    $filearray["created_date"] = $this->datetime;
                    $filearray["created_user"] = auth()->guard('employee')->user()->id;
                    $upload_status = $emp_doc->upload_employee_document($filearray);

                    if ($upload_status) {
                        $message = ValidationMessage::$validation_messages["nda_upload_success"];
                        echo json_encode(array("status" => TRUE, "message" => $message));
                    } else {
                        $message = ValidationMessage::$validation_messages["nda_upload_failed"];
                        echo json_encode(array("status" => FALSE, "message" => $message));
                    }
                }
            }
        }
    }

    public function upload_ca_form(Request $request)
    {
        if ($request->ajax()) {
            $validate = Validator::make($request->all(), [
                'ca_doc' => 'required|file',
            ]);

            if ($validate->fails()) {
                echo json_encode(["status" => FALSE, "error" => $validate->errors()]);
            } else {

                $emp_doc = new EmpDocument();

                $get_doc = $emp_doc->get_employee_ca_document($request->employee_id);

                if (!empty($get_doc)) {
                    $file_path = $get_doc[0]->employee_docs;
                    Storage::delete('/public/rockpay/documents/ca/' . $file_path);
                }

                $path_to_upload = "/public/rockpay/documents/ca";
                $files = Storage::files($path_to_upload);
                $filearray = array();
                foreach ($request->file() as $key => $value) {

                    $file = $request->file($key);
                    $file_extension = $file->getClientOriginalExtension();
                    $file_name = $request->employee_name . "_CONA" . time() . "." . $file_extension;
                    $file->storeAs($path_to_upload, $file_name);
                    $filearray["employee_docs"] = $file_name;
                }
                $filearray["employee_id"] = $request->employee_id;

                if (isset($request->id)) {
                    $where_condition = $request->only("id");
                    $update_status = $emp_doc->update_employee_document($where_condition, $filearray);

                    if ($update_status) {
                        $message = ValidationMessage::$validation_messages["ca_update_success"];
                        echo json_encode(array("status" => TRUE, "message" => $message));
                    } else {
                        $message = ValidationMessage::$validation_messages["ca_update_failed"];
                        echo json_encode(array("status" => FALSE, "message" => $message));
                    }
                } else {

                    $filearray["doc_belongs_to"] = "ca";
                    $filearray["created_date"] = $this->datetime;
                    $filearray["created_user"] = auth()->guard('employee')->user()->id;
                    $upload_status = $emp_doc->upload_employee_document($filearray);

                    if ($upload_status) {
                        $message = ValidationMessage::$validation_messages["ca_upload_success"];
                        echo json_encode(array("status" => TRUE, "message" => $message));
                    } else {
                        $message = ValidationMessage::$validation_messages["ca_upload_failed"];
                        echo json_encode(array("status" => FALSE, "message" => $message));
                    }
                }
            }
        }
    }

    public function emp_payslip()
    {
        return view("employee.hrm.payslip");
    }

    public function edit_payslip(Request $request, $id)
    {

        $payslipObject = new EmpPayslip();
        $editpayslip = $payslipObject->get_employee_payslip($id);
        $employee_details = array();
        $earn_deduct =  array();
        foreach ($editpayslip as $key => $value) {
            $employee_details["id"] = $value->id;
            $employee_details["employee_id"] = $value->employee_id;
            $employee_details["full_name"] = $value->full_name;
            $employee_details["designation"] = $value->designation;
            $employee_details["payslip_month"] = $value->payslip_month;
            $employee_details["total_addition"] = $value->total_addition;
            $employee_details["total_deduction"] = $value->total_deduction;
            $employee_details["net_salary"] = $value->net_salary;
            $employee_details["check_number"] = $value->check_number;
            $employee_details["bank_name"] = $value->bank_name;
            $employee_details["payslip_gdate"] = $value->payslip_gdate;
            $employee_details["employee_sign"] = $value->employee_sign;
            $employee_details["director_sign"] = $value->director_sign;
            $earn_deduct[$key]["element_id"] = $value->element_id;
            $earn_deduct[$key]["element_type"] = $value->element_type;
            $earn_deduct[$key]["element_value"] = $value->element_value;
        }
        return view("employee.hrm.payslip")->with(["details" => $employee_details, "earn_deduct" => $earn_deduct, "form" => "edit"]);
    }

    public function emp_payslip_from(Request $request, $id)
    {

        $employeeObject = new Employee();
        $employee = $employeeObject->get_employee_details($id);
        $payslip_elements = PayslipElement::get_payslip_elements();

        echo json_encode(["employee" => $employee, "payslip" => $payslip_elements]);
    }

    public function get_payslip(Request $request)
    {
        if ($request->ajax()) {
            $payslipObject = new EmpPayslip();

            $paysliplist = $payslipObject->get_payslip();

            $pagination = $this->_arrayPaginator($paysliplist, $request, "paysliplist");

            return View::make("employee.pagination")->with(["module" => "paysliplist", "paysliplists" => $pagination])->render();
        }
    }


    public function store_payslip(Request $request)
    {
        if ($request->ajax()) {
            $earn_deduct = array();
            $element_count = 0;
            $element_deductcount = 0;
            $payslip_earn_deduct = $request->only("emp_earning", "earning", "emp_deduction", "deduction");
            $payslip_data = $request->except("_token", "emp_earning", "earning", "emp_deduction", "deduction");

            $payslipObject = new EmpPayslip();
            $earndeductObjet = new EmpEarnDeduct();

            $payslip_data["payslip_gdate"] = date("Y-m-d", strtotime($request->payslip_gdate));
            $payslip_data["created_date"] = $this->datetime;
            $payslip_data["created_user"] = auth()->guard('employee')->user()->id;
            $payslip_id = $payslipObject->add_payslip($payslip_data);

            foreach ($payslip_earn_deduct["emp_earning"] as $key => $value) {

                $earn_deduct[$element_count]["emp_payslip_id"] = $payslip_id;
                $earn_deduct[$element_count]["element_id"] = $payslip_earn_deduct["emp_earning"][$key];
                $earn_deduct[$element_count]["element_value"] = $payslip_earn_deduct["earning"][$key];
                $earn_deduct[$element_count]["created_date"] = $this->datetime;
                ++$element_count;
            }
            foreach ($payslip_earn_deduct["emp_deduction"] as $key => $value) {


                $earn_deduct[$element_count]["emp_payslip_id"] = $payslip_id;
                $earn_deduct[$element_count]["element_id"] = $payslip_earn_deduct["emp_deduction"][$key];
                $earn_deduct[$element_count]["element_value"] = $payslip_earn_deduct["deduction"][$key];
                $earn_deduct[$element_count]["created_date"] = $this->datetime;
                ++$element_count;
            }

            $insert_status = $earndeductObjet->add_emp_earn_deduct($earn_deduct);

            if ($insert_status) {
                $message = ValidationMessage::$validation_messages["payslip_insert_success"];
                echo json_encode(["status" => TRUE, "message" => $message]);
            } else {
                $message = ValidationMessage::$validation_messages["payslip_insert_failed"];
                echo json_encode(["status" => FALSE, "message" => $message]);
            }
        }
    }

    public function get_job(Request $request, $Perpage)
    {
        if ($request->ajax()) {
            $careerObject = new RyapayCareer();
            $jobs = $careerObject->get_jobs();
            $paginate_job = $this->_arrayPaginator($jobs, $request, "jobs", $Perpage);
            return View::make('employee.pagination')->with(["module" => "job", "jobs" => $paginate_job])->render();
        }
    }

    public function store_job(Request $request)
    {
        if ($request->ajax()) {
            $jobdata = $request->except("_token");
            $jobdata["created_date"] = $this->datetime;
            $jobdata["created_user"] = auth()->guard('employee')->user()->id;

            $careerObject = new RyapayCareer();
            $insert_status = $careerObject->add_job($jobdata);

            if ($insert_status) {
                $message = ValidationMessage::$validation_messages["postjob_insert_success"];
                echo json_encode(["status" => TRUE, "message" => $message]);
            } else {
                $message = ValidationMessage::$validation_messages["postjob_insert_failed"];
                echo json_encode(["status" => FALSE, "message" => $message]);
            }
        }
    }

    public function edit_job(Request $request, $id)
    {
        if ($request->ajax()) {
            $careerObject = new RyapayCareer();
            $jobdetails = $careerObject->get_job($id);
            echo json_encode($jobdetails);
        }
    }

    public function update_job(Request $request)
    {
        if ($request->ajax()) {
            $jobid = $request->only("id");
            $jobdata = $request->except("_token", "id");
            $careerObject = new RyapayCareer();
            $update_status = $careerObject->update_job($jobid, $jobdata);

            if ($update_status) {
                $message = ValidationMessage::$validation_messages["postjob_update_success"];
                echo json_encode(["status" => TRUE, "message" => $message]);
            } else {
                $message = ValidationMessage::$validation_messages["postjob_update_failed"];
                echo json_encode(["status" => FALSE, "message" => $message]);
            }
        }
    }

    public function update_job_status(Request $request)
    {
        if ($request->ajax()) {
            $jobid = $request->only("id");
            $jobdata = $request->except("_token", "id");
            $careerObject = new RyapayCareer();
            $update_status = $careerObject->update_job($jobid, $jobdata);
            if ($update_status) {
                $message = ValidationMessage::$validation_messages["postjob_update_success"];
                echo json_encode(["status" => TRUE, "message" => $message]);
            } else {
                $message = ValidationMessage::$validation_messages["postjob_update_failed"];
                echo json_encode(["status" => FALSE, "message" => $message]);
            }
        }
    }

    public function get_applicants(Request $request, $Perpage)
    {
        if ($request->ajax()) {
            $applicantObject = new RyapayApplicant();
            $applicants = $applicantObject->get_applicants();
            $paginate_applicant = $this->_arrayPaginator($applicants, $request, "applicant", $Perpage);
            return View::make('employee.pagination')->with(["module" => "applicant", "applicants" => $paginate_applicant])->render();
        }
    }

    public function update_applicant_status(Request $request)
    {
        if ($request->ajax()) {
            $applicant_id = $request->only("id");
            $applicant_data = $request->except("_token");
            $applicantObject = new RyapayApplicant();
            $update_status = $applicantObject->update_applicant($applicant_id, $applicant_data);
            if ($update_status) {
                $message = ValidationMessage::$validation_messages["applicant_update_success"];
                echo json_encode(["status" => TRUE, "message" => $message]);
            } else {
                $message = ValidationMessage::$validation_messages["applicant_update_failed"];
                echo json_encode(["status" => FALSE, "message" => $message]);
            }
        }
    }

    //HRM User Functionality Ends Here

    //My Account Sub Module Code Starts Here

    public function my_account(Request $request)
    {

        $emp_details = new Employee();
        $id = auth()->guard('employee')->user()->id;
        $detail =  $emp_details->get_employee_details($id);

        return view("employee.myaccount", ["detail" => $detail]);
    }

    public function update_mydetails(Request $request)
    {

        $rules = [
            "first_name" => "required",
            "last_name" => "required",
            "personal_email" => "required"
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        } else {

            $my_profile = [
                "first_name" => $request->first_name,
                "last_name" => $request->last_name,
                "personal_email" => $request->personal_email,
            ];
            $emp_details = new Employee();
            $update_status =  $emp_details->update_my_details($my_profile, Auth::guard("employee")->user()->id);
            if ($update_status) {
                $message = ValidationMessage::$validation_messages["myprofile_update_success"];
                return redirect()->back()->with(["message" => $message]);
            } else {
                $message = ValidationMessage::$validation_messages["myprofile_update_failed"];
                return redirect()->back()->with(["message" => $message]);
            }
        }
    }

    public function request_password_change(Request $request)
    {
        $empObject = auth()->guard('employee')->user();
        $emailOTP = mt_rand(99999, 999999);
        session(["ryapayemailOTP" => $emailOTP]);

        $data = array(
            "from" => env("MAIL_USERNAME", ""),
            "subject" => "Password Change Request",
            "view" => "/maillayouts/ryapaychangepass",
            "htmldata" => array(
                "name" => $empObject->first_name . " " . $empObject->last_name,
                "emailOTP" => $emailOTP,
            ),
        );

        $mail_status = Mail::to($empObject->official_email)->send(new SendMail($data));
        $message = ValidationMessage::$validation_messages["password_change_mail_success"];
        return redirect()->back()->with(["page-active" => "active", "message" => $message, "email-form" => TRUE]);
    }

    public function verify_emailOTP(Request $request)
    {

        $empObject = auth()->guard('employee')->user();
        if (session("ryapayemailOTP") == $request->ryapayemailOTP) {
            $request->session()->forget('ryapayemailOTP');
            if ($empObject->user_type != 1) {
                return redirect()->back()->with(["page-active" => "active", "password-form" => TRUE]);
            } else {

                $mobileOTP = mt_rand(99999, 999999);

                session(["ryapaymobileOTP" => $mobileOTP]);

                $number = $empObject->mobile_no;

                $message = "Hi " . $empObject->first_name . " " . $empObject->last_name . ", Use this OTP " . $mobileOTP . " for changing flakpay account password. -flakpay";

                $sms =  new SmsController($message, $number, "1307164793075795400");
                $sms->sendMessage();
                $message = ValidationMessage::$validation_messages["mobile_message_sent"];
                return redirect()->back()->with(["page-active" => "active", "message" => $message, "mobile-form" => TRUE]);
            }
        } else {
            $message = ValidationMessage::$validation_messages["wrong_OTP"];
            return redirect()->back()->with(["page-active" => "active", "message" => $message, "email-status" => TRUE]);
        }
    }

    public function verify_mobileOTP(Request $request)
    {

        $empObject = auth()->guard('employee')->user();
        if (session("ryapaymobileOTP") == $request->ryapaymobileOTP) {
            $request->session()->forget('ryapayemailOTP');
            return redirect()->back()->with(["page-active" => "active", "password-form" => TRUE]);
        } else {
            $message = ValidationMessage::$validation_messages["wrong_OTP"];
            return redirect()->back()->with(["page-active" => "active", "message" => $message, "mobile-form" => TRUE]);
        }
    }

    public function change_password(Request $request)
    {

        $data = $request->except("_token");
        $rules = [
            "current_password" => "required",
            "password" => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'],
        ];
        $messages = ['password.regex' => 'Password should contain at-least 1 Uppercase,1 Lowercase,1 Numeric & 1 Special character)'];
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->with(["page-active" => "active", "errors" => $validator->errors(), "password-form" => TRUE]);
        } else {

            $empObject = auth()->guard('employee')->user();
            $hashedPassword = $empObject->password;
            $employee = [];
            $employeeObject =  new Employee();
            if (Hash::check($request->current_password, $hashedPassword)) {

                $employee["password"] = bcrypt($request->password);
                $update_status = $employeeObject->update_my_details($employee);

                if ($update_status) {
                    $message = ValidationMessage::$validation_messages["password_update_success"];
                    return redirect()->back()->with(["page-active" => "active", "message" => $message, "password-form-success" => TRUE, "password-form" => FALSE]);
                } else {
                    $message = ValidationMessage::$validation_messages["password_update_failed"];
                    return redirect()->back()->with(["page-active" => "active", "message" => $message, "password-form-failed" => TRUE, "password-form" => FALSE]);
                }
            } else {

                $message = ValidationMessage::$validation_messages["wrong_current_password"];
                return redirect()->back()->with(["page-active" => "active", "message" => $message, "password-form" => TRUE, "password-form-failed" => TRUE]);
            }
        }
    }

    //Work Status Functionality starts here

    public function show_workstatus()
    {
        return View::make('employee.workstatus.workstatus');
    }

    public function get_workstatus(Request $request, $Perpage)
    {
        if ($request->ajax()) {
            $workstatusObject = new EmpWorkStatus();
            $workstatuses = $workstatusObject->get_work_status(auth()->guard("employee")->user()->id);
            $paginate_workstatus = $this->_arrayPaginator($workstatuses, $request, "workstatus", $Perpage);
            return View::make('employee.pagination')->with(["module" => "workstatus", "workstatuses" => $paginate_workstatus])->render();
        }
    }

    public function store_workstatus(Request $request)
    {
        if ($request->ajax()) {

            $rules = [
                "today_date" => "required",
                "today_work" => "required|string",
                "nextday_work" => "required|string",
            ];

            $messages = [
                "today_date.required" => "Work date is mandatory",
                "today_work.required" => "Work date is mandatory",
                "nextday_work.required" => "Tomorrow Task is mandatory",
            ];


            $validate = Validator::make($request->all(), $rules, $messages);

            if ($validate->fails()) {
                echo json_encode(["status" => FALSE, "errors" => $validate->errors()]);
            } else {
                $workstatusObject = new EmpWorkStatus();
                $workstatus = $request->except("_token");
                $workstatus["created_date"] = $this->datetime;
                $workstatus["created_user"] = auth()->guard('employee')->user()->id;
                $insert_status = $workstatusObject->add_work_status($workstatus);
                if ($insert_status) {
                    $message = ValidationMessage::$validation_messages["workstatus_insert_success"];
                    echo json_encode(["status" => TRUE, "message" => $message]);
                } else {
                    $message = ValidationMessage::$validation_messages["workstatus_insert_failed"];
                    echo json_encode(["status" => FALSE, "message" => $message]);
                }
            }
        }
    }

    public function edit_workstatus(Request $request, $id)
    {
        if ($request->ajax()) {
            $workstatusObject = new EmpWorkStatus();
            $workstatus = $workstatusObject->get_work_info($id);
            echo json_encode($workstatus);
        }
    }

    public function update_workstatus(Request $request)
    {
        if ($request->ajax()) {

            $rules = [
                "today_date" => "required",
                "today_work" => "required|string",
                "nextday_work" => "required|string",
            ];

            $messages = [
                "today_date.required" => "Work date is mandatory",
                "today_work.required" => "Work date is mandatory",
                "nextday_work.required" => "Tomorrow Task is mandatory",
            ];


            $validate = Validator::make($request->all(), $rules, $messages);

            if ($validate->fails()) {
                echo json_encode(["status" => FALSE, "errors" => $validate->errors()]);
            } else {
                $workstatusObject = new EmpWorkStatus();
                $record_id = $request->only("id");
                $workstatus = $request->except("_token", "id");
                $workstatus["modified_date"] = $this->datetime;
                $update_status = $workstatusObject->update_work_status($record_id, $workstatus);
                if ($update_status) {
                    $message = ValidationMessage::$validation_messages["workstatus_update_success"];
                    echo json_encode(["status" => TRUE, "message" => $message]);
                } else {
                    $message = ValidationMessage::$validation_messages["workstatus_update_failed"];
                    echo json_encode(["status" => FALSE, "message" => $message]);
                }
            }
        }
    }
    //Work Status Functionality ends here


    public function login_activities(Request $request)
    {
        if ($request->ajax()) {
            $log_activities = new EmployeeLogActivity();
            $login_log = $log_activities->get_employee_log();
            $loginactivities_pagination = $this->_arrayPaginator($login_log, $request, "loginactivity");
            return View::make("employee.pagination")->with(["module" => "loginactivity", "loginactivities" => $loginactivities_pagination])->render();
        }
    }




    //My Account Sub Module Code Ends Here


    public function admin_merchant(Request $request, $id)
    {

        $navigation = new Navigation();
        $emp_doc = new EmpDocument();

        if (!empty($id)) {
            $sublinks = $navigation->get_sub_links($id);
        }

        $sublink_name = session('sublinkNames')[$id];
        switch ($id) {

            case 'ryapay-Ma42px1Z':

                $merchants = User::join('merchant_business', 'merchant_business.created_merchant', '=', 'merchant.id')
                ->select('merchant.id', 'merchant_business.business_name')->where('merchant.app_mode',1)
                ->get();

                return view("employee.merchant.transactions")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name,"merchantname"=>$merchants]);
                break;

            case 'ryapay-7xnYf8Yy':

                return view("employee.merchant.transmethods")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
                break;

            case 'ryapay-G6VFQPKr':

                return view("employee.merchant.details")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
                break;

            case 'ryapay-VnUZJTRX':

                return view("employee.merchant.routes")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
                break;
            case 'ryapay-VwAPGcs2':

                return view("employee.merchant.cases")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
                break;

            case 'ryapay-cw1kdlTJ':

                return view("employee.merchant.adjustments")->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
                break;
        }
    }

    public function no_of_transactions(Request $request)
    {


        if ($request->ajax()) {
            $user = new User();

            if (empty($request->trans_from_date) && empty($request->trans_to_date)) {

                $from_date = date('Y-m-d');
                $to_date = date('Y-m-d');

                $no_of_transactions = $user->get_merchant_transactions($from_date, $to_date);
                // dd( $no_of_transactions);
            } else {

                $from_date = $request->trans_from_date;
                $to_date = $request->trans_to_date;

                $no_of_transactions = $user->get_merchant_transactions($from_date, $to_date);
            }
            if ($request->mode == 'live') {
                // Select data from the live table
                $data = 'payin_transactions';
            }else{
                // Select data from the test table
                $data ='test_payintransactions';
            } 



            $trans_pagination_list = DB::table($data)
            ->select('merchant_id','email','mobile_no','customer_name', DB::raw('count(*) as merchant_count'))
            ->groupBy('merchant_id')
            ->get()
            ->toArray();
        

            $trans_pagination = $this->_arrayPaginator($trans_pagination_list, $request, "nooftransaction");

            // return View::make("employee.pagination")->with(["module" => "nooftransaction", "nooftransactions" => $trans_pagination])->render();
            // return view("employee.pagination")->with(["module" => "nooftransaction", "nooftransactions" => $trans_pagination]);
            return View::make("employee.pagination")->with(["module" => "nooftransaction", "nooftransactions" => $trans_pagination])->render();
        }
    }

    public function no_of_transactionsList(Request $request)
    {

        if ($request->mode == 'live') {
            
            $data = 'payin_transactions';
            $userkey ='prod_mid';
        } else {
            
            $data ='test_payintransactions';
            $userkey ='test_mid';
        } 
        
        $trans_pagination_list = DB::table($data)
           ->leftJoin('user_keys', 'user_keys.'. $userkey, '=', $data .'.merchant_id')
            ->leftJoin('merchant', 'merchant.id', '=', 'user_keys.mid')
            ->select("$data.merchant_id", 'merchant.email', 'merchant.mobile_no', 'merchant.name', DB::raw('count(*) as merchant_count'))
            ->groupBy("$data.merchant_id", 'merchant.email', 'merchant.mobile_no', 'merchant.name')
            ->get();

            return DataTables::of($trans_pagination_list)


            ->make(true);

    }

    public function transaction_amountList(Request $request)
    {

            if ($request->mode == 'live') {
                $userkey ='prod_mid';
                $data = 'payin_transactions';
            }else{
              
                $data ='test_payintransactions';
                $userkey ='test_mid';
            } 

            $trans_pagination_amount= DB::table($data)
            ->leftJoin('user_keys', 'user_keys.'. $userkey, '=', $data .'.merchant_id')
            ->leftJoin('merchant', 'merchant.id', '=', 'user_keys.mid')
            ->select("$data.merchant_id", 'merchant.email', 'merchant.mobile_no', 'merchant.name', DB::raw('sum(amount) as merchant_sum'))
            ->groupBy("$data.merchant_id", 'merchant.email', 'merchant.mobile_no', 'merchant.name')
            ->get();
            // ->toArray(); 

            return DataTables::of($trans_pagination_amount)


            ->make(true);
    

    }

    public function no_of_paylinks(Request $request)
    {

        if ($request->ajax()) {
            $paylink = new Paylink();

            // if(empty($request->trans_from_date) && empty($request->trans_to_date)){

            //     $from_date = date('Y-m-d');
            //     $to_date = date('Y-m-d');

            //     $no_of_transactions = $user->get_merchant_transactions($from_date,$to_date);

            // }else{

            //     $from_date = $request->trans_from_date;
            //     $to_date = $request->trans_to_date;

            //     $no_of_transactions = $user->get_merchant_transactions($from_date,$to_date);
            // }
            $no_of_paylinks = $paylink->get_merchant_paylinks();
            $paylinks_pagination = $this->_arrayPaginator($no_of_paylinks, $request, "noofpaylink");

            return View::make("employee.pagination")->with(["module" => "noofpaylink", "noofpaylinks" => $paylinks_pagination])->render();
        }
    }

    public function no_of_invoices(Request $request)
    {

        if ($request->ajax()) {
            $invoice = new Invoice();

            // if(empty($request->trans_from_date) && empty($request->trans_to_date)){

            //     $from_date = date('Y-m-d');
            //     $to_date = date('Y-m-d');

            //     $no_of_transactions = $user->get_merchant_transactions($from_date,$to_date);

            // }else{

            //     $from_date = $request->trans_from_date;
            //     $to_date = $request->trans_to_date;

            //     $no_of_transactions = $user->get_merchant_transactions($from_date,$to_date);
            // }
            $no_of_invoices = $invoice->get_merchant_invoices();
            $invoices_pagination = $this->_arrayPaginator($no_of_invoices, $request, "noofinvoice");

            return View::make("employee.pagination")->with(["module" => "noofinvoice", "noofinvoices" => $invoices_pagination])->render();
        }
    }


    public function transaction_amount(Request $request)
    {
        if ($request->ajax()) {
            $user = new User();


            if (empty($request->trans_from_date) && empty($request->trans_to_date)) {

                $from_date = date('Y-m-d');
                $to_date = date('Y-m-d');

                $transaction_amount = $user->get_merchant_trans_amount($from_date, $to_date);
            } else {

                $from_date = $request->trans_from_date;
                $to_date = $request->trans_to_date;

                $transaction_amount = $user->get_merchant_trans_amount($from_date, $to_date);
            }
            if ($request->mode == 'live') {
                // Select data from the live table
                $data = 'payin_transactions';
            }else{
                // Select data from the test table
                $data ='test_payintransactions';
            } 

            $trans_pagination_amount= DB::table($data)
            ->select('merchant_id','email','mobile_no','customer_name', DB::raw('sum(amount) as merchant_sum'))
            ->groupBy('merchant_id')
            ->get()
            ->toArray();

            
    
            $transamount_pagination = $this->_arrayPaginator($trans_pagination_amount, $request, "transactionamount");
            return View::make("employee.pagination")->with(["module" => "transactionamount", "transactionamounts" => $transamount_pagination])->render();
        }
    }

    public function get_all_merchants(Request $request, $perpage)
    {
        if ($request->ajax()) {
            $user = new User();
            $merchant = $user->get_all_merchants();
            $merchant_pagination = $this->_arrayPaginator($merchant, $request, "merchant", $perpage);
            return View::make("employee.pagination")->with(["module" => "merchant", "merchants" => $merchant_pagination])->render();
        }
    }

    public function get_all_cases(Request $request)
    {
        if ($request->ajax()) {
            $user = new User();
            $cases = $user->get_merchant_cases();
            $case_pagination = $this->_arrayPaginator($cases, $request, "case");
            return View::make("employee.pagination")->with(["module" => "case", "cases" => $case_pagination])->render();
        }
    }

    public function get_all_adjustments(Request $request)
    {
        if ($request->ajax()) {
            $adjustments = new Settlement();
            $adjustments = $adjustments->get_all_merchant_adjustments();
            $adjustment_pagination = $this->_arrayPaginator($adjustments, $request, "adjustment");
            return View::make("employee.pagination")->with(["module" => "adjustment", "adjustments" => $adjustment_pagination])->render();
        }
    }


    public function employee_pagination(Request $request, $module, $perpage)
    {

        switch ($module) {

            case 'porders':

                $porderObject = new RyapayPorder();
                $porders = $porderObject->get_all_porder();
                $paginate_porder = $this->_arrayPaginator($porders, $request, "porders", $perpage);
                return View::make('employee.pagination')->with(["module" => "porder", "porders" => $paginate_porder])->render();
                break;

            case 'suporders':

                $suporderObject = new RyapayaSupOrderInv();
                $suporders = $suporderObject->get_all_suporder();
                $paginate_suporder = $this->_arrayPaginator($suporders, $request, "suporders", $perpage);
                return View::make('employee.pagination')->with(["module" => "suporder", "suporders" => $paginate_suporder])->render();
                break;

            case 'supexps':

                $supexpObject = new RyapaySupExpInv();
                $supexps = $supexpObject->get_all_supexp();
                $paginate_supexp = $this->_arrayPaginator($supexps, $request, "supexps", $perpage);
                return View::make('employee.pagination')->with(["module" => "supexp", "supexps" => $paginate_supexp])->render();
                break;

            case 'supnotes':

                $supnoteObject = new RyapaySupCDNote();
                $supnotes = $supnoteObject->get_all_supplier_note();
                $paginate_supnote = $this->_arrayPaginator($supnotes, $request, "supnotes", $perpage);
                return View::make('employee.pagination')->with(["module" => "supnote", "supnotes" => $paginate_supnote])->render();
                break;

            case 'sorders':

                $sorderObject = new RyapaySorder();
                $sorders = $sorderObject->get_all_sorder();
                $paginate_sorder = $this->_arrayPaginator($sorders, $request, "sorders", $perpage);
                return View::make('employee.pagination')->with(["module" => "sorder", "sorders" => $paginate_sorder])->render();
                break;

            case 'custorders':

                $custorderObject = new RyapayCustOrderInv();
                $custorders = $custorderObject->get_all_custorder();
                $paginate_custorder = $this->_arrayPaginator($custorders, $request, "custorders", $perpage);
                return View::make('employee.pagination')->with(["module" => "custorder", "custorders" => $paginate_custorder])->render();
                break;

            case 'custnotes':

                $custnoteObject = new RyapayaCustCDNote();
                $custnotes = $custnoteObject->get_all_customer_note();
                $paginate_custnote = $this->_arrayPaginator($custnotes, $request, "custnotes", $perpage);
                return View::make('employee.pagination')->with(["module" => "custnote", "custnotes" => $paginate_custnote])->render();
                break;


            case 'assets':

                $assetObject = new RyapayFixedAsset();
                $asset = $assetObject->get_all_assets();
                $paginate_asset = $this->_arrayPaginator($asset, $request, "assets", $perpage);
                return View::make('employee.pagination')->with(["module" => "asset", "assets" => $paginate_asset])->render();
                break;

            case 'capitalassets':

                $assetObject = new RyapayFixedAsset();
                $capitalasset = $assetObject->get_all_capital_assets();
                $paginate_capitalasset = $this->_arrayPaginator($capitalasset, $request, "capitalassets", $perpage);
                return View::make('employee.pagination')->with(["module" => "capitalasset", "capitalassets" => $paginate_capitalasset])->render();
                break;

            case 'depreciateassets':

                $assetObject = new RyapayFixedAsset();
                $depreciateasset = $assetObject->get_all_depreciate_assets();
                $paginate_depreciateasset = $this->_arrayPaginator($depreciateasset, $request, "depreciateassets");
                return View::make('employee.pagination')->with(["module" => "depreciateasset", "depreciateassets" => $paginate_depreciateasset])->render();
                break;

            case 'saleassets':

                $assetObject = new RyapayFixedAsset();
                $saleasset = $assetObject->get_all_sale_assets();
                $paginate_saleasset = $this->_arrayPaginator($saleasset, $request, "saleassets", $perpage);
                return View::make('employee.pagination')->with(["module" => "saleasset", "saleassets" => $paginate_saleasset])->render();
                break;


            case 'taxsettlements':

                $tax_settlement_object = new RyapayTaxSettlement();
                $taxsettlement = $tax_settlement_object->get_all_taxsettlement();
                $paginate_taxsettlement = $this->_arrayPaginator($taxsettlement, $request, "taxsettlements");
                return View::make('employee.pagination')->with(["module" => "taxsettlement", "taxsettlements" => $paginate_taxsettlement])->render();
                break;

            case 'taxadjustments':

                $tax_adjustment_object = new RyapayTaxAdjustment();
                $taxadjustment = $tax_adjustment_object->get_all_taxadjustment();
                $paginate_taxadjustment = $this->_arrayPaginator($taxadjustment, $request, "taxadjustments", $perpage);
                return View::make('employee.pagination')->with(["module" => "taxadjustment", "taxadjustments" => $paginate_taxadjustment])->render();
                break;

            case 'taxpayments':

                $tax_payment_object = new RyapayTaxPayment();
                $taxpayment = $tax_payment_object->get_all_taxpayment();
                $paginate_taxpayment = $this->_arrayPaginator($taxpayment, $request, "taxpayments", $perpage);
                return View::make('employee.pagination')->with(["module" => "taxpayment", "taxpayments" => $paginate_taxpayment])->render();
                break;

            case 'accountcharts':

                $chart_of_account = new CharOfAccount();
                $account_charts = $chart_of_account->get_account_details();
                $paginate_account_charts = $this->_arrayPaginator($account_charts, $request, "accountcharts", $perpage);
                return View::make("employee.pagination")->with(["module" => "accountchart", "accountcharts" => $paginate_account_charts])->render();
                break;

            case 'vouchers':
                $voucherObject = new RyapayJournalVoucher();
                $vouchers = $voucherObject->get_all_vouchers();
                $paginate_vouchers = $this->_arrayPaginator($vouchers, $request, "vouchers", $perpage);
                return View::make('employee.pagination')->with(["module" => "voucher", "vouchers" => $paginate_vouchers])->render();
                break;

            case 'invoices':

                $invoiceObject = new RyaPayInvoice();
                $invoices = $invoiceObject->get_all_invoices();
                $paginate_invoice = $this->_arrayPaginator($invoices, $request, "invoices", $perpage);
                return View::make('employee.pagination')->with(["module" => "invoice", "invoices" => $paginate_invoice])->render();
                break;


            case 'items':

                $itemObject = new RyaPayItem();
                $items = $itemObject->get_all_items();
                $pagination = $this->_arrayPaginator($items, $request, "items");
                return View::make('employee.pagination')->with(["module" => "item", "items" => $pagination])->render();
                break;

            case 'customers':

                $customerObject = new RyaPayCustomer();
                $customer = $customerObject->get_all_customers();
                $pagination = $this->_arrayPaginator($customer, $request, "customers", $perpage);
                return View::make('employee.pagination')->with(["module" => "customer", "customers" => $pagination])->render();
                break;

            case 'suppliers':

                $supplierObject = new RyapaySupplier();
                $supplier_info = $supplierObject->get_all_suppliers();
                $supplier_pagination = $this->_arrayPaginator($supplier_info, $request, "suppliers", $perpage);
                return View::make('employee.pagination')->with(["module" => "supplier", "suppliers" => $supplier_pagination])->render();
                break;

            case 'banks':

                $bankObject = new RyapayBankInfo();
                $bank_info = $bankObject->get_banks_info();
                $bank_pagination = $this->_arrayPaginator($bank_info, $request, "banks", $perpage);
                return View::make('employee.pagination')->with(["module" => "bank", "banks" => $bank_pagination])->render();
                break;

            case 'contras':

                $contraObject = new RyapayContEntry();
                $contra_info = $contraObject->get_contras_info();
                $contra_pagination = $this->_arrayPaginator($contra_info, $request, "contras", $perpage);
                return View::make('employee.pagination')->with(["module" => "contra", "contras" => $contra_pagination])->render();
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

            case 'workstatus':

                $workstatusObject = new EmpWorkStatus();
                $workstatuses = $workstatusObject->get_work_status(auth()->guard("employee")->user()->id);
                $paginate_workstatus = $this->_arrayPaginator($workstatuses, $request, "workstatus", $perpage);
                return View::make('employee.pagination')->with(["module" => "workstatus", "workstatuses" => $paginate_workstatus])->render();
                break;

            case 'document':

                $merchantObject = new MerchantDocument();
                $document =  $merchantObject->get_merchants_document();
                $documents = $this->_arrayPaginator($document, $request, "document", $perpage);
                return View::make("employee.pagination")->with(["module" => "document", "documents" => $documents])->render();
                break;

            case 'bginfo':

                $bgcheck = new RyapayBGCheck();
                $bginfo = $bgcheck->get_background_info();
                $bginfos = $this->_arrayPaginator($bginfo, $request, "bginfo", $perpage);
                return View::make("employee.pagination")->with(["module" => "bginfo", "bginfos" => $bginfos])->render();
                break;

            case 'custcase':

                $custcase = new CustomerCase();
                $custcases = $custcase->get_all_cases();
                $paginate_custcases = $this->_arrayPaginator($custcases, $request, "custcase", $perpage);
                return View::make("employee.pagination")->with(["module" => "custcase", "custcases" => $paginate_custcases])->render();
                break;

            case 'approvedmerchant':

                $merchantObject = new MerchantDocument();
                $approvedmerchant =  $merchantObject->get_approved_merchants();
                $approvedmerchants = $this->_arrayPaginator($approvedmerchant, $request, "approvedmerchant", $perpage);
                return View::make("employee.pagination")->with(["module" => "approvedmerchant", "approvedmerchants" => $approvedmerchants])->render();
                break;

            case 'merchant':

                $user = new User();
                $merchant = $user->get_all_merchants();
                $merchant_pagination = $this->_arrayPaginator($merchant, $request, "merchant", $perpage);
                return View::make("employee.pagination")->with(["module" => "merchant", "merchants" => $merchant_pagination])->render();
                break;

            case 'alltransaction':

                $payment = new Payment();
                $transactions_result = $payment->get_transactions_bydate(session('fromdate'), session('todate'));
                $transactions = $this->transaction_setup($transactions_result);
                $paginate_alltransaction = $this->_arrayPaginator($transactions, $request, "alltransaction", $perpage);

                return View::make('employee.pagination')->with(["module" => "alltransaction", "alltransactions" => $paginate_alltransaction])->render();
                break;

            default:

                break;
        }
    }

    public function employee_search(Request $request, $module, $search_value, $perpage = 10)
    {

        $searched_array = array();

        switch ($module) {

            case 'supexps':


                if (strlen($search_value) > 1) {
                    $searched_array  = $this->_search_algorithm($request->session()->get('supexps-search'), $search_value);
                    $paginate_supexp = $this->_arrayPaginator($searched_array, $request, "paylink", $perpage);
                } else {

                    $supexpObject = new RyapaySupExpInv();
                    $supexps = $supexpObject->get_all_supexp();
                    session(['supexps-search' => $supexps]);
                    $searched_array = $this->_search_algorithm($request->session()->get('supexps-search'), $search_value);
                    $paginate_supexp = $this->_arrayPaginator($searched_array, $request, "supexps", $perpage);
                }
                return View::make('employee.pagination')->with(["module" => "supexp", "supexps" => $paginate_supexp])->render();
                break;

            case 'supnotes':

                if (strlen($search_value) > 1) {
                    $searched_array  = $this->_search_algorithm($request->session()->get('supnotes-search'), $search_value);
                    $paginate_supnote = $this->_arrayPaginator($searched_array, $request, "paylink", $perpage);
                } else {

                    $supnoteObject = new RyapaySupCDNote();
                    $supnotes = $supnoteObject->get_all_supplier_note();
                    session(['supnotes-search' => $supnotes]);
                    $searched_array = $this->_search_algorithm($request->session()->get('supnotes-search'), $search_value);
                    $paginate_supnote = $this->_arrayPaginator($searched_array, $request, "supnotes", $perpage);
                }

                return View::make('employee.pagination')->with(["module" => "supnote", "supnotes" => $paginate_supnote])->render();
                break;

            case 'sorders':

                if (strlen($search_value) > 1) {
                    $searched_array  = $this->_search_algorithm($request->session()->get('sorders-search'), $search_value);
                    $paginate_sorder = $this->_arrayPaginator($searched_array, $request, "sorders", $perpage);
                } else {
                    $sorderObject = new RyapaySorder();
                    $sorders = $sorderObject->get_all_sorder();
                    session(['sorders-search' => $sorders]);
                    $searched_array = $this->_search_algorithm($request->session()->get('sorders-search'), $search_value);
                    $paginate_sorder = $this->_arrayPaginator($searched_array, $request, "sorders", $perpage);
                }
                return View::make('employee.pagination')->with(["module" => "sorder", "sorders" => $paginate_sorder])->render();
                break;

            case 'custorders':

                if (strlen($search_value) > 1) {

                    $searched_array = $this->_search_algorithm($request->session()->get('custorders-search'), $search_value);
                    $paginate_custorder = $this->_arrayPaginator($searched_array, $request, "custorders", $perpage);
                } else {

                    $custorderObject = new RyapayCustOrderInv();
                    $custorders = $custorderObject->get_all_custorder();
                    session(['custorders-search' => $custorders]);
                    $searched_array = $this->_search_algorithm($request->session()->get('custorders-search'), $search_value);
                    $paginate_custorder = $this->_arrayPaginator($searched_array, $request, "custorders", $perpage);
                }

                return View::make('employee.pagination')->with(["module" => "custorder", "custorders" => $paginate_custorder])->render();
                break;


            case 'custnotes':

                if (strlen($search_value) > 1) {

                    $searched_array = $this->_search_algorithm($request->session()->get('custnotes-search'), $search_value);
                    $paginate_custnote = $this->_arrayPaginator($searched_array, $request, "custnotes", $perpage);
                } else {

                    $custnoteObject = new RyapayaCustCDNote();
                    $custnotes = $custnoteObject->get_all_customer_note();
                    session(['custnotes-search' => $custnotes]);
                    $searched_array = $this->_search_algorithm($request->session()->get('custnotes-search'), $search_value);
                    $paginate_custnote = $this->_arrayPaginator($searched_array, $request, "custnotes", $perpage);
                }

                return View::make('employee.pagination')->with(["module" => "custnote", "custnotes" => $paginate_custnote])->render();
                break;


            case 'assets':

                if (strlen($search_value) > 1) {

                    $searched_array = $this->_search_algorithm($request->session()->get('asset-search'), $search_value);
                    $paginate_asset = $this->_arrayPaginator($searched_array, $request, "assets", $perpage);
                } else {

                    $assetObject = new RyapayFixedAsset();
                    $asset = $assetObject->get_all_assets();
                    session(['asset-search' => $asset]);
                    $searched_array = $this->_search_algorithm($request->session()->get('asset-search'), $search_value);
                    $paginate_asset = $this->_arrayPaginator($searched_array, $request, "assets", $perpage);
                }

                return View::make('employee.pagination')->with(["module" => "asset", "assets" => $paginate_asset])->render();
                break;

            case 'capitalassets':

                if (strlen($search_value) > 1) {

                    $searched_array = $this->_search_algorithm($request->session()->get('capitalasset-search'), $search_value);
                    $paginate_capitalasset = $this->_arrayPaginator($searched_array, $request, "capitalassets", $perpage);
                } else {

                    $assetObject = new RyapayFixedAsset();
                    $capitalasset = $assetObject->get_all_capital_assets();
                    session(["capitalasset-search" => $capitalasset]);
                    $searched_array = $this->_search_algorithm($request->session()->get('capitalasset-search'), $search_value);
                    $paginate_capitalasset = $this->_arrayPaginator($searched_array, $request, "capitalassets", $perpage);
                }

                return View::make('employee.pagination')->with(["module" => "capitalasset", "capitalassets" => $paginate_capitalasset])->render();
                break;


            case 'depreciateassets':

                if (strlen($search_value) > 1) {

                    $searched_array = $this->_search_algorithm($request->session()->get('depreciateassets-search'), $search_value);
                    $paginate_depreciateasset = $this->_arrayPaginator($searched_array, $request, "depreciateassets");
                } else {

                    $assetObject = new RyapayFixedAsset();
                    $depreciateasset = $assetObject->get_all_depreciate_assets();
                    session(["depreciateassets-search" => $depreciateasset]);
                    $searched_array = $this->_search_algorithm($request->session()->get('depreciateassets-search'), $search_value);
                    $paginate_depreciateasset = $this->_arrayPaginator($searched_array, $request, "depreciateassets");
                }
                return View::make('employee.pagination')->with(["module" => "depreciateasset", "depreciateassets" => $paginate_depreciateasset])->render();
                break;

            case 'saleassets':

                if (strlen($search_value) > 1) {

                    $searched_array = $this->_search_algorithm($request->session()->get('saleassets-search'), $search_value);
                    $paginate_saleasset = $this->_arrayPaginator($searched_array, $request, "saleassets", $perpage);
                } else {

                    $assetObject = new RyapayFixedAsset();
                    $saleasset = $assetObject->get_all_sale_assets();
                    session(['saleassets-search' => $saleasset]);
                    $searched_array = $this->_search_algorithm($request->session()->get('saleassets-search'), $search_value);
                    $paginate_saleasset = $this->_arrayPaginator($searched_array, $request, "saleassets", $perpage);
                }

                return View::make('employee.pagination')->with(["module" => "saleasset", "saleassets" => $paginate_saleasset])->render();
                break;

            case 'taxsettlements':

                if (strlen($search_value) > 1) {

                    $searched_array = $this->_search_algorithm($request->session()->get('taxsettlements-search'), $search_value);
                    $paginate_taxsettlement = $this->_arrayPaginator($searched_array, $request, "taxsettlements");
                } else {
                    $tax_settlement_object = new RyapayTaxSettlement();
                    $taxsettlement = $tax_settlement_object->get_all_taxsettlement();
                    session(['taxsettlements-search' => $taxsettlement]);
                    $searched_array = $this->_search_algorithm($request->session()->get('taxsettlements-search'), $search_value);
                    $paginate_taxsettlement = $this->_arrayPaginator($searched_array, $request, "taxsettlements");
                }
                return View::make('employee.pagination')->with(["module" => "taxsettlement", "taxsettlements" => $paginate_taxsettlement])->render();
                break;

            case 'taxadjustments':

                if (strlen($search_value) > 1) {

                    $searched_array = $this->_search_algorithm($request->session()->get('taxadjustments-search'), $search_value);
                    $paginate_taxadjustment = $this->_arrayPaginator($searched_array, $request, "saleassets", $perpage);
                } else {
                    $tax_adjustment_object = new RyapayTaxAdjustment();
                    $taxadjustment = $tax_adjustment_object->get_all_taxadjustment();
                    session(['taxadjustments-search' => $taxadjustment]);
                    $searched_array = $this->_search_algorithm($request->session()->get('taxadjustments-search'), $search_value);
                    $paginate_taxadjustment = $this->_arrayPaginator($searched_array, $request, "taxadjustments", $perpage);
                }
                return View::make('employee.pagination')->with(["module" => "taxadjustment", "taxadjustments" => $paginate_taxadjustment])->render();
                break;

            case 'taxpayments':

                if (strlen($search_value) > 1) {

                    $searched_array = $this->_search_algorithm($request->session()->get('taxpayments-search'), $search_value);
                    $paginate_taxpayment = $this->_arrayPaginator($searched_array, $request, "saleassets", $perpage);
                } else {

                    $tax_payment_object = new RyapayTaxPayment();
                    $taxpayment = $tax_payment_object->get_all_taxpayment();
                    session(['taxpayments-search' => $taxpayment]);
                    $searched_array = $this->_search_algorithm($request->session()->get('taxpayments-search'), $search_value);
                    $paginate_taxpayment = $this->_arrayPaginator($searched_array, $request, "taxpayments", $perpage);
                }
                return View::make('employee.pagination')->with(["module" => "taxpayment", "taxpayments" => $paginate_taxpayment])->render();
                break;

            case 'accountcharts':

                if (strlen($search_value) > 1) {

                    $searched_array = $this->_search_algorithm($request->session()->get('accountcharts-search'), $search_value);
                    $paginate_account_charts = $this->_arrayPaginator($searched_array, $request, "accountcharts", $perpage);
                } else {

                    $chart_of_account = new CharOfAccount();
                    $account_charts = $chart_of_account->get_account_details();
                    session(['accountcharts-search' => $account_charts]);
                    $searched_array = $this->_search_algorithm($request->session()->get('accountcharts-search'), $search_value);
                    $paginate_account_charts = $this->_arrayPaginator($searched_array, $request, "accountcharts", $perpage);
                }
                return View::make("employee.pagination")->with(["module" => "accountchart", "accountcharts" => $paginate_account_charts])->render();
                break;

            case 'vouchers':

                if (strlen($search_value) > 1) {

                    $searched_array = $this->_search_algorithm($request->session()->get('vouchers-search'), $search_value);
                    $paginate_vouchers = $this->_arrayPaginator($searched_array, $request, "vouchers", $perpage);
                } else {

                    $voucherObject = new RyapayJournalVoucher();
                    $vouchers = $voucherObject->get_all_vouchers();
                    session(['vouchers-search' => $vouchers]);
                    $searched_array = $this->_search_algorithm($request->session()->get('vouchers-search'), $search_value);
                    $paginate_vouchers = $this->_arrayPaginator($searched_array, $request, "vouchers", $perpage);
                }
                return View::make('employee.pagination')->with(["module" => "voucher", "vouchers" => $paginate_vouchers])->render();
                break;

            case 'items':

                if (strlen($search_value) > 1) {

                    $searched_array = $this->_search_algorithm($request->session()->get('items-search'), $search_value);
                    $pagination = $this->_arrayPaginator($searched_array, $request, "items");
                } else {

                    $itemObject = new RyaPayItem();
                    $items = $itemObject->get_all_items();
                    session(['items-search' => $items]);
                    $searched_array = $this->_search_algorithm($request->session()->get('items-search'), $search_value);
                    $pagination = $this->_arrayPaginator($searched_array, $request, "items");
                }
                return View::make('employee.pagination')->with(["module" => "item", "items" => $pagination])->render();
                break;

            case 'customers':

                if (strlen($search_value) > 1) {

                    $searched_array = $this->_search_algorithm($request->session()->get('customers-search'), $search_value);
                    $pagination = $this->_arrayPaginator($searched_array, $request, "customers", $perpage);
                } else {

                    $customerObject = new RyaPayCustomer();
                    $customer = $customerObject->get_all_customers();
                    session(['customers-search' => $customer]);
                    $searched_array = $this->_search_algorithm($request->session()->get('customers-search'), $search_value);
                    $pagination = $this->_arrayPaginator($searched_array, $request, "customers", $perpage);
                }
                return View::make('employee.pagination')->with(["module" => "customer", "customers" => $pagination])->render();
                break;

            case 'suppliers':

                if (strlen($search_value) > 1) {

                    $searched_array = $this->_search_algorithm($request->session()->get('suppliers-search'), $search_value);
                    $supplier_pagination = $this->_arrayPaginator($searched_array, $request, "suppliers", $perpage);
                } else {

                    $supplierObject = new RyapaySupplier();
                    $supplier_info = $supplierObject->get_all_suppliers();
                    session(['suppliers-search' => $supplier_info]);
                    $searched_array = $this->_search_algorithm($request->session()->get('suppliers-search'), $search_value);
                    $supplier_pagination = $this->_arrayPaginator($searched_array, $request, "suppliers", $perpage);
                }
                return View::make('employee.pagination')->with(["module" => "supplier", "suppliers" => $supplier_pagination])->render();
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


    public function saveVendorkeys(Request $request)
    {

        $vendor = $request->vendor_id;
        if ($vendor == 'Atom') {
            $insert = DB::table('mid_keys_atom')->insert([
                'merchant_id' => $request->merchant_id,
                'userid' => $request->atomuserid,
                'hash_request_key' => $request->atomhashrequestkey,
                'hash_response_key' => $request->atomhashresponsekey,
                'aes_request_key' => $request->atomaesrequestkey,
                'aes_request_salt_iv_key' => $request->atomaesrequestsaltkey,
                'aes_response_key' => $request->atomaesresponsekey,
                'aes_response_salt_iv_key' => $request->atomaesresponsesaltkey,

                'created_user' => Auth::guard("employee")->user()->id
            ]);
        } else if ($vendor == 'Razorpay') {
            $insert = DB::table('mid_keys_razorpay')->insert([
                'merchant_id' => $request->merchant_id,
                'key_id' => $request->razorpay_keyid,
                'key_secret' => $request->razorpay_keysecret,
                'created_user' => Auth::guard("employee")->user()->id
            ]);
        } else if ($vendor == 'CashFree') {
            $insert = DB::table('cf_rpay_keys')->insert([
                'merchant_id' => $request->merchant_id,
                'app_id' => $request->app_id,
                'secret_key' => $request->secret_key,
                'created_user' => Auth::guard("employee")->user()->id
            ]);
        } else if ($vendor == 'Grezpay') {
            $insert = DB::table('grezpay_mid_keys')->insert([
                'merchant_id' => $request->merchant_id,
                'app_id' => $request->grezappID,
                'salt_key' => $request->grezsaltkey,
                'secret_key' => $request->grezsecretkey,
                'created_user' => Auth::guard("employee")->user()->id
            ]);
        } else if ($vendor == 'Worldline') {
            $insert = DB::table('worldline_mid_keys')->insert([
                'merchant_id' => $request->merchant_id,
                'merchant_code' => $request->worldlinemercode,
                'scheme_code' => $request->worldlineschemecode,
                'enc_key' => $request->worldlineEncKey,
                'enc_iv' => $request->worldlineEncIv,
                'created_user' => Auth::guard("employee")->user()->id
            ]);
        } else if ($vendor == 'Paytm') {
            $insert = DB::table('mid_keys_paytm')->insert([
                'merchant_id' => $request->merchant_id,
                'paytm_merchant_id' => $request->paytm_merchantid,
                'merchant_key' => $request->paytm_merchant_key,
                'website' => $request->paytm_website,
                'industry_type' => $request->paytm_industry_type,
                'channel_id_website' => $request->paytm_channel_id_website,
                'channel_id_mobileapp' => $request->paytm_channel_id_mobileapp,
                'created_user' => Auth::guard("employee")->user()->id
            ]);
        } else if ($vendor == 'Razorpay') {
            $insert = DB::table('mid_keys_razorpay')->insert([
                'merchant_id' => $request->merchant_id,
                'key_id' => $request->razorpay_keyid,
                'key_secret' => $request->razorpay_keysecret,
                'created_user' => Auth::guard("employee")->user()->id
            ]);
        } else if ($vendor == 'PayU') {
            $insert = DB::table('payu_mid_keys')->insert([
                'merchant_id' => $request->merchant_id,
                'merchant_mid' => $request->payumid,
                'merchant_key' => $request->payukey,
                'salt_key' => $request->payusaltkey,
                'created_user' => Auth::guard("employee")->user()->id
            ]);
        } else {
            dd('work in progress');
        }

        return redirect()->back()->with('message', 'Keys Added Successfully');
    }

    public function merchantListWhenSavingVendor(Request $request)
    {

        $vendor = $request->vendor_id;
        if ($vendor == 'Atom') {
            $getSavedUsers = DB::table('mid_keys_atom')->select('merchant_id')->get();
        } else if ($vendor == 'Razorpay') {
            $getSavedUsers = DB::table('mid_keys_razorpay')->select('merchant_id')->get();
        } else if ($vendor == 'CashFree') {
            $getSavedUsers = DB::table('cf_rpay_keys')->select('merchant_id')->get();
        } else if ($vendor == 'Grezpay') {
            $getSavedUsers = DB::table('grezpay_mid_keys')->select('merchant_id')->get();
        } else if ($vendor == 'Worldline') {
            $getSavedUsers = DB::table('worldline_mid_keys')->select('merchant_id')->get();
        } else if ($vendor == 'Paytm') {
            $getSavedUsers = DB::table('mid_keys_paytm')->select('merchant_id')->get();
        } else if ($vendor == 'Razorpay') {
            $getSavedUsers = DB::table('mid_keys_razorpay')->select('merchant_id')->get();
        } else if ($vendor == 'PayU') {
            $getSavedUsers = DB::table('payu_mid_keys')->select('merchant_id')->get();
        } else {
            $getSavedUsers = [];
        }

        $UserArray = [];
        foreach ($getSavedUsers as $key => $Users) {
            $UserArray[$key] = $Users->merchant_id;
        }



        $allUsers = DB::table('merchant')->whereNotIn('id', $UserArray)->get();

        return $allUsers;
    }

    public function deleteVendorKeys(Request $request)
    {

        $vendor = $request->vendor_id;
        if ($vendor == 'Atom') {
            $deleteKey = DB::table('mid_keys_atom')->where('id', $request->id)->delete();
        } else if ($vendor == 'Razorpay') {
            $deleteKey = DB::table('mid_keys_razorpay')->where('id', $request->id)->delete();
        } else if ($vendor == 'CashFree') {
            $deleteKey = DB::table('cf_rpay_keys')->where('id', $request->id)->delete();
        } else if ($vendor == 'Grezpay') {
            $deleteKey = DB::table('grezpay_mid_keys')->where('id', $request->id)->delete();
        } else if ($vendor == 'Worldline') {
            $deleteKey = DB::table('worldline_mid_keys')->where('id', $request->id)->delete();
        } else if ($vendor == 'Paytm') {
            $deleteKey = DB::table('mid_keys_paytm')->where('id', $request->id)->delete();
        } else if ($vendor == 'Razorpay') {
            $deleteKey = DB::table('mid_keys_razorpay')->where('id', $request->id)->delete();
        } else if ($vendor == 'PayU') {
            $deleteKey = DB::table('payu_mid_keys')->where('id', $request->id)->delete();
        } else {
            $deleteKey = [];
        }


        return redirect()->back()->with('message', 'Key Deleted Successfully');
    }

    public function payoutDashboard()
    {
        $merchants = User::get();
        return view('employee.payout.dashboard', compact('merchants'));
    }

    public function priceSetting()
    {
        $PricesUsers = MerchantPayoutCharges::groupBy('merchant_id')->with('merchant')->select('merchant_id')->get();

        $modifiedArr = [];
        foreach ($PricesUsers as $key => $user) {


            $object = new \stdClass();

			if(isset($user->merchant->id)) {
				$object->merchantid =  $user->merchant->id;
				$object->merchantgid =  $user->merchant->merchant_gid;
				$object->merchantname =  $user->merchant->name;
				$object->settings = MerchantPayoutCharges::where('merchant_id', $user->merchant_id)->count();

				$modifiedArr[$key] = $object;
			}
            
        }

        $user = User::get();

        return view('employee.payout.pricesettingusers', compact('user', 'modifiedArr'));
    }

    public function priceSettingofUser($id)
    {
        $prices = MerchantPayoutCharges::with('merchant')->where('merchant_id', $id)->get();
        $user = User::get();

        return view('employee.payout.pricesetting', compact('user', 'prices'));
    }

    public function savePriceSetting(Request $request)
    {
        $pricingArr = [];
        foreach ($request->type as $key => $type) {

            $pricing = new \stdClass();
            $pricing->min_range = $request->min_range[$key];
            $pricing->max_range = $request->max_range[$key];
            $pricing->type = $request->type[$key];
            $pricing->imps = $request->imps[$key];
            $pricing->neft = $request->neft[$key];
            $pricing->rtgs = $request->rtgs[$key];
            $pricing->upi = $request->upi[$key];
            $pricing->paytm = $request->paytm[$key];
            $pricing->amazon = $request->amazon[$key];
            $pricingArr[$key] = $pricing;
        }


        foreach ($pricingArr as $key => $arr) {
            $insert = MerchantPayoutCharges::create([
                'merchant_id' => $request->merchant_id,
                'min_range' => $arr->min_range,
                'max_range' => $arr->max_range,
                'type' => $arr->type,
                'IMPS' => $arr->imps,
                'NEFT' => $arr->neft,
                'RTGS' => $arr->rtgs,
                'UPI' => $arr->upi,
                'PAYTM' => $arr->paytm,
                'AMAZON' => $arr->amazon,
            ]);
        }


        return redirect()->back()->with('message', 'Added Successfully');
    }

    public function deletePriceSetting(Request $request)
    {
        $delete =   MerchantPayoutCharges::where('id', $request->id)->delete();

        return redirect()->back()->with('message', 'Deleted Successfully');
    }

    public function editPriceSetting(Request $request)
    {

        $update = MerchantPayoutCharges::where('id', $request->id)->update([
            'min_range' => $request->min_range,
            'max_range' => $request->max_range,
            'type' => $request->type,
            'IMPS' => $request->imps,
            'NEFT' => $request->neft,
            'RTGS' => $request->rtgs,
            'UPI' => $request->upi,
            'PAYTM' => $request->paytm,
            'AMAZON' => $request->amazon,
        ]);


        if ($update) {
            return redirect()->back()->with('message', 'Added Successfully');
        }
        return redirect()->back()->with('message', 'Something went Wrong Successfully');
    }


    public function routingConfig()
    {
        $payoutVendors = MerchantPayoutVendor::with('merchant')->get();

        $savedUsers = [];
        foreach ($payoutVendors as $key => $value) {
            //extracting savedmerchant ids to array
            $savedUsers[$key] = $value->merchant_id;

            //converting vendor ids to vendor names
            $payoutVendors[$key]->imps_vendor =   DB::table('payout_vendor_bank')->where('id', $value->imps)->first()->bank_name;
            $payoutVendors[$key]->neft_vendor =   DB::table('payout_vendor_bank')->where('id', $value->neft)->first()->bank_name;
            $payoutVendors[$key]->rtgs_vendor =   DB::table('payout_vendor_bank')->where('id', $value->rtgs)->first()->bank_name;
            $payoutVendors[$key]->upi_vendor =   DB::table('payout_vendor_bank')->where('id', $value->upi)->first()->bank_name;
            $payoutVendors[$key]->paytm_vendor =   DB::table('payout_vendor_bank')->where('id', $value->paytm)->first()->bank_name;
            $payoutVendors[$key]->amazon_vendor =   DB::table('payout_vendor_bank')->where('id', $value->amazon)->first()->bank_name;
            $merchant = DB::table('merchant')->where('id', $value->merchant_id)->first();
            if ($merchant) {
                $payoutVendors[$key]->merchant_name = $merchant->name;
            } else {
                // Handle the case where no merchant is found
                $payoutVendors[$key]->merchant_name = "Unknown";}
        }
       

        $user = User::whereNotIn('id', $savedUsers)->get();
        $vendors =  DB::table('payout_vendor_bank')->get();

        return view('employee.payout.routingconfig', compact('vendors', 'user', 'payoutVendors'));
    }

    public function saveRoutingConfig(Request $request)
    {
        $insert = MerchantPayoutVendor::create([
            'merchant_id' => $request->merchant_id,
            'imps' => $request->imps,
            'neft' => $request->neft,
            'rtgs' => $request->rtgs,
            'upi' => $request->upi,
            'paytm' => $request->paytm,
            'amazon' => $request->amazon,
        ]);

        return redirect()->back()->with('message', 'Added Successfully');
    }

    public function deleteRoutingConfig(Request $request)
    {
        $delete =   MerchantPayoutVendor::where('id', $request->id)->delete();

        return redirect()->back()->with('message', 'Deleted Successfully');
    }

    public function editRoutingConfig(Request $request)
    {
        $update = MerchantPayoutVendor::where('id', $request->id)->update([
            'imps' => $request->imps,
            'neft' => $request->neft,
            'rtgs' => $request->rtgs,
            'upi' => $request->upi,
            'paytm' => $request->paytm,
            'amazon' => $request->amazon,
        ]);

        if ($update) {
            return redirect()->back()->with('message', 'Edited Successfully');
        } else {
            return redirect()->back()->with('message', 'Something Went Wrong');
        }
    }

    public function payoutdashboardTransactionStats(Request $request)
    {
        $start = $request->start;
        $end = $request->end;
        $merchant = $request->merchantId;

        if ($merchant == 'all') {
            $dashboard = new \stdClass();
            $dashboard->total_transaction = PayoutTransaction::whereDate('created_at', '>=', $request->start)->whereDate('created_at', '<=', $request->end)->count();
            $dashboard->successful_transaction = PayoutTransaction::whereDate('created_at', '>=', $request->start)->whereDate('created_at', '<=', $request->end)->where('status', 'PENDING')->orWhere('status', 'SUCCESS')->count();
            $dashboard->failed_transaction = PayoutTransaction::whereDate('created_at', '>=', $request->start)->whereDate('created_at', '<=', $request->end)->where('status', 'FAILED')->count();
            $dashboard->successful_tamount = PayoutTransaction::whereDate('created_at', '>=', $request->start)->whereDate('created_at', '<=', $request->end)->where('status', 'PENDING')->orWhere('status', 'SUCCESS')->sum('amount');
        } else {
            $dashboard = new \stdClass();
            $dashboard->total_transaction = PayoutTransaction::where('merchant_id', $merchant)->whereDate('created_at', '>=', $request->start)->whereDate('created_at', '<=', $request->end)->count();
            $dashboard->successful_transaction = PayoutTransaction::where('merchant_id', $merchant)->whereDate('created_at', '>=', $request->start)->whereDate('created_at', '<=', $request->end)->where('status', 'PENDING')->orWhere('status', 'SUCCESS')->count();
            $dashboard->failed_transaction = PayoutTransaction::where('merchant_id', $merchant)->whereDate('created_at', '>=', $request->start)->whereDate('created_at', '<=', $request->end)->where('status', 'FAILED')->count();
            $dashboard->successful_tamount = PayoutTransaction::where('merchant_id', $merchant)->whereDate('created_at', '>=', $request->start)->whereDate('created_at', '<=', $request->end)->where('status', 'PENDING')->orWhere('status', 'SUCCESS')->sum('amount');
        }

        return response()->json(['transactionStats' => $dashboard], 200);
    }

    public function payoutDashboardGraph(Request $request)
    {

        $startDate = new Carbon($request->start);
        $endDate = new Carbon($request->end);
        $merchant = $request->merchantId;
        $all_dates = array();
        while ($startDate->lte($endDate)) {
            $all_dates[] = $startDate->toDateString();

            $startDate->addDay();
        }

        $graphData = [];
        if ($merchant == 'all') {
            foreach ($all_dates as $key => $date) {
                $graphData[$key] = new \stdClass();
                $graphData[$key]->gtv_amount = PayoutTransaction::whereDate('created_at', $date)->sum('amount');
                $graphData[$key]->tran_count = PayoutTransaction::whereDate('created_at', $date)->count() ?? 0;
                $graphData[$key]->gtv_date = $date;
            }
        } else {
            foreach ($all_dates as $key => $date) {
                $graphData[$key] = new \stdClass();
                $graphData[$key]->gtv_amount = PayoutTransaction::where('merchant_id', $merchant)->whereDate('created_at', $date)->sum('amount');
                $graphData[$key]->tran_count = PayoutTransaction::where('merchant_id', $merchant)->whereDate('created_at', $date)->count() ?? 0;
                $graphData[$key]->gtv_date = $date;
            }
        }




        //graph 2 dooughnut
        $vendors = DB::table('payout_vendor_bank')->get();

        $vendorData = array();
        $vendorList = array();
        $paymentMData = array();

        if ($merchant == 'all') {
            foreach ($vendors as $key => $vendor) {

                $vendorData[$key] = PayoutTransaction::where('vendor', $vendor->bank_name)->whereDate('created_at', '>=', $request->start)->whereDate('created_at', '<=', $request->end)->count();
            }
        } else {
            foreach ($vendors as $key => $vendor) {
                $vendorData[$key] = PayoutTransaction::where('vendor', $vendor->bank_name)->where('merchant_id', $merchant)->whereDate('created_at', '>=', $request->start)->whereDate('created_at', '<=', $request->end)->count();
            }
        }

        foreach ($vendors as $key => $vendor) {
            $vendorList[$key] = $vendor->bank_name;
        }

        array_splice($vendorList, 0, 1);


        //end graph 2 dooughnut

        //graph3 data
        $paymentMethod = ['banktransfer', 'IMPS', 'NEFT', 'RTGS', 'UPI', 'PAYTM', 'AMAZON'];
        if ($merchant == 'all') {
            foreach ($paymentMethod as $key => $method) {

                $paymentMData[$key] = PayoutTransaction::where('transfer_mode', $method)->whereDate('created_at', '>=', $request->start)->whereDate('created_at', '<=', $request->end)->count();
            }
        } else {
            foreach ($paymentMethod as $key => $method) {
                $paymentMData[$key] = PayoutTransaction::where('transfer_mode', $method)->where('merchant_id', $merchant)->whereDate('created_at', '>=', $request->start)->whereDate('created_at', '<=', $request->end)->count();
            }
        }

        //endgraph3data


        $graph = new \stdClass();
        $graph->transaction = $graphData;
        $graph->vendorList = $vendorList;
        $graph->vendorCount = $vendorData;
        $graph->pmodeHeaders = $paymentMethod;
        $graph->pmodeData = $paymentMData;



        return response()->json(['graphData' =>  $graph], 200);
    }

    public function addmerchant(Request $request)
    {
        try {

            // dd('stop');
            $userObject = new User();

            $merchant_count = $userObject->getLastUserIndex();

            if ($merchant_count[0]->merchant_count == 0) {
                $nextuserid = 2021;
            } else {    

                $user_count = $merchant_count[0]->merchant_count;
                $nextuserid = (2021 + $user_count);
            }

            // dd($request->all());
        //    $virtual_id='NEOD_'.Str::random(4);
        //    $virtual_id = 'NEOD_' . substr(str_shuffle('0123456789'), 0, 4);

           do {
            $virtual_id = 'NEOD_' . substr(str_shuffle('0123456789'), 0, 4);
        
            // Check if the generated virtual_id already exists in the table
        } while (User::where('virtual_id', $virtual_id)->exists());
          //   dd($virtual_id);
            $user = User::create([
                'merchant_gid' => "flakpay" . $nextuserid,
                'name' => $request->name,
                'email' => $request->email,
                'mobile_no' => $request->mobile,
                'password' => bcrypt($request->password),
                'verify_token' => Str::random(25),
                'is_mobile_verified' => 'Y',
                'i_agree' => 'Y',
                'user_register'=> 'N',
                'virtual_id'=>$virtual_id,
                'created_date' => Carbon::now()
            ]);

            $user->sendAccountVerificationEmail();

            $addMerchantBusiness = new MerchantBusiness();
            $addMerchantBusiness->add_merchant_business([
                'business_type_id' => $request->business_type,
                'business_expenditure' => $request->monexpenditure,
                'business_category_id' => $request->businesscategory,
                'business_sub_category_id' => $request->business_subcategory,
                'business_name' => $request->companyname,
                'address' => $request->companyaddress,
                'pincode' => $request->companypincode,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'webapp_url' => $request->webapp_url,
                'bank_name' => $request->bank_name,
                'bank_acc_no' => $request->bank_acc_no,
                'bank_ifsc_code' => $request->bank_ifsc,
                'comp_pan_number' => $request->company_pan_no,
                'comp_gst' => $request->company_gst,
                'mer_pan_number' => $request->authorized_sign_pan_no,
                'mer_aadhar_number' => $request->authorized_sign_aadhar_no,
                'mer_name' => $request->authorized_sign_name,
                'created_date' => Carbon::now(),
                'created_merchant' => $user->id,
                'branchname' => $request ->branchname,
                'acc_holder_name' => $request ->acc_holder_name



            ]);




            //uploaddocuments

            $merchant_doc = new MerchantDocument();
            $path_to_upload = "/public/merchant/documents/" . $user->merchant_gid;
            $files = Storage::files($path_to_upload);

            $documents = array();

            foreach ($request->file() as $key => $value) {
                $file = $request->file($key);
                $file_extension = $file->getClientOriginalExtension();
                $file_name = str_replace("_", "", $key) . "." . $file_extension;
                $file->storeAs($path_to_upload, $file_name);
                $documents[$key] = $file_name;
            }



            $documents["created_date"] = Carbon::now();
            $documents["created_merchant"] = $user->id;
            $upload_status = $merchant_doc->add_documents($documents);
            //enduploaddocuments


            return Redirect::to('/flakpay/risk-complaince/merchant-document/ryapay-7WRwwggm');

            // return redirect()->back();
        } catch (\Throwable $e) {
            dd($e->getMessage());
        }
    }

    public function getSubCategory(Request $request)
    {
       
        $subcategories = DB::table('business_sub_category')->where('category_id', $request->categoryID)->where('status', 'active')->get();

        return $subcategories;
    }

    public function payoutTransacations()
    {
        return view('employee.payout.transactions');
    }

    public function getPayouttransactions(Request $request)
    {
        // $search = $request->search;
        // $startdate = $request->startdate;
        // $enddate = $request->enddate;
    
        // $transactions = PayoutTransaction::join('merchant', 'payout_transactions.merchant_id', 'merchant.id')
        //     ->whereDate('payout_transactions.created_at', '>=', $request->startdate)
        //     ->whereDate('payout_transactions.created_at', '<=', $request->enddate)
        //     ->where(function ($query) use ($search) {
        //         $query->where('transfer_id', 'LIKE', '%' . $search . '%')
        //             ->orWhere('ben_id', 'LIKE', '%' . $search . '%')
        //             ->orWhere('ben_name', 'LIKE', '%' . $search . '%')
        //             ->orWhere('ben_phone', 'LIKE', '%' . $search . '%')
        //             ->orWhere('ben_email', 'LIKE', '%' . $search . '%')
        //             ->orWhere('ben_bank_acc', 'LIKE', '%' . $search . '%')
        //             ->orWhere('status', 'LIKE', '%' . $search . '%');
        //     })
        //     ->select('payout_transactions.transfer_id', 'payout_transactions.status', 'payout_transactions.ben_id', 'payout_transactions.ben_name', 'payout_transactions.ben_phone', 'payout_transactions.ben_email', 'payout_transactions.amount', 'payout_transactions.created_at', 'payout_transactions.ben_bank_acc')
        //     ->get();
    
        $transactions = DB::table('payout_transactions')->get();
        // dd($transactions);
    
        return $transactions;
    }
    

    public function payoutTransactionInfo(Request $request)
    {
        $info = new \stdClass();

        $info->transaction_info = PayoutTransaction::where('transfer_id', $request->transferId)->first();

        $info->merchant_info = User::where('id', $info->transaction_info->merchant_id)->first();

        return response()->json(['status' => 'Success', 'data' => $info], 200);
    }

    public function updatePayoutTransactionStatus(Request $request)
    {
        //Generate Token
        $clientid = "CF157153CBOAL8VCM6H5GVH11DO0";
        $clientsecret = "de1e416550780af45375dc3608b6ecf49fbc8e2c";
        $opts = array(
            'http' =>
            array(
                'method'  => 'POST',
                'header'  => array("Content-Type: application/json", "X-Client-Id:" . $clientid, "X-Client-Secret:" . $clientsecret),
            )
        );
        $context  = stream_context_create($opts);
        $result_json = file_get_contents('https://payout-gamma.cashfree.com/payout/v1/authorize', false, $context);

        $result =  json_decode($result_json, true);

        $token = $result['data']['token'];


        //End

        //Verify token

        $opts = array(
            'http' =>
            array(
                'method'  => 'POST',
                'header'  => array("Content-Type: application/json", "Authorization:Bearer " . $token),
            )
        );
        $context  = stream_context_create($opts);
        $result_json = file_get_contents('https://payout-gamma.cashfree.com/payout/v1/verifyToken', false, $context);
        $result =  json_decode($result_json, true);


        $transactionId = $request->transactionid;
        // $transactionMode = $request->transactionmode;
        // $merchantId = $request->merchantid;

        $getTransactionInfo = PayoutTransaction::where('transfer_id', $transactionId)->first();

        $referenceId =  $getTransactionInfo->reference_id;




        if ($result['status'] == "SUCCESS") {


            $getdata = http_build_query(
                array(
                    'referenceId' =>  $referenceId,
                    'transferId' => $transactionId
                )
            );


            $opts = array(
                'http' =>
                array(
                    'method'  => 'GET',
                    'header'  => array("Content-Type: application/json", "Authorization:Bearer " . $token)

                )
            );


            $context  = stream_context_create($opts);
            $result_json = file_get_contents("https://payout-gamma.cashfree.com/payout/v1/getTransferStatus?.$getdata", false, $context);
            $result =  json_decode($result_json, true);

            $updateStatus = PayoutTransaction::where('transfer_id', $transactionId)->update(['status' => $result['data']['transfer']['status']]);

            return $result;




            if ($result['status'] == "ERROR") {
                return response()->json(['status' => 'Failed', 'data' => $result], 200);
            }
        }
    }


    public function merchantRequestListings(Request $request)
    {
        $requests = DB::table('merchant_requests')->join('merchant', 'merchant_requests.merchant_id', 'merchant.id')->select('*', 'merchant_requests.id as request_id')->get();

        return view('employee.technical.merchantrequestlising', compact('requests'));
    }


    public function merchantRequestStatusUpdate(Request $request)
    {
        $prevStatus = DB::table('merchant_requests')->where('id', $request->id)->first();

        if ($prevStatus->status == 0) {
            $newStatus = 1;
        } else {
            $newStatus = 0;
        }

        $requests = DB::table('merchant_requests')->where('id', $request->id)->update([
            'status' => $newStatus
        ]);

        return redirect()->back();
    }

    public function changeMerchantPassword(Request $request)
    {
        $update = User::where('id', $request->id)->update([
            'password' =>   Hash::make($request->newpassword)
        ]);

        return redirect()->back()->withSuccess('Password Successfully Changed');
    }

    public function employeeAccess($id)
    {
        $allmodules = Navigation::where('parent_id', 0)->get();
        $useraccess = NavPermission::where('employee_id', $id)->first();
        foreach ($allmodules as $key => $module) {

            $allmodules[$key]->submodules = Navigation::where('parent_id', $module->id)->get();

            foreach ($allmodules[$key]->submodules as $submodule) {
                switch ($module->link_name) {
                    case "Account":
                        $arr =  explode('+',  $useraccess->account);
                        break;
                    case "Finance":
                        $arr =  explode('+',  $useraccess->finance);
                        break;
                    case "Settlement":
                        $arr =  explode('+',  $useraccess->settlement);
                        break;
                    case "Technical":
                        $arr =  explode('+',  $useraccess->technical);
                        break;
                    case "Networking":
                        $arr =  explode('+',  $useraccess->networking);
                        break;
                    case "Support":
                        $arr =  explode('+',  $useraccess->support);
                        break;
                    case "Marketing":
                        $arr =  explode('+',  $useraccess->marketing);
                        break;
                    case "Sales":
                        $arr =  explode('+',  $useraccess->sales);
                        break;
                    case "Risk & Complaince":
                        $arr =  explode('+',  $useraccess->risk_complaince);
                        break;
                    case "Legal":
                        $arr =  explode('+',  $useraccess->legal);
                        break;
                    case "HRM":
                        $arr =  explode('+',  $useraccess->hrm);
                        break;
                    case "Merchant":
                        $arr =  explode('+',  $useraccess->merchant);
                        break;

                        case "Payout":
                            $arr =  explode('+',  $useraccess->payout);
                            break;

                    default:
                        echo "";
                }

                if ($module->link_name == 'Finance') {
                }

                $check =  array_search($submodule->id, $arr);
                if ($check) {
                    $submodule->status = 1;
                } else {
                    $submodule->status = 0;
                }
            }
        }

        return view('employee.hrm.employeeaccess', compact('allmodules', 'id'));
    }

    public function editemployeeAccess(Request $request)
    {
        
        $id = $request->userid;
        if ($request->has('Account')) {

            $modules = $request->Account;
            $parentid = 1;
            array_unshift($modules, $parentid);
            $finalArr = implode("+", $modules);
            $insert = DB::table('nav_permission')->where('employee_id', $id)->update([
                'account' => $finalArr
            ]);
        }
        else {

            $insert = DB::table('nav_permission')->where('employee_id', $id)->update([
                'account' => ''
            ]);
        }

        if ($request->has('Finance')) {

            $modules = $request->Finance;
            $parentid = 2;
            array_unshift($modules, $parentid);
            $finalArr = implode("+", $modules);

            $insert = DB::table('nav_permission')->where('employee_id', $id)->update([
                'finance' => $finalArr
            ]);
        }
        else {

            $insert = DB::table('nav_permission')->where('employee_id', $id)->update([
                'finance' => ''
            ]);
        }

        if ($request->has('Settlement')) {

            $modules = $request->Settlement;
            $parentid = 3;
            array_unshift($modules, $parentid);
            $finalArr = implode("+", $modules);

            $insert = DB::table('nav_permission')->where('employee_id', $id)->update([
                'settlement' => $finalArr
            ]);
        }
        else {

            $insert = DB::table('nav_permission')->where('employee_id', $id)->update([
                'settlement' => ''
            ]);
        }

        if ($request->has('Technical')) {
            $modules = $request->Technical;
            $parentid = 4;
            array_unshift($modules, $parentid);
            $finalArr = implode("+", $modules);

            $insert = DB::table('nav_permission')->where('employee_id', $id)->update([
                'technical' => $finalArr
            ]);
        }
        else {

            $insert = DB::table('nav_permission')->where('employee_id', $id)->update([
                'technical' => ''
            ]);
        }

        if ($request->has('Networking')) {
            $modules = $request->Networking;
            $parentid = 5;
            array_unshift($modules, $parentid);
            $finalArr = implode("+", $modules);
      
            $insert = DB::table('nav_permission')->where('employee_id', $id)->update([
                'networking' => $finalArr
            ]);
        }
        else {
            $insert = DB::table('nav_permission')->where('employee_id', $id)->update([
                'networking' => ''
            ]);
        }

        if ($request->has('Support')) {
            $modules = $request->Support;
            $parentid = 6;
            array_unshift($modules, $parentid);
            $finalArr = implode("+", $modules);
      
            $insert = DB::table('nav_permission')->where('employee_id', $id)->update([
                'support' => $finalArr
            ]);
        }
        else {
            $insert = DB::table('nav_permission')->where('employee_id', $id)->update([
                'support' => ''
            ]);
        }

        if ($request->has('Marketing')) {
            $modules = $request->Marketing;
            $parentid = 7;
            array_unshift($modules, $parentid);
            $finalArr = implode("+", $modules);
      
            $insert = DB::table('nav_permission')->where('employee_id', $id)->update([
                'marketing' => $finalArr
            ]);
        }
        else {
            $insert = DB::table('nav_permission')->where('employee_id', $id)->update([
                'marketing' => ''
            ]);
        }

        if ($request->has('Sales')) {
            $modules = $request->Sales;
            $parentid = 8;
            array_unshift($modules, $parentid);
            $finalArr = implode("+", $modules);
      
            $insert = DB::table('nav_permission')->where('employee_id', $id)->update([
                'sales' => $finalArr
            ]);
        }
        else {
            $insert = DB::table('nav_permission')->where('employee_id', $id)->update([
                'sales' => ''
            ]);
        }

        if ($request->has('risk_complaince')) {
            $modules = $request->risk_complaince;
            $parentid = 9;
            array_unshift($modules, $parentid);
            $finalArr = implode("+", $modules);
      
            $insert = DB::table('nav_permission')->where('employee_id', $id)->update([
                'risk_complaince' => $finalArr
            ]);
        }
        else {
            $insert = DB::table('nav_permission')->where('employee_id', $id)->update([
                'risk_complaince' => ''
            ]);
        }

        if ($request->has('Legal')) {
            $modules = $request->Legal;
            $parentid = 10;
            array_unshift($modules, $parentid);
            $finalArr = implode("+", $modules);
      
            $insert = DB::table('nav_permission')->where('employee_id', $id)->update([
                'legal' => $finalArr
            ]);
        }
        else {
            $insert = DB::table('nav_permission')->where('employee_id', $id)->update([
                'legal' => ''
            ]);
        }

        if ($request->has('HRM')) {
            $modules = $request->HRM;
            $parentid = 97;
            array_unshift($modules, $parentid);
            $finalArr = implode("+", $modules);
      
            $insert = DB::table('nav_permission')->where('employee_id', $id)->update([
                'hrm' => $finalArr
            ]);
        }
        else {
            $insert = DB::table('nav_permission')->where('employee_id', $id)->update([
                'hrm' => ''
            ]);
        }

        if ($request->has('Merchant')) {
            $modules = $request->Merchant;
            $parentid = 225;
            array_unshift($modules, $parentid);
            $finalArr = implode("+", $modules);
      
            $insert = DB::table('nav_permission')->where('employee_id', $id)->update([
                'merchant' => $finalArr
            ]);
        }
        else {
            $insert = DB::table('nav_permission')->where('employee_id', $id)->update([
                'merchant' => ''
            ]);
        }

        if ($request->has('Payout')) {
            $modules = $request->Payout;
            $parentid = 255;
            array_unshift($modules, $parentid);
            $finalArr = implode("+", $modules);
      
            $insert = DB::table('nav_permission')->where('employee_id', $id)->update([
                'payout' => $finalArr
            ]);
        }
        else {
            $insert = DB::table('nav_permission')->where('employee_id', $id)->update([
                'payout' => ''
            ]);
        }

        return redirect()->back();

    

       
    }  

    public function merchantadd(Request $request)         
    
    {
                    $businesstype = DB::table('business_type')->get();
                    $businessCategory = DB::table('business_category')->get();
                    $businessSubcategory = DB::table('business_sub_category')->get();
                    $monthlyExpenditure = DB::table('app_option')->where('module', 'merchant_business')->get();
                    $merchant = DB::table('app_option')->where('module', 'merchant_business')->get();

        return view("employee.riskcomplaince.merchantadd")->with(["businesstype" => $businesstype, "businesscategory" => $businessCategory, "businesssubcategory" => $businessSubcategory,
        "monthlyExpenditure" => $monthlyExpenditure]);
        // return view("employee.riskcomplaince.merchantnewdocument");
        // ->with(["sublinks" => $sublinks, "sublink_name" => $sublink_name]);
        // return view("merchantnewdocument");
    }

    public function checkEmail(Request $request)
    {
        $email = $request->input('email');
        $user = User::where('email', $email)->first();
        if ($user) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
    }
    

    // public function curltest(Request $request){
    //     $livepostData = [
          
	// 		"mid" => '900014',
	// 		"mname" => "kousyv",
	// 		"secret_key"=> "01YRIGUJIU91MDIP",
	// 		"salt_key"=> "FQWGZnbhdPWFWM5G",
	// 		"merchant_api_key"=>"Dz4fdderJ5vTj",
	// 		"checksum_key"=> "E2FK67JNBHD22PN"
	// ];
	
	// $liveapiUrl = "https://paymentgateway.flakpay.com/fpay/setmerchantConfig";

	// $livejsonData = json_encode($livepostData);

	// $livech = curl_init($liveapiUrl);
	
	// curl_setopt($livech, CURLOPT_RETURNTRANSFER, true);
	// curl_setopt($livech, CURLOPT_POST, true);
	// curl_setopt($livech, CURLOPT_FOLLOWLOCATION, true);

	// curl_setopt($livech, CURLOPT_POSTFIELDS, $livejsonData);
	// curl_setopt($livech, CURLOPT_SSL_VERIFYPEER,false); 
	// curl_setopt($livech, CURLOPT_HTTPHEADER, [  
    //     'Content-Length: ' . strlen($livejsonData),
	// 	'Content-Type: application/json',
	// ]);
	
  

	// $liveresponse = curl_exec($livech);
	// echo '<pre>';
    // print_r(curl_getinfo($livech));
    // print_r($liveresponse);

	// $statusCode = curl_getinfo($livech, CURLINFO_HTTP_CODE);

	// curl_close($livech);
    // }  
}

    

