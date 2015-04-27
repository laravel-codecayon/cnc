{{ HTML::script('sximo/themes/shop/js/jquery.cookie.js') }}
<section class="row_section" style='  '><div class="container"><div class="row"><div class="col-lg-9 col-md-9 col-sm-12 col-xs-12"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><section class="clearfix">       
 
    	<section class="breadcrumbs clearfix">
	        <a href="{{URL::to('')}}" title="Trang chủ"><i class="fa fa-home"></i></a>
											            
	            	&nbsp;&nbsp;/&nbsp;&nbsp;<a href="#">{{$cat->CategoryName}}</a>	            	
	            	            					</section>

</section></div></div><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	    
    	    	
    	    </div></div><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">				<!-- thanh order san pham -->
 				
                <section class="utilities col-lg-12 col-md-12 col-sm-12 col-xs-12">
				  	<div class="filter pull-right">
				  	
				  	
				  	
				  		<div class="order-product pull-left">					
                            <div class="btn-group"> 
                                <span class="btn dropdown-toggle" data-toggle="dropdown"> 
                                    <a href="#"> 
                                        <span><i class="fa fa-sort"></i></span> 
                                        <span>Sắp xếp</span> 
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                </span>
                                
                                <!-- Show Dropdown Menu -->
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{URL::to('')}}/danh-muc/{{$cat->alias}}-{{$cat->CategoryID}}.html">
                                            <span> Mặc định</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{URL::to('')}}/danh-muc/{{$cat->alias}}-{{$cat->CategoryID}}.html?sort=ProductName-asc">
                                            <span><i class="fa fa-sort-alpha-asc"></i> Tên sản phẩm</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{URL::to('')}}/danh-muc/{{$cat->alias}}-{{$cat->CategoryID}}.html?sort=ProductName-desc">
                                            <span><i class="fa fa-sort-alpha-desc"></i> Tên sản phẩm</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{URL::to('')}}/danh-muc/{{$cat->alias}}-{{$cat->CategoryID}}.html?sort=UnitPrice-asc">
                                            <span><i class="fa fa-sort-numeric-asc"></i> Đơn giá</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{URL::to('')}}/danh-muc/{{$cat->alias}}-{{$cat->CategoryID}}.html?sort=UnitPrice-desc">
                                            <span><i class="fa fa-sort-numeric-desc"></i> Đơn giá</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>               
						</div>
							
				  	</div>
	                            
					<div class="view pull-right">
						<span>Hiển thị</span>
							<a @if($display != 'gird') id="change-display" type="gird" @endif href="javascript:0"><i class="fa fa-th @if($display == 'gird') active @endif"></i></a>
							<a @if($display != 'list') id="change-display" type="list" @endif href="javascript:0"><i class="fa fa-th-list @if($display == 'list') active @endif"></i></a>
					</div>
				</section>
				
				<!-- thanh order san pham -->
			 	<!--grid-->

				<section id="product-listitem">
                
              	<div class="listitem box_9 ">
                        <h2>
                        <span>{{$cat->CategoryName}}</span>
                        </h2>
                    @if($display == "gird")
                    <div class="row" >
                    @endif
                        <!-- Item 1-->
                        @foreach($data as $item)
			                {{ SiteHelpers::templateProduct($item,$display) }}
			            @endforeach
					@if($display == "gird")
                    </div>
                    @endif
              </div>           
			</section>             
			{{ $pagination->appends(array("sort"=>"$sort","page"=>$page))->links('pagination_site') }}
<script type="text/javascript"><!--

$( document ).ready(function() {
	$("#change-display").click(function(){
		var type = $(this).attr('type');
	    var link = "{{URL::to('')}}{{$_SERVER['REQUEST_URI']}}";
	    var ln = "{{URL::to('')}}/home/changedisplay";
		$.post( ln,{type : type}, function( data ) {
			window.location.href = link;
		});
	});
});
//--></script>