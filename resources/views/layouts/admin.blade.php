<!doctype html>
<html>
<head>
    @include('includes.admin.head')
</head>
<body>

    <header>
        @include('includes.admin.header')
    </header>
    @include('includes.admin.nav')
    <div class="admin container">
    <div id="main" class="row">

        @yield('content')

    </div>

    <footer class="row">
        @include('includes.admin.footer')
    </footer>
</div>
</body>
</html>