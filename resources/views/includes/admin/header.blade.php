 <div id="top">
     <div class="leftSide">
         <span class="topHeader">
             {{env('APP_NAME', 'Asset Booking App')}}
         </span><span class="headerTitDesc"> Admin <span class="normalText"> @yield('title')</span> </span>
     </div>
     <a href="#"><span class="rightHeader"> <span class="glyphicon glyphicon-cog"></span> {{Cas::user()}}</span></a>
 </div>