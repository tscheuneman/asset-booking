<meta charset="utf-8">
<meta name="description" content="">
<meta name="author" content="Thomas Scheuneman">

<title>{{env('APP_NAME', 'Asset Booking App')}} || @yield('title')</title>

<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<script src="{{ asset('js/app.js') }}"></script>

<meta name="viewport" content="width=device-width, initial-scale=1">
<meta content="{{csrf_token()}}" name="csrf-token" />
