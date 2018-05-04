@extends('layouts.frontend')

@section('body-content')
    <!-- contact wrapper -->
    <div class="contact-page-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="comment-form-wrapper contact-from clearfix">
                        <div class="widget-title ">
                            <h4>Registrasi</h4>
                        </div>
                        <form class="comment-form row altered" method="POST" action="{{ route('register') }}">
                            @if($errors->has('msg'))
                                <div class="field col-sm-12 text-center">
                                    <span class="help-block" style="color: red;">{{$errors->first()}}</span>
                                </div>
                            @endif
                            {{ csrf_field() }}

                            <div class="field col-sm-12 {{ $errors->has('email') ? ' has-error' : '' }}">
                                <h4>E-mail</h4>
                                <input type="email" name="email" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="field col-sm-12 {{ $errors->has('first_name') ? ' has-error' : '' }}">
                                <h4>Nama Depan</h4>
                                <input type="text" name="first_name" value="{{ old('first_name') }}">
                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div style="margin-top: 0;" class="field col-sm-12 {{ $errors->has('last_name') ? ' has-error' : '' }}">
                                <h4>Nama Belakang</h4>
                                <input type="text" name="last_name" value="{{ old('last_name') }}">
                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div style="margin-top: 0;" class="field col-sm-12 {{ $errors->has('username') ? ' has-error' : '' }}">
                                <h4>Username</h4>
                                <h3>case sensitif</h3>
                                <input type="text" name="username" value="{{ old('username') }}">
                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="field col-sm-12 {{ $errors->has('phone') ? ' has-error' : '' }}">
                                <h4>Nomor Handphone</h4>
                                <input type="number" name="phone" value="{{ old('phone') }}">
                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="field col-sm-12" {{ $errors->has('password') ? ' has-error' : '' }}>
                                <h4>Password</h4>
                                <h3>Case sensitif</h3>
                                <input type="password" name="password">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="field col-sm-12" {{ $errors->has('password_confirmation') ? ' has-error' : '' }}>
                                <h4>Konfirmasi Password</h4>
                                <h3>Harus sama dengan Password</h3>
                                <input type="password" name="password_confirmation">
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="field col-sm-12 {{ $errors->has('referral') ? ' has-error' : '' }}">
                                <h4>Referral</h4>
                                <h3>Case sensitif, dan jika anda tidak memiliki referal harap di kosongkan</h3>
                                <input type="text" name="referral">
                                @if ($errors->has('referral'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('referral') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-sm-12">
                                <label>
                                    <input type="checkbox" name="check1" id="check1" onclick="check()">
                                    Dengan mendaftarkan diri pada indofund.id saya telah membaca dan mengetahui
                                    syarat dan ketentuan yang berlaku pada halaman
                                    <a href="{{route("term-condition")}}" target="_blank"> Syarat & Ketentuan </a> serta
                                    <a href="{{route("privacy-policy")}}" target="_blank"> Kebijakan Privasi</a>
                                </label>
                            </div>
                            <div class="field col-sm-12">
                                <br/>
                                <button class="btn btn-big btn-solid" id="submit" disabled><i class="fa fa-paper-plane"></i><span>Register</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function check(){

            if(document.getElementById("check1").checked){
                document.getElementById("submit").disabled = false;
            }
            else if(document.getElementById("check1").checked == false){
                document.getElementById("submit").disabled = true;
            }
        }
    </script>
@endsection
