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
            <div class="page-title">
                <div class="title_left">
                    <h3>KTP User</h3>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Nama User = {{$user->first_name}} {{$user->last_name}}</h2>
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">

                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <div style="height:350px;">
                                    <img src="{{asset('storage\ktp\\'.$user->img_ktp)}}" height="350px" />
                                </div>

                                <div>
                                    <ul class="messages">
                                        <li>
                                            <div class="message_wrapper">
                                                <h2 class="heading">Nomor KTP</h2>
                                                <blockquote class="message">
                                                    <div class="col-md-12">
                                                        {{$user->identity_number}}
                                                    </div>
                                                </blockquote>
                                                <br />
                                            </div>
                                        </li>
                                        <li>
                                            <div class="message_wrapper">
                                                <h2 class="heading">Nama</h2>
                                                <blockquote class="message">
                                                    <div class="col-md-12">
                                                        {{$user->name_ktp}}
                                                    </div>
                                                </blockquote>
                                                <br />
                                            </div>
                                        </li>
                                        <li>
                                            <div class="message_wrapper">
                                                <h2 class="heading">Kewarganegaraan</h2>
                                                <blockquote class="message">
                                                    <div class="col-md-12">
                                                        Warga Negara {{$user->citizen}}
                                                    </div>
                                                </blockquote>
                                                <br />
                                            </div>
                                        </li>
                                        <li>
                                            <div class="message_wrapper">
                                                <h2 class="heading">Alamat, Kota, Provinsi</h2>
                                                <blockquote class="message">
                                                    <div class="col-md-12">
                                                        {{$user->address_ktp}}, {{$user->city_ktp}}, {{$user->province_ktp}}
                                                    </div>
                                                </blockquote>
                                                <br />
                                            </div>
                                        </li>
                                        <li>
                                            <div class="message_wrapper">
                                                <h2 class="heading">Kode Pos</h2>
                                                <blockquote class="message">
                                                    <div class="col-md-12">
                                                        {{$user->postal_code_ktp}}
                                                    </div>
                                                </blockquote>
                                                <br />
                                            </div>
                                        </li>
                                    </ul>
                                    <br/>
                                    <div class="text-center mtop20">
                                        <a onclick="modalPop('{{ $user->vendor_id }}', 'accept', '/admin/vendor/request-accept/')" class="btn btn-big btn-success">Accept</a>
                                        <a onclick="modalPop('{{ $user->vendor_id }}', 'cancel', '/admin/vendor/request-reject/')" class="btn btn-big btn-danger">Reject</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- small modal -->
    @include('admin.partials._small_modal')
    <!-- /small modal -->

    <!-- footer -->
    @include('admin.partials._footer')
    <!-- /footer -->

@endsection