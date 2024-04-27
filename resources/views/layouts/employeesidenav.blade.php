@php
    use App\Http\Controllers\EmployeeController;

    $filterlinks = EmployeeController::navigation();

    $selectedLinks=['dashboard'=>'/flakpay/dashboard','myaccount'=>'/flakpay/my-account'];
    $icons = [
       
       
        "fa fa-handshake-o",
        "fa fa-credit-card",
        "fa fa-group",
        "fa fa-inr",
        "fa fa-calculator",
        "fa fa-bullhorn",
        "fa fa-tags",
        "fa fa-shield",
        "fa fa-gavel",
        "fa fa-usb",
        "fa fa-ticket",
        "fa fa-wrench",
        "fa fa-search",
        "fa fa-sign-out" 
    ];

    $sublinks_names = [];

    $sublink_ids = [];

// Define your desired menu order
$desiredOrder = ['Settlement', 'Payout','Merchant','Finance','Account','Marketing','Sales','Risk & Complaince','Legal','Networking','Support','Technical','HRM'];

// Reorder the $filterlinks array based on $desiredOrder
$reorderedLinks = [];
foreach ($desiredOrder as $linkName) {
    foreach ($filterlinks as $link) {
        if ($link['link_name'] === $linkName) {
            $reorderedLinks[] = $link;
            break;
        }
    }
}


$filterlinks = $reorderedLinks;


@endphp
<style>
li#submenu-107 {
    text-wrap: nowrap !important;
}
.sidebar-wrapper .sidebar-menu ul li:hover > a,
.sidebar-wrapper .sidebar-menu .sidebar-dropdown.active > a {
  color: #fff;
  background-color: #178ddb;
}

.sidebar-submenulist.active a{
  color: #fff !important;
  background-color: #E3A13D !important;

}

</style>
<div class="row">
    <div class="page-wrapper toggled">
        <nav id="sidebar" class="sidebar-wrapper">
            <div class="sidebar-content">
                <a href="#" id="toggle-sidebar"><i class="fa fa-bars"></i></a>
                <div class="sidebar-brand">
                    <div class="text-center">
                        <img class="rupayapay-logo" src="{{asset('new/img/flakpay_logo.png')}}" alt="rockpay App"  style=" width: 336px; height: 40px;
"/>
                    </div>
                </div>
                <div class="sidebar-menu">
                    @if(!empty($filterlinks))
                    <ul>
                        <li class="sidebar-dropdown dash {{ (Request::path() === 'flakpay/dashboard')?'active':''}}">
                            <a href="{{$selectedLinks['dashboard']}}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a>
                        </li>

                        @foreach($filterlinks as $index => $link)
                        <li class="sidebar-dropdown">
                            @if(!empty($filterlinks[$index]["sublinks"]))
                            <a href="javascript:void(0)"><i class="{{$icons[$index]}}"></i><span></span><span>{{$filterlinks[$index]["link_name"]}}</span></a>
                                <div class="sidebar-submenu">
                                    <ul>
                                        @foreach($filterlinks[$index]["sublinks"] as $index => $sublink)
                                            @php 
                                                $sublink_array = explode("/",$sublink["hyperlink"]);
                                                $sublink_count = count($sublink_array);
                                                $sublinks_names[$sublink_array[$sublink_count-1]] = $sublink["link_name"];
                                                $sublink_ids[$sublink["id"]] = $sublink["hyperlinkid"];
                                            @endphp
                                            <li id="submenu-{{$sublink['id']}}" class="sidebar-submenulist"><a href="{{$sublink['hyperlink']}}">{{$sublink['link_name']}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                            @php 
                               
                            @endphp
                            <a href="{{$link['hyperlink']}}"><i class="{{$icons[$index]}}"></i><span>{{$link["link_name"]}}</span></a>
                            @endif
                        </li>
                        @endforeach
                        <li class="sidebar-dropdown dash {{ (Request::path() === 'flakpay/my-account')?'active':''}}">
                            <a href="{{$selectedLinks['myaccount']}}"><i class="fa fa-user"></i> <span>My Account</span></a>
                        </li>
                        <li>
                            <form id="logout-form" action="{{ route('rupayapay.logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                            <a href="{{ route('rupayapay.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out"></i> <span>Log Out</span>
                            </a>
                        </li>
                    </ul>
                    @endif
                </div>

            </div>
        </nav>
    </div>
</div>
@php
session(['sublinkNames'=>$sublinks_names])
@endphp

<script>
    document.addEventListener('DOMContentLoaded', function () {

        // Check if there is a stored active submenu in local storage
        var activeSubmenu = localStorage.getItem('activeSubmenu');


        $(`#${activeSubmenu}`).parent().parent().css('display','block')
        $(`#${activeSubmenu}`).parent().parent().parent().addClass("active")
        
       

        // If there is an active submenu, add the 'active' class to it
        if (activeSubmenu) {
            var activeSubmenuElement = document.getElementById(activeSubmenu);
            if (activeSubmenuElement) {
                activeSubmenuElement.classList.add('active');
                // If your submenu has a parent dropdown, you may need to add 'show' class as well
                activeSubmenuElement.closest('.sidebar-dropdown').classList.add('show');
            }
        }

            $('.sidebar-submenulist').click(function () {
                // Remove 'active' class from all submenu items


                // Add 'active' class to the clicked submenu item
                this.classList.add('active');

                // Store the active submenu in local storage
                localStorage.setItem('activeSubmenu', this.getAttribute('id'));
            });

        $('.dash').click(function () {
        
           localStorage.clear();

        });
            
    });
</script>
