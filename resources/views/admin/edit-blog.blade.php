\@extends('layouts.admin')

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
                            <h2>Edit Article</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <form id="blog-form" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="/admin/blog/edit/update/{{ $blog->id }}">
                                {{ csrf_field() }}

                                @if(count($errors))
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 alert alert-danger alert-dismissible fade in" role="alert">
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

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Judul Artikel <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-6 col-sm-6 col-xs-12" id="input" name="title" placeholder="Judul Artikel" value="{{ $blog->title }}">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Link Gambar <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-6 col-sm-6 col-xs-12" id="input" name="img" placeholder="Link Gambar" value="{{ $blog->img_path }}">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Category <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select id="category" name="category" class="form-control col-md-7 col-xs-7">
                                            <option value="-1">Select category</option>

                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" @if( $category->id == $blog->category_id) selected @endif>{{ $category->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Status <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select id="status" name="status" class="form-control col-md-7 col-xs-1">

                                            @if($blog->status_id == 1)
                                                <option value="1" selected>Publish</option>
                                                <option value="2">Unpublish</option>
                                            @else
                                                <option value="1">Publish</option>
                                                <option value="2" selected>Unpublish</option>
                                            @endif

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="contents">Contents</label>
                                    <input type="hidden" id="content" name="content">
                                    <textarea name="text" class="summernote" id="contents" title="Contents">
                                        {!! $blog->description !!}
                                    </textarea>
                                </div>
                                <button type="button" class="btn btn-default" onclick="formsubmit()">submit</button>
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
    <script>
        function formsubmit(){

            var content = $('.summernote').val();
            $('#content').val(content);
            $('#blog-form').submit();
        }

    </script>
@endsection