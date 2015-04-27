<section class="row_section" style='  '><div class="container"><div class="row"><div class="col-lg-9 col-md-9 col-sm-12 col-xs-12"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><section class="clearfix">       
      <section class="breadcrumbs clearfix">
          <a href="{{URL::to('')}}" title="Trang chủ"><i class="fa fa-home"></i></a>
                                  
                &nbsp;&nbsp;/&nbsp;&nbsp;<a href="#">Đặt hàng thành công</a>                
                                      </section>

</section></div></div><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">  <section id="acc">
    <div class="itemacc">

            <article class="acc-info">
            <ul>
            <li><label>Mã hóa đơn</label> : <span> {{{$input['OrderName']}}}</span></li>
            <li><label>Khách hàng</label> : <span> {{{$input['name']}}}</span></li>
            <li><label>Số Điện Thoại</label> : <span>{{{$input['phone']}}}</span></li>
            <li><label>Email</label> : <span>{{$input['email']}}</span></li>
            <li><label>Địa chỉ liên lạc</label> : <span>{{{$input['address']}}}</span></li>
            <li><label>Thành phố</label> : <span>{{{SiteHelpers::getNameaddress($input['provinceid'],'province','provinceid')}}}</span></li>
            <li><label>Quận / huyện</label> : <span>{{{SiteHelpers::getNameaddress($input['districtid'],'district','districtid')}}}</span></li>
            <li><label>Phường / Xã</label> : <span>{{{SiteHelpers::getNameaddress($input['wardid'],'ward','wardid')}}}</span></li>
            </ul>
            <figure class="table-responsive">
                        <table class="list-price table">
                        <thead>
                        <tr>
                            <th style="width:5%;text-align:center">STT</th>
                            <th>Tên</th>
                            <th>Số lượng</th>
                            <th>Giá</th>  
                            <th>Tổng tiền</th>    
                        </tr>
                        </thead>
                        <tbody> 
                            <?php
                                $i = 1;
                                $mdPro = new Nproducts();
                                foreach($orderdetail as $detail){
                                $product = $mdPro->find($detail->ProductID);
                            ?>
                                <tr>
                                    <td style="width:5%;text-align:center">{{$i++}}</td>
                                    <td> {{{$product->ProductName}}}
                                    </td>
                                    <td>{{$detail->Quantity}}</td>
                                    <td>{{number_format($detail->UnitPrice,0,',','.')}}đ</td> 
                                    <td>{{number_format(($detail->UnitPrice * $detail->Quantity),0,',','.')}}đ</td> 
                                </tr>
                            <?php
                                }
                            ?>
                                                    
                                                
                                               <tr>
                            <td colspan="4">Tiền sản phẩm</td>
                            <td>{{number_format($input['total'],0,',','.')}}đ</td>
                        </tr>
                                               <tr>
                            <td colspan="4">tổng tiền</td>
                            <td>{{number_format($input['total'],0,',','.')}}đ</td>
                        </tr>
                                            </tbody>
                        </table>
                    </figure>
        </article>


  </div>
