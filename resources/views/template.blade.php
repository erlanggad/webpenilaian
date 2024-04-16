<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ URL::asset('plugins/images/cuti (2).png') }}">
    <title>SI CUTKAR @yield('title')</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ URL::asset('bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('plugins/bower_components/datatables/jquery.dataTables.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css') }}"
        rel="stylesheet">
    <!-- Menu CSS -->
    <link href="{{ URL::asset('plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css') }}" rel="stylesheet">
    <!-- morris CSS -->
    <link href="{{ URL::asset('plugins/bower_components/morrisjs/morris.css') }}" rel="stylesheet">
    <!-- animation CSS -->
    <link href="{{ URL::asset('css/animate.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet">
    <!-- color CSS -->
    <link href="{{ URL::asset('css/colors/default.css') }}" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <script>
        (function(i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function() {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o), m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
        ga('create', 'UA-19175540-9', 'auto');
        ga('send', 'pageview');
    </script>
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2"
                stroke-miterlimit="10" />
        </svg>
    </div>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header" style="background-color: #1E90FF;"> <a
                    class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)"
                    data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>

                <ul class="nav navbar-top-links navbar-left hidden-xs">
                    <li><a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light"><i
                                class="icon-arrow-left-circle ti-menu"></i></a></li>
                    <!-- <li>
                        <form role="search" class="app-search hidden-xs">
                            <input type="text" placeholder="Search..." class="form-control"> <a href=""><i class="fa fa-search"></i></a>
                        </form>
                    </li> -->
                </ul>
                <ul class="nav navbar-top-links navbar-right pull-right">


                    <li class="dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img
                                src="{{ URL::asset('plugins/images/users/user.png') }}" alt="user-img" width="36"
                                class="img-circle"><b class="hidden-xs">{{ Session('user')['nama'] }}</b> </a>
                        <ul class="dropdown-menu dropdown-user scale-up">
                            <li><a href="/logout-action"><i class="fa fa-power-off"></i> Logout</a></li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>

                </ul>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
        <!-- Left navbar-header -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse slimscrollsidebar">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search hidden-sm hidden-md hidden-lg">
                        <!-- input-group -->
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Search..."> <span
                                class="input-group-btn">
                                <button class="btn btn-default" type="button"> <i class="fa fa-search"></i> </button>
                            </span>
                        </div>
                        <!-- /input-group -->
                    </li>

                    <li class="nav-small-cap m-t-10 ml-2">Main Menu</li>
                    @if (Session('user')['role'] == 'admin')
                        <li> <a href="/admin/home" class="waves-effect "><i
                                    class="zmdi zmdi-view-dashboard zmdi-hc-fw fa-fw"></i> <span class="hide-menu"> Home
                                </span></a></li>
                        {{-- <li> <a href="/admin/manage-pejabat-struktural" class="waves-effect "><i class="zmdi zmdi-account zmdi-hc-fw fa-fw"></i> <span class="hide-menu"> Manage Pejabat Struktural  </span></a></li> --}}
                        <li> <a href="/admin/kriteria" class="waves-effect "><i
                                    class="zmdi zmdi-account zmdi-hc-fw fa-fw"></i> <span class="hide-menu"> Kelola
                                    Bobot dan Kriteria </span></a></li>
                        <li> <a href="/admin/manage-karyawan" class="waves-effect "><i
                                    class="zmdi zmdi-account zmdi-hc-fw fa-fw"></i> <span class="hide-menu"> Kelola
                                    Karyawan </span></a></li>
                    @elseif (Session('user')['role'] == 'Kepala Bagian')
                        <li> <a href="/kepala-bagian/home" class="waves-effect "><i
                                    class="zmdi zmdi-view-dashboard zmdi-hc-fw fa-fw"></i> <span class="hide-menu">
                                    Home
                                </span></a></li>
                        {{-- <li> <a href="/admin/manage-pejabat-struktural" class="waves-effect "><i class="zmdi zmdi-account zmdi-hc-fw fa-fw"></i> <span class="hide-menu"> Manage Pejabat Struktural  </span></a></li> --}}

                        <li> <a href="/kepala-bagian/manage-karyawan" class="waves-effect "><i
                                    class="zmdi zmdi-account zmdi-hc-fw fa-fw"></i> <span class="hide-menu"> Data
                                    Karyawan </span></a></li>

                        <li> <a href="/kepala-bagian/manage-kepala-sub-bagian" class="waves-effect "><i
                                    class="zmdi zmdi-account zmdi-hc-fw fa-fw"></i> <span class="hide-menu"> Data
                                    Kepala Sub Bagian </span></a></li>
                        <li> <a href="/kepala-bagian/form-penilaian" class="waves-effect "><i
                                    class="zmdi zmdi-account zmdi-hc-fw fa-fw"></i> <span class="hide-menu"> Form
                                    Penilaian Kepala Sub Bagian </span></a></li>
                        <li class="nav-item">
                            <a href="#"
                                class="nav-link waves-effect d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="zmdi zmdi-settings zmdi-hc-fw fa-fw"></i>
                                    <span class="hide-menu">Perhitungan Kinerja Karyawan Waspas</span>
                                </div>
                                <i class="fa fa-caret-down"></i> <!-- Icon panah ke bawah -->
                            </a>
                            <ul class="nav flex-column ml-2">
                                <li class="nav-item">
                                    <a href="/kepala-bagian/konversi-alternatif-waspas" class="nav-link"><span
                                            class="hide-menu">Konversi Alternatif</span></a>
                                </li>
                                <li class="nav-item">
                                    <a href="/kepala-bagian/hasil-normalisasi-waspas" class="nav-link"><span
                                            class="hide-menu">Hasil Normalisasi</span></a>
                                </li>
                                <li class="nav-item">
                                    <a href="/kepala-bagian/hasil-akhir-waspas" class="nav-link"><span
                                            class="hide-menu">Hasil Akhir</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#"
                                class="nav-link waves-effect d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="zmdi zmdi-settings zmdi-hc-fw fa-fw"></i>
                                    <span class="hide-menu">Perhitungan Kinerja Karyawan Moora</span>
                                </div>
                                <i class="fa fa-caret-down"></i> <!-- Icon panah ke bawah -->
                            </a>
                            <ul class="nav flex-column ml-2">
                                <li class="nav-item">
                                    <a href="/kepala-bagian/konversi-alternatif-moora" class="nav-link"><span
                                            class="hide-menu">Konversi Alternatif</span></a>
                                </li>
                                <li class="nav-item">
                                    <a href="/kepala-bagian/hasil-normalisasi-moora" class="nav-link"><span
                                            class="hide-menu">Hasil Normalisasi</span></a>
                                </li>
                                <li class="nav-item">
                                    <a href="/kepala-bagian/hasil-atribut-optimal" class="nav-link"><span
                                            class="hide-menu">Hasil Atribut Optimal</span></a>
                                </li>
                                <li class="nav-item">
                                    <a href="/kepala-bagian/hasil-akhir-moora" class="nav-link"><span
                                            class="hide-menu">Hasil Akhir</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#"
                                class="nav-link waves-effect d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="zmdi zmdi-settings zmdi-hc-fw fa-fw"></i>
                                    <span class="hide-menu">Perhitungan Kinerja Karyawan Topsis</span>
                                </div>
                                <i class="fa fa-caret-down"></i> <!-- Icon panah ke bawah -->
                            </a>
                            <ul class="nav flex-column ml-2">
                                <li class="nav-item">
                                    <a href="/kepala-bagian/konversi-alternatif-topsis" class="nav-link"><span
                                            class="hide-menu">Konversi Alternatif</span></a>
                                </li>
                                <li class="nav-item">
                                    <a href="/kepala-bagian/hasil-normalisasi-topsis" class="nav-link"><span
                                            class="hide-menu">Hasil Normalisasi </span></a>
                                </li>
                                <li class="nav-item">
                                    <a href="/kepala-bagian/hasil-normalisasi-terbobot-topsis" class="nav-link"><span
                                            class="hide-menu">Hasil Normalisasi Terbobot</span></a>
                                </li>
                                <li class="nav-item">
                                    <a href="/kepala-bagian/hasil-solusi-ideal-topsis" class="nav-link"><span
                                            class="hide-menu">Hasil Solusi Ideal</span></a>
                                </li>
                                <li class="nav-item">
                                    <a href="/kepala-bagian/hasil-akhir-topsis" class="nav-link"><span
                                            class="hide-menu">Hasil Akhir</span></a>
                                </li>
                            </ul>
                        </li>
                    @elseif (Session('user')['role'] == 'Kepala Sub Bagian')
                        <li> <a href="/kepala-sub-bagian/home" class="waves-effect "><i
                                    class="zmdi zmdi-view-dashboard zmdi-hc-fw fa-fw"></i> <span class="hide-menu">
                                    Home </span></a></li>
                        <li> <a href="/kepala-sub-bagian/manage-karyawan" class="waves-effect "><i
                                    class="zmdi zmdi-account zmdi-hc-fw fa-fw"></i> <span class="hide-menu"> Data
                                    Karyawan </span></a></li>

                        <li> <a href="/kepala-sub-bagian/form-penilaian" class="waves-effect "><i
                                    class="zmdi zmdi-account zmdi-hc-fw fa-fw"></i> <span class="hide-menu"> Form
                                    Penilaian Karyawan </span></a></li>
                        <li class="nav-item">
                            <a href="#"
                                class="nav-link waves-effect d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="zmdi zmdi-settings zmdi-hc-fw fa-fw"></i>
                                    <span class="hide-menu">Perhitungan Kinerja Karyawan Waspas</span>
                                </div>
                                <i class="fa fa-caret-down"></i> <!-- Icon panah ke bawah -->
                            </a>
                            <ul class="nav flex-column ml-2">
                                <li class="nav-item">
                                    <a href="/kepala-sub-bagian/konversi-alternatif-waspas" class="nav-link"><span
                                            class="hide-menu">Konversi Alternatif</span></a>
                                </li>
                                <li class="nav-item">
                                    <a href="/kepala-sub-bagian/hasil-normalisasi-waspas" class="nav-link"><span
                                            class="hide-menu">Hasil Normalisasi</span></a>
                                </li>
                                <li class="nav-item">
                                    <a href="/kepala-sub-bagian/hasil-akhir-waspas" class="nav-link"><span
                                            class="hide-menu">Hasil Akhir</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#"
                                class="nav-link waves-effect d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="zmdi zmdi-settings zmdi-hc-fw fa-fw"></i>
                                    <span class="hide-menu">Perhitungan Kinerja Karyawan Moora</span>
                                </div>
                                <i class="fa fa-caret-down"></i> <!-- Icon panah ke bawah -->
                            </a>
                            <ul class="nav flex-column ml-2">
                                <li class="nav-item">
                                    <a href="/kepala-sub-bagian/konversi-alternatif-moora" class="nav-link"><span
                                            class="hide-menu">Konversi Alternatif</span></a>
                                </li>
                                <li class="nav-item">
                                    <a href="/kepala-sub-bagian/hasil-normalisasi-moora" class="nav-link"><span
                                            class="hide-menu">Hasil Normalisasi</span></a>
                                </li>
                                <li class="nav-item">
                                    <a href="/kepala-sub-bagian/hasil-atribut-optimal" class="nav-link"><span
                                            class="hide-menu">Hasil Atribut Optimal</span></a>
                                </li>
                                <li class="nav-item">
                                    <a href="/kepala-sub-bagian/hasil-akhir-moora" class="nav-link"><span
                                            class="hide-menu">Hasil Akhir</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#"
                                class="nav-link waves-effect d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="zmdi zmdi-settings zmdi-hc-fw fa-fw"></i>
                                    <span class="hide-menu">Perhitungan Kinerja Karyawan Topsis</span>
                                </div>
                                <i class="fa fa-caret-down"></i> <!-- Icon panah ke bawah -->
                            </a>
                            <ul class="nav flex-column ml-2">
                                <li class="nav-item">
                                    <a href="/kepala-sub-bagian/konversi-alternatif-topsis" class="nav-link"><span
                                            class="hide-menu">Konversi Alternatif</span></a>
                                </li>
                                <li class="nav-item">
                                    <a href="/kepala-sub-bagian/hasil-normalisasi-topsis" class="nav-link"><span
                                            class="hide-menu">Hasil Normalisasi </span></a>
                                </li>
                                <li class="nav-item">
                                    <a href="/kepala-sub-bagian/hasil-normalisasi-terbobot-topsis"
                                        class="nav-link"><span class="hide-menu">Hasil Normalisasi Terbobot</span></a>
                                </li>
                                <li class="nav-item">
                                    <a href="/kepala-sub-bagian/hasil-solusi-ideal-topsis" class="nav-link"><span
                                            class="hide-menu">Hasil Solusi Ideal</span></a>
                                </li>
                                <li class="nav-item">
                                    <a href="/kepala-sub-bagian/hasil-akhir-topsis" class="nav-link"><span
                                            class="hide-menu">Hasil Akhir</span></a>
                                </li>
                            </ul>
                        </li>
                        <li> <a href="/kepala-sub-bagian/ranking" class="waves-effect "><i
                                    class="zmdi zmdi-account zmdi-hc-fw fa-fw"></i> <span class="hide-menu"> Form
                                    Ranking Penilaian Kinerja </span></a></li>
                    @elseif (Session('user')['role'] == 'karyawan' || Session('user')['role'] == 'Karyawan')
                        <li> <a href="/karyawan/home" class="waves-effect "><i
                                    class="zmdi zmdi-view-dashboard zmdi-hc-fw fa-fw"></i> <span class="hide-menu">
                                    Home </span></a></li>
                        <li> <a href="/karyawan/manage-pengajuan-cuti" class="waves-effect "><i
                                    class="zmdi zmdi-settings zmdi-hc-fw fa-fw"></i> <span class="hide-menu"> Cuti
                                    Tahunan </span></a></li>
                        <li> <a href="/karyawan/cuti-non-tahunan" class="waves-effect "><i
                                    class="zmdi zmdi-settings zmdi-hc-fw fa-fw"></i> <span class="hide-menu"> Cuti
                                    Diluar Cuti Tahunan </span></a></li>
                    @endif

                </ul>
            </div>
        </div>
        <!-- Left navbar-header end -->
        <!-- Page Content -->
        <div id="page-wrapper">
            @yield('konten')
            <footer class="footer text-center"> {{ date('Y') }} &copy; by Angga </footer>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="{{ URL::asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ URL::asset('bootstrap/dist/js/tether.min.js') }}"></script>
    <script src="{{ URL::asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js') }}"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="{{ URL::asset('plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js') }}"></script>
    <!--slimscroll JavaScript -->
    <script src="{{ URL::asset('js/jquery.slimscroll.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ URL::asset('js/waves.js') }}"></script>
    <!--weather icon -->
    <script src="{{ URL::asset('plugins/bower_components/skycons/skycons.js') }}"></script>
    <!--Counter js -->
    <script src="{{ URL::asset('plugins/bower_components/waypoints/lib/jquery.waypoints.js') }}"></script>
    <script src="{{ URL::asset('plugins/bower_components/counterup/jquery.counterup.min.js') }}"></script>
    <!--Morris JavaScript -->
    <script src="{{ URL::asset('plugins/bower_components/raphael/raphael-min.js') }}"></script>
    <script src="{{ URL::asset('plugins/bower_components/morrisjs/morris.js') }}"></script>
    <!-- Custom Theme JavaScript -->
    <script src="{{ URL::asset('js/custom.min.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard4.js') }}"></script>
    <!-- Sparkline chart JavaScript -->
    <script src="{{ URL::asset('plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/bower_components/jquery-sparkline/jquery.charts-sparkline.js') }}"></script>
    <script src="{{ URL::asset('plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <!-- end - This is for export functionality only -->
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
            $(document).ready(function() {
                var table = $('#example').DataTable({
                    "columnDefs": [{
                        "visible": false,
                        "targets": 2
                    }],
                    "order": [
                        [2, 'asc']
                    ],
                    "displayLength": 25,
                    "drawCallback": function(settings) {
                        var api = this.api();
                        var rows = api.rows({
                            page: 'current'
                        }).nodes();
                        var last = null;

                        api.column(2, {
                            page: 'current'
                        }).data().each(function(group, i) {
                            if (last !== group) {
                                $(rows).eq(i).before(
                                    '<tr class="group"><td colspan="5">' + group +
                                    '</td></tr>'
                                );

                                last = group;
                            }
                        });
                    }
                });

                // Order by the grouping
                $('#example tbody').on('click', 'tr.group', function() {
                    var currentOrder = table.order()[0];
                    if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                        table.order([2, 'desc']).draw();
                    } else {
                        table.order([2, 'asc']).draw();
                    }
                });
            });
        });
        $('#example23').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    </script>
    <!--Style Switcher -->
    <script src="{{ URL::asset('plugins/bower_components/styleswitcher/jQuery.style.switcher.js') }}"></script>
</body>

</html>
