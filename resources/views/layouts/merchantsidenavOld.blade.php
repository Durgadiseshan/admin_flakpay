<style>
    @import url("https://fonts.googleapis.com/css?family=Open+Sans:300,400,700");
    @import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css");

    body {
        color: #5d5f63;

        height: 100vh;
        width: 100vw;
        font-family: "Open Sans", sans-serif;
        padding: 0;
        margin: 0;
        text-rendering: optimizeLegibility;
        -webkit-font-smoothing: antialiased;
    }

    .sidebare-toggle {
        margin-left: -240px;
    }

    .sidebare {
        overflow-y: scroll;
        height: 800px;
        max-height: 1000px;
        width: 210px;
        background: #293949;
        position: fixed;
        margin-top: -50px;
        -webkit-transition: all 0.3s ease-in-out;
        -moz-transition: all 0.3s ease-in-out;
        -o-transition: all 0.3s ease-in-out;
        -ms-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
        z-index: 1040;
    }

    .sidebare #leftside-navigation ul,
    .sidebare #leftside-navigation ul ul {
        margin: -2px 0 0;
        padding: 0;
    }

    .sidebare #leftside-navigation ul li {
        list-style-type: none;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .sidebare #leftside-navigation ul li.active a {
        color: #1abc9c;
    }

    .sidebare #leftside-navigation ul li.active ul {
        display: block;
    }

    .sidebare #leftside-navigation ul li a {
        color: #aeb2b7;
        text-decoration: none;
        display: block;
        padding: 18px 0 18px 25px;
        font-size: 12px;
        outline: 0;
        -webkit-transition: all 200ms ease-in;
        -moz-transition: all 200ms ease-in;
        -o-transition: all 200ms ease-in;
        -ms-transition: all 200ms ease-in;
        transition: all 200ms ease-in;
    }

    .sidebare #leftside-navigation ul li a:hover {
        color: #1abc9c;
    }

    .active {
        color: #1abc9c;
    }

    .sidebare #leftside-navigation ul li a span {
        display: inline-block;
    }

    .sidebare #leftside-navigation ul li a i {
        width: 20px;
    }

    .sidebare #leftside-navigation ul li a i .fa-angle-left,
    .sidebare #leftside-navigation ul li a i .fa-angle-right {
        padding-top: 3px;
    }

    .sidebare #leftside-navigation ul ul {
        display: none;
    }

    .sidebare #leftside-navigation ul ul li {
        background: #23313f;
        margin-bottom: 0;
        margin-left: 0;
        margin-right: 0;
        border-bottom: none;
    }

    .sidebare #leftside-navigation ul ul li a {
        font-size: 13px;
        padding-top: 13px;
        padding-bottom: 13px;
         color: #c5c9d2;
    }
</style>

<div class="row" style="">


    <aside class="sidebare">
        <div id="leftside-navigation" class="nano">
          <!--   <div class="text-center" style="padding: 4px;">
                <img class="rupayapay-logo" src="{{ asset('assets/img/rockpay.png') }}" alt="Payflash Logo" />
            </div> -->
            <ul class="nano-content">
                <li>
                    <div class="text-center" style="padding: 4px;">
                        <img class="rupayapay-logo" src="{{ asset('assets/img/rockpay.png') }}" alt="Payflash Logo" />
                    </div>
                </li>
                <li class="{{ in_array(Request::path(),['merchant/dashboard'])?'active' : '' }}">
                    <a href="/merchant/dashboard"><i class="fa fa-dashboard"></i><span>Dashboard</span></a>
                </li>
                <li class="{{ in_array(Request::path(),['merchant/transactions'])?'active' : '' }}">
                    <a href="/merchant/transactions"><i class="fa fa-exchange fa-lg" style="color:lightgreen"></i><span>Transactions</span></a>
                </li>
                <li class="sub-menu">
                    <a href="javascript:void(0);"><i class="fa fa-money fa-lg" style="color:gold"></i><span>Payout</span><i class="arrow fa fa-angle-right pull-right"></i></a>
                    <ul id="subMenu3">
                        <li class="{{ in_array(Request::path(),['merchant/payout_overview'])?'active' : '' }}"><a href="/merchant/payout_overview">Payout Dashboard</a></li>
                        <li class="{{ in_array(Request::path(),['merchant/payout'])?'active' : '' }}"><a href="/merchant/payout">Payout</a></li>
                        <li class="{{ in_array(Request::path(),['merchant/beneficiaries'])?'active' : '' }}"><a href="/merchant/beneficiaries">Beneficiaries</a></li>
                        <li class="{{ in_array(Request::path(),['merchant/contacts'])?'active' : '' }}"><a href="/merchant/contacts">Contacts</a></li>
                        <li class="{{ in_array(Request::path(),['merchant/beneficiary_groups'])?'active' : '' }}"><a href="/merchant/beneficiary_groups">Groups</a></li>
                        <li class="{{ in_array(Request::path(),['merchant/fund_transfer'])?'active' : '' }}"><a href="/merchant/fund_transfer">Fund Transfer</a></li>
                        <li class="{{ in_array(Request::path(),['merchant/payout_setting'])?'active' : '' }}"><a href="/merchant/payout_setting">Settings</a></li>
                        <li class="{{ in_array(Request::path(),['merchant/payout_account'])?'active' : '' }}"><a href="/merchant/payout_account">Accounts</a></li>
                        <li class="{{ in_array(Request::path(),['merchant/payout_reports'])?'active' : '' }}"><a href="/merchant/payout_reports">Reports</a></li>


                    </ul>
                </li>
                <li class="{{ in_array(Request::path(),['merchant/paylinks'])?'active' : '' }}">
                    <a href="/merchant/paylinks"><i class="fa fa-link fa-lg" style="color:yellow"></i><span>Pay Links</span></a>
                </li>
                <li class="{{ in_array(Request::path(),['merchant/invoices'])?'active' : '' }}">
                    <a href="/merchant/invoices"><i class="fa fa-file-pdf-o fa-lg" style="color:fuchsia"></i><span>Invoices</span></a>
                </li>
                <li class="{{ in_array(Request::path(),['merchant/settlements'])?'active' : '' }}">
                    <a href="/merchant/settlements"><i class="fa fa-handshake-o fa-lg" style="color:orange"></i><span>Settlements</span></a>
                </li>
                <li class="{{ in_array(Request::path(),['merchant/settings'])?'active' : '' }}">
                    <a href="/merchant/settings"><i class="fa fa-cog fa-lg" style="color:rgb(250, 144, 144)"></i><span>Settings</span></a>
                </li>

                <li class="{{ in_array(Request::path(),['merchant/resolution-center'])?'active' : '' }}">
                    <a href="/merchant/resolution-center"><i class="fa fa-universal-access fa-lg" style="color:lightgreen" aria-hidden="true"></i><span>Conclusion Center</span></a>
                </li>

                <li class="sub-menu">
                    <a href="javascript:void(0);"><i class=" fa fa-code-fork fa-lg" style="color:chocolate"></i><span>Utilities</span><i class="arrow fa fa-angle-right pull-right"></i></a>
                    <ul id="subMenu">
                        <li class="{{ in_array(Request::path(),['merchant/tools'])?'active' : '' }}"><a href="/merchant/tools">Flashpage</a></li>
                        <li class="{{ in_array(Request::path(),['merchant/feed-back'])?'active' : '' }}"><a href="/merchant/feed-back">Feed back</a></li>
                        <li class="{{ in_array(Request::path(),['merchant/help-support'])?'active' : '' }}"><a href="/merchant/help-support">Help & Support</a></li>
                        <li class="{{ in_array(Request::path(),['merchant/serefer-earnttings'])?'active' : '' }}"><a href="/merchant/refer-earn">Refer & Earn</a></li>
                    </ul>
                </li>

                <li class="sub-menu">
                    <a href="javascript:void(0);"><i class=" fa fa-file-text fa-lg" style="color:antiquewhite"></i><span>Reports</span><i class="arrow fa fa-angle-right pull-right"></i></a>
                    <ul id="subMenu2">
                        <li class="{{ in_array(Request::path(),['merchant/transactionreport'])?'active' : '' }}"><a href="/merchant/transactionreport">Transaction Report</a></li>
                        <li class="{{ in_array(Request::path(),['merchant/gstinvoicereport'])?'active' : '' }}"><a href="/merchant/gstinvoicereport">Gst Invoice</a></li>
                        <li class="{{ in_array(Request::path(),['merchant/datatable_export'])?'active' : '' }}"><a href="/merchant/datatable_export">Datatable Exports</a></li>
                        <li class="{{ in_array(Request::path(),['merchant/miscellaneous'])?'active' : '' }}"><a href="/merchant/miscellaneous">Miscellaneous</a></li>
                    </ul>
                </li>


                <li class="sub-menu">
                    <a href="javascript:void(0);"><i class="fa fa-users fa-lg" style="color:lightblue"></i><span>Users</span><i class="arrow fa fa-angle-right pull-right"></i></a>
                    <ul id="subMenu4">
                        <li class="{{ in_array(Request::path(),['merchant/employee'])?'active' : '' }}"><a href="/merchant/employee">Employee</a></li>
                        <li class="{{ in_array(Request::path(),['merchant/employee-types'])?'active' : '' }}"><a href="/merchant/employee-types">Types</a></li>
                        

                    </ul>
                </li>



    

                <li class="{{ in_array(Request::path(),['merchant/my-account'])?'active' : '' }}">
                    <a href="/merchant/my-account"><i class="fa fa-user-circle-o fa-lg" style="color:lightsalmon"></i><span>My Account</span></a>
                </li>




            </ul>
        </div>
    </aside>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script>
    $("#leftside-navigation .sub-menu > a").click(function(e) {
        $("#leftside-navigation ul ul").slideUp(),
            $(this).next().is(":visible") || $(this).next().slideDown(),
            e.stopPropagation();
    });
</script>


<script>
    if ($('#subMenu').children().hasClass('active')) {
        $('#subMenu').css("display", "block");
    } else {

    }
</script>

<script>
    if ($('#subMenu2').children().hasClass('active')) {
        $('#subMenu2').css("display", "block");
    } else {

    }
</script>

<script>
    if ($('#subMenu3').children().hasClass('active')) {
        $('#subMenu3').css("display", "block");
    } else {

    }

    if ($('#subMenu4').children().hasClass('active')) {
        $('#subMenu4').css("display", "block");
    } else {

    }

    
</script>