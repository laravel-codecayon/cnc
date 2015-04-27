<!DOCTYPE html>
<html lang="en">
<title><?php echo isset($page['pageTitle']) ? $page['pageTitle'].' | '.$page['pageNote']. " | ". CNF_APPNAME : CNF_APPNAME ;?></title>
<!-- Mirrored from demot103.web4s.vn/ by HTTrack Website Copier/3.x [XR&CO'2013], Thu, 12 Mar 2015 10:05:24 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
   
    <!-- Favicon --> 
	<meta name="keywords" content="{{ CNF_METAKEY }}">
    <meta name="description" content="{{ CNF_METADESC }}">
    <link rel="shortcut icon" href="{{ URL::to('')}}/images.ico" type="image/x-icon">
        <!-- Bootstrap -->
    {{ HTML::style('sximo/themes/dongho/css/bootstrap.min.css')}}
    <!-- Font Awesome -->
    {{ HTML::style('sximo/themes/dongho/css/font-awesome.min.css')}}
	<!-- Style -->
    {{ HTML::style('sximo/themes/dongho/css/reset.css')}}
    {{ HTML::style('sximo/themes/dongho/css/style.css')}}
    <!-- Style Responsive -->
    {{ HTML::style('sximo/themes/dongho/css/style-responsive.css')}}
    <!-- owl Slider -->
    {{ HTML::style('sximo/themes/dongho/css/slider.css')}}
    <!-- SLIDER REVOLUTION Main Slider -->
    {{ HTML::style('sximo/themes/dongho/css/captions.css')}}
    {{ HTML::style('sximo/themes/dongho/css/settings.css')}}
    {{ HTML::style('sximo/themes/dongho/css/magnific-popup.css')}}
    {{ HTML::style('sximo/themes/dongho/css/slider.css')}}
    <!--<link href="profiles/demot103web4svn/cache/custom.css" rel="stylesheet">-->
    <!-- Load jQuery Library -->
     {{ HTML::script('sximo/themes/dongho/js/jquery-1.11.min.js') }}
    {{ HTML::script('sximo/themes/dongho/js/owl.carousel.js') }}
    {{ HTML::script('sximo/themes/dongho/js/jquery.validate.js') }}
    {{ HTML::script('sximo/themes/dongho/js/bootstrap.min.js') }}
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
        
</head>
@if(Session::has('customer'))
     {{--*/ $ses_cus = Session::get('customer'); /*--}}               
@else
    {{--*/ $ses_cus = ''; /*--}}
@endif
<body>
    <script type="text/javascript">
        var link_home = "{{URL::to('')}}";
    </script>
    {{ HTML::script('sximo/themes/dongho/js/my.js') }}
    <div id="st-container" class="st-container">
        <div class="st-pusher">
            <nav class="st-menu st-effect-3" id="cssmenu-st">
	<form class="search"  action="{{URL::to('')}}/tim-kiem.html" method="get">
        <input type="text" name="key" placeholder="Từ khóa tìm kiếm..." class="search_query">
        <span><i class="fa fa-search fa-lg"></i></span>
    </form>
        @include('layouts/dongho/topbar_reponsive')
</nav><!-------Menu reponsive--->




	
            <div class="st-content"><!-- this is the wrapper for the content -->
                <div class="st-content-inner">
                    <div class="main clearfix">
                    	<!--begin top-->
                        @if(Session::has('message'))
                           {{ Session::get('message') }}
                            <script>
                                $(document).ready(function(){       
                                    setTimeout(function(){
                                        $('.noti-done,.noti-error,.noti-info').hide();
                                    }, 5000);               
                                });
                            </script>
                      @endif
                    	<!--icon menu su dụng trong giao diện mobile-->
<div id="st-trigger-effects" class="column hidden-lg hidden-md">
	<button data-effect="st-effect-3">
	    <i class="fa fa-bars fa-lg"></i>
	</button>
</div>
<!--icon menu su dụng trong giao diện mobile-->
<section id="topheader">
    <section id="topbar">
		<div class="container">
			<div class="row">
             <!--start popup login modal fade -->
            @if($ses_cus == '')
                @include('layouts/dongho/popup_login')
            @endif
                                  
                                <!--end popup login--> 
				<!-- end col -->
				<!-- start col -->
				<div class="col-lg-9 col-md-9 col-sm-6 col-xs-12 hidden-xs hidden-sm header-right">
					<div class="welcome pull-right">
						<ul class="links pull-right">
                            @if($ses_cus == '')
                                                <li>
                            <a href="#login" class="btn btn-primary btn-lg popup-with-zoom-anim">
                            <i class="fa fa-user"></i>&nbsp;Đăng nhập                            </a>
                        </li> 
                                                
                        
                                                <li>                        
                            <a href="{{URL::to('')}}/dang-ky.html">
                            <i class="fa fa-user"></i>&nbsp;Tạo tài khoản                            </a>
                        </li> 
                                                                    
                  			@else
                            <li>                        
                            <a href="{{URL::to('')}}/thong-tin-thanh-vien.html">
                            <i class="fa fa-user"></i>&nbsp;Quản lý tài khoản                            </a>
                        </li>
                        <li>                        
                            <a href="{{URL::to('')}}/home/logout">
                            <i class="fa fa-user"></i>&nbsp;Đăng xuất                          </a>
                        </li>
                            @endif
                		</ul>
					</div>
                    <ul class="hidden-sm hidden-xs links pull-right">
                        @if($ses_cus != '')
                        <li>
                            <a href="{{URL::to('')}}/yeu-thich.html">
                                <i class="fa fa-heart"></i>&nbsp;Yêu thích
                            </a>
                        </li>                         
                                
                        @endif
                        <li>
                                {{--*/ $num_cart = SiteHelpers::getNumcart(); /*--}}
                            <a href="{{URL::to('')}}/gio-hang-cua-toi.html">
                                <i class="fa fa-shopping-cart"></i>&nbsp; Giỏ hàng(<font id="num-cart">{{$num_cart}}</font>)
                            </a>
                        </li>
                        <li>
                            <a href="van-chuyen-hang.html">
                                <i class="fa fa-outdent"></i>&nbsp;Thanh toán                            </a>
                        </li>
                    </ul>
				</div>
				<!-- end col -->
				<!-- start col -->
				<div class="show-mobile hidden-lg hidden-md pull-right">
					<!-- start quick-user -->
					<div class="quick-user pull-left">
                		<div class="quickaccess-toggle"> 
                			<i class="fa fa-user"></i>
                		</div>
                		<div class="inner-toggle">
                  			<div>
                    			<ul class="links pull-right">
                                    @if($ses_cus == '')
                      				                                             <li>
                                             <a href="#login" class="popup-with-zoom-anim">
                                            <i class="fa fa-user"></i>&nbsp;Đăng nhập                                              </a>
                                            </li> 
                                                             			
                                       
                                                                                            <li>
                                           
                                                <a href="{{URL::to('')}}/dang-ky.html">
                                                        <i class="fa fa-user"></i>&nbsp;Tạo tài khoản                                                </a>
                                                </li> 
                                    
                                    @else
                                        
                                        <li>
                                           
                                                <a href="{{URL::to('')}}/thong-tin-thanh-vien.html">
                                                        <i class="fa fa-user"></i>&nbsp;Quản lý tài khoản                                                </a>
                                                </li>
                                                <li>
                                                <a href="{{URL::to('')}}/home/logout">
                                                        <i class="fa fa-user"></i>&nbsp;Đăng xuất                                              </a>
                                                </li>
                                    @endif
                    			</ul>
                  			</div>
                		</div>
              		</div>
              		<!-- end quick-user -->
              		<!-- start quick-access -->
					<div class="quick-access pull-left">
                		<div class="quickaccess-toggle"> 
                			<i class="fa fa-navicon"></i> 
                		</div>
               			<div class="inner-toggle">
	                    	<ul class="links pull-left">
                                @if($ses_cus != '')
                                <li>
                			<a href="{{URL::to('')}}/yeu-thich.html">
        	            		<i class="fa fa-heart"></i>&nbsp;Yêu thích
		                    </a>
                		</li>                         
                                
		                <li>
                			<a href="{{URL::to('')}}/thong-tin-thanh-vien.html">
		                    	<i class="fa fa-user"></i>&nbsp;Quản lý tài khoản		                    </a>
                		</li>
                                @endif
                		<li>
                			<a href="{{URL::to('')}}/gio-hang-cua-toi.html">
								<i class="fa fa-shopping-cart"></i>&nbsp; Giỏ hàng		                    </a>
                		</li>
                		<li>
                			<a href="van-chuyen-hang.html">
                    			<i class="fa fa-outdent"></i>&nbsp;Thanh toán		                    </a>
        		        </li>
                  			</ul>
                		</div>
              		</div>
					<!-- end quick-access -->
              		<!-- start quick-access -->
					<div class="quick-access pull-left">
                                  		</div>
					<!-- end quick-access -->
					<!-- start quick-access -->
              		<!-- end quick-access -->
				</div>
				<!-- end col -->
			</div>
		</div>
	</section>
</section>				  
                                     
                        <section class="row-section top-logo top-search " style='  '><div class="container"><div class="row"><div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"><h1 class="logo">
    <a title="" href="{{URL::to('')}}">
        <img alt="" style="max-width: 100%; max-height:100%" src="{{URL::to('')}}/donghomodel.png"/>
    </a>     
</h1>
</div><div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"><div class="header-right hidden-sm hidden-xs">                    
        
    <form class="search-header"  action="{{URL::to('')}}/tim-kiem.html" method="get">
		<input type="text" name="key" placeholder="Từ khóa tìm kiếm...">
		<input type="submit" value="">
    </form>
</div>


</div></div></div></section><section class="row-section top-menu " style='background:#D50133 !important;  '><div class="container">		<div class="hidden-sm hidden-xs">
       @include('layouts/dongho/topbar')
    </div>
    
<script>
	$(document).ready(function(){
		var url=document.URL;
		
		$("a[href='"+url+"'][level='"+1+"']").addClass('active');
	});	
</script>

</div></section>
    @include('layouts/dongho/slidemenu')
    @include('layouts/dongho/product_hot')
                    	<!--end top--> 	
                        <div class="main-wrap">
                            {{$content}}
                            @if( $menu != "cart" && $menu !="vanchuyen" && $menu !="thanhtoan" && $menu !="xacnhan")
                            </div></div></div><div class="col-lg-3 col-md-3 col-sm-12 col-xs-12"><div><!--$css_item,$box_width,$position,$num_item_row -->
                            @include('layouts/dongho/rightbar')
</div></div></div></div></section>
                        </div>
                            @endif
                        <footer>
                         
                        <section class="row-section footer-banner footer-banner  row_0" style='  '><div class="container">
                            
                        </div></section><section class="row-section footer-slideshow  row_2" style='  '><div class="container"><!-----Slider------>
		
	
<script>
	//script de chạy slide
	$(document).ready(function() {
	  var owl = $("#slide_9396881426156503");
	  owl.owlCarousel({
		  items : 4, 
		  itemsDesktop : [1000,4], 
		  itemsDesktopSmall : [900,3],
		  itemsTablet: [600,2],
		  itemsMobile : false
	});
	  // Custom Navigation Events
	  $(".next_9396881426156503").click(function(){
		owl.trigger('owl.next');
	  })
	  $(".prev_9396881426156503").click(function(){
		owl.trigger('owl.prev');
	  })		 
	});
	
</script></div></section><section class="row-section footer-html footer-post_views footer-tag footer-html  row_3" style='background:#05080d !important; padding:25px 0px !important; '><div class="container"><div class="row"><div class="col-lg-3 col-md-3 col-sm-12 col-xs-12"><div class="box1">
<h3>Liên hệ</h3>

{{CNF_ADDRESS}}

<ul class="social">
	<li><a href="https://www.facebook.com/pages/An-S%E1%BB%89-l%E1%BA%BB-%C4%91%E1%BB%93ng-h%E1%BB%93-th%E1%BB%9Di-trang/1386626251656805?ref=hl"><img alt="" src="{{URL::to('')}}/sximo/images/fb.png" /></a></li>
	<li><a href="#" target="_blank"><img alt="" src="{{URL::to('')}}/sximo/images/tw.png" /></a></li>
	<li><a href="#"><img alt="" src="{{URL::to('')}}/sximo/images/sky.png" /></a></li>
	<li><a href="#"><img alt="" src="{{URL::to('')}}/sximo/images/dr.png" /></a></li>
	<li><a href="#"><img alt="" src="{{URL::to('')}}/sximo/images/gplus.png" /></a></li>
</ul>
</div></div>
    @include('layouts/dongho/footer')
<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">	        <h3>Tag</h3>
                <ul class="tags-footer">
                        {{SiteHelpers::getListTags()}}
                    </ul>
                
         </div><div class="col-lg-3 col-md-3 col-sm-12 col-xs-12"><div class="box">
<h3>Fanpage shop</h3>

<div class="fb-like-box" data-colorscheme="light" data-header="true" data-href="https://www.facebook.com/pages/An-S%E1%BB%89-l%E1%BA%BB-%C4%91%E1%BB%93ng-h%E1%BB%93-th%E1%BB%9Di-trang/1386626251656805?ref=hl" data-show-border="true" data-show-faces="true" data-stream="false"> </div>
</div>
</div></div></div></section><section class="row-section footer-html  row_4" style='background:#020305 !important;  '><div class="container"><section class="center">
<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore</p>

<p>enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor</p>
</section>
</div></section><section class="row-section footer-html  row_5" style='background:#05080d !important;  '><div class="container"><div class="copyright">

</div>
</div></section>                        
                        </footer>
                    </div><!-- /main --> 
                </div><!-- /st-content-inner --> 
            </div><!-- /st-content --> 
        </div><!-- /st-pusher --> 
    </div><!-- /st-container -->        
{{ HTML::script('sximo/themes/dongho/js/main.js') }}
   
	<!--end id=page-->
	<br/>
    <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&appId=1538621203024054&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    {{ HTML::script('sximo/themes/dongho/js/custom.js') }}

   
</body>

</html>