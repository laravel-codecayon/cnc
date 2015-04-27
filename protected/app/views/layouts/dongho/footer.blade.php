{{--*/ $menus = SiteHelpers::menus('footer') /*--}}
<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12"><!--$css_item,$box_width,$position,$num_item_row -->
		
	<h3>Bài viết xem nhiều</h3>
	<ul class="news-footer">
			@foreach ($menus as $menu)
				<li>
					<a 
					@if($menu['menu_type'] =='external')
	                    href="{{ URL::to($menu['url'].$menu['module'])}}" 
	                @else
	                    href="{{ URL::to($menu['module'])}}" 
	                @endif 

	                title="{{$menu['menu_name']}}">
						<span>{{$menu['menu_name']}}</span>
					</a>
				</li>
			@endforeach
	</ul>	
	</div>