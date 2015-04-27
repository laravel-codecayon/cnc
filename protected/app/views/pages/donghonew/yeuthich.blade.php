<section class="row_section" style="  "><div class="container"><div class="row"><div class="col-lg-9 col-md-9 col-sm-12 col-xs-12"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><section class="clearfix">       
 
    	<section class="breadcrumbs clearfix">
	        <a href="http://donghoss.vnws.com" title="Trang chủ"><i class="fa fa-home"></i></a>
											            
	            	&nbsp;&nbsp;/&nbsp;&nbsp;<a href="#">Yêu thích</a>	            	
	            	            					</section>

</section></div></div><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><section>
	<ul class="wishlist">

        <li class="thead">
            <div class="name">Tên sản phẩm</div>
            <div class="unit-price">Thêm vào ngày</div>
            <div class="price">Đơn giá</div>
            <div class="action">Thao tác</div>
        </li>
        @foreach($datas as $data)
        {{--*/ list($price,$price_html) = SiteHelpers::getPrice($data); /*--}}
        <li id="li_{{$data->ProductID}}">
            <div class="name">
                <img src="{{URL::to('')}}/uploads/products/thumb/{{$data->image}}" alt="{{$data->ProductName}} {{$data->ProductCode}}">
                <p>{{$data->ProductName}}</p>
                <p>Mã sản phẩm: {{$data->ProductCode}}</p>
            </div>
            <div class="unit-price">
                <span>Thêm vào ngày</span>{{date('d/m/Y',$data->time)}}            </div>
            <div class="price">
                <span>Đơn giá</span>
                				    {{$price_html}}
            </div>
            <div class="cs">
                <a href="http://donghoss.vnws.com/?site=cart&amp;act=order&amp;sub=update_cart&amp;key=addfmodule&amp;item=124" title="Mua sản phẩm này">
                    <button type="button" class="btn btnitem">
                        <i class="fa fa-shopping-cart"></i>
                    </button>
                </a>
            </div>
            <div class="del">
                <a onclick="return del_favo('{{$data->ProductID}}')" href="javascript:void(0);" title="Xoá sản phẩm này">
                    <button type="button" class="btn btnitem">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </a>
            </div>
        </li>
        @endforeach

    </ul>
