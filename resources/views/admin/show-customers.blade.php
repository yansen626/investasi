@extends('layouts.admin')

@section('dashboard')

    <!-- sidebar -->
    @include('admin.partials._sidebar')
    <!-- sidebar -->

    <!-- top navigation -->
    @include('admin.partials._navigation')
    <!-- /top navigation -->

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                {{--<div class="title_left">--}}
                    {{--<h3>Users <small>Some examples to get you started</small></h3>--}}
                {{--</div>--}}

                {{--<div class="title_right">--}}
                    {{--<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">--}}
                        {{--<div class="input-group">--}}
                            {{--<input type="text" class="form-control" placeholder="Search for...">--}}
                            {{--<span class="input-group-btn">--}}
                          {{--<button class="btn btn-default" type="button">Go!</button>--}}
                        {{--</span>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Lender List</h2>
                            <div class="nav navbar-right">
                                <a href="{{ route('download-mcm') }}" class="btn btn-app">
                                    <i class="fa fa-download"></i> Download MCM to Excel
                                </a>
                            </div>
                            {{--<ul class="nav navbar-right panel_toolbox">--}}
                                {{--<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>--}}
                                {{--</li>--}}
                                {{--<li class="dropdown">--}}
                                    {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>--}}
                                    {{--<ul class="dropdown-menu" role="menu">--}}
                                        {{--<li><a href="#">Settings 1</a>--}}
                                        {{--</li>--}}
                                        {{--<li><a href="#">Settings 2</a>--}}
                                        {{--</li>--}}
                                    {{--</ul>--}}
                                {{--</li>--}}
                                {{--<li><a class="close-link"><i class="fa fa-close"></i></a>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            @include('admin.partials._success')
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Join Date</th>
                                    <th>Name</th>
                                    <th>E-mail</th>
                                    <th>Phone</th>
                                    <th>VA Number</th>
                                    <th>Wallet Amount</th>
                                    <th>Last Login</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php( $idx = 1 )
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($user->created_at)->format('j M Y G:i:s') }}</td>
                                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->va_acc == null ? "-" : $user->va_acc }}</td>
                                        <td>Rp {{ $user->wallet_amount }}</td>
                                        <td>{{ $user->last_login!=null ? \Carbon\Carbon::parse($user->last_login)->format('j M Y G:i:s') : "-" }}</td>
                                        <td>
                                            <a href="{{route('customer-detail', ['id'=> $user->id])}}" class="btn btn-primary">Detail</a>
                                            <a href="{{route('customer-ktp', ['id'=> $user->id])}}" class="btn btn-primary">Detail KTP</a>
                                            @if($adminType == 1)
                                                <a href="{{route('customer-add-dana', ['id'=> $user->id])}}" class="btn btn-danger">Tambah Dana</a>
                                            @endif
                                        </td>
                                    </tr>
                                    @php( $idx++ )
                                @endforeach
                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->

@endsection