@extends('layouts.frontend')

@section('body-content')
    <!-- Banner -->
    <div class="page-banner">
        <div class="container">
            <div class="parallax-mask"></div>
            <div class="section-name">
                <h2>Pembayaran Cicilan</h2>
                <div class="short-text">
                    <h5><a href="{{route('index')}}">Beranda</a>
                        <i class="fa fa-angle-double-right"></i>Pembayaran Cicilan
                    </h5>
                </div>
            </div>
        </div>
    </div>

    <!-- contact wrapper -->
    <div class="contact-page-wrapper">
        <div class="container">
            <div class="row">
                <div class="donation-wrapper">
                    <div class="container" >
                        <div class="row">
                            <div class="col-lg-offset-3 col-lg-6 col-md-offset-3 col-md-6 col-sm-6 col-xs-12">
                                {!! Form::open(array('action' => 'Frontend\VendorController@InstallmentPaymentSubmit', 'method' => 'POST', 'role' => 'form')) !!}
                                {{ csrf_field() }}

                                <div class="custom-container">
                                    <div class="row">
                                        <div class="col-md-6">
                                            Nama Proyek
                                        </div>
                                        <div class="col-md-6">
                                            <span class="pull-right"><b>{{$productInstallmentDB->Product->name}}</b></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            Jumlah Tagihan
                                        </div>
                                        <div class="col-md-6">
                                            <span class="pull-right"><b>Rp {{ $totalAmountStr }}</b></span>
                                        </div>
                                    </div>

                                    <div class="form-group price-format" id="amount_section">
                                        <label for="amount" class="control-label">Jumlah Pembayaran</label>
                                        <input type="text" class="form-control" id="amount" name="amount" placeholder="Jumlah Pembayaran">
                                    </div>
                                    <div class="row text-center">
                                        <div class="col-md-12">
                                            <input type="hidden" name="product_installment_id" value="{{$productInstallmentDB->id}}">
                                            <hr>
                                            <button type="submit" class="btn btn-primary">Proses Sekarang</button>
                                        </div>
                                    </div>
                                </div>

                                {!! Form::close() !!}
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-0"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection