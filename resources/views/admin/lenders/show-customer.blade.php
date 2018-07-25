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
                        <h2>Lender Profile</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="#">
                            @if(\Illuminate\Support\Facades\Session::has('message'))
                                <div class="form-group">
                                    <div class="control-label col-md-3 col-sm-3 col-xs-12"></div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="alert alert-success">{{ \Illuminate\Support\Facades\Session::get('message') }}</div>
                                    </div>
                                </div>
                            @endif
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
                            <div class="form-group">
                                <div class="control-label col-md-3 col-sm-3 col-xs-12">
                                    <label>Tanggal Lahir :</label>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label class="form-control">{{ $user->dob}} </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="control-label col-md-3 col-sm-3 col-xs-12">
                                    <label>Jenis Kelamin :</label>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label class="form-control">{{ $user->gender}} </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="control-label col-md-3 col-sm-3 col-xs-12">
                                    <label>Domisili :</label>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label class="form-control">{{ $user->address_stay }}</label>
                                </div>
                            </div>

                            <div class="ln_solid"></div>

                                <div class="panel-heading">

                                    <ul class="nav nav-pills nav-justified thumbnail custom-color" style="height:auto!important;">
                                        <li class="active"><a href="#transaction" data-toggle="tab">
                                                <h4 class="list-group-item-heading"><b>History Transaksi</b></h4>
                                            </a></li>
                                        <li><a href="#dompet" data-toggle="tab">
                                                <h4 class="list-group-item-heading"><b>History Dompet</b></h4>
                                            </a></li>
                                    </ul>
                                    {{--<ul class="nav nav-tabs">--}}
                                    {{--<li class="active"><a href="#project" data-toggle="tab">Data Proyek</a></li>--}}
                                    {{--<li><a href="#user" data-toggle="tab">Data Diri</a></li>--}}
                                    {{--<li><a href="#owner" data-toggle="tab">Perusahaan/Usaha</a></li>--}}
                                    {{--<li><a href="#bank" data-toggle="tab">Akun Bank</a></li>--}}
                                    {{--</ul>--}}
                                </div>

                                <div class="panel-body">
                                    <div class="tab-content">

                                        {{--tab 3--}}
                                        <div class="tab-pane active" id="transaction">

                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="x_panel">
                                                    <div class="x_title">
                                                    </div>
                                                    <div class="x_content">
                                                        <table id="datatable-responsive-trx" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                                            <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Invoice</th>
                                                                <th>Project Name</th>
                                                                <th>Payment Method</th>
                                                                <th>Total Price</th>
                                                                <th>Order Date</th>
                                                                <th>Status</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @php( $idx = 1 )
                                                            @foreach($transactions as $trx)
                                                                <tr>
                                                                    <td>{{ $idx }}</td>
                                                                    <td>{{ $trx->invoice }}</td>
                                                                    <td>{{ $trx->Product->name }}</td>
                                                                    <td>{{ $trx->payment_method->description }}</td>
                                                                    <td>Rp {{ $trx->total_price }}</td>
                                                                    <td>{{ \Carbon\Carbon::parse($trx->created_on)->format('j M Y G:i:s') }}</td>
                                                                    <td>
                                                                        @if($trx->status_id == 9)
                                                                            <span style="color: #42b549;">{{$trx->status->description}}</span>
                                                                        @elseif($trx->status_id == 10)
                                                                            <span style="color: red;">{{$trx->status->description}}</span>
                                                                            <br>
                                                                            ({{$trx->reject_note}})
                                                                        @else
                                                                            {{$trx->status->description}}
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

                                        {{--tab 4--}}
                                        <div class="tab-pane" id="dompet">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="x_panel">
                                                    <div class="x_title">
                                                    </div>
                                                    <div class="x_content">
                                                        <table id="datatable-responsive-dompet" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                                            <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Tanggal</th>
                                                                <th>Deskripsi</th>
                                                                <th class="text-right">Jumlah</th>
                                                                <th>Status</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @php( $idx = 1 )
                                                            @foreach($statements as $statement)
                                                                <tr>
                                                                    <td>{{ $idx }}</td>
                                                                    <td>{{ \Carbon\Carbon::parse($statement->date)->format('j M Y G:i:s') }}</td>
                                                                    <td>{{ $statement->description }}</td>
                                                                    <td class="text-right">Rp {{ $statement->amount }}</td>
                                                                    @if($statement->status_id == 3)
                                                                        <td>Pending</td>
                                                                    @elseif($statement->status_id == 7)
                                                                        <td>Dibatalkan</td>
                                                                    @else
                                                                        <td>Selesai</td>
                                                                    @endif

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