<?php
class Nproducts extends BaseModel  {
	
	protected $table = 'products';
	protected $primaryKey = 'ProductID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT products.* FROM products  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE products.ProductID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}

	public static function getPaging($id = 0 , $lang = 'vi', $perpage = 9, $page = 1){
		$page = $page == 0 ? 1 : $page;
		$skip =  $page == 1 ? 0 : ($page - 1) * $perpage;
		$all = DB::table('products')->join('product_tag','products.ProductID','=','product_tag.ProductID')
												->where('product_tag.tags_id','=',$id)
												->where('products.status','=',1)
												->where('products.lang','=',$lang)->get();
		$results['total'] = count($all);
		$results['rows'] = DB::table('products')->join('product_tag','products.ProductID','=','product_tag.ProductID')
												->where('product_tag.tags_id','=',$id)
												->where('products.status','=',1)
												->where('products.lang','=',$lang)
												->take($perpage)->skip($skip)->get();
		return $results;
	}

	public static function getPagingFavor($id = 0 , $lang = 'vi', $perpage = 9, $page = 1){
		$page = $page == 0 ? 1 : $page;
		$skip =  $page == 1 ? 0 : ($page - 1) * $perpage;
		$all = DB::table('products')->join('product_customer','products.ProductID','=','product_customer.ProductID')
												->where('product_customer.customer_id','=',$id)->get();
		$results['total'] = count($all);
		$results['rows'] = DB::table('products')->join('product_customer','products.ProductID','=','product_customer.ProductID')
												->select("products.*","product_customer.time")
												->where('product_customer.customer_id','=',$id)
												->take($perpage)->skip($skip)->get();
		return $results;
	}

	public static $rules=array(
			"ProductName" => "required",
			"UnitPrice" => "numeric",
			"CategoryID" => "required|numeric",
			"file" => "mimes:gif,png,jpg,jpeg|image|max:20000",
		);
	
	public function columnTable(){
		$array = array(
			"ProductID" => array("label"=>Lang::get('core.table_id'), "type"=>"text", "name"=>"ProductID", "value" => ""),
			"ProductName" => array("label"=>Lang::get('core.table_name'), "type"=>"text", "name"=>"ProductName", "value" => ""),
			"ProductCode" => array("label"=>Lang::get('core.table_code'), "type"=>"text", "name"=>"ProductCode", "value" => ""),
			"UnitPrice" => array("label"=>Lang::get('core.table_price'), "type"=>"text", "name"=>"UnitPrice", "value" => ""),
			"CategoryID" => array("label"=>Lang::get('core.table_category'), "type"=>"select", "name"=>"CategoryID", "value" => "", "model"=>"categories", "id"=>"CategoryID", "show" =>"CategoryName"),
			"type_id" => array("label"=>Lang::get('core.table_type'), "type"=>"select", "name"=>"type_id", "value" => "", "model"=>"product_type", "id"=>"type_id", "show" =>"type_name"),
			"id_promotion" => array("label"=>Lang::get('core.table_promotion'), "type"=>"select_nola", "name"=>"id_promotion", "value" => "", "model"=>"promotion", "id"=>"id_promotion", "show" =>"name"),
			"status" => array("label"=>Lang::get('core.table_status'), "type"=>"radio", "name"=>"status", "value" => "","option"=>array("0"=>Lang::get('core.table_disable'),"1"=>Lang::get('core.table_enable'))),
			"is_hot" => array("label"=>Lang::get('core.hot'), "type"=>"radio", "name"=>"is_hot", "value" => "","option"=>array("0"=>Lang::get('core.no'),"1"=>Lang::get('core.yes'))),
			"position" => array("label"=>Lang::get('core.table_position'), "type"=>"text", "name"=>"position", "value" => ""),
			"created" => array("label"=>Lang::get('core.table_created'), "type"=>"date", "name"=>"created", "value" => ""),
		);
		return $array;
	}

}
