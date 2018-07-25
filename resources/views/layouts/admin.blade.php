<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Indofund.id | Admin</title>

    <!-- Bootstrap -->
    <link href="{{ URL::asset('css/bootstrap.css') }}" rel="stylesheet">
    <!-- bootstrap-file-input -->
    <link href="{{ URL::asset('css/kartik-bootstrap-file-input/fileinput.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ URL::asset('css/font-awesome/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ URL::asset('css/admin/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ URL::asset('css/admin/iCheck/skins/flat/green.css') }}" rel="stylesheet">
    <!-- bootstrap-wysiwyg -->
    <link href="{{ URL::asset('css/admin/google-code-prettify/prettify.min.css') }}" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="{{ URL::asset('css/admin/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{ URL::asset('css/admin/jqvmap/jqvmap.min.css') }}" rel="stylesheet">
    <!-- Select2 -->
    <link href="{{ URL::asset('css/admin/select2/select2.min.css') }}" rel="stylesheet">
    <!-- Switchery -->
    <link href="{{ URL::asset('css/admin/switchery/switchery.min.css') }}" rel="stylesheet">
    <!-- starrr -->
    <link href="{{ URL::asset('css/admin/starrr/starrr.css') }}" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="{{ URL::asset('css/admin/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">

    <!-- Datatables -->
    <link href="{{ URL::asset('css/admin/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/admin/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }} " rel="stylesheet">
    <link href="{{ URL::asset('css/admin/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }} " rel="stylesheet">
    <link href="{{ URL::asset('css/admin/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/admin/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }} " rel="stylesheet">

    <!-- include codemirror (codemirror.css, codemirror.js, xml.js, formatting.js) -->
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.css">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/theme/monokai.css">

    <!-- include summernote -->
    <link rel="stylesheet" href="{{ URL::asset('css/admin/summernote/summernote.css') }}">

    <!-- Custom Theme Style -->
    <link href="{{ URL::asset('css/admin/custom.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/admin/custom-admin-lowids.css') }}" rel="stylesheet">
</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">

        <!-- page content -->
    @yield('dashboard')
    <!-- /page content -->

    </div>
</div>

<!-- jQuery -->
<script src="{{ URL::asset('js/admin/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
<!-- bootstrap-file-input -->
<script src="{{ URL::asset('js/kartik-bootstrap-file-input/fileinput.min.js') }}"></script>
<!-- DateTime -->
<script src="{{ URL::asset('js/frontend/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<!-- autoNumeric -->
<script src="{{ URL::asset('js/autoNumeric/autoNumeric.min.js') }}"></script>

<!-- FastClick -->
<script src="{{ URL::asset('js/admin/fastclick/fastclick.js') }}"></script>
<!-- NProgress -->
<script src="{{ URL::asset('js/admin/nprogress/nprogress.js') }}"></script>
<!-- Chart.js -->
<script src="{{ URL::asset('js/admin/Chart/Chart.min.js') }}"></script>
<!-- gauge.js -->
<script src="{{ URL::asset('js/admin/gauge/gauge.min.js') }}"></script>
<!-- bootstrap-progressbar -->
<script src="{{ URL::asset('js/admin/gauge/gauge.min.js') }}"></script>
<script src="{{ URL::asset('js/admin/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ URL::asset('js/admin/iCheck/icheck.min.js') }}"></script>
<!-- Skycons -->
<script src="{{ URL::asset('js/admin/skycons/skycons.js') }}"></script>
<!-- Flot -->
<script src="{{ URL::asset('js/admin/Flot/jquery.flot.js') }}"></script>
<script src="{{ URL::asset('js/admin/Flot/jquery.flot.pie.js') }}"></script>
<script src="{{ URL::asset('js/admin/Flot/jquery.flot.time.js') }}"></script>
<script src="{{ URL::asset('js/admin/Flot/jquery.flot.stack.js') }}"></script>
<script src="{{ URL::asset('js/admin/Flot/jquery.flot.resize.js') }}"></script>
<!-- Flot plugins -->
<script src="{{ URL::asset('js/admin/flot.orderbars/jquery.flot.orderBars.js') }}"></script>
<script src="{{ URL::asset('js/admin/flot-spline/jquery.flot.spline.min.js') }}"></script>
<script src="{{ URL::asset('js/admin/flot.curvedlines/curvedLines.js') }}"></script>
<!-- DateJS -->
<script src="{{ URL::asset('js/admin/DateJS/date.js') }}"></script>
<!-- JQVMap -->
<script src="{{ URL::asset('js/admin/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ URL::asset('js/admin/jqvmap/jquery.vmap.world.js') }}"></script>
<script src="{{ URL::asset('js/admin/jqvmap/jquery.vmap.sampledata.js') }}"></script>
<!-- bootstrap-daterangepicker -->
<script src="{{ URL::asset('js/admin/moment/moment.min.js') }}"></script>
<script src="{{ URL::asset('js/admin/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<!-- bootstrap-wysiwyg -->
<script src="{{ URL::asset('js/admin/bootstrap-wysiwyg/bootstrap-wysiwyg.min.js') }}"></script>
<script src="{{ URL::asset('js/admin/jquery.hotkeys/jquery.hotkeys.js') }}"></script>
<script src="{{ URL::asset('js/admin/google-code-prettify/prettify.min.js') }}"></script>
<!-- jQuery Tags Input -->
<script src="{{ URL::asset('js/admin/jquery.tagsinput/jquery.tagsinput.js') }}"></script>
<!-- Switchery -->
<script src="{{ URL::asset('js/admin/switchery/switchery.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ URL::asset('js/admin/select2/select2.full.min.js') }}"></script>
<!-- Parsley -->
<script src="{{ URL::asset('js/admin/parsleyjs/parsley.min.js') }}"></script>
<!-- Autosize -->
<script src="{{ URL::asset('js/admin/autosize/autosize.min.js') }}"></script>
<!-- jQuery autocomplete -->
<script src="{{ URL::asset('js/admin/devbridge-autocomplete/jquery.autocomplete.min.js') }}"></script>
<!-- starrr -->
<script src="{{ URL::asset('js/admin/starrr/starrr.js') }}"></script>
<!-- validator -->
<script src="{{ URL::asset('js/admin/validator/validator.js') }}"></script>

<!-- Datatables -->
<script src="{{ URL::asset('css/admin/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('css/admin/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('css/admin/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('css/admin/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('css/admin/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
<script src="{{ URL::asset('css/admin/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('css/admin/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ URL::asset('css/admin/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
<script src="{{ URL::asset('css/admin/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
<script src="{{ URL::asset('css/admin/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('css/admin/datatables.net-responsive-bs/js/responsive.bootstrap.js') }}"></script>
<script src="{{ URL::asset('css/admin/datatables.net-scroller/js/dataTables.scroller.min.js') }}"></script>
<script src="{{ URL::asset('css/admin/jszip/dist/jszip.min.js') }}"></script>
<script src="{{ URL::asset('css/admin/pdfmake/build/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('css/admin/pdfmake/build/vfs_fonts.js') }}"></script>
{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>--}}
<script src="http://www.position-absolute.com/creation/print/jquery.printPage.js"></script>

{{-- js for wysiwyg editor --}}
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/mode/xml/xml.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/2.36.0/formatting.js"></script>
<script src="{{ URL::asset('js/admin/summernote/summernote.js') }}"></script>


<!-- string builder js -->
<script src="{{ URL::asset('js/admin/stringbuilder.js') }}"></script>

<!-- Custom Theme Scripts -->
<script src="{{ URL::asset('js/admin/custom.js') }}"></script>

<!-- Custom Lowids Scripts -->
<script src="{{ URL::asset('js/admin/custom-lowids.js') }}"></script>
<script>
    $('#datatable-responsive').DataTable( {
        buttons: [
            {
                extend: 'print',
                text: 'Print current page',
                exportOptions: {
                    modifier: {
                        page: 'current'
                    }
                }
            }
        ],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Indonesian-Alternative.json"
        }
    } );
    $('#datatable-responsive-trx').DataTable( {
        buttons: [
            {
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.childRowImmediate,
                        type: ''
                    }
                },
                extend: 'print',
                text: 'Print current page',
                exportOptions: {
                    modifier: {
                        page: 'current'
                    }
                }
            }
        ],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Indonesian-Alternative.json"
        }
    } );
    $('#datatable-responsive-dompet').DataTable( {
        buttons: [
            {
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.childRowImmediate,
                        type: ''
                    }
                },
                extend: 'print',
                text: 'Print current page',
                exportOptions: {
                    modifier: {
                        page: 'current'
                    }
                }
            }
        ],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Indonesian-Alternative.json"
        }
    } );
    $(document).ready(function() {
        var table = $('#datatable-responsive').DataTable();

        $('#datatable-responsive tbody').on( 'click', 'tr', function () {
            var id = $(this).attr('id');

            var checkBoxes = $('#checkbox'+id);
            checkBoxes.prop("checked", !checkBoxes.prop("checked"));

            var checkboxValue = checkBoxes.val();
            var isNull = $('#checkboxvalue'+id).val();
            if(isNull != ""){
                $('#checkboxvalue'+id).val("");
            }
            else{
                $('#checkboxvalue'+id).val(checkboxValue);
            }
        } );

        $('#btn-accept').click( function () {
            $('#actionSelector').val('accept');

            var title = "Warning";
            var content = "Apakah Anda yakin untuk melanjutkan / menerima?"
            var yes = "Accept";

            $("#small-modal-title").html(title);
            $("#small-modal-body").html(content);
            $("#small-modal-yes").html(yes);

            $("#small-modal-yes").attr('onclick', 'clickPopup()');
            $("#small-modal").modal();
        });
        $('#btn-decline').click( function () {
            $('#actionSelector').val('decline');

            var title = "Warning";
            var content = "Apakah Anda yakin untuk menolak / menghapus?"
            var yes = "Delete";

            $("#small-modal-yes").attr("class","btn btn-danger");
            $("#small-modal-title").html(title);
            $("#small-modal-body").html(content);
            $("#small-modal-yes").html(yes);

            $("#small-modal-yes").attr('onclick', 'clickPopup()');
            $("#small-modal").modal();

        });
    });

    function clickPopup(){
        $("#multiple-wallet-form").submit();
    }

    $(function() {
        $('.summernote').summernote({
            height: 400
        });

//        $('form').on('submit', function (e) {
//            e.preventDefault();
//            alert($('.summernote').summernote('code'));
//            alert($('.summernote').val());
//        });
    });
</script>
</body>
</html>
