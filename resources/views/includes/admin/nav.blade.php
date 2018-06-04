<sidebar class="navbar">

            <ul class="nav navbar-nav">
                <li class="{{ Request::is('admin') ? 'active' : '' }}"><a href="{{ url('/admin') }}">Home</a></li>
                <li class="{{ Request::is('admin/users*') ? 'active' : '' }}"><a href="{{ url('/admin/users') }}">Admin Users</a></li>
                <li class="{{ Request::is('admin/department*') ? 'active' : '' }}"><a href="{{ url('/admin/departments') }}">Departments</a></li>
                <li class="{{ Request::is('admin/asset*') ? 'active' : '' }}"><a href="{{ url('/admin/assets') }}">Assets</a></li>
                <li class="{{ Request::is('admin/categor*') ? 'active' : '' }}"><a href="{{ url('/admin/categories') }}">Asset Categories</a></li>
                <li class="dropdown {{ Request::is('admin/locations*') ? 'active' : '' }}">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Locations <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ Request::is('admin/locations/building*') ? 'active' : '' }}"><a href="{{ url('/admin/locations/buildings') }}">Buildings</a></li>
                        <li class="{{ Request::is('admin/locations/region*') ? 'active' : '' }}"><a href="{{ url('/admin/locations/regions') }}">Regions</a></li>
                    </ul>
                </li>
                <li class="{{ Request::is('admin/specification*') ? 'active' : '' }}"><a href="{{ url('/admin/specifications') }}">Specifications</a></li>
                <li class="{{ Request::is('admin/bookings*') ? 'active' : '' }}"><a href="{{ url('/admin/bookings') }}">Bookings</a></li>

                <li class="dropdown {{ Request::is('admin/installer*') ? 'active' : '' }}">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Installers <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('/admin/installers') }}">Installers</a></li>
                        <li class="special"><a href="{{ url('/installers') }}">Installation Center </a></li>
                    </ul>
                </li>

                <li class="dropdown {{ Request::is('admin/user*') ? 'active' : '' }}">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Users <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        @if(config('globalSettings.user-approval'))
                            <li class="approval {{ Request::is('admin/user/approval*') ? 'active' : '' }}"><a href="{{ url('/admin/user/approval') }}">User Approval</a></li>
                        @endif
                            <li><a href="{{ url('/admin/user/users') }}">Users</a></li>
                    </ul>
                </li>

            </ul>
</sidebar>