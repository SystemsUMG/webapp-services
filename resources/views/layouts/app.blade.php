<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" value="{{ csrf_token() }}" />
    <title>Control de Personal</title>
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('/img/logoRH.png') }}">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="{{ asset('/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('/css/nucleo-svg.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link id="pagestyle" href="{{ asset('/css/argon-dashboard.css?v=2.0.4') }}" rel="stylesheet" />
    @vite('resources/css/app.css')
    <style>
        .bg-light {
            background-color: #eae9e9 !important;
        }
    </style>
</head>

<body>
    <div id="app"></div>
    @vite('resources/js/app.js')
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="{{ asset('/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/smooth-scrollbar.min.js') }}"></script>
</body>

</html>
