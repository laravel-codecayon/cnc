<div class="zoom-anim-dialog mfp-hide" id="login">
                                 
                                        <div class="popup-header">
                                          
                                          <h4 class="modal-title" id="myModalLabel">Đăng nhập</h4>
                                        </div>
                                      
                                         
                                            <div class="popup-body">
                                            <div class="noti-error login_notify" style="display:none"></div>
                                            
                                            <form action="#" method="post">
                                                <input type="text" placeholder="Tài khoản" class="login" name="username" id="login_user_name">
                                                <input type="password" placeholder="Mật khẩu" class="login" name="password" id="login_user_pass">
                                            <div class="block">
                                                <input type="button" class="submit_login" value="Đăng nhập" onClick="customer_login('{{URL::to('/home/dangnhapajax')}}');">
                                                 <a class='regislink' href="{{URL::to('')}}/quen-mat-khau.html" class="lostpass">Quên mật khẩu ?</a> 
                                                <a class='regislink' href="{{URL::to('')}}/dang-ky.html" class="lostpass">Tạo tài khoản</a>
                                                <a class="regislink shipping_register"  href="#news_pop_create_new_customer" id="new_customer_common"  style="display:none" id="shipping_register"></a><!--use for paging shipping method-->



                                                <!--a href="#" class="lostpass">Quên mật khẩu ?</a-->
                                            </div>
                                            </form>
											<Script language="javascript">
                                            function customer_login(url)
                                            {
                                                var login_user_name=jQuery('#login_user_name').val();
                                                var login_user_pass=jQuery('#login_user_pass').val();
                                                jQuery(".login_notify").show();
                                                if(login_user_name.length=="" || login_user_pass.length==""){
                                                        jQuery(".login_notify").html('Tài khoản và mật khẩu không được bỏ trống');
                                                }else{												
                                                        jQuery(".login_notify").html('Loading..');               

                                                        jQuery.post(url, {username:login_user_name, password: login_user_pass}).done(function( data ) {
                                                        if(data==1)
                                                        {
                                                        jQuery(".login_notify").html('Đăng nhập thành công');
                                                        window.setTimeout('location.reload()', 1000);
                                                        }
                                                        else if(data==2)
                                                        {
                                                        jQuery(".login_notify").html('Tài khoản của bạn đã bị khóa');        
                                                        }
                                                        else{
                                                        //login success
                                                        jQuery(".login_notify").html('Sai tên đăng nhập hoặc mật khẩu !');
														
                                                        
                                                        }
                                                })
                                                }
                                            }
                                            </script>
                                                                                        
                                        </div>
                                      
                                  </div>
                                  
                                  
                                
                              {{ HTML::script('sximo/themes/dongho/js/jquery.magnific-popup.min.js') }}
                                <!--Don't move the js file above-->
								<script>
                                $(document).ready(function() {
                                    $('.popup-with-zoom-anim').magnificPopup({
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
                                });
                                </script>