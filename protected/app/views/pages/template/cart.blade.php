{{ HTML::script('sximo/themes/dongho/js/jquery.jcombo.min.js') }}
<section class="row_section" ><div class="container"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> <section class="cart-step">
            <ol class="progtrckr" data-progtrckr-steps="4">
                <li class="progtrckr-done">
                    <a href="gio-hang-cua-toi.html">
                        <span class="step">1</span>
                        <p>Giỏ hàng</p>
                    </a>                                                    
                </li>
                <li class="progtrckr-todo">
                <a href="#">
                        <span class="step">2</span>
                       <p> Vận chuyển</p>
                 </a>
                </li>
                <li class="progtrckr-todo">
                        <a href="#"><span class="step">3</span>
                        <p>Thanh toán</p>
                        </a>
                </li>
                <li class="progtrckr-todo">
                        <a href="#">  <span class="step">4</span>
                      <p> Xác nhận</p>
                       </a>
                </li>
            </ol>
        </section>

    <section class="clearfix">
                                                    
    <form action="{{URL::to('')}}/home/vanchuyen" method="post">
        <div class="listitem">                                
            <div class="row">
                <div class="col-lg-12">
                    <ul class="cart-list">
                        <li class="thead">
                            <div class="name">Tên sản phẩm</div>
                            <div class="amount">Số lượng</div>
                            <div class="unit-price">Đơn giá</div>
                           <!-- <div class="unit-price">Giá phụ</div>-->
                            <div class="price">Thành tiền</div>
                            <div class="action">Xóa</div>
                        </li>                 
                        
                          <?php
                              $total = 0;
                              foreach($datas as $data){
                                list($price,$price_format) =  SiteHelpers::getPrice($data);
                                $price_total = (int)$price * (int)$data->num;
                                $total += $price_total;
                          ?>
                                  <li id="{{$data->ProductID}}">
                                    <div class="name" >
                                        <a href="{{URL::to('')}}/chi-tiet/{{$data->alias}}-{{$data->ProductID}}.html"><img src="{{URL::to('')}}/uploads/products/thumb/{{$data->image}}" alt="{{$data->ProductName}} {{$data->code}}"></a> 
                                        <p>{{$data->ProductName}} {{$data->code}}</p>
                                        
                                            
                                    </div><!--End Name-->
                                    <div class="amount"><span>Số lượng</span>
                                        <input type="number" id="sl_{{$data->ProductID}}" class="order_qty_1" width="10" height="18" border="1" size="1" value="{{$data->num}}" name="textbox">
                                        <a onclick="update_cart({{$data->ProductID}},{{$price}},{{$data->num}})"><i class="fa fa-refresh"></i></a>

                                    </div>
                                    <div class="unit-price price_change_1"><span>Đơn giá</span>{{$price_format}}đ</div>
                                    <!--<div class="unit-price"><span>Giá phụ</span>0đ</div>-->
                                    <div class="price"><span>Thành tiền</span><font id="total_pro_{{$data->ProductID}}">{{number_format($price_total,0,',','.')}}</font>đ</div>
                                    <input type="hidden" id="total_{{$data->ProductID}}" value="{{$price_total}}" />
                                    <div class="del">
                                    <a href="javascript:void(0)" onclick="del_cart({{$data->ProductID}})" title="Xóa sản phẩm này" class="red"><i class="fa fa-trash-o"></i></a>
                                    </div>
                                  </li>
                            <?php } ?>
                        
                      </ul>
                </div>
            </div>
        </div>
        
        <div class="total">
          <div class="left col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="coupon">                    
                    <span>Mã khuyến mãi</span><input type="text" name="coupon_code" placeholder="Mã khuyến mãi" id="coupon_code"><a class="cart-continue" href="javascript:void(0)" title="Thêm" onclick="alert('Mã không hợp lệ')">Thêm</a>
                    
                </div>
        <ul class="info ">                                  
          <li>&nbsp;</li>                                     
        </ul> 
      </div>
          <ul class="confirm col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <input type="hidden" id="total" value="{{$total}}" />
            <li> <span class="pull-left"><strong>Tiền sản phẩm</strong></span> <span class="pull-right red1"><strong id="show_total1">{{number_format($total,0,',','.')}}đ</strong></span> </li>
                                      <li> <span class="pull-left"><strong>Tổng tiền</strong></span> <span class="pull-right red1"><strong id="show_total2">{{number_format($total,0,',','.')}}đ</strong></span> </li>
          </ul>
    </div>
        
        <a href="{{URL::to('')}}" id="new_customer" class="cart-continue-shopping pull-left">
          <i class="fa fa-angle-right"></i>Tiếp tục mua hàng        </a>
       <a href="#news_pop_create_checkout_express" id="checkout_express" class="cart-continue pull-right">Đặt hàng nhanh </a>
        
    <a class="cart-continue pull-right" href="{{URL::to('')}}/van-chuyen-hang.html" title="Tiếp tục">Tiếp tục</a>
<!--End total--> 
            </section> <!--End listitem-->
                            </form> 
                           
                            
<div id="news_pop_create_checkout_express" class="zoom-anim-dialog mfp-hide">
<form name="create_checkout_express" action="{{URL::to('')}}/home/checkoutexpress" id="create_checkout_express" method="post">

<section class="block">
    <div class="main-inner">
        <p class="title"></p>
        
        <div class="clearfix">
            <label for="email">Email</label>                        
            <input class="input" type="text" id="email" name="email" value="">
        </div>

        <div class="clearfix">
            <label for="name">Tên</label>                       
            <input class="input" type="text" id="name" name="name" value="">
        </div>
        
        <div class="clearfix">
            <label for="phone">Số điện thoại</label>
            <input class="input" maxlength="40" type="text" id="phone" name="phone" value="">
        </div>      
        
        
       
        
       
        <div class="clearfix">
          <label for="address">Địa chỉ</label>
          <input type="text" class="input entry_street_address" id="address" name="address">
          <div class="err_user_address_1"></div>
        </div>
        <div class="clearfix" id="form_comment_cart">
          <label for="entry_street_address" style="vertical-align:top;">Tin nhắn</label>
          <textarea name="comment" ></textarea>
         
        </div>
        <div class="clearfix">
        <label>Tỉnh / Thành phố</label>
        <select name="provinceid" id="city" class="input user_city"></select>
        <div class="err_list_region"></div>
      </div> 
      <div class="clearfix">
          <label>Quận / Huyện</label>
          <span id="city_ajax"></span>
          <select name="districtid" id="district" class="input user_city"></select>
          <div class="err_user_city"></div>
      </div>
      <div class="clearfix">
          <label>Phường / Xã</label>
          <span id="city_ajax"></span>
          <select name="wardid" id="ward" class="input user_city"></select>
          <div class="err_user_city"></div>
      </div>
        @if(CNF_RECAPTCHA =='true') 

          <div class="clearfix">
          <label for="address">Mã bảo mật</label>
          {{ Form::captcha(array('theme' => 'white')); }}
          <div class="err_user_address_1"></div>
        </div>

        @endif
       
       
       
        
      
        
        <div class="clearfix"><input type="submit" name="Tiếp tục" value="Đặt hàng"></div>   
    </div>
</section>
</form>
</div>
<script>
  $(document).ready(function() {
    $('#checkout_express').magnificPopup({
      type: 'inline',
  
      fixedContentPos: false,
      fixedBgPos: true,
  
      overflowY: 'auto',
  
      closeBtnInside: true,
      preloader: false,
      
      midClick: true,
      removalDelay: 300,
      mainClass: 'my-mfp-zoom-in'
    }); 
    $("#create_checkout_express").validate({
      rules: {
        name: {
          required: true,
          minlength: 5
        },
        email: {
          required: true,
          email: true
        },
        phone: {
          required: true,
          minlength: 9,
          number: true
        },
        address: "required",
        provinceid: {
          required: true,
          number: true
        },
        districtid: {
          required: true,
          number: true
        },
        wardid: {
          required: true,
          number: true
        },
      },
      messages: {
        name: {
          required: "Vui lòng nhập Tên",
          minlength: "Tên ít nhất 5 kí tự"
        },
        phone: {
          required: "Vui lòng nhập số điện thoại",
          minlength: "Điện thoại ít nhất 9 kí tự",
          number: "Vui lòng nhập số"
        },
        email: {
          required: "Vui lòng nhập Email",
          email: "Sai định dạng"
        },
        address: "Vui lòng nhập địa chỉ",
        provinceid: {
          required: "Vui lòng chọn thành phố",
          number: "Sai định dạng"
        },
        districtid: {
          required: "Vui lòng chọn quận/huyện",
          number: "Sai định dạng"
        },
        wardid: {
          required: "Vui lòng chọn phường/xã",
          number: "Sai định dạng"
        },
      }
    });
  });
  

    
</script>
<script type="text/javascript">
          $(document).ready(function() { 
            $("#city").jCombo("{{ URL::to('ward/comboselect?filter=province:provinceid:name') }}",
            {  selected_value : "79",initial_text: "-- Tỉnh/Thành --", });
            $("#city").on('change', function() {
              var val = this.value ; 
              $("#district").jCombo("{{ URL::to('ward/comboselect?filter=district:districtid:name:') }}"+val,
            {  selected_value : "",initial_text: "-- Quận/Huyện --", });
            });
            $("#district").on('change', function() {
              var val = this.value ; 
              $("#ward").jCombo("{{ URL::to('ward/comboselect?filter=ward:wardid:name:') }}"+val,
            {  selected_value : "",initial_text: "-- Phường/Xã --", });
            });
          });
        </script>

   <!--End row main--></div></div></div></section>                        </div>            