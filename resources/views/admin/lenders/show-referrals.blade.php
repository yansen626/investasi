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
                            <h2>Referral List</h2>
                            {{--<div class="nav navbar-right">--}}
                                {{--<a href="{{ route('download-subscribe') }}" class="btn btn-app">--}}
                                    {{--<i class="fa fa-download"></i> Download to Excel--}}
                                {{--</a>--}}
                            {{--</div>--}}
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Parent E-mail</th>
                                    <th>Parent Name</th>
                                    <th>Parent VA</th>
                                    <th>Child E-mail</th>
                                    <th>Child Name</th>
                                    <th>Child VA</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php( $idx = 1 )
                                @foreach($referrals as $referral)
                                    <tr>
                                        <td>{{ $idx }}</td>
                                        <td>{{ $referral->user->email }}</td>
                                        <td>{{ $referral->user->first_name }} {{ $referral->user->last_name }}</td>
                                        <td>{{ $referral->user->va_acc }}</td>
                                        <td>{{ $referral->user1->email }}</td>
                                        <td>{{ $referral->user1->first_name }} {{ $referral->user1->last_name }}</td>
                                        <td>{{ $referral->user1->va_acc }}</td>
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