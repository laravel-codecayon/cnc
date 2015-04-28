<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
	protected  $perpage = 12;

	public function __construct() {

		parent::__construct();
		$this->lang = Session::get('lang') == '' ? CNF_LANG : Session::get('lang');
		if($_SERVER['REMOTE_ADDR'] == "14.161.4.12"){
			$this->layout = "layouts.donghonew.index";
			$this->theme = "donghonew";
		}else{
			$this->layout = "layouts.".CNF_THEME.".index";
			$this->theme = "template";
		}
		$this->display = Session::get('display') == '' ? "gird" : Session::get('display');

		$host = $_SERVER['HTTP_HOST'];
		$url = $_SERVER['REQUEST_URI'];
		$this->data['detail_url'] = $host . $url;
		$this->data['description'] = CNF_METADESC;
		$this->data['image'] = ROOT .'/sximo/themes/dongho/images/logo-footer.png';
		$this->data['width'] = "200";
		$this->data['height'] = "125";
	}

	public function postTest(){
		$file = Input::file('file');
				$destinationPath = './uploads/products/test/';
				$filename = $file->getClientOriginalName();
				$extension = $file->getClientOriginalExtension(); //if you need extension of the file
				$newfilename = "test22222222."."jpg";
				$uploadSuccess = Input::file('file')->move($destinationPath, $newfilename);
				die;
	}


	public function pdf(){
		$parameterr = array();
        $parameter['param'] = "Hello Dung!!";
		$pdf = App::make('dompdf');
        $pdf->loadView('print_pdf/test',$parameter);
        return $pdf->stream('Hello.pdf');
	}

	public function dangky(){
		if(Session::has('customer')){
			return Redirect::to('change-info.html');
		}
		$this->data['pageTitle'] = "Đăng ký";
		$this->data['pageNote'] = CNF_APPNAME;

		$input = array(
				'username'	=>'',
				'name'	=>'',
				'sex'	=>'1',
				'phone'	=>'',
				'email'	=>'',
				'address'	=>'',
				'provinceid'	=>'79',
				'districtid'	=>'',
				'wardid'	=>'',
				'birthday'	=>'',
			);
		if(Session::has('input_rd')){
			$input = Session::get('input_rd');
		}
		$data['input'] = $input;

		//$this->data['breadcrumb'] = 'inactive';
		$page = 'pages.template.dangky';


		$page = SiteHelpers::renderHtml($page);
		$this->layout->nest('content',$page,$data)->with('page', $this->data)->with('menu','dangky');
	}

	public function postDangky(){
		$rules = Customer::$rules;
		if(CNF_RECAPTCHA =='true') $rules['recaptcha_response_field'] = 'required|recaptcha';

		$validator = Validator::make(Input::all(), $rules);
		if ($validator->passes()) {
			$data = $this->getDataPost('customer');
			//print_r($data);die;
			$data['created'] = time();
			$data['password'] = md5($data['password']);
			$data['code'] = md5(time());
			$data['birthday'] = strtotime($data['birthday']);
			$mdCus = new Customer();

			if(!is_null(Input::file('file')))
			{
				$file = Input::file('file');
				$destinationPath = './uploads/customer/';
				$filename = $file->getClientOriginalName();
				$extension = $file->getClientOriginalExtension(); //if you need extension of the file
				$newfilename = time().'.'.$extension;
				$uploadSuccess = Input::file('file')->move($destinationPath, $newfilename);
				if( $uploadSuccess ) {
				    $data['image'] = $newfilename;
				    $orgFile = $destinationPath.'/'.$newfilename;
				    $thumbFile = $destinationPath.'/thumb/'.$newfilename;
				    SiteHelpers::resizewidth("193",$orgFile,$thumbFile);
				}
			}

			$ID = $mdCus->insertRow($data , Input::get('customer_id'));
			$data_message = array('name'=>Input::get('name'),'code'=>$data['code'],'email'=>Input::get('email'),'password'=>Input::get('password')); 
			Mail::send('emails.dangky', $data_message, function($message)
			{
				$message->from( CNF_EMAIL, 'Admin' );
			    $message->to(Input::get('email'), Input::get('name'))->subject('Kích hoạt tài khoản');
			});
			return Redirect::to('')->with('message', SiteHelpers::alert('success','Đăng ký thành công ! Email kích hoạt dã được gửi vào Email của bạn Vui lòng kích hoạt !'));
		}
		else{
			return Redirect::to('dang-ky.html')->with('message_dangky', SiteHelpers::alert('error','Vui lòng xác nhận các thông tin bên dưới'))->with('input_rd',Input::all())->withErrors($validator)->withInput();
		}
	}

	public function getActivation(){
		if(!isset($_GET['code']) || $_GET['code'] == ''){
			return Redirect::to('');
		}
		$code = $_GET['code'];
		$customer = DB::table('customer')->where('code','=',$code)->first();
		if(count($customer) <= 0){
			return Redirect::to('');
		}
		$data['code'] = '';
		$data['status'] = '1';
		DB::table('customer')->where('customer_id','=',$customer->customer_id)->update($data);
		return Redirect::to('')->with('message', SiteHelpers::alert('success','Kích hoạt thành công ! Hãy đăng nhập ngay để tham gia với chúng tôi !'));
	}

	public function getDangnhap(){
		$this->data['pageTitle'] = "Đăng nhập";
		$this->data['pageNote'] = CNF_APPNAME;


		//$this->data['breadcrumb'] = 'inactive';
		$page = 'pages.template.dangnhap';


		$page = SiteHelpers::renderHtml($page);
		$this->layout->nest('content',$page)->with('page', $this->data)->with('menu','dangnhap');
	}

	public function postDangnhap(){
		$rules = array(
			'username'=>'required',
			'password'=>'required',
		);		
		if(CNF_RECAPTCHA =='true') $rules['recaptcha_response_field'] = 'required|recaptcha';
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->passes()) {
			$cus = DB::table('customer')->where('username', '=',Input::get('username'))->where('status','=','1')->where('password','=',md5(Input::get('password')))->first();
			if(count($cus)>0){
				$arr_cus = array('id'=>$cus->customer_id, 'name'=>$cus->name, "email"=>$cus->email, 'image'=>$cus->image);
				Session::put('customer',$arr_cus);
				Session::save();
				return Redirect::to('');
			}else{
				return Redirect::to('home/dangnhap')->with('message_dangnhap', SiteHelpers::alert('error','Sai tên đăng nhập hoặc mật khẩu'));
			}
		}
		else{
			return Redirect::to('home/dangnhap')->with('message_dangnhap', SiteHelpers::alert('error','Vui lòng xác nhận các thông tin bên dưới'))->withErrors($validator)->withInput();
		}
		
	}

	public function postDangnhapajax(){
		$cus = DB::table('customer')->where('username', '=',Input::get('username'))->where('password','=',md5(Input::get('password')))->first();
		if(count($cus)>0){
			if($cus->status == 0){
				echo "2";die;
			}
			$arr_cus = array('id'=>$cus->customer_id, 'name'=>$cus->name, "email"=>$cus->email, 'image'=>$cus->image, 'username'=>$cus->username);
			Session::put('customer',$arr_cus);
			Session::save();
			echo "1";
		}else{
			echo "0";
		}
		die();
	}

	public function forgotpass(){
		$this->data['pageTitle'] = "Quên mật khẩu";
		$this->data['pageNote'] = CNF_APPNAME;


		//$this->data['breadcrumb'] = 'inactive';
		$page = 'pages.template.forgotpass';


		$page = SiteHelpers::renderHtml($page);
		$this->layout->nest('content',$page)->with('page', $this->data)->with('menu','forgotpass');
	}

	public function postForgotpass(){
		$rules = array(
			'email'=>'required|email',
		);
		if(CNF_RECAPTCHA =='true') $rules['recaptcha_response_field'] = 'required|recaptcha';
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->passes()) {
			$cus = DB::table('customer')->where('email','=',Input::get('email'))->first();
			if(count($cus) > 0){
				if($cus->status == 0){
					return Redirect::to('quen-mat-khau.html')->with('message_forgotpass', SiteHelpers::alert('error','Tài khoản của bạn đã bị khóa !'));
				}
				$pass = SiteHelpers::randomPassword();
				DB::table('customer')->where('email','=',Input::get('email'))->update(array('password'=>md5($pass)));
				$data = array('name'=>$cus->name,'username'=>$cus->username,'pass'=>$pass); 
				Mail::send('emails.forgotpass', $data, function($message)
				{
					$message->from( CNF_EMAIL, 'Admin' );
				    $message->to(Input::get('email'), '')->subject('Thông tin đăng nhập');
				});
			}else{
				return Redirect::to('quen-mat-khau.html')->with('message_forgotpass', SiteHelpers::alert('error','Email không tồn tại !'));
			}
			return Redirect::to('')->with('message', SiteHelpers::alert('success','Vui lòng kiểm tra Email để nhận mật khẩu mới !'));
		}	
		else{
			return Redirect::to('quen-mat-khau.html')->with('message_forgotpass', SiteHelpers::alert('error','Vui lòng xác nhận các thông tin bên dưới'))->withErrors($validator)->withInput();
		}
	}

	public function categorydetail($alias = '',$id = ''){
		if($id == '')
		{
			return Redirect::to('');
		}
		$cat = Ncategories::detail($id);
		if(count($cat) == 0 || $cat->status == 0)
		{
			return Redirect::to('');
		}
		$sortget = ( Input::get('sort') != '') ? Input::get('sort') : 'ProductID-desc';
		list($sort,$order) = explode('-', $sortget);

		$sort = ($sort != "ProductID" && $sort != "CategoryID" && $sort != "ProductName" && $sort != "UnitPrice") ? "ProductID" : $sort;
		$desc = ($order != "desc" && $order != "asc") ? "desc" : $order;
		$sortget = $sort . "-" . $desc;

		$filter = " AND status = 1 AND CategoryID = $id AND lang = '$this->lang'";
		$page = (!is_null(Input::get('page')) && Input::get('page') != '') ? Input::get('page') : "1";
		$params = array(
			'page'		=> $page ,
			'limit'		=> ($this->perpage ) ,
			'sort'		=> $sort ,
			'order'		=> $order,
			'params'	=> $filter,
			//'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
		);
		$model = new Nproducts();
		$results = $model->getRows( $params );
		// Build pagination setting
		$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;	
		$pagination = Paginator::make($results['rows'], $results['total'],$params['limit']);
		$data['cat']		=$cat;
		$data['data']		= $results['rows'];
		$data['page']		= $page;
		$data['sort']		= $sortget;
		//$data['numpage']	= $params['limit'];
		$data['display']	= $this->display;
		// Build Pagination 
		$data['pagination']	= $pagination;
		// Build pager number and append current param GET
		$data['pager'] 		= $this->injectPaginate();

		$html = SiteHelpers::renderHtml('pages.template.category');
		$this->layout->nest('content',$html,$data)->with('menu','categorydetail');
	}

	public function typedetail($alias = '',$id = ''){
		if($id == '')
		{
			return Redirect::to('');
		}
		$type = DB::table('product_type')->where('type_id','=',$id)->first();
		if(count($type) == 0 || $type->status == 0)
		{
			return Redirect::to('');
		}
		$sortget = ( Input::get('sort') != '') ? Input::get('sort') : 'ProductID-desc';
		list($sort,$order) = explode('-', $sortget);

		$sort = ($sort != "ProductID" && $sort != "type_id" && $sort != "ProductName" && $sort != "UnitPrice") ? "ProductID" : $sort;
		$desc = ($order != "desc" && $order != "asc") ? "desc" : $order;
		$sortget = $sort . "-" . $desc;

		$filter = " AND status = 1 AND type_id = $id AND lang = '$this->lang'";
		$page = (!is_null(Input::get('page')) && Input::get('page') != '') ? Input::get('page') : "1";
		$params = array(
			'page'		=> $page ,
			'limit'		=> ($this->perpage ) ,
			'sort'		=> $sort ,
			'order'		=> $order,
			'params'	=> $filter,
			//'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
		);
		$model = new Nproducts();
		$results = $model->getRows( $params );
		// Build pagination setting
		$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;	
		$pagination = Paginator::make($results['rows'], $results['total'],$params['limit']);
		$data['type']		=$type;
		$data['data']		= $results['rows'];
		$data['page']		= $page;
		$data['sort']		= $sortget;
		//$data['numpage']	= $params['limit'];
		$data['display']	= $this->display;
		// Build Pagination 
		$data['pagination']	= $pagination;
		// Build pager number and append current param GET
		$data['pager'] 		= $this->injectPaginate();

		$html = SiteHelpers::renderHtml('pages.template.type');
		$this->layout->nest('content',$html,$data)->with('menu','typedetail');
	}

	public function promotiondetail($alias = '',$id = ''){
		if($id == '')
		{
			return Redirect::to('');
		}
		$promotion = DB::table('promotion')->where('id_promotion','=',$id)->first();
		if(count($promotion) == 0 || $promotion->status == 0)
		{
			return Redirect::to('');
		}
		$sortget = ( Input::get('sort') != '') ? Input::get('sort') : 'ProductID-desc';
		list($sort,$order) = explode('-', $sortget);

		$sort = ($sort != "ProductID" && $sort != "type_id" && $sort != "ProductName" && $sort != "UnitPrice") ? "ProductID" : $sort;
		$desc = ($order != "desc" && $order != "asc") ? "desc" : $order;
		$sortget = $sort . "-" . $desc;

		$filter = " AND status = 1 AND id_promotion = $id AND lang = '$this->lang'";
		$page = (!is_null(Input::get('page')) && Input::get('page') != '') ? Input::get('page') : "1";
		$params = array(
			'page'		=> $page ,
			'limit'		=> ($this->perpage ) ,
			'sort'		=> $sort ,
			'order'		=> $order,
			'params'	=> $filter,
			//'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
		);
		$model = new Nproducts();
		$results = $model->getRows( $params );
		// Build pagination setting
		$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;	
		$pagination = Paginator::make($results['rows'], $results['total'],$params['limit']);
		$data['promotion']		=$promotion;
		$data['data']		= $results['rows'];
		$data['page']		= $page;
		$data['sort']		= $sortget;
		//$data['numpage']	= $params['limit'];
		$data['display']	= $this->display;
		// Build Pagination 
		$data['pagination']	= $pagination;
		// Build pager number and append current param GET
		$data['pager'] 		= $this->injectPaginate();

		$html = SiteHelpers::renderHtml('pages.template.promotion');
		$this->layout->nest('content',$html,$data)->with('menu','promotiondetail');
	}

	public function tagdetail($alias = '',$id = ''){
		if($id == '')
		{
			return Redirect::to('');
		}
		$tag = DB::table('tags')->where('tags_id','=',$id)->first();
		if(count($tag) == 0 || $tag->status == 0)
		{
			return Redirect::to('');
		}
		$sortget = ( Input::get('sort') != '') ? Input::get('sort') : 'ProductID-desc';
		list($sort,$order) = explode('-', $sortget);

		$sort = ($sort != "ProductID" && $sort != "type_id" && $sort != "ProductName" && $sort != "UnitPrice") ? "ProductID" : $sort;
		$desc = ($order != "desc" && $order != "asc") ? "desc" : $order;
		$sortget = $sort . "-" . $desc;

		$page = (!is_null(Input::get('page')) && Input::get('page') != '') ? Input::get('page') : "1";

		$model = new Nproducts();
		$results = $model->getPaging($id,$this->lang,$this->perpage,$page);
		// Build pagination setting
		$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;	
		$pagination = Paginator::make($results['rows'], $results['total'],$this->perpage );
		$data['tag']		=$tag;
		$data['data']		= $results['rows'];
		$data['page']		= $page;
		$data['sort']		= $sortget;
		//$data['numpage']	= $params['limit'];
		$data['display']	= $this->display;
		// Build Pagination 
		$data['pagination']	= $pagination;
		// Build pager number and append current param GET
		$data['pager'] 		= $this->injectPaginate();

		$html = SiteHelpers::renderHtml('pages.template.tag');
		$this->layout->nest('content',$html,$data)->with('menu','tagdetail');
	}

	public function yeuthich(){
		if(!Session::has('customer')){
			return Redirect::to('');
		}
		$cus = Session::get('customer');
		$data = DB::table('product_customer')->where("customer_id",'=',$cus['id'])->get();
		if(count($data) <= 0){
			return Redirect::to(URL::to('thong-tin-thanh-vien.html'))->with('message', SiteHelpers::alert('warning','Không có sản phẩm yêu thích nào !'));
		}
		$sortget = ( Input::get('sort') != '') ? Input::get('sort') : 'ProductID-desc';
		list($sort,$order) = explode('-', $sortget);

		$sort = ($sort != "ProductID" && $sort != "type_id" && $sort != "ProductName" && $sort != "UnitPrice") ? "ProductID" : $sort;
		$desc = ($order != "desc" && $order != "asc") ? "desc" : $order;
		$sortget = $sort . "-" . $desc;

		$page = (!is_null(Input::get('page')) && Input::get('page') != '') ? Input::get('page') : "1";

		$model = new Nproducts();
		$results = $model->getPagingFavor($cus['id'],$this->lang,$this->perpage,$page);
		// Build pagination setting
		$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;	
		$pagination = Paginator::make($results['rows'], $results['total'],$this->perpage );
		$data['datas']		= $results['rows'];
		$data['page']		= $page;
		$data['sort']		= $sortget;
		//$data['numpage']	= $params['limit'];
		$data['display']	= $this->display;
		// Build Pagination 
		$data['pagination']	= $pagination;
		// Build pager number and append current param GET
		$data['pager'] 		= $this->injectPaginate();

		$html = SiteHelpers::renderHtml('pages.template.yeuthich');
		$this->layout->nest('content',$html,$data)->with('menu','yeuthich');
	}

	public function sexdetail($type = ''){
		if($type == '' || ($type != 'nam' && $type != 'nu'))
		{
			return Redirect::to('');
		}
		$sex = $type == 'nam' ? 1 : 0;
		$sortget = ( Input::get('sort') != '') ? Input::get('sort') : 'ProductID-desc';
		list($sort,$order) = explode('-', $sortget);

		$sort = ($sort != "ProductID" && $sort != "sex" && $sort != "ProductName" && $sort != "UnitPrice") ? "ProductID" : $sort;
		$desc = ($order != "desc" && $order != "asc") ? "desc" : $order;
		$sortget = $sort . "-" . $desc;

		$filter = " AND status = 1 AND sex = $sex AND lang = '$this->lang'";
		$page = (!is_null(Input::get('page')) && Input::get('page') != '') ? Input::get('page') : "1";
		$params = array(
			'page'		=> $page ,
			'limit'		=> ($this->perpage ) ,
			'sort'		=> $sort ,
			'order'		=> $order,
			'params'	=> $filter,
			//'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
		);
		$model = new Nproducts();
		$results = $model->getRows( $params );
		// Build pagination setting
		$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;	
		$pagination = Paginator::make($results['rows'], $results['total'],$params['limit']);
		$data['sex']		= $type == 'nam' ? 'Đồng hồ nam' : 'Đồng hồ nữ';
		$data['type']		= $type;
		$data['data']		= $results['rows'];
		$data['page']		= $page;
		$data['sort']		= $sortget;
		//$data['numpage']	= $params['limit'];
		$data['display']	= $this->display;
		// Build Pagination 
		$data['pagination']	= $pagination;
		// Build pager number and append current param GET
		$data['pager'] 		= $this->injectPaginate();

		$html = SiteHelpers::renderHtml('pages.template.sex');
		$this->layout->nest('content',$html,$data)->with('menu','sexdetail');
	}

	

	public function postFavora(){
		if(!Session::has('customer')){
			echo "100";die;
		}
		$id =(int) Input::get('id');
		if($id == ''){
			echo '101';die;
		}
		$model = new Nproducts();
		$data = $model->find($id);
		if(count($data) == 0 || $data->status == 0){
			echo '101';die;
		}
		$cus = Session::get('customer');

		$product_cus = DB::table('product_customer')->where('ProductID','=',$id)->where('customer_id','=',$cus['id'])->first();
		if(count($product_cus) == 0){
			DB::table('product_customer')->insert(array('ProductID'=>$id,'customer_id'=>$cus['id']));
		}
		echo "1";die;
	}

	public function postDelfavora(){
		if(!Session::has('customer')){
			echo "100";die;
		}
		$id =(int) Input::get('id');
		if($id == ''){
			echo '101';die;
		}
		$model = new Nproducts();
		$data = $model->find($id);
		if(count($data) == 0 || $data->status == 0){
			echo '101';die;
		}
		$cus = Session::get('customer');

		$product_cus = DB::table('product_customer')->where('ProductID','=',$id)->where('customer_id','=',$cus['id'])->delete();

		echo "1";die;
	}

	public function postDelcart(){
		$id =(int) Input::get('id');
		if($id == ''){
			echo '101';die;
		}
		$model = new Nproducts();
		$data = $model->find($id);
		if(count($data) == 0 || $data->status == 0){
			echo '101';die;
		}
		if(!Session::has('cart')){
			echo '101';die;
		}
		$cart = Session::get('cart');
		unset($cart[$id]);
		Session::put('cart',$cart);
		Session::save();
		echo "1";die;
	}

	public function postUpdatecart(){
		$id =(int) Input::get('id');
		if($id == ''){
			echo '101';die;
		}
		$model = new Nproducts();
		$data = $model->find($id);
		if(count($data) == 0 || $data->status == 0){
			echo '101';die;
		}
		if(!Session::has('cart')){
			echo '101';die;
		}
		$num = (int) Input::get('num');
		$cart = Session::get('cart');
		if($cart[$id] != ''){
			$cart[$id] = $num;
		}
		Session::put('cart',$cart);
		Session::save();
		echo "1";die;
	}

	public function postAddcart(){
		$id =(int) Input::get('id');
		$num = (int) Input::get('num') ;
		if($id == ''){
			echo '101';die;
		}
		$model = new Nproducts();
		$data = $model->find($id);
		if(count($data) == 0 || $data->status == 0){
			echo '101';die;
		}

		$this->addtocart($data,$num);
		echo "1";die;
	}

	private function addtocart($product = array(), $num = 1){
		$cart = array();
		if(Session::has('cart')){
			$cart = Session::get('cart');
		}
		if(array_key_exists($product->ProductID,$cart)){
			$cart[$product->ProductID] = $cart[$product->ProductID] + $num;
		}else{
			$cart[$product->ProductID] = $num;
		}
		Session::put('cart',$cart);
		Session::save();
		return true;
	}

	public function cart(){
		if(!Session::has('cart') || count(Session::get('cart')) == 0){
			return Redirect::to(URL::to(''))->with('message', SiteHelpers::alert('warning','Bạn vui lòng đặt mua sản phẩm !'));	
		}
		$datas = array();
		$cart = Session::get('cart');
		$mdPro = new Nproducts();
		foreach($cart as $id=>$num){
			$data = $mdPro->find($id);
			if(count($data) == 0 || $data->status == 0){
				unset($cart[$id]);
			}else{
				$data->num = $num;
				$datas[] = $data;
			}
		}
		$para['datas'] = $datas;
		Session::put('cart',$cart);
		Session::save();
		$seo['pageTitle'] = "Giỏ hàng của bạn";
		$seo['pageNote'] = CNF_APPNAME;
		$html = SiteHelpers::renderHtml('pages.template.cart');
		$this->layout->nest('content',$html,$para)->with('page', $seo)->with('menu','cart');;
	}

	public function postChangedisplay(){
		$type = Input::get('type');
		if($type != 'gird' && $type != "list"){
			die;
		}
		Session::put('display',$type);
		Session::save();die;
	}

	public function productdetail($alias = '',$id = ''){
		$mdPro = new Nproducts();
		$mdCat = new Ncategories();
		//$mdImg = new Imagesproduct();
		$product = $mdPro->find($id);
		$cat = $mdCat->find($product->CategoryID);
		if(count($product) == 0 || count($cat) == 0 || $product->status != 1 || $cat->status != 1){
			return Redirect::to(URL::to(''))->with('message', SiteHelpers::alert('warning','Sản phẩm này không tồn tại hoặc đã bị xóa !'));	
		}
		//$images = $mdImg->getImagesOfProduct($product->ProductID);
		DB::table('products')->where('ProductID','=',$id)->update(array('views' => $product->views + 1));
		$pro_same = DB::table('products')->where('ProductID','!=',$product->ProductID)->where('status','=',1)->where('lang','=',$this->lang)->where('CategoryID','=',$product->CategoryID)->limit(8)->get();

		$data['pro_same'] = $pro_same;
		$data['cat'] = $cat;
		$data['cat_link'] = $cat != NULL ? "» <a href='".URL::to('')."/danh-muc/".$cat->alias."-".$cat->CategoryID.".html'>".$cat->CategoryName."</a>" : '';
		//$data['images'] = $images;
		$data['product'] = $product;
		$seo['pageTitle'] = $product->ProductName;
		$seo['pageNote'] = $cat != NULL ? $cat->CategoryName :CNF_APPNAME;
		$html = SiteHelpers::renderHtml('pages.template.productdetail');
		$this->layout->nest('content',$html,$data)->with('page', $seo)->with('menu','productdetail');
	}

	public function  changeinfo(){
		if(!Session::has('customer')){
			return Redirect::to('dang-ky.html');
		}
		$this->data['pageTitle'] = "Thay đổi thông tin";
		$this->data['pageNote'] = CNF_APPNAME;
		$ses_cus = Session::get('customer');
		$input = DB::table('customer')->where("customer_id",'=',$ses_cus['id'])->first();
		$input->birthday = date('d-m-Y', $input->birthday);

		if(Session::has('input_rd')){
			$input = Session::get('input_rd');
		}
		$data['input'] =(array) $input;

		//$this->data['breadcrumb'] = 'inactive';
		$page = 'pages.template.changeinfo';


		$page = SiteHelpers::renderHtml($page);
		$this->layout->nest('content',$page,$data)->with('page', $this->data)->with('menu','changeinfo');
	}
	
	public function thongtinthanhvien(){
		
		if(!Session::has('customer')){
			return Redirect::to('dang-ky.html');
		}
		$this->data['pageTitle'] = "Thông tin thành viên";
		$this->data['pageNote'] = CNF_APPNAME;
		$ses_cus = Session::get('customer');
		$data['input'] = (array) DB::table('customer')->where("customer_id",'=',$ses_cus['id'])->first();
		

		/*if(Session::has('input_rd')){
			$input = Session::get('input_rd');
		}
		$data['input'] =(array) $input;*/

		//$this->data['breadcrumb'] = 'inactive';
		$page = 'pages.template.infocustomer';


		$page = SiteHelpers::renderHtml($page);
		$this->layout->nest('content',$page,$data)->with('page', $this->data)->with('menu','infocustomer');
	}

	public function cartsuccess(){
		
		if(!Session::has('vieworder')){
			return Redirect::to('');
		}
		$this->data['pageTitle'] = "Thanh toán thành công";
		$this->data['pageNote'] = CNF_APPNAME;
		$id = Session::get('vieworder');
		//Session::forget('vieworder');
		$data['input'] = (array) DB::table('orders')->where("OrderID",'=',$id)->first();

		
		$data['orderdetail'] = DB::table('orderdetails')->where("OrderID",'=',$id)->get();

		/*if(Session::has('input_rd')){
			$input = Session::get('input_rd');
		}
		$data['input'] =(array) $input;*/

		//$this->data['breadcrumb'] = 'inactive';
		$page = 'pages.template.cartsuccess';


		$page = SiteHelpers::renderHtml($page);
		$this->layout->nest('content',$page,$data)->with('page', $this->data)->with('menu','infocustomer');
	}

	public function postConfirm(){
		
		if(!Session::has('cart') || count(Session::get('cart')) == 0){
			return Redirect::to('')->with('message', SiteHelpers::alert('warning','Bạn không truy cập vào địa chỉ này được!'));
		}
		if(!Session::has('cartinfo') || count(Session::get('cartinfo')) == 0){
			return Redirect::to('')->with('message', SiteHelpers::alert('warning','Bạn không truy cập vào địa chỉ này được!'));
		}
		$data = array();
			$data['customer_id'] = 0;
			$cart_info = Session::get('cartinfo');
			if(Session::has('customer')){
				$cus = Session::get('customer');
				$data['customer_id'] = $cus['id'];
			}
			$data['OrderDate'] = time();
			$data['name'] = $cart_info['name'];
			$data['email'] = $cart_info['email'];
			$data['phone'] = $cart_info['phone'];
			$data['address'] = $cart_info['address'];
			$data['content'] = '';
			$data['provinceid'] = $cart_info['provinceid'];
			$data['districtid'] = $cart_info['districtid'];
			$data['wardid'] = $cart_info['wardid'];
			$mdOrd = new Order();
			$id = $mdOrd->insertRow($data,'');

			$mdOrdDetail = new Orderdetail();
			$mdPro = new Nproducts();
			$cart = Session::get('cart');
			$cart_detail = array();
			$total = 0;
			foreach($cart as $id_pro=>$num){
				$product = $mdPro->find($id_pro);
				list($price,$price_html) = SiteHelpers::getPrice($product);
				$cart_detail['OrderID'] = $id;
				$cart_detail['ProductID'] = $id_pro;
				$cart_detail['Quantity'] = $num;
				$cart_detail['UnitPrice'] = $price;
				$id_ord_detail = $mdOrdDetail->insertRow($cart_detail,'');
				$total += $price*$num;
			}
			$ordername = SiteHelpers::getOrdName($id);
			$mdOrd->insertRow(array('OrderName'=>$ordername,"total"=>$total),$id);
			Session::put('vieworder',$id);
			Session::save();
			Session::forget('cart');
			Session::forget('cartinfo');
			return Redirect::to('thanh-toan-thanh-cong.html')->with('message', SiteHelpers::alert('success','Đơn hàng của bạn đã hoàn thành ! Chúng tôi sẽ liên hệ bạn trong thời gian sớm nhất'));
	}

	public function postXacnhan(){
		
		if(!Session::has('cart') || count(Session::get('cart')) == 0){
			return Redirect::to('')->with('message', SiteHelpers::alert('warning','Bạn không truy cập vào địa chỉ này được!'));
		}
		if(!Session::has('cartinfo') || count(Session::get('cartinfo')) == 0){
			return Redirect::to('')->with('message', SiteHelpers::alert('warning','Bạn không truy cập vào địa chỉ này được!'));
		}
		$this->data['pageTitle'] = "Xác nhận";
		$this->data['pageNote'] = CNF_APPNAME;
		$page = 'pages.template.xacnhan';
		$data['info'] = Session::get('cartinfo');


		$page = SiteHelpers::renderHtml($page);
		$this->layout->nest('content',$page,$data)->with('page', $this->data)->with('menu','xacnhan');
	}

	public function thanhtoan(){
		
		if(!Session::has('cart') || count(Session::get('cart')) == 0){
			return Redirect::to('')->with('message', SiteHelpers::alert('warning','Bạn không truy cập vào địa chỉ này được!'));
		}
		if(!Session::has('cartinfo') || count(Session::get('cartinfo')) == 0){
			return Redirect::to('')->with('message', SiteHelpers::alert('warning','Bạn không truy cập vào địa chỉ này được!'));
		}
		$this->data['pageTitle'] = "Thanh toán";
		$this->data['pageNote'] = CNF_APPNAME;
		$page = 'pages.template.thanhtoan';
		$data = array();

		$page = SiteHelpers::renderHtml($page);
		$this->layout->nest('content',$page,$data)->with('page', $this->data)->with('menu','thanhtoan');
	}

	public function vanchuyen(){
		
		if(!Session::has('cart') || count(Session::get('cart')) == 0){
			return Redirect::to('')->with('message', SiteHelpers::alert('warning','Bạn không truy cập vào địa chỉ này được!'));
		}
		$this->data['pageTitle'] = "Vận chuyển";
		$this->data['pageNote'] = CNF_APPNAME;
		$page = 'pages.template.vanchuyen';
		$input = array(
				"name"=>'',
				"phone"=>'',
				"email"=>'',
				"address"=>'',
				"provinceid"=>'79',
				"districtid"=>'',
				"wardid"=>''
			);
		if(Session::has('customer') && count(Session::get('customer')) > 0){
			$mdCus = new Customer();
			$cus = Session::get('customer');
			$data_cus = $mdCus->find($cus['id']);
			$input = array(
				"name"=>$data_cus->name,
				"phone"=>$data_cus->phone,
				"email"=>$data_cus->email,
				"address"=>$data_cus->address,
				"provinceid"=>$data_cus->provinceid,
				"districtid"=>$data_cus->districtid,
				"wardid"=>$data_cus->wardid
			);
		}
		if(Session::has('input_rd')){
			$input = Session::get('input_rd');
		}
		$data['input'] = $input;

		$page = SiteHelpers::renderHtml($page);
		$this->layout->nest('content',$page,$data)->with('page', $this->data)->with('menu','vanchuyen');
	}

	public function  postThanhtoan()
	{
		if(!Session::has('cart') || count(Session::get('cart')) == 0){
			return Redirect::to('')->with('message', SiteHelpers::alert('warning','Bạn không truy cập vào địa chỉ này được!'));
		}
		$this->beforeFilter('csrf', array('on'=>'post'));
		$rules = $rules=array(
			"name" => "required|between:5,50",
			"phone" => "required|Numeric",
			"email" => "required|email",
			"address" => "required",
			"provinceid" => "required|Numeric",
			"districtid" => "required|Numeric",
			"wardid" => "required|Numeric",
		);
		if(CNF_RECAPTCHA =='true') $rules['recaptcha_response_field'] = 'required|recaptcha';
		$validator = Validator::make(Input::all(), $rules);	
		if ($validator->passes()) 
		{
			
			$cart_info = array();
			$cart_info['name'] = Input::get('name');
			$cart_info['email'] = Input::get('email');
			$cart_info['phone'] = Input::get('phone');
			$cart_info['address'] = Input::get('address');
			$cart_info['provinceid'] = Input::get('provinceid');
			$cart_info['districtid'] = Input::get('districtid');
			$cart_info['wardid'] = Input::get('wardid');
			Session::put('cartinfo',$cart_info);
			Session::save();
			return Redirect::to('thanh-toan.html');	
				
		} else {
			return Redirect::to(URL::to('')."/van-chuyen-hang.html")->with('message_vanvhuyen', SiteHelpers::alert('error','Vui lòng khắc phục các lỗi bên dưới'))->with('input_rd',Input::all())
			->withErrors($validator)->withInput();
		}		
	}

	public function postCheckoutexpress(){
		
		if(!Session::has('cart') || count(Session::get('cart')) == 0){
			return Redirect::to('gio-hang-cua-toi.html')->with('message', SiteHelpers::alert('warning','Bạn không truy cập vào địa chỉ này được!'));
		}
		$rules = $rules=array(
			"name" => "required|between:5,50",
			"phone" => "required|Numeric",
			"email" => "required|email",
			"address" => "required",
			"provinceid" => "required|Numeric",
			"districtid" => "required|Numeric",
			"wardid" => "required|Numeric",
		);
		if(CNF_RECAPTCHA =='true') $rules['recaptcha_response_field'] = 'required|recaptcha';
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->passes()) {
			$data = array();
			$data['customer_id'] = 0;
			if(Session::has('customer')){
				$cus = Session::get('customer');
				$data['customer_id'] = $cus['id'];
			}
			$data['OrderDate'] = time();
			$data['name'] = Input::get('name');
			$data['email'] = Input::get('email');
			$data['phone'] = Input::get('phone');
			$data['address'] = Input::get('address');
			$data['content'] = Input::get('comment');
			$data['provinceid'] = Input::get('provinceid');
			$data['districtid'] = Input::get('districtid');
			$data['wardid'] = Input::get('wardid');
			$mdOrd = new Order();
			$id = $mdOrd->insertRow($data,'');

			$mdOrdDetail = new Orderdetail();
			$mdPro = new Nproducts();
			$cart = Session::get('cart');
			$cart_detail = array();
			$total = 0;
			foreach($cart as $id_pro=>$num){
				$product = $mdPro->find($id_pro);
				list($price,$price_html) = SiteHelpers::getPrice($product);
				$cart_detail['OrderID'] = $id;
				$cart_detail['ProductID'] = $id_pro;
				$cart_detail['Quantity'] = $num;
				$cart_detail['UnitPrice'] = $price;
				$id_ord_detail = $mdOrdDetail->insertRow($cart_detail,'');
				$total += $price*$num;
			}
			$ordername = SiteHelpers::getOrdName($id);
			$mdOrd->insertRow(array('OrderName'=>$ordername,"total"=>$total),$id);
			Session::put('vieworder',$id);
			Session::save();
			Session::forget('cart');
			return Redirect::to('thanh-toan-thanh-cong.html')->with('message', SiteHelpers::alert('success','Đơn hàng của bạn đã hoàn thành ! Chúng tôi sẽ liên hệ bạn trong thời gian sớm nhất'));
		}	
		else{
			//print_r($validator);die;
			return Redirect::to('gio-hang-cua-toi.html')->with('message_forgotpass', SiteHelpers::alert('error','Mã bảo mật không đúng !'));
		}
	}
	
	public function tindadang(){
		
		if(!Session::has('customer')){
			return Redirect::to('dang-ky.html');
		}
		$sort = 'post_id';
		$order = 'desc';
		$ses_cus = Session::get('customer');
		$id = $ses_cus['id'];
		$filter = " AND status = 1 AND active = 1 AND customer_id = $id ";

		$page = (!is_null(Input::get('page')) && Input::get('page') != '') ? Input::get('page') : "1";
		$params = array(
			'page'		=> $page ,
			'limit'		=> ( $this->perpage ) ,
			'sort'		=> $sort ,
			'order'		=> $order,
			'params'	=> $filter,
			//'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
		);
		$model = new Post();
		$results = $model->getRows( $params );
		// Build pagination setting
		$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;	
		$pagination = Paginator::make($results['rows'], $results['total'],$params['limit']);
		//$data['order'] 		= $data_order;
		//$data['province']	= $data_province;
		$data['data']		= $results['rows'];
		$data['page']		= $page;
		$data['numpage']	= $params['limit'];
		// Build Pagination 
		$data['pagination']	= $pagination;
		// Build pager number and append current param GET
		$data['pager'] 		= $this->injectPaginate();


		$this->data['pageTitle'] = "Danh sách tin ";
		$this->data['pageNote'] = CNF_APPNAME;
		$page = 'pages.template.tindadang';
		$page = SiteHelpers::renderHtml($page);
		$this->layout->nest('content',$page,$data)->with('page', $this->data)->with('menu','tindadang');
	}

	public function postChangeinfo(){
		if(!Session::has('customer')){
			return Redirect::to('dang-ky.html');
		}
		$rules = $rules=array(
			"name" => "required|between:5,50",
			"phone" => "required|Numeric",
			"sex" => "required|Numeric|in:0,1,2",
			"birthday" => "required|date_format:d-m-Y",
			"provinceid" => "required|Numeric",
			"districtid" => "required|Numeric",
			"wardid" => "required|Numeric",
		);
		if(CNF_RECAPTCHA =='true') $rules['recaptcha_response_field'] = 'required|recaptcha';
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->passes()) {
			$data['name'] = Input::get('name');
			$data['phone'] = Input::get('phone');
			$data['sex'] = Input::get('sex');
			$data['birthday'] = Input::get('birthday');
			$data['address'] = Input::get('address');
			$data['provinceid'] = Input::get('provinceid');
			$data['districtid'] = Input::get('districtid');
			$data['wardid'] = Input::get('wardid');
			/*if(!is_null(Input::file('file')))
			{
				$file = Input::file('file');
				$destinationPath = './uploads/customer/';
				$filename = $file->getClientOriginalName();
				$extension = $file->getClientOriginalExtension(); //if you need extension of the file
				$newfilename = time().'.'.$extension;
				$uploadSuccess = Input::file('file')->move($destinationPath, $newfilename);
				if( $uploadSuccess ) {
				    $data['image'] = $newfilename;
				    $orgFile = $destinationPath.'/'.$newfilename;
				    $thumbFile = $destinationPath.'/thumb/'.$newfilename;
				    SiteHelpers::resizewidth("193",$orgFile,$thumbFile);
				    $ses_cus = Session::get('customer');
				    if($ses_cus['image'] != ''){
				    	@unlink(ROOT .'/uploads/customer/'.$ses_cus['image']);
				    	@unlink(ROOT .'/uploads/customer/thumb/'.$ses_cus['image']);
				    }
				}
			}*/
			DB::table('customer')->where('email','=',Input::get('email'))->where('username','=',Input::get('username'))->update($data);
			return Redirect::to('thong-tin-thanh-vien.html')->with('message', SiteHelpers::alert('success','Thay đổi thông tin thành công !'));
		}else{
			return Redirect::to('thay-doi-thong-tin-thanh-vien.html')->with('message_changeinfo', SiteHelpers::alert('error','Vui lòng xác nhận các thông tin bên dưới'))->withErrors($validator)->withInput();
		}
	}

	public function changepass(){
		if(!Session::has('customer')){
			return Redirect::to('dang-ky.html');
		}
		$this->data['pageTitle'] = "Thay đổi mật khẩu";
		$this->data['pageNote'] = CNF_APPNAME;
		$page = 'pages.template.changepass';


		$page = SiteHelpers::renderHtml($page);
		$this->layout->nest('content',$page)->with('page', $this->data)->with('menu','changepass');
	}

	public function postChangepass(){
		if(!Session::has('customer')){
			return Redirect::to('dang-ky.html');
		}
		$rules = $rules=array(
			"password" => "required|between:5,20",
			"newpassword" => "required|alpha_num|between:5,20",
			"confirmpassword" => "required|same:newpassword",
		);
		if(CNF_RECAPTCHA =='true') $rules['recaptcha_response_field'] = 'required|recaptcha';
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->passes()) {
			$ses_cus = Session::get('customer');
			$cus = DB::table('customer')->where('customer_id','=',$ses_cus['id'])->first();
			if(md5(Input::get('password')) != $cus->password){
				return Redirect::to('doi-mat-khau.html')->with('message_changepass', SiteHelpers::alert('error','Mật khẩu cũ không chính xác !'));
			}
			$pass = md5(Input::get('newpassword'));
			DB::table('customer')->where('customer_id','=',$ses_cus['id'])->update(array('password'=>$pass));
			return Redirect::to('thong-tin-thanh-vien.html')->with('message', SiteHelpers::alert('success','Thay đổi mật khẩu thành công !'));
		}else{
			return Redirect::to('doi-mat-khau.html')->with('message_changepass', SiteHelpers::alert('error','Vui lòng xác nhận các thông tin bên dưới'))->withErrors($validator)->withInput();
		}
		/*$rules = $rules=array(
			"type_customer" => "required|Numeric",
			"subject" => "required",
			"subject" => "required|alpha_num|between:5,15",
			"name" => "required|between:5,15",
			"phone" => "required|Numeric",
			"address" => "required",
			"provinceid" => "required",
			"districtid" => "required",
			"wardid" => "required",
		);
		if(CNF_RECAPTCHA =='true') $rules['recaptcha_response_field'] = 'required|recaptcha';
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->passes()) {

		}else{

		}*/

	}

	public function getLogout(){
		Session::forget('customer');
		return Redirect::to('');
	}

	public function dangtin(){
		if(!Session::has('customer')){
			return Redirect::to('home/dangnhap');
		}
		$this->data['pageTitle'] = "Đăng tin";
		$this->data['pageNote'] = CNF_APPNAME;
		$page = 'pages.template.dangtin';
		$ses_cus = Session::get('customer');
		$cus = DB::table('customer')->where("customer_id","=",$ses_cus['id'])->first();
		$input = array(
				'post_typecustomer'	=>'',
				'post_subject'	=>'',
				'post_provincefrom'	=>'79',
				'post_districtfrom'	=>'',
				'post_addressfrom'	=>'',
				'post_provinceto'	=>'79',
				'post_districtto'	=>'',
				'post_addressto'	=>'',
				'post_datestar'	=>'',
				'post_price'	=>'0',
				'post_typecar'	=>'',
				'post_note'	=>'',
				'name'	=>$cus->name,
				'phone'	=>$cus->phone,
				'address'	=>$cus->address." ".SiteHelpers::getNameaddress($cus->provinceid,'province','provinceid')." ".SiteHelpers::getNameaddress($cus->districtid,'district','districtid')." ".SiteHelpers::getNameaddress($cus->wardid,'ward','wardid'),
			);
		if(Session::has('input_rd')){
			$input = Session::get('input_rd');
		}
		$data['input'] = $input;

		$page = SiteHelpers::renderHtml($page);
		$this->layout->nest('content',$page,$data)->with('page', $this->data)->with('menu','dangtin');
	}

	public function postDangtin(){
		if(!Session::has('customer')){
			return Redirect::to('home/dangnhap');
		}
		
		$rules = array(
				'post_typecustomer'		=>'required|Numeric',
				'post_subject'			=>'required',
				'post_provincefrom'		=>'required|Numeric',
				'post_districtfrom'		=>'required|Numeric',
				//'post_addressfrom'		=>'required',
				'post_provinceto'		=>'required|Numeric',
				'post_districtto'		=>'required|Numeric',
				//'post_addressto'		=>'required',
				'post_datestar'			=>'required',
				'post_price'			=>'required|Numeric',
				//'post_typecar'			=>'required',
				'post_note'				=>'required',
				'name'					=>'required',
				'phone'					=>'required',
				'address'				=>'required',
				"post_file1" => "mimes:doc,docx|max:10000",
				"post_file2" => "mimes:doc,docx|max:10000",
		);
		if(CNF_RECAPTCHA =='true') $rules['recaptcha_response_field'] = 'required|recaptcha';
		$validator = Validator::make(Input::all(), $rules);	
		if ($validator->passes()) 
		{
			$ses_cus = Session::get('customer');
			$customer = DB::table('customer')->where('customer_id','=',$ses_cus['id'])->first();
			$data = $this->getDataPost('post');
			if(CNF_FREE == 1){
				if($customer->money < CNF_PRICEPOST){
					return Redirect::to('contact-us.html')->with('message_contact', SiteHelpers::alert('warning','Tài khoản quý khách không đủ để đăng tin ! Vui lòng liên hệ Admin để nạp tài khoản !'));
				}
				$update_cus['money'] = $customer->money - CNF_PRICEPOST;
				DB::table('customer')->where('customer_id','=',$ses_cus['id'])->update($update_cus);
			}
			$data['created'] = time();
			$data['post_datestar'] = strtotime($data['post_datestar']);
			$data['post_slug'] = SiteHelpers::seoUrl(trim($data['post_subject']));
			$data['customer_id'] = $ses_cus['id'];
			unset($data['lang']);
			if(!is_null(Input::file('post_file1')))
			{
				$file = Input::file('post_file1');
				$destinationPath = './uploads/files/';
				$filename = $file->getClientOriginalName();
				$extension = $file->getClientOriginalExtension(); //if you need extension of the file
				$newfilename = time().'.'.$extension;
				$uploadSuccess = Input::file('post_file1')->move($destinationPath, $newfilename);
				$data['post_file1'] = $newfilename;
			}
			if(!is_null(Input::file('post_file2')))
			{
				$file = Input::file('post_file2');
				$destinationPath = './uploads/files/';
				$filename = $file->getClientOriginalName();
				$extension = $file->getClientOriginalExtension(); //if you need extension of the file
				$newfilename = time().'.'.$extension;
				$uploadSuccess = Input::file('post_file2')->move($destinationPath, $newfilename);
				$data['post_file2'] = $newfilename;
			}
			$mdPost = new Post();
			$ID = $mdPost->insertRow($data , '');
			return Redirect::to('thong-bao.html')->with('message', SiteHelpers::alert('success','Thao tác thành công ! Bài đăng của bạn đang chờ duyệt !'));
		}else{
			$input_rd = Input::all();
			unset($input_rd['post_file1']);
			unset($input_rd['post_file2']);
			return Redirect::to('dang-tin.html')->with('message_dangtin', SiteHelpers::alert('error','Vui lòng xác nhận các thông tin bên dưới'))->with('input',$input_rd)->withErrors($validator)->withInput();
		}

	}

	public function thongbao(){
		if(!Session::has('message')){
			return Redirect::to('');
		}
		$this->data['pageTitle'] = "Thông báo";
		$this->data['pageNote'] = CNF_APPNAME;
		$page = 'pages.template.thongbao';
		$page = SiteHelpers::renderHtml($page);
		$this->layout->nest('content',$page)->with('page', $this->data)->with('menu','thongbao');
	}

	public function tinmoi (){
		$sort = 'post_id';
		$order = 'desc';
		$filter = " AND status = 1 AND active = 1 ";
		$province_from = (Input::get('province_from') != '') ? Input::get('province_from') : '';
		$district_from = ( Input::get('district_from') != '') ? Input::get('district_from') : '';
		$province_to = ( Input::get('province_to') != '') ? Input::get('province_to') : '';
		$district_to = ( Input::get('district_to') != '') ? Input::get('district_to') : '';
		$datestar = ( Input::get('datestar') != '') ? strtotime(Input::get('datestar')) : '';

		$filter .= ( Input::get('province_from') != '') ? " AND post_provincefrom = ".Input::get('province_from') : '';
		$filter .= ( Input::get('district_from') != '') ? " AND post_districtfrom = ".Input::get('district_from') : '';
		$filter .= ( Input::get('province_to') != '') ? " AND post_provinceto = ".Input::get('province_to') : '';
		$filter .= ( Input::get('district_to') != '') ? " AND post_districtto = ".Input::get('district_to') : '';
		$filter .= ( Input::get('datestar') != '') ? " AND post_datestar >= ".strtotime(Input::get('datestar')) : '';

		$data_order = array(
						'province_from' => $province_from,
						'district_from' => $district_from,
						'province_to' => $province_to,
						'district_to' => $district_to,
						'datestar' => $datestar,
					);

		$page = (!is_null(Input::get('page')) && Input::get('page') != '') ? Input::get('page') : "1";
		$params = array(
			'page'		=> $page ,
			'limit'		=> ( $this->perpage ) ,
			'sort'		=> $sort ,
			'order'		=> $order,
			'params'	=> $filter,
			//'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
		);
		$model = new Post();
		$results = $model->getRows( $params );
		// Build pagination setting
		$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;	
		$pagination = Paginator::make($results['rows'], $results['total'],$params['limit']);
		$data['order'] 		= $data_order;
		$data['data']		= $results['rows'];
		$data['page']		= $page;
		$data['numpage']	= $params['limit'];
		// Build Pagination 
		$data['pagination']	= $pagination;
		// Build pager number and append current param GET
		$data['pager'] 		= $this->injectPaginate();


		$this->data['pageTitle'] = "Tin mới đăng";
		$this->data['pageNote'] = CNF_APPNAME;
		$page = 'pages.template.tinmoi';
		$page = SiteHelpers::renderHtml($page);
		$this->layout->nest('content',$page,$data)->with('page', $this->data)->with('menu','tinmoi');
	}

	public function hanhkhach (){
		$sort = 'post_id';
		$order = 'desc';
		$filter = " AND status = 1 AND active = 1 AND post_typecustomer = 1";
		$province_from = (Input::get('province_from') != '') ? Input::get('province_from') : '';
		$district_from = ( Input::get('district_from') != '') ? Input::get('district_from') : '';
		$province_to = ( Input::get('province_to') != '') ? Input::get('province_to') : '';
		$district_to = ( Input::get('district_to') != '') ? Input::get('district_to') : '';
		$datestar = ( Input::get('datestar') != '') ? strtotime(Input::get('datestar')) : '';

		$filter .= ( Input::get('province_from') != '') ? " AND post_provincefrom = ".Input::get('province_from') : '';
		$filter .= ( Input::get('district_from') != '') ? " AND post_districtfrom = ".Input::get('district_from') : '';
		$filter .= ( Input::get('province_to') != '') ? " AND post_provinceto = ".Input::get('province_to') : '';
		$filter .= ( Input::get('district_to') != '') ? " AND post_districtto = ".Input::get('district_to') : '';
		$filter .= ( Input::get('datestar') != '') ? " AND post_datestar >= ".strtotime(Input::get('datestar')) : '';

		$data_order = array(
						'province_from' => $province_from,
						'district_from' => $district_from,
						'province_to' => $province_to,
						'district_to' => $district_to,
						'datestar' => $datestar,
					);

		$page = (!is_null(Input::get('page')) && Input::get('page') != '') ? Input::get('page') : "1";
		$params = array(
			'page'		=> $page ,
			'limit'		=> ( $this->perpage ) ,
			'sort'		=> $sort ,
			'order'		=> $order,
			'params'	=> $filter,
			//'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
		);
		$model = new Post();
		$results = $model->getRows( $params );
		// Build pagination setting
		$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;	
		$pagination = Paginator::make($results['rows'], $results['total'],$params['limit']);
		$data['order'] 		= $data_order;
		$data['data']		= $results['rows'];
		$data['page']		= $page;
		$data['numpage']	= $params['limit'];
		// Build Pagination 
		$data['pagination']	= $pagination;
		// Build pager number and append current param GET
		$data['pager'] 		= $this->injectPaginate();


		$this->data['pageTitle'] = "Hành khách";
		$this->data['pageNote'] = CNF_APPNAME;
		$page = 'pages.template.hanhkhach';
		$page = SiteHelpers::renderHtml($page);
		$this->layout->nest('content',$page,$data)->with('page', $this->data)->with('menu','hanhkhach');
	}

	public function taixe (){
		$sort = 'post_id';
		$order = 'desc';
		$filter = " AND status = 1 AND active = 1 AND post_typecustomer = 0";
		$province_from = (Input::get('province_from') != '') ? Input::get('province_from') : '';
		$district_from = ( Input::get('district_from') != '') ? Input::get('district_from') : '';
		$province_to = ( Input::get('province_to') != '') ? Input::get('province_to') : '';
		$district_to = ( Input::get('district_to') != '') ? Input::get('district_to') : '';
		$datestar = ( Input::get('datestar') != '') ? strtotime(Input::get('datestar')) : '';

		$filter .= ( Input::get('province_from') != '') ? " AND post_provincefrom = ".Input::get('province_from') : '';
		$filter .= ( Input::get('district_from') != '') ? " AND post_districtfrom = ".Input::get('district_from') : '';
		$filter .= ( Input::get('province_to') != '') ? " AND post_provinceto = ".Input::get('province_to') : '';
		$filter .= ( Input::get('district_to') != '') ? " AND post_districtto = ".Input::get('district_to') : '';
		$filter .= ( Input::get('datestar') != '') ? " AND post_datestar >= ".strtotime(Input::get('datestar')) : '';

		$data_order = array(
						'province_from' => $province_from,
						'district_from' => $district_from,
						'province_to' => $province_to,
						'district_to' => $district_to,
						'datestar' => $datestar,
					);

		$page = (!is_null(Input::get('page')) && Input::get('page') != '') ? Input::get('page') : "1";
		$params = array(
			'page'		=> $page ,
			'limit'		=> ( $this->perpage ) ,
			'sort'		=> $sort ,
			'order'		=> $order,
			'params'	=> $filter,
			//'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
		);
		$model = new Post();
		$results = $model->getRows( $params );
		// Build pagination setting
		$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;	
		$pagination = Paginator::make($results['rows'], $results['total'],$params['limit']);
		$data['order'] 		= $data_order;
		$data['data']		= $results['rows'];
		$data['page']		= $page;
		$data['numpage']	= $params['limit'];
		// Build Pagination 
		$data['pagination']	= $pagination;
		// Build pager number and append current param GET
		$data['pager'] 		= $this->injectPaginate();


		$this->data['pageTitle'] = "Danh sách tài xế";
		$this->data['pageNote'] = CNF_APPNAME;
		$page = 'pages.template.taixe';
		$page = SiteHelpers::renderHtml($page);
		$this->layout->nest('content',$page,$data)->with('page', $this->data)->with('menu','taixe');
	}

	public function tinhthanh (){
		if(Input::get('province') == ''){
			return Redirect::to('');
		}
		$sort = 'post_id';
		$order = 'desc';
		$province = Input::get('province');
		$data_province = DB::table('province')->where('provinceid','=',$province)->first();
		$filter = " AND status = 1 AND active = 1 AND (post_provincefrom = $province OR post_provinceto = $province) ";
		$data_order = array(
						'province' => $province,
					);

		$page = (!is_null(Input::get('page')) && Input::get('page') != '') ? Input::get('page') : "1";
		$params = array(
			'page'		=> $page ,
			'limit'		=> ( $this->perpage ) ,
			'sort'		=> $sort ,
			'order'		=> $order,
			'params'	=> $filter,
			//'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
		);
		$model = new Post();
		$results = $model->getRows( $params );
		// Build pagination setting
		$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;	
		$pagination = Paginator::make($results['rows'], $results['total'],$params['limit']);
		$data['order'] 		= $data_order;
		$data['province']	= $data_province;
		$data['data']		= $results['rows'];
		$data['page']		= $page;
		$data['numpage']	= $params['limit'];
		// Build Pagination 
		$data['pagination']	= $pagination;
		// Build pager number and append current param GET
		$data['pager'] 		= $this->injectPaginate();


		$this->data['pageTitle'] = "Danh sách tin ".$data_province->name;
		$this->data['pageNote'] = CNF_APPNAME;
		$page = 'pages.template.tinhthanh';
		$page = SiteHelpers::renderHtml($page);
		$this->layout->nest('content',$page,$data)->with('page', $this->data)->with('menu','tinhthanh');
	}

	public function detailpost($alias = '', $id = ''){
		$post = DB::table('post')->where('post_id','=',$id)->first();
		$data['customer'] = DB::table('customer')->where('customer_id','=',$post->customer_id)->first();
		$data['post'] = $post;
		$this->data['pageTitle'] = $post->post_subject;
		$this->data['pageNote'] = CNF_APPNAME;
		$page = 'pages.template.detailpost';
		$page = SiteHelpers::renderHtml($page);
		$this->layout->nest('content',$page,$data)->with('page', $this->data)->with('menu','detailpost');
	}

	public function getViewfile($file = ''){
		$url = URL::to('').'/uploads/files/'.$file;
		header('Content-Description: Thông tin bài đăng');
	    //header('Content-Type: application/octet-stream');
	    //header('Content-Disposition: attachment; filename='.basename($file));
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	   // header('Content-Length: ' . filesize($url));
	    //readfile($url);
		header('Location: ' . $url);
		die;
	}

	/*public function cart()
	{
		$cart = Session::get('addcart');
		if(count($cart) <= 0){
			return Redirect::to('')->with('message', SiteHelpers::alert('success','Bạn vui lòng chọn mua sản phẩm'));	
		}
		$datacart = array();
		$mdPro = new Nproducts();
		$mdCat = new Ncategories();
		//$total = 0;
		$total_real = 0;
		foreach ($cart as $key => $value) {
			$data = $mdPro->find($key);
			$category = $mdCat->find($data->CategoryID);
			$price_convert = SiteHelpers::getPricePromotion($data);

			$price_item = $price_convert * $value;
			//$total += $data->UnitPrice * $value ;
			$total_real += $price_item ;
			$datacart[$key]['image'] = $data->image == '' ? URL::to('').'/sximo/images/no_pic.png' : URL::to('').'/uploads/products/thumb/'.$data->image;
			$datacart[$key]['ProductName'] = $data->ProductName;
			$datacart[$key]['categoryname'] = $category->CategoryName != "" ?  $category->CategoryName : 'Unknow';
			$datacart[$key]['sl'] = $value;
			$datacart[$key]['price'] = number_format($price_convert,0,',','.') . 'VNĐ';
			$datacart[$key]['price_total'] = number_format($price_item,0,',','.') . 'VNĐ';
			$datacart[$key]['price_promition'] = $data->id_promotion != 0 ? '<br/><span style="color: #f00;font-weight: normal;text-decoration: line-through;">'.number_format($data->UnitPrice,0,',','.') . 'VNĐ</span><br/>' : '';
			$datacart[$key]['link'] = URL::to('')."/detail/".$data->slug . "-" . $data->ProductID . ".html";
		}
		$datas['cart'] = $datacart;
		//$datas['total'] = $total;
		$datas['total_real'] = number_format($total_real,0,',','.') . 'VNĐ';
		$datas['total'] = $total_real;
		//print_r($data);die;

		$seo['pageTitle'] = 'Cart';
		$seo['pageNote'] = 'Welcome To Our Site';
		$html = SiteHelpers::renderHtml('pages.template.cart');
		$this->layout->nest('content',$html,$datas)->with('page', $seo);
	}

	public function postOrder(){
		$cart = Session::get('addcart');
		if(count($cart) <= 0){
			return Redirect::to('')->with('message', SiteHelpers::alert('warning','Bạn vui lòng chọn mua sản phẩm'));	
		}
		$rules = array(
			'recaptcha_response_field'=>'required|recaptcha',
			);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->passes()) {
			$data = $this->getDataPost('orders');
			$data['total'] = SiteHelpers::getTotalcart();
			unset($data['lang']);
			$data['OrderDate'] = date('Y-m-d H:i:s', time());
			$mdOrderDetail = new Orderdetail();
			$mdOrder = new Order();
			$mdPro = new Nproducts();
			$ID = $mdOrder->insertRow($data,'');
			if($ID){
				foreach($cart as $key=>$val){
					$product = $mdPro->find($key);
					$price = SiteHelpers::getPricePromotion($product);
					$data_cart['UnitPrice'] = $price;
					$data_cart['OrderID'] = $ID;
					$data_cart['ProductID'] = $key;
					$data_cart['Quantity'] = $val;
					$mdOrderDetail->insertRow($data_cart,'');
				}

				Session::put('addcart',array());
				Session::save();
			}
			return Redirect::to('')->with('message', SiteHelpers::alert('success','Đặt hàng thành công'));
		}
		else{
			return Redirect::to('checkout.html')->with('message_checkout', SiteHelpers::alert('warning','Sai mã bảo mật'))->with('input_rd',Input::all());
		}
	}*/

	public function getSearch(){
		if(Input::get('key') == ''){
			return Redirect::to('');
		}
		$this->data['brc'] = '<li><a href="'.URL::to("").'">'.Lang::get('layout.home').'</a></li><li class="active">'.Lang::get('layout.search').'</li>';
		$s = Input::get('key');
		$sortget = ( Input::get('sort') != '') ? Input::get('sort') : 'ProductID-desc';
		list($sort,$order) = explode('-', $sortget);
		$sort = ($sort != "ProductID" && $sort != "type_id" && $sort != "ProductName" && $sort != "UnitPrice") ? "ProductID" : $sort;
		$desc = ($order != "desc" && $order != "asc") ? "desc" : $order;
		$sortget = $sort . "-" . $desc;
		$filter = " AND status = 1 AND (ProductName LIKE '%".$s."%' OR Slug LIKE '%".$s."%' OR Content LIKE '%".$s."%' OR description LIKE '%".$s."%') AND lang = '$this->lang'";
		$page = (!is_null(Input::get('page') && Input::get('page') != '')) ? Input::get('page') : 1;
		$params = array(
			'page'		=> $page ,
			'limit'		=> (!is_null(Input::get('numpage')) ? filter_var(Input::get('numpage'),FILTER_VALIDATE_INT) : $this->perpage ) ,
			'sort'		=> $sort ,
			'order'		=> $order,
			'params'	=> $filter,
			//'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
		);
		$model = new Nproducts();
		$results = $model->getRows( $params );
		// Build pagination setting
		$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;	
		$pagination = Paginator::make($results['rows'], $results['total'],$params['limit']);
		$data['search']		=$s;
		$data['data']		= $results['rows'];
		$data['page']		= $page;
		$data['sort']		= $sortget;
		$data['display']	= $this->display;
		$data['numpage']	= $params['limit'];
		// Build Pagination 
		$data['pagination']	= $pagination;
		// Build pager number and append current param GET
		$data['pager'] 		= $this->injectPaginate();


		$this->data['pageTitle'] = 'Kết qua tìm kiếm từ khóa'.'"'.$s.'"';
		$this->data['pageNote'] = CNF_APPNAME;

		//$this->data['breadcrumb'] = 'inactive';
		$page = 'pages.template.search';


		$page = SiteHelpers::renderHtml($page);
		$this->layout->nest('content',$page,$data)->with('page', $this->data)->with('menu','search');
	}

	/*public function checkout()
	{
		$cart = Session::get('addcart');
		if(count($cart) <= 0){
			return Redirect::to('')->with('message', SiteHelpers::alert('success','Bạn không có sản phẩm nào trong giỏ hàng !'));	
		}
		$input = array(
				'name'	=>'',
				'sex'	=>'1',
				'phone'	=>'',
				'email'	=>'',
				'address'	=>'',
				'provinceid'	=>'79',
				'content'	=>'',
				'districtid'	=>'',
				'wardid'	=>'',
			);
		if(Session::has('input_rd')){
			$input = Session::get('input_rd');
		}
		$datas['input'] = $input;
		$datacart = array();
		$mdPro = new Nproducts();
		$mdCat = new Ncategories();
		//$total = 0;
		$total_real = 0;
		foreach ($cart as $key => $value) {
			$data = $mdPro->find($key);
			$category = $mdCat->find($data->CategoryID);
			$price_convert = SiteHelpers::getPricePromotion($data);

			$price_item = $price_convert * $value;
			//$total += $data->UnitPrice * $value ;
			$total_real += $price_item ;
			$datacart[$key]['image'] = $data->image == '' ? URL::to('').'/sximo/images/no_pic.png' : URL::to('').'/uploads/products/thumb/'.$data->image;
			$datacart[$key]['ProductName'] = $data->ProductName;
			$datacart[$key]['categoryname'] = $category->CategoryName != "" ?  $category->CategoryName : 'Unknow';
			$datacart[$key]['sl'] = $value;
			$datacart[$key]['price'] = number_format($price_convert,0,',','.') . 'VNĐ';
			$datacart[$key]['price_total'] = number_format($price_item,0,',','.') . 'VNĐ';
			$datacart[$key]['price_promition'] = $data->id_promotion != 0 ? '<br/><span style="color: #f00;font-weight: normal;text-decoration: line-through;">'.number_format($data->UnitPrice,0,',','.') . 'VNĐ</span><br/>' : '';
			$datacart[$key]['link'] = URL::to('')."/detail/".$data->slug . "-" . $data->ProductID . ".html";
		}
		$datas['cart'] = $datacart;
		//$datas['total'] = $total;
		$datas['total_real'] = number_format($total_real,0,',','.') . 'VNĐ';
		$datas['total'] = $total_real;

		$this->data['pageTitle'] = 'Check out';
		$this->data['pageNote'] = 'Welcome To Our Site';

		//$this->data['breadcrumb'] = 'inactive';
		$page = 'pages.template.checkout';


		$page = SiteHelpers::renderHtml($page);
		$this->layout->nest('content',$page,$datas)->with('page', $this->data);
	}

	public function getUpdatecart(){
		if($_GET['id'] != '' && $_GET['quality'] != ''){
			$id = $_GET['id'] ;
			$quality = $_GET['quality'] ;
			$cart = Session::get('addcart');
			if(isset($cart[$id])){
				$cart[$id] = $quality;
				Session::put('addcart',$cart);
				Session::save();
			}
		}
		die;
	}*/
	

	public function index()
	{
		if(CNF_FRONT =='false' && Session::get('uid') !=1) :
			if(!Auth::check())  return Redirect::to('user/login');
		endif; 
		$data = array();
		$mdPage = new Pages();
		$id = $this->lang == 'en' ? 1 : 2;
		$item = $mdPage->find($id);
		$data['page'] = $item;
		$this->data['pageTitle'] = Lang::get('layout.home');
		$this->data['brc'] = '<li><a href="'.URL::to("").'">'.Lang::get('layout.home').'</a></li>';
		//$this->data['pageNote'] = 'Welcome To Our Site';
		//$this->data['breadcrumb'] = 'inactive';			
		$page = 'pages.'.$this->theme.'.index';
		
		$page = SiteHelpers::renderHtml($page);

		$this->layout->nest('content',$page,$data)->with('page', $this->data)->with('menu', 'index' );
			
	}

	public function page($id){
		$mdPage = new Pages();
		//$item = $mdPage->find($id);
		$item = DB::table('tb_pages')->where('pageID','=',$id)->where('status','=',1)->where('lang','=',$this->lang)->first();
		if(count($item) <= 0){
			return Redirect::to(URL::to(''))->with('message', SiteHelpers::alert('warning','Trang bạn yêu cầu không tồn tại !'));	
		}
		$this->data['brc'] = '<li><a href="'.URL::to("").'">'.Lang::get('layout.home').'</a></li><li class="active">'.$item->title.'</li>';
		$data['page'] = $item;
		$this->data['pageTitle'] = $item->title;
		$this->data['pageNote'] = CNF_APPNAME;

		//$this->data['breadcrumb'] = 'inactive';
		$page = 'pages.'.$this->theme.'.index';


		$page = SiteHelpers::renderHtml($page);
		$this->layout->nest('content',$page,$data)->with('page', $this->data)->with('menu','page');
	}

	public function contactus(){
		$input = array(
				"name"=>'',
				"email"=>'',
				"comment"=>'',
				"website"=>''
			);
		if(Session::has('input_rd')){
			$input = Session::get('input_rd');
		}
		$data['input'] = $input;


		$page = 'pages.'.$this->theme.'.contactus';
		$this->data['brc'] = '<li><a href="'.URL::to("").'">'.Lang::get('layout.home').'</a></li><li class="active">'.Lang::get('layout.contact').'</li>';
		$this->data['pageTitle'] = Lang::get('layout.contact');
		//$this->data['pageNote'] = CNF_APPNAME;
		$page = SiteHelpers::renderHtml($page);
		$this->layout->nest('content',$page,$data)->with('page', $this->data)->with('menu','contactus');
	}

	public function  postContactform()
	{
	
		$this->beforeFilter('csrf', array('on'=>'post'));
		$rules = array(
				'name'		=>'required',
				'email'	=>'required|email',
				'comment'	=>'required',
		);
		//if(CNF_RECAPTCHA =='true') $rules['recaptcha_response_field'] = 'required|recaptcha';
		$validator = Validator::make(Input::all(), $rules);	
		if ($validator->passes()) 
		{
			
			$data = array('name'=>Input::get('name'),'comment'=>Input::get('comment'),'email'=>Input::get('email'),'website'=>Input::get('website')); 
			
			Mail::send('emails.contact', $data, function($message)
			{
				$message->from( Input::get('email'), Input::get('name') );
			    $message->to(CNF_EMAIL, 'Admin')->subject(Lang::get('layout.contact_info'));
			});
			return Redirect::to(URL::to(''))->with('message', SiteHelpers::alert('success',Lang::get('layout.success_submit_form_contact')));	
				
		} else {
			return Redirect::to(URL::to('')."/contact-us.html")->with('message_contact', SiteHelpers::alert('error',Lang::get('layout.notice_error_submit_form_contact')))->with('input_rd',Input::all())
			->withErrors($validator)->withInput();
		}		
	}

	public function service(){
		$services = DB::table('service')->where('status','=','1')->where('lang','=',$this->lang)->orderby('created','DESC')->limit(6)->get();
		$data['services'] = $services;
		$page = 'pages.'.$this->theme.'.service';
		$this->data['brc'] = '<li><a href="'.URL::to("").'">'.Lang::get('layout.home').'</a></li><li class="active">'.Lang::get('layout.service').'</li>';
		$this->data['pageTitle'] = Lang::get('layout.service');
		//$this->data['pageNote'] = CNF_APPNAME;
		$page = SiteHelpers::renderHtml($page);
		$this->layout->nest('content',$page,$data)->with('page', $this->data)->with('menu','contactus');
	}

	public function postMoreservice(){
		$num = Input::get('num');
		$services = DB::table('service')->where('status','=','1')->where('lang','=',$this->lang)->orderby('created','DESC')->take(6)->skip($num)->get();
		$output = '';
		foreach($services as $item){
			$output .= SiteHelpers::templateService($item);
			$num ++;
		}
		echo $output != '' ? $output."&&&&&".$num : '';die;
	}

	public function tintuc(){
		$data = array();
		$this->data['brc'] = '<li><a href="'.URL::to("").'">'.Lang::get('layout.home').'</a></li><li class="active">'.Lang::get('layout.news').'</li>';

		$news1 = DB::table('news')->where('cat_id','=','1')->where('news_status','=','1')->where('lang','=',$this->lang)->orderby('created','DESC')->get();
		$num1 = 1;
		$output1 = '';
		foreach($news1 as $item1){
			$type = ($num1 == 1 || $num1 ==2 || ($num1 -1) % 8 == 0 || ($num1 -2) % 8 == 0) ? 'big' : 'small';
			if($num1 == 1){
				$output1 .= '<div class="list">';
			}
			$output1 .= SiteHelpers::templateNews($item1,$type);
			if($num1 % 8 == 0){
				$output1 .= '</div><div class="list">';
			}
			$num1 ++;
		}
		$output1 = $output1."</div>";
		$data['news1'] = str_replace('<div class="list"></div>', '', $output1);

		$news2 = DB::table('news')->where('cat_id','=','2')->where('news_status','=','1')->where('lang','=',$this->lang)->orderby('created','DESC')->get();
		$num2 = 1;
		$output2 = '';
		foreach($news2 as $item2){
			$type = ($num2 == 1 || ($num2 - 1) % 4 == 0) ? 'big' : 'small';
			if($num2 == 1){
				$output2 .= '<div class="list">';
			}
			$output2 .= SiteHelpers::templateNews($item2,$type);
			if($num2 % 4 == 0){
				$output2 .= '</div><div class="list">';
			}
			$num2 ++;
		}
		$output2 = $output2."</div>";
		$data['news2'] = str_replace('<div class="list"></div>', '', $output2);

		$news3 = DB::table('news')->where('cat_id','=','3')->where('news_status','=','1')->where('lang','=',$this->lang)->orderby('created','DESC')->get();
		$num3 = 1;
		$output3 = '';
		foreach($news3 as $item3){
			if($num3 == 1){
				$output3 .= '<div class="list">';
			}
			$output3 .= SiteHelpers::templateNews($item3,'other');
			if($num3 % 6 == 0){
				$output3 .= '</div><div class="list">';
			}
			$num3 ++;
		}
		$output3 = $output3."</div>";
		$data['news3'] = str_replace('<div class="list"></div>', '', $output3);

		$this->data['pageTitle'] = Lang::get('layout.news');;
		//$this->data['pageNote'] = CNF_APPNAME;
		$page = 'pages.'.$this->theme.'.tintuc';
		$page = SiteHelpers::renderHtml($page);
		$this->layout->nest('content',$page,$data)->with('page', $this->data)->with('menu','tintuc');
	}

	public function detailtintuc($alias = '', $id = ''){
		$new = DB::table('news')->where('news_id','=',$id)->where('news_status','=','1')->where('lang','=',$this->lang)->first();
		if(count($new) == 0){
			return Redirect::to('');
		}
		$this->layout = View::make("layouts.".CNF_THEME.".detailnew");
		$this->data['brc'] = '<li><a href="'.URL::to("").'">'.Lang::get('layout.home').'</a></li><li><a href="'.URL::to("news.html").'">'.Lang::get('layout.news').'</a></li><li class="active">'.$new->news_name.'</li>';
		$data['new'] = $new;
		$pre = DB::table('news')->where('news_id','<',$id)->where('news_status','=','1')->where('lang','=',$this->lang)->orderby('news_id','DESC')->first();
		$this->data['pre'] = $pre != '' ? URL::to('')."/news/".$pre->news_alias."-".$pre->news_id.".html" : '';
		$next = DB::table('news')->where('news_id','>',$id)->where('news_status','=','1')->where('lang','=',$this->lang)->orderby('news_id','ASC')->first();
		$this->data['next'] = $next != '' ? URL::to('')."/news/".$next->news_alias."-".$next->news_id.".html" : "";
		$this->data['pageTitle'] = $new->news_name;
		//$this->data['pageNote'] = CNF_APPNAME;
		$this->data['description'] = $new->news_description;
		$this->data['image'] = URL::to('')."/uploads/news/".$new->news_picture;
		list($width, $height) = getimagesize(ROOT."/uploads/news/".$new->news_picture);
		$this->data['width'] = $width;
		$this->data['height'] = $height;
		$page = 'pages.'.$this->theme.'.detailnews';
		$page = SiteHelpers::renderHtml($page);
		$this->layout->nest('content',$page,$data)->with('page', $this->data)->with('menu','detailnews');
	}

	/*public function getAddtocart(){
		if($_GET['id'] != '' && $_GET['quality'] != ''){
			$id = $_GET['id'] ;
			$quality = $_GET['quality'] ;
			$cart = Session::get('addcart');
			if(isset($cart[$id])){
				$cart[$id] = $cart[$id] + $quality;
			}
			else{
				$cart[$id] =  $quality;
			}
			
			Session::put('addcart',$cart);
			Session::save();
		}
		$output = SiteHelpers::getCart();

		echo $output;die;

	}

	public function getLoadcart(){
		$cart = Session::get('addcart');
		if(count($cart) > 0){
			$mdPro = new Nproducts();
			$datacart = array();
			foreach($cart as $key=>$val){
				$data = $mdPro->find($key);
				$price_convert = SiteHelpers::getPricePromotion($data);
				$price_item = $price_convert * $val;
				$datacart[$key]['ProductName'] = $data->ProductName;
				$datacart[$key]['image'] = $data->image != '' ? asset('uploads/products/thumb').'/'.$data->image : asset('sximo/images/no_pic.png');
				$datacart[$key]['sl'] = $val;
				$datacart[$key]['link'] = URL::to('detail').'/'.$data->slug.'-'.$data->ProductID.'.html';
				$datacart[$key]['price'] = number_format($price_convert,0,',','.').' VNĐ';
			}
			$view = View::make('pages.template.loadcart')->with('datacart', $datacart);
	    	echo $view;die;
		}else{
			echo '';die;
		}

	}

	public function getRemovecart(){
		if($_GET['id'] != ''){
			$id = $_GET['id'] ;
			$cart = Session::get('addcart');
			unset($cart[$id]);
			Session::put('addcart',$cart);
			Session::save();
		}
		$output = SiteHelpers::getCart();

		echo $output;die;
	}

	*/


	public function  getLang($lang='en')
	{
		Session::put('lang', $lang);
		return  Redirect::back();
	}	
}