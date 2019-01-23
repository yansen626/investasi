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
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Penambahan Dana {{$user->first_name}} {{$user->last_name}}</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form id="demo-form1" data-parsley-validate class="form-horizontal form-label-left" action="#">
                            <div class="form-group">
                                <div class="control-label col-md-3 col-sm-3 col-xs-12">
                                    <label>Email :</label>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label class="form-control">{{ $user->email}} </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="control-label col-md-3 col-sm-3 col-xs-12">
                                    <label>Name :</label>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label class="form-control">{{ $user->first_name }} {{ $user->last_name}} </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="control-label col-md-3 col-sm-3 col-xs-12">
                                    <label>Virtual Account :</label>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label class="form-control">{{ $user->va_acc}} </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="control-label col-md-3 col-sm-3 col-xs-12">
                                    <label>Phone :</label>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label class="form-control">{{ $user->phone}} </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="control-label col-md-3 col-sm-3 col-xs-12">
                                    <label>Wallet :</label>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label class="form-control">{{ $user->wallet_amount}} </label>
                                </div>
                            </div>
                        </form>
                        <br />
                        <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="/admin/customer/add-dana">
                            {{ csrf_field() }}
                            <input type="hidden" name="user_id" value="{{$user->id}}" >

                            <div class="ln_solid"></div>

                            <div class="form-group">
                                <div class="control-label col-md-3 col-sm-3 col-xs-12">
                                    <label for="description">Amount <span class="required">*</span></label>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="number" id="amount" name="amount" required="required" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                            <div class="ln_solid"></div>

                            <div class="form-group">
                                <div class="control-label col-md-3 col-sm-3 col-xs-12">
                                    <label for="description">Description <span class="required">*</span></label>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="col-md-5 col-xs-12">
                                        Penambahan
                                    </div>
                                    <input type="text" id="description" name="description" required="required" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                            @if(count($errors))
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 alert alert-danger alert-dismissible fade in" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                        </button>
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li> {{ $error }} </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif

                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    @include('admin.partials._footer')
    <!-- /footer -->

@endsection