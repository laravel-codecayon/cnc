<section class="row_section" style='  '><div class="container"><div class="row"><div class="col-lg-9 col-md-9 col-sm-12 col-xs-12"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><section class="clearfix">       
 
      <section class="breadcrumbs clearfix">
          <a href="index.html" title="Trang chủ"><i class="fa fa-home"></i></a>
                                  
                &nbsp;&nbsp;/&nbsp;&nbsp;<a href="#">Quên mật khẩu </a>                
                                      </section>

</section></div></div><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          @if(Session::has('message_forgotpass'))
                     {{ Session::get('message_forgotpass') }}
                @endif
                <ul class="parsley-error-list">
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
          <form method="post" id="forgot" name="forgot" action="{{URL::to('home/forgotpass')}}">
                    <article class="acc-cart">
                        <section class="block">
                            <div class="heading">
                            <span>
                            Quên mật khẩu ?                           </span>
                            
                            </div>
                            <div class="main-inner">
                                <div class="clearfix">
                                <label>Địa chỉ Email</label>
                                <input type="text" class="input" name="email" id="email">
                                </div>
                                @if(CNF_RECAPTCHA =='true') 
                                <div class="clearfix">
                                <label>Mã bảo mật</label>
                                {{ Form::captcha(array('theme' => 'white')); }}
                                </div>
                            @endif
                                <input type="submit" class="submit" value="Gửi">
                            </div>

                        </section>
                    </article>    
                </form>            