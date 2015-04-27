<div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
      </div>
      <ul class="breadcrumb">
        <li><a href="{{ URL::to('config/dashboard') }}">{{ Lang::get('core.home') }}</a></li>
		<li><a href="{{ URL::to('post?md='.$masterdetail["filtermd"]) }}">{{ $pageTitle }}</a></li>
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
	 </div>  
	 
	 
 	<div class="page-content-wrapper">   
	   <div class="toolbar-line">
	   		<a href="{{ URL::to('post?md='.$masterdetail["filtermd"].$trackUri) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_back') }}"><i class="icon-table"></i>&nbsp;{{ Lang::get('core.btn_back') }}</a>
			@if($access['is_add'] ==1)
	   		<a href="{{ URL::to('post/add/'.$id.'?md='.$masterdetail["filtermd"].$trackUri) }}" class="tips btn btn-xs btn-primary" title="{{ Lang::get('core.btn_edit') }}"><i class="icon-pencil3"></i>&nbsp;{{ Lang::get('core.btn_edit') }}</a>
			@endif  		   	  
		</div>
	<div class="table-responsive">
	<table class="table table-striped table-bordered" >
		<tbody>	
	
					<tr>
						<td width='30%' class='label-view text-right'>ID</td>
						<td>{{ $row->post_id }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Loại KH</td>
						<td>@if($row->post_typecustomer == 0) Khách hàng @else Tài xế @endif </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Tiêu đề</td>
						<td>{{ $row->post_subject }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Nơi đi</td>
						<td><?php echo $row->post_addressfrom .' - ' .SiteHelpers::getNameaddress($row->post_provincefrom,'province','provinceid').' - ' .SiteHelpers::getNameaddress($row->post_districtfrom,'district','districtid') ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Nơi đến</td>
						<td><?php echo $row->post_addressto .' - ' .SiteHelpers::getNameaddress($row->post_provinceto,'province','provinceid').' - ' .SiteHelpers::getNameaddress($row->post_districtto,'district','districtid') ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Ngày xuất phát</td>
						<td>{{date('d-m-Y',$row->post_datestar)}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Post Price</td>
						<td>{{number_format($row->post_price,0,',','.') }} VNĐ </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Post Typecar</td>
						<td>{{ $row->post_typecar }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Post Note</td>
						<td>{{ $row->post_note }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Tập tin đính kèm 1</td>
						<td>{{ $row->post_file1 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Tập tin đính kèm 2</td>
						<td>{{ $row->post_file2 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Tên</td>
						<td>{{ $row->name }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Điện thoại</td>
						<td>{{ $row->phone }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Địa chỉ</td>
						<td>{{ $row->address }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Created</td>
						<td>{{date('Y-m-d',$row->created)}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Trạng thái</td>
						<td>@if($row->status == 1) {{ Lang::get('core.enable') }}  @else {{ Lang::get('core.disable') }}  @endif  </td>
						
					</tr>
				
		</tbody>	
	</table>    
	</div>
	</div>
</div>
	  