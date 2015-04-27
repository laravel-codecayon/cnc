{{--*/ $menus = SiteHelpers::menus('top') /*--}}
<ul>
        @foreach ($menus as $menu)
            <li>
                <a
                @if($menu['menu_type'] =='external')
                    href="{{ URL::to($menu['url'].$menu['module'])}}" 
                @else
                    href="{{ URL::to($menu['module'])}}" 
                @endif
                >
                {{$menu['menu_name']}}
                </a>
            </li>
        @endforeach
    </ul>
