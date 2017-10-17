@extends('layouts.frontend')

@section('body-content')
    <!-- Banner -->
    <div class="page-banner">
        <div class="container">
            <div class="parallax-mask"></div>
            <div class="section-name">
                <h2>Daftar Investasi</h2>
                <div class="short-text">
                    <h5><a href="{{route('index')}}">Home</a>
                        <i class="fa fa-angle-double-right"></i>Daftar Investasi
                    </h5>
                </div>
            </div>
        </div>
    </div>


    <div class="grid-cause-area list-cause-area">
        <div class="container">

            <div class="panel with-nav-tabs panel-default">
                <div class="panel-heading">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#debt" data-toggle="tab">Debt</a></li>
                        <li><a href="#equity" data-toggle="tab">Equity</a></li>
                        <li><a href="#sharing" data-toggle="tab">Profit Sharing / Produk</a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="debt">
                            <div class="col-md-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_content table-responsive">
                                        <table id="datatable-responsive-debt" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
                                            <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Total</th>
                                                <th>Sisa Hari</th>
                                                <th>Terkumpul</th>
                                                <th>Minimum</th>
                                                <th>Progress</th>
                                                <th>Option</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php( $idx = 1 )
                                                @foreach($products as $product)

                                                    @php( $percentage = ($product->getOriginal('raised') * 100) / $product->getOriginal('raising') )
                                                        @php( $percentage = number_format($percentage, 0) )
                                                            <tr>
                                                                <td>{{ $idx }}</td>
                                                                <td>{{ $product->name }}</td>
                                                                <td>Rp {{ $product->raising }}</td>
                                                                <td>{{ $product->days_left }} </td>
                                                                <td>Rp {{ $product->raised }}</td>
                                                                <td>Rp {{ $product->minimum_per_investor }}</td>
                                                                <td>
                                                                    <div class="progress-bar-inner">
                                                                        <div class="progress-bar">
                                                                            <span data-percent="{{$percentage}}"><span class="pretng">{{$percentage}}%</span> </span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <a href="{{ route('project-detail', ['id' => $product->id]) }}" >
                                                                        <button class="btn btn-primary">Detail</button>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            @php( $idx++ )
                                                                @endforeach
                                            </tbody>
                                        </table>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="equity">
                            <div class="col-md-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_content table-responsive">
                                        <table id="datatable-responsive-equity" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
                                            <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Total</th>
                                                <th>Sisa Hari</th>
                                                <th>Terkumpul</th>
                                                <th>Minimum</th>
                                                <th>Progress</th>
                                                <th>Option</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php( $idx = 1 )
                                                @foreach($products as $product)

                                                    @php( $percentage = ($product->getOriginal('raised') * 100) / $product->getOriginal('raising') )
                                                    @php( $percentage = number_format($percentage, 0) )
                                                        <tr>
                                                            <td>{{ $idx }}</td>
                                                            <td>{{ $product->name }}</td>
                                                            <td>Rp {{ $product->raising }}</td>
                                                            <td>{{ $product->days_left }} </td>
                                                            <td>Rp {{ $product->raised }}</td>
                                                            <td>Rp {{ $product->minimum_per_investor }}</td>
                                                            <td>
                                                                <div class="progress-bar-inner">
                                                                    <div class="progress-bar">
                                                                        <span data-percent="{{$percentage}}"><span class="pretng">{{$percentage}}%</span> </span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('project-detail', ['id' => $product->id]) }}" >
                                                                    <button class="btn btn-primary">Detail</button>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @php( $idx++ )
                                                @endforeach
                                            </tbody>
                                        </table>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="sharing">
                            <div class="col-md-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_content table-responsive">
                                        <table id="datatable-responsive-sharing" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
                                            <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Total</th>
                                                <th>Sisa Hari</th>
                                                <th>Terkumpul</th>
                                                <th>Minimum</th>
                                                <th>Progress</th>
                                                <th>Option</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php( $idx = 1 )
                                                @foreach($products as $product)

                                                    @php( $percentage = ($product->getOriginal('raised') * 100) / $product->getOriginal('raising') )
                                                        @php( $percentage = number_format($percentage, 0) )
                                                            <tr>
                                                                <td>{{ $idx }}</td>
                                                                <td>{{ $product->name }}</td>
                                                                <td>Rp {{ $product->raising }}</td>
                                                                <td>{{ $product->days_left }} </td>
                                                                <td>Rp {{ $product->raised }}</td>
                                                                <td>Rp {{ $product->minimum_per_investor }}</td>
                                                                <td>
                                                                    <div class="progress-bar-inner">
                                                                        <div class="progress-bar">
                                                                            <span data-percent="{{$percentage}}"><span class="pretng">{{$percentage}}%</span> </span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <a href="{{ route('project-detail', ['id' => $product->id]) }}" >
                                                                        <button class="btn btn-primary">Detail</button>
                                                                    </a>
                                                                </td>
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
            </div>
        </div>
    </div>
@endsection