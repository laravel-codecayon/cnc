{{ HTML::script('sximo/js/plugins/tinymce/jscripts/tiny_mce/jquery.tinymce.js')}}
{{ HTML::script('sximo/js/plugins/tinymce/jscripts/tiny_mce/tiny_mce.js')}}
  <div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> SXIMO VERSION  <small>{{ Lang::get('core.t_generalsettingsmall'); }}</small></h3>
      </div>
	  
	 
	  <ul class="breadcrumb">
		<li><a href="{{ URL::to('dashboard') }}">{{ Lang::get('core.home'); }}</a></li>
		<li><a href="{{ URL::to('config') }}">{{ Lang::get('core.t_generalsetting'); }}</a></li>
	  </ul>	  
	 
    </div>
 	<div class="page-content-wrapper">   
	@if(Session::has('message'))
	  
		   {{ Session::get('message') }}
	   
	@endif
	<ul class="parsley-error-list">
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>		
<div class="block-content">
	<ul class="nav nav-tabs" >
	  <li ><a href="{{ URL::to('config')}}"> {{ Lang::get('core.tab_siteinfo'); }}  </a></li>
	  <!--<li ><a href="{{ URL::to('config/email') }}" >  {{ Lang::get('core.tab_email'); }} </a></li>
	  <li ><a href="{{ URL::to('config/security') }}" >  {{ Lang::get('core.tab_loginsecurity'); }}  </a></li>
	  <li ><a href="{{ URL::to('config/translation') }}" >  Translation  <sup class="badge " style="background:#5BC0DE" >New </sup> </a></li>-->
	   <li ><a href="{{ URL::to('config/log') }}" >  Clear Cache & Logs  </a></li>
	   <li class="active"><a href="{{ URL::to('config/templateemail') }}" >  Email Template  </a></li>
	</ul>	
<div class="tab-content m-t">
  <div class="tab-pane active use-padding" id="info">	
 {{ Form::open(array('url'=>'config/save/', 'class'=>'form-horizontal row')) }}

<div class="col-sm-12">
  <div class="form-group">
    <label for="ipt" class=" control-label col-md-4">Chọn Email Template </label>
	<div class="col-md-8">
	<select name='email_template' rows='5' id='email_template'  class='select2 '    >
		<option value="">-- Chọn Email template</option>
		@foreach($arr_file as $key=>$file)
			<option value="{{$key}}">{{$file}}</option>
		@endforeach
	</select> 
	 </div> 
  </div>  
  
  <div class="form-group">
    <label  class=" control-label col-md-4">Content footer</label>
	<div class="col-md-8">
		<textarea class="form-control input-sm mceEditor" row='10' clos="10" id="content"  name="content"></textarea>
	 </div> 
  </div>
	<div class="form-group">
    <label for="ipt" class=" control-label col-md-4">&nbsp;</label>
	<div class="col-md-8">
		<button class="btn btn-primary" type="submit">{{ Lang::get('core.sb_savechanges'); }} </button>
	 </div> 
  </div> 
</div>

 {{ Form::close() }}

</div>
</div>
</div>
</div>

<script type="text/javascript">
	$(document).ready(function() { 

		$("#email_template").change(function(){
			var url = $(this).val();
			if(url == ''){
				return false;
			}
			var link = "{{URL::to('')}}/config/templateemail";
			$.post( link,{url : url}, function( data ) {
				tinymce.get('content').setContent(data);
			});
		});

		$(function(){
		tinymce.init({	
			mode : "specific_textareas",
			editor_selector : "mceEditor",
			 plugins : "openmanager",
			 file_browser_callback: "openmanager",
			 theme_advanced_buttons3 : "forecolor , backcolor ,forecolorpicker, backcolorpicker , fontselect, fontsizeselect ",
			 open_manager_upload_path: '../../../../../../../../uploads/images/',
		 });
	});

	});
</script>




