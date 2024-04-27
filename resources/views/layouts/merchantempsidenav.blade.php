
        @php($mainLinks=[
        'transactions'=>'<a href="/merchant/employee/transactions"><span class="fa fa-exchange fa-lg" style="color:lightgreen"></span>&nbsp;Transactions</a>',
        'paylinks'=>'<a href="/merchant/employee/paylinks"><span class="fa fa-link fa-lg" style="color:yellow"></span>&nbsp;Paylinks</a>',
        'loginlog'=>'<a href="/merchant/employee/login-activity-log"><span class="fa fa-sign-in fa-lg" style="color:white"></span>&nbsp;Login Activity Log</a>',
    ]);
    
    @php($selectedLinks=[
        'transactions'=>['merchant/employee/transactions'],
        'paylinks'=>['merchant/employee/paylinks'],
        'loginlog'=>['merchant/employee/login-activity-log'],
    ]);

    <div class="row">
        <nav id="sidebar">
            <div class="custom-menu">
            </div>
            <ul class="list-unstyled components mb-5">
                <li>
                    <div class="text-center">
                         <img class="rupayapay-logo" src="{{ asset('assets/img/rockpay.png') }}" alt="Payflash Logo" />
                    </div>
                </li>
                @foreach($mainLinks as $index=>$value)
                    <li class="{{ in_array(Request::path(),$selectedLinks[$index])?'active' : '' }}">{!! $value !!}</li>
                @endforeach
                <li>
                    <form id="logout-form" action="{{ route('emplogout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                    <a href="{{ route('emplogout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <span class="fa fa-sign-out fa-lg" style="color:#b6b6b6"></span>&nbsp;Log Out
                    </a>
                </li>
            </ul>
        </nav>
    </div> 


    
    
