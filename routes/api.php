<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::get('add_beneficiary', 'MerchantApiController@addBeneficiary');

Route::get('payout_transfer', 'MerchantApiController@payoutTransferMoney');

Route::get('transaction_status', 'MerchantApiController@transactionStatus');

Route::get('get_report', 'MerchantApiController@exportReport');


Route::get('signatureTest', 'MerchantApiController@getSignature');

Route::get('getIpAddress', 'MerchantApiController@getIpAddress');

Route::post('add_item', 'MerchantApiController@addItem');
Route::post('add_customer', 'MerchantApiController@addCustomer');
Route::post('add_product', 'MerchantApiController@addProduct');
Route::post('add_paylink', 'MerchantApiController@addPaylink');
Route::post('add_quicklink', 'MerchantApiController@addQuicklink');
