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
                <li class="progtrckr-done">
                      <a href="{{URL::to('')}}/thanh-toan.html">  <span class="step">3</span>
                        <p>Thanh toán</p>
                        </a> 
                </li>
                <li class="progtrckr-done">
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
<form action="{{URL::to('')}}/home/confirm" method="post"  id="form_shipping_method" name="form_shipping_method" method="post"/>
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
                                <ul>
                                            <li><i class="fa fa-user"></i><strong>{{{$info['name']}}} </strong></li>
                                                <li><i class="fa fa-phone"></i><strong>{{{$info['phone']}}} </strong></li>
                                                <li><i class="fa fa-envelope"></i>{{{$info['email']}}} </li>
                                                <li><i class="fa fa-home"></i><strong>{{{$info['address']}}} </strong></li>
                                                 <li><i class="fa fa-home"></i>{{{SiteHelpers::getNameaddress($info['provinceid'],'province','provinceid')}}}</li>
                                                <li><i class="fa fa-home"></i>{{{SiteHelpers::getNameaddress($info['districtid'],'district','districtid')}}}</li>
                                                <li><i class="fa fa-home"></i>{{{SiteHelpers::getNameaddress($info['wardid'],'ward','wardid')}}}</li>
                            </ul>
                            </div>
                        </div>
              </div>
        </div>
        <div class="panel-group" id="accordion">
                    <div class="panel panel-default cart-step-two">
                        <div class="panel-heading">
                              <h4 class="panel-title"> 
                                Hình thức thanh toán
                              </h4>
                        </div>
                        <div id="collapseTwo" class="">
                            <div class="panel-body">
                                <div class="radio">
                               
                               <section class="block new_billing_block">
                    <div class="main">
                        Chúng tôi miến phí hoàn toàn phí vận chuyển . Trước khi giao hàng quý khách vui lòng chuyển khoản cho chúng tối 100.000 VNĐ để đặt cọc . Xin chân thành cảm ơn sự quan tâm của quý khách !
                </section>
                               
                               
                                                               
                            </div>
                            </div>
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
                <div class="total-step-two">
                  <div class="heading">
                      Vận chuyển
                    </div>    
                  <ul class="confirm">
                    
                    
                                                            
                    <li> Miễn phí giao hàng trên toàn quốc </li>
                  </ul>
                </div>
            </div>
            
            <div class="col-lg-12 col-xs-12">
              
                <input type="submit" value="Đặt hàng" name="Đặt hàng" class="cart-continue pull-right" >
            </div>
        </div>
</form>


</div></div></div></section>                        </div>            