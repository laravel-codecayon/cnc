{{--*/ $pro1 = SiteHelpers::getProductMain(0); /*--}}
<section class="row_section" style='  '><div class="container"><div class="row"><div class="col-lg-9 col-md-9 col-sm-12 col-xs-12"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><!--$css_item,$box_width,$position,$num_item_row -->
    
    <section id="product-listitem" class="clearfix">
    <div class="listitem box_9">
    
                <h2><span>Sản phẩm nổi bật</span>
                </h2>
                <div class="row">
                    <!-- Item 1-->
                        @foreach($pro1 as $item)
                            <?php echo SiteHelpers::templateProduct($item); ?>
                        @endforeach
        </div>
               
</section>
    </div></div><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><!--$css_item,$box_width,$position,$num_item_row -->
    
    <section id="product-listitem" class="clearfix">
    <div class="listitem box_9">
    {{--*/ $pro2 = SiteHelpers::getProductMain(1); /*--}}
                <h2><span>Sản phẩm mới</span>
                </h2>
                <div class="row">
                    <!-- Item 1-->
                                                                                                
                        @foreach($pro2 as $item2)
                            <?php echo SiteHelpers::templateProduct($item2); ?>
                        @endforeach
                       
                                             
                                         <!-- Item 2-->
                    
                </div>
                        
        </div>
               
</section>
    
    