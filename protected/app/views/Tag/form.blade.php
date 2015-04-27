
  <div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
      </div>
      <ul class="breadcrumb">
        <li><a href="{{ URL::to('dashboard') }}">{{ Lang::get('core.home') }}</a></li>
		<li><a href="{{ URL::to('Tag?md='.$filtermd) }}">{{ $pageTitle }}</a></li>
        <li class="active">{{ Lang::get('core.addedit') }} </li>
      </ul>
	  	  
    </div>
 
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
		 {{ Form::open(array('url'=>'Tag/save/'.SiteHelpers::encryptID($row['tags_id']).'?md='.$filtermd.$trackUri, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
				<div class="col-md-12">
						<fieldset><legend> Tags</legend>

									  {{ Form::hidden('tags_id', $row['tags_id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 
								  <div class="form-group  " >
									<label for="Tags Name" class=" control-label col-md-4 text-left"> Tên tag </label>
									<div class="col-md-6">
									  {{ Form::text('tags_name', $row['tags_name'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
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
				<button type="button" onclick="location.href='{{ URL::to('Tag?md='.$masterdetail["filtermd"].$trackUri) }}' " id="submit" class="btn btn-success ">  {{ Lang::get('core.sb_cancel') }} </button>
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