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
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Request Penarikan Total Dana</h2>
                            <div class="nav navbar-right">
                                <a href="{{ route('download-wallet') }}" class="btn btn-app">
                                    <i class="fa fa-download"></i> Download to Excel
                                </a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            @include('admin.partials._success')
                            <form class="comment-form row altered" id="multiple-wallet-form" method="POST" action="{{route('multiple-process')}}">
                                {{ csrf_field() }}

                                <input type="hidden" id="actionSelector" name="action" value="">
                                <a class="btn btn-success" id="btn-accept">Terima Semua</a>
                                <a class="btn btn-danger" id="btn-decline">Tolak Semua</a>

                                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Deskripsi</th>
                                        <th class="text-right">Saldo Terakhir</th>
                                        <th class="text-right">Jumlah Penarikan</th>
                                        <th class="text-right">Fee</th>
                                        <th class="text-right">Jumlah yang ditransfer</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>

                                @php( $idx = 1 )
                                @foreach($statements as $statement)

                                    <tr id="{{$idx}}">
                                        <td>
                                            <input id="checkbox{{$idx}}" type="checkbox" value="{{$statement->id}}">
                                            <input id="checkboxvalue{{$idx}}" name="submitCheckbox[]" type="hidden" value="">
                                        </td>
                                        <td>{{ $idx }}</td>
                                        <td>{{ $statement->date }}</td>
                                        <td>{{ $statement->description }}</td>
                                        <td class="text-right">Rp {{ $statement->saldo }}</td>
                                        <td class="text-right">Rp {{ $statement->amount }}</td>
                                        <td class="text-right">Rp {{ $statement->fee }}</td>
                                        <td class="text-right">Rp {{ $statement->transfer_amount }}</td>
                                        <td>
                                            <a onclick="modalPop('{{ $statement->id }}', 'accept', '/admin/dompet/accept/')" class="btn btn-success">Terima</a>
                                            <a onclick="modalPop('{{ $statement->id }}', 'cancel', '/admin/dompet/reject/')" class="btn btn-danger">Tolak</a>
                                        </td>
                                    </tr>
                                    @php( $idx++ )
                                @endforeach
                                </tbody>
                            </table>

                            </form>
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

    <!-- footer -->
    @include('admin.partials._footer')
    <!-- /footer -->

@endsection