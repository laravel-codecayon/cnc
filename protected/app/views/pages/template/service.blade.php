<div id="services-page">
        <div id="services" class="block">
            <div class="top container move"><img src="{{ asset('sximo/themes/dongho/images/service-icon.png')}}"><h2>{{LANG::get('layout.our_perfect_service')}}</h2></div>
            <p class="container move">{{LANG::get('layout.notice_first_service')}}</p>
            <div class="container content move">
            	<div class="row">
            		<?php
            		$i = 0;
            		foreach($services as $item){

            			echo SiteHelpers::templateService($item);
                    	$i++;
                    }
                    ?>
					@if($i>= 6)
                    <div id="div_seemore" class="col-md-12"><a class="more move" id="service_more" href="javascript:void(0);">{{LANG::get('layout.see_more')}}</a></div>
            		@endif
            	</div><!-- row -->
            </div>
        </div><!-- block -->
        <input type="hidden" id="num_service" value="{{$i}}" />
        <div class="map clearfix"></div><!-- map -->
    </div><!-- contact-page -->
    <script type="text/javascript">
                $(document).ready(function() {
                    $("#service_more").click(function(event) {
                    	var num = $("#num_service").val();
                        var link = "{{URL::to('home/moreservice')}}";
                        $.post(link,{num:num},function(data,status){
                        	if(data != ''){
                        		var ex = data.split('&&&&&');
                        		$("#div_seemore").before(ex[0]);
                        		$("#num_service").val(ex[1]);
                        	}else{
                        		//$("#div_seemore").attr('disable','disable');
                        	}
                          });
                    });
                });
            </script>