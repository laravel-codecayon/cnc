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
<script>
$(document).ready(function() {
	
	//$("body").css("display", "none");
	$("body").addClass('animated');
    $("body").addClass('fadeInRight');
		
});
</script>
</head>

<body>
<div id="hide-menu" class="hide-menu"><!-- --></div>
<div id="menu-slide" class="menu-slide">
	<div><a href="#"><img src="images/logo.png"></a></div>
	<ul>
    	<li class="home"><a href="#">Home</a></li>
        <li class="about"><a href="#">About us</a></li>
        <li class="services"><a href="#">Services</a></li>
        <li class="news"><a href="#">News & Events</a></li>
        <li class="contact"><a href="#">Contact us</a></li>
    </ul><!--main-menu-->
</div>
<!-- Modal -->
<div class="modal fade" id="seach-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content clearfix">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<form>
            <input type="text" placeholder="Tìm kiếm" class="form-control search-input">
            <button type="submit" class="btn btn-success search-submit"><i class="fa fa-search"></i></button>
      	</form>
  	</div>
  </div>
</div>
<div id="header" class="detail-page">
	<div class="container">
        <div id="logo"><a href="{{URL::to('')}}"><img src="{{ asset('sximo/themes/dongho/images/logo-footer.png')}}"></a></div>
    </div>    
</div><!--header-->
<div id="body-content" class="container detail-page">
     <div class="navigator-detail-page clearfix">
     	<a href="{{URL::to('news.html')}}" class="close-button"></a>
     	@if($page['pre'] != '')
        <a href="{{$page['pre']}}" class="prev-button"><i class="fa fa-angle-left"></i></a>
        @endif
        @if($page['next'] != '')
        <a href="{{$page['next']}}" class="next-button"><i class="fa fa-angle-right"></i></a>
        @endif
     </div>
     <div class="single-post">
     	{{$content}}
     </div><!-- content -->
    
</div><!-- body-content -->
</body>
</html>