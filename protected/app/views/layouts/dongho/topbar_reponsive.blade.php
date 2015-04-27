{{--*/ $menus = SiteHelpers::menus('top') /*--}}
<div class="list-group panel"> 
            @foreach ($menus as $menu)
                <a target="_self" class="list-group-item-stmenu"
                @if($menu['menu_type'] =='external')
                    href="{{ URL::to($menu['url'].$menu['module'])}}" 
                @else
                    href="{{ URL::to($menu['module'])}}" 
                @endif>
                    {{$menu['menu_name']}}
                </a>
                @if(count($menu['childs']) > 0 )
                	<a href="#menu_71" data-toggle="collapse" class="arrow-sub">
				          <i class="fa fa-angle-down"></i>
				    </a>
                @endif
                @if(count($menu['childs']) > 0)
                     <div class="collapse" id="menu_71">
                        @foreach ($menu['childs'] as $menu2)
                        	
                            <a target="_self" class="list-group-item-stmenu sub"
                                @if($menu['menu_type'] =='external')
                                    href="{{ URL::to($menu2['url'].$menu['module'])}}" 
                                @else
                                    href="{{ URL::to($menu2['module'])}}" 
                                @endif
                                            
                            >
                            <i class="fa fa-angle-right"></i>
                                 {{$menu2['menu_name']}}
                            </a>
                            @if(count($menu2['childs']) > 0)
                            	<a href="#menu_72" target="_self" data-toggle="collapse" class="arrow-sub">
							          <i class="fa fa-angle-down"></i>
							    </a>
                            @endif
                            @if(count($menu2['childs']) > 0)
                            <div class="collapse" id="menu_72">
                                @foreach($menu2['childs'] as $menu3)
                                	
                                        <a  target="_self" class="list-group-item-stmenu subsub"
                                            @if($menu['menu_type'] =='external')
                                                href="{{ URL::to($menu3['url'].$menu['module'])}}" 
                                            @else
                                                href="{{ URL::to($menu3['module'])}}" 
                                            @endif
                                        >
                                        <i class="fa fa-angle-right"></i>
                                            {{$menu3['menu_name']}}
                                        </a>
                                @endforeach
                            </div>
                            @endif                          
                        @endforeach
                    </div>
                @endif
        @endforeach  
      </div>
