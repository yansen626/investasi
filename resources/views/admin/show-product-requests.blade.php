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
                            <h2>Request Produk Investasi</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            @include('admin.partials._success')
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    {{--<th>User Name</th>--}}
                                    {{--<th>Vendor Name</th>--}}
                                    <th>Raising </th>
                                    <th>Created Date</th>
                                    <th>Featured Photo</th>
                                    <th>Option</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php ($idx = 1)
                                    @foreach($products as $product)
                                        <tr>
                                            <td>{{ $idx}}</td>
                                            <td>{{ $product->name}}</td>
                                            <td>{{ $product->category->name }}</td>
{{--                                            <td>{{ $product->user->first_name }} {{ $product->user->last_name }}</td>--}}
{{--                                            <td>{{ $product->name}}</td>--}}
                                            <td>Rp {{ $product->raising}}</td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($product->created_on)->format('j F y')}}
                                            </td>
                                            {{--<td width="15%">--}}
                                                {{--<img width="100%" src="{{ asset('storage\product\\'. $product->product_image()->where('featured', 1)->first()->path) }}">--}}
                                            {{--</td>--}}
                                            <td><img src="{{ URL::asset('storage/project/'.$product->image_path) }}" width="100"></td>
                                            <td>
                                                @if($product->vendor->status_id == 3)
                                                    <a onclick="modalPop('{{ $product->vendor_id }}', 'accept', '/admin/vendor/request-accept/')" class="btn btn-sm btn-success">Accept</a>
                                                    <a onclick="modalPop('{{ $product->vendor_id }}', 'cancel', '/admin/vendor/request-reject/')" class="btn btn-sm btn-danger">Reject</a>
                                                @else
                                                    <a onclick="modalPop('{{ $product->id }}', 'accept', '/admin/product/request-accept/')" class="btn btn-sm btn-success">Accept</a>
                                                    <a onclick="modalPop('{{ $product->id }}', 'cancel', '/admin/product/request-reject/')" class="btn btn-sm btn-danger">Reject</a>
                                                @endif
                                                {{--<a href="#" class="btn btn-primary">Terima</a>--}}
                                                {{--<a href="#" class="btn btn-danger">Tolak</a>--}}
                                            </td>
                                        </tr>
                                        @php ($idx++)
                                    @endforeach
                                </tbody>
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