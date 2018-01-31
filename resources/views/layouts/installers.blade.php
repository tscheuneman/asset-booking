<!doctype html>
<html>
<head>
    @include('includes.installers.head')
</head>
<body>

<header>
    @include('includes.installers.header')
</header>
@include('includes.installers.nav')
<div class="container">
    <div id="main" class="row">

        @yield('content')

    </div>

    <footer class="row">

    </footer>
</div>
</body>
</html>