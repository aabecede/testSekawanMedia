<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LOGIN</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets') }}/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    @include('baseLayout.customCss')
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>Sekawan</b>Media</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form method="post" id="formLogin">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" name="email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" name="password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            {{-- <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div> --}}
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="button" class="btn btn-primary btn-block" id="btnLogin">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <!-- /.login-card-body -->
            </div>
        </div>
        <!-- /.login-box -->

        <!-- jQuery -->
        <script src="{{ asset('assets') }}/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('assets') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('assets') }}/dist/js/adminlte.min.js"></script>
        @include('baseLayout.customJs')
        <script>
            $(document).on('click', '#btnLogin', function() {
                var this_form = $('#formLogin')
                var this_button = $(this)
                var data = this_form.serializeArray()
                var is_validated = customValidatorVJs({
                    button: this_button,
                    form: this_form
                })

                if (is_validated == true) {
                    $.ajax({
                        type: "POST",
                        url: `${BASE_URL}/login`,
                        data: data,
                        dataType: "json",
                        success: function(response) {

                            $('#main-page-loading').css('display', 'none')
                            $("#loading-button").remove()
                            $(this_button).attr('disabled', false)

                            if (response.code == 200) {
                                window.location.href = response.url
                            }
                        },
                        error: function(response) {

                            $('#main-page-loading').css('display', 'none')
                            $("#loading-button").remove()
                            $(this_button).attr('disabled', false)
                            // console.log(response.responseJSON.code)
                            if (response.responseJSON.code == 400) {
                                return validatorMessageJs({
                                    message: response.responseJSON.message
                                });
                            } else {
                                return swalTerjadiKesalahanServer()
                            }
                        }
                    });
                }
            })
        </script>
</body>

</html>
