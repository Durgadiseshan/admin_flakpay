@php
use App\User;
$merchants = User::get_tmode_docupload_merchants();
@endphp

@extends('layouts.employeecontent')
@section('employeecontent')
<div class="row">
                    <div class="row">
                      <div class="col-sm-12">
                            <a href="{{ route('merchant-document', 'ryapay-7WRwwggm') }}" class="btn btn-primary btn-sm pull-right" 
                            style="border-radius: 25px;">
                                <i class="fa fa-arrow-left" style="margin-right: 10px;"></i>Back
                            </a>
                        </div>
                    </div>
    <div class="col-sm-12 padding-20">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs" id="transaction-tabs">
                    <li class="active"><a data-toggle="tab" class="show-pointer" data-target="documentt-verify">Document
                            Verify</a></li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="#documentt-verify" class="tab-pane fade in active">
                   
                    <div class="row">
                            <div class="col-sm-12">
                                <a href="{{route('priceSetting')}}" class="btn btn-primary btn-sm" style="float: right !important;">Add Slab for Merchant</a>
                            </div>
                    </div>
                        <div class="row padding-10">
                            <div class="col-sm-12 p-0">
                                @if($module == "docscreen")
                                @if($form == "create")
                                <form id="merchant-details-form" method="POST" class="form-horizontal">
                                    
                                    @foreach($merchant_details as $index => $merchant_detail)
                                    <div class="form-group">
                                        <label for="input"
                                            class="col-sm-2 control-label">{{$merchant_detail->field_label}}:</label>
                                        <div class="col-sm-3">
                                            <input type="text" id="input" class="form-control"
                                                value="{{$merchant_detail->field_value}}">
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="{{$merchant_detail->field_name}}" value="Y"
                                                    onclick="UpdateRncVerify('{{$merchant_detail->id}}',this)"
                                                    {{($merchant_detail->field_verified =='Y')?'checked':''}}>
                                                <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                                                No Correction
                                            </label>
                                            <label>
                                                <input type="radio" name="{{$merchant_detail->field_name}}" value="N"
                                                    onclick="UpdateRncVerify('{{$merchant_detail->id}}',this)"
                                                    {{($merchant_detail->field_verified =='N')?'checked':''}}>
                                                <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                                                Correction
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </form>
                                <form id="document-details-form" method="POST" class="form-horizontal">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>File Name</th>
                                                    <th>File</th>
                                                    <th style="white-space: nowrap;">Document Verified</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($documents as $index => $value)
                                                <tr>
                                                    <td>{{$value->file_name}}</td>
                                                    <td>
                                                        <div class="col-sm-12">
                                                            <input type="file" name="{{$value->doc_name}}"
                                                                id="file-{{$index}}"
                                                                class="inputfile uploadfile form-control inputfile-{{$index}}"
                                                                data-multiple-caption="{count} files selected" multiple />
                                                            <label for="file-{{$index}}" class="custom-file-upload">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                    height="17" viewBox="0 0 20 17">
                                                                    <path
                                                                        d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z" />
                                                                </svg>
                                                                <span id="{{$value->doc_name}}_file">
                                                                    @if(!empty($value->file_ext))
                                                                    <span
                                                                        id="{{$value->doc_name}}_file_not_exist">{{$value->file_name}}</span>
                                                                    @else
                                                                    <span id="{{$value->doc_name}}_file_not_exist">Choose a
                                                                        file...</span>
                                                                    @endif
                                                                </span>
                                                            </label>
                                                            @if(!empty($value->file_ext))
                                                            <button type="reset" class="button124"
                                                                data-name="{{$value->file_ext}}" data-id="{{$value->id}}">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                            @endif
                                                            <div id="{{$value->doc_name}}_error"></div>
                                                        </div>
                                                        @if(!empty($value->file_ext))
                                                        <a
                                                            href="/document-verify/download/merchant-document/{{$folder_name}}/{{$value->file_ext}}">{{$value->file_name}}</a>
                                                        @endif
                                                    </td>
                                                    <td style="white-space: normal;">
                                                        <div class="radio">
                                                            <label style="white-space: nowrap;padding-left: 5px;">
                                                                <input type="radio" name="{{$value->doc_name}}" value="Y"
                                                                    onclick="UpdateDocVerify('{{$value->id}}',this)" ;
                                                                    {{($value->doc_verified =='Y')?'checked':''}}>
                                                                <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                                                                No Correction
                                                            </label>
                                                            <label style="white-space: nowrap;padding-left: 5px;">
                                                                <input type="radio" name="{{$value->doc_name}}" value="N"
                                                                    onclick="UpdateDocVerify('{{$value->id}}',this)" ;
                                                                    {{($value->doc_verified =='N')?'checked':''}}>
                                                                <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                                                                Correction
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-sm-12 p-0">
                                        <button type="submit" class="btn btn-primary pull-right"
                                            onclick="callReportModal();">Submit Report</button>
                                    </div>

                                </div>

                                

                                <div id="Keys">
                                    <div class="row secret-input">
                                        <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12" style="padding: 6px 15px">
                                            <input type="text" id="secretKey" class="small-input" value="" readonly>
                                            <button class="btn btn-primary key-btn" style="width:50%"
                                                onclick="generateRandomValue('secretKey', 20)">Generate Secret
                                                Key</button>
                                        </div>

                                        <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12" style="padding: 6px 15px">
                                            <input type="text" id="saltKey" class="small-input" value="" readonly>

                                            <button class="btn btn-primary key-btn" style="width:50%"
                                                onclick="saltKeygenerateRandomValue('saltKey', 16)">Generate Salt
                                                Key</button>
                                        </div>

                                        <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12" style="padding: 6px 15px">
                                            <input type="text" id="checksumKey" class="small-input" value="" readonly>
                                            <button class="btn btn-primary checksumKey key-btn" style="width:50%"
                                                onclick="checksumKeygenerateRandomValue('checksumKey', 16)">Generate
                                                Checksum
                                                Key</button>
                                        </div>

                                        <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12" style="padding: 6px 15px">
                                            <input type="text" id="merchant_api_key" class="small-input" value=""
                                                readonly>
                                            <button class="btn btn-primary checksumKey key-btn" style="width:50%"
                                                onclick="merchant_api_key('merchant_api_key', 16)">Generate
                                                Merchant_api_key
                                            </button>
                                        </div>
                                        <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12" style="padding: 6px 15px">
                                            <label for="apiKey">API Key:</label>
                                            <input type="text" id="apiKey" value="<?php echo $mid; ?>"
                                                class="small-input" readonly disabled>
                                        </div>
                                        
                                        <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12" style="padding: 6px 15px">
                                            <div class="row">                                                
                                                <div class="col-xs-12 p-0" style="display: flex;align-items: center;">
                                                    <label class="checkbox-container">
                                                        <input type="checkbox" id="modeToggle" class="checkbox-input" onchange="toggleMode()" <?php echo $livemode ? 'checked' : ''; ?>>
                                                        <span class="custom-checkbox"></span>
                                                    </label>
                                                    <label for="apiKey" class="mode-label" style="margin: 0px 10px;">Live Mode</label>
                                                </div>                                               
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                @endif
                                @endif
                            </div>
                        </div>
                        <div class="modal" id="document-response-modal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        {{-- <h4 class="modal-title">Document Status</h4> --}}
                                        <h4 class="modal-title">Merchant Verification</h4>

                                    </div>
                                    <div class="modal-body">
                                        <div id="document-response-message"></div>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="{{route('merchant-document','ryapay-7WRwwggm')}}"
                                            class="btn btn-primary btn-sm">Ok</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal" id="report-modal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-hidden="true">&times;</button>
                                        <h4 class="modal-title">Rnc Report To Merchant</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form id="rnc-report-form" method="POST" class="form-horizontal" role="form">

                                            <input type="hidden" value="<?php echo $merchant; ?>" name='merchantname'
                                                id="merchantname">
                                            <input type="hidden" value="<?php echo $mid; ?>" name='mid' id="m_id">
                                            <input type="hidden" value="" name='secretKey' id="hiddensecretKey">
                                            <input type="hidden" value="" name='saltKey' id="hiddensaltKey">
                                            <input type="hidden" value="" name='checksumKey' id="hiddenchecksumKey">
                                            <input type="hidden" value="" name='merchant_api_key' id="hiddenmerchant_api_key">
                                            <input type="hidden" name="mode" id="modeInput" value="test">

                                            
                                            <div class="form-group">
                                                <label for="" class="col-sm-3 control-label">Note:</label>
                                                <div class="col-sm-9">
                                                    <span class="text-danger">Fill the below textarea if you would like
                                                        to make a note to merchant via email</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="textarea" class="col-sm-3 control-label">Email Note:</label>
                                                <div class="col-sm-9">
                                                    <textarea name="email_note" id="textarea" class="form-control"
                                                        rows="6"></textarea>
                                                </div>
                                            </div>
                                            {{csrf_field()}}
                                            <input type="hidden" id="merchant_id" name="merchant_id"
                                                value={{$merchant_id}}>
                                            <div class="form-group">
                                                <div class="col-sm-10 col-sm-offset-3">
                                                    <button type="submit" class="btn btn-primary"
                                                        >Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    /* Style for small input fields */
    .small-input {
        width: 200px;
        padding: 5px;
        font-size: 14px;
    }


    input,
    button {
        margin: 10px;
    }
</style>

<?php

header("Access-Control-Allow-Origin: *"); // Allow cross-origin requests from any domain


?>

<script>


    function toggleMode() {
        var isChecked = document.getElementById('modeToggle').checked;
        document.getElementById("modeInput").value = isChecked ? "live" : "test";

        if (isChecked) {
           
               document.getElementById('modeToggle').checked = true;

            } 
        else {
            // setTestModeValues();
        }
    }

    // function setLiveModeValues() {
    //     // document.getElementById('secretKey').value = "";
    //     // document.getElementById('saltKey').value = "";
    //     // document.getElementById('checksumKey').value = "";
        
    // }

    // function setTestModeValues() {
    //     document.getElementById('secretKey').value = "";
    //     document.getElementById('saltKey').value = "";
    //     document.getElementById('checksumKey').value = "";
    // }
  

    function generateRandomValue(secretKey, length) {
        // Get the input element by ID
        var inputElement = document.getElementById(secretKey);

        // Define the characters to choose from
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        // Generate the key
        var keyValue = '';
        for (var i = 0; i < length; i++) {
            var randomIndex = Math.floor(Math.random() * characters.length);
            keyValue += characters.charAt(randomIndex);
        }

        // Set the key to the input field
        inputElement.value = keyValue;

        console.log(secretKey + ':', keyValue);


        $('#hiddensecretKey').val(keyValue)
        return keyValue;


    }

    function saltKeygenerateRandomValue(saltKey, length) {
        // Get the input element by ID
        var inputElements = document.getElementById(saltKey);

        // Define the characters to choose from
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        // Generate the key
        var keyValues = '';
        for (var i = 0; i < length; i++) {
            var randomIndex = Math.floor(Math.random() * characters.length);
            keyValues += characters.charAt(randomIndex);
        }

        // Set the key to the input field
        inputElements.value = keyValues;

        console.log(saltKey + ':', keyValues);


        $('#hiddensaltKey').val(keyValues)
        return keyValues;


    }

    function checksumKeygenerateRandomValue(checksumKey, length) {
        // Get the input element by ID
        var checksumKeyinputElements = document.getElementById(checksumKey);

        // Define the characters to choose from
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        // Generate the key
        var checksumKeykeyValues = '';
        for (var i = 0; i < length; i++) {
            var randomIndex = Math.floor(Math.random() * characters.length);
            checksumKeykeyValues += characters.charAt(randomIndex);
        }

        // Set the key to the input field
        checksumKeyinputElements.value = checksumKeykeyValues;

        console.log(checksumKey + ':', checksumKeykeyValues);


        $('#hiddenchecksumKey').val(checksumKeykeyValues);

        return checksumKeykeyValues;

    }

    function merchant_api_key(merchant_api_key, length) {
        var merchant_api_keyinputElement = document.getElementById(merchant_api_key);

        var merchant_api_keycharacters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        var merchant_api_keykeyValue = '';
        for (var i = 0; i < length; i++) {
            var merchant_api_keyrandomIndex = Math.floor(Math.random() * merchant_api_keycharacters.length);
            merchant_api_keykeyValue += merchant_api_keycharacters.charAt(merchant_api_keyrandomIndex);
        }

        merchant_api_keyinputElement.value = merchant_api_keykeyValue;

        console.log(merchant_api_key + ':', merchant_api_keykeyValue);


        $('#hiddenmerchant_api_key').val(merchant_api_keykeyValue)
        return merchant_api_keykeyValue;


    }

    // function sendKeysToServer() {
    //     // Call the functions to generate values and use them in $postData
    //     var secretKeyValue = generateRandomValue('hiddensecretKey', 10);
    //     var saltKeyValue = saltKeygenerateRandomValue('hiddensaltKey', 10);
    //     var checksumKeyValue = checksumKeygenerateRandomValue('hiddenchecksumKey', 10);
    //     var apikey = $('#apiKey').val();

    //     // Use XMLHttpRequest to send the values to a PHP script
    //     var apiUrl = "https://pg.flakpay.com/setmerchantConfig";
    //     var postData = {
    //         secretKeyValue: secretKeyValue,
    //         saltKeyValue: saltKeyValue,
    //         checksumKeyValue: checksumKeyValue,
    //         apikey: apikey
    //     };

    //     var xhr = new XMLHttpRequest();

    //     // Ignore SSL verification errors (not recommended for production)
    //     // xhr.onerror = function () {
    //     //     console.error("Error: Unable to make the request. Check if SSL verification is disabled.");
    //     // };

    //     xhr.open("GET", apiUrl, true);
    //     xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

    //     // Disable SSL verification
    //     xhr.overrideMimeType('text/plain; charset=x-user-defined-binary');

    //     // Setting withCredentials for CORS requests
    //     xhr.withCredentials = true;

    //     xhr.onload = function () {
    //         if (xhr.status === 200) {
    //             console.log(xhr.responseText);
    //             // Handle the response from the server
    //         } else {
    //             console.error("Error:", xhr.statusText);
    //             // Handle errors
    //         }
    //     };

    //     xhr.send(JSON.stringify(postData));
    // }




</script>


<script>
    function fetchMerchantConfigs() {
        <?php
        $id = $merchant_detail->merchant_id;
        $merchant = DB::table('merchant')
                ->select('fpay_id')
                ->where('merchant.id', $id)
                ->first();
        $merchantid = $merchant->fpay_id;

        $postData = array(
           'mid' => $merchantid,
        );
 
        $url = 'https://pg.flakpay.com/fpay/getmerchantConfig';
        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response, true);
        ?>

        var data = <?php echo json_encode($data); ?>;
        console.log('test',data);
        console.log('sec_key',data.sec_key)
        if(data){
        document.getElementById('secretKey').value = data.sec_key;
        document.getElementById('saltKey').value = data.salt_key;
        document.getElementById('checksumKey').value = data.checksum_key; 
        document.getElementById('merchant_api_key').value = data.api_key;
        }
        else{
            document.getElementById('Keys').innerHTML = '<tr><td colspan="5">No data available.Please Contact the Admin</td></tr>';

        }
        
    }

    document.addEventListener("DOMContentLoaded", function() {
        fetchMerchantConfigs();
}, false);
       
    
</script>