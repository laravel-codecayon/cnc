<?php
class NcategoriesController extends BaseController {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'Ncategories';
	static $per_page	= '10';
	protected $img_width = 150;
	protected $img_height = 150;
	
	public function __construct() {
		parent::__construct();
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Ncategories();
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
		$this->lang = Session::get('lang') == '' ? CNF_LANG : Session::get('lang');
		$this->data = array(
			'pageTitle'	=> 	Lang::get('core.category'),
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'Ncategories',
			'trackUri' 	=> ''
		);
			
				
	} 

	
	public function getIndex()
	{
		if($this->access['is_view'] ==0) 
			return Redirect::to('')
				->with('message', SiteHelpers::alert('error',Lang::get('core.note_restric')));
				
		// Filter sort and order for query 
		$sort = (!is_null(Input::get('sort')) ? Input::get('sort') : 'CategoryID'); 
		$order = (!is_null(Input::get('order')) ? Input::get('order') : 'asc');
		// End Filter sort and order for query 
		// Filter Search for query		
		$filter = (!is_null(Input::get('search')) ? $this->buildSearch() : '');
		$filter .=  " AND lang = '$this->lang'";
		$filter .=  " AND CategoryID != 14";
		// End Filter Search for query 
		
		// Take param master detail if any
		$master  = $this->buildMasterDetail(); 
		// append to current $filter
		$filter .=  $master['masterFilter'];
	
		
		$page = Input::get('page', 1);
		$params = array(
			'page'		=> $page ,
			'limit'		=> (!is_null(Input::get('rows')) ? filter_var(Input::get('rows'),FILTER_VALIDATE_INT) : static::$per_page ) ,
			'sort'		=> $sort ,
			'order'		=> $order,
			'params'	=> $filter,
			'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
		);
		// Get Query 
		$results = $this->model->getRows( $params );		
		
		// Build pagination setting
		$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;	
		$pagination = Paginator::make($results['rows'], $results['total'],$params['limit']);		

		$test 						= $this->model->columnTable();
		$arr_search 				= SiteHelpers::arraySearch(Input::get('search'));
		foreach($arr_search as $key=>$val){
			if($key != "sort" && $key != "order" && $key != "rows"){
				$test[$key]['value'] = $val;
			}
		}
		$this->data['test'] = $test;
		
		
		$this->data['rowData']		= $results['rows'];
		// Build Pagination 
		$this->data['pagination']	= $pagination;
		// Build pager number and append current param GET
		$this->data['pager'] 		= $this->injectPaginate();	
		// Row grid Number 
		$this->data['i']			= ($page * $params['limit'])- $params['limit']; 
		// Grid Configuration 
		$this->data['tableGrid'] 	= $this->info['config']['grid'];
		$this->data['tableForm'] 	= $this->info['config']['forms'];
		$this->data['colspan'] 		= SiteHelpers::viewColSpan($this->info['config']['grid']);		
		// Group users permission
		$this->data['access']		= $this->access;
		// Detail from master if any
		$this->data['masterdetail']  = $this->masterDetailParam(); 
		$this->data['details']		= $master['masterView'];
		// Master detail link if any 
		$this->data['subgrid']	= (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array()); 
		// Render into template
		$this->layout->nest('content','Ncategories.index',$this->data)
						->with('menus', SiteHelpers::menus());
	}		
	

	function getAdd( $id = null)
	{
	
		if($id =='')
		{
			if($this->access['is_add'] ==0 )
			return Redirect::to('')->with('message', SiteHelpers::alert('error',Lang::get('core.note_restric')));
		}	
		
		if($id !='')
		{
			if($this->access['is_edit'] ==0 )
			return Redirect::to('')->with('message', SiteHelpers::alert('error',Lang::get('core.note_restric')));
		}				
			
		$id = ($id == null ? '' : SiteHelpers::encryptID($id,true)) ;
		
		$row = $this->model->find($id);
		if($row)
		{
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('categories'); 
		}
		/* Master detail lock key and value */
		if(!is_null(Input::get('md')) && Input::get('md') !='')
		{
			$filters = explode(" ", Input::get('md') );
			$this->data['row'][$filters[3]] = SiteHelpers::encryptID($filters[4],true); 	
		}
		/* End Master detail lock key and value */
		$this->data['masterdetail']  = $this->masterDetailParam(); 
		$this->data['filtermd'] = str_replace(" ","+",Input::get('md')); 		
		$this->data['id'] = $id;
		$this->layout->nest('content','Ncategories.form',$this->data)->with('menus', $this->menus );	
	}
	
	function getShow( $id = null)
	{
		if($this->access['is_detail'] ==0) 
			return Redirect::to('')
				->with('message', SiteHelpers::alert('error',Lang::get('core.note_restric')));
					
		$ids = (is_numeric($id) ? $id : SiteHelpers::encryptID($id,true)  );
		if($ids == 14){
			return Redirect::to('');
		}
		$row = $this->model->getRow($ids);
		if($row)
		{
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('categories'); 
		}
		$this->data['masterdetail']  = $this->masterDetailParam(); 
		$this->data['id'] = $id;
		$this->data['access']		= $this->access;
		$this->layout->nest('content','Ncategories.view',$this->data)->with('menus', $this->menus );	
	}	
	
	function postSave( $id =0)
	{
		$trackUri = $this->data['trackUri'];
		$rules = Ncategories::$rules;
		//$rules = $this->validateForm();
		if(Input::get('CategoryID') == ''){
			$ID = '';
			$rules["CategoryCode"] = "required|unique:categories,CategoryCode";
		}else{
			$ID = Input::get('CategoryID');
			$data_old = $this->model->getRow(Input::get('CategoryID'));
		}
		$validator = Validator::make(Input::all(), $rules);
		SiteHelpers::globalXssClean();
		if ($validator->passes()) {
			if(!is_null(Input::file('file')))
			{
				$file = Input::file('file');
				$destinationPath = ROOT.'/uploads/categories/';
				$filename = $file->getClientOriginalName();
				$extension = $file->getClientOriginalExtension(); //if you need extension of the file
				$newfilename = SiteHelpers::seoUrl( trim(Input::get('CategoryName'))).'_'.time().'.'.$extension;
				$uploadSuccess = Input::file('file')->move($destinationPath, $newfilename);
				if( $uploadSuccess ) {
				    $data['Picture'] = $newfilename;
				    $orgFile = $destinationPath.'/'.$newfilename;
				    $thumbFile = $destinationPath.'/thumb/'.$newfilename;
				    //SiteHelpers::cropImage($this->img_width , $this->img_height , $orgFile ,  $extension,	 $thumbFile);
				    SiteHelpers::resizewidth("263",$orgFile,$thumbFile);
				    if($ID != "")
				    {
				    	@unlink(ROOT .'/uploads/categories/'.$data_old->Picture);
				    	@unlink(ROOT .'/uploads/categories/thumb/'.$data_old->Picture);
				    }
				}
			}
			if(!is_null(Input::file('file2')))
			{
				$file2 = Input::file('file2');
				$destinationPath = ROOT.'/uploads/categories/';
				$filename = $file2->getClientOriginalName();
				$extension = $file2->getClientOriginalExtension(); //if you need extension of the file
				$newfilename = SiteHelpers::seoUrl( trim(Input::get('CategoryName'))).'_large_'.time().'.'.$extension;
				$uploadSuccess = Input::file('file2')->move($destinationPath, $newfilename);
				if( $uploadSuccess ) {
				    $data['Picture2'] = $newfilename;
				    $orgFile = $destinationPath.'/'.$newfilename;
				    $thumbFile = $destinationPath.'/thumb/'.$newfilename;
				    //SiteHelpers::cropImage($this->img_width , $this->img_height , $orgFile ,  $extension,	 $thumbFile);
				    SiteHelpers::resizewidth("698",$orgFile,$thumbFile);
				    if($ID != "")
				    {
				    	@unlink(ROOT .'/uploads/categories/'.$data_old->Picture2);
				    	@unlink(ROOT .'/uploads/categories/thumb/'.$data_old->Picture2);
				    }
				}
			}
			$data['CategoryCode'] = $ID == '' ?  Input::get('CategoryCode') :  $data_old->CategoryCode ;
			$data['CategoryName'] = Input::get('CategoryName');
			$data['Description'] = Input::get('Description');
			$data['lang'] = $this->lang;
			$data['created'] = time();
			$data['status'] = Input::get('status');
			$data['alias'] = SiteHelpers::seoUrl( trim($data['CategoryName']));
			//$data = $this->validatePost('categories');
			$ID = $this->model->insertRow($data , Input::get('CategoryID'));
			// Input logs
			if( Input::get('CategoryID') =='')
			{
				$this->inputLogs("New Entry row with ID : $ID  , Has Been Save Successfull");
				$id = SiteHelpers::encryptID($ID);
			} else {
				$this->inputLogs(" ID : $ID  , Has Been Changed Successfull");
			}
			// Redirect after save	
			//$md = str_replace(" ","+",Input::get('md'));
			$redirect = (!is_null(Input::get('apply')) ? 'Ncategories/add/'.$id :  'Ncategories?md=' );
			return Redirect::to($redirect)->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));
		} else {
			return Redirect::to('Ncategories/add/'.$id)->with('message', SiteHelpers::alert('error',Lang::get('core.note_error')))
			->withErrors($validator)->withInput();
		}	
	
	}
	
	public function postDestroy()
	{
		
		if($this->access['is_remove'] ==0) 
			return Redirect::to('')
				->with('message', SiteHelpers::alert('error',Lang::get('core.note_restric')));		
		// delete multipe rows 
		$array = Input::get('id');
		foreach($array as $key=>$id){
			if($id == 14){
				unset($array[$key]);
			}
			$data = $this->model->getRow($id);
			@unlink(ROOT .'/uploads/categories/'.$data->Picture);
			@unlink(ROOT .'/uploads/categories/thumb/'.$data->Picture);
			@unlink(ROOT .'/uploads/categories/'.$data->Picture2);
			@unlink(ROOT .'/uploads/categories/thumb/'.$data->Picture2);
			DB::table('products')->where('CategoryID','=',$id)->update(array('CategoryID'=>14));
		}
		$this->model->destroy($array);
		$this->inputLogs("ID : ".implode(",",Input::get('id'))."  , Has Been Removed Successfull");
		// redirect
		Session::flash('message', SiteHelpers::alert('success',Lang::get('core.note_success_delete')));
		return Redirect::to('Ncategories?md='.Input::get('md'));
	}			
		
}