@extends('layouts.frontend')

@section('body-content')
    <!-- Banner -->
    <div class="page-banner">
        <div class="container">
            <div class="parallax-mask"></div>
            <div class="section-name">
                <h2>Penarikan Saldo</h2>
                <div class="short-text">
                    <h5><a href="{{route('index')}}">Beranda</a>
                        <i class="fa fa-angle-double-right"></i><a href="{{route('my-wallet')}}">Total Saldo Saya</a>
                        <i class="fa fa-angle-double-right"></i>Penarikan Saldo
                    </h5>
                </div>
            </div>
        </div>
    </div>

    <!-- contact wrapper -->
    <div class="contact-page-wrapper">
        <div class="container">
            <div class="row">

                <div class="col-md-12 col-xs-12 text-center">
                    <h2>
                        Total Saldo Anda<br> Rp {{$user->wallet_amount}}
                    </h2>
                </div>
                @if($user->google_authenticator == 0)
                    <div class="col-md-6 col-md-offset-3">
                        <div class="comment-form-wrapper contact-from clearfix">
                            <div class="widget-title ">
                                <h4>Mohon Aktifkan Google Authenticator Anda.</h4>
                                <h3>
                                    Klik <a href="{{route('my-profile', ['tab' => 'security'])}}">disini</a> untuk mengaktifkan.
                                    <br>
                                    Informasi lebih lanjut hubungi kami melalui email atau chat box di bawah
                                </h3>
                            </div>
                        </div>
                    </div>
                @elseif(empty($user->img_ktp))
                    <div class="col-md-6 col-md-offset-3">
                        <div class="comment-form-wrapper contact-from clearfix">
                            <div class="widget-title ">
                                <h4>Mohon Mengunggah foto KTP / menunggu verifikasi foto KTP Anda.</h4>
                                <h3>
                                    Klik <a href="{{route('my-profile', ['tab' => 'profile'])}}">disini</a> untuk mengunggah/mengecek.
                                    <br>
                                    Informasi lebih lanjut hubungi kami melalui email atau chat box di bawah
                                </h3>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-md-6 col-md-offset-3">
                        <div class="comment-form-wrapper contact-from clearfix">
                            <div class="widget-title ">
                                <h4>Penarikan Saldo</h4>
                                <span style="color:red;font-size:14px;">Nomor rekening untuk penarikan harus sama dengan nama yang terdaftar pada profil akun</span>
                            </div>
                            <form id="withdraw-form" class="comment-form row altered" method="POST" action="{{ route('withdrawSubmit') }}">
                                {{ csrf_field() }}

                                @if(count($errors))
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12 alert alert-danger alert-dismissible fade in" role="alert">
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
                                @if(empty($user->bank_name) || empty($user->bank_acc_number) || empty($user->bank_acc_name))
                                    <div class="field col-sm-12 {{ $errors->has('acc_number') ? ' has-error' : '' }}">
                                        <h4>Nomor Rekening</h4>
                                        <input type="text" name="acc_number" value="{{old('acc_number')}}">
                                    </div>
                                    <div style="margin-top: 0;" class="field col-sm-12 {{ $errors->has('acc_name') ? ' has-error' : '' }}">
                                        <h4>Nama Rekening</h4>
                                        <input type="text" name="acc_name" value="{{old('acc_name')}}">
                                    </div>
                                    <div class="field col-sm-12 {{ $errors->has('bank') ? ' has-error' : '' }}">
                                        <h4>Nama Bank</h4>
                                        <input type="text" name="bank" value="{{old('bank')}}">
                                    </div>
                                @else
                                    <div class="field col-sm-12">
                                        <h4>Nomor Rekening : <b>{{$user->bank_acc_number}}</b></h4>
                                    </div>
                                    <div class="field col-sm-12">
                                        <h4>Nama Rekening : <b> {{$user->bank_acc_name}}</b></h4>
                                    </div>
                                    <div style="margin-top: 0;"  class="field col-sm-12">
                                        <h4>Nama Bank : <b> {{$user->bank_name}}</b></h4>
                                    </div>
                                    <input type="hidden" name="bank" value="{{$user->bank_name}}">
                                    <input type="hidden" name="acc_number" value="{{$user->bank_acc_number}}">
                                    <input type="hidden" name="acc_name" value="{{$user->bank_acc_name}}">
                                @endif
                                <div class="field col-sm-12 price-format {{ $errors->has('amount') ? ' has-error' : '' }}">
                                    <h4>Jumlah Penarikan</h4>
                                    <input type="text" id="amount" name="amount"  value="{{old('amount')}}">
                                </div>
                                <div style="margin-top: 0;" class="field col-sm-12 {{ $errors->has('google') ? ' has-error' : '' }}">
                                    <h4>PIN Google Auth</h4>
                                    <input type="number" name="google" value="{{old('google')}}">
                                </div>
                                <input type="hidden" id="fee" value="{{env('FEE_TRANSFER')}}">
                            </form>
                            <div class="field col-sm-12">
                                <br/>
                                <button class="btn btn-big btn-solid" onclick="modalWalletWithdraw()"><i class="fa fa-paper-plane"></i><span>Tarik Saldo</span></button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @include('frontend.partials._modal-wallet-withdraw')
@endsection


@section('styles')
    @parent
    <style>
        .red-text{
            color: red;
            font-size: 14px;
        }
    </style>
@endsection

@section('scripts')
    @parent
    <script src="{{ URL::asset('js/frontend/bootstrap-datetimepicker.min.js') }}"></script>
    <script>
        function modalWalletDeposit(){
            $("#modal_wallet_deposit").modal();
        }

        function modalWalletWithdraw(){
            var amount = $("#amount").val();
            var fee = $("#fee").val();

            $("#withdraw-amount").html(amount);
            $("#withdraw-fee").html(fee);

            $("#withdrawModal").modal();
        }

        function modalWalletWithdrawSubmit(){
            $("#withdraw-form").submit();
        }

    </script>
@endsection
