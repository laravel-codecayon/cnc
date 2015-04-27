<!DOCTYPE HTML>
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo isset($page['pageTitle']) ? $page['pageTitle'] : CNF_APPNAME ;?></title>
<meta name="keywords" content="{{ CNF_METAKEY }}">
<meta name="description" content="{{ CNF_METADESC }}"/>
<link rel="shortcut icon" href="{{ URL::to('')}}/logo.ico" type="image/x-icon"> 
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
    <div><a href="#"><img src="images/logo.png"></a></div>
    <ul>
        <li class="home"><a href="#">Home</a></li>
        <li class="about"><a href="#">About us</a></li>
        <li class="services"><a href="#">Services</a></li>
        <li class="news"><a href="#">News &amp; Events</a></li>
        <li class="contact"><a href="#">Contact us</a></li>
    </ul><!--main-menu-->
</div>
<!-- Modal -->
<div class="modal fade" id="seach-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content clearfix">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <form>
            <input type="text" placeholder="Tìm kiếm" class="form-control search-input">
            <button type="submit" class="btn btn-success search-submit"><i class="fa fa-search"></i></button>
        </form>
    </div>
  </div>
</div>
<div id="header" class="home">
    <div class="container animated fadein">
        <div id="logo"><a href="#"><img src="images/logo.png"></a></div>
        <div class="header-right">
            <div class="language dropdown">
                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                Vietnamese
                <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">English</a></li>
                </ul>
            </div>
            <div class="consulting"><span>(08) 62 699 699</span><p>Free consulting</p></div>
            <div class="navigator">        
                <a href="#"><i class="fa fa-envelope"></i></a>
                <a href="#" class="show-slide-menu"><i class="fa fa-navicon"></i></a>
                <a href="#" data-toggle="modal" data-target="#seach-popup"><i class="fa fa-search"></i></a>
            </div><!-- navigator -->
        </div><!-- header-right -->
    </div>
    <ul id="main-menu">
        <li class="home"><a href="index.html" class="transition">Home</a></li><img src="images/menu-sep.png">
        <li class="about"><a href="about.html" class="transition">About us</a></li><img src="images/menu-sep.png">
        <li class="services"><a href="services.html" class="transition">Services</a></li><img src="images/menu-sep.png">
        <li class="news"><a href="news.html" class="transition">News &amp; Events</a></li><img src="images/menu-sep.png">
        <li class="contact"><a href="contact.html" class="transition">Contact us</a></li>
    </ul><!--main-menu-->
    @include('layouts/dongho/slidemenu')
</div><!--header-->
<div id="breadcumbs" class="home">
    <ol class="breadcrumb container">
      <li><a href="#">Home</a></li>
      <li class="active">Contact us</li>
    </ol>
</div><!-- breadcumbs -->
<div id="body-content">

    <div id="home-page">
        <div id="welcome" class="block">
            <div class="top container move">
                <img src="images/home-icon1.png">
                <h2>Welcome to consultant cnc</h2>
            </div>
            <p class="container move">Reference site about Lorem Ipsum, giving information on <br> its origins, as well as a random Lipsum generator. </p>
            <div class="container move">
                <div class="row">
                    <div class="article" style="-webkit-animation-delay: 0s; animation-delay: 0s;">
                        <h3><img src="images/home-icon-app.png">APPROACH</h3>
                        <p>Nam justo ante, hendrerit vitae aliquet condimentum, commodo eu mi. Etiam sol licitudin odio at vehicula venenatis</p>
                        <a href="#" class="more">See more</a>
                    </div><!-- acrticle-->
                    <div class="article" style="-webkit-animation-delay: 0.25s; animation-delay: 0.25s;">
                        <h3><img src="images/home-icon-sol.png">SOLUTIONS</h3>
                        <p>Nam justo ante, hendrerit vitae aliquet condimentum, commodo eu mi. Etiam sol licitudin odio at vehicula venenatis</p>
                        <a href="#" class="more">See more</a>
                    </div><!-- acrticle-->
                    <div class="article" style="-webkit-animation-delay: .5s; animation-delay: .5s;">
                        <h3><img src="images/home-icon-suc.png">SUCCESS</h3>
                        <p>Nam justo ante, hendrerit vitae aliquet condimentum, commodo eu mi. Etiam sol licitudin odio at vehicula venenatis</p>
                        <a href="#" class="more">See more</a>
                    </div><!-- acrticle-->
                    <div class="article" style="-webkit-animation-delay: 1s; animation-delay: 1s;">
                        <h3><img src="images/home-icon-res.png">RESULTS</h3>
                        <p>Nam justo ante, hendrerit vitae aliquet condimentum, commodo eu mi. Etiam sol licitudin odio at vehicula venenatis</p>
                        <a href="#" class="more">See more</a>
                    </div><!-- acrticle-->
                </div>
            </div>
        </div><!-- welcome -->
        
        <div id="wwa">
            <div  class="block">
                <div class="top container move">
                    <img src="images/home-icon2.png"><h2>Who We Are</h2>
                </div>
                <p class="container move">Reference site about Lorem Ipsum, giving information on <br> its origins, as well as a random Lipsum generator. </p>
                <div class="wwa-content container move">Nam justo ante, hendrerit vitae aliquet condimentum, commodo eu mi. Etiam sol licitudin odio at vehicula venenatis. Nam justo ante, hendrerit vitae aliquet condimentum, commodo eu mi. Etiam sol licitudin odio at vehicula venenatisNam justo ante, hendrerit vitae aliquet condimentum, commodo eu mi. Etiam sol licitudin odio at vehicula venenatis Nam justo ante, hendrerit vitae aliquet condimentum, commodo eu mi. Etiam sol licitudin odio at vehicula venenatis Nam justo ante, hendrerit vitae aliquet condimentum, commodo eu mi. Etiam sol licitudin odio at vehicula venenatis Nam justo ante, hendrerit vitae aliquet condimentum, commodo eu mi. Etiam sol licitudin odio at vehicula venenatis</div>
            </div>
        </div><!-- activity -->
        
        <div id="consulting">
            <div class="block">
                <div class="container move">
                    <h2>Free Consulting</h2>
                    <p>Nam justo ante, hendrerit vitae aliquet condimentum, commodo eu mi. Etiam sol licitudin odio at vehicula venenatis. </p>
                    <span>(08) 62 699 699</span>
                </div>
            </div>
        </div><!--consulting-->
        
        <div id="activity">
            <div class="block">
                <div class="top container move">
                    <img src="images/home-icon3.png">
                    <h2>See More Our Activities </h2>
                </div>
                <div class="image container move">
                    <a href="http://www.youtube.com/watch?v=4eYSpIz2FjU" class="youtube"><img src="images/home-imac.png"></a><br>
                    <a href="http://www.youtube.com/watch?v=4eYSpIz2FjU" class="more youtube">See more</a>
                </div>
            </div>
        </div><!--activity-->
        
        <div id="news">
            <div class="block">
            <div class="top container move">
                <img src="images/home-icon4.png">
                <h2>some news from us</h2>
            </div>
            <div class="news-content container move">
                <div class="featured-news">
                    <div class="item">
                        <div class="image"><a href="#"><img src="images/home-news-img.jpg"></a></div>
                        <div class="meta"><span class="date">01/04/2015</span><span class="comment">50 Comment (s) </span></div>
                        <h3 class="title"><a href="#">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy</a></h3>
                        <p class="content">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum... Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit </p>
                    </div><!--item-->
                </div><!--featured-news-->
                <div class="latest-news">
                    <div class="item">
                        <div class="meta"><span class="date">01/04/2015</span><span class="comment">50 Comment (s) </span></div>
                        <div class="image"><a href="#"><img src="images/home-news-thumb.jpg"></a></div>
                        <h3 class="title"><a href="#">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy</a></h3>
                        <p class="content">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum... Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit </p>
                    </div><!--item-->
                    <div class="item">
                        <div class="meta"><span class="date">01/04/2015</span><span class="comment">50 Comment (s) </span></div>
                        <div class="image"><a href="#"><img src="images/home-news-thumb.jpg"></a></div>
                        <h3 class="title"><a href="#">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy</a></h3>
                        <p class="content">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum... Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit </p>
                    </div><!--item-->
                    <div class="item">
                        <div class="meta"><span class="date">01/04/2015</span><span class="comment">50 Comment (s) </span></div>
                        <div class="image"><a href="#"><img src="images/home-news-thumb.jpg"></a></div>
                        <h3 class="title"><a href="#">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy</a></h3>
                        <p class="content">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum... Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit </p>
                    </div><!--item-->
                    <div class="item">
                        <div class="meta"><span class="date">01/04/2015</span><span class="comment">50 Comment (s) </span></div>
                        <div class="image"><a href="#"><img src="images/home-news-thumb.jpg"></a></div>
                        <h3 class="title"><a href="#">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy</a></h3>
                        <p class="content">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum... Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit </p>
                    </div><!--item-->
                    <div class="item">
                        <div class="meta"><span class="date">01/04/2015</span><span class="comment">50 Comment (s) </span></div>
                        <div class="image"><a href="#"><img src="images/home-news-thumb.jpg"></a></div>
                        <h3 class="title"><a href="#">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy</a></h3>
                        <p class="content">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum... Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit </p>
                    </div><!--item-->
                    <div class="item">
                        <div class="meta"><span class="date">01/04/2015</span><span class="comment">50 Comment (s) </span></div>
                        <div class="image"><a href="#"><img src="images/home-news-thumb.jpg"></a></div>
                        <h3 class="title"><a href="#">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy</a></h3>
                        <p class="content">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum... Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit </p>
                    </div><!--item-->
                    <div class="item">
                        <div class="meta"><span class="date">01/04/2015</span><span class="comment">50 Comment (s) </span></div>
                        <div class="image"><a href="#"><img src="images/home-news-thumb.jpg"></a></div>
                        <h3 class="title"><a href="#">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy</a></h3>
                        <p class="content">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum... Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit </p>
                    </div><!--item-->
                    <div class="item">
                        <div class="meta"><span class="date">01/04/2015</span><span class="comment">50 Comment (s) </span></div>
                        <div class="image"><a href="#"><img src="images/home-news-thumb.jpg"></a></div>
                        <h3 class="title"><a href="#">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy</a></h3>
                        <p class="content">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum... Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit </p>
                    </div><!--item-->
                    <div class="item">
                        <div class="meta"><span class="date">01/04/2015</span><span class="comment">50 Comment (s) </span></div>
                        <div class="image"><a href="#"><img src="images/home-news-thumb.jpg"></a></div>
                        <h3 class="title"><a href="#">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy</a></h3>
                        <p class="content">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum... Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit </p>
                    </div><!--item-->
                    <div class="item">
                        <div class="meta"><span class="date">01/04/2015</span><span class="comment">50 Comment (s) </span></div>
                        <div class="image"><a href="#"><img src="images/home-news-thumb.jpg"></a></div>
                        <h3 class="title"><a href="#">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy</a></h3>
                        <p class="content">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum... Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit </p>
                    </div><!--item-->
                </div><!-- latest-news -->
            </div><!--news-content-->
            </div>
        </div><!--news-->
        
        
    </div><!-- home-page -->
     

</div><!-- body-content -->
<div id="bottom">
    <div class="container">
    Follow us on : <a href="#"><i class="fa fa-facebook-square"></i></a><a href="#"><i class="fa fa-twitter-square"></i></a><a href="#"><i class="fa fa-google-plus-square"></i></a><a href="#"><i class="fa fa-linkedin-square"></i></a><a href="#"><i class="fa fa-pinterest-square"></i></a><a href="#"><i class="fa fa-youtube-square"></i></a>
    </div>
</div><!-- bottom -->
<div id="footer">
    <div class="container">
        <ul class="column">
            <h3>About us</h3>          
            <li><i class="fa fa-angle-right"></i><a href="#">Physiology</a></li>
            <li><i class="fa fa-angle-right"></i><a href="#">Vision</a></li>
            <li><i class="fa fa-angle-right"></i><a href="#">Award &amp; Testimonial </a></li>
            <li><i class="fa fa-angle-right"></i><a href="#">Meet our team   </a></li>
        </ul><!--column-->
        <ul class="column">    
            <h3>News &amp; Events</h3>
            <li><i class="fa fa-angle-right"></i><a href="#">Newsletters</a></li>
            <li><i class="fa fa-angle-right"></i><a href="#">Company news</a></li>
            <li><i class="fa fa-angle-right"></i><a href="#">Recruitment</a></li>
            <li><i class="fa fa-angle-right"></i><a href="#">Publication</a></li>
        </ul><!--column-->
        <ul class="column">
            <h3>Privacy &amp; security</h3>
            <li><i class="fa fa-angle-right"></i><a href="#">Privacy</a></li>
            <li><i class="fa fa-angle-right"></i><a href="#">Terms of use</a></li>
        </ul><!--column-->
        <ul class="column">
            <h3>Contact Us</h3>
            <li>(08) 62 947 669</li>
            <li>118/116 Bach Dang Street, Ward 24,</li>
            <li>Binh Thanh District, HoChiMinh City</li>
            <li>info@goldenfolder.com</li>
        </ul><!--column-->
        <div class="column"><img src="images/logo-footer.png"></div>
    </div>
</div><!-- footer -->


</body></html>