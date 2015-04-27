{{--*/ $menus = SiteHelpers::menus('top') /*--}}
<nav id="nav">
        <ul class="nav navbar-nav default">
            @foreach ($menus as $menu)
             <li @if(count($menu['childs']) > 0 ) class="dropdown" @endif >
                <a level="1" target="_self"
                @if($menu['menu_type'] =='external')
                    href="{{ URL::to($menu['url'].$menu['module'])}}" 
                @else
                    href="{{ URL::to($menu['module'])}}" 
                @endif
             
                 @if(count($menu['childs']) > 0 ) class="dropdown-toggle" data-toggle="" @endif>
                    {{$menu['menu_name']}}
                </a> 
                @if(count($menu['childs']) > 0)
                     <ul class="dropdown-menu">
                        @foreach ($menu['childs'] as $menu2)
                         <li class=" 
                         @if(count($menu2['childs']) > 0) dropdown-submenu @endif
                         @if(Request::is($menu2['module']))  @endif">
                            <a tabindex="-1" target="_self"
                                @if($menu['menu_type'] =='external')
                                    href="{{ URL::to($menu2['url'].$menu2['module'])}}" 
                                @else
                                    href="{{ URL::to($menu2['module'])}}" 
                                @endif
                                            
                            >
                                 {{$menu2['menu_name']}}
                            </a> 
                            @if(count($menu2['childs']) > 0)
                            <ul class="dropdown-menu">
                                @foreach($menu2['childs'] as $menu3)
                                    <li @if(Request::is($menu3['module']))  @endif>
                                        <a 
                                            @if($menu['menu_type'] =='external')
                                                href="{{ URL::to($menu3['url'].$menu3['module'])}}" 
                                            @else
                                                href="{{ URL::to($menu3['module'])}}" 
                                            @endif                                      
                                        
                                        >
                                            {{$menu3['menu_name']}}
                                        </a>
                                    </li>   
                                @endforeach
                            </ul>
                            @endif                          
                            
                        </li>                           
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach  
            
               	                    
        </ul>
      </nav>