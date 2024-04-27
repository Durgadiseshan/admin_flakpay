<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\SIDController;
use App\Http\Controllers\MailController;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


Route::any('/login', function (){
        return redirect('/flakpay/login');
});

Route::get('/sitemap.xml', function (){
    View::addExtension('xml','php');
    return response(file_get_contents(resource_path('views/sitemap.xml')), 200, [
        'Content-Type' => 'application/xml'
    ]);
});

Route::get('/googlea59b5d17aca07eef.html', function (){
    View::addExtension('html','php');
    return View::make('googlea59b5d17aca07eef');
});


$uri = Request::path();


$routes = [
    'about','contact','blog','event','payment-gateway','payment-pages','payment-link','subscription',
    'dev-doc','integration','rpay-mudra','rpay-punji','rpay-tej','rpay-wallet','rpay-epos','rpay-credit-card',
    'rpay-ivr','banking','education','ecommerce','route','invoice','index.html','rpay-doc','disclaimer','privacy'
    ,'term&condition','agreement','covid','saas','upi','customer-stories','partner','customer-stories','adjustment-guide','api'
];

if(in_array($uri,$routes))
{
    Route::get("/".$uri,function () {
        View::addExtension('html','php');
        return View::make('index');
    });
}


Route::get('/pricing', function () {
    View::addExtension('html','php');
    return View::make('index');
});



Route::get('/reload-captcha', function () {
    return captcha_src('flat');
});


Route::get("/chart", function () {
    return View::make("am_chart.amchart1");
});


Route::any('/flakpay/settlement/test', 'Admin\SettlementController@test')->name('test');

/* 
 * Merchant Funcionality Controller Routes 
 */
Auth::routes();

Route::get('/', 'MerchantController@index')->name('dashboard');

Route::get('/apitest', 'MerchantController@apitest')->name('apitest');

Route::get('/view_logs', 'VerifyController@viewlog');

Route::post('/mobile-register', 'Auth\RegisterController@mobile_register');

Route::get('/demo', 'VerifyController@demo_page');

Route::post('/demo/request', 'VerifyController@demo_request')->name("test-demo-request");

Route::post('/verify-login', 'Auth\LoginController@verifyLogin');

Route::get('/resend-mobile-otp', 'Auth\RegisterController@resend_mobileOTP');

Route::post('/verify-mobile', 'VerifyController@verify_mobile_number')->name("mverification");

Route::get('/contact', 'VerifyController@contact_us');

Route::get('/forgotpassword', 'VerifyController@forgotpassword');

Route::get('/loginform', 'VerifyController@loginform');

Route::get('/registerform', 'VerifyController@registerform');

Route::post('/contact-us-form', 'VerifyController@rupayapay_contactus')->name('contact-us');

Route::post('/subscribe-us', 'VerifyController@rupayapay_subscribe')->name('subscribe-us');

Route::get('/blog', 'VerifyController@blog');

Route::get('/blog/{postid}', 'VerifyController@blog_post')->name('blog-post');

Route::get('/event', 'VerifyController@event');

Route::get('/event/{postid}', 'VerifyController@event_post')->name('event-post');

Route::get('/csr/{postid}', 'VerifyController@csr_post')->name('csr-post');

Route::get('/press-release/{postid}', 'VerifyController@pr_post')->name('pr-post');

Route::get('/gallery', 'VerifyController@gallery')->name('gallery');

Route::get('/career', 'VerifyController@career')->name('career');

Route::get('/integration', 'VerifyController@integration')->name('integration');

Route::get('/career/job/description/{id}', 'VerifyController@get_job_description');

Route::post('/career/job/apply', 'VerifyController@store_applicant');

Route::get('/csr', 'VerifyController@csr')->name('csr');

Route::get('/press-release', 'VerifyController@press_release')->name('press-release');

Route::get('/rupayapay-qrcode/{id}', 'VerifyController@generate_qrcode');

Route::get('/verify-account/{token}', 'VerifyController@verify_email_account')->name('verify-account');

Route::post('/rupayapay-webhook', 'VerifyController@get_webhook_detail');

Route::get('/payout-response', 'VerifyController@payout_response');

Route::get("/session-timeout", 'VerifyController@session_timeout')->name("session-timeout");

/* 
 * Employee Funcionality Controller Routes
 * 
 */

Route::group(['prefix' => 'flakpay'], function () {
    // Login Routes...
    Route::get('login', ['as' => 'rupayapay.login', 'uses' => 'EmployeeAuth\LoginController@showLoginForm']);
    Route::post('login', ['uses' => 'EmployeeAuth\LoginController@login']);
    Route::post('logout', ['as' => 'rupayapay.logout', 'uses' => 'EmployeeAuth\LoginController@logout']);

    // Registration Routes...
    Route::get('register', ['as' => 'rupayapay.register', 'uses' => 'EmployeeAuth\RegisterController@showRegistrationForm']);
    Route::post('register', ['uses' => 'EmployeeAuth\RegisterController@register']);

    // Password Reset Routes...
    Route::get('password/reset', ['as' => 'rupayapay.password.reset', 'uses' => 'EmployeeAuth\ForgotPasswordController@showLinkRequestForm']);
    Route::post('password/email', ['as' => 'rupayapay.password.email', 'uses' => 'EmployeeAuth\ForgotPasswordController@sendResetLinkEmail']);
    Route::get('password/reset/{token}', ['as' => 'rupayapay.password.reset.token', 'uses' => 'EmployeeAuth\ResetPasswordController@showResetForm']);
    Route::post('password/reset', ['uses' => 'EmployeeAuth\ResetPasswordController@reset']);

    Route::get("/session-timeout", 'VerifyController@emp_session_timeout');

    Route::post("/update-lastlogin", "VerifyController@emp_session_update")->name("emp-session-update");

    Route::get('admin-forget-password', ['uses' => 'EmployeeAuth\ForgotPasswordController@admin_forget_password']);
});

Route::get('/rockpay/generateid', function () {
    return "ryapay-" . Str::random(8);  
});

Route::post('/flakpay/verify-credentials', 'EmployeeAuth\LoginController@verifyLogin');

Route::get('/flakpay/load-login-forms', 'EmployeeAuth\LoginController@load_login_forms');

Route::post('/rockpay/email-verify-otp', 'EmployeeAuth\LoginController@rupayapay_verify_email_otp')->name('rupayapay-email-verify');

Route::post('/rockpay/mobile-verify-otp', 'EmployeeAuth\LoginController@rupayapay_verify_mobile_otp')->name('rupayapay-mobile-verify');

Route::get('/rockpay/ft-password-change/send-otp-mobile', 'EmployeeAuth\LoginController@load_change_password_form')->name('send-otp-mobile');

Route::post('/rockpay/ft-password-change/verify-empmobile-otp', 'EmployeeAuth\LoginController@verify_empmobile_OTP')->name('verify-empmobile-otp');

Route::post('/rockpay/ft-password-change/ftpassword-change', 'EmployeeAuth\LoginController@change_ftemppassword')->name('ftpassword-change');

Route::get('/flakpay/dashboard', 'EmployeeController@index')->name('flakpay-dashboard');
Route::any('/flakpaydashboard/ajax', 'EmployeeController@dashboardAjax');

Route::get('/flakpay/dashboardGraphData', 'EmployeeController@dashboardTransactionGraph')->name('dashboardTransactionGraph');

Route::get('/flakpay/dashboard_transactionstats', 'EmployeeController@dashboardTransactionStats')->name('dashboardTransactionStats');
Route::get('/excel-export-successratio', 'EmployeeController@excelExportSuccessratio')->name('excel.export.successratio');

//payout
Route::get('/flakpay/payout_dashboard', 'EmployeeController@payoutDashboard')->name('payoutDashboard');
Route::get('/flakpay/payout_dashboard_transactionstats', 'EmployeeController@payoutdashboardTransactionStats')->name('payoutdashboardTransactionStats');
Route::get('/flakpay/payout_dashboard_graph', 'EmployeeController@payoutDashboardGraph')->name('payoutDashboardGraph');
Route::get('/flakpay/price_setting', 'EmployeeController@priceSetting')->name('priceSetting');
Route::get('/flakpay/price_setting/{id}', 'EmployeeController@priceSettingofUser')->name('priceSettingofUser');
Route::post('/flakpay/save_price_setting', 'EmployeeController@savePriceSetting')->name('savePriceSetting');
Route::post('/flakpay/delete_price_setting', 'EmployeeController@deletePriceSetting')->name('deletePriceSetting');
Route::post('/flakpay/edit_price_setting', 'EmployeeController@editPriceSetting')->name('editPriceSetting');
Route::get('/flakpay/routing_config', 'EmployeeController@routingConfig')->name('routingConfig');
Route::post('/rockpay/save_routing_config', 'EmployeeController@saveRoutingConfig')->name('saveRoutingConfig');
Route::post('/rockpay/delete_routing_config', 'EmployeeController@deleteRoutingConfig')->name('deleteRoutingConfig');
Route::post('/rockpay/edit_routing_config', 'EmployeeController@editRoutingConfig')->name('editRoutingConfig');

Route::get('/flakpay/payout_transactions', 'EmployeeController@payoutTransacations')->name('payouttransactions');
Route::get('/flakpay/payout_get_transactions', 'EmployeeController@getPayouttransactions')->name('getPayouttransactions');
Route::get('/flakpay/payout_transaction_info', 'EmployeeController@payoutTransactionInfo')->name('payoutTransactionInfo');
Route::get('/flakpay/update_payout_transaction_status', 'EmployeeController@updatePayoutTransactionStatus')->name('updatePayoutTransactionStatus');
//endpayout

Route::get('/rockpay/email-otp', 'VerifyController@rupayapay_email_otp')->name('rupayapay-email');

Route::get('/rockpay/ft-password-change', 'VerifyController@firsttime_passwordchange')->name('rupayapay-ft-password');

Route::get('/rockpay/mobile-otp', 'VerifyController@rupayapay_mobile_otp')->name('rupayapay-mobile');

Route::post('/rockpay/verify-employee-email', 'EmployeeAuth\ForgotPasswordController@verify_email');

Route::get('/rockpay/load-email-form', 'EmployeeAuth\ForgotPasswordController@load_email_form');

Route::post('/rockpay/employee-verify-email-otp', 'EmployeeAuth\ForgotPasswordController@verify_email_otp');

Route::get('/rockpay/load-mobile-form', 'EmployeeAuth\ForgotPasswordController@load_mobile_form');

Route::post('/rockpay/employee-verify-mobile-otp', 'EmployeeAuth\ForgotPasswordController@verify_mobile_otp');

Route::get('/rockpay/admin-reset-password', 'EmployeeAuth\ForgotPasswordController@load_reset_password_form');

Route::post('/rockpay/reset-admin-password', 'EmployeeAuth\ResetPasswordController@reset_admin_password');

Route::post('/rockpay/send-again-mobile-otp', 'VerifyController@sendagain_rupayapay_empOTP')->name('send-again-mobile-otp');

/**
 * 
 * Accounting Module Routing Starts here
 */

Route::get('/flakpay/account/payable-management/{id}', 'EmployeeController@account')->name('account-payable');

Route::get('/rockpay/account/payable-management/supplier-invoice/create', 'EmployeeController@show_supplier_invoice')->name('new-supplier-invoice');

Route::get('/flakpay/account/receivable-management/{id}', 'EmployeeController@account')->name('account-receivable');

Route::get('/flakpay/account/fixed-assets-accounting/{id}', 'EmployeeController@account')->name('account-fixed-assets');

Route::get('/flakpay/account/global-taxation-solution/{id}', 'EmployeeController@account')->name('account-global-tax');

Route::get('/flakpay/account/global-taxation-solution/tax-settlement/create', 'EmployeeController@show_tax_settlement')->name('create-tax-settlement');

Route::get('/rockpay/account/global-taxation-solution/tax-settlement/get/{id}', 'EmployeeController@get_tax_settlement')->name('get-tax-settlement');

Route::post('/rockpay/account/global-taxation-solution/tax-settlement/new', 'EmployeeController@store_tax_settlement')->name('new-tax-settlement');

Route::get('/flakpay/account/global-taxation-solution/tax-adjustment/create', 'EmployeeController@show_tax_adjustment')->name('create-tax-adjustment');

Route::get('/rockpay/account/global-taxation-solution/tax-adjustment/get/{id}', 'EmployeeController@get_tax_adjustment')->name('get-tax-adjustment');

Route::post('/rockpay/account/global-taxation-solution/tax-adjustment/new', 'EmployeeController@store_tax_adjustment')->name('new-tax-adjustment');

Route::get('/flakpay/account/global-taxation-solution/tax-payment/create', 'EmployeeController@show_tax_payment')->name('create-tax-payment');

Route::get('/rockpay/account/global-taxation-solution/tax-payment/get/{id}', 'EmployeeController@get_tax_payment')->name('get-tax-payment');

Route::post('/rockpay/account/global-taxation-solution/tax-payment/new', 'EmployeeController@store_tax_payment')->name('new-tax-payment');

Route::get('/flakpay/account/account-charts/{id}', 'EmployeeController@account')->name('get-chart');

Route::get('/flakpay/account/book-keeping/{id}', 'EmployeeController@account')->name('get-book-keeping');


/**
 * Account Purchase Order CRUD Operations Routes
 */

Route::get('/rockpay/account/purchase-order/get-supplier/{id}', 'EmployeeController@get_selected_supplier_info')->name('get-supplier');
Route::get('/rockpay/account/payable-management/purchasae-order/get-all-purchase-order/{id}', 'EmployeeController@get_purchase_order')->name('get-all-purchase-order');
Route::get('/rockpay/account/payable-management/purchase-order/create', 'EmployeeController@show_purchase_order')->name('create-purchase-order');
Route::post('/rockpay/account/payable-management/purchase-order/new', 'EmployeeController@store_purchase_order')->name('new-purchase-order');
Route::post('/rockpay/account/payable-management/purchase-order/update', 'EmployeeController@update_purchase_order')->name('update-purchase-order');
Route::get('/rockpay/account/payable-management/purchase-order/edit/{id}', 'EmployeeController@edit_purchase_order')->name('edit-purchase-order');

/**
 * Account Supplier Order CRUD Operations Routes
 */
Route::get('/rockpay/account/payable-management/suporder-invoice/get-purchase-order-items/{id}', 'EmployeeController@get_purchase_order_items')->name('get-purchase-order-items');
Route::get('/rockpay/account/payable-management/suporder-invoice/get-all-suporder-invoice/{id}', 'EmployeeController@get_suporder_invoice')->name('get-all-suporder-invoice');
Route::get('/rockpay/account/payable-management/suporder-invoice/create', 'EmployeeController@show_suporder_invoice')->name('create-suporder-invoice');
Route::post('/rockpay/account/payable-management/suporder-invoice/new', 'EmployeeController@store_suporder_invoice')->name('new-suporder-invoice');
Route::post('/rockpay/account/payable-management/suporder-invoice/update', 'EmployeeController@update_suporder_invoice')->name('update-suporder-invoice');
Route::get('/rockpay/account/payable-management/suporder-invoice/edit/{id}', 'EmployeeController@edit_suporder_invoice')->name('edit-suporder-invoice');

/**
 * Account Expense Invoice Suppliers CRUD Operations Routes
 */
Route::get('/rockpay/account/payable-management/supexp-invoice/get-all-supexp-invoice/{id}', 'EmployeeController@get_supexp_invoice')->name('get-all-suppexp-invoice');
Route::get('/flakpay/account/payable-management/supexp-invoice/create', 'EmployeeController@show_supexp_invoice')->name('create-supexp-invoice');
Route::post('/rockpay/account/payable-management/supexp-invoice/new', 'EmployeeController@store_supexp_invoice')->name('new-supexp-invoice');
Route::post('/rockpay/account/payable-management/supexp-invoice/update', 'EmployeeController@update_supexp_invoice')->name('update-supexp-invoice');
Route::get('/rockpay/account/payable-management/supexp-invoice/edit/{id}', 'EmployeeController@edit_supexp_invoice')->name('edit-supexp-invoice');

/**
 * Account Suppliers Credit Debit Note CRUD Operations Routes
 */
Route::get('/rockpay/account/payable-management/debit-note/get-all-supcd-note/{id}', 'EmployeeController@get_supcd_note')->name('get-all-supcd-note');
Route::get('/flakpay/account/payable-management/debit-note/create', 'EmployeeController@show_debit_note')->name('new-debit-note');
Route::post('/rockpay/account/payable-management/debit-note/new', 'EmployeeController@store_supcd_note')->name('store-supcd-note');
Route::get('/rockpay/account/payable-management/debit-note/edit/{id}', 'EmployeeController@edit_supcd_note')->name('edit-supcd-note');
Route::post('/rockpay/account/payable-management/debit-note/update', 'EmployeeController@update_supcd_note')->name('update-supcd-note');

/**
 * Account Purchase Order CRUD Operations Routes
 */

Route::get('/rockpay/account/receivable-management/sales-order/get-customer/{id}', 'EmployeeController@get_selected_customer_info')->name('get-customer-info');
Route::get('/rockpay/account/receivable-management/sales-order/get-all-sales-order/{id}', 'EmployeeController@get_sales_order')->name('get-all-sales-order');
Route::get('/flakpay/account/receivable-management/sales-order/create', 'EmployeeController@show_sales_order')->name('create-sales-order');
Route::post('/rockpay/account/receivable-management/sales-order/new', 'EmployeeController@store_sales_order')->name('new-sales-order');
Route::post('/rockpay/account/receivable-management/sales-order/update', 'EmployeeController@update_sales_order')->name('update-sales-order');
Route::get('/rockpay/account/receivable-management/sales-order/edit/{id}', 'EmployeeController@edit_sales_order')->name('edit-sales-order');

/**
 * Account Customer Order Invoice CRUD Operations Routes
 */
Route::get('/rockpay/account/receivable-management/custorder-invoice/get-sales-order-items/{id}', 'EmployeeController@get_sales_order_items')->name('get-sales-order-items');
Route::get('/rockpay/account/receivable-management/custorder-invoice/get-all-custorder-invoice/{id}', 'EmployeeController@get_custorder_invoice')->name('get-all-custorder-invoice');
Route::get('/flakpay/account/receivable-management/custorder-invoice/create', 'EmployeeController@show_custorder_invoice')->name('create-custorder-invoice');
Route::post('/rockpay/account/receivable-management/custorder-invoice/new', 'EmployeeController@store_custorder_invoice')->name('new-custorder-invoice');
Route::post('/rockpay/account/receivable-management/custorder-invoice/update', 'EmployeeController@update_custorder_invoice')->name('update-custorder-invoice');
Route::get('/rockpay/account/receivable-management/custorder-invoice/edit/{id}', 'EmployeeController@edit_custorder_invoice')->name('edit-custorder-invoice');

/**
 * Account Customer Credit Debit Note CRUD Operations Routes
 */
Route::get('/rockpay/account/receivable-management/debit-note/get-all-custcd-note/{id}', 'EmployeeController@get_custcd_note')->name('get-all-custcd-note');
Route::get('/flakpay/account/receivable-management/debit-note/create', 'EmployeeController@show_custcd_note')->name('new-custcd-note');
Route::post('/rockpay/account/receivable-management/debit-note/new', 'EmployeeController@store_custcd_note')->name('store-custcd-note');
Route::get('/rockpay/account/receivable-management/debit-note/edit/{id}', 'EmployeeController@edit_custcd_note')->name('edit-custcd-note');
Route::post('/rockpay/account/receivable-management/debit-note/update', 'EmployeeController@update_custcd_note')->name('update-custcd-note');


/**
 * Account Invoice Items CRUD Operations Routes 
 */
Route::get('/rockpay/account/fixed-asset/get-all-assets/{id}', 'EmployeeController@get_all_assets')->name('get-all-assets');

Route::post('/rockpay/account/fixed-asset/new', 'EmployeeController@store_asset')->name('add-new-asset');

Route::get('/rockpay/account/fixed-asset/edit/{id}', 'EmployeeController@edit_asset')->name('edit-asset');

Route::post('/rockpay/account/fixed-asset/update', 'EmployeeController@update_asset')->name('update-asset');

Route::get('/rockpay/account/fixed-asset/get-all-capital-assets/{id}', 'EmployeeController@get_all_capital_assets')->name('get-all-capital-assets');

Route::get('/rockpay/account/fixed-asset/get-all-depreciate-assets/{id}', 'EmployeeController@get_all_depreciate_assets')->name('get-all-depreciate-assets');

Route::get('/rockpay/account/fixed-asset/get-all-sale-assets/{id}', 'EmployeeController@get_all_sale_assets')->name('get-all-sale-assets');

Route::post('/rockpay/account/fixed-asset/capital/update', 'EmployeeController@update_capital_asset')->name('update-capital-asset');

Route::post('/rockpay/account/fixed-asset/depreciate/update', 'EmployeeController@update_depreciate_asset')->name('update-depreciate-asset');

Route::post('/rockpay/account/fixed-asset/sale/update', 'EmployeeController@update_sale_asset')->name('update-sale-asset');

Route::get('/rockpay/account/vouchers/get-all-vouchers/{id}', 'EmployeeController@get_all_vouchers')->name('get-all-vouchers');

Route::post('/rockpay/account/voucher/new', 'EmployeeController@store_voucher')->name('add-new-voucher');

Route::get('/rockpay/account/voucher/edit/{id}', 'EmployeeController@edit_voucher')->name('edit-voucher');

Route::post('/rockpay/account/voucher/update', 'EmployeeController@update_voucher')->name('update-voucher');

Route::get('/flakpay/account/invoice/{id}', 'EmployeeController@account')->name('invoice');

/**
 * Account Invoice Invoices CRUD Operations Routes
 */
Route::get('/rockpay/account/invoice/invoices/get-all-invoices/{id}', 'EmployeeController@get_all_invoices')->name('get-all-invoices');

Route::get('/rockpay/account/invoice/invoices/get-all-items-options', 'EmployeeController@get_all_item_options')->name('get-all-item-options');

Route::get('/rockpay/account/invoice/invoice/get-customer-info/{id}', 'EmployeeController@get_customer_details')->name('get-customer-details');

Route::get('/rockpay/account/invoice/invoices/get-all-customer-options', 'EmployeeController@get_all_customer_options')->name('get-all-customer-options');

Route::post("/rockpay/account/invoice/invoice/customer-address/add", 'EmployeeController@store_customer_address')->name('add-new-customer-address');

Route::post("/rockpay/account/invoice/invoice/customer-address/update", 'EmployeeController@update_customer_address')->name('update-customer-address');

Route::get("/rockpay/account/invoice/invoices/show", 'EmployeeController@show_invoice')->name('show-new-invoice');

Route::post('/rockpay/account/invoice/invoices/new', 'EmployeeController@store_invoice')->name('add-new-invoice');

Route::get('/rockpay/account/invoice/invoices/edit/{id}', 'EmployeeController@edit_invoice')->name('edit-invoice');

Route::post('/rockpay/account/invoice/invoices/update', 'EmployeeController@update_invoice')->name('update-invoice');

Route::post('/rockpay/account/invoice/invoices/destroy', 'EmployeeController@destroy_invoice')->name('destroy-invoice');

/**
 * Account Invoice Items CRUD Operations Routes
 */
Route::get('/rockpay/account/invoice/items/get-all-items/{id}', 'EmployeeController@get_all_items')->name('get-all-items');

Route::post('/rockpay/account/invoice/item/new', 'EmployeeController@store_item')->name('add-new-item');

Route::get('/rockpay/account/invoice/item/edit/{id}', 'EmployeeController@edit_item')->name('edit-item');

Route::post('/rockpay/account/invoice/item/update', 'EmployeeController@update_item')->name('update-item');

Route::post('/rockpay/account/invoice/item/destroy', 'EmployeeController@destroy_item')->name('destroy-item');

Route::get('/rockpay/account/invoice/item/get-item-options', 'EmployeeController@get_item_options')->name('get-item-options');

/**
 * Account Invoice Customers CRUD Operations Routes
 */
Route::get('/rockpay/account/invoice/customers/get-all-customers/{id}', 'EmployeeController@get_all_customers')->name('get-all-customers');

Route::post('/rockpay/account/invoice/customer/new', 'EmployeeController@store_customer')->name('add-new-customer');

Route::get('/rockpay/account/invoice/customer/edit/{id}', 'EmployeeController@edit_customer')->name('edit-customer');

Route::post('/rockpay/account/invoice/customer/update', 'EmployeeController@update_customer')->name('update-customer');

Route::post('/rockpay/account/invoice/customer/destroy', 'EmployeeController@destroy_customer')->name('destroy-customer');

/**
 * Account Invoice Suppliers CRUD Operations Routes
 */
Route::get('/rockpay/account/invoice/suppliers/get-all-suppliers/{id}', 'EmployeeController@get_all_suppliers')->name('get-all-suppliers');

Route::post('/rockpay/account/invoice/supplier/new', 'EmployeeController@store_supplier')->name('add-new-supplier');

Route::get('/rockpay/account/invoice/supplier/edit/{id}', 'EmployeeController@edit_supplier')->name('edit-supplier');

Route::post('/rockpay/account/invoice/supplier/update', 'EmployeeController@update_supplier')->name('update-supplier');

Route::post('/rockpay/account/invoice/supplier/destroy', 'EmployeeController@destroy_supplier')->name('destroy-supplier');


Route::get('/rockpay/get-chart-options', 'EmployeeController@get_chart_options');

Route::get('/rockpay/edit-chart-record/{id}', 'EmployeeController@edit_chart_record');

Route::get('/rockpay/account/charts-account/get-chart/{id}', 'EmployeeController@get_allchart_details')->name('get-all-chart');

Route::post('/rockpay/account/charts-account/add', 'EmployeeController@store_accountchart')->name('store-chart');

Route::get('/flakpay/finance/payable-management/{id}', 'EmployeeController@finance')->name('finance-payable');
Route::get('/flakpay/finance/receivable-management/{id}', 'EmployeeController@finance')->name('finance-receivable');

/**
 * 
 * Finance Payable Management Supplier Pay Batch Entry routing starts here
 */
Route::get('/rockpay/finance/payable-management/supplier-paybatch/get/{id}', 'EmployeeController@get_supp_paybatch');
Route::get('/rockpay/finance/payable-management/supplier-paybatch/create', 'EmployeeController@show_supp_paybatch')->name('supp-paybatch-show');
Route::post('/rockpay/finance/payable-management/supplier-paybatch/add', 'EmployeeController@store_supp_paybatch')->name('supp-paybatch-add');
Route::get('/rockpay/finance/payable-management/supplier-paybatch/edit/{id}', 'EmployeeController@edit_supp_paybatch')->name('supp-paybatch-edit');
Route::post('/rockpay/finance/payable-management/supplier-paybatch/update', 'EmployeeController@update_supp_paybatch')->name('supp-paybatch-update');

/**
 * 
 * Finance Sundry Payment Entry routing starts here
 */
Route::get('/rockpay/finance/payable-management/sundry-payment/get/invoice-no/{id}', 'EmployeeController@get_invoice_no');
Route::get('/rockpay/finance/payable-management/sundry-payment/get/{id}', 'EmployeeController@get_sundry_payment');
Route::get('/flakpay/finance/payable-management/sundry-payment/create', 'EmployeeController@show_sundry_payment')->name('sundry-payment-show');
Route::post('/rockpay/finance/payable-management/sundry-payment/add', 'EmployeeController@store_sundry_payment')->name('sundry-payment-add');
Route::get('/rockpay/finance/payable-management/sundry-payment/edit/{id}', 'EmployeeController@edit_sundry_payment')->name('sundry-payment-edit');
Route::post('/rockpay/finance/payable-management/sundry-payment/update', 'EmployeeController@update_sundry_payment')->name('sundry-payment-update');
/**
 * 
 * Finance Payable management Bank starts here
 */
Route::get('/rockpay/finance/payable-management/bank/get/{id}', 'EmployeeController@get_banks_info');
Route::post('/rockpay/finance/payable-management/bank/add', 'EmployeeController@store_bank_info')->name('bank-add');
Route::get('/rockpay/finance/payable-management/bank/edit/{id}', 'EmployeeController@edit_bank_info')->name('bank-edit');
Route::post('/rockpay/finance/payable-management/bank/update', 'EmployeeController@update_bank_info')->name('bank-update');

/**
 * 
 * Finance Contra Entry routing starts here
 */
Route::get('/rockpay/finance/payable-management/contra-entry/get/{id}', 'EmployeeController@get_contra_entry');
Route::get('/flakpay/finance/payable-management/contra-entry/create', 'EmployeeController@show_contra_entry')->name('contra-entry-show');
Route::post('/rockpay/finance/payable-management/contra-entry/add', 'EmployeeController@store_contra_entry')->name('contra-entry-add');
Route::get('/rockpay/finance/payable-management/contra-entry/edit/{id}', 'EmployeeController@edit_contra_entry')->name('contra-entry-edit');
Route::post('/rockpay/finance/payable-management/contra-entry/update', 'EmployeeController@update_contra_entry')->name('contra-entry-update');

/**
 * 
 * Finance Receivable management Customer Direct Entry starts here
 */
Route::get('/rockpay/finance/receivable-management/cust-dreceipt-entry/get/invoice-no/{id}', 'EmployeeController@get_saleinvoice_no');
Route::get('/rockpay/finance/receivable-management/cust-dreceipt-entry/get/{id}', 'EmployeeController@get_cust_dreceipt_entry');
Route::get('/rockpay/finance/receivable-management/cust-dreceipt-entry/create', 'EmployeeController@show_cust_dreceipt_entry')->name('cust-dreceipt-entry-show');
Route::post('/rockpay/finance/receivable-management/cust-dreceipt-entry/add', 'EmployeeController@store_cust_dreceipt_entry')->name('cust-dreceipt-entry-add');
Route::get('/rockpay/finance/receivable-management/cust-dreceipt-entry/edit/{id}', 'EmployeeController@edit_cust_dreceipt_entry')->name('cust-dreceipt-entry-edit');
Route::post('/rockpay/finance/receivable-management/cust-dreceipt-entry/update', 'EmployeeController@update_cust_dreceipt_entry')->name('cust-dreceipt-entry-update');
/**
 * 
 * Finance Receivable management Sundry receipt Entry starts here
 */
Route::get('/rockpay/finance/receivable-management/sundry-receipt/get/{id}', 'EmployeeController@get_sundry_receipt');
Route::get('/flakpay/finance/receivable-management/sundry-receipt/create', 'EmployeeController@show_sundry_receipt')->name('sundry-receipt-show');
Route::post('/rockpay/finance/receivable-management/sundry-receipt/add', 'EmployeeController@store_sundry_receipt')->name('sundry-receipt-add');
Route::get('/rockpay/finance/receivable-management/sundry-receipt/edit/{id}', 'EmployeeController@edit_sundry_receipt')->name('sundry-receipt-edit');
Route::post('/rockpay/finance/receivable-management/sundry-receipt/update', 'EmployeeController@update_sundry_receipt')->name('sundry-receipt-update');

/**
 * 
 * Settlement Transaction Module routing starts here 
 */

Route::post("/flakpay/settlement/get-all-transactions", 'EmployeeController@get_transactions_bydate');

Route::post("/flakpay/settlement/settlement-get-all-transactions", 'EmployeeController@settlement_alltransactions');

Route::get('/flakpay/settlement/transactions/{id}', 'EmployeeController@adjustment')->name('settlement-transactions');

Route::get('/rockpay/settlement/add/new', 'EmployeeController@store_adjustment_view')->name('add-new-settlement');

Route::post('/rockpay/settlement/generate', 'EmployeeController@generate_adjustment')->name('generate-adjustment');

Route::post('/rockpay/settlement/add', 'EmployeeController@store_adjustment')->name('add-settlement');

Route::get('/rockpay/settlement/get', 'EmployeeController@get_adjustment_detail');

Route::post('/rockpay/settlement/proceed-adjustment', 'EmployeeController@proceed_adjustment');

Route::get('/rockpay/settlement/get-merchants-transactions/{id}', 'EmployeeController@get_merchant_transactions');

Route::post('/rockpay/settlement/transactions-details', 'EmployeeController@get_transactions_details');

Route::post('/rockpay/settlement/get-vendor-adjustments', 'EmployeeController@get_vendor_adjustments');

Route::post('/rockpay/settlement/rockpay-adjustment', 'EmployeeController@rupayapay_adjustment');

Route::post('/rockpay/settlement/get-rupayapay-adjustments', 'EmployeeController@get_rupayapay_adjustments');

Route::post('/flakpay/settlement/download-transaction-data', 'EmployeeController@download_transaction')->name('download-transactiondata');

Route::get('/flakpay/settlement/getoverallsettlementList', 'Admin\SettlementController@index');

Route::post('/flakpay/settlement/file_upload', 'Admin\SettlementController@settlementFileUpload')->name('settlement-fileupload');

Route::get('/flakpay/settlement/getcompletedsettlementList', 'Admin\SettlementController@SettlementList')->name('getcompletedsettlementList');

Route::any('/flakpay/settlement/markasPaid/{settlement_id}', 'Admin\SettlementController@PaidStatusUpdate')->name('PaidStatusUpdate');


/**
 * Settlement ChargeBack Dispute Resolution starts here
 */

Route::get('/flakpay/settlement/cdr/{id}', 'EmployeeController@adjustment')->name('cdr-home');
Route::get('/rockpay/settlement/chargeback-dispute-refund/get/{id}', 'EmployeeController@get_cdr_info');
Route::get('/flakpay/settlement/chargeback-dispute-refund/create', 'EmployeeController@show_cdr_info')->name('cdr-show');
Route::post('/rockpay/settlement/chargeback-dispute-refund/add', 'EmployeeController@store_cdr_info')->name('cdr-add');
Route::get('/flakpay/settlement/chargeback-dispute-refund/edit/{id}', 'EmployeeController@edit_cdr_info')->name('cdr-edit');
Route::post('/rockpay/settlement/chargeback-dispute-refund/update', 'EmployeeController@update_cdr_info')->name('cdr-update');

Route::get('/flakpay/settlement/reports/{id}', 'EmployeeController@adjustment');

Route::get('/flakpay/settlement/settings/{id}', 'EmployeeController@adjustment');

Route::get('/flakpay/technical/l2-tickets/{id}', 'EmployeeController@technical')->name('technical-payable');

Route::get('/flakpay/technical/transactions', 'EmployeeController@transactions')->name('transactions');
Route::get('/rockpay/technical/searchtransactions', 'EmployeeController@gettransactions')->name('gettransactions');

Route::get('/rockpay/technical/findvendortransactionstatus', 'EmployeeController@findvendortransactionstatus')->name('findvendortransactionstatus');
Route::get('/rockpay/technical/updatetransactionstatus', 'EmployeeController@updateTransactionStatus')->name('updateTransactionStatus');

Route::get('/rockpay/technical/transactionInfo', 'EmployeeController@transactionInfo')->name('transactionInfo');

Route::get('/flakpay/technical/merchant_services', 'EmployeeController@merchantServices')->name('merchantTransactionPermission');
Route::post('/rockpay/technical/add_merchant_services', 'EmployeeController@addMerchantServices')->name('addMerchantServices');
Route::post('/rockpay/technical/edit_merchant_services', 'EmployeeController@editMerchantServices')->name('editMerchantServices');

Route::get('/flakpay/technical/merchant_request_listing', 'EmployeeController@merchantRequestListings')->name('merchantRequestListings');
Route::post('/rockpay/technical/merchant_request_status_update', 'EmployeeController@merchantRequestStatusUpdate')->name('merchantRequestStatusUpdate');

Route::post('/rockpay/technical/save_vendor_keys', 'EmployeeController@saveVendorkeys')->name('saveVendorkeys');

Route::post('/rockpay/technical/delete_vendor_keys', 'EmployeeController@deleteVendorKeys')->name('deleteVendorKeys');

Route::get('/rockpay/technical/merchantList', 'EmployeeController@merchantListWhenSavingVendor')->name('merchantListWhenSavingVendor');

Route::get('/flakpay/technical/work-status/{id}', 'EmployeeController@technical')->name('technical-payable');

Route::get('/flakpay/technical/sidconfiguration', 'SIDController@index')->name('sidconfiguration');

Route::post('/flakpay/technical/add_sid', 'SIDController@add')->name('addnewSid');
Route::post('/flakpay/technical/edit_sid/{id}', 'SIDController@edit')->name('editSid');
Route::post('/flakpay/technical/delete_sid/{id}', 'SIDController@destroy')->name('deleteSid');
Route::post('/flakpay/technical/status_sid/{id}', 'SIDController@statusUpdate')->name('statusSid');

Route::get('/fetch-sid/{id}', 'SIDController@fetchSid')->name('fetchSid');


Route::get('/flakpay/networking/network-status/{id}', 'EmployeeController@network')->name('networking-payable');

/**
 * Technical Menu Routes starts here
 */
Route::get('/rockpay/technical/get-merchant-charges/{perpage}', 'EmployeeController@get_merchant_charges');
Route::get('/rockpay/technical/get-apporved-merchants/{perpage}', 'EmployeeController@get_approved_merchants');
Route::get('/rockpay/technical/make-merchant-live/{id}', 'EmployeeController@make_approved_merchant_live');
Route::get('/rockpay/technical/change-merchant-status/{id}/{status}', 'EmployeeController@change_approved_merchant_status');
Route::get('/rockpay/technical/get-merchant-charge/{recordid}', 'EmployeeController@get_merchant_charge');
Route::get('/rockpay/technical/get-merchant-business-type/{merchantid}', 'EmployeeController@get_merchant_bussinesstype');

Route::get('/flakpay/api/payin-status-toggle/{id}', 'EmployeeController@payinstatusupdate');



Route::post('/rockpay/technical/merchant-charge/add', 'EmployeeController@addupdate_merchant_charge');
Route::post('/rockpay/technical/change-merchant-password', 'EmployeeController@changeMerchantPassword');

Route::get('/rockpay/technical/get-adjustment-charges/{perpage}', 'EmployeeController@get_adjustment_charges');
Route::post('/rockpay/technical/adjustment-charge/add-update', 'EmployeeController@addupdate_adjustment_charge');
Route::get('/rockpay/technical/get-adjustment-charge/{perpage}', 'EmployeeController@get_adjustment_charge');

Route::get('/rockpay/technical/get-merchant-routes/{id}', 'EmployeeController@get_merchant_routes');
Route::post('/rockpay/technical/add-merchant-route', 'EmployeeController@store_merchant_route');
Route::get('/rockpay/technical/get-merchant-route/{id}', 'EmployeeController@get_merchant_route');

Route::get('/rockpay/technical/cashfree-getroutes/{perpage}', 'EmployeeController@get_cashfree_route');
Route::post('/rockpay/technical/cashfree-add-route', 'EmployeeController@add_cashfree_route');
Route::get('/rockpay/technical/cashfree-edit-route/{id}', 'EmployeeController@edit_cashfree_route')->name('cashfree-route');
Route::post('/rockpay/technical/cashfree-update-route', 'EmployeeController@update_cashfree_route');

/**
 * 
 * Support Menu routing starts here
 */

Route::get('/flakpay/support/client-desk/{id}', 'EmployeeController@support')->name('support-payable');
Route::post('/rockpay/support/call-list/merchant-support/add', 'EmployeeController@store_merchant_support')->name('add-merchant-support');
Route::get('/flakpay/support/merchant-status/{id}', 'EmployeeController@support')->name('support-payable');
Route::get('/flakpay/support/call-list/{id}', 'EmployeeController@support')->name('support-payable');
Route::get('/rockpay/support/merchant/support-list', 'EmployeeController@get_merchant_support')->name('merchant-support');
Route::get('/rockpay/support/merchant/status', 'EmployeeController@get_merchant_status')->name('merchant-status');
Route::post('/rockpay/support/call-list/support/new', 'EmployeeController@store_callsupport')->name('call-support');
Route::get('/rockpay/support/call-list/support/get', 'EmployeeController@get_callsupport')->name('get-callsupport');
Route::get('/rockpay/support/merchant/locked-accounts/get', 'EmployeeController@get_merchant_locked_accounts');
Route::get('/rockpay/support/merchant/unlock-account/{merchantid}', 'EmployeeController@merchant_unlock');

/**
 * 
 * Marketing Menu routing starts here
 */

Route::get('/flakpay/marketing/offline-marketing/{id}', 'EmployeeController@marketing')->name('marketing-online');
Route::get('/flakpay/marketing/online-marketing/{id}', 'EmployeeController@marketing')->name('marketing-offline');

Route::post('/rockpay/marketing/add-post', 'EmployeeController@store_post');
Route::get('/rockpay/marketing/get-all-posts', 'EmployeeController@get_all_post');
Route::get('/rockpay/marketing/edit-post/{id}', 'EmployeeController@edit_post');
Route::post('/rockpay/marketing/update-post', 'EmployeeController@update_post');
Route::post('/rockpay/marketing/remove-post', 'EmployeeController@remove_post');
Route::get('/rockpay/marketing/remove-post-image/{imagename}', 'EmployeeController@remove_post_image');

Route::get('/rockpay/merketing/contact/get/{id}', 'EmployeeController@get_contact_lead');

Route::get('/rockpay/merketing/subscribe/get/{id}', 'EmployeeController@get_subscribe_list');
Route::get('/rockpay/merketing/gallery/get/{id}', 'EmployeeController@get_gallery_image');
Route::post('/rockpay/merketing/gallery/add', 'EmployeeController@store_image');
Route::get('/rockpay/merketing/gallery/edit/{id}', 'EmployeeController@edit_image');
Route::get('/rockpay/marketing/remove-gallery-image/{imagename}', 'EmployeeController@remove_gallery_image');
Route::post('/rockpay/marketing/gallery/update', 'EmployeeController@update_image');

Route::post('/rockpay/marketing/event/add-post', 'EmployeeController@store_event_post');
Route::get('/rockpay/marketing/event/get-all-posts', 'EmployeeController@get_all_event_post');
Route::get('/rockpay/marketing/event/edit-post/{id}', 'EmployeeController@edit_event_post');
Route::post('/rockpay/marketing/event/update-post', 'EmployeeController@update_event_post');
Route::post('/rockpay/marketing/event/remove-post', 'EmployeeController@remove_event_post');
Route::get('/rockpay/marketing/event/remove-post-image/{imagename}', 'EmployeeController@remove_event_post_image');

Route::post('/rockpay/marketing/csr/add-post', 'EmployeeController@store_csr_post');
Route::get('/rockpay/marketing/csr/get-all-posts', 'EmployeeController@get_all_csr_post');
Route::get('/rockpay/marketing/csr/edit-post/{id}', 'EmployeeController@edit_csr_post');
Route::post('/rockpay/marketing/csr/update-post', 'EmployeeController@update_csr_post');
Route::post('/rockpay/marketing/csr/remove-post', 'EmployeeController@remove_csr_post');
Route::get('/rockpay/marketing/csr/remove-post-image/{imagename}', 'EmployeeController@remove_csr_post_image');

Route::post('/rockpay/marketing/pr/add-post', 'EmployeeController@store_pr_post');
Route::get('/rockpay/marketing/pr/get-all-posts', 'EmployeeController@get_all_pr_post');
Route::get('/rockpay/marketing/pr/edit-post/{id}', 'EmployeeController@edit_pr_post');
Route::post('/rockpay/marketing/pr/update-post', 'EmployeeController@update_pr_post');
Route::post('/rockpay/marketing/pr/remove-post', 'EmployeeController@remove_pr_post');
Route::get('/rockpay/marketing/pr/remove-post-image/{imagename}', 'EmployeeController@remove_pr_post_image');

/**
 * 
 * Sales Menu Routing starts here
 * 
 */

Route::get('/flakpay/sales/lead-status/{id}', 'EmployeeController@sales')->name('sales-payable');
Route::post('/rockpay/sales/salesheet/new', 'EmployeeController@store_sale')->name('store-salessheet');
Route::post('/rockpay/sales/dailysheet/new', 'EmployeeController@store_daily')->name('store-salessheet');
Route::get('/rockpay/sales/leadsalesheet/get', 'EmployeeController@get_lead_sales')->name('get-leadsale');
Route::get('/rockpay/sales/dailysalesheet/get', 'EmployeeController@get_daily_sales')->name('get-dailysale');
Route::get('/rockpay/sales/salesheet/get', 'EmployeeController@get_sales')->name('get-salesheet');
Route::get('/rockpay/sales/leadsalesheet/edit/{id}', 'EmployeeController@edit_leadsale')->name('edit-leadsale');
Route::get('/rockpay/sales/dailysalesheet/edit/{id}', 'EmployeeController@edit_dailysale')->name('edit-dailysale');
Route::get('/rockpay/sales/salesheet/edit/{id}', 'EmployeeController@edit_sales')->name('edit-salessheet');
Route::post('/rockpay/sales/field-lead-salesheet/get', 'EmployeeController@get_field_lead_sales')->name('get-field-lead-salessheet');
Route::get('/rockpay/sales/field-daily-salesheet/get', 'EmployeeController@get_field_daily_sales')->name('get-field-daily-salessheet');
Route::get('/rockpay/sales/field-salesheet/get', 'EmployeeController@get_field_sales')->name('get-fieldsalessheet');

Route::get('/flakpay/sales/merchant-transactions/{id}', 'EmployeeController@sales')->name('sales-payable');
Route::post('/rockpay/sales/fieldsalesheet/new', 'EmployeeController@store_fieldsale')->name('store-fieldsalessheet');

Route::get('/rockpay/sales/field-lead-salesheet/edit/{id}', 'EmployeeController@edit_fieldsales')->name('edit-field-leadsalessheet');
Route::get('/rockpay/sales/field-daily-salesheet/edit/{id}', 'EmployeeController@edit_fieldsales')->name('edit-field-dailysalessheet');
Route::get('/rockpay/sales/fieldsalesheet/edit/{id}', 'EmployeeController@edit_fieldsales')->name('edit-fieldsalessheet');

Route::get('/flakpay/sales/merchant-commercials/{id}', 'EmployeeController@sales')->name('sales-payable');

Route::get('/flakpay/sales/product-modes/{id}', 'EmployeeController@sales')->name('sales-payable');
Route::get('/rockpay/sales/merchant-commercials/show/{id}', 'EmployeeController@show_merchant_charges');
Route::get('/rockpay/sales/transaction-breakup/{merchantid}', 'EmployeeController@get_transaction_breakup');
Route::get('/rockpay/sales/get/campaiagn/{perpage}', 'EmployeeController@get_campaigns');
Route::post('/rockpay/sales/campaiagn', 'EmployeeController@campaign');

/**
 * 
 * Risk Complaince Menu Routing starts here   
 * 
 */
Route::get('/flakpay/risk-complaince/merchant-document/{id}', 'EmployeeController@risk_complaince')->name('merchant-document');
//Route::post('/rockpay/add_merchant/', 'EmployeeController@addmerchant')->name('add_merchant');
Route::any('/flakpay/add_merchant/', 'EmployeeController@addmerchant')->name('add_merchant');
Route::get('/flakpay/get_business_subcategories/', 'EmployeeController@getSubCategory')->name('getSubCategorys');

Route::get('/flakpay/risk-complaince/merchant-document/verify/get-merchant-doc-detail/{perpage}', 'EmployeeController@get_merchant_docs')->name('get-all-merchant-doc-detail');
Route::get('/flakpay/risk-complaince/merchant-document/verify/create/{id}', 'EmployeeController@show_merchant_docs_status')->name('new-merchant-doc');
Route::get('/flakpay/risk-complaince/merchant-document/view/{id}', 'EmployeeController@show_merchant_docs')->name('show_merchant_docs');
Route::post('/rockpay/risk-complaince/merchant-document/verify/new', 'EmployeeController@store_merchant_docs_status')->name('store-merchant-doc-status');
Route::post('/flakpay/risk-complaince/merchant-document/verify/update', 'EmployeeController@update_merchant_docs_status')->name('update-merchant-doc-status');
Route::post('/flakpay/risk-complaince/merchant-details/verify/update', 'EmployeeController@update_merchant_details_status')->name('update-merchant-details-status');
Route::post('/flakpay/risk-complaince/merchant-document/send-report', 'EmployeeController@merchant_docs_report')->name('merchant-doc-report');
Route::get('/flakpay/risk-complaince/merchant/details/{id}', 'EmployeeController@merchant_detail')->name('merchant-detail');

Route::get('/flakpay/risk-complaince/merchant/merchantadd', 'EmployeeController@merchantadd');

Route::get('/document-verify/download/merchant-document/{email}/{file}', function ($merchant_email, $file) {
    if (file_exists(storage_path('app/public/merchant/documents/' . $merchant_email . "/" . $file))) {
        return response()->download(storage_path('app/public/merchant/documents/' . $merchant_email . "/" . $file));
    } else {
        return redirect()->back();
    }
});

Route::post('/rockpay/risk-complaince/merchant/document/upload', 'EmployeeController@merchant_document_upload');
Route::post('/rockpay/risk-complaince/merchant/document/remove', 'EmployeeController@merchant_document_remove');

Route::get('/rockpay/risk-complaince/merchant/extra-documents/get/{perpapage}', 'EmployeeController@get_merchant_extdocuments');
Route::get('/rockpay/risk-complaince/merchant/extra-document/get/{id}', 'EmployeeController@get_merchant_extdocument')->name('extra-document');
Route::post('/rockpay/risk-complaince/merchant/extra-document/upload', 'EmployeeController@merchant_extdocument_upload');
Route::get('/rockpay/risk-complaince/merchant/extra-document/download/{file}', function ($file) {
    if (file_exists(storage_path('app/public/merchant/extradocuments/' . $file))) {
        return response()->download(storage_path('app/public/merchant/extradocuments/' . $file));
    } else {
        return redirect()->back();
    }
})->name('download-extra-doc');

Route::get('/rockpay/risk-complaince/background-verification/verify/get-merchant-business-details/{id}', 'EmployeeController@get_merchant_business_detail')->name('get-all-merchant-bussdetails');
Route::get('/flakpay/risk-complaince/background-verification/{id}', 'EmployeeController@risk_complaince')->name('background-check');
Route::post('/rockpay/risk-complaince/background-verification/verify/get-sub-category', 'EmployeeController@get_business_subcategory');
Route::get('/rockpay/risk-complaince/background-verification/verify/get-verified-merchants/{perpage}', 'EmployeeController@get_verified_merchant')->name('get-all-verified-merchant');
Route::get('/flakpay/risk-complaince/background-verification/verify/create', 'EmployeeController@show_merchant_verify')->name('new-verify-merchant');
Route::post('/rockpay/risk-complaince/background-verification/verify/new', 'EmployeeController@store_merchant_verify')->name('store-verify-merchant');
Route::get('/rockpay/risk-complaince/background-verification/verify/edit/{id}', 'EmployeeController@edit_merchant_verify')->name('edit-verify-merchant');
Route::post('/rockpay/risk-complaince/background-verification/verify/update', 'EmployeeController@update_merchant_verify')->name('update-verify-merchant');

Route::get('/flakpay/risk-complaince/grievence-cell/{id}', 'EmployeeController@risk_complaince')->name('risk-complaince-payable');
Route::get('/rockpay/risk-complaince/grievence-cell/get/all-cases/{perpage}', 'EmployeeController@get_all_cust_cases')->name('get-all-cases');
Route::get('/rockpay/risk-complaince/grievence-cell/get/cases-details/{id}', 'EmployeeController@get_case_details')->name('get-case-details');
Route::post('/rockpay/risk-complaince/grievence-cell/comment/add', 'EmployeeController@customer_comment')->name('add-case-comment');
Route::post('/rockpay/risk-complaince/grievence-cell/case/update', 'EmployeeController@update_customer_case')->name('case-update');
Route::get('/flakpay/risk-complaince/banned-products/{id}', 'EmployeeController@risk_complaince')->name('risk-complaince-payable');

/**
 *    
 * Legal Menu Routing starts here
 * 
 */

Route::get('/flakpay/legal/customer-case/{id}', 'EmployeeController@legal')->name('legal-payable');
Route::get('/rockpay/legal/customer-case/get/{id}', 'EmployeeController@get_legal_cases')->name('legal-cases');
Route::get('/rockpay/legal/customer-case/case/create', 'EmployeeController@show_legal_case')->name('show-legal-case');
Route::post('/rockpay/legal/customer-case/case/add', 'EmployeeController@store_legal_case')->name('store-legal-case');
Route::get('/rockpay/legal/customer-case/case/edit', 'EmployeeController@edit_legal_case')->name('edit-legal-case');
Route::post('/rockpay/legal/customer-case/case/update', 'EmployeeController@update_legal_case')->name('update-legal-case');

Route::get('/rockpay/legal/capital/{id}', 'EmployeeController@legal')->name('legal-payable');
Route::get('/rockpay/legal/express-case/{id}', 'EmployeeController@legal')->name('legal-payable');
Route::get('/rockpay/legal/pos-case/{id}', 'EmployeeController@legal')->name('legal-payable');
Route::get('/rockpay/legal/wallet-gullak-sanddok/{id}', 'EmployeeController@legal')->name('legal-payable');
Route::get('/rockpay/legal/credit-card-case/{id}', 'EmployeeController@legal')->name('legal-payable');
Route::get('/rockpay/legal/ivr-pay-case/{id}', 'EmployeeController@legal')->name('legal-payable');

/**
 * 
 * HRM Menu Route Code Starts here
 */

Route::get('/flakpay/hrm/employee-details/{id}', 'EmployeeController@hrm')->name('hrm-payable');
Route::get('/flakpay/hrm/nda/{id}', 'EmployeeController@hrm')->name('hrm-payable');
Route::get('/flakpay/hrm/bvf/{id}', 'EmployeeController@hrm')->name('hrm-payable');
Route::get('/flakpay/hrm/employee-attendance/{id}', 'EmployeeController@hrm')->name('hrm-payable');
Route::get('/flakpay/hrm/payroll/{id}', 'EmployeeController@hrm')->name('hrm-payable');
Route::get('/flakpay/hrm/performance-appraisal/{id}', 'EmployeeController@hrm')->name('hrm-payable');
Route::get('/flakpay/hrm/confidentiality-agreement/{id}', 'EmployeeController@hrm')->name('hrm-payable');
Route::get('/flakpay/hrm/career/{id}', 'EmployeeController@hrm')->name('hrm-career');

Route::get('/rockpay/hrm/get-employees', 'EmployeeController@get_all_employees')->name('get.employees');
Route::get('/rockpay/hrm/employee-accesses/{id}', 'EmployeeController@employeeAccess')->name('employeeAccess');
Route::post('/rockpay/hrm/edit-employee-accesses/', 'EmployeeController@editemployeeAccess')->name('editemployeeAccess');
Route::get('/rockpay/hrm/employee-details/edit/{id}', 'EmployeeController@edit_employee')->name('edit.employee');
Route::post('/rockpay/hrm/get-employees/update', 'EmployeeController@update_employee');
Route::post('/rockpay/hrm/get-employees/add', 'EmployeeController@store_employee');
Route::post('/rockpay/hrm/get-employees/delete', 'EmployeeController@delete_employee');

Route::post('/rockpay/hrm/bvf/add-personal-profile', 'EmployeeController@store_personal');
Route::post('/rockpay/hrm/bvf/add-contact-details', 'EmployeeController@store_contact_details');
Route::post('/rockpay/hrm/bvf/add-reference-details', 'EmployeeController@store_reference_details');

Route::get('/rockpay/hrm/nda/get-nda/{id}', 'EmployeeController@get_employee_nda_doc')->name('nda-file');
Route::post('/rockpay/hrm/nda/upload-file', 'EmployeeController@upload_nda_form');
Route::get('/rockpay/hrm/conagree/get-conagree/{id}', 'EmployeeController@get_employee_ca_doc')->name('ca-file');
Route::post('/rockpay/hrm/ca/upload-file', 'EmployeeController@upload_ca_form');

Route::get('/flakpay/hrm/payroll/payslip/form', 'EmployeeController@emp_payslip')->name('payslip');
Route::get('/rockpay/hrm/payroll/payslip/get-form/{id}', 'EmployeeController@emp_payslip_from')->name('payslip-from');
Route::post('/rockpay/hrm/payroll/payslip/add', 'EmployeeController@store_payslip')->name('add-payslip');
Route::get('/rockpay/hrm/payroll/payslip/edit/{id}', 'EmployeeController@edit_payslip')->name('edit-payslip');
Route::get('/rockpay/hrm/payroll/payslip/get', 'EmployeeController@get_payslip')->name('get-payslip');

Route::get('/rockpay/hrm/career/job/get/{id}', 'EmployeeController@get_job');
Route::post('/rockpay/hrm/career/job/add', 'EmployeeController@store_job');
Route::get('/rockpay/hrm/career/job/edit/{id}', 'EmployeeController@edit_job');
Route::post('/rockpay/hrm/career/job/update', 'EmployeeController@update_job');
Route::post('/rockpay/hrm/career/job/change-status', 'EmployeeController@update_job_status');

Route::get('/rockpay/hrm/career/applicant/get/{id}', 'EmployeeController@get_applicants');
Route::post('/rockpay/hrm/career/applicant/update', 'EmployeeController@update_applicant_status');

Route::get('/download/applicant/resume/{file}', function ($file = '') {
    return response()->download(public_path('storage/applicants/' . $file));
});

/**
 * 
 * Merchanr Menu Route Code Starts here
 */

Route::get('/flakpay/merchant/transactions/{id}', 'EmployeeController@admin_merchant');
Route::get('/flakpay/merchant/transaction/methods/{id}', 'EmployeeController@admin_merchant');
Route::get('/flakpay/merchant/details/{id}', 'EmployeeController@admin_merchant');
Route::get('/flakpay/merchant/routes/{id}', 'EmployeeController@admin_merchant');
Route::get('/flakpay/merchant/cases/{id}', 'EmployeeController@admin_merchant');
Route::get('/flakpay/merchant/adjustments/{id}', 'EmployeeController@admin_merchant');

Route::post('/flakpay/merchant/no-of-transactions', 'EmployeeController@no_of_transactions');
Route::post('/flakpay/merchant/transaction-amount', 'EmployeeController@transaction_amount');

Route::get('/rockpay/merchant/get-all-merchants/{perpage}', 'EmployeeController@get_all_merchants');
Route::get('/rockpay/merchant/get-all-merchant-cases', 'EmployeeController@get_all_cases');
Route::get('/rockpay/merchant/get-all-adjustments', 'EmployeeController@get_all_adjustments');

Route::get('/rockpay/merchant/no-of-paylinks', 'EmployeeController@no_of_paylinks');
Route::get('/rockpay/merchant/no-of-invoices', 'EmployeeController@no_of_invoices');

/**
 * 
 * My Account Menu Route Code Starts here
 */

Route::get('/flakpay/my-account', 'EmployeeController@my_account')->name("my-account");

Route::post('/rockpay/my-account/personal-details/update', 'EmployeeController@update_mydetails')->name("my-details-update");

Route::post('/rockpay/my-account/request-password-change', 'EmployeeController@request_password_change')->name("my-password-change");

Route::post('/rockpay/my-account/verify-email-OTP', 'EmployeeController@verify_emailOTP')->name("verify-emailOTP");

Route::post('/rockpay/my-account/verify-mobile-OTP', 'EmployeeController@verify_mobileOTP')->name("verify-mobileOTP");

Route::post('/rockpay/my-account/change-password', 'EmployeeController@change_password')->name("change-password");

Route::get('/rockpay/merchant/get-login-activities', 'EmployeeController@login_activities');

/**
 * 
 * My Account Menu Route Code Starts here
 */
Route::get('/rockpay/work-status', 'EmployeeController@show_workstatus')->name("show-status");

Route::get('/rockpay/work-status/get/{id}', 'EmployeeController@get_workstatus')->name("get-work-status");

Route::post('/rockpay/work-status/add', 'EmployeeController@store_workstatus')->name("store-work-status");

Route::get('/rockpay/work-status/edit/{id}', 'EmployeeController@edit_workstatus')->name("edit-work-status");

Route::post('/rockpay/work-status/update', 'EmployeeController@update_workstatus')->name("update-work-status");

//rockpay Angular Related Routings

Route::post('/rockpay/contact-us', 'VerifyController@rupayapay_contactus');

Route::get('/flakpay/pagination/{submod}-{perpage}', 'EmployeeController@employee_pagination');

Route::get('/rockpay/emp/search/{submod}/{searchtext}', 'EmployeeController@employee_search');

//testing
// Route::get('/test', 'MerchantController@graph_success_rate');

Route::get('/test', 'EmployeeController@curltest');


Route::group(['prefix' => 'invoice'], function () {
    Route::get('/demo', 'InvoiceController@demo')->name('demo');
    Route::get('/recipt/{id}', 'InvoiceController@recipt')->name('recipt');
});

Route::post('/flakpayregister', 'flakpayCMSAuth\CMSRegController@websiteinsertapi');


// Route::any('/webregister', 'flakpayCMSAuth\CMSRegController@websiteinsertapi');


Route::post('/check-email', 'EmployeeController@checkEmail');

Route::get('transactionslist/data', 'EmployeeController@getTransactionsList')->name('transactions.data.list');
Route::get('nooftransactionslist/data', 'EmployeeController@no_of_transactionsList')->name('nooftransactions.data.list');
Route::get('amounttransactionslist/data', 'EmployeeController@transaction_amountList')->name('transactions.amount.list');

//Mail

Route::post('/send-mail', [MailController::class, 'sendEmail']);
