@extends('layouts.frontend')

@section('body-content')
    <!-- Banner -->
    <div class="page-banner">
        <div class="container">
            <div class="parallax-mask"></div>
            <div class="section-name">
                <h2>My Wallet</h2>
                <div class="short-text">
                    <h5>Home<i class="fa fa-angle-double-right"></i>My Wallet</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- contact wrapper -->
    <div class="contact-page-wrapper">
        <div class="container">
            <div class="row">

                <div class="col-md-12 col-xs-12">
                    <div class="row">
                        <div class="col-md-7 col-xs-12 center">
                            <h2>
                                <i class="fa fa-money fa-1x"></i> Rp 5.000.000
                            </h2>
                        </div>
                        <div class="col-md-5 col-xs-12 center" style="padding-top:3%;">
                            <a href="{{route('withdraw')}}" class="btn btn-big btn-warning">Withdraw</a>
                            <a href="{{route('deposit')}}" class="btn btn-big btn-success">Deposit</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Statement</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content table-responsive">
                            <table id="datatable-responsive-debt" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php( $idx = 1 )
                                    @foreach($statements as $trx)
                                        <tr>
                                            <td>{{ $idx }}</td>
                                            <td>{{ $trx->date }}</td>
                                            <td>{{ $trx->description }}</td>
                                            <td>{{ $trx->amount }}</td>
                                        </tr>
                                        @php( $idx++ )
                                            @endforeach
                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection