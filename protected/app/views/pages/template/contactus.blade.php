<section class="row_section" style='  '><div class="container"><div class="row"><div class="col-lg-9 col-md-9 col-sm-12 col-xs-12"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <section class="">
                      <section id="contact">
                            @if(Session::has('message_contact'))
                                 {{ Session::get('message_contact') }}
                            @endif
                            <ul class="parsley-error-list">
                              @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                              @endforeach
                            </ul>
                            <div class="itemcontact">
                            <form action="{{URL::to('')}}/home/contactform" method="post" name="contact_form" id="contact_form">
                                      <article class="contact-form">
                                        <h2><span>Liên hệ</span></h2>
                                          <div class="row">
                                          <div class="col-lg-12 col-md-12 col-xs-12"></div>
                                              <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                  <input type="text" class="input-contact" placeholder="Họ tên" name="name" id="name" value="{{$input['name']}}">
                                              </div>
                                              <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                  <input type="text" class="input-contact" placeholder="Điện thoại" name="phone" id="phone" value="{{$input['phone']}}">
                                              </div>
                                              <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                  <input type="text" class="input-contact" placeholder="Địa chỉ" name="address" id="address" value="{{$input['address']}}">
                                              </div>
                                              <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                  <input type="text" class="input-contact" placeholder="Email" name="email" id="email" value="{{$input['email']}}">
                                              </div>
                                              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                 <input type="text" class="input-contact" placeholder="Tiêu đề" name="subject" id="subject" value="{{$input['subject']}}">
                                              </div>
                                              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                  <textarea class="textarea" placeholder="Nội dung" name="content" id="content">{{$input['content']}}</textarea>
                                              </div>
                                              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                  @if(CNF_RECAPTCHA =='true') 

                                                    {{ Form::captcha(array('theme' => 'white')); }}

                                                  @endif
                                              </div>
                                            <input type="submit" class="submit" value="Gửi đi">
                                          </div>
                                      </article>  
                                    </form>  
              </div>
              </section> <!--End listitem-->
                   
                </section>




