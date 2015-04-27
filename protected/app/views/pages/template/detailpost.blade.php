<div class="container">
        	<div id="wrap-content">
            	<!--<ol class="breadcrumb">
                  <li><a href="#">Trang chủ</a></li>
                  <li><a href="#">Hành khách</a></li>
                </ol>-->
            	<div class="box post-detail">
                    <div class="img">@if($post->post_typecustomer == 1)<img src="{{asset('sximo/themes/uber/image/guest-icon.png')}}">@else<img src="{{asset('sximo/themes/uber/image/driver-icon.png')}}">@endif</div>
                    <div class="title">{{$post->post_subject}}</div>
                    <div class="trip clearfix">
                        <span class="start-place">Nơi đi : <b>{{SiteHelpers::getNameaddress($post->post_districtfrom,'district','districtid')}}, {{SiteHelpers::getNameaddress($post->post_provincefrom,'province','provinceid')}}</b></span>
                        <span class="end-place">Nơi đến : <b>{{SiteHelpers::getNameaddress($post->post_districtto,'district','districtid')}}, {{SiteHelpers::getNameaddress($post->post_provinceto,'province','provinceid')}}</b></span>
                        <span class="start-date">Ngày xuất phát : <b>{{date('d-m-Y',$post->post_datestar)}}</b></span>
                    </div><!-- trip -->
                    <div class="detail clearfix">
                        <table>
                        	<tr><td>Nơi xuất phát</td><td>{{$post->post_addressfrom}}, {{SiteHelpers::getNameaddress($post->post_districtfrom,'district','districtid')}}, {{SiteHelpers::getNameaddress($post->post_provincefrom,'province','provinceid')}}</td></tr>
                            <tr><td>Nơi đến</td><td>{{$post->post_addressto}}, {{SiteHelpers::getNameaddress($post->post_districtto,'district','districtid')}}, {{SiteHelpers::getNameaddress($post->post_provinceto,'province','provinceid')}}</td></tr>
                            <tr><td>Ngày xuất phát</td><td>{{date('d-m-Y',$post->post_datestar)}}</td></tr>
                            <tr><td>Loại xe</td><td>{{$post->post_typecar}}</td></tr>
                            <tr><td>Giá</td><td>@if($post->post_price == 0) Thỏa thuận @else {{number_format($post->post_price,0,',','.')}} VNĐ @endif</td></tr>
                            <tr><td>Ghi chú thêm</td><td>{{$post->post_note}}</td></tr>
                        </table>
                    </div><!-- detail -->
                    @if($post->post_file1 != '' || $post->post_file2 != '')
                    <div class="attached-file"> File đính kèm @if($post->post_file1 != '') <a href="{{URL::to('')}}/home/viewfile/{{$post->post_file1}}">Tập tin đính kèm</a> @endif @if($post->post_file2 != '') <a href="{{URL::to('')}}/home/viewfile/{{$post->post_file2}}">Tập tin đính kèm</a> @endif</div>
                    @endif
                </div><!-- guest-list -->
            </div><!-- wrap-content -->
            <div id="wrap-right">
            	<div class="box user-info">
                	<div class="box-heading">Thông tin liên hệ</div>
                    <div class="box-content">
                    	<h2 class="username"><a href="javascript:">{{$customer->name}}</a></h2>
                        <div class="avatar"><img src="@if($customer->image == '') {{asset('sximo/themes/uber/image/no-avatar.jpg')}} @else {{URL::to('')}}/uploads/customer/thumb/{{$customer->image}} @endif"></div>
                        <ul class="info">
                        	<li><div class="heading"><span>Tên</span></div>{{$customer->name}}</li>
                            <li><div class="heading"><span>Số điện thoại</span></div>{{$customer->phone}}</li>
                            <li><div class="heading"><span>Địa chỉ</span></div>{{$customer->address}}, Phường {{SiteHelpers::getNameaddress($customer->wardid,'ward','wardid')}},{{SiteHelpers::getNameaddress($customer->districtid,'district','districtid')}}, {{SiteHelpers::getNameaddress($customer->provinceid,'province','provinceid')}}</li>
                        </ul>
                    </div><!-- box-content -->
                </div><!-- filter -->
            </div><!-- wrap-right -->

        </div><!-- container -->