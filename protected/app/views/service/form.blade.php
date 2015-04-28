<script src="http://ajax.microsoft.com/ajax/jquery.templates/beta1/jquery.tmpl.min.js"></script>
{{ HTML::script('sximo/js/preview-image/modernizr.custom.js')}}
{{ HTML::script('sximo/js/preview-image/script.js')}}
<script id="imageTemplate" type="text/x-jquery-tmpl"> 
    <div class="imageholder">
		<figure>
			<img src="${filePath}" alt="${fileName}"/>
			<figcaption>
			</figcaption>
		</figure>
	</div>
</script>
  <div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
      </div>
      <ul class="breadcrumb">
        <li><a href="{{ URL::to('dashboard') }}">{{ Lang::get('core.home') }}</a></li>
		<li><a href="{{ URL::to('service?md='.$filtermd) }}">{{ $pageTitle }}</a></li>
        <li class="active">{{ Lang::get('core.addedit') }} </li>
      </ul>
	  	  
    </div>
 <input type="hidden" value="360" id="imgwidth" />
 	<input type="hidden" value="283" id="imgheight" />
 	<input type="hidden" value="132" id="imgwidth2" />
 	<input type="hidden" value="66" id="imgheight2" />
 	<div class="page-content-wrapper">
	<div class="panel-default panel">
		<div class="panel-body">
		@if(Session::has('message'))	  
			   {{ Session::get('message') }}
		@endif	
		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
		 {{ Form::open(array('url'=>'service/save/'.SiteHelpers::encryptID($row['service_id']).'?md='.$filtermd.$trackUri, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
				<div class="col-md-12">
						<fieldset><legend> Service</legend>

									  {{ Form::hidden('service_id', $row['service_id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 

								  <div class="form-group  " >
									<label for="Service Name" class=" control-label col-md-4 text-left"> Service Name </label>
									<div class="col-md-6">
									  {{ Form::text('service_name', $row['service_name'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 					
								  <div class="form-group  " >
									<label for="Service Description" class=" control-label col-md-4 text-left"> Service Description </label>
									<div class="col-md-6">
									  <textarea name='service_description' rows='2' id='service_description' class='form-control '  
				           >{{ $row['service_description'] }}</textarea> 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 					
								  <div class="form-group  " >
									<label for="Picture" class=" control-label col-md-4 text-left"> Image </label>
									<div class="col-md-6">
									  <input id="upload" name="file" type="file" />
									  	<div id="result">
											@if($row['service_image'] != "")
												<img width="360px" src="/uploads/service/thumb/{{$row['service_image']}}">
											@endif
										</div>
									 </div> 
									 <div class="col-md-2">
									 </div>
								  </div> 					
								  <div class="form-group  " >
									<label for="Picture" class=" control-label col-md-4 text-left"> icon </label>
									<div class="col-md-6">
									  <input id="upload2" name="file2" type="file" />
									  <div id="result2">
											@if($row['service_icon'] != "")
												<img  src="/uploads/service/icon/{{$row['service_icon']}}">
											@endif
										</div>
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Status" class=" control-label col-md-4 text-left"> Status </label>
									<div class="col-md-6">
									  <label class='checked'>
										<input type='radio' name='status' value ='0' required @if($row['status'] == '0' || $row['status'] == '') checked="checked" @endif > {{ Lang::get('core.disable') }} </label>
										<label class='checked'>
										<input type='radio' name='status' value ='1' required @if($row['status'] == '1') checked="checked" @endif > {{ Lang::get('core.enable') }} </label>  
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div>
								   </fieldset>
			</div>
			
			
			<div style="clear:both"></div>	
				
			  <div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">	
				<input type="submit" name="apply" class="btn btn-info" value="{{ Lang::get('core.sb_apply') }} " />
				<input type="submit" name="submit" class="btn btn-primary" value="{{ Lang::get('core.sb_save') }}  " />
				<button type="button" onclick="location.href='{{ URL::to('service?md='.$masterdetail["filtermd"].$trackUri) }}' " id="submit" class="btn btn-success ">  {{ Lang::get('core.sb_cancel') }} </button>
				</div>	  
		
			  </div> 
		 
		 {{ Form::close() }}
		</div>
	</div>	
</div>	
</div>			 
   <script type="text/javascript">
	$(document).ready(function() { 
		 
	});
	</script>		 