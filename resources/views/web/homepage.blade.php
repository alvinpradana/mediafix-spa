<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Media Fix</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/fontawesome-all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/aos.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/swiper.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('admin/assets/images/logo-mf.jpg') }}">
</head>
<body>
        @include('web.layouts.navbar')

            <section class="about d-flex align-items-center text-light py-5" id="about">
                @include('web.pages.home')
            </section>
            <section class="services d-flex align-items-center py-5" id="services">
                @include('web.pages.services')
            </section>
            <section class="newsletter text-light py-5" id="contact">
                @include('web.pages.units')
            </section>

        @include('web.layouts.footer')

    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/purecounter.min.js') }}"></script>
    <script src="{{ asset('assets/js/swiper.min.js') }}"></script>
    <script src="{{ asset('assets/js/aos.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>
</html>