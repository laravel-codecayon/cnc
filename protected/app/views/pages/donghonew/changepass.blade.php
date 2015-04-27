<section class="row_section" style='  '><div class="container"><div class="row"><div class="col-lg-9 col-md-9 col-sm-12 col-xs-12"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><section class="clearfix">       

      <section class="breadcrumbs clearfix">
          <a href="{{URL::to('')}}" title="Trang chủ"><i class="fa fa-home"></i></a>

                &nbsp;&nbsp;/&nbsp;&nbsp;<a href="#">Thay đổi mật khẩu</a>
                                      </section>

</section></div></div><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              @if(Session::has('message_changepass'))
                     {{ Session::get('message_changepass') }}
                @endif
                <ul class="parsley-error-list">
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
   <section class="">

           <form method="post" id="register" class="cmxform" action="{{URL::to('home/changepass')}}" >
        <input type="hidden" name="act" value="add">

      <div  id="register_has_been_successed">
                  <section id="signup" class="clearfix" >
            <div class="row">
              <div class="col-lg-12">
                <section class="block">
                  <div class="heading">Dổi mật khẩu</div>
                    <div class="main-inner">
                                            <div class="clearfix">
                        <label for="password">Mật khẩu cũ</label>
                                                <input class="input" type="password" id="password" name="password" value="">
                      </div>

                      <div class="clearfix">
                        <label for="newpassword"> Mật khẩu mới</label>
                        <input type="password" class="input" id="newpassword" name="newpassword" value="" >
                      </div>
                      <div class="clearfix">
                        <label for="confirmpassword">Nhập lại mật khẩu mới</label>
                        <input class="input" type="password" id="confirmpassword" name="confirmpassword" value="">
                      </div>
                      
                                            
                        @if(CNF_RECAPTCHA =='true') 
                        <div class="clearfix">
                        <label for="email">Mã bảo mật</label>
                          {{ Form::captcha(array('theme' => 'white')); }}
                          </div>
                        @endif
                        
                      
                        <input type="submit" class="submit" value="Gửi">
                    </div>
                </section>

              </div>
            </div><!--End Row-->
        </section> <!--End listitem-->
      </div> <!--End row--> 
    </form>  <div id="cssmenu"></div> 
  <div id="tooltip"></div>
</section>
