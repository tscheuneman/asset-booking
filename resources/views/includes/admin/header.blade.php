 <div id="top">
     <div class="navTop">
         <div class="openSide">
             <span class="glyphicon glyphicon-menu-hamburger"></span>
         </div>
         <div class="logo">
             <span class="topHeader">
                 {{config('adminSettings.site-name')}}
             </span>
             <span class="headerTitDesc">
                 Admin
                 <span class="normalText">
                     @yield('title')
                 </span>
             </span>
         </div>
     </div>
     <div class="topNav">
         <a class="menuItem {{ Request::is('admin/settings*') ? 'active' : '' }}" href="{{ url('/admin/settings') }}">
             <span class="glyphicon glyphicon-cog"></span> Settings
         </a>
     </div>
 </div>