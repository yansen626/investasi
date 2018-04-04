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
                        <div class="x_title">
                            <h2>Produk Dana Gagal Terkumpul</h2>
                        </div>
                        <div class="x_content">
                            @include('admin.partials._success')
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Proyek</th>
                                    {{--<th>Category</th>--}}
                                    <th>Pengumpulan Dana </th>
                                    <th>Dana Terkumpul</th>
                                    <th>Konfirmasi Admin</th>
                                    <th>Konfirmasi Superadmin</th>
                                    <th>Tanggal Pembuatan</th>
                                    <th>Option</th>
                                </tr>
                                </thead>
                                <form>
                                <tbody>
                                @php ($idx = 1)
                                    @foreach($products as $product)
                                        <tr>
                                            <td>{{ $idx}}</td>
                                            <td>{{ $product->name}}</td>
                                            {{--<td>{{ $product->category->name }}</td>--}}
                                            <td>Rp {{ $product->raising}}</td>
                                            <td>Rp {{ $product->raised}}</td>
                                            <td><input type="checkbox" @if($product->confirmation_1 == 1) checked @endif onclick="return false;" /></td>
                                            <td><input type="checkbox" @if($product->confirmation_2 == 1) checked @endif onclick="return false;" /></td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($product->created_on)->format('j F y')}}
                                            </td>
                                            <td>
                                                <a href="{{ route('product-investors', ['id'=>$product->id]) }}" class="btn btn-primary">Detail Pendana</a>
                                                @if(
                                                    ($adminType == 2 && $product->confirmation_1 == 0) ||
                                                    ($adminType == 1 && $product->confirmation_1 == 1&& $product->confirmation_2 == 0))
                                                    <a onclick="modalPop('{{ $product->id }}', 'accept', '/admin/product/collected-fund/accept/')" class="btn btn-success">Terima</a>
                                                @endif
                                            </td>
                                        </tr>
                                        @php ($idx++)
                                    @endforeach
                                </tbody>
                                </form>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->

    <!-- small modal -->
    @include('admin.partials._small_modal')
    <!-- /small modal -->

@endsection