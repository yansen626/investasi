@extends('layouts.frontend')

@section('body-content')
    <!-- contact wrapper -->
    <div class="contact-page-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="comment-form-wrapper contact-from clearfix">
                        <div class="widget-title ">
                            <h4>Login</h4>
                            @include('admin.partials._success')
                        </div>
                        <form class="comment-form row altered" method="POST" action="{{ route('login') }}">
                            @if($errors->has('msg'))
                                <div class="field col-sm-12 text-center">
                                    <span class="help-block" style="color: red;">{{$errors->first()}}</span>
                                </div>
                            @endif
                            {{ csrf_field() }}
                            <div class="field col-sm-12 {{ $errors->has('email') ? ' has-error' : '' }}">
                                <h4>E-mail</h4>
                                <input type="email" name="email">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="field col-sm-12" {{ $errors->has('password') ? ' has-error' : '' }}>
                                <h4>Password</h4>
                                <input type="password" name="password">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-sm-12">
                                <label>
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                </label>
                            </div>
                                <div class="col-sm-12">
                                    <a id="forgot-pass" href="{{ route('password.request') }}"  class="btn btn-big btn-success"><span>Lupa Password?</span></a>
                                    {{--<a class="btn btn-link" href="{{ route('password.request') }}" style="color: #ff7a00;">--}}
                                    {{--Forgot Your Password?--}}
                                    {{--</a>--}}
                                    {{--<br>--}}
                                    <button class="btn btn-big btn-solid"><i class="fa fa-paper-plane"></i><span>Login</span></button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
