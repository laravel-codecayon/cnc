<section class="row_section" style='  '><div class="container"><div class="row"><div class="col-lg-9 col-md-9 col-sm-12 col-xs-12"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><section class="clearfix">       
 
      <section class="breadcrumbs clearfix">
          <a href="{{URL::to('')}}" title="Trang chủ"><i class="fa fa-home"></i></a>
                                      &nbsp;&nbsp;/&nbsp;&nbsp;{{$cat_link}}
                                                        
                &nbsp;&nbsp;/&nbsp;&nbsp;<a href="#">{{{$product->ProductName}}} {{{$product->ProductCode}}}</a>                
                                      </section>

</section></div></div><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><section class="">
{{ HTML::script('sximo/themes/dongho/js/jquery.elevatezoom.js') }}
{{ HTML::script('sximo/themes/dongho/js/jquery.fancybox8cbb.js?v=2.1.5') }}
{{ HTML::style('sximo/themes/dongho/css/jquery.fancybox8cbb.css?v=2.1.5')}}
      <section>
        <article class="detail">                                
          <div class="row">
            <div class="img-blog col-lg-4 col-md-4 col-sm-4 col-xs-12" id="gallery_01">
                        <a class="elevatezoom-gallery active" data-update="" data-image="{{URL::to('')}}/uploads/products/thumb/{{$product->image}}" href="javascript:void(0)" data-zoom-image="{{URL::to('')}}/uploads/products/{{$product->image}}">
              <img  id="main_img" src="{{URL::to('')}}/uploads/products/{{$product->image}}" alt="{{{$product->ProductName}}} {{{$product->ProductCode}}}" >
                            </a>
                          
                        
                        <script type="text/javascript">
          jQuery(document).ready(function () {
          jQuery("#main_img").elevateZoom({gallery:'thumbs', cursor: 'pointer',  imageCrossfade: false,zoomType:'window'}); 
          
          jQuery("#main_img").bind("click", function(e) {  
            var ez =   jQuery('#main_img').data('elevateZoom');
            ez.closeAll(); //NEW: This function force hides the lens, tint and window 
            jQuery.fancybox(ez.getGalleryList());
            return false;
          });
          
          }); 
            
          </script>
                      
                        
                       
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">  
                          <p>Lượt xem: <strong>{{$product->views}}</strong></p>            
              <h2>{{{$product->ProductName}}} {{{$product->ProductCode}}}</h2>
              <p><strong>Mã sản phẩm: :</strong>{{$product->ProductCode}}</p>  
                <div class="share">
                  <!-- Go to www.addthis.com/dashboard to customize your tools -->
                  <div class="addthis_native_toolbox"></div>
                                    
                </div>                                      
                                                <p class="des">{{$product->description}}</p>
                                                          
              <div class="price-num">
                <div class="price">
                    {{SiteHelpers::getPricePromotion($product)}}
                                                      </div>
                <div class="quantity-input">
                  Số lượng: <input type="text" name="quantity_pd" id="quantity_pd" maxlength="4" value="1" size="3" />
                </div>
              </div>
                                          <ul class="function">
                                                                  <li>
                                            <input type="submit" onclick="add_cart_detail({{$product->ProductID}})" name="btn_submit" class="btn btnitem" value="Thêm vào giỏ hàng" />
                                               
                                            
                                    </li> 
                                                                <li>
                                      <a href="javascript:void(0)" onclick="add_favo({{$product->ProductID}})" title="">
                    <button type="button" class="btn btnitem">
                      <i class="fa fa-heart"></i>
                    </button>
                                      </a>
                  
                </li>
                                        
                              </ul>

            </div>
          </div> <!--End row-->                            
        </article>               
      </section>
                      
            <section id="product-tab">
        <ul class="tabs">
          <li class="selected"><a class="item_tabs" tab_id="1">Giới thiệu</a></li>
          <!--<li class=""><a class="item_tabs" tab_id="2">Thông tin sản phẩm</a></li>-->
          <li class="comment-on-off" style="display:"><a class="item_tabs" tab_id="3">Bình luận</a></li>
        </ul>
        <ul id="tb_1" class="tab" style="display: block;">
          <p>
                                                @if($product->Content == '')
                                                  Đang cập nhật
                                                @else 
                                                     {{$product->Content}}
                                                @endif                                        </p>
        </ul>
        <!--<ul id="tb_2" class="tab" style="display: none;">
                  
        </ul>-->
                <ul id="tb_3" class="tab" style="display: none;">
                  <div class="fb-comments" data-width="100%" data-href="{{URL::to('')}}{{$_SERVER['REQUEST_URI']}}" data-numposts="5" data-colorscheme="light"></div>
        </ul>
      </section> <!--end product-tab-->
                            
            <!-- LIST ITEM-->   
      <section id="product-listitem">
                <div class="listitem box_9 ">
                    <h2><span>Sản phẩm liên quan</span></h2>
                    <div class="row">
                        <!-- Item 1-->
                        
                                              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                @if(count($pro_same) > 0)
                                                @foreach($pro_same as $item)
                                                    {{ SiteHelpers::templateProduct($item,'gird') }}
                                                @endforeach
                                                @else
                                                Đang cập nhật
                                                @endif
                                              </div>
                                      </div>       
                </div>                
      </section>