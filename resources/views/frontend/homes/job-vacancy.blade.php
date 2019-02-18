@extends('layouts.frontend')

@section('body-content')
    <!-- Banner -->
    <div class="page-banner">
        <div class="container">
            <div class="parallax-mask"></div>
            <div class="section-name">
                <h2>Lowongan Pekerjaan</h2>
                <div class="short-text">
                    <h5><a href="{{route('index')}}">Beranda</a>
                        <i class="fa fa-angle-double-right"></i>Lowongan Pekerjaan
                    </h5>
                </div>
            </div>
        </div>
    </div>


    <!-- Blog-Wrapper -->
    <div class="blog-page-wrapper">
        <div class="container">
            <div class="col-md-4">
                <ul class="list-group help-group">
                    <div class="faq-list list-group nav nav-tabs">
                        <a href="#tab1" class="list-group-item active" role="tab" data-toggle="tab">Content Creator</a>
                        <a href="#tab2" class="list-group-item" role="tab" data-toggle="tab"><i class="mdi mdi-account"></i> Public Relation</a>
                        <a href="#tab3" class="list-group-item" role="tab" data-toggle="tab"><i class="mdi mdi-account-settings"></i> Accounting</a>
                    </div>
                </ul>
            </div>
            <div class="col-md-8">
                <div class="tab-content panels-faq">
                    <div class="tab-pane active" id="tab1">
                        <div class="panel-group" id="help-accordion-1">
                            <div class="panel panel-default panel-help">
                                <img src="{{ URL::asset('frontend_images/homepage/job1.png') }}" style="width: 100%; height: auto;">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab2">
                        <div class="panel-group" id="help-accordion-2">
                            <div class="panel panel-default panel-help">
                                <img src="{{ URL::asset('frontend_images/homepage/job2.png') }}" style="width: 100%; height: auto;">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab3">
                        <div class="panel-group" id="help-accordion-3">
                            <div class="panel panel-default panel-help">
                                <img src="{{ URL::asset('frontend_images/homepage/job3.png') }}" style="width: 100%; height: auto;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    @parent
    <style>
        body {
            margin-top: 30px;
            background-color: #eee;
        }

        .list-group.help-group {
            margin-bottom: 20px;
            padding-left: 0;
            margin: 0;
        }
        .list-group.help-group .faq-list {
            display: block;
            top: auto;
            margin: 0 0 32px;
            border-radius: 2px;
            border: 1px solid #ddd;
            box-shadow: 0 1px 5px rgba(85, 85, 85, 0.15);
        }
        .list-group.help-group .faq-list .list-group-item {
            position: relative;
            display: block;
            margin: 0;
            padding: 13px 16px;
            background-color: #fff;
            border: 0;
            border-bottom: 1px solid #ddd;
            border-top-left-radius: 2px;
            border-top-right-radius: 2px;
            color: #616161;
            transition: background-color .2s;
        }
        .list-group.help-group .faq-list .list-group-item i.mdi {
            margin-right: 5px;
            font-size: 18px;
            position: relative;
            top: 2px;
        }
        .list-group.help-group .faq-list .list-group-item:hover {
            background-color: #f6f6f6;
        }
        .list-group.help-group .faq-list .list-group-item.active {
            background-color: #f6f6f6;
            font-weight: 700;
            color: rgba(0, 0, 0, 0.87);
        }
        .list-group.help-group .faq-list .list-group-item:last-of-type {
            border-bottom-left-radius: 2px;
            border-bottom-right-radius: 2px;
            border-bottom: 0;
        }

        .tab-content.panels-faq {
            padding: 0;
            border: 0;
        }

        .panel.panel-help {
            box-shadow: 0 1px 5px rgba(85, 85, 85, 0.15);
            padding-bottom: 0;
            border-radius: 2px;
            overflow: hidden;
            background-color: #fff;
            margin: 0 0 16px;
        }
        .panel.panel-help a[href^="#"],
        .panel.panel-help a[href^="#"]:hover,
        .panel.panel-help a[href^="#"]:focus {
            outline: none;
            cursor: pointer;
            text-decoration: none;
        }
        .panel.panel-help .panel-heading {
            background-color: #f6f6f6;
            padding: 0 16px;
            line-height: 48px;
            border-top-right-radius: 2px;
            border-top-left-radius: 2px;
            color: rgba(0, 0, 0, 0.87);
        }
        .panel.panel-help .panel-heading h2 {
            margin: 0;
            padding: 14px 0 14px;
            font-size: 18px;
            font-weight: 400;
            line-height: 20px;
            letter-spacing: 0;
            text-transform: none;
        }
        .panel.panel-help .panel-body {
            background-color: #fff;
            border-top: 1px solid #ddd;
            border-radius: 2px;
            border-top-right-radius: 0;
            border-top-left-radius: 0;
            margin-top: 0;
        }
        .panel.panel-help .panel-body p {
            margin: 0 0 16px;
        }
        .panel.panel-help .panel-body p:last-of-type {
            margin: 0;
        }

    </style>
@endsection

@section('scripts')
    @parent
    <script>
        $(function() {
            // Since there's no list-group/tab integration in Bootstrap
            $(".list-group-item").on("click", function(e) {
                var previous = $(this)
                    .closest(".list-group")
                    .children(".active");
                previous.removeClass("active"); // previous list-item
                $(e.target).addClass("active"); // activated list-item
            });
        });

    </script>
@endsection