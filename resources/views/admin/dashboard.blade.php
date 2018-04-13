@extends('layouts.admin')

@section('dashboard')

    <!-- sidebar -->
    @include('admin.partials._sidebar')
    <!-- sidebar -->

    <!-- top navigation -->
    @include('admin.partials._navigation')
    <!-- /top navigation -->

    <div class="right_col" role="main">
        <!-- top tiles -->
        <div class="row tile_count">
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> Investor Baru (1 Bulan)</span>
                <div class="count">{{ $newCustomerTotal }}</div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-money"></i> Transaksi Baru</span>
                <div class="count">{{ $newOrderTotal }}</div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-dollar"></i> Penarikan Dompet</span>
                <div class="count">{{ $walletWithdraw }}</div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-money"></i> Pembayaran Akun Virtual</span>
                <div class="count">{{ $onGoingPaymentBankTotal }}</div>
            </div>
        </div>
        <!-- /top tiles -->
        <!-- top tiles -->
        <div class="row tile_count">
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> Tambah Borrower Baru</span>
                <br>
                <a style="color: dodgerblue;" href="{{ route('vendor-request-form') }}"><strong>Klik disini</strong></a>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> Edit Konten Website</span>
                <br>
                <a style="color: dodgerblue;" href="{{ route('content-edit') }}"><strong>Klik disini</strong></a>
            </div>
        </div>
        <!-- /top tiles -->

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="dashboard_graph">

                    <div class="row x_title">
                        <div class="col-md-6">
                            <h3>Selamat Datang</h3>
                        </div>
                        {{--<div class="col-md-6">--}}
                            {{--<div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">--}}
                                {{--<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>--}}
                                {{--<span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    </div>

                    <div class="col-md-9 col-sm-9 col-xs-12">
                        @if($fundingDone == 0 && $fundingFailed == 0 && $twoDayTransfer == 0 && $newOrderTotal == 0 && $walletWithdraw == 0)
                            <div class="alert alert-info alert-dismissible fade in" role="alert">
                                <strong>Halo!</strong> Saat ini tidak ada yang memerlukan tindakan Anda
                            </div>
                        @endif

                        @if($fundingDone > 0)
                            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                Terdapat {{ $fundingDone }} Dana proyek BERHASIL terkumpul
                                , Anda dapat mengecek <a style="color: dodgerblue;" href="{{ route('product-collected-fund') }}"><strong>disini</strong></a>
                            </div>
                        @endif

                        @if($fundingFailed > 0)
                            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                Terdapat {{ $fundingFailed }} Dana proyek GAGAL terkumpul
                                , Anda dapat mengecek <a style="color: dodgerblue;" href="{{ route('product-failed-fund') }}"><strong>disini</strong></a>
                            </div>
                        @endif

                        @if($twoDayTransfer > 0)
                            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                Terdapat {{ $twoDayTransfer }} Jatuh Tempo pemindahan VA ke RDN
                                , Anda dapat mengecek <a style="color: dodgerblue;" href="{{ route('VA-RDN-list') }}"><strong>disini</strong></a>
                            </div>
                        @endif

                        @if($newOrderTotal > 0)
                            <div class="alert alert-warning alert-dismissible fade in" role="alert">
                                Terdapat {{ $newOrderTotal }} transaksi baru
                                , Anda dapat mengecek <a style="color: dodgerblue;" href="{{ route('new-order-list') }}"><strong>disini</strong></a>
                            </div>
                        @endif

                        {{--@if($onGoingPaymentTotal > 0)--}}
                            {{--<div class="alert alert-warning alert-dismissible fade in" role="alert">--}}
                                {{--Terdapat {{ $onGoingPaymentTotal }} pembayaran baru--}}
                                    {{--, Anda dapat mengecek statusnya <a style="color: dodgerblue;" href="{{ route('payment-list') }}"><strong>disini</strong></a>--}}
                            {{--</div>--}}
                        {{--@endif--}}

                        @if($walletWithdraw > 0)
                            <div class="alert alert-warning alert-dismissible fade in" role="alert">
                                Terdapat {{ $walletWithdraw }} penarikan dompet baru
                                    , Anda dapat mengecek statusnya <a style="color: dodgerblue;" href="{{ route('dompet-request') }}"><strong>disini</strong></a>
                            </div>
                        @endif
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

        </div>
        <br />
    </div>

@endsection