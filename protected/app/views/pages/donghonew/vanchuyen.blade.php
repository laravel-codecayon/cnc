{{ HTML::script('sximo/themes/dongho/js/jquery.jcombo.min.js') }}
<section class="row_section" ><div class="container"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><section class="">    
 <section class="cart-step">
            <ol class="progtrckr" data-progtrckr-steps="4">
                <li class="progtrckr-done">
                    <a href="{{URL::to('')}}/gio-hang-cua-toi.html">
                        <span class="step">1</span>
                       <p> Giỏ hàng</p>
                    </a>                                                    
                </li>
                <li class="progtrckr-done">
                <a href="{{URL::to('')}}/van-chuyen-hang.html">
                        <span class="step">2</span>
                       <p> Vận chuyển</p>
                 </a>
                </li>
                <li class="progtrckr-todo">
                      <a href="#">  <span class="step">3</span>
                        <p>Thanh toán</p>
                        </a> 
                </li>
                <li class="progtrckr-todo">
                         <a href="#"><span class="step">4</span>
                       <p>Xác nhận</p>
                      </a> 
                </li>
            </ol>
        </section>
 <section class="cart-step">
<div class="row">
<div class="col-lg-12 col-md-12">
</div>
</div>
 </section>
<form action="{{URL::to('')}}/home/thanhtoan" method="post"  id="form_shipping_method" name="form_shipping_method" method="post"/>
<div class="row">
            <div class="col-lg-8 col-md-8">
                
                <div class="panel-group" id="accordion">
                    <div class="panel panel-default cart-step-two">
                        <div class="panel-heading">
                              <h4 class="panel-title"> 
                                Địa chỉ nhận hàng
                              </h4>
                        </div>
                        <div id="collapseTwo" class="">
                            <div class="panel-body">
                                <div class="radio">
                               
                               <section class="block new_billing_block">
                    @if(Session::has('message_vanvhuyen'))
                                 {{ Session::get('message_vanvhuyen') }}
                            @endif
                            <ul class="parsley-error-list">
                              @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                              @endforeach
                            </ul>
                    <div class="main">
                                          <div class="clearfix">
            <label for="email">Email</label>                        
            <input class="input" type="text" id="email" name="email" value="{{$input['email']}}">
        </div>

        <div class="clearfix">
            <label for="name">Tên</label>                       
            <input class="input" type="text" id="name" name="name" value="{{$input['name']}}">
        </div>
        
        <div class="clearfix">
            <label for="phone">Số điện thoại</label>
            <input class="input" maxlength="40" type="text" id="phone" name="phone" value="{{$input['phone']}}">
        </div>      
        
        
       
        
       
        <div class="clearfix">
          <label for="address">Địa chỉ</label>
          <input type="text" class="input entry_street_address" id="address" name="address" value="{{$input['address']}}">
          <div class="err_user_address_1"></div>
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
                        
                    </div>
                </section>
                               
                               
                                                               
                            </div>
                            </div>
                        </div>
              </div>
        </div>
                <div class="panel panel-default cart-step-two">
                        <div class="panel-heading">
                              <h4 class="panel-title"> 
                                Vận chuyển                              </h4>
                        </div>
                
                    <div id="collapseThree" >
                                <div class="panel-body">
                                 <div>
<strong>Miễn phí giao hàng trên toàn quốc</strong></div>
                                </div>
                    </div>
            </div>
      </div>
            
            <div class="col-lg-4 col-md-4">
                <div class="total-step-two">
                  <div class="heading">
                      Giỏ hàng                         <a href="{{URL::to('')}}/gio-hang-cua-toi.html"  class="pull-right">Chỉnh sửa</a>
                    </div>    
                  <ul class="confirm">
                    
                    
                                                            
                    <li> <span class="pull-left"><strong>Tổng tiền</strong></span> <span class="pull-right red1"><strong>{{number_format(SiteHelpers::getTotalcart(),0,',','.')}}đ</strong></span> </li>
                  </ul>
                </div>
            </div>
            
            <div class="col-lg-12 col-xs-12">
              
                <input type="submit" value="Tiếp tục" name="Tiếp tục" class="cart-continue pull-right" >
            </div>
        </div>
</form>

<script type="text/javascript">
          $(document).ready(function() { 
            $("#city").jCombo("{{ URL::to('ward/comboselect?filter=province:provinceid:name') }}",
            {  selected_value : "{{$input['provinceid']}}",initial_text: "-- Tỉnh/Thành --", });
            $("#city").on('change', function() {
              var val = this.value ; 
              $("#district").jCombo("{{ URL::to('ward/comboselect?filter=district:districtid:name:') }}"+val,
            {  selected_value : "{{$input['districtid']}}",initial_text: "-- Quận/Huyện --", });
            });
            $("#district").on('change', function() {
              var val = this.value ; 
              $("#ward").jCombo("{{ URL::to('ward/comboselect?filter=ward:wardid:name:') }}"+val,
            {  selected_value : "{{$input['wardid']}}",initial_text: "-- Phường/Xã --", });
            });
          });
        </script>

</div></div></div></section>                        </div>            