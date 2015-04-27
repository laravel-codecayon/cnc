{{ HTML::script('sximo/themes/shop/js/jquery.jcombo.min.js') }}
<div class="container">
			<div class="box new-post">
                <h2>Đăng tin miễn phí</h2>
                <p>Vậy còn chờ gì ? Hãy tham gia ngay!</p>
                @if(Session::has('message_dangtin'))
                     {{ Session::get('message_dangtin') }}
                @endif
                <ul class="parsley-error-list">
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
                <form method="post" action="{{URL::to('')}}/home/dangtin" enctype="multipart/form-data">
                	<div class="input-group">
                      <label>Bạn là </label>
                      <label class="type left"><span><input type="radio" name="post_typecustomer" @if( $input['post_typecustomer'] != '' && $input['post_typecustomer'] == 1  ) checked @endif value="1"></span> Hành khách</label>
                      <span> hay </span>
                      <label class="type right"><span><input type="radio" name="post_typecustomer" @if( $input['post_typecustomer'] != '' && $input['post_typecustomer'] == 0  ) checked @endif value="0"></span> Tài xế</label>
                    </div>
                    <div class="devide clearfix"></div>
                    <div class="input-group">
                      <label>Tiêu đề</label>
                      <input type="text" value="{{$input['post_subject']}}" name="post_subject" class="form-control">
                    </div>
                    <div class="devide clearfix"></div>
                    <div class="place">
                    	 <div class="input-group place">
                          	<label>Nơi xuất phát</label>
                          	<select id="city_from" name="post_provincefrom" class="form-control">
                          	</select>
                          	<select id="district_from" name="post_districtfrom" class="form-control">
                          	</select>
                          	<input type="text" class="form-control" value="{{$input['post_addressfrom']}}" name="post_addressfrom" placeholder="Địa chỉ chi tiết">
                      	</div>
                    </div><!-- place -->
                    <div class="devide clearfix"></div>
                    <div class="place">
                    	 <div class="input-group place">
                          	<label>Nơi đến</label>
                          	<select id="city_to" name="post_provinceto" class="form-control">
                          	</select>
                          	<select id="district_to" name="post_districtto" class="form-control">
                          	</select>
                          	<input type="text" class="form-control" value="{{$input['post_addressto']}}" name="post_addressto" placeholder="Địa chỉ chi tiết">
                      	</div>
                    </div><!-- place -->
                    <div class="devide clearfix"></div>
                 	<div class="input-group date">
                    <label>Ngày xuất phát</label>
                        <input name="post_datestar" value="{{$input['post_datestar']}}" type="text" data-beatpicker="true" data-beatpicker-format="['DD','MM','YYYY'],separator:'-'" data-beatpicker-position="['right','bottom']" data-beatpicker-disable="{from:[1970 , 2 , 2],to:[{{date("Y")}} , {{(int)date("m")}}  , <?php echo (date("d") -1 ) ?> ]}"/>
                	</div>
                    <div class="devide clearfix"></div>
                    <div class="column left">
                   		<div class="input-group">
                          <label>Giá</label>
                          <input name="post_price" type="text"  class="form-control" value="{{$input['post_price']}}">
                        </div>
                    </div><!-- column -->
                    <div class="column right">
                        <div class="input-group">
                          <label>Loại xe</label>
                          <input name="post_typecar" type="text" value="{{$input['post_typecar']}}" class="form-control">
                        </div>
                    </div><!-- column -->
                    <div class="devide clearfix"></div>
                    <div class="column left">
                   		<div class="input-group">
                          <label>Ghi chú thêm</label>
                          <textarea  name="post_note">{{$input['post_note']}}</textarea>
                        </div>
                    </div><!-- column -->
                    <div class="column right">
                   		<div class="input-group">
                          <label>Đính kèm file</label>
                          <input type="file" name="post_file1">
                          <input type="file" name="post_file2">
                        </div>
                    </div><!-- column -->
                    <div class="devide clearfix"></div>
                    <div class="box info-user">
                    	<label>Thông tin liên hệ</label>
                    	<table>
                        	<tr><td>Tên</td><td><input type="text" class="form-control" id="name" value="{{$input['name']}}" name="name"></td></tr>
                            <tr><td>Số điện thoại</td><td><input type="text" id="phone" class="form-control" value="{{$input['phone']}}" name="phone"></td></tr>
                            <tr><td>Địa chỉ</td><td><input type="text" id="address" class="form-control" value="{{$input['address']}}" name="address"></td></tr>
                        </table>
                    </div><!-- info-user -->
                    <div class="box info-user">
                      <label>Mã bảo mật</label>
                      <table>
                          <tr><td> @if(CNF_RECAPTCHA =='true') 

                        {{ Form::captcha(array('theme' => 'white')); }}

                      @endif</td></tr>
                        </table>
                    </div><!-- info-user -->
                    <div class="devide clearfix"></div>
                  	<button type="submit" class="btn btn-default submit">Đăng tin</button>
                </form>
			</div>
        </div><!-- container -->
        {{ HTML::style('sximo/themes/uber/css/BeatPicker.min.css')}}
        {{ HTML::script('sximo/themes/uber/js/BeatPicker.min.js') }}
        <script type="text/javascript">
          $(document).ready(function() { 
            $("#city_from").jCombo("{{ URL::to('ward/comboselect?filter=province:provinceid:name') }}",
            {  selected_value : "{{$input['post_provincefrom']}}",initial_text: "-- Tỉnh/Thành --", });
            $("#city_from").on('change', function() {
              var val = this.value ; 
              $("#district_from").jCombo("{{ URL::to('ward/comboselect?filter=district:districtid:name:') }}"+val,
            {  selected_value : "{{$input['post_districtfrom']}}",initial_text: "-- Quận/Huyện --", });
            });
            $("#city_to").jCombo("{{ URL::to('ward/comboselect?filter=province:provinceid:name') }}",
            {  selected_value : "{{$input['post_provinceto']}}",initial_text: "-- Tỉnh/Thành --", });
            $("#city_to").on('change', function() {
              var val = this.value ; 
              $("#district_to").jCombo("{{ URL::to('ward/comboselect?filter=district:districtid:name:') }}"+val,
            {  selected_value : "{{$input['post_districtto']}}",initial_text: "-- Quận/Huyện --", });
            });
          });
        </script>
