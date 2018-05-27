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

    <!-- Causes Wrapper -->
    <div class="single-cause">
        <div class="container" style="margin-bottom: 20px;">
            <div class="row cause">
                <div class="col-md-10 col-md-offset-1">
                    <div class="image-wrapper">
                        <img class="img-responsive" src="assets/img/causes/single-cause.jpg" alt="">
                    </div>
                    <div class="clearfix text-center">
                        <div class="foundings">
                            <h3>
                                Pembayaran Cicilan Anda
                            </h3>
                            <h4>
                                Silahkan melakukan pembayaran senilai Rp {{ $productInstallmentDB->paid_amount}}
                                ke nomor rekening {{ $vendor->vendor_va }}
                            </h4>
                            <h4>dengan nama akun : Indofund.id ({{ $vendor->name }})*
                            </h4>
                            <h4>pembayaran dapat dilakukan maksimal 6 jam</h4>
                            <p>*Nama akun akan menjadi nama anda setelah pendaftaran 2x24 jam, nama akun default adalah indofund.id</p>
                            <a href="https://indofund.id/blog/4b3055d0-52cc-11e8-95cd-0358eaa51cd4" target="_blank" class="btn btn-big btn-info">ATM Bank Mandiri</a>
                            <a href="https://indofund.id/blog/c5922d50-52c9-11e8-aee5-21781808d846" target="_blank" class="btn btn-big btn-info">Internet Banking Mandiri</a>
                            <a href="https://indofund.id/blog/fe889710-52cb-11e8-8bde-9f2bfcf5771e" target="_blank" class="btn btn-big btn-info">Mobile Banking Mandiri</a>
                            <a href="https://indofund.id/blog/f79e91d0-52cc-11e8-8d41-195550d3cf6c" target="_blank" class="btn btn-big btn-info">Bank Lain</a>
                        </div>
                    </div>
                    <div class="info-block" style="margin: 0; padding: 0;text-align: center;">
                        <a href="{{ route('index') }}" class="btn btn-big btn-solid">Beranda</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection