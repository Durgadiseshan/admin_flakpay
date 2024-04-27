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
          <img class="rupayapay-top-nav-logo" src="{{asset('images/neopay.png')}}" alt="Neopay"/>
        </a>
       </div>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        @php
            use App\Http\Controllers\MerchantController;
        @endphp
  
        @php($mainLinks=[
                  'transactions'=>'<a href="/merchant/transactions"><span class="fa fa-exchange" style="color:rgb(0, 0, 0)"></span>&nbsp;Transactions</a>',
                  'paylinks'=>'<a href="/merchant/paylinks"><span class="fa fa-link " style="color:rgb(0, 0, 0)"></span>&nbsp;Paylinks</a>',
              ])
  
              @php($selectedLinks=[
                  'transactions'=>['merchant/transactions'],
                  'paylinks'=>['merchant/paylinks'],
              ])
              
              
            
        <ul class="nav navbar-nav show-nav">
          @foreach($mainLinks as $index=>$value)
              <li class="{{ in_array(Request::path(),$selectedLinks[$index])?'active' : '' }}">{!! $value !!}</li>
          @endforeach
        </ul>
        <ul class="nav navbar-nav navbar-left">
          @auth("merchantemp")
          <li class="current-time"><a href="javascript:void(0)"><strong><div id="nav-clock"></div></strong></a></li>
          <li class="ip-address" ><a href="javascript:void(0)"><strong><span style='color:#00a8e9'>Login Ip:</span> {{ Request::ip()}}</strong></a></li>
          <!-- <li class="ip-address" ><a href="javascript:void(0)"><strong><span style='color:#00a8e9'>Current Amount:</span></strong>&nbsp;₹</a></li> -->
          @endauth
        </ul>
        <ul class="nav navbar-nav navbar-right">
          @auth("merchantemp")
            <!-- <li class="nav-item dropdown messages-menu">
                <a class="nav-link dropdown-toggle bell" href="javascript:" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="viewAllNotifications();">
                <i class="fa fa-bell-o"></i>
                <span class="label label-success bg-success" id="new-notification-count"></span>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <ul class="dropdown-menu-over list-unstyled">
                    <li class="header-ul text-center" id="new-notification-status"></li>
                    <li>
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
                        <ul class="menu list-unstyled" id="messages-list">
                        </ul>
                    </li>
                    <li class="footer-ul text-center"><a href="/merchant/my-account/messages">View all messages</a></li>
                </ul>
                </div>
            </li> -->
            <li class="dropdown">
                <a href="#" class="dropdown-toggle admin-name" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre id="merchant-name">
                {{ Auth::guard('merchantemp')->user()->employee_name }} <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                <li>
                    <i class="fa fa-id-badge dropdown-icon" ></i>
                    <p><label class="dropdown-label">Username:</label>{{Auth::guard('merchantemp')->user()->employee_gid}}</p>
                </li>
                <li>
                    <i class="fa fa-ticket dropdown-icon"></i>
                    <p class="dropdown-p">Support Details</p>
                </li>
                <li>
                    <p><label class="dropdown-label">Contact:</label><a href="tel:+91 7676752187">+91 7676752187</a></p>
                </li>
                <li>
                    <p><label class="dropdown-label">Email:</label><a href="mailto:support@neopay.co.in">support@neopay.co.in</a></p>
                </li>
                <li>
                    <i class="fa fa-user dropdown-icon" ></i>
                    <p class="dropdown-p">Account Manager Details</p>
                </li>
                <li>
                    <p><label class="dropdown-label">Contact:</label><a href="tel:+91 9718667722">+91 9718667722</a></p>
                </li>
                <li>
                    <p><label class="dropdown-label">Email:</label><a href="mailto:support@neopay.co.in">support@neopay.co.in</a></p>
                </li>
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
          @endauth
        </ul>
      </div>
    </div>
  </nav>
  </header>
  