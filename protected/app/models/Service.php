<?php
class Service extends BaseModel  {
	
	protected $table = 'service';
	protected $primaryKey = 'service_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT service.* FROM service  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE service.service_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	public static $rules=array(
			"service_name" => "required",
			"service_description" => "required",
			"file" => "mimes:gif,png,jpg,jpeg|image|max:20000",
			"file2" => "mimes:gif,png,jpg,jpeg|image|max:20000",
		);
	public function columnTable(){
		$array = array(
			"service_id" => array("label"=>Lang::get('core.table_id'), "type"=>"text", "name"=>"service_id", "value" => ""),
			"service_name" => array("label"=>Lang::get('core.table_name'), "type"=>"text", "name"=>"service_name", "value" => ""),
			"created" => array("label"=>Lang::get('core.table_created'), "type"=>"date", "name"=>"created", "value" => ""),
			"status" => array("label"=>Lang::get('core.table_status'), "type"=>"radio", "name"=>"status", "value" => "","option"=>array("0"=>Lang::get('core.disable'),"1"=>Lang::get('core.enable'))),
			//"UnitPrice" => array("label"=>"Price", "type"=>"text", "name"=>"UnitPrice", "value" => ""),
			//"CategoryID" => array("label"=>"Category", "type"=>"select", "name"=>"CategoryID", "value" => "", "model"=>"categories", "id"=>"CategoryID", "show" =>"CategoryName"),
		);
		return $array;
	}

}
