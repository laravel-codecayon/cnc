<?php
class Producttype extends BaseModel  {
	
	protected $table = 'product_type';
	protected $primaryKey = 'type_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT product_type.* FROM product_type  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE product_type.type_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	
	public static $rules=array(
			"type_name" => "required",
			"description" => "required",
			//"file" => "mimes:gif,png,jpg,jpeg|image|max:20000",
		);
	public function columnTable(){
		$array = array(
			"type_id" => array("label"=>Lang::get('core.table_id'), "type"=>"text", "name"=>"type_id", "value" => ""),
			"type_name" => array("label"=>Lang::get('core.table_name'), "type"=>"text", "name"=>"type_name", "value" => ""),
			"created" => array("label"=>Lang::get('core.table_created'), "type"=>"date", "name"=>"created", "value" => ""),
			"status" => array("label"=>Lang::get('core.table_status'), "type"=>"radio", "name"=>"status", "value" => "","option"=>array("0"=>Lang::get('core.disable'),"1"=>Lang::get('core.enable'))),
			//"UnitPrice" => array("label"=>"Price", "type"=>"text", "name"=>"UnitPrice", "value" => ""),
			//"CategoryID" => array("label"=>"Category", "type"=>"select", "name"=>"CategoryID", "value" => "", "model"=>"categories", "id"=>"CategoryID", "show" =>"CategoryName"),
		);
		return $array;
	}

}
