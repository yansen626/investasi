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
                            <h2>Edit Proyek | Borrower = {{$vendorDB->name}}</h2>
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">
                            <form class="comment-form row altered" id="owner-form" method="POST" enctype="multipart/form-data" action="{{route('product-edit-submit')}}">
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
                                                <input type="hidden" name="product_id" value="{{ $productDB->id }}" class="form-control col-md-7 col-xs-12">

                                                <div class="field col-md-6 col-sm-12">
                                                    <h4>Gambar Proyek / Produk</h4>
                                                    <img src="{{ URL::asset('storage/project/'.$productDB->image_path) }}" height="200">
                                                </div>
                                                <div class="field col-md-6 col-sm-12">
                                                    {!! Form::file('project_image', array('id' => 'photo', 'class' => 'file')) !!}
                                                </div>

                                                <div class="field col-md-12 col-sm-12">
                                                    <h4>Link product disclosure statement</h4>
                                                    <input type="text" name="prospectus" value="{{ $productDB->prospectus_path }}" class="form-control col-md-7 col-xs-12">
                                                    {{--{!! Form::file('prospectus', array('id' => 'prospectus', 'class' => 'file', 'accept' => 'application/pdf')) !!}--}}
                                                </div>
                                                <div class="field col-sm-12">
                                                    <h4>Nama Proyek / Produk</h4>
                                                    <input type="text" name="project_name" value="{{ $productDB->name }}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div style="margin-top: 0;" class="field col-sm-12">
                                                    <h4>Tagline Proyek / Produk</h4>
                                                    <input type="text" name="project_tagline" value="{{ $productDB->tagline }}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="field col-sm-12">
                                                    <h4>Deskripsi Proyek / Produk</h4>
                                                    <input type="hidden" id="description" name="description" value="{{$productDB->description}}">
                                                    <textarea class="summernote" id="description_text" title="description">{{$productDB->description}}</textarea>
                                                </div>
                                                <div class="field col-md-6 col-sm-12">
                                                    <h4>Link Video Youtube</h4>
                                                    <input type="text" name="youtube" value="{{$productDB->youtube_link}}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div style="margin-top: 0;" class="field col-md-6 col-sm-12 ">
                                                    <h4>Kategori</h4>
                                                    <select id="category" name="category" class="form-control">
                                                        <option value="-1">Pilih Kategori</option>

                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}" {{ $productDB->category_id == $category->id ? "selected":"" }} >{{ $category->name }}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                                <div class="field col-md-6 col-sm-12">
                                                    <h4>Durasi Pengumpulan Dana (hari)</h4>
                                                    <input type="number" name="days_left" value="{{ $productDB->days_left }}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="field col-md-6 col-sm-12">
                                                    <h4>Kelas</h4>
                                                    <select id="business_class" name="business_class" class="form-control">
                                                        {{--<option {{ $productDB->business_class == "-1" ? "selected":"" }} value="-1">Pilih</option>--}}
                                                        <option {{ $productDB->business_class == "A" ? "selected":"" }} value="A">A</option>
                                                        <option {{ $productDB->business_class == "B" ? "selected":"" }} value="B">B</option>
                                                        <option {{ $productDB->business_class == "C" ? "selected":"" }} value="C">C</option>
                                                        <option {{ $productDB->business_class == "D" ? "selected":"" }} value="D">D</option>
                                                    </select>
                                                </div>
                                                <div class="field col-md-6 col-sm-12">
                                                    <h4>Suku Bunga</h4>
                                                    <input type="number" name="interest_rate" value="{{$productDB->interest_rate}}" class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="field col-md-6 col-sm-12">
                                                    <h4>Total Pendanaan</h4>
                                                    <input type="number" name="raising" value="{{ $productDB->getOriginal('raising') }}" disabled class="form-control col-md-7 col-xs-12">
                                                </div>
                                                <div class="field col-md-6 col-sm-12">
                                                    <h4>Durasi Pinjaman (bulan)</h4>
                                                    <input type="number" id="tenor_loan" name="tenor_loan" value="{{$productDB->tenor_loan }}" disabled class="form-control col-md-7 col-xs-12">
                                                </div>
                                                {{--<div class="field col-md-6 col-sm-12">--}}
                                                {{--<h4>Cicilan/bulan</h4>--}}
                                                {{--<input type="number" name="installment_per_month" value="{{old('installment_per_month')}}" class="form-control col-md-7 col-xs-12">--}}
                                                {{--</div>--}}
                                                {{--<div class="field col-md-6 col-sm-12">--}}
                                                {{--<h4>Bunga/bulan</h4>--}}
                                                {{--<input type="number" name="interest_per_month" value="{{old('interest_per_month')}}" class="form-control col-md-7 col-xs-12">--}}
                                                {{--</div>--}}
                                                {{--<div class="field col-md-6 col-sm-12">--}}
                                                    {{--<h4>&nbsp;</h4>--}}
                                                    {{--<a class="btn btn-primary col-md-5 col-xs-12" onclick="interestPerMonth()">Cicilan&Bunga / bulan</a>--}}
                                                {{--</div>--}}
                                                <div class="field col-sm-12">
                                                    <table id="interest-month">
                                                        <tr>
                                                            <td><h4>Bulan</h4></td>
                                                            <td style='padding-left:5%;'><h4>Cicilan/bulan</h4></td>
                                                            <td style='padding-left:5%;'><h4>Bunga/bulan</h4></td>
                                                        </tr>
                                                        @foreach($productInstallmentDB as $productInstallment)

                                                            <tr>
                                                                <td> Bulan {{$productInstallment->month}}</td>
                                                                <td style='padding-left:5%;'>
                                                                    <input type='number' value="{{$productInstallment->getOriginal('amount')}}" name='installment_per_month[]' class='form-control col-md-7 col-xs-12'/></td>
                                                                <td style='padding-left:5%;'>
                                                                    <input type='number' value="{{$productInstallment->getOriginal('interest_amount')}}" name='interest_per_month[]' class='form-control col-md-7 col-xs-12'/></td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
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
        function interestPerMonth(){
            var divAmount = $("#tenor_loan").val();

            var sbAdd = new stringbuilder();
            $('#interest-month').empty();

            sbAdd.append("<tr>");
            sbAdd.append("<td> <h4>Bulan</h4></td>");
            sbAdd.append("<td style='padding-left:5%;'><h4>Cicilan/bulan</h4></td>");
            sbAdd.append("<td style='padding-left:5%;'><h4>Bunga/bulan</h4></td>");
            sbAdd.append("</tr>");

            for(var i=1;i<=divAmount;i++){
                sbAdd.append("<tr>");
                sbAdd.append("<td> Bulan "+ i + "</td>");
                sbAdd.append("<td style='padding-left:5%;'>");
                sbAdd.append("<input type='number' name='installment_per_month[]' class='form-control col-md-7 col-xs-12'/></td>");
                sbAdd.append("<td style='padding-left:5%;'>");
                sbAdd.append("<input type='number' name='interest_per_month[]' class='form-control col-md-7 col-xs-12'/></td>");
                sbAdd.append("</tr>");
            }

            $('#interest-month').append(sbAdd.toString());
        }
    </script>
@endsection