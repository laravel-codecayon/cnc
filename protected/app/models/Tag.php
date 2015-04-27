<?php
class Tag extends BaseModel  {
	
	protected $table = 'tags';
	protected $primaryKey = 'tags_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT tags.* FROM tags  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE tags.tags_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	public static $rules=array(
			"tags_name" => "required",
			//"description" => "required",
			//"file" => "mimes:gif,png,jpg,jpeg|image|max:20000",
	);
	public static function getListtags(){
		return DB::table('tags')->where('status','=',1)->get();
	}
	public static function getListtagsAvai($id = 0){
		$datas = DB::table('product_tag')->where('ProductID','=',$id)->get();
		$result = array();
		foreach($datas as $item){
			$result[] = $item->tags_id;
		}
		return $result;
	}
	public function columnTable(){
		$array = array(
			"tags_id" => array("label"=>Lang::get('core.table_id'), "type"=>"text", "name"=>"tags_id", "value" => ""),
			"tags_name" => array("label"=>Lang::get('core.table_name'), "type"=>"text", "name"=>"tags_name", "value" => ""),
			"created" => array("label"=>Lang::get('core.table_created'), "type"=>"date", "name"=>"created", "value" => ""),
			"status" => array("label"=>Lang::get('core.table_status'), "type"=>"radio", "name"=>"status", "value" => "","option"=>array("0"=>Lang::get('core.disable'),"1"=>Lang::get('core.enable'))),
			//"UnitPrice" => array("label"=>"Price", "type"=>"text", "name"=>"UnitPrice", "value" => ""),
			//"CategoryID" => array("label"=>"Category", "type"=>"select", "name"=>"CategoryID", "value" => "", "model"=>"categories", "id"=>"CategoryID", "show" =>"CategoryName"),
		);
		return $array;
	}

}
