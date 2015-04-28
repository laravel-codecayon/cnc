{{--*/ $menus = SiteHelpers::menus('footer1') /*--}}
<ul class="column">
        	<h3>{{Lang::get("layout.news_event")}}</h3>          
        	@foreach ($menus as $menu)
				<li>
					<i class="fa fa-angle-right"></i>
					<a 
					@if($menu['menu_type'] =='external')
	                    href="{{ URL::to($menu['url'].$menu['module'])}}" 
	                @else
	                    href="{{ URL::to($menu['module'])}}" 
	                @endif 

	                title="{{$menu['menu_name']}}">
						{{$menu['menu_name']}}
					</a>
				</li>
			@endforeach

        </ul><!--column-->
