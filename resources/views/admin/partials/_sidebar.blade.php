<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>Indofund.id</span></a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="{{ URL::asset('admin_images/user.png') }}" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Welcome,</span>
                <h2>{{ \Illuminate\Support\Facades\Auth::guard('user_admins')->user()->first_name }} {{ \Illuminate\Support\Facades\Auth::guard('user_admins')->user()->last_name }}</h2>
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <ul class="nav side-menu">
                    @if(\Illuminate\Support\Facades\Auth::guard('user_admins')->user()->user_type < 3 )
                    <li>
                        <a href="{{ route('admin-dashboard') }}"><i class="fa fa-home"></i> Dashboard </a>
                    </li>
                    <li><a><i class="fa fa-tags"></i> User <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('customer-list') }}">User List</a></li>
                            <li><a href="{{route ('import')}}">Topup Saldo</a></li>
                            <li><a href="{{ route('subscribe-list') }}">Subscriber List</a></li>
                            <li><a href="{{ route('referral-list') }}">Refferal List</a></li>
                            {{--<li><a href="{{ route('product-create') }}">Tambah</a></li>--}}
                        </ul>
                    </li>
                    <li><a><i class="fa fa-tags"></i> Borrower <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('vendor-request-form') }}">Submit New Borrower</a></li>
                            <li><a href="{{ route('vendor-list') }}">Borrower List</a></li>
                            <li><a href="{{ route('product-request') }}">Project Launch</a></li>
                            <li><a href="{{ route('product-list') }}">Project List</a></li>
                            <li><a href="{{ route('product-collected-fund') }}">Project Success Funding</a></li>
                            <li><a href="{{ route('product-failed-fund') }}">Project Failed Funding</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-tags"></i> Lender <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('VA-RDN-list') }}">VA To RDN List</a></li>
                            <li><a href="{{ route('dompet-request') }}">Withdraw Request</a></li>
                            <li><a href="{{ route('dompet-list') }}">Withdraw List</a></li>
                            <li><a href="#">Submit Coupun</a></li>
                            <li><a href="{{ route('new-order-list') }}">New Transaction List</a></li>
                            <li><a href="{{ route('transaction-list') }}">Transaction List</a></li>
                        </ul>
                    </li>
                    @endif
                    <li><a><i class="fa fa-tags"></i> News & Blog <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('admin-blog-list') }}">News List</a></li>
                            <li><a href="{{ route('admin-blog-urgent-list') }}">News Urgent List</a></li>
                            <li><a href="{{ route ('blog-create') }}">Submit News</a></li>
                            <li><a href="{{ route ('admin-blog-update-list') }}">Pending News</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-tags"></i> Content <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('content-edit') }}">Edit Content</a></li>
                        </ul>
                    </li>
                        @if(\Illuminate\Support\Facades\Auth::guard('user_admins')->user()->user_type == 1 )
                    <li><a><i class="fa fa-user-secret"></i> Admin <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('admin-list') }}">Admin List</a></li>
                            <li><a href="{{ route('admin-create') }}">Submit Admin</a></li>
                        </ul>
                    </li>
                        @endif
                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->

        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{ route('admin-logout') }}">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>