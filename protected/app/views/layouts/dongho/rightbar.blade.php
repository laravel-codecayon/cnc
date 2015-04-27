{{--*/ $category = SiteHelpers::getMenuCategories(); /*--}}
<!-- Vertical Menu -->
<section class="box-category">
    <div class="heading">
        <h2><span>Hãng</span></h2>
    </div>
    <div class="list-group panelvmenu">
        @foreach($category as $cat)
            <a href="{{URL::to('')}}/danh-muc/{{$cat->alias}}-{{$cat->CategoryID}}.html" class="list-group-item-vmenu"><i class="fa fa-angle-right"></i>{{$cat->CategoryName}}</a>
        @endforeach
    </div>
</section>
{{--*/ $products = SiteHelpers::getMenuProductSale(); /*--}}
@if(count($products) > 0)

<script>
    var url_cat=document.URL;   
    $(".panelvmenu a[href='"+url_cat+"']").addClass('active');  
    $(".panelvmenu a[href='"+url_cat+"']").parents('.collapse').addClass('in');
</script>
</div><div><!--$css_item,$box_width,$position,$num_item_row -->
        <!-- Product silder -->
    <Script language="javascript">
    $(document).ready(function() {
        var owl101426156503 = $('#typical-products-101426156503');
            owl101426156503.owlCarousel({
                items : 1, 
              itemsDesktop : [1024,1], 
              itemsDesktopSmall : [960,3],
              itemsTablet: [640,2],
            });
            $("#next101426156503").click(function(){
                owl101426156503.trigger('owl.next');
              })
              $("#prev101426156503").click(function(){

                owl101426156503.trigger('owl.prev');
              })
    });
    </script>

    <!-- Product silder -->
    <section id="typical" class="box-category">
      <div class="heading"> 
        <h2>
            <span>Sản phẩm khuyến mãi</span>
        </h2>
       </div>
            <div class="main">
                <div id="typical-products-101426156503" class="owl-carousel typical-products"> 

                <!-- 1 -->
            @foreach($products as $pro)
            <div class="item col3">
                <a href="{{URL::to('')}}/chi-tiet/{{$pro->slug}}-{{$pro->ProductID}}.html" title="{{$pro->ProductName}}">

                    <div class="box-feature">
                        <img src="{{URL::to('')}}/uploads/products/thumb/three_{{$pro->image}}" alt="{{$pro->ProductName}}" />

                        <!--span class="product-label-special-left label">NEW</span-->

                        <h3>{{$pro->ProductName}}</h3>
                    </div>

                </a>
                <p>{{$pro->description}}</p>
                                                            <span class="price-new">{{number_format($pro->UnitPrice,0,',','.')}}đ</span>
                                                </div>
            @endforeach
        </div>
        <div class="typicalNavigation">
            <a class="prev" id="prev101426156503"><i class="fa fa-chevron-left"></i></a>
            <a class="next" id="next101426156503"><i class="fa fa-chevron-right"></i></a>
        </div>
    </div> 

    </section>
</div>
@endif
<div>
<!--<section class="left-map box-category">
<div class="heading">
<h2><span>Bản đồ</span></h2>
</div>

<div class="main"><iframe frameborder="0" height="200" src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d26081603.294420466!2d-95.677068!3d37.06250000000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2s!4v1414725941877" style="border:0" width="100%"></iframe></div>
</section>-->
@if(isset($menu) && $menu != "detailnews" && $menu != "tintuc" )
{{--*/ $news = SiteHelpers::getMenuNews(); /*--}}
<section class="box-category">
                    <div class="heading">
                        <h2><span>Tin tức mới nhất</span></h2>
                    </div>
                    
                    <div class="main">
                        <ul class="list-post-latest list_post">
                            @foreach($news as $new)
                            <li>
                                <a href="{{URL::to('')}}/tin-tuc/{{$new->news_alias}}-{{$new->news_id}}.html" title="{{{$new->news_name}}}"> 
                                    <div class="img-overflow">   
                                        <img src="{{URL::to('')}}/uploads/news/thumb/{{$new->news_picture}}" alt="{{{$new->news_name}}}"/>
                                    </div>
                                    <p>{{{$new->news_name}}}</p>
                                    <span>{{date('d/m/Y',$new->created)}}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>

                    </div>                    
        </section>
@endif