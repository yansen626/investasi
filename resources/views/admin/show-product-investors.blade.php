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
                <div class="title_left">
                    <h3>Project & Lender</h3>
                </div>

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
                <div class="col-md-12">
                    <div class="x_panel">
                        <div class="col-md-11 col-sm-11 col-xs-11">
                            <div class="x_title">
                                <h2>{{$productDB->name}}</h2>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-1 col-sm-1 col-xs-1">
                            <div class="message_date">
                                <h3 class="date text-info">{{ \Carbon\Carbon::parse($productDB->created_on)->format('j') }}</h3>
                                <p class="month">{{ \Carbon\Carbon::parse($productDB->created_on)->format('M Y') }}</p>
                            </div>
                        </div>
                        <div class="x_content">
                            <div class="col-md-3 col-sm-3 col-xs-3">
                                <div style="height:350px;">
                                    <img src="{{asset('storage\project\\'.$productDB->image_path)}}" style="max-width: 100%; max-height:100%"/>
                                </div>
                            </div>
                            <div class="col-md-9 col-sm-9 col-xs-9">
                                <ul class="stats-overview">
                                    <li>
                                        <span class="name"> Owner </span>
                                        <span class="value text-success"> {{$productDB->user->first_name}} {{$productDB->user->last_name}} </span>
                                    </li>
                                    <li>
                                        <span class="name"> Raising </span>
                                        <span class="value text-success"> Rp{{$productDB->raising}} </span>
                                    </li>
                                    <li class="hidden-phone">
                                        <span class="name"> Days Left </span>
                                        <span class="value text-success"> {{$productDB->days_left}} </span>
                                    </li>
                                </ul>
                                <br />
                                <ul class="stats-overview">
                                    <li>
                                        <span class="name"> Kelas (Suku Bunga) </span>
                                        <span class="value text-success"> {{$productDB->business_class}} ( {{$productDB->interest_rate}}% ) </span>
                                    </li>
                                    <li>
                                        <span class="name"> Dana Terkumpul </span>
                                        <span class="value text-success"> Rp {{$productDB->raised}} </span>
                                    </li>
                                    {{--<li class="hidden-phone">--}}
                                        {{--<span class="name"> Bunga/Bulan </span>--}}
                                        {{--<span class="value text-success"> Rp {{$productDB->interest_per_month}} </span>--}}
                                    {{--</li>--}}
                                </ul>
                            </div>

                            <div class="row">

                                <div class="panel-heading">

                                    <ul class="nav nav-pills nav-justified thumbnail custom-color" style="height:auto!important;">
                                        <li class="active"><a href="#pending" data-toggle="tab">
                                                <h4 class="list-group-item-heading"><b>Pending</b></h4>
                                            </a></li>
                                        <li><a href="#success" data-toggle="tab">
                                                <h4 class="list-group-item-heading"><b>Berhasil</b></h4>
                                            </a></li>
                                        <li><a href="#failed" data-toggle="tab">
                                                <h4 class="list-group-item-heading"><b>Gagal</b></h4>
                                            </a></li>
                                    </ul>
                                </div>

                                <div class="panel-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="pending">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="x_panel">
                                                    <div class="x_content">
                                                        <table class="datatable-js table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                                            <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Invoice</th>
                                                                <th>Status</th>
                                                                <th>Nama Pendana</th>
                                                                <th>Nomor VA</th>
                                                                <th>Tanggal Transaksi</th>
                                                                <th>Jumlah Pendanaan</th>
                                                                <th>Metode Pembayaran </th>
                                                            </tr>
                                                            </thead>
                                                            <form>
                                                                <tbody>
                                                                @php ($idx = 1)
                                                                @foreach($transactionDB->where('status_id', 3) as $transaction)
                                                                    <tr>
                                                                        <td>{{ $idx}}</td>
                                                                        <td>{{ $transaction->invoice}}</td>
                                                                        <td>{{$transaction->status->description}}</td>
                                                                        <td>{{ $transaction->user->first_name }} {{ $transaction->user->last_name }}</td>
                                                                        <td>{{ $transaction->user->va_acc }}</td>
                                                                        <td>{{ \Carbon\Carbon::parse($transaction->created_on)->format('j-F-Y H:i:s')}}</td>
                                                                        <td>Rp {{ $transaction->total_price}}</td>
                                                                        <td>{{ $transaction->payment_method->description}}</td>
                                                                    </tr>
                                                                    @php ($idx++)
                                                                @endforeach
                                                                </tbody>
                                                            </form>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="success">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="x_panel">
                                                    <div class="x_content">
                                                        <table class="datatable-js table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                                            <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Invoice</th>
                                                                <th>Status</th>
                                                                <th>Nama Pendana</th>
                                                                <th>Nomor VA</th>
                                                                <th>Tanggal Transaksi</th>
                                                                <th>Jumlah Pendanaan</th>
                                                                <th>Metode Pembayaran </th>
                                                            </tr>
                                                            </thead>
                                                            <form>
                                                                <tbody>
                                                                @php ($idx = 1)
                                                                @foreach($transactionDB->where('status_id', 5) as $transaction)
                                                                    <tr>
                                                                        <td>{{ $idx}}</td>
                                                                        <td>{{ $transaction->invoice}}</td>
                                                                        <td>{{$transaction->status->description}}</td>
                                                                        <td>{{ $transaction->user->first_name }} {{ $transaction->user->last_name }}</td>
                                                                        <td>{{ $transaction->user->va_acc }}</td>
                                                                        <td>{{ \Carbon\Carbon::parse($transaction->created_on)->format('j-F-Y H:i:s')}}</td>
                                                                        <td>Rp {{ $transaction->total_price}}</td>
                                                                        <td>{{ $transaction->payment_method->description}}</td>
                                                                    </tr>
                                                                    @php ($idx++)
                                                                @endforeach
                                                                </tbody>
                                                            </form>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="failed">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="x_panel">
                                                    <div class="x_content">
                                                        <table class="datatable-js table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                                            <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Invoice</th>
                                                                <th>Status</th>
                                                                <th>Nama Pendana</th>
                                                                <th>Nomor VA</th>
                                                                <th>Tanggal Transaksi</th>
                                                                <th>Jumlah Pendanaan</th>
                                                                <th>Metode Pembayaran </th>
                                                            </tr>
                                                            </thead>
                                                            <form>
                                                                <tbody>
                                                                @php ($idx = 1)
                                                                @foreach($transactionDB->where('status_id', 10) as $transaction)
                                                                    <tr>
                                                                        <td>{{ $idx}}</td>
                                                                        <td>{{ $transaction->invoice}}</td>
                                                                        <td>{{$transaction->status->description}}</td>
                                                                        <td>{{ $transaction->user->first_name }} {{ $transaction->user->last_name }}</td>
                                                                        <td>{{ $transaction->user->va_acc }}</td>
                                                                        <td>{{ \Carbon\Carbon::parse($transaction->created_on)->format('j-F-Y H:i:s')}}</td>
                                                                        <td>Rp {{ $transaction->total_price}}</td>
                                                                        <td>{{ $transaction->payment_method->description}}</td>
                                                                    </tr>
                                                                    @php ($idx++)
                                                                @endforeach
                                                                </tbody>
                                                            </form>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- small modal -->
    @include('admin.partials._small_modal')
    <!-- /small modal -->

    <!-- footer -->
    @include('admin.partials._footer')
    <!-- /footer -->

@endsection


@section('styles')
    @parent
    <style>
    </style>
@endsection

@section('scripts')
    @parent
    <script>
        $("a[data-toggle=\"tab\"]").on("shown.bs.tab", function (e) {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });

        $('.datatable-js').DataTable( {
            buttons: [
                {
                    responsive: {
                        details: {
                            display: $.fn.dataTable.Responsive.display.childRowImmediate,
                            type: ''
                        }
                    },
                    extend: 'print',
                    text: 'Print current page',
                    exportOptions: {
                        modifier: {
                            page: 'current'
                        }
                    }
                }
            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Indonesian-Alternative.json"
            }
        } );
    </script>
@endsection