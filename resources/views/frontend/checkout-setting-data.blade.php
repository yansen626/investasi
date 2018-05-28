@extends('layouts.frontend')

@section('body-content')
    <!-- Banner -->
    <div class="page-banner">
        <div class="container">
            <div class="parallax-mask"></div>
            <div class="section-name">
                <h2>LENGKAPI DATA</h2>
                <div class="short-text">
                    <h5><a href="{{route('index')}}">Beranda</a>
                        <i class="fa fa-angle-double-right"></i><a href="{{ route('project-list', ['tab' => 'debt']) }}">Daftar Investasi</a>
                        <i class="fa fa-angle-double-right"></i>Lengkapi Data
                    </h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Causes Wrapper -->
    <div class="causes-page-wrapper single-cause">
        <div class="container" style="margin-bottom: 20px;">
            <div class="row cause">
                <div class="col-md-10 col-md-offset-1">
                    <div class="comment-form-wrapper contact-from clearfix col-md-12 col-sm-12">
                        <h2>*Mohon melengkapi data berikut ini sesuai dengan KTP Anda untuk melanjutkan pendaaan pertama kali.</h2>
                        {{ Form::open(['route'=>['store-data'],'method' => 'post','class'=>'comment-form row altered', 'style'=>'margin-bottom: 10px;', 'enctype'=>'multipart/form-data']) }}
                            <div class="field col-sm-12">
                                <h5>Nomor KTP</h5>
                                <input type="hidden" id="product_id" name="product_id" value="{{ $product->id }}"/>
                                <input type="text" id="KTP" name="ktp"  value="{{ $user->identity_number }}" required/>
                                @if ($errors->has('ktp'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ktp') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="field col-sm-12">
                                <h5>Nama Sesuai KTP</h5>
                                <h5 style="color:red;">Ketikkan nama Anda sebagai pengganti tanda tangan</h5>
                                <input type="text" id="KTP" name="name_ktp"  value="{{ $user->name_ktp }}" required/>
                                @if ($errors->has('ktp'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('ktp') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="field col-sm-12" style="margin-top: -3px;">
                                <h5>Kewarganegaraan</h5>
                                <select class="form-control" id="citizen" name="citizen">
                                    @if($user->citizen == "Asing")
                                        <option value="Indonesia">Warga Negara Indonesia</option>
                                        <option value="Asing" selected>Warga Negara Asing</option>
                                    @else
                                        <option value="Indonesia" selected>Warga Negara Indonesia</option>
                                        <option value="Asing">Warga Negara Asing</option>
                                    @endif
                                </select>
                            </div>
                            <div class="field col-sm-12" style="margin-top: -3px;">
                                <h5>Alamat</h5>
                                <input id="address-ktp" name="address_ktp" value="{{ $user->address_ktp }}" type="text" required/>
                                @if ($errors->has('address_ktp'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address_ktp') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="field col-sm-12" style="margin-top: -3px;">
                                <h5>Kota</h5>
                                <input id="city-ktp" name="city_ktp" value="{{ $user->city_ktp }}" type="text" required/>
                                @if ($errors->has('city_ktp'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('city_ktp') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="field col-sm-12">
                                <h5>Provinsi</h5>
                                <input id="province-ktp" name="province_ktp" value="{{ $user->province_ktp }}" type="text" required/>
                                @if ($errors->has('province_ktp'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('province_ktp') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="field col-sm-12">
                                <h5>Kode Pos</h5>
                                <input id="postal-code-ktp" name="postal_code_ktp" value="{{ $user->postal_code_ktp }}" type="text" required/>
                                @if ($errors->has('postal_code_ktp'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('postal_code_ktp') }}</strong>
                                    </span>
                                @endif
                            </div>

                            {{--<div class="field col-sm-12" style="margin-top: -3px;">--}}
                                {{--<h5>Foto KTP</h5>--}}
                                {{--<h5 style="color:red;">Size maksimal foto adalah 16MB</h5>--}}
                                {{--<div class="input-group">--}}
                                    {{--<span class="input-group-btn">--}}
                                        {{--<span class="btn btn-primary btn-file">--}}
                                            {{--Browse {!! Form::file('photo_ktp', array('id' => 'photo-ktp', 'accept' => 'image/*,application/pdf')) !!}--}}
                                            {{--Browse <input type="file" id="photo-ktp" name="photo_ktp" accept="image/*,application/pdf">--}}
                                        {{--</span>--}}
                                    {{--</span>--}}
                                    {{--<input type="text" class="form-control" readonly>--}}
                                {{--</div>--}}
                                {{--<img id='img-upload' style="width:200px; height:100%"/>--}}
                            {{--</div>--}}

                            <div class="field col-sm-12 text-right" >
                                <button id="submit" type="submit" class="btn btn-solid">Submit</button>
                            </div>
                        {{ Form::close() }}
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