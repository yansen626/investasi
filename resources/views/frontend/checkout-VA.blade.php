@extends('layouts.frontend')

@section('body-content')
    <!-- Banner -->
    <div class="page-banner">
        <div class="container">
            <div class="parallax-mask"></div>
            <div class="section-name">
                <h2>Pembayaran</h2>
                <div class="short-text">
                    <h5><a href="{{route('index')}}">Beranda</a>
                        <i class="fa fa-angle-double-right"></i><a href="{{ route('project-list', ['tab' => 'debt']) }}">Daftar Investasi</a>
                        <i class="fa fa-angle-double-right"></i>Pembayaran
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
                    <div class="meta">
                        <h2>Pembayaran Transfer Bank</h2>
                    </div>
                    <div class="clearfix text-center">
                        <div class="foundings">
                            <h4>
                                Silahkan melakukan pembayaran senilai Rp {{ $transaction->total_payment}}
                                ke nomor rekening {{ $user->va_acc }}
                            </h4>
                            <h4>dengan nama akun : Indofund.id({{ $user->first_name }} {{$user->last_name}})*
                            </h4>
                            <h4>pembayaran dapat dilakukan maksimal 4 jam</h4>
                            <p>*Nama akun akan menjadi nama anda setelah pendaftaran 2x24 jam, nama akun default adalah indofund.id</p>
                            {{--<h4>Nomor Virtual Akun = {{ $user->va_acc }}</h4>--}}
                            {{--<h4>Nama Akun = Indofund.id({{ $user->first_name }} {{$user->last_name}})*</h4>--}}
                            {{--<h4>Total Pembayaran = Rp {{ $transaction->total_payment}}</h4>--}}
                            {{--<p>Pembayaran maksimal 24 jam</p><br>--}}
                            {{--<p>*Nama akun anda akan terupdate menjadi nama anda setelah pendaftaran 2x24 jam</p>--}}
                            <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#mandiri">Bank Mandiri</button>
                            <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#bank_lain">Bank Lain</button>
                        </div>
                    </div>
                    <div class="info-block" style="margin: 0; padding: 0;">
                        <div id="mandiri" class="collapse">
                            <h3>Pembayaran dengan Bank Mandiri</h3>
                            <h5>*Pembayaran tidak dapat dilakukan dengan mobile banking gunakan ATM atau Internet banking</h5>
                            <ol>
                                <li>1. Masukkan kartu ATM dan PIN MANDIRI Anda</li>
                                <li>2. Masuk ke menu BAYAR/BELI > menu LAINNYA > menu LAINNYA > menu MULTIPAYMENT</li>
                                <li>3. Masukkan KODE PERUSAHAAN yaitu 88795</li>
                                <li>4. Masukkan nomor virtual account Anda: {{$user->va_acc}}</li>
                                <li>5. Masukkan jumlah nominal yang akan di bayarkan / di transfer</li>
                                <li>6. Ikuti instruksi untuk menyelesaikan transaksi</li>
                            </ol>
                        </div>
                        <div id="bank_lain" class="collapse">
                            <h3>Pembayaran dengan Bank Lain</h3>
                            <ol>
                                <li>1. Masukkan kartu ATM dan PIN ATM Anda</li>
                                <li>2. Pilih menu transfer</li>
                                <li>3. Masukkan kode Bank Mandiri 008</li>
                                <li>4. Masukkan nomor virtual account Anda: {{$user->va_acc}}</li>
                                <li>5. Masukkan jumlah nominal yang akan di bayarkan / di transfer</li>
                            </ol>
                        </div>
                    </div>
                    <div class="info-block" style="margin: 0; padding: 0;">
                        <a href="{{ route('portfolio', ['tab' => 'pending']) }}" class="btn btn-big btn-solid">Status Pembayaran</a>
                        <a href="{{ route('index') }}" class="btn btn-big btn-solid">Beranda</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection