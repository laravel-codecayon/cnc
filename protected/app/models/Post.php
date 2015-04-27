<?php
class Post extends BaseModel  {
	
	protected $table = 'post';
	protected $primaryKey = 'post_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT post.* FROM post  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE post.post_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	public function columnTable(){
		$array = array(
			"post_id" => array("label"=>Lang::get('core.table_id'), "type"=>"text", "name"=>"post_id", "value" => ""),
			"post_subject" => array("label"=>Lang::get('core.table_subject'), "type"=>"text", "name"=>"post_subject", "value" => ""),
			"name" => array("label"=>Lang::get('core.table_name'), "type"=>"text", "name"=>"name", "value" => ""),
			"phone" => array("label"=>Lang::get('core.table_phone'), "type"=>"text", "name"=>"phone", "value" => ""),
			"status" => array("label"=>Lang::get('core.table_status'), "type"=>"radio", "name"=>"status", "value" => "","option"=>array("0"=>Lang::get('core.table_disable'),"1"=>Lang::get('core.table_enable'))),
			"active" => array("label"=>Lang::get('core.post_active'), "type"=>"radio", "name"=>"active", "value" => "","option"=>array("0"=>"UnActive","1"=>"Active")),
			"created" => array("label"=>Lang::get('core.table_created'), "type"=>"date", "name"=>"created", "value" => ""),
		);
		return $array;
	}

}
