<section class="row_section" style='  '><div class="container"><div class="row"><div class="col-lg-9 col-md-9 col-sm-12 col-xs-12"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><section class="clearfix">       

    	<section class="breadcrumbs clearfix">
	        <a href="{{URL::to('')}}" title="Trang chủ"><i class="fa fa-home"></i></a>
											                &nbsp;&nbsp;/&nbsp;&nbsp;<a href="{{URL::to('')}}/tin-tuc.html">Tin tức</a> 
	            	&nbsp;&nbsp;/&nbsp;&nbsp;<a href="#">{{{$new->news_name}}}</a>
	            	            					</section>

</section></div></div><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">   <section class="clearfix">
				<section id="post">
               		<div class="postitem">
						<div class="row">
							<article class="col-lg-12">
                            	<h2><span>{{{$new->news_name}}}</span></h2>
                                <div class="date"><i class="fa fa-calendar"></i>&nbsp;&nbsp;{{date('d/m/Y',$new->created)}}  </div>
                                <div>
                                	<div class="share">
										<!-- Go to www.addthis.com/dashboard to customize your tools -->
										<div class="addthis_native_toolbox"></div>
									</div>
                                </div>
                                <p>{{$new->news_content}}</p> 
                            </article>
						</div><!--End Row-->
					</div>	            
                    
				</section>             
				<!--End listitem-->
	    
	     			                
	            <section id="product-listitem" class="clearfix">
	                <div class="listitem">
	                    <h2><span>Tin tức mới</span>
	                        <a href="{{URL::to('')}}/tin-tuc.html" title="Tin tức mới" class="all">Xem tất cả</a>
	                    </h2>
                        @foreach($news as $item)
                                                <!-- ITEM-NEWS-->
                        <div class=" mg">
                            <div class="news">
                                <a href="{{URL::to('')}}/tin-tuc/{{$item->news_alias}}-{{$item->news_id}}.html" title="{{{$item->news_name}}}">
                                    <div class="image">
                                        <img src="{{URL::to('')}}/uploads/news/thumb/{{$item->news_picture}}" alt="{{{$item->news_name}}}">  
                                        <div class="ImageOverlay"></div>
                                        
                                       
                                    </div>
                                </a>                         
                            </div>
                            <div class="title-news">
                                    <a href="{{URL::to('')}}/tin-tuc/{{$item->news_alias}}-{{$item->news_id}}.html" title="{{{$item->news_name}}}" title="{{{$item->news_name}}}">{{{$item->news_name}}}</a>
                                    <div class="date f20">{{date('d/m/Y',$item->created)}}</div>
                            </div>
                        </div>
                        <!-- ITEM-NEWS-->
                        @endforeach
	                </div>
	            </section>
</section>