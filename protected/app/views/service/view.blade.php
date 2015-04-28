<div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
      </div>
      <ul class="breadcrumb">
        <li><a href="{{ URL::to('config/dashboard') }}">{{ Lang::get('core.home') }}</a></li>
		<li><a href="{{ URL::to('service?md='.$masterdetail["filtermd"]) }}">{{ $pageTitle }}</a></li>
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
	 </div>  
	 
	 
 	<div class="page-content-wrapper">   
	   <div class="toolbar-line">
	   		<a href="{{ URL::to('service?md='.$masterdetail["filtermd"].$trackUri) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_back') }}"><i class="icon-table"></i>&nbsp;{{ Lang::get('core.btn_back') }}</a>
			@if($access['is_add'] ==1)
	   		<a href="{{ URL::to('service/add/'.$id.'?md='.$masterdetail["filtermd"].$trackUri) }}" class="tips btn btn-xs btn-primary" title="{{ Lang::get('core.btn_edit') }}"><i class="icon-pencil3"></i>&nbsp;{{ Lang::get('core.btn_edit') }}</a>
			@endif  		   	  
		</div>
	<div class="table-responsive">
	<table class="table table-striped table-bordered" >
		<tbody>	
	
					<tr>
						<td width='30%' class='label-view text-right'>Service Id</td>
						<td>{{ $row->service_id }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Service Name</td>
						<td>{{ $row->service_name }} </td>
						
					</tr>
			
				
					<tr>
						<td width='30%' class='label-view text-right'>Service Description</td>
						<td>{{ $row->service_description }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Status</td>
						<td>@if($row->status == 1) {{ Lang::get('core.enable') }}  @else {{ Lang::get('core.disable') }}  @endif  </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Created</td>
						<td>{{date('Y-m-d',$row->created)}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Service Image</td>
						<td><img src="/uploads/service/thumb/{{ $row->service_image }}" /> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Service Icon</td>
						<td><img src="/uploads/service/icon/{{ $row->service_icon }}" /> </td>
						
					</tr>

				
		</tbody>	
	</table>    
	</div>
	</div>
</div>
	  