@extends('layouts.frontend')

@section('body-content')
    <!-- Banner -->
    <div class="page-banner">
        <div class="container">
            <div class="parallax-mask"></div>
            <div class="section-name">
                <h2>Daftar Berita</h2>
                <div class="short-text">
                    <h5><a href="{{route('index')}}">Beranda</a>
                        <i class="fa fa-angle-double-right"></i>Daftar Berita</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Blog-Wrapper -->
    <div class="blog-page-wrapper">
        <div class="container">
            <div class="row">
                <div class="blog-posts col-md-8">

                @foreach($blogDBs as $blogDB)
                    <!-- Blog Single -->
                        <div class="blog-box" style="padding-bottom: 10%;">
                            <div class="blog-top-desc">
                                <div class="blog-date">
                                    {{ \Carbon\Carbon::parse($blogDB->created_at)->format('j M Y ') }}
                                </div>
                                <i class="fa fa-user-o"></i> <strong>{{$blogDB->user_admin->first_name}} {{$blogDB->user_admin->last_name}}</strong>
                                <i class="fa fa-commenting-o"></i> <strong> Kategori : {{$blogDB->Category->name}}</strong>
                            </div>
                            <img class="img-responsive" src="{{$blogDB->img_path}}" alt="" style="width: 30%">
                            <div class="blog-btm-desc">
                                <p>
                                    {{ $highlightBlog[$blogDB->id] }}
                                </p>
                                <a href="{{ route('blog', ['id' => $blogDB->id]) }}" class="btn btn-min btn-solid"> Baca Selanjutnya  <i class="fa fa-arrow-right"></i> </a>
                            </div>
                        </div>

                        {{--<a href="{{ route('blog', ['id' => $recentBlog->id]) }}">--}}
                            {{--<div class="col-md-3 col-sm-6">--}}
                                {{--<div class="blog-box">--}}
                                    {{--<div class="blog-top-desc" style="color:white;">--}}
                                        {{--<strong> {{ \Carbon\Carbon::parse($recentBlog->created_at)->format('j M Y ') }} - Kategori : {{$recentBlog->Category->name}}</strong>--}}
                                    {{--</div>--}}
                                    {{--<div style="height: 30%;">--}}
                                        {{--<img src="{{$recentBlog->img_path}}" alt="" style="height: 150px;width: 100%;">--}}
                                    {{--</div>--}}
                                    {{--<div class="blog-btm-desc">--}}
                                        {{--<p>--}}
                                            {{--{{ $highlightBlog[$recentBlog->id] }}--}}
                                            {{--<br><span class="read-more">Baca Selanjutnya</span>--}}
                                        {{--</p>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</a>--}}
                        <!-- Blog Single -->
                    @endforeach
                    {{ $blogDBs->links() }}
                    {{--<div class="pagination-wrapper">--}}
                        {{--<ul class="pagination">--}}
                            {{--<li><a href="#"><i class="fa fa-angle-double-left"></i></a></li>--}}
                            {{--<li><a href="#">1</a></li>--}}
                            {{--<li><a href="#" class="active">2</a></li>--}}
                            {{--<li><a href="#">3</a></li>--}}
                            {{--<li><span>...</span></li>--}}
                            {{--<li><a href="#">7</a></li>--}}
                            {{--<li><a href="#">8</a></li>--}}
                            {{--<li><a href="#"><i class="fa fa-angle-double-right"></i></a></li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                </div>
                <!-- sidebar -->
                <div class="sidebar-wrapper col-md-4">
                    <div class="sidebar">
                        <div class="widget">
                            <div class="widget-title">
                                <h4>Recent Posts</h4>
                                <div class="sep">
                                    <div class="sep-inside"></div>
                                </div>
                            </div>
                            <div class="recent-posts clearfix">
                                @foreach($recentBlogs as $recentBlog)
                                    <div class="post clearfix">
                                        <div class="info-block">
                                            <a href="{{ route('blog', ['id' => $recentBlog->id]) }}"><h4>{{$recentBlog->title}}</h4></a>
                                            <div class="meta">
                                                <p><i class="fa fa-user"></i>{{$recentBlog->user_admin->first_name}} {{$recentBlog->user_admin->last_name}}</p>
                                                <span>&#x7C;</span>
                                                <p><i class="fa fa-clock-o"></i>{{ \Carbon\Carbon::parse($recentBlog->created_at)->format('j M Y ') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        {{--<div class="widget">--}}
                            {{--<div class="widget-title">--}}
                                {{--<h4>Tags</h4>--}}
                                {{--<div class="sep">--}}
                                    {{--<div class="sep-inside"></div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="tags">--}}
                                {{--<a href="#"><span>Cause</span></a>--}}
                                {{--<a href="#"><span>Lipsum</span></a>--}}
                                {{--<a href="#"><span>Donation</span></a>--}}
                                {{--<a href="#"><span>Charitable</span></a>--}}
                                {{--<a href="#"><span>Homeless</span></a>--}}
                                {{--<a href="#"><span>Blog</span></a>--}}
                                {{--<a href="#"><span>Minimal</span></a>--}}
                                {{--<a href="#"><span>Health</span></a>--}}
                                {{--<a href="#"><span>Education</span></a>--}}
                                {{--<a href="#"><span>LifStyle</span></a>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection