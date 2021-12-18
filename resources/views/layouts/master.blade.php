<!doctype html>

<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="description" content="Laravel assessment task"/>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:type" content="website" />

    <title>Laravel Assessment</title>
    <link rel="canonical" href="{{url()->current()}}"/>
    <link rel="shortcut icon" href="{{ url('images/favicon.png') }}">
    <link rel="icon" href="{{ url('images/favicon.png') }}" type="image/x-icon">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @stack('css-stack')
</head>
<body>
<div class="container">
    @include('partials.navigation')
    @yield('content')
    @include('partials.footer')
</div>

@yield('scripts')

@stack('js-stack')
</body>
</html>
