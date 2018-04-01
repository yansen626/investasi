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
                            <h2>Buat Proyek | Vendor = {{$vendorDB->name}}</h2>
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">
                            <form class="comment-form row altered" id="owner-form" method="POST" enctype="multipart/form-data" action="{{route('product-request-submit')}}">
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
                                            <li class="active"><a href="#project" data-toggle="tab">
                                                    <h4 class="list-group-item-heading"><b>Data Proyek</b></h4>
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
                                            {{--tab 1--}}
                                            <div class="tab-pane active" id="project">

                                                <input type="hidden" name="vendor_id" value="{{ $vendorDB->id }}" class="form-control col-md-7 col-xs-12">
                                                <div class="field col-sm-12">
                                                    <h4>Gambar Proyek / Produk</h4>
                                                    {!! Form::file('project_image', array('id' => 'photo', 'class' => 'file')) !!}
                                                </div>

                                                <div class="field col-sm-12">
                                                    <h4>Upload product disclosure statement</h4>
                                                    {!! Form::file('prospectus', array('id' => 'prospectus', 'class' => 'file', 'accept' => 'application/pdf')) !!}
                                                </div>
                                                <div class="field col-sm-12">
                                                    <h4>Link Video Youtube</h4>
                                                    <input type="text" name="youtube" value="{{old('youtube')}}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="field col-sm-12">
                                                    <h4>Nama Proyek / Produk</h4>
                                                    <input type="text" name="project_name" value="{{old('project_name')}}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div style="margin-top: 0;" class="field col-sm-12">
                                                    <h4>Tagline Proyek / Produk</h4>
                                                    <input type="text" name="project_tagline" value="{{old('project_tagline')}}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="field col-sm-12">
                                                    <h4>Deskripsi Proyek / Produk</h4>
                                                    <input type="hidden" id="description" name="description" value="{{old('description')}}">
                                                    <textarea class="summernote" id="description_text" title="description">{{old('description')}}</textarea>
                                                </div>
                                                <div style="margin-top: 0;" class="field col-sm-12 ">
                                                    <h4>Kategori</h4>
                                                    <select id="category" name="category" class="form-control">
                                                        <option value="-1">Pilih Kategori</option>

                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}" {{ old('category') == $category->id ? "selected":"" }} >{{ $category->name }}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                                <div class="field col-sm-12">
                                                    <h4>Total Pendanaan</h4>
                                                    <input type="number" name="raising" value="{{old('raising')}}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="field col-sm-12">
                                                    <h4>Durasi Pinjaman (bulan)</h4>
                                                    <input type="number" name="tenor_loan" value="{{old('tenor_loan')}}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="field col-sm-12">
                                                    <h4>Durasi Pengumpulan Dana (hari)</h4>
                                                    <input type="number" name="days_left" value="{{old('days_left')}}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="field col-sm-12">
                                                    <h4>Suku Bunga</h4>
                                                    <input type="number" name="interest_rate" value="{{old('interest_rate')}}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="field col-sm-12">
                                                    <h4>Kelas</h4>
                                                    <select id="business_class" name="business_class" class="form-control">
                                                        <option {{ old('business_class') == "-1" ? "selected":"" }} value="-1">Pilih</option>
                                                        <option {{ old('business_class') == "A" ? "selected":"" }} value="A">A</option>
                                                        <option {{ old('business_class') == "B" ? "selected":"" }} value="B">B</option>
                                                        <option {{ old('business_class') == "C" ? "selected":"" }} value="C">C</option>
                                                        <option {{ old('business_class') == "D" ? "selected":"" }} value="D">D</option>
                                                    </select>
                                                </div>
                                                <div class="field col-sm-12">
                                                    <h4>Cicilan/bulan</h4>
                                                    <input type="number" name="installment_per_month" value="{{old('installment_per_month')}}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="field col-sm-12">
                                                    <h4>Bunga/bulan</h4>
                                                    <input type="number" name="interest_per_month" value="{{old('interest_per_month')}}" class="form-control col-md-7 col-xs-12">
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
//            alert(replaceContent);

//            $('#owner-form').submit();
        }

    </script>
@endsection