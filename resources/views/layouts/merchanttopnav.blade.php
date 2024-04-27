  <header class="header">
  <nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
     <div class="user-image">
      <a class="navbar-brand" href="#">
        <img class="rupayapay-top-nav-logo" src="{{asset('new/img/rockpay.png')}}" alt="Payflash logo"/>
      </a>
     </div>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      @php
          use App\Http\Controllers\MerchantController;
      @endphp

      @php($mainLinks=[
                'dashboard'=>'<a href="/merchant/dashboard"><span class="fa fa-dashboard " style="color:rgb(0, 0, 0)"></span>&nbsp;Dashboard</a>',
                'transactions'=>'<a href="/merchant/transactions"><span class="fa fa-exchange" style="color:rgb(0, 0, 0)"></span>&nbsp;Transactions</a>',
                'paylinks'=>'<a href="/merchant/paylinks"><span class="fa fa-link " style="color:rgb(0, 0, 0)"></span>&nbsp;Paylinks</a>',
                'invoices'=>'<a href="/merchant/invoices"><span class="fa fa-file-text " style="color:rgb(0, 0, 0)b6"></span>&nbsp;Invoices</a>',
                'adjustments'=>'<a href="/merchant/settlements"><span class="fa fa-handshake-o" style="color:rgb(0, 0, 0)"></span>&nbsp;Adjsutments</a>',
                'settings'=>'<a href="/merchant/settings"><span class="fa fa-cog" style="color:rgb(0, 0, 0)"></span>&nbsp;Settings</a>',
                'resolution'=>'<a href="/merchant/resolution-center"><span class="fa fa-university" style="color:rgb(0, 0, 0)"></span>&nbsp;Conclusion Center</a>',
                'feed-back'=>'<a href="/merchant/feed-back"><span class="fa fa-comments " style="color:rgb(0, 0, 0)"></span>&nbsp;Feed back</a>',
                'help-support'=>'<a href="/merchant/help-support"><span class="fa fa-ticket " style="color:rgb(0, 0, 0)"></span>&nbsp;Help & Support</a>',
                'refer-earn'=>'<a href="/merchant/refer-earn"><span class="fa fa-money " style="color:rgb(0, 0, 0)"></span>&nbsp;Refer & Earn</a>',
                'tools'=>'<a href="/merchant/tools" ><span class="fa fa fa-wrench " style="color:rgb(0, 0, 0)
                "></span>&nbsp;Utilities</a>'
            ])

            @php($selectedLinks=[
                'dashboard'=>['merchant/dashboard'],
                //'transactions'=>['merchant/payments'],
                'transactions'=>['merchant/transactions'],
                'paylinks'=>['merchant/paylinks'],
                'invoices'=>['merchant/invoices'],
                'adjustments'=>['merchant/settlements'],
                'settings'=>['merchant/settings'],
                'resolution'=>['merchant/resolution-center'],
                'feed-back'=>['merchant/feed-back'],
                'help-support'=>['merchant/help-support'],
                'refer-earn'=>['merchant/refer-earn'],
                'tools'=>['/merchant/tools']
            ])
            
            
          
      <ul class="nav navbar-nav show-nav">
        @foreach($mainLinks as $index=>$value)
            <li class="{{ in_array(Request::path(),$selectedLinks[$index])?'active' : '' }}">{!! $value !!}</li>
        @endforeach
      </ul>
      <ul class="nav navbar-nav navbar-left">
        @guest
        @else
        <li class="current-time"><a href="javascript:void(0)"><strong><div id="nav-clock"></div></strong></a></li>
        <li class="ip-address" ><a href="javascript:void(0)"><strong><span style='color:#d7943d'>Login Ip:</span> {{ Request::ip()}}</strong></a></li>
        <li class="ip-address" ><a href="javascript:void(0)"><strong><span style='color:#d7943d'>Non Setteled Amount : </span>{{ number_format(MerchantController::current_amount(),2)}}</strong>&nbsp;₹</a></li>
        @endguest
      </ul>
      <ul class="nav navbar-nav navbar-right">
        @guest
            <li><a href="{{ route('login') }}">Login</a></li>
            <li><a href="{{ route('register') }}">Register</a></li>
        @else
        <li class="nav-item dropdown messages-menu">
          <a class="nav-link dropdown-toggle bell" href="javascript:" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="viewAllNotifications();">
            <i class="fa fa-bell-o"></i>
            <span class="label label-success bg-success" id="new-notification-count"></span>
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <ul class="dropdown-menu-over list-unstyled">
              <li class="header-ul text-center" id="new-notification-status"></li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu list-unstyled" id="notifications-list"> 
                </ul>
            </li>
            <li class="footer-ul text-center"><a href="/merchant/my-account/notifications">View all notifications</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item dropdown notifications-menu">
        <a class="nav-link dropdown-toggle msg" href="javascript:" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
          <i class="fa fa-envelope-o fa-2x"></i>
          <span class="label label-warning bg-warning" id="new-message-count"></span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <ul class="dropdown-menu-over list-unstyled">
            <li class="header-ul text-center" id="new-message-status"></li>
            <li>
              <!-- inner menu: contains the actual data -->
              <ul class="menu list-unstyled" id="messages-list">
              </ul>
            </li>
            <li class="footer-ul text-center"><a href="/merchant/my-account/messages">View all messages</a></li>
          </ul>
        </div>
      </li>
            <!--  -->
            <li class="dropdown">
                <a>
                    <select name="app_mode" id="app_mode" class="form-control input-sm" onchange="changeAppMode(this);">
                        <option value="1" {{ Auth::user()->app_mode==1?"selected":""}}>Live Mode</option>
                        <option value="0" {{ Auth::user()->app_mode==0?"selected":""}}>Test Mode</option>
                    </select>
                </a>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle admin-name" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre id="merchant-name">
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <ul class="dropdown-menu">
                    <li><i class="fa fa-id-badge dropdown-icon" ></i><p><label class="dropdown-label">Merchant Id:</label>{{Auth::user()->merchant_gid}}</p></li>
                    <li><i class="fa fa-ticket dropdown-icon"></i><p class="dropdown-p">Support Details</p></li>
                    <li><p><label class="dropdown-label">Contact:</label><a href="tel:+91 9087711911">+91 9087711911</a></p></li>
                    <li><p><label class="dropdown-label">Email:</label><a href="mailto:support@flakpay.in">support@flakpay.in</a></p></li>
                    <li>
                      
                      <i class="fa fa-unlock dropdown-icon" ></i><p class="dropdown-p"><a href="/merchant/two-factor-auth">2FA Authentication</a></p>
                    
                    </li>
                    <li><i class="fa fa-user dropdown-icon" ></i><p class="dropdown-p">Account Manager Details</p></li>
                    <li><p><label class="dropdown-label">Contact:</label><a href="tel:+91 9087711911">+91 9087711911</a></p></li>
                    <li><p><label class="dropdown-label">Email:</label><a href="mailto:hello@flakpay.in">hello@flakpay.in</a></p></li>
                    <li>
                      <i class="fa fa-sign-out dropdown-icon">
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                            Logout
                        </a></i>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li> 
                  </ul>
            </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>
</header>
