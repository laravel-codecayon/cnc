{{ HTML::script('sximo/themes/dongho/js/jquery.jcombo.min.js') }}
{{ HTML::style('sximo/themes/dongho/css/BeatPicker.min.css')}}
{{ HTML::script('sximo/themes/dongho/js/BeatPicker.min.js') }}
<section class="row_section" style='  '><div class="container"><div class="row"><div class="col-lg-9 col-md-9 col-sm-12 col-xs-12"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><section class="clearfix">       

      <section class="breadcrumbs clearfix">
          <a href="{{URL::to('')}}" title="Trang chủ"><i class="fa fa-home"></i></a>

                &nbsp;&nbsp;/&nbsp;&nbsp;<a href="#">Đăng ký thành viên</a>
                                      </section>

</section></div></div><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  @if(Session::has('message_dangky'))
                     {{ Session::get('message_dangky') }}
                @endif
                <ul class="parsley-error-list">
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
   <section class="">

           <form method="post" id="register" class="cmxform" action="{{URL::to('home/dangky')}}" >
        <input type="hidden" name="act" value="add">

      <div  id="register_has_been_successed">
                  <section id="signup" class="clearfix" >
            <div class="row">
              <div class="col-lg-12">
                <section class="block">
                  <div class="heading">Thông tin cá nhân</div>
                    <div class="main-inner">
                                          <p class="title">Thông tin cá nhân của bạn</p>
                                            <div class="clearfix">
                        <label for="name">Tên</label>
                                                <input class="input" type="text" id="user_first_name" name="name" value="{{$input['name']}}">
                      </div>

                      <div class="clearfix">
                        <label for="username"> Tên truy cập</label>
                        <input type="text" class="input" id="username" name="username" value="{{$input['username']}}" >
                      </div>
                      <div class="clearfix">
                        <label for="password">Mật Khẩu</label>
                        <input class="input" type="password" id="password" name="password" value="">
                      </div>
                      <div class="clearfix">
                        <label for="repassword">Nhập lại Mật Khẩu</label>
                        <input class="input" type="password" name="repassword" value="">
                      </div>
                      <div class="clearfix">
                        <label for="birthday">Ngày sinh</label>
                        <input class="input" name="birthday" value="{{$input['birthday']}}" type="text" data-beatpicker="true" data-beatpicker-format="['DD','MM','YYYY'],separator:'-'" />
                      </div>
                                            <div class="clearfix">
                                            <label for="user_phone">Giới tính </label>
                                              <select name="sex">
                                                  <option @if($input['sex'] == 1) selected @endif value="1">Nam </option>
                                                    <option @if($input['sex'] == 0) selected @endif value="0">Nữ </option>
                                                    <option @if($input['sex'] == 2) selected @endif value="2">Khác </option>
                                                </select>

                      </div>
                                            <div class="clearfix">
                        <label for="phone">Số Điện Thoại</label>
                        <input class="input" maxlength="40" type="text" id="phone" name="phone" value="{{$input['phone']}}">
                      </div>      
                      <div class="clearfix">
                        <label for="email">Địa chỉ Email</label>
                        <input class="input" type="text" id="email" name="email" value="{{$input['email']}}">
                      </div>

                                            <p class="title">Địa chỉ của bạn</p>

                                            <div class="clearfix">
                                              <label>Địa chỉ </label>
                                              <input type="text" class="input user_address_1" name="address" value="{{$input['address']}}">
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
                        <label for="email">Mã bảo mật</label>
                          {{ Form::captcha(array('theme' => 'white')); }}
                          </div>
                        @endif
                        
                      
                        <input type="submit" class="submit" value="Đăng ký">
                    </div>
                </section>

              </div>
            </div><!--End Row-->
        </section> <!--End listitem-->
      </div> <!--End row--> 
    </form>  <div id="cssmenu"></div> 
  <div id="tooltip"></div>
</section>
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
