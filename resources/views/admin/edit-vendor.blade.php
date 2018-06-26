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
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div id="title-header" class="x_title">
                            <h2>Edit Borrower</h2>
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">
                            <form class="comment-form row altered" id="owner-form" method="POST" enctype="multipart/form-data" action="/admin/vendor/edit/update/{{ $vendorDB->id }}">
                                {{ csrf_field() }}

                                <div class="field col-sm-12">
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

                                    <div class="panel-heading">

                                        <ul class="nav nav-pills nav-justified thumbnail custom-color" style="height:auto!important;">
                                            <li class="active"><a href="#owner" data-toggle="tab">
                                                    <h4 class="list-group-item-heading"><b>Perusahaan/Usaha</b></h4>
                                                </a></li>
                                            <li><a href="#user" data-toggle="tab">
                                                    <h4 class="list-group-item-heading"><b>Data Diri</b></h4>
                                                </a></li>
                                            <li><a href="#sosmed" data-toggle="tab">
                                                    <h4 class="list-group-item-heading"><b>Akun Media Sosial</b></h4>
                                                </a></li>
                                            <li><a href="#bank" data-toggle="tab">
                                                    <h4 class="list-group-item-heading"><b>Akun Bank</b></h4>
                                                </a></li>
                                        </ul>
                                        {{--<ul class="nav nav-tabs">--}}
                                        {{--<li class="active"><a href="#project" data-toggle="tab">Data Proyek</a></li>--}}
                                        {{--<li><a href="#user" data-toggle="tab">Data Diri</a></li>--}}
                                        {{--<li><a href="#owner" data-toggle="tab">Perusahaan/Usaha</a></li>--}}
                                        {{--<li><a href="#bank" data-toggle="tab">Akun Bank</a></li>--}}
                                        {{--</ul>--}}
                                    </div>
                                    <div class="panel-body">
                                        <div class="tab-content">

                                            <input type="hidden" name="vendor_id" value="{{ $vendorDB->id }}" class="form-control col-md-7 col-xs-12">
                                            {{--tab 2--}}
                                            <div class="tab-pane active" id="owner">

                                                <div class="field col-md-6 col-sm-12">
                                                    <h4>Gambar Profil</h4>
                                                    <img src="{{ URL::asset('storage/owner_picture/'.$vendorDB->profile_picture) }}" height="200">
                                                </div>
                                                <div class="field col-md-6 col-sm-12">
                                                    {!! Form::file('vendor_image', array('id' => 'photo_profile', 'class' => 'file')) !!}
                                                </div>
                                                <div class="field col-sm-12">
                                                    <h4>Nama Perusahaan * </h4>
                                                    <input type="text" name="name_vendor" value="{{$vendorDB->name }}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="field col-md-6 col-sm-12">
                                                    <h4>Tipe Perusahaan * </h4>
                                                    <select id="vendor_type" name="vendor_type" class="form-control">
                                                        <option {{ $vendorDB->vendor_type  == "-1" ? "selected":"" }} value="-1">Pilih</option>
                                                        <option {{ $vendorDB->vendor_type  == "pt" ? "selected":"" }} value="pt">Perseroan Terbatas (PT)</option>
                                                        <option {{ $vendorDB->vendor_type  == "cv" ? "selected":"" }} value="cv">CV</option>
                                                        <option {{ $vendorDB->vendor_type  == "individual" ? "selected":"" }} value="individual">Perseorangan</option>
                                                    </select>
                                                </div>
                                                <div class="field col-md-6 col-sm-12">
                                                    <h4>Merk / Nama Dagang * </h4>
                                                    <input type="text" name="brand" value="{{$vendorDB->brand }}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="field col-md-6 col-sm-12">
                                                    <h4>Tipe Usaha * </h4>
                                                    <select id="business_type" name="business_type" class="form-control">
                                                        <option {{ $vendorDB->business_type  == "-1" ? "selected":"" }} value="-1">Pilih</option>
                                                        <option {{ $vendorDB->business_type  == "manufaktur" ? "selected":"" }} value="manufaktur">Manufaktur</option>
                                                        <option {{ $vendorDB->business_type  == "jasa" ? "selected":"" }} value="jasa">Jasa</option>
                                                        <option {{ $vendorDB->business_type  == "perdagangan" ? "selected":"" }} value="perdagangan">Perdagangan</option>
                                                    </select>
                                                </div>
                                                <div class="field col-md-6 col-sm-12">
                                                    <h4>Lama Usaha (Tahun) * </h4>
                                                    <input type="text" name="establish_since" value="{{$vendorDB->establish_since }}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="field col-md-6 col-sm-12">
                                                    <h4>Lama Usaha (Bulan)</h4>
                                                    <input type="text" name="establish_since_month" value="{{$vendorDB->establish_since_month }}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="field col-md-6 col-sm-12">
                                                    <h4>Rata-rata penjualan per bulan *</h4>
                                                    <input type="number" name="monthly_income" value="{{$vendorDB->monthly_income }}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="field col-md-6 col-sm-12">
                                                    <h4>Rata-rata keuntungan  per bulan *</h4>
                                                    <input type="number" name="monthly_profit" value="{{$vendorDB->monthly_profit }}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="field col-md-6 col-sm-12">
                                                    <h4>Besar Kepemilikan Saham Anda (%) * </h4>
                                                    <input type="text" name="ownership" value="{{$vendorDB->ownership }}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="field col-sm-12 ">
                                                    <h4>Biografi * </h4>
                                                    <input type="hidden" id="description_vendor" name="description_vendor" value="{{$vendorDB->description }}">
                                                    <textarea class="summernote" id="description_vendor_text" title="description_vendor">{{$vendorDB->description }}</textarea>
                                                </div>
                                                <div class="field col-sm-12">
                                                    <h4>Alamat Kantor * </h4>
                                                    <input type="text" name="address"value="{{$vendorDB->address }}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="field col-md-6 col-sm-12">
                                                    <h4>Kota * </h4>
                                                    <input type="text" name="city"value="{{$vendorDB->city }}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="field col-md-6 col-sm-12">
                                                    <h4>Provinsi * </h4>
                                                    <input type="text" name="province"value="{{$vendorDB->province }}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="field col-md-6 col-sm-12">
                                                    <h4>Kode Pos * </h4>
                                                    <input type="text" name="postal_code"value="{{$vendorDB->postal_code }}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="field col-md-6 col-sm-12">
                                                    <h4>Nomor Telepon Kantor * </h4>
                                                    <input type="text" name="phone_office"value="{{$vendorDB->phone_office }}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="field col-md-6 col-sm-12">
                                                    <h4>Alamat Website</h4>
                                                    <input type="text" name="website" value="{{$vendorDB->website }}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                            </div>

                                            {{--tab 3--}}
                                            <div class="tab-pane" id="user">
                                                <div class="field col-md-6 col-sm-12">
                                                    <h4>E-mail</h4>
                                                    <input type="email" name="email" value="{{ $userDB->email }}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="field col-md-6 col-sm-12">
                                                    <h4>Nomor Handphone</h4>
                                                    <input type="number" name="phone" value="{{ $userDB->phone }}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                {{--<div class="field col-md-6 col-sm-12">--}}
                                                    {{--<h4>Password</h4>--}}
                                                    {{--<input type="password" name="password" value="{{$userDB->password }}" class="form-control col-md-7 col-xs-12">--}}
                                                {{--</div>--}}
                                                {{--<div class="field col-md-6 col-sm-12">--}}
                                                    {{--<h4>Konfirmasi Password</h4>--}}
                                                    {{--<input type="password" name="password_confirmation" value="{{$userDB->phone old('password_confirmation')}}" class="form-control col-md-7 col-xs-12">--}}
                                                {{--</div>--}}
                                                <div class="field col-sm-12">
                                                    <h4>Nama sesuai KTP</h4>
                                                    <input type="text" name="name" value="{{$userDB->first_name}}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="field col-sm-12">
                                                    <h4>Alamat Rumah sesuai KTP</h4>
                                                    <input type="text" name="address_ktp" value="{{$userDB->address_ktp }}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="field col-md-6 col-sm-12">
                                                    <h4>Tanggal Lahir sesuai KTP</h4>
                                                    <input type="text" name="dob" value="{{$userDB->dob }}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="field col-md-6 col-sm-12">
                                                    <h4>Status Pernikahan</h4>
                                                    <input type="text" name="marital_status" value="{{$userDB->marital_status }}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="field col-md-6 col-sm-12">
                                                    <h4>Pendidikan Terakhir</h4>
                                                    <input type="text" name="education" value="{{$userDB->education }}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div style="margin-top: 0;" class="field col-sm-12">
                                                    <h4>Username</h4>
                                                    <input type="text" name="username" value="{{$userDB->username }}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                            </div>

                                            {{--tab 4--}}
                                            <div class="tab-pane" id="sosmed">
                                                <div class="field col-md-6 col-sm-12">
                                                    <h4>Alamat akun facebook *</h4>
                                                    <input type="text" name="fb_acc" value="{{$userDB->fb_acc }}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="field col-md-6 col-sm-12">
                                                    <h4>Alamat akun facebook usaha</h4>
                                                    <input type="text" name="vendor_fb" value="{{$vendorDB->fb_acc }}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="field col-md-6 col-sm-12">
                                                    <h4>Alamat akun Instagram *</h4>
                                                    <input type="text" name="ig_acc" value="{{$userDB->ig_acc }}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="field col-md-6 col-sm-12">
                                                    <h4>Alamat akun Instagram usaha</h4>
                                                    <input type="text" name="vendor_ig" value="{{$vendorDB->ig_acc }}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div style="margin-top: 0;" class="field col-md-6 col-sm-12">
                                                    <h4>Alamat akun Twitter *</h4>
                                                    <input type="text" name="twitter_acc" value="{{$userDB->twitter_acc }}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="field col-md-6 col-sm-12">
                                                    <h4>Alamat akun Twitter usaha</h4>
                                                    <input type="text" name="vendor_tw" value="{{$vendorDB->twitter_acc }}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="field col-sm-12">
                                                    <h4>Alamat akun Youtube usaha</h4>
                                                    <input type="text" name="vendor_yt" value="{{$vendorDB->youtube_acc }}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                            </div>

                                            {{--tab 5--}}
                                            <div class="tab-pane" id="bank">
                                                <div class="field col-sm-12">
                                                    <h4>Nama Pemilik Rekening</h4>
                                                    <input type="text" name="acc_bank" value="{{$vendorDB->bank_acc_name }}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="field col-sm-12">
                                                    <h4>Nama Bank</h4>
                                                    <input type="text" name="bank" value="{{$vendorDB->bank_name }}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="field col-sm-12">
                                                    <h4>Nomor Rekening</h4>
                                                    <input type="text" name="no_rek" value="{{$vendorDB->bank_acc_number }}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="field col-sm-12">
                                                    <br>
                                                    <button class="btn btn-success" onclick="formsubmit()"><i class="fa fa-paper-plane"></i><span>Submit</span></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <a href="#title-header" class="btn btn-primary">
                                        Top
                                    </a>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- page content -->

    <!-- footer content -->
    @include('admin.partials._footer')
    <!-- footer content -->

    <script type="text/javascript">
        function formsubmit(){

            var content = $('#description_text').val();
            var replaceContent = content.replace("\n", "<br/>");
            $('#description').val(replaceContent);

            var contentVendor = $('#description_vendor_text').val();
            var replaceContentVendor = contentVendor.replace("\n", "<br/>");
            $('#description_vendor').val(replaceContentVendor);
        }

    </script>
@endsection