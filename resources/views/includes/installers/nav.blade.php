<sidebar class="navbar">
    <div class="navTop">
         <span class="topHeader">
             {{env('APP_NAME', 'Asset Booking App')}}
         </span><span class="headerTitDesc"> Installers </span>
    </div>

        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>


            <ul class="nav navbar-nav">
                <li class="{{ Request::is('installers') ? 'active' : '' }}"><a href="{{ url('/installers') }}">Home</a></li>
            </ul>
</sidebar>