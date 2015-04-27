{{--*/ $menus = SiteHelpers::menus('top') /*--}}
    <ul id="main-menu">
        @foreach ($menus as $menu)
            <li>
                <a class="transition"
                @if($menu['menu_type'] =='external')
                    href="{{ URL::to($menu['url'].$menu['module'])}}" 
                @else
                    href="{{ URL::to($menu['module'])}}" 
                @endif
                >
                {{$menu['menu_name']}}
                </a>
            </li>
            <img src="{{ asset('sximo/themes/dongho/images/menu-sep.png')}}">
        @endforeach
    </ul><!--main-menu-->
