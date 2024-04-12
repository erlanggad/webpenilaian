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
    <title>Login | E-Cuti</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords"
        content="Login Form" />
    <!-- //Meta tag Keywords -->

    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <!--/Style-CSS -->
    <link rel="stylesheet" href="css/style1.css" type="text/css" media="all" />
    <!--//Style-CSS -->

    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>

</head>

<body>
 <!-- Modal -->
  <!-- Modal -->

<div id="modalotp" class="modal fade" role="dialog" >
    <div class="modal-dialog modal-md modal-dialog-centered" style="margin-top:250px ">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header bg-warning py-4" style="background-color: #499DB1 !important">
          <h4 class="modal-title text-light">Verifikasi Kode OTP</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body bg-light">
              <div class="form-group">
                  <label for="otp">Masukkan Kode OTP</label>
                  <input id="otp"class="form-control" type="number" name="otp" id="otp" autofocus="" min="0">
                  <div class="red" id="redotp" style="color: red; display:none;"><b>Kode OTP Salah!</b></div>
                  *Masukkan kode OTP yang telah dikirim ke email anda
              </div>


              <div class="form-group">
              <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4" onclick="confirmotp()">
               Konfirmasi
              </button>
              </div>

              <center id="kirimotp" style="display:none;">
              <div class="form-group">
              <a  class="btn-lg btn-block" style="font-size:14px; cursor:pointer;" tabindex="4" onclick="kirimotp()">
                Kirim Ulang Kode OTP
              </a>
              </div>
              </center>

              <div class="mt-2 text-muted text-center" id="containercounter">
                   Mohon tunggu dalam <span id="counterotp">60</span> detik untuk kirim ulang kode otp
              </div>
        </div>
        </div>
       </div>
    </div>
  </div>

    <!-- form section start -->
    <section class="w3l-mockup-form">
        <div class="container">
            <!-- /form -->
            <div class="workinghny-form-grid">
                <div class="main-mockup">

                    <div class="w3l_form align-self">
                        <div class="left_grid_info">
                            <img src="" alt="">
                        </div>
                    </div>
                    <div class="content-wthree">
                        <center><h2>Forgot Password</h2></center>
                        <form id="loginform" action="/forgot-password-action" method="post">
                            @csrf
                            @if (session('email'))
                            <div class="red"  style="color: red"><b>Akun tidak ditemukan!</b></div>
                            @endif

                            <input type="email" class="email" name="email" placeholder="Masukkan Email" required id="email">
                            <button name="submit" name="submit" class="btn" type="submit">Submit</button>

                        </form>

                    </div>
                </div>
            </div>
            <!-- //form -->
        </div>
    </section>
    <!-- //form section start -->

    <script src="js/jquery.min.js"></script>

    <script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="bootstrap/dist/js/tether.min.js"></script>
    <script src="bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="js/custom.min.js"></script>
    <!--Style Switcher -->
    <script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>

    <script>

        var email = ""
        @if (Session::has('showmodal'))
                    email = "{{ Session::get('showmodal') }}";
                    $(document).ready(function() {
                        $("#modalotp").modal("show");
                    });
                @endif

                var count = 60, timer = setInterval(function() {
    $("#counterotp").html(count--);
    if(count == -1) {
        clearInterval(timer);
        $("#kirimotp").css("display", "");
        $("#containercounter").css("display", "none");
    }
    }, 1000);


    function kirimotp() {
      $.ajax({
      url: '/forgot-password-action',
      data: {email : email},
      dataType:'json',
      success:function(data){
      }
      });
    }

    function confirmotp() {
      let otp = $("#otp").val();
      $.ajax({
      url: '/verify-otp-action',
      data: {otp : otp},
      dataType:'json',
      success:function(data){
        if (data.status == 1) {
            window.location.href = "{{ url('/') }}" + "/reset-password?otp="+otp+"&email="+email;
        } else {
            $("#redotp").css("display", "");
        }
      }
      });
    }
                // $(document).ready(function (c) {
                //     $('.alert-close').on('click', function (c) {
                //         $('.main-mockup').fadeOut('slow', function (c) {
                //             $('.main-mockup').remove();
                //         });
                //     });
                // });
            </script>

</body>

</html>
