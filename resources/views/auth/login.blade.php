<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login | {{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('logo.svg') }}" type="image/svg">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/adminty/bower_components/bootstrap/css/bootstrap.min.css') }}">
    <!-- feather Awesome -->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/adminty/assets/icon/feather/css/feather.css') }}">
    <!-- notify js Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/pnotify/css/pnotify.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/pnotify/css/pnotify.brighttheme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/pnotify/css/pnotify.buttons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/pnotify/css/pnotify.history.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/pnotify/css/pnotify.mobile.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/notify.css') }}">
    <!-- Style.css -->
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/adminty/assets/css/style.css') }}">

    <style>
        body {
            background-image: url('/images/login-bg.png');
        }
        .input-group span {
            position: absolute;
            right: 5px;
            z-index: 100;
            height: 100%;
            /* background: pink; */
            display: flex;
            align-items: center;
        }
        .img-logo {
            /* position: relative; */
            margin: auto;
            width: 50px;
            filter:drop-shadow(0,0, 10px, rgba(0,0,0,1));
        }
    </style>
</head>
<body style="height: 100vh;">

        <div class="row align-items-center h-100" >
            <div class="col-sm-4 m-auto" >
                <div class="card my-auto">
                    <div class="card-header text-center bg-info py-3">
                        <img src="{{ asset('logo.svg') }}" alt="Tutwuri" class="img-logo">
                        <h3 class="text-center my-0">{{ config('app.name') }}</h3>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title"><i class="feather icon-lock"></i> Login</h4>
                        <form action="{{ route('authenticate') }}" method="POST" class="form" id="login-form">
                            @csrf()
                            <div class="form-group">
                                <label for="userid">Username</label>
                                <div class="input-group">
                                    <input type="text" name="username" placeholder="Username" class="form-control">
                                    <span>
                                        <i class="feather icon-user"></i>
                                    </span>
                                </div>
                                @error('username')
                                    <span class="alert-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="input-group">
                                    <input type="password" name="password" placeholder="*****" class="form-control">
                                    <span>
                                        <i class="feather icon-eye-off"></i>
                                    </span>
                                </div>
                                @error('password')
                                    <span class="alert-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="form-group mt-4 mb-4 col-sm-12">
                                    <div class="captcha d-flex">
                                        <span style="min-width:29%;">{!! captcha_img() !!}</span>
                                        <button type="button" class="btn btn-success" class="reload" id="reload">
                                            ↻
                                        </button>
                                        <input id="captcha" type="text" class="form-control" placeholder="Jawaban Anda" name="captcha" >
                                    </div>
                                    @error('captcha')
                                        <span class="alert-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
        
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    {{-- <div class="checkbox-fade fade-in-primary d-"> --}}
                                        <label>
                                            <input type="checkbox" name="remember_me">
                                            {{-- <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span> --}}
                                            <span class="text-inverse">Ingat saya</span>
                                        </label>
                                    {{-- </div> --}}
                                    <div class="forgot-phone text-right f-right">
                                        <a href="{{ route('forgot-password') }}" class="text-right f-w-600"> Lupa Password?</a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-12">
                                <button class="btn btn-primary btn-block">Masuk</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <p class="text-white text-right">Belum memiliki akun? <a href="{{ route('register') }}" style="text-decoration: underline;color: orange;">Daftar di sini</a></p>
            </div>
           {{-- @error('db_error')
                {{ $message }}
           @enderror --}}
        </div>

        <script type="text/javascript" src="{{ asset('vendors/adminty/bower_components/jquery/js/jquery.min.js') }}"></script>
        <!-- pnotify js -->
        <script type="text/javascript" src="{{ asset('vendors/pnotify/js/pnotify.js') }}"></script>
        <script type="text/javascript" src="{{ asset('vendors/pnotify/js/pnotify.desktop.js') }}"></script>
        <script type="text/javascript" src="{{ asset('vendors/pnotify/js/pnotify.buttons.js') }}"></script>
        <script type="text/javascript" src="{{ asset('vendors/pnotify/js/pnotify.confirm.js') }}"></script>
        <script type="text/javascript" src="{{ asset('vendors/pnotify/js/pnotify.callbacks.js') }}"></script>
        <script type="text/javascript" src="{{ asset('vendors/pnotify/js/pnotify.animate.js') }}"></script>
        <script type="text/javascript" src="{{ asset('vendors/pnotify/js/pnotify.history.js') }}"></script>
        <script type="text/javascript" src="{{ asset('vendors/pnotify/js/pnotify.mobile.js') }}"></script>
        <script type="text/javascript" src="{{ asset('vendors/pnotify/js/pnotify.nonblock.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/notify.js') }}"></script>
        @if (session('status'))
            <script>
                new PNotify({
                        title: 'Info',
                        text: 'Pendaftaran berhasil. Silahkan Login dan cek Kotak masuk email Anda untuk verifikasi.',
                        type: 'info'
                    })
            </script>
        @endif
        @error('db_error')
            <script>
                new PNotify({
                    title: "Error",
                    text: "{{ $message }}",
                    type: "error"
                })
            </script>
        @enderror
        <script>
            $(document).ready(function(){
                var passwordField = $('input[name="password"]')
                passwordField.siblings('span').click(function(){
                    $(this).find('i').toggleClass('icon-eye icon-eye-off')
                    passwordField.prop('type', passwordField.prop('type') == 'password' ? 'text' : 'password')
                })

                $('#reload').click(function () {
                    $.ajax({
                        type: 'GET',
                        url: 'reload-captcha',
                        success: function (data) {
                            $(".captcha span").html(data.captcha);
                        }
                    });
                });
            })
        </script>
</body>
</html>