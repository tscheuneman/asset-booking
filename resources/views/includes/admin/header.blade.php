 <div id="top">
     <div class="navTop">
         <div class="openSide">
             <span class="glyphicon glyphicon-menu-hamburger"></span>
         </div>

         <span class="topHeader">
             {{env('APP_NAME', 'Asset Booking App')}}
         </span><span class="headerTitDesc"> Admin <span class="normalText"> @yield('title')</span> </span>
     </div>
     <a href="/admin/settings"><span class="rightHeader"> <span class="glyphicon glyphicon-cog"></span> {{Cas::user()}}</span></a>
 </div>