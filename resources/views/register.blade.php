<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{URL::asset('plugins/images/cuti (2).png')}}">
    <!-- Bootstrap Core CSS -->
    <link href="{{URL::asset('bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('plugins/bower_components/datatables/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css')}}" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="{{URL::asset('plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css')}}" rel="stylesheet">
    <!-- morris CSS -->
    <link href="{{URL::asset('plugins/bower_components/morrisjs/morris.css')}}" rel="stylesheet">
    <!-- animation CSS -->
    <link href="{{URL::asset('css/animate.css')}}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{URL::asset('css/style.css')}}" rel="stylesheet">
    
    <!-- color CSS -->
    <link href="{{URL::asset('css/colors/default.css')}}" id="theme" rel="stylesheet">
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
    <title>Register | E-cuti</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords"
        content="Login Form" />
    <!-- //Meta tag Keywords -->

    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!--/Style-CSS -->
    <link rel="stylesheet" href="css/style.css"  >
    <link href="css/style1.css" rel="stylesheet">
    <!--//Style-CSS -->

    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>

</head>

<body>
    
    <!-- form section start -->
    <section class="w2l-mockup-form">
        <div class="container">
            <!-- /form -->
            <div class="workinghny-form-grid">
                <div class="main-mockup">
                    <div class="alert-close">
                        <span class="fa fa-close"></span>
                    </div>
                    <div class="w2l_form align-self">
                        <div class="left_grid_info">
                            <img src="" alt="">
                        </div>
                    </div>
                    
                    <div class="content-wthree">
                        <h2>Register Now</h2>
                        <?php  ?>
                        <form class="form" action="/store-register" method="post">
                            @csrf
                            <input type="text" class="nama_karyawan" name="nama_karyawan" placeholder="Masukkan Nama" required>
                            <input type="text" class="nik" name="nik" placeholder="Masukkan NIK" required>
                            <input type="text" class="tanggal_lahir" name="tanggal_lahir" placeholder="Tanggal Mulai Bekerja" onblur="if(this.value==''){this.type='text'}" onfocus="(this.type='date')"required>
                            <input type="email" class="email" name="email" placeholder="Masukkan Email" required>
                            <input type="password" class="password" name="password" placeholder="Masukkan Password" required>
                            <input type="text" class="posisi" name="posisi" placeholder="Masukkan Jabatan" required>
                            <input type="text" name="unit" placeholder="Masukkan Unit Kerja" id="" required>
                            <br>
                            <button name="submit" class="btn" type="submit">Register</button>
                        </form>
                        <div class="social-icons">
                            <p>Have an account! <a href="/login">Login</a>.</p>
                        </div>
                    </div>
                    
                </div>
            </div>
            <!-- //form -->
        </div>
    </section>
    
    <!-- //form section start -->

    <script src="js/jquery.min.js"></script>
    <script>
        $(document).ready(function (c) {
            $('.alert-close').on('click', function (c) {
                $('.main-mockup').fadeOut('slow', function (c) {
                    $('.main-mockup').remove();
                });
            });
        });
    </script>

</body>

</html>