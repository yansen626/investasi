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
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <h3>Detail Cicilan</h3>
                                    @include('admin.partials._success')
                                    <table>
                                        <tr>
                                            <td width="80">Bulan </td>
                                            <td width="100">Tanggal Jatuh Tempo</td>
                                            <td width="100">Jumlah Tagihan</td>
                                            <td width="20"></td>
                                        </tr>
                                        @foreach($productInstallments as $productInstallment)
                                            <tr>
                                                <td width="80">Bulan {{$productInstallment->month}}</td>
                                                <td width="100">{{ \Carbon\Carbon::parse($productInstallment->due_date)->format('j-F-Y')}}</td>
                                                <td width="100">Rp {{$productInstallment->paid_amount}}</td>
                                                <td width="20">
                                                    @if($productInstallment->status_id == 26)
                                                        <a onclick="modalPop('{{ $productInstallment->id }}', 'accept', '/admin/product/installment/process/')" class="btn btn-sm btn-success">Process</a>
                                                    @elseif($productInstallment->status_id == 27)
                                                        <button class="btn btn-sm btn-primary">{{$productInstallment->status->description}}</button>
                                                    @elseif($productInstallment->status_id == 1)
                                                        <button class="btn btn-sm btn-warning">Pending</button>
                                                    @endif
                                                    {{--<a href="{{route('product-installment-payment', ['id'=>$productInstallment->id])}}" class="btn btn-primary">--}}
                                                        {{--Process--}}
                                                    {{--</a>--}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                    <div class="x_panel">
                                        <div class="x_content">
                                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                                <thead>
                                                <tr>
                                                    <th>Tanggal Transaksi</th>
                                                    <th>Invoice</th>
                                                    <th>Status</th>
                                                    <th>Nama Pendana</th>
                                                    <th>Metode Pembayaran </th>
                                                    <th>Jumlah Pendanaan</th>
                                                    <th>Persentasi</th>
                                                    @php ($idx2 = 1)
                                                    @foreach($productInstallments as $productInstallment)
                                                        <th>Pendapatan {{$idx2}}</th>
                                                        @php ($idx2++)
                                                    @endforeach
                                                </tr>
                                                </thead>
                                                <form>
                                                    <tbody>
                                                    @php ($idx = 1)
                                                        @foreach($transactionDB as $transaction)
                                                            <tr>
                                                                <td>{{ \Carbon\Carbon::parse($transaction->created_on)->format('j-F-Y H:i:s')}}</td>
                                                                <td>{{ $transaction->invoice}}</td>
                                                                <td>{{$transaction->status->description}}</td>
                                                                <td>{{ $transaction->user->first_name }} {{ $transaction->user->last_name }}</td>
                                                                <td>{{ $transaction->payment_method->description}}</td>
                                                                <td>Rp {{ $transaction->total_price}}</td>
                                                                <td>{{ \App\Libs\Utilities::UserPercentage($transaction->product->raised, $transaction->total_price)}}%</td>

                                                                @foreach($productInstallments as $productInstallment)
                                                                    <td>{{ \App\Libs\Utilities::UserGetInstallment($productInstallment->paid_amount, $productInstallment->product->raised, $transaction->total_price)}}</td>
                                                                @endforeach
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

    <!-- small modal -->
    @include('admin.partials._small_modal')
    <!-- /small modal -->

    <!-- footer -->
    @include('admin.partials._footer')
    <!-- /footer -->

@endsection