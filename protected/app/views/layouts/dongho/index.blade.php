<!DOCTYPE HTML>
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo isset($page['pageTitle']) ? $page['pageTitle'] : CNF_APPNAME ;?></title>
<meta name="keywords" content="{{ CNF_METAKEY }}">
<meta name="description" content="{{ CNF_METADESC }}"/>
<link rel="shortcut icon" href="{{ URL::to('')}}/logo.ico" type="image/x-icon">
<meta property="og:title" content="<?php echo isset($page['pageTitle']) ? $page['pageTitle'] : CNF_APPNAME ;?>" />
<meta property="og:url" content="{{$page['detail_url']}}" />
<meta property="og:description" content="{{$page['description']}}" />
<meta property="og:image" content="{{$page['image']}}" />
<meta property="og:width" content="{{$page['width']}}" />
<meta property="og:height" content="{{$page['height']}}" />
{{ HTML::style('sximo/themes/dongho/css/bootstrap.min.css')}}
{{ HTML::style('sximo/themes/dongho/css/bootstrap-theme.min.css')}}
{{ HTML::style('sximo/themes/dongho/css/font-awesome.css')}}
{{ HTML::style('sximo/themes/dongho/css/slick.css')}}
{{ HTML::style('sximo/themes/dongho/css/jquery.mCustomScrollbar.css')}}
{{ HTML::style('sximo/themes/dongho/fonts/font.css')}}
{{ HTML::style('sximo/themes/dongho/css/animate.css')}}
{{ HTML::style('sximo/themes/dongho/css/style.css')}}

{{ HTML::script('sximo/themes/dongho/js/jquery-2.1.1.min.js') }}
{{ HTML::script('sximo/themes/dongho/js/slidereveal.js') }}
{{ HTML::script('sximo/themes/dongho/js/jquery.mCustomScrollbar.concat.min.js') }}
{{ HTML::script('sximo/themes/dongho/js/bootstrap.min.js') }}
{{ HTML::script('sximo/themes/dongho/js/slick.min.js') }}
{{ HTML::script('sximo/themes/dongho/js/viewportchecker.js') }}
{{ HTML::script('sximo/themes/dongho/js/bootstrap.youtubepopup.js') }}
{{ HTML::script('sximo/themes/dongho/js/layout.js') }}

</head>

<body>
<div id="hide-menu" class="hide-menu"><!-- --></div>
<div id="menu-slide" class="menu-slide" style="position: fixed; width: 250px; transition: all 600ms ease; -webkit-transition: all 600ms ease; height: 100%; top: 0px; right: -250px;">
    <div><a href="{{URL::to('')}}"><img src="{{ asset('sximo/themes/dongho/images/logo.png')}}"></a></div>
    @include('layouts/dongho/rightbar')<!--main-menu-->
</div>
<!-- Modal -->
<div class="modal fade" id="seach-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content clearfix">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <form method="get" action="{{URL::to('')}}/home/search">
            <input name="key" type="text" placeholder="Tìm kiếm" class="form-control search-input">
            <button type="submit" class="btn btn-success search-submit"><i class="fa fa-search"></i></button>
        </form>
    </div>
  </div>
</div>
<div id="header" @if($menu == 'index') class="home" @endif>
    <div class="container animated fadein">
        <div id="logo"><a href="{{URL::to('')}}"><img src="{{ asset('sximo/themes/dongho/images/logo.png')}}"></a></div>
        <div class="header-right">
            <div class="language dropdown">
                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                        <?php 
                            $lang = Session::get('lang') == '' ? CNF_LANG : Session::get('lang');
                            echo $lang == "vi" ? 'Vietnamese' : 'English';
                            $lang_diff = $lang == "vi" ? 'en' : 'vi';
                        ?>
                <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="{{URL::to('home/lang')}}/{{$lang_diff}}"><?php echo $lang == "vi" ? 'English' : 'Vietnamese'; ?></a></li>
                </ul>
            </div>
            <div class="consulting"><span>(08) 62 699 699</span><p>Free consulting</p></div>
            <div class="navigator">        
                <a href="{{URL::to('contact-us.html')}}"><i class="fa fa-envelope"></i></a>
                <a href="#" class="show-slide-menu"><i class="fa fa-navicon"></i></a>
                <a href="#" data-toggle="modal" data-target="#seach-popup"><i class="fa fa-search"></i></a>
            </div><!-- navigator -->
        </div><!-- header-right -->
    </div>
    @include('layouts/dongho/topbar')<!--main-menu-->
    @if($menu == 'index')
    @include('layouts/dongho/slidemenu')
    @endif
</div><!--header-->
<div id="breadcumbs" @if($menu == 'index') class="home" @endif>
    <ol class="breadcrumb container">
        {{$page['brc']}}
    </ol>
</div><!-- breadcumbs -->
<div id="body-content">

    {{$content}}
        
        @include('layouts/dongho/product_hot')
        
        
    </div><!-- home-page -->
     

</div><!-- body-content -->
<div id="bottom">
    <div class="container">
    Follow us on :
    @if( CNF_fb != '')
    <a href="{{CNF_fb}}"><i class="fa fa-facebook-square"></i></a>
    @endif
    @if(CNF_tw != '')
    <a href="{{CNF_tw}}"><i class="fa fa-twitter-square"></i></a>
    @endif
    @if( CNF_gg != '')
    <a href="{{CNF_gg}}"><i class="fa fa-google-plus-square"></i></a>
    @endif
    @if(CNF_in != '')
    <a href="{{CNF_in}}"><i class="fa fa-linkedin-square"></i></a>
    @endif
    @if( CNF_pi != '')
    <a href="{{CNF_pi}}"><i class="fa fa-pinterest-square"></i></a>
    @endif
    @if( CNF_yt != '')
    <a href="{{CNF_yt}}"><i class="fa fa-youtube-square"></i></a>
    @endif
    </div>
</div><!-- bottom -->
<div id="footer">
    <div class="container">
        @include('layouts/dongho/footer')
        
        @include('layouts/dongho/footer1')
        @include('layouts/dongho/footer2')
        {{CNF_FOOTER}}<!--column-->
        <div class="column"><img src="{{ asset('sximo/themes/dongho/images/logo-footer.png')}}"></div>
    </div>
</div><!-- footer -->


</body></html>