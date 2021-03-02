<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verifikasi Email Anda | {{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
    <link rel="icon" href="{{ asset('logo.svg') }}" type="image/svg">
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
        article {
            background: #efefef;
        }
       
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <img src="{{ asset('logo.svg') }}" alt="">
                <article>
                    <h2>Selamat Datang {{ Auth::user()->username }}</h2>
                    <p>Sebuah link untuk mengaktifkan / memverifikasi akun Anda telah dikirimkan lewat email yang Anda daftarkan {{ Auth::user()->email }}. Silahkan cek Kotak masuk pada email tersebut. Jika tidak ada, coba cek di folder spam.</p>
                    <p>Jika belum menerima Email, klik tombol di bawah ini untuk meminta ulang link verifikasi</p>
                    <form action="{{ route('verification.send') }}" method="POST">
                        @csrf
                        <button class="btn btn-danger" type="submit">Kirim Ulang Email</button>
                    </form>
                    
                    <p>Salam hangat, <br> Admin Masudar,</p>
                </article>

            </div>
        </div>
    </div>
    
</body>
</html>