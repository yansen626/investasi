@extends('layouts.frontend-home')

@section('body-content')
    @if(auth()->check())
        <!-- Features -->
        <div class="features-wrapper one">
            <div class="container" style="margin-top: 40px;">
                <div class="section-name one">
                    <h2>
                        Halo Selamat Datang , {{ \Illuminate\Support\Facades\Auth::User()->first_name }} {{ \Illuminate\Support\Facades\Auth::user()->last_name }}
                        <br>
                        Saat ini Anda memiliki {{$onGoingProductCount}} Transaksi berjalan
                    </h2>
                </div>
                <div class="row features">
                    @if($user->wallet_amount != 0)
                        <div class="col-md-4 col-sm-12" data-toggle="tooltip" data-placement="bottom" title="Danai Proyek adalah list proyek yang dapat didanai, link ini sama seperti pada link Daftar Proyek pada menu utama di header">
                            <a href="{{route('project-list', ['tab' => 'premium'])}}">
                                <div class="feature clearfix">
                                    <img class="homepage-section1-img" src="{{ URL::asset('frontend_images/homepage/login-1.png') }}">
                                    <h4>Danai Proyek</h4>
                                    <div class="feature-div">
                                        <p>Saat ini terdapat {{$recentProductCount}} proyek bisa Anda danai, klik disini</p>
                                        {{--<p>3 hampir selesai, 3 selesai</p>--}}
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 col-sm-12 " data-toggle="tooltip" data-placement="bottom" title="Penarikan Saldo adalah menu yang digunakan borower untuk memeriksa saldo maupun melakukan penarikan.">

                            <a href="{{route('my-wallet')}}">
                                <div class="feature clearfix">
                                    <img class="homepage-section1-img" src="{{ URL::asset('frontend_images/homepage/login-2.png') }}">
                                    <h4>Penarikan Saldo</h4>
                                    <div class="feature-div">
                                        <p>Total Saldo Anda saat ini Rp. {{$user->wallet_amount}}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 col-sm-12" data-toggle="tooltip" data-placement="bottom" title="Ringkasan Akun Anda adalah menu borrower melakukan pengecekan terhadap hasil keuntungan hasil bunga dari proyek yang didanainya.">

                            {{--<a href="{{route('portfolio', ['tab' => 'sum'])}}">--}}
                            <a href="{{route('portfolio', ['tab' => 'debt'])}}">
                                <div class="feature  clearfix">
                                    <img class="homepage-section1-img" src="{{ URL::asset('frontend_images/homepage/login-3.png') }}">
                                    <h4>Ringkasan Akun Anda </h4>
                                    <div class="feature-div">
                                        <p>Monitor pendapatan Anda disini</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @else
                        <div class="col-md-offset-2 col-md-4 col-sm-12" data-toggle="tooltip" data-placement="bottom" title="Investasi sekarang adalah list proyek yang dapat didanai, link ini sama seperti pada link investasi pada menu utama di header">
                            <a href="{{route('project-list', ['tab' => 'premium'])}}">
                                <div class="feature clearfix">
                                    <img class="homepage-section1-img" src="{{ URL::asset('frontend_images/homepage/login-1.png') }}">
                                    <h4>Danai Proyek</h4>
                                    <div class="feature-div">
                                        <p>Saat ini terdapat {{$recentProductCount}} proyek bisa Anda danai, klik disini</p>
                                        {{--<p>3 hampir selesai, 3 selesai</p>--}}
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 col-sm-12" data-toggle="tooltip" data-placement="bottom" title="Pendapatan adalah menu investor melakukan pengecekan terhadap hasil keuntungan (kerugian) hasil bunga atau dividen atau bagi hasil dari investasinya.">

                            {{--<a href="{{route('portfolio', ['tab' => 'sum'])}}">--}}
                            <a href="{{route('portfolio', ['tab' => 'debt'])}}">
                                <div class="feature  clearfix">
                                    <img class="homepage-section1-img" src="{{ URL::asset('frontend_images/homepage/login-3.png') }}">
                                    <h4>Ringkasan Akun Anda </h4>
                                    <div class="feature-div">
                                        <p>Monitor pendapatan Anda disini</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                </div>

                {{--@if($isBorrower)--}}
                    {{--<div class="row features">--}}
                        {{--<div class="col-md-offset-2 col-md-4 col-sm-12">--}}
                            {{--<a href="#">--}}
                                {{--<div class="feature clearfix">--}}
                                    {{--<img class="homepage-section1-img" src="{{ URL::asset('frontend_images/homepage/login-1.png') }}">--}}
                                    {{--<h4>Proyek Saya</h4>--}}
                                    {{--<div class="feature-div">--}}
                                        {{--<p>Saat ini terdapat {{$myProductCount}} proyek Anda yang berjalan</p>--}}
                                        {{--<p>3 hampir selesai, 3 selesai</p>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-4 col-sm-12">--}}
                            {{--<a href="{{route('installment')}}">--}}
                                {{--<div class="feature  clearfix">--}}
                                    {{--<img class="homepage-section1-img" src="{{ URL::asset('frontend_images/homepage/login-2.png') }}">--}}
                                    {{--<h4>Cicilan Proyek </h4>--}}
                                    {{--<div class="feature-div">--}}
                                        {{--<p>Bayar Cicilan Proyek Anda disini</p>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--@endif--}}

                @if($onGoingProducts->count() > 0)
                <div class="one">
                    <h2>Proyek yang Anda Danai</h2>
                </div>
                <div style="margin: 40px; !important">

                    @foreach($onGoingProducts as $transaction)

                        @php( $togo = $transaction->product->getOriginal('raising') - $transaction->product->getOriginal('raised') )
                        @php( $togo = number_format($togo,0, ",", ".") )
                        @php( $percentage = ($transaction->product->getOriginal('raised') * 100) / $transaction->product->getOriginal('raising') )
                        @php( $percentage = number_format($percentage, 2) )
                        <a href="{{ route('project-detail', ['id' => $transaction->product->id]) }}">
                            <div class="col-md-12 project-border">
                                <div class="col-md-3">
                                    <span>Nama Project</span>
                                    <br>
                                    <span style="color: #ff7a00">{{ $transaction->product->name }}</span>
                                    <br>
                                    <span>{{ $transaction->invoice }}</span>
                                </div>
                                <div class="col-md-3">
                                    Jumlah Pendanaan
                                    <br>
                                    <span style="color: #ff7a00">Rp {{ $transaction->total_price }}</span>
                                </div>
                                <div class="col-md-2">
                                    Rating Rate
                                    <br>
                                    <span style="color: #ff7a00">{{$transaction->product->business_class}} {{$transaction->product->interest_rate}}% / tahun</span>
                                </div>
                                <div class="col-md-2">
                                    Status
                                    <br>
                                    <span style="color: #ff7a00">{{$transaction->Status->description}} </span>
                                    @if(!empty($transaction->modified_on))
                                        <br>
                                        <span>
                                            {{ \Carbon\Carbon::parse($transaction->modified_on)->format('j-F-Y H:i:s')}}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    Progress {{$percentage}}%
                                    <br>
                                    Rp {{$transaction->product->raised}}
                                    <br>
                                    <div class="min">
                                        <div class="progress-bar-outer">
                                            <div class="progress-bar-inner">
                                                <div class="progress-bar">
                                                    <span data-percent="{{$percentage}}"><span class="pretng">{{$percentage}}%</span> </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </a>

                    @endforeach
                </div>
                <div class="text-center">
                    <a href="{{route('portfolio', ['tab' => 'premium'])}}" class="btn btn-min btn-solid"><span>Proyek yang Anda Danai</span></a>
                </div>
                @endif
            </div>
        </div>
    @else

        <!-- apa itu indofund.id -->
        <div class="special-cause fullpage_background">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-xs-12 text-center">
                        <div class=" parallax one" style="text-align:center;">
                            <br>
                            <h3 class="background-h3" style="color: white !important;line-height: 25px;">
                                Mari membangun usaha dan potensi di Indonesia langsung dari tangan kita bersama<br>
                                Ajukan pinjaman dengan bunga bersahabat dan berikan pinjaman dengan return yang menarik <br>
                                bersama Indofund.id - peer to peer lending & business acceleration<br>
                                Terdaftar & diawasi oleh :
                                <br>
                                <br>
                            </h3>
                            <img class="background-img" src="{{ URL::asset('frontend_images/homepage/logo-ojk.png') }}" height="15%">
                            <br><br>
                            <div class="col-md-6 text-right hidden-sm hidden-xs">
                                <a data-toggle="modal" data-target="#loginModalPopup" class="btn btn-big btn-custom" style="margin-right:2%;">
                                    <span style="font-size: 16px;">Berikan Pinjaman</span>
                                </a>
                            </div>
                            <div class="col-md-6 text-left hidden-sm hidden-xs">
                                <a href="https://docs.google.com/forms/d/e/1FAIpQLSfykNgRf0GkrOe_7Eer-VuIuViOaGwFzDdqp4YxVl3yNnxOFg/viewform?c=0&w=1" class="btn btn-big btn-custom">
                                    <span style="font-size: 16px;">Ajukan Pinjaman</span>
                                </a>
                            </div>
                            <div class="col-sm-12 text-center hidden-md hidden-lg" style="margin-bottom:3%;">
                                <a data-toggle="modal" data-target="#loginModalPopup" class="btn btn-big btn-custom" style="margin-right:2%;">
                                    <span style="font-size: 16px;">Berikan Pinjaman</span>
                                </a>
                            </div>
                            <div class="col-sm-12 text-center hidden-md hidden-lg">
                                <a href="https://docs.google.com/forms/d/e/1FAIpQLSfykNgRf0GkrOe_7Eer-VuIuViOaGwFzDdqp4YxVl3yNnxOFg/viewform?c=0&w=1" class="btn btn-big btn-custom">
                                    <span style="font-size: 16px;">Ajukan Pinjaman</span>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- selamat datang -->
        {{--<div class="special-cause fullpage_background1">--}}
            {{--<div class="container">--}}
                {{--<div class="row">--}}
                    {{--<div class="col-md-6 col-xs-12">--}}
                        {{--<div class="section-name-first parallax one" style="line-height: 1.3;padding-top:10%;margin-bottom: 5%;color:white !important; margin-left: 15%;">--}}
                            {{--<h1 style="color: white !important;">{{ $section_1->content_1 }}</h1>--}}
                            {{--<br>--}}
                            {{--<h3 style="color: white !important;line-height: 25px;">--}}
                                {{--{!! $section_1->content_2 !!}--}}
                            {{--</h3>--}}
                            {{--<br><br>--}}
                            {{--<a href="{{ $section_1->link }}" class="btn btn-big btn-solid "><span style="font-size: 16px;">{{ $section_1->content_3 }}</span></a>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

        <!-- apa itu indofund.id -->
        <div class="special-cause fullpage_background2">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-xs-12 hidden-xs hidden-sm">
                        <img src="{{ URL::asset('frontend_images/homepage/bg2-asset.png') }}" style="width: 75%;">
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <div class="section-name-first parallax one" style="line-height: 1.3;padding-top:5%;margin-bottom: 3%;">
                            {{--<h2 style="color: white !important;">Apa itu Investasi.me</h2>--}}
                            <h1>{{ $section_2->content_1 }}</h1>
                            <h2 style="color:black;">{!! $section_2->content_2 !!}</h2>
                            <img src="{{ URL::asset('frontend_images/homepage/border.png') }}" style="padding: 5% 5% 5% 0;">
                            <br>
                            <span style="font-size:14px;text-align:justify;">
                            {!! $section_2->content_3 !!}
                            </span>
                        </div>
                        <div class="btns-wrapper">
                            <a href="{{ $section_2->link }}" class="btn btn-big btn-solid "><span>{{ $section_2->content_4 }}</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- p2p lending -->
        <div class="special-cause fullpage_background3">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-xs-12" style="background: none; border: none;">
                        <div class="section-name-first parallax one" style="color: white !important; padding-bottom:5%;text-align: left;padding-left: 10%;">
                            <h2 style="color: white !important;">{{ $section_3->content_1 }} </h2>
                            <br>
                            <h3 style="color: white !important;line-height: 30px;" class="homepage-section3-h1">{{ $section_3->content_2 }}</h3>
                            <img src="{{ URL::asset('frontend_images/homepage/border.png') }}" style="padding: 5% 5% 5% 0;">
                            <br>
                            <h2 style="color: white !important;">{{ $section_3->content_3 }}</h2>
                            <span>{{ $section_3->content_4 }}</span>
                        </div>
                        <div class="btns-wrapper">
                            <a href="{{ $section_3->link }}" class="btn btn-big btn-solid "><span style="font-size: 20px;">{{ $section_3->content_5 }}</span></a>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12 hidden-xs hidden-sm">
                        <img src="{{ URL::asset('frontend_images/homepage/bg3-asset.png') }}" style="width: 75%;">
                    </div>
                </div>
            </div>
        </div>

        <!-- langkah -->
        <div class="special-cause fullpage_background4">
            <div class="container">
                <div class="row">
                    <div class="section-name parallax one">
                        <div class="short-text">
                            <span style="color: white !important;font-size: 24px;">{{ $section_4_1->content_1 }}</span>
                        </div>
                        <h1 style="color: white !important;">{{ $section_4_1->content_2 }}</h1>
                    </div>

                    <div class="team-members row" style="padding: 5% 10% 0 10%;">
                        <div class="col-md-3 col-sm-12 col-xs-12 hidden-sm">
                            <div class="homepage-section4-img-text" style="display: table; #position: relative; overflow: hidden;">
                                <div style=
                                     "#position: absolute; #top: 50%;display: table-cell; vertical-align: middle;">
                                    <div style=" #position: relative; #top: -50%; color: white !important;">
                                        <h2>{{ $section_4_2->content_1 }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12 hidden-lg hidden-md hidden-xs" style="padding:30px 0 20px 0;">
                            <h2 style="color: white !important;">{{ $section_4_2->content_1 }}</h2>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12 center">
                            <img src="{{ URL::asset('frontend_images/aboutus/kerja-lender-1.png') }}" alt="" class="homepage-section4-img">
                            <br>
                            <span style="color: white !important;">Daftarkan Diri Anda</span>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12 center">
                            <img src="{{ URL::asset('frontend_images/aboutus/kerja-lender-2.png') }}" alt="" class="homepage-section4-img">
                            <br>
                            <span style="color: white !important;">Pilih Pinjaman Sesuai Risiko Anda</span>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12 center">
                            <img src="{{ URL::asset('frontend_images/aboutus/kerja-lender-3.png') }}"alt="" class="homepage-section4-img">
                            <br>
                            <span style="color: white !important;">Dapatkan Return dan Laporan Setiap Bulan</span>
                        </div>
                    </div>
                    <div class="team-members row" style="padding: 0 10% 0 10%;">
                        <div class="col-md-3 col-sm-12 col-xs-12 hidden-sm">
                            <div class="homepage-section4-img-text" style="display: table; #position: relative; overflow: hidden;">
                                <div style=
                                     "#position: absolute; #top: 50%;display: table-cell; vertical-align: middle;">
                                    <div style=" #position: relative; #top: -50%;color: white !important;">
                                        <h2>{{ $section_4_3->content_1 }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12 hidden-lg hidden-md hidden-xs" style="padding:30px 0 20px 0;">
                            <h2 style="color: white !important;">{{ $section_4_3->content_1 }}</h2>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12 center">
                            <img src="{{ URL::asset('frontend_images/aboutus/kerja-borrower-1.png') }}"alt="" class="homepage-section4-img">
                            <br>
                            <span style="color: white !important;">Ajukan Pinjaman Anda</span>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12 center">
                            <img src="{{ URL::asset('frontend_images/aboutus/kerja-borrower-2.png') }}" alt="" class="homepage-section4-img">
                            <br>
                            <span style="color: white !important;">Aplikasi Diproses dengan Cepat oleh Tim</span>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12 center">
                            <img src="{{ URL::asset('frontend_images/aboutus/kerja-borrower-3.png') }}" alt="" class="homepage-section4-img">
                            <br>
                            <span style="color: white !important;">Dapatkan Pendanaan dengan Bunga Kompetitif</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- proyek -->
    <div class="special-cause fullpage_background5">
        <div class="container">
            <div class="row">
                <div class="one">
                    <h2>Proyek Berjalan Saat ini</h2>
                    <br>
                    <h3>Lihat daftar proyek yang dapat Anda danai hari ini</h3>
                </div>
                <div style="margin: 40px; !important">

                    @foreach($recentProductPremiums as $product)
                        @php( $togo = $product->getOriginal('raising') - $product->getOriginal('raised') )
                        @php( $togo = number_format($togo,0, ",", ".") )
                        @php( $percentage = ($product->getOriginal('raised') * 100) / $product->getOriginal('raising') )
                        @php( $percentage = number_format($percentage, 2) )
                        <a href="{{ route('project-detail', ['id' => $product->id]) }}">
                            <div class="col-md-12 project-border" style="background-color: #DCF8C6;">
                                <div class="col-md-2">
                                    <span>Nama Project</span>
                                    <br>
                                    <span style="color: #ff7a00">{{ $product->name }}</span>
                                    <br>
                                    <span>{{ $product->Category->name }}</span>
                                </div>
                                <div class="col-md-2">
                                    Nominal
                                    <br>
                                    <span style="color: #ff7a00">Rp {{ $product->raising }}</span>
                                </div>
                                <div class="col-md-2">
                                    Rating Rate
                                    <br>
                                    <span style="color: #ff7a00">{{$product->business_class}} {{$product->interest_rate}}% / tahun</span>
                                </div>
                                <div class="col-md-2">
                                    Waktu
                                    <br>
                                    <span style="color: #ff7a00">{{$product->tenor_loan}} Bulan </span>
                                </div>
                                <div class="col-md-2">
                                    Progress {{$percentage}}%
                                    <br>
                                    Rp {{$product->raised}}
                                    <br>
                                    <div class="min">
                                        <div class="progress-bar-outer">
                                            <div class="progress-bar-inner">
                                                <div class="progress-bar">
                                                    <span data-percent="{{$percentage}}"><span class="pretng">{{$percentage}}%</span> </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    Masa Penawaran
                                    <br>
                                    <span style="color: #ff7a00">{{ $product->days_left }} hari lagi</span>
                                </div>

                            </div>
                        </a>

                    @endforeach
                    @foreach($recentProducts as $product)

                        @php( $togo = $product->getOriginal('raising') - $product->getOriginal('raised') )
                        @php( $togo = number_format($togo,0, ",", ".") )
                        @php( $percentage = ($product->getOriginal('raised') * 100) / $product->getOriginal('raising') )
                        @php( $percentage = number_format($percentage, 2) )
                        <a href="{{ route('project-detail', ['id' => $product->id]) }}">
                            <div class="col-md-12 project-border">
                                <div class="col-md-2">
                                    <span>Nama Project</span>
                                    <br>
                                    <span style="color: #ff7a00">{{ $product->name }}</span>
                                    <br>
                                    <span>{{ $product->Category->name }}</span>
                                </div>
                                <div class="col-md-2">
                                    Nominal
                                    <br>
                                    <span style="color: #ff7a00">Rp {{ $product->raising }}</span>
                                </div>
                                <div class="col-md-2">
                                    Rating Rate
                                    <br>
                                    <span style="color: #ff7a00">{{$product->business_class}} {{$product->interest_rate}}% / tahun</span>
                                </div>
                                <div class="col-md-2">
                                    Waktu
                                    <br>
                                    <span style="color: #ff7a00">{{$product->tenor_loan}} Bulan </span>
                                </div>
                                <div class="col-md-2">
                                    Progress {{$percentage}}%
                                    <br>
                                    Rp {{$product->raised}}
                                    <br>
                                    <div class="min">
                                        <div class="progress-bar-outer">
                                            <div class="progress-bar-inner">
                                                <div class="progress-bar">
                                                    <span data-percent="{{$percentage}}"><span class="pretng">{{$percentage}}%</span> </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    Masa Penawaran
                                    <br>
                                    <span style="color: #ff7a00">{{ $product->days_left }} hari lagi</span>
                                </div>

                            </div>
                        </a>

                    @endforeach
                </div>

                <div class="col-md-6 text-right hidden-sm hidden-xs">
                    <a href="{{route('project-list', ['tab' => 'premium'])}}" class="btn btn-min btn-solid"><span>Berikan Bantuan</span></a>
                </div>
                <div class="col-md-6 text-left hidden-sm hidden-xs">
                    <a href="https://docs.google.com/forms/d/e/1FAIpQLSfykNgRf0GkrOe_7Eer-VuIuViOaGwFzDdqp4YxVl3yNnxOFg/viewform?c=0&w=1" class="btn btn-min btn-solid" style="background-color: white !important;color: #ff7a00 !important;" target="_blank"><span>Daftarkan Proyek</span></a>
                </div>
                <div class="col-sm-12 text-center hidden-md hidden-lg" style="margin-bottom:3%;">
                    <a href="{{route('project-list', ['tab' => 'premium'])}}" class="btn btn-min btn-solid"><span>Berikan Bantuan</span></a>
                </div>
                <div class="col-sm-12 text-center hidden-md hidden-lg">
                    <a href="https://docs.google.com/forms/d/e/1FAIpQLSfykNgRf0GkrOe_7Eer-VuIuViOaGwFzDdqp4YxVl3yNnxOFg/viewform?c=0&w=1" class="btn btn-min btn-solid" style="background-color: white !important;color: #ff7a00 !important;" target="_blank"><span>Daftarkan Proyek</span></a>
                </div>

                <div>
                </div>
            </div>
        </div>
    </div>


    <!-- Blog -->
    <section  class="blog-area blog-post-wrapper" style="background: #ff7a00 none repeat scroll 0 0; color:white">
        <div class="container">
            <div class="section-name one">
                <h2>Artikel & Berita Proyek Terbaru</h2>
                <div class="short-text">
                    <h5>Update terkini & ikuti berita terbaru Indofund.id</h5>
                </div>
            </div>
            <div class="row">

            @foreach($recentBlogs as $recentBlog)
                <!-- Blog Single -->
                <a href="{{ route('blog', ['id' => $recentBlog->id]) }}">
                    <div class="col-md-3 col-sm-6">
                        <div class="blog-box">
                            <div class="blog-top-desc" style="color:white;">
                                <strong> {{ \Carbon\Carbon::parse($recentBlog->created_at)->format('j M Y ') }} - Kategori : {{$recentBlog->Category->name}}</strong>
                            </div>
                            <div style="height: 30%;">
                                <img src="{{$recentBlog->img_path}}" alt="" style="height: 150px;width: 100%;">
                            </div>
                            <div class="blog-btm-desc">
                                <p>
                                    {{ $highlightBlog[$recentBlog->id] }}
                                    <br><span class="read-more">Baca Selanjutnya</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
                <!-- Blog Single -->
            @endforeach

            </div>
        </div>
    </section>

    <!-- Subscribe -->
    <div class="subscribe-form-div">
        <div class="section-name one  subscribe-section">
            <div class="subcribe widget clearfix">
                <h2>Dapatkan Berita & Informasi Terbaru ke Email Anda</h2>
                {!! Form::open(['url'=>'subscribeEmail','id'=>'subscribe-form'])!!}
                <div class="col-md-3 col-sm-12 field">
                    <input style="margin-bottom: 5%;color:black;" type="text" name="name" id="name" class="subscribe-field" placeholder="Ketikkan nama Anda disini">
                </div>
                <div class="col-md-3 col-sm-12 field">
                    <input style="margin-bottom: 5%;color:black;" type="email" name="email" id="email" class="subscribe-field" placeholder="Ketikkan alamat E-mail Anda disini">
                </div>
                <div class="col-md-3 col-sm-12 field">
                    <input style="margin-bottom: 5%;color:black;" type="text" name="phone" id="phone" class="subscribe-field" placeholder="Ketikkan nomor handphone Anda disini">
                </div>
                <div class="col-md-3 col-sm-12 field">
                    {!! Form::submit('Kirim',['class'=>'btn btn-min btn-solid subscribe-submit', 'id'=>'subscribe-button'])!!}
                    <i id="subscribe-spinner" class="fa fa-circle-o-notch fa-spin" style="font-size:24px;display: none;"></i>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        &nbsp;
    </div>
@endsection


{{--@include('frontend.partials._modal-ads', compact('section_Popup'))--}}
