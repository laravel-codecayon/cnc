<?php
class SiteHelpers
{

	public static function menus( $position ='top',$active = '1')
	{
		$data = array();  
		$menu = self::nestedMenu(0,$position ,$active);		
		foreach ($menu as $row) 
		{
			$child_level = array();
			$p = json_decode($row->access_data,true);
			
			
			if($row->allow_guest == 1)
			{
				$is_allow = 1;
			} else {
				$is_allow = (isset($p[Session::get('gid')]) && $p[Session::get('gid')] ? 1 : 0);
			}
			if($is_allow ==1) 
			{
				
				$menus2 = self::nestedMenu($row->menu_id , $position ,$active );
				if(count($menus2) > 0 )
				{	 
					$level2 = array();							 
					foreach ($menus2 as $row2) 
					{
						$p = json_decode($row2->access_data,true);
						if($row2->allow_guest == 1)
						{
							$is_allow = 1;
						} else {
							$is_allow = (isset($p[Session::get('gid')]) && $p[Session::get('gid')] ? 1 : 0);
						}						
									
						if($is_allow ==1)  
						{						
					
							$menu2 = array(
									'menu_id'		=> $row2->menu_id,
									'module'		=> $row2->module,
									'menu_type'		=> $row2->menu_type,
									'url'			=> $row2->url,
									'menu_name'		=> $row2->menu_name,
									'menu_icons'	=> $row2->menu_icons,
									'childs'		=> array()
								);	
												
							$menus3 = self::nestedMenu($row2->menu_id , $position , $active);
							if(count($menus3) > 0 )
							{
								$child_level_3 = array();
								foreach ($menus3 as $row3) 
								{
									$p = json_decode($row3->access_data,true);
									if($row3->allow_guest == 1)
									{
										$is_allow = 1;
									} else {
										$is_allow = (isset($p[Session::get('gid')]) && $p[Session::get('gid')] ? 1 : 0);
									}										
									if($is_allow ==1)  
									{								
										$menu3 = array(
												'menu_id'		=> $row3->menu_id,
												'module'		=> $row3->module,
												'menu_type'		=> $row3->menu_type,
												'url'			=> $row3->url,												
												'menu_name'		=> $row3->menu_name,
												'menu_icons'	=> $row3->menu_icons,
												'childs'		=> array()
											);	
										$child_level_3[] = $menu3;	
									}					
								}
								$menu2['childs'] = $child_level_3;
							}
							$level2[] = $menu2 ;
						}	
					
					}
					$child_level = $level2;
						
				}
				
				$level = array(
						'menu_id'		=> $row->menu_id,
						'module'		=> $row->module,
						'menu_type'		=> $row->menu_type,
						'url'			=> $row->url,						
						'menu_name'		=> $row->menu_name,
						'menu_icons'	=> $row->menu_icons,
						'childs'		=> $child_level
					);			
				
				$data[] = $level;	
			}	
				
		}	
		//echo '<pre>';print_r($data); echo '</pre>'; exit;
		return $data;
	}
	
	public static function getSlide(){
		return Slideshow::where('slideshow_status','=','1')->get();
	}

	public static function getProductHot(){
		$lang = Session::get('lang') == '' ? CNF_LANG : Session::get('lang');
		return Nproducts::where('status','=','1')->where('lang','=',$lang)->where('is_hot','=','1')->orderBy('created','desc')->limit(4)->get();
	}

	public static function getMenuCategories(){
		$lang = Session::get('lang') == '' ? CNF_LANG : Session::get('lang');
		return Ncategories::where('status','=','1')->where('lang','=',$lang)->orderBy('CategoryName','asc')->get();
	}

	public static function getCategoryCode($id = 0){
		$data = Ncategories::where('status','=','1')->where('CategoryID','=',$id)->first();
		return $data;
	}

	public static function getMenuProductSale(){
		$lang = Session::get('lang') == '' ? CNF_LANG : Session::get('lang');
		$pro = Promotion::where('status','=','1')->orderBy('created','desc')->limit(1)->first();
		if(count($pro) <= 0){
			return false;
		}
		return Nproducts::where('status','=','1')->where('lang','=',$lang)->where('id_promotion','=',$pro->id_promotion)->orderBy('created','desc')->limit(10)->get();
	}

	public static function getMenuNews(){
		$lang = Session::get('lang') == '' ? CNF_LANG : Session::get('lang');
		return News::where('news_status','=','1')->where('lang','=',$lang)->orderBy('created','desc')->limit(5)->get();
	}

	public static function getArrayTemplateEmail(){
		$dir = app_path() ."/views/emails/";
		$array_file = array();
		if (is_dir($dir)) {
		    if ($dh = opendir($dir)) {
		        while (($file = readdir($dh)) !== false) {
		        	if(is_file($dir.$file)){
		        		$array_file[$dir.$file] = $file;
		        	}
		        }
		        closedir($dh);
		    }
		}
		return $array_file;
	}

	public static function getListTags(){
		$data = DB::table('tags')->where('status','=',1)->limit(10)->get();
		$result = '';
		foreach($data as $item){
			$result .= '<li><a href="'.URL::to('').'/tag/'.$item->alias.'-'.$item->tags_id.'.html" title="'.$item->tags_name.'">'.$item->tags_name.'</a></li>';
		}
		return $result;
	}

	public static function getProductMain($type = 0){
		$lang = Session::get('lang') == '' ? CNF_LANG : Session::get('lang');
		$str_dup = '';
		if($type == 0){
			$pro = Nproducts::where('status','=','1')->where('lang','=',$lang)->where('is_hot','!=','1')->orderBy('position','desc')->orderBy('created','desc')->limit(12)->get();
			$i=1;
			foreach($pro as $item){
				$str_dup .= $i == 1 ? $item->ProductID : ','.$item->ProductID;
				$i++;
			}
			Session::put('pro_dup',$str_dup);
			Session::save();
		}elseif($type == 1){
			$not_in = Session::get('pro_dup');
			$pro = Nproducts::where('status','=','1')->where('lang','=',$lang)->where('is_hot','!=','1')->whereNotIn('ProductID', [$not_in])->orderBy('created','desc')->limit(8)->get();
		}

		return $pro;
	}

	public static function listposthome($type = 0){
		$post = DB::table('post')->where('status','=','1')->where('active','=','1')->where('post_typecustomer','=',$type)->orderBy('post_id','desc')->limit(10)->get();
		return $post;
	}

	public static function getAdvertise($type = 1){
		$limit = $type == 0 ? 2 : 1;
		$data = Advertise::where('position','=',$type)->where('status','=',1)->limit($limit)->get();
		return $data;
	}

	public static function getNameaddress($id = '',$table = '',$key=''){
		$data = DB::table($table)->where($key,"=",$id)->first();
		$name = count($data) > 0 ? $data->name : '';
		return $name;
	}

	public static function randomPassword() {
	    $alphabet = "abcdefghijklmnopqrstuwxyz0123456789";
	    $pass = array(); //remember to declare $pass as an array
	    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	    for ($i = 0; $i < 8; $i++) {
	        $n = rand(0, $alphaLength);
	        $pass[] = $alphabet[$n];
	    }
	    return implode($pass); //turn the array into a string
	}

	public static function getSex($sex = ''){
		return $sex == 1 ? "Nam" : "Nu";
	}

	public static function templateProduct($data = "",$type = "gird")
	{
		$link = URL::to('')."/chi-tiet/".$data->slug."-".$data->ProductID.".html";
		$image = URL::to('')."/uploads/products/thumb/".$data->image;
		if($data->id_promotion == 0)
		{
			$html_promotion = '';
			$price = '<span class="price-new">'.number_format($data->UnitPrice,0,',','.') . 'đ</span>';
		}
		else
		{
			$promotion = DB::table('promotion')->where('status','=',1)->where('id_promotion','=',$data->id_promotion)->first();
			$html_promotion = '<span class="product-label-special-right label">-'.$promotion->promotion .'</span>';
			if(count($promotion) >= 1){
				$pri = $promotion->type == 1 ? $data->UnitPrice - $promotion->promotion : $data->UnitPrice - ($data->UnitPrice * $promotion->promotion/100);
				$price = '<span class="price-old">'.number_format($data->UnitPrice,0,',','.') . 'đ</span><br/>';
				$price .= '<span class="price-new">'.number_format($pri,0,',','.') . 'đ</span>';
			}
			else{
				$price = '<span class="price-new">'.number_format($data->UnitPrice,0,',','.') . 'đ</span>';
			}
		}
		if($type == "gird"){
			$output = '<div class="col-lg-3 col-md-3 col-sm-4 col-xs-6 col94 mg">
                            <!--item -->
                            <div class="product">
                              <div class="image">
                                <div class="img-overflow"> 
                                    <a href="'.$link.'" title="'.$data->ProductCode.'">
                                    <img src="'.$image.'" alt="'.$data->ProductCode.'">                   
                                    </a> 
                                </div>

                                <!--span class="product-label-special-left label">NEW</span-->
                                                                '.$html_promotion.'

                                <a href="'.$link.'" title="'.$data->ProductCode.'">
                                <h3>'.$data->ProductCode.'</h3>
                                </a>
                                <p>'.$data->ProductName.'</p>
                              </div>
                              <div class="price"> 
                                        '.$price.'
                                                                                                  </div>
                              <ul class="function">
                                                                                                            <li>
                                       <a href="javascript:void(0)" onclick="add_cart('.$data->ProductID.')" title="Mua sản phẩm này">
                                            <button type="button" class="btn btnitem">
                                                <i class="fa fa-shopping-cart"></i>
                                            </button>
                                        </a>
                                    </li>
                                                                                                                                                <li>
                                       <a href="javascript:void(0)" onclick="add_favo('.$data->ProductID.')" title="Thêm vào danh sách yêu thích">
                                            <button type="button" class="btn btnitem">
                                                <i class="fa fa-heart"></i>
                                            </button>
                                        </a>
                                                                    </ul>
                            </div>

                            <!--item -->

                </div>';
            }else{
            	$output = '<article class="catalist col3">                               	
									<div class="row">
                                        <figure class="col-lg-3 col-md-4 col-sm-4 col-xs-4">
                                        	<div class="image">
                                            	<a href="'.$link.'" title="'.$data->ProductCode.'">
                                               		<div class="img-overflow">
                                                    	<img src="'.$image.'" alt="'.$data->ProductCode.'">
                                                	</div>
                                            	</a>
                                                	
                                                	                                            </div>
                                        </figure>
									
                                        <figure class="col-lg-9 col-md-8 col-sm-8 col-xs-8">
                                            <a href="'.$link.'" title="'.$data->ProductCode.'">
                                                <h3>'.$data->ProductCode.'</h3>
                                            </a>                                           
                                            <p>'.$data->description.'</p>
                                            <div class="price">
                                            		                                                													    '.$price.'
																									                                            </div>
                                            <ul class="function pull-right">
                                                                                                						                                <li>
					                                   <a href="javascript:void(0)" onclick="add_cart('.$data->ProductID.')" title="Mua sản phẩm này">
					                                        <button type="button" class="btn btnitem">
					                                            <i class="fa fa-shopping-cart"></i>
					                                        </button>
					                                    </a>
					                                </li>
					                                
					                             						                             					                                
					                                <li>
					                                   <a href="javascript:void(0)" onclick="add_favo('.$data->ProductID.')" title="Thêm vào danh sách yêu thích">
					                                        <button type="button" class="btn btnitem">
					                                            <i class="fa fa-heart"></i>
					                                        </button>
					                                    </a>
					                                                                          </ul>
                                        </figure>
									</div>                        
								</article>';
            }
		
		
        return $output;
	}

	public static function templateProductSide($data = "")
	{
		$image = $data->image == '' ? URL::to('').'/sximo/images/no_pic.png' : URL::to('').'/uploads/products/thumb/'.$data->image;
		if($data->id_promotion == 0)
		{
			$price = '<span class="price-new">'.number_format($data->UnitPrice,0,',','.') . 'VNĐ</span>';
		}
		else
		{
			$promotion = DB::table('promotion')->where('status','=',1)->where('id_promotion','=',$data->id_promotion)->first();
			if(count($promotion) >= 1){
				$pri = $promotion->type == 1 ? $data->UnitPrice - $promotion->promotion : $data->UnitPrice - ($data->UnitPrice * $promotion->promotion/100);
				$price = '<span class="price-old">'.number_format($data->UnitPrice,0,',','.') . 'VNĐ</span><br/>';
				$price .= '<span class="price-new">'.number_format($pri,0,',','.') . 'VNĐ</span>';
			}
			else{
				$price = '<span class="price-new">'.number_format($data->UnitPrice,0,',','.') . 'VNĐ</span>';
			}
		}
		$output = '';
		$output .=	'<div>';
        $output .=   '<div class="image"><a title="'.$data->ProductName.'" href="'.URL::to('').'/detail/'.$data->slug.'-'.$data->ProductID.'.html"><img width="60px" src="'.$image.'" alt="'.$data->ProductName.'" /></a></div>';
        $output .=   '<div class="name"><a title="'.$data->ProductName.'" href="'.URL::to('').'/detail/'.$data->slug.'-'.$data->ProductID.'.html">'.$data->ProductName.'</a></div>';
        $output .=   '<div class="price"> '.$price.' </div>';
        $output .=   '</div>';
        return $output;
	}

	public static function getTotalcart(){
		$price = 0;
		$mdPro = new Nproducts();

		foreach(Session::get('cart') as $key=>$val){
			$data = $mdPro->find($key);
			list($price_cv,$price_convert) = SiteHelpers::getPrice($data);
			$price_item = $price_cv * $val;
			$price += $price_item;
		}

		return $price;
	}


	public static function getCart(){
		$item = 0;
		$price = 0;
		if(Session::has('addcart')){
			$cart = Session::get('addcart');
			$item = 0;
			$price = 0;
			$mdPro = new Nproducts();
			foreach(Session::get('addcart') as $key=>$val){
				$data = $mdPro->find($key);
				$price_convert = SiteHelpers::getPricePromotion($data);
				$price_item = $price_convert * $val;
				$price += $price_item;
				$item += $val;
			}
		}
		return $item . " item(s) - " . number_format($price,0,',','.') . 'VNĐ';
	}

	public static function getNumcart(){
		$result = 0;
		if(Session::has('cart')){
			$cart = Session::get('cart');
			foreach($cart as $item){
				$result += $item;
			}
		}
		return $result;
	}

	public static function getNamePromotion($id){
		$data = DB::table('promotion')->where('id_promotion','=',$id)->first();
		return $data;
	}

	public static function saleProducts(){
		$lang = Session::get('lang') == '' ? CNF_LANG : Session::get('lang');
		$data = DB::table('products')->where('status','=','1')->where('lang','=',$lang)->where('id_promotion','!=','0')->orderBy(DB::raw('RAND()'))->limit(5)->get();
		return $data;
	}

	public static function randomProduct(){
		$lang = Session::get('lang') == '' ? CNF_LANG : Session::get('lang');
		$data = DB::table('products')->where('status','=','1')->where('lang','=',$lang)->orderBy(DB::raw('RAND()'))->limit(5)->get();
		return $data;
	}

	public static function getPricePromotion($product){
		if($product->id_promotion == 0)
		{
			$html_promotion = '';
			$price = '<span class="price-new">'.number_format($product->UnitPrice,0,',','.') . 'đ</span>';
		}
		else
		{
			$promotion = DB::table('promotion')->where('status','=',1)->where('id_promotion','=',$product->id_promotion)->first();
			if(count($promotion) >= 1){
				$pri = $promotion->type == 1 ? $product->UnitPrice - $promotion->promotion : $product->UnitPrice - ($product->UnitPrice * $promotion->promotion/100);
				$price = '<span class="price-old">'.number_format($product->UnitPrice,0,',','.') . 'đ</span><br/>';
				$price .= '<span class="price-new">'.number_format($pri,0,',','.') . 'đ</span>';
			}
			else{
				$price = '<span class="price-new">'.number_format($product->UnitPrice,0,',','.') . 'đ</span>';
			}
		}
		return $price;
	}

	public static function getOrdName($id){
		$length = strlen($id);
		$result = "ORD";
		if($length == 1){
			$result .= "0000".$id;
		}
		if($length == 2){
			$result .= "000".$id;
		}
		if($length == 3){
			$result .= "00".$id;
		}
		if($length == 4){
			$result .= "0".$id;
		}
		if($length == 5){
			$result .= $id;
		}
		return $result;
	}

	public static function getPrice($product){
		if($product->id_promotion == 0)
		{
			$price = $product->UnitPrice;
			$price_format = number_format($product->UnitPrice,0,',','.');

		}
		else
		{
			$promotion = DB::table('promotion')->where('status','=',1)->where('id_promotion','=',$product->id_promotion)->first();
			if(count($promotion) >= 1){
				$pri = $promotion->type == 1 ? $product->UnitPrice - $promotion->promotion : $product->UnitPrice - ($product->UnitPrice * $promotion->promotion/100);
				$price = $pri;
				$price_format = number_format($pri,0,',','.') ;
			}
			else{
				$price = $product->UnitPrice;
				$price_format = number_format($product->UnitPrice,0,',','.') ;
			}
		}
		return array($price,$price_format);
	}

	public static function getValuePromotion($product){
		$promotion = DB::table('promotion')->where('id_promotion','=',$product->id_promotion)->first();
		return $promotion->type == 1 ? $promotion->promotion : ($product->UnitPrice * $promotion->promotion/100);
	}
	
	public static function nestedMenu($parent=0,$position ='top',$active = '1')
	{
		$lang = Session::get('lang') == '' ? CNF_LANG : Session::get('lang');
		$group_sql = " AND tb_menu_access.group_id ='".Session::get('gid')."' ";
		$active 	=  ($active =='all' ? "" : "AND active ='1' ");
		$Q = DB::select("
		SELECT 
			tb_menu.*
		FROM tb_menu WHERE parent_id ='". $parent ."' ".$active." AND position ='{$position}' AND lang ='$lang'
		GROUP BY tb_menu.menu_id ORDER BY ordering
		");					
		return $Q;					
	}

	public static function GetSlideshow(){
		$lang = Session::get('lang') == '' ? CNF_LANG : Session::get('lang');
		$slide = DB::table('slideshow')->where("lang",'=', $lang)->where("slideshow_status",'=', '1')->get();
		return $slide;
	}

	public static function GetCategories(){
		$lang = Session::get('lang') == '' ? CNF_LANG : Session::get('lang');
		$cat = DB::table('categories')->where("lang",'=', $lang)->where("status",'=', '1')->get();
		return $cat;
	}

	public static function getNameCat($id= ''){
		$cat = DB::table('categories')->where("CategoryID",'=', $id)->first();
		return count($cat) > 0 ? $cat->CategoryName : '';
	}
	
	public static function CF_encode_json($arr) {
	  $str = json_encode( $arr );
	  $enc = base64_encode($str );
	  $enc = strtr( $enc, 'poligamI123456', '123456poligamI');
	  return $enc;
	}
	
	public static function CF_decode_json($str) {
	  $dec = strtr( $str , '123456poligamI', 'poligamI123456');
	  $dec = base64_decode( $dec );
	  $obj = json_decode( $dec ,true);
	  return $obj;
	}	
	
	
	public static function columnTable( $table )
	{	  
        $columns = array();
	    foreach(DB::select("SHOW COLUMNS FROM $table") as $column)
        {
           //print_r($column);
		    $columns[] = $column->Field;
        }
	  

        return $columns;
	}	
	
	public static function encryptID($id,$decript=false,$pass='',$separator='-', & $data=array()) {
		$pass = $pass?$pass:Config::get('app.key');
		$pass2 = Config::get('app.url');;
		$bignum = 200000000;
		$multi1 = 500;
		$multi2 = 50;
		$saltnum = 10000000;
		if($decript==false){
			$strA = self::alphaid(($bignum+($id*$multi1)),0,0,$pass);
			$strB = self::alphaid(($saltnum+($id*$multi2)),0,0,$pass2);
			$out = $strA.$separator.$strB;
		} else {
			$pid = explode($separator,$id);
			
			
		//    trace($pid);
			$idA = (self::alphaid($pid[0],1,0,$pass)-$bignum)/$multi1;
			$idB = (self::alphaid($pid[1],1,0,$pass2)-$saltnum)/$multi2;
			$data['id A'] = $idA;
			$data['id B'] = $idB;
			$out = ($idA==$idB)?$idA:false;
		}
		return $out;
	}
	
public static function alphaID($in, $to_num = false, $pad_up = false, $passKey = null)
{
    $index = "abcdefghijkmnpqrstuvwxyz23456789ABCDEFGHIJKLMNPQRSTUVWXYZ";
    if ($passKey !== null) {
        // Although this function's purpose is to just make the
        // ID short - and not so much secure,
        // with this patch by Simon Franz (http://blog.snaky.org/)
        // you can optionally supply a password to make it harder
        // to calculate the corresponding numeric ID
 
        for ($n = 0; $n<strlen($index); $n++) {
            $i[] = substr( $index,$n ,1);
        }
 
        $passhash = hash('sha256',$passKey);
        $passhash = (strlen($passhash) < strlen($index))
            ? hash('sha512',$passKey)
            : $passhash;
 
        for ($n=0; $n < strlen($index); $n++) {
            $p[] =    substr($passhash, $n ,1);
        }
 
        array_multisort($p,    SORT_DESC, $i);
        $index = implode($i);
    }
 
    $base    = strlen($index);
 
    if ($to_num) {
        // Digital number    <<--    alphabet letter code
        $in    = strrev($in);
        $out = 0;
        $len = strlen($in) - 1;
        for ($t = 0; $t <= $len; $t++) {
            $bcpow = bcpow($base, $len - $t);
            $out     = $out + strpos($index, substr($in, $t, 1)) * $bcpow;
        }
 
        if (is_numeric($pad_up)) {
            $pad_up--;
            if ($pad_up > 0) {
                $out -= pow($base, $pad_up);
            }
        }
        $out = sprintf('%F', $out);
        $out = substr($out, 0, strpos($out, '.'));
    } else {
        // Digital number    -->>    alphabet letter code
        if (is_numeric($pad_up)) {
            $pad_up--;
            if ($pad_up > 0) {
                $in += pow($base, $pad_up);
            }
        }
 
        $out = "";
        for ($t = floor(log($in, $base)); $t >= 0; $t--) {
            $bcp = bcpow($base, $t);
            $a     = floor($in / $bcp) % $base;
            $out = $out . substr($index, $a, 1);
            $in    = $in - ($a * $bcp);
        }
        $out = strrev($out); // reverse
    }
 
    return $out;
}	
		
	
	public static function toForm($forms,$layout)
	{
		$f = '';
	//	echo '<pre>'; print_r($forms);echo '</pre>';
		//usort($forms,"_sort"); 
		$block = $layout['column'];
		$format = $layout['format'];
		$display = $layout['display'];
		$title = explode(",",$layout['title']);
		
		if($format =='tab')
		{
			$f .='<ul class="nav nav-tabs">';
			
			for($i=0;$i<$block;$i++)
			{
				$active = ($i==0 ? 'active' : '');
				$tit = (isset($title[$i]) ? $title[$i] : 'None');	
				$f .= '<li class="'.$active.'"><a href="#'.trim(str_replace(" ","",$tit)).'" data-toggle="tab">'.$tit.'</a></li>
				';	
			}
			$f .= '</ul>';		
		}

		if($format =='tab') $f .= '<div class="tab-content">';
		for($i=0;$i<$block;$i++)
		{		
			if($block == 4) {
				$class = 'col-md-3';
			}  elseif( $block ==3 ) {
				$class = 'col-md-4';
			}  elseif( $block ==2 ) {
				$class = 'col-md-6';
			} else {
				$class = 'col-md-12';
			}	
			
			$tit = (isset($title[$i]) ? $title[$i] : 'None');	
			// Grid format 
			if($format == 'grid')
			{
				$f .= '<div class="'.$class.'">
						<fieldset><legend> '.$tit.'</legend>
				';
			} else {
				$active = ($i==0 ? 'active' : '');
				$f .= '<div class="tab-pane m-t '.$active.'" id="'.trim(str_replace(" ","",$tit)).'"> 
				';			
			}	
			
			
			
			$group = array(); 
			
			foreach($forms as $form)
			{
				$tooltip =''; $required = ($form['required'] != '0' ? '<span class="asterix"> * </span>' : '');
				if($form['view'] != 0)
				{
					if($form['field'] !='entry_by')
					{
						if(isset($form['option']['tooltip']) && $form['option']['tooltip'] !='') 	
						$tooltip = '<a href="#" data-toggle="tooltip" placement="left" class="tips" title="'. $form['option']['tooltip'] .'"><i class="icon-question2"></i></a>';	
						$hidethis = ""; if($form['type'] =='hidden') $hidethis ='hidethis';
						$inhide = ''; if(count($group) >1) $inhide ='inhide';
						//$ebutton = ($form['type'] =='radio' || $form['option'] =='checkbox') ? "ebutton-radio" : "";
						$show = '';
						if($form['type'] =='hidden') $show = 'style="display:none;"';	
						if($form['form_group'] == $i)
						{	
							if($display == 'horizontal')
							{			
								$f .= '					
								  <div class="form-group '.$hidethis.' '.$inhide.'" '.$show .'>
									<label for="'.$form['label'].'" class=" control-label col-md-4 text-left"> '.$form['label'].' '.$required.'</label>
									<div class="col-md-6">
									  '.self::formShow($form['type'],$form['field'],$form['required'],$form['option']).' 
									 </div> 
									 <div class="col-md-2">
									 	'.$tooltip.'
									 </div>
								  </div> '; 
							} else {
								$f .= '					
								  <div class="form-group '.$hidethis.' '.$inhide.'" '.$show .'>
									<label for="ipt" class=" control-label "> '.$form['label'].'  '.$required.' '.$tooltip.' </label>									
									  '.self::formShow($form['type'],$form['field'],$form['required'],$form['option']).' 						
								  </div> '; 							
							
							}	  
						}	  
					}	  
					
				}					
			}
			if($format == 'grid') $f .='</fieldset>';
			$f .= '
			</div>
			
			';
		} 		
		
		//echo '<pre>'; print_r($f);echo '</pre>'; exit;
		return $f;
	
	}
	public static function gridClass( $layout )
	{
		$column = $layout['column'];
		$format = $layout['format'];

		if($block == 4) {
			$class = 'col-md-3';
		}  elseif( $block ==3 ) {
			$class = 'col-md-4';
		}  elseif( $block ==2 ) {
			$class = 'col-md-6';
		} else {
			$class = 'col-md-12';
		}	
				
		
		if(format == 'tab')
		{
			$tag_open = '<div class="col-md-">';
			$tag_close = '<div class="col-md-">';
			
		}  elseif($layout['format'] == 'accordion'){
		
		} else {					
			$tag_open = '<div class="col-md-">';
			$tag_close = '</div>';
		}		
		

		return $class;	
	}
	
	
	public static function formShow( $type , $field , $required ,$option = array()){
		//print_r($option);
		$mandatory = '';$attribute = ''; $extend_class ='';
		if(isset($option['attribute']) && $option['attribute'] !='') {
				$attribute = $option['attribute']; }
		if(isset($option['extend_class']) && $option['extend_class'] !='') {
			$extend_class = $option['extend_class']; 
		}				
				
		$show = '';
		if($type =='hidden') $show = 'style="display:none;"';	
				
		if($required =='required') {
			$mandatory = "'required'=>'true'";
		} else if($required =='email') {
			$mandatory = "'required'=>'true', 'parsley-type'=>'email' ";
		} else if($required =='url') {
			$mandatory = "required parsley-type='url' ";
		} else if($required =='date') {
			$mandatory = "'required'=>'true', 'parsley-type'=>'dateIso' ";
		} else if($required =='numeric') {
			$mandatory = "'required'=>'true', 'parsley-type'=>'number' ";
		} else {
			$mandatory = '';
		}		
		
		switch($type)
		{
			default;
				$form = "{{ Form::text('{$field}', \$row['{$field}'],array('class'=>'form-control', 'placeholder'=>'', {$mandatory}  )) }}";
				break;
				
			case 'textarea';
				if($required !='0') { $mandatory = 'required'; }
				$form = "<textarea name='{$field}' rows='2' id='{$field}' class='form-control {$extend_class}'  
				         {$mandatory} {$attribute} >{{ \$row['{$field}'] }}</textarea>";
				break;

			case 'textarea_editor';
				if($required !='0') { $mandatory = 'required'; }
				$form = "<textarea name='{$field}' rows='2' id='editor' class='form-control markItUp {$extend_class}'  
						{$mandatory}{$attribute} >{{ \$row['{$field}'] }}</textarea>";
				break;				
				

			case 'text_date';
				$form = "
				{{ Form::text('{$field}', \$row['{$field}'],array('class'=>'form-control date', 'style'=>'width:150px !important;')) }}";
				break;
				
			case 'text_time';
				$form = "<input  type='text' name='{$field}' id='{$field}' value='{{ \$row['{$field}'] }}' 
						{$mandatory}  {$attribute} style='width:150px !important;'  class='form-control {$extend_class}'
						data-date-format='yyyy-mm-dd'
						 />";
				break;				

			case 'text_datetime';
				if($required !='0') { $mandatory = 'required'; }
				$form = "
				{{ Form::text('{$field}', \$row['{$field}'],array('class'=>'form-control datetime', 'style'=>'width:150px !important;')) }}";
				break;				

			case 'select';
				if($required !='0') { $mandatory = 'required'; }
				if($option['opt_type'] =='datalist')
				{
					$optList ='';
					$opt = explode("|",$option['lookup_query']);
					for($i=0; $i<count($opt);$i++) 
					{							
						$row =  explode(":",$opt[$i]);
						for($i=0; $i<count($opt);$i++) 
						{					
							
							$row =  explode(":",$opt[$i]);
							$optList .= " '".trim($row[0])."' => '".trim($row[1])."' , ";
							
						}							
					}	
					$form  = "
					<?php \$".$field." = explode(',',\$row['".$field."']);
					";
					$form  .= 
					"\$".$field."_opt = array(".$optList."); ?>
					";	
					
					if(isset($option['is_multiple']) && $option['is_multiple'] ==1)
					{
					 
						$form  .= "<select name='{$field}[]' rows='5' {$mandatory} multiple  class='select2 '  > ";
						$form  .= "
						<?php 
						foreach(\$".$field."_opt as \$key=>\$val)
						{
							echo \"<option  value ='\$key' \".(in_array(\$key,\$".$field.") ? \" selected='selected' \" : '' ).\">\$val</option>\"; 						
						}						
						?>";
						$form .= "</select>";
					} else {
						
						$form  .= "<select name='{$field}' rows='5' {$mandatory}  class='select2 '  > ";
						$form  .= "
						<?php 
						foreach(\$".$field."_opt as \$key=>\$val)
						{
							echo \"<option  value ='\$key' \".(\$row['".$field."'] == \$key ? \" selected='selected' \" : '' ).\">\$val</option>\"; 						
						}						
						?>";
						$form .= "</select>";				
					
					}
					
				} else {
					$form = "<select name='{$field}' rows='5' id='{$field}' code='{\${$field}}' 
							class='select2 {$extend_class}'  {$mandatory} {$attribute} ></select>";
				}
				break;	
				
			case 'file';
				if($required !='0') { $mandatory = 'requred'; }
				$form = "<input  type='file' name='{$field}' id='{$field}' ";
				$form .= "@if(\$row['$field'] =='') class='required' @endif "; 
				$form .= "style='width:150px !important;' {$attribute} />
					{{ SiteHelpers::showUploadedFile(\$row['{$field}'],'$option[path_to_upload]') }}
				";
				break;						
				
			case 'radio';
				if($required !='0') { $mandatory = 'requred'; }
				$opt = explode("|",$option['lookup_query']);
				$form = '';
				for($i=0; $i<count($opt);$i++) 
				{
					$checked = '';
					$row =  explode(":",$opt[$i]); 
					$form .= "
					<label class='radio radio-inline'>
					<input type='radio' name='{$field}' value ='".ltrim(rtrim($row[0]))."' {$mandatory} {$attribute}";
					$form .= "@if(\$row['".$field."'] == '".ltrim(rtrim($row[0]))."') checked=\"checked\" @endif";
					$form .= " > ".$row[1]." </label>";
				}
				break;
				
			case 'checkbox';
				if($required !='0') { $mandatory = 'requred'; }
				$opt = explode("|",$option['lookup_query']);
				$form = "<?php \$".$field." = explode(\",\",\$row['".$field."']); ?>";
				for($i=0; $i<count($opt);$i++) 
				{
					
					$checked = '';
					$row =  explode(":",$opt[$i]);					
					 $form .= "
					 <label class='checked checkbox-inline'>   
					<input type='checkbox' name='{$field}[]' value ='".ltrim(rtrim($row[0]))."' {$mandatory} {$attribute} class='{$extend_class}' ";
					$form .= "
					@if(in_array('".trim($row[0])."',\$".$field."))checked @endif 
					";
					$form .= " /> ".$row[1]." </label> ";					
				}
				break;				
			
		}
		
		return $form;		
	}
	
	public static function toView( $grids )
	{
		$f = '';
		foreach($grids as $grid)
		{
			if(isset($grid['conn']) && is_array($grid['conn']))
			{
				$conn = $grid['conn'];
				//print_r($conn);exit;
			} else {
				$conn = array('valid'=>0,'db'=>'','key'=>'','display'=>'');
			}
			
			if($grid['detail'] =='1')  
			{
				if($grid['attribute']['image']['active'] =='1')
				{	
					$val = "{{ SiteHelpers::showUploadedFile(\$row->".$grid['field'].",'".$grid['attribute']['image']['path']."') }}";	
				} elseif($conn['valid'] ==1)  {
					$arr = implode(':',$conn);
					//$arg = "'".$arr['valid'].":".$arr['db'].":".$arr['key'].":".$arr['display']."'";
					$val = "{{ SiteHelpers::gridDisplayView(\$row->".$grid['field'].",'".$grid['field']."','".$arr."') }}";
				} else {
					$val = "{{ \$row->".$grid['field']." }}"; 
				}
				$f .= "
					<tr>
						<td width='30%' class='label-view text-right'>".$grid['label']."</td>
						<td>".$val." </td>
						
					</tr>
				";
			}
		}
		return $f;
	}

	public static function arraySearch($s){
		$output = array();
		if($s != ""){
			$arr_first = explode("|", $s);
			foreach($arr_first as $item){
				$arr = explode(":", $item);
				$output["$arr[0]"] = $arr[1];
			}
		}
		return $output;
	}

	public static function transNameOfId($model, $id, $key, $value){
		$data = DB::table($model)->where("$key",'=', $id)->get();
		return count($data) >= 1 ? $data[0]->$value : '';
	}

	public static function transSelect($field,$data){
		switch($field['type'])
		{
			default;
				$form ='';
				break;
			
			case 'text';			
				$form = htmlspecialchars($data->$field['name']);
				break;
			case 'date';			
				$form = date('Y-m-d',$data->$field['name']);
				break;
			case 'datatime';
				$time = strtotime($data->$field['name']);
				$form = date('Y-m-d',$time);
				break;
			case 'radio';
				$key =  $field['option'];
				$form =$key[$data->$field['name']];
				break;
			case 'select';
				$item = $data->$field['id'];
				$id = $field['id'];
				$datas = DB::table($field['model'])->where("$id",'=', $item)->first();
				$form =$datas != "" ? $datas->$field['show'] : "NULL";
				break;
			case 'select_nola';
				$item = $data->$field['id'];
				$id = $field['id'];
				$datas = DB::table($field['model'])->where("$id",'=', $item)->first();
				$form =$datas != "" ? $datas->$field['show'] : "NULL";
				break;
		}
		return $form;
	}

	public static function transFormsearch($field){
		$lang = Session::get('lang') == '' ? CNF_LANG : Session::get('lang');
		switch($field['type'])
		{
			default;
				$form ='';
				break;
			
			case 'text';			
				$form = "<input  type='text' name='".$field['name']."' class='form-control input-sm'  value='".$field['value']."'/>";
				break;

			case 'text_date';
				$form = "<input  type='text' name='".$field['name']."' class='date form-control input-sm'  value='".$field['value']."'/> ";
				break;

			case 'text_datetime';
				$form = "<input  type='text' name='".$field['name']."'  class='date form-control input-sm'   value='".$field['value']."'/> ";
				break;				

			case 'select';
				$value = $field['value'];
				$data = DB::table($field['model'])->where("lang","=",$lang)->get();
				$opts = '';
				foreach($data as $row):
					$selected = '';
					if($value == $row->$field['id']) $selected ='selected="selected"';

					$opts .= "<option $selected value='".$row->$field['id']."'  > ".$row->$field['show']." </option> ";
					endforeach;
				$form = "<select name='".$field['name']."'  class='form-control'  >
							<option value=''> -- Select  -- </option>
							$opts
						</select>";
				break;
			case 'select_nola';
				$value = $field['value'];
				$data = DB::table($field['model'])->get();
				$opts = '';
				foreach($data as $row):
					$selected = '';
					if($value == $row->$field['id']) $selected ='selected="selected"';

					$opts .= "<option $selected value='".$row->$field['id']."'  > ".$row->$field['show']." </option> ";
					endforeach;
				$form = "<select name='".$field['name']."'  class='form-control'  >
							<option value=''> -- Select  -- </option>
							$opts
						</select>";
				break;

			case 'radio';
				$value = $field['value'];
				$opt = $field['option'];
				$opts = '';
				foreach($opt as $key=>$val){
					$selected = '';
					if($value == $key && $value != '') {$selected ='selected="selected"';}
					$opts .= "<option $selected  value='".$key."'  > ".$val." </option> ";
				}
				$form = "<select name='".$field['name']."' class='form-control' ><option value=''> -- Select  -- </option>$opts</select>";
				break;												
			
		}
		
		return $form;	
	}
	
	public static  function transForm( $field, $forms = array(),$bulk=false , $value ='')
	{
		$type = ''; 
		$bulk = ($bulk == true ? '[]' : '');
		$mandatory = '';
		foreach($forms as $f)
		{
			if($f['field'] == $field && $f['search'] ==1)
			{
				$type = ($f['type'] !='file' ? $f['type'] : ''); 
				$option = $f['option'];
				$required = $f['required'];
				
				if($required =='required') {
					$mandatory = "data-parsley-required='true'";
				} else if($required =='email') {
					$mandatory = "data-parsley-type'='email' ";
				} else if($required =='date') {
					$mandatory = "data-parsley-required='true'";
				} else if($required =='numeric') {
					$mandatory = "data-parsley-type='number' ";
				} else {
					$mandatory = '';
				}				
			}	
		}
		
		switch($type)
		{
			default;
				$form ='';
				break;
			
			case 'text';			
				$form = "<input  type='text' name='".$field."{$bulk}' class='form-control input-sm' $mandatory value='{$value}'/>";
				break;

			case 'text_date';
				$form = "<input  type='text' name='$field{$bulk}' class='date form-control input-sm' $mandatory value='{$value}'/> ";
				break;

			case 'text_datetime';
				$form = "<input  type='text' name='$field{$bulk}'  class='date form-control input-sm'  $mandatory value='{$value}'/> ";
				break;				

			case 'select';
				
			
				if($option['opt_type'] =='external')
				{
					
					$data = DB::table($option['lookup_table'])->get();
					$opts = '';
					foreach($data as $row):
						$selected = '';
						if($value == $row->$option['lookup_key']) $selected ='selected="selected"';
						$fields = explode("|",$option['lookup_value']);
						//print_r($fields);exit;
						$val = "";
						foreach($fields as $item=>$v)
						{
							if($v !="") $val .= $row->$v." " ;
						}
						$opts .= "<option $selected value='".$row->$option['lookup_key']."' $mandatory > ".$val." </option> ";
					endforeach;
						
				} else {
					$opt = explode("|",$option['lookup_query']);
					$opts = '';
					for($i=0; $i<count($opt);$i++) 
					{
						$selected = ''; 
						if($value == ltrim(rtrim($opt[0]))) $selected ='selected="selected"';
						$row =  explode(":",$opt[$i]); 
						$opts .= "<option $selected value ='".ltrim(rtrim($opt[0]))."' > ".$opt[1]." </option> ";
					}				
					
				}
				$form = "<select name='$field{$bulk}'  class='form-control' $mandatory >
							<option value=''> -- Select  -- </option>
							$opts
						</select>";
				break;	

			case 'radio';
			
				$opt = explode("|",$option['lookup_query']);
				$opts = '';
				for($i=0; $i<count($opt);$i++) 
				{
					$checked = '';
					$row =  explode(":",$opt[$i]);
					$opts .= "<option value ='".$row[0]."' > ".$row[1]." </option> ";
				}
				$form = "<select name='$field{$bulk}' class='form-control' $mandatory ><option value=''> -- Select  -- </option>$opts</select>";
				break;												
			
		}
		
		return $form;	
	}
	
	public static function viewColSpan( $grid )
	{
		$i =0;
		foreach ($grid as $t):
			if($t['view'] =='1') ++$i;
		endforeach;
		return $i;	
	}
	
	public static function blend($str,$data) {
		$src = $rep = array();
		
		foreach($data as $k=>$v){
			$src[] = "{".$k."}";
			$rep[] = $v;
		}
		
		if(is_array($str)){
			foreach($str as $st ){
				$res[] = trim(str_ireplace($src,$rep,$st));
			}
		} else {
			$res = str_ireplace($src,$rep,$str);
		}
		
		return $res;
		
	}			
		
	public static function toJavascript( $forms , $app , $class )
	{
		$f = '';
		foreach($forms as $form){
			if($form['view'] != 0)
			{			
				if(preg_match('/(select)/',$form['type'])) 
				{
					if($form['option']['opt_type'] == 'external') 
					{
						$table 	=  $form['option']['lookup_table'] ;
						$val 	=  $form['option']['lookup_value'];
						$key 	=  $form['option']['lookup_key'];
						$lookey = '';
						if($form['option']['is_dependency']) $lookey .= $form['option']['lookup_dependency_key'] ;
						$f .= self::createPreCombo( $form['field'] , $table , $key , $val ,$app, $class , $lookey  );
							
					}
									
				}
				
			}	
		
		}
		return $f;	
	
	}
	
	public static function createPreCombo( $field , $table , $key ,  $val ,$app ,$class ,$lookey = null)
	{


		
		$parent = null;
		$parent_field = null;
		if($lookey != null)  
		{	
			$parent = " parent: '#".$lookey."',";
			$parent_field =  ":{$lookey}:";
		}	
		$pre_jCombo = "
		\$(\"#{$field}\").jCombo(\"{{ URL::to('{$class}/comboselect?filter={$table}:{$key}:{$val}') }}$parent_field\",
		{ ".$parent." selected_value : '{{ \$row[\"{$field}\"] }}' });
		";	
		return $pre_jCombo;
	}	
	
	public static function alert( $task , $message)
	{
		if($task =='error') {
			$alert ='
			<div class="alert alert-danger  fade in block-inner">
				
			<i class="icon-cancel-circle"></i> '. $message.' </div>
			';			
		} elseif ($task =='success') {
			$alert ='
			<div class="noti-done" ><div class="container"><i class="fa fa-check"></i>'. $message.' </div></div>
			';			
		} elseif ($task =='warning') {
			$alert ='
			<div class="noti-info" ><div class="container"><i class="fa fa-check"></i>'. $message.' </div></div>
			';			
		} else {
			$alert ='
			<div class="alert alert-info  fade in block-inner">

			<i class="icon-info"></i> '. $message.' </div>
			';			
		}
		return $alert;
	
	} 		

	public static function _sort($a, $b) {
	 
		if ($a['sortlist'] == $a['sortlist']) {
		return strnatcmp($a['sortlist'], $b['sortlist']);
		}
		return strnatcmp($a['sortlist'], $b['sortlist']);
	}

	static function resizewidth($width, $imageold, $imagenew) {

      $image_info = getimagesize($imageold);
      $image_type = $image_info[2];
      if( $image_type == IMAGETYPE_JPEG ) {
 
         $image = imagecreatefromjpeg($imageold);
      } elseif( $image_type == IMAGETYPE_GIF ) {
 
         $image = imagecreatefromgif($imageold);
      } elseif( $image_type == IMAGETYPE_PNG ) {
 
         $image = imagecreatefrompng($imageold);
      }

      $ratio = imagesy($image) / imagesx($image);
      $height = $width * $ratio;

      //$width = imagesx($image) * $width/100;
     // $height = imagesx($image) * $width/100;

      $new_image = imagecreatetruecolor($width, $height);
      imagecopyresampled($new_image, $image, 0, 0, 0, 0, $width, $height, $image_info[0], $image_info[1]);
      $image = $new_image;

      $compression=75; 
      $permissions=null;

      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($image,$imagenew,$compression);
      } elseif( $image_type == IMAGETYPE_GIF ) {
 
         imagegif($image,$imagenew);
      } elseif( $image_type == IMAGETYPE_PNG ) {
 
         imagepng($image,$imagenew);
      }
      if( $permissions != null) {
 
         chmod($imagenew,$permissions);
      }
      
   }

	
	static public function cropImage($nw, $nh, $source, $stype, $dest) 
	{
		$size = getimagesize($source); // ukuran gambar
		$w = $size[0];
		$h = $size[1];
		switch($stype) 
		{ // format gambar
			case 'gif':
				$simg = imagecreatefromgif($source);
				break;
			case 'jpg':
				$simg = imagecreatefromjpeg($source);
				break;
			case 'jpeg':
				$simg = imagecreatefromjpeg($source);
				break;
			case 'png':
				$simg = imagecreatefrompng($source);
				break;
		}
		$dimg = imagecreatetruecolor($nw, $nh); // menciptakan image baru
		$wm = $w/$nw;
		$hm = $h/$nh;
		$h_height = $nh/2;
		$w_height = $nw/2;
		if($w> $h) 
		{
			$adjusted_width = $w / $hm;
			$half_width = $adjusted_width / 2;
			$int_width = $half_width - $w_height;
			imagecopyresampled($dimg,$simg,-$int_width,0,0,0,$adjusted_width,$nh,$w,$h);
		}
		elseif(($w <$h) || ($w == $h)) 
		{
			$adjusted_height = $h / $wm;
			$half_height = $adjusted_height / 2;
			$int_height = $half_height - $h_height;
			imagecopyresampled($dimg,$simg,0,-$int_height,0,0,$nw,$adjusted_height,$w,$h);
		}
		else
		{
			imagecopyresampled($dimg,$simg,0,0,0,0,$nw,$nh,$w,$h);
		}
		imagejpeg($dimg,$dest,100);
	}	
		
	
	public static function showUploadedFile($file,$path , $width = 50) {
	
		$files =  public_path().str_replace('.','',$path). $file ;		
		if(file_exists('./'.$files ) && $file !="") {
		//	echo $files ;
			$info = pathinfo($files);	
			if($info['extension'] == "jpg" || $info['extension'] == "jpeg" ||  $info['extension'] == "png" || $info['extension'] == "gif") 
			{
				$path_file = str_replace("./","",$path);
				return '<p><a href="'.URL::to(''). $path_file . $file.'" target="_blank" class="previewImage">
				<img src="'.URL::to(''). $path_file . $file.'" border="0" width="'. $width .'" class="img-circle" /></a></p>';
			} else {
				$path_file = str_replace("./","",$path);
				return '<p> <a href="'.URL::to($path_file . $file).'" target="_blank"> '.$file.' </a>';
			}
	
		} else {
			$info = pathinfo($files);
			if(isset($info['extension']))
			{
				if($info['extension'] == "jpg" || $info['extension'] == "jpeg" ||  $info['extension'] == "png" 
				|| $info['extension'] == "gif") 
				{
					$path_file = str_replace("./","",$path);
					return "<img src='".URL::to('')."/uploads/images/no-image.png' border='0' width='".$width."' class='img-circle' /></a>";
				} 	
			} else {
				
			}	
		}

	}	

	public static function globalXssClean()
	{
	    // Recursive cleaning for array [] inputs, not just strings.
	    $sanitized = static::arrayStripTags(Input::get());
	    Input::merge($sanitized);
	}
	 
	public static function arrayStripTags($array)
	{
	    $result = array();
	 
	    foreach ($array as $key => $value) {
	        // Don't allow tags on key either, maybe useful for dynamic forms.
	        $key = strip_tags($key);
	 
	        // If the value is an array, we will just recurse back into the
	        // function to keep stripping the tags out of the array,
	        // otherwise we will set the stripped value.
	        if (is_array($value)) {
	            $result[$key] = static::arrayStripTags($value);
	        } else {
	            // I am using strip_tags(), you may use htmlentities(),
	            // also I am doing trim() here, you may remove it, if you wish.
	            $result[$key] = trim(strip_tags($value));
	        }
	    }
	 
	    return $result;
	}
	
	public static function writeEncoder($val) {
		return base64_encode($val);
	}
	
	public static function readEncoder($val) {
		return base64_decode($val);
	}
	
	public static function gridDisplay($val , $field, $arr) {
		if(isset($arr['valid']) && $arr['valid'] ==1)
		{
			$fields = str_replace("|",",",$arr['display']);
			$Q = DB::select(" SELECT ".$fields." FROM ".$arr['db']." WHERE ".$arr['key']." = '".$val."' ");
			if(count($Q) >= 1 )
			{
				$row = $Q[0];
				$fields = explode("|",$arr['display']);
				$v= '';
				$v .= (isset($fields[0]) && $fields[0] !='' ?  $row->$fields[0].' ' : '');
				$v .= (isset($fields[1]) && $fields[1] !=''  ? $row-> $fields[1].' ' : '');
				$v .= (isset($fields[2]) && $fields[2] !=''  ? $row->$fields[2].' ' : '');
				
				
				return $v;
			} else {
				return '';
			}
		} else {
			return $val;
		}	
	}
	public static function gridDisplayView($val , $field, $arr) {
		$arr = explode(':',$arr);
		
		if(isset($arr['0']) && $arr['0'] ==1)
		{
			$Q = DB::select(" SELECT ".str_replace("|",",",$arr['3'])." FROM ".$arr['1']." WHERE ".$arr['2']." = '".$val."' ");
			if(count($Q) >= 1 )
			{
				$row = $Q[0];
				$fields = explode("|",$arr['3']);
				$v= '';
				$v .= (isset($fields[0]) && $fields[0] !='' ?  $row->$fields[0].' ' : '');
				$v .= (isset($fields[1]) && $fields[1] !=''  ? $row-> $fields[1].' ' : '');
				$v .= (isset($fields[2]) && $fields[2] !=''  ? $row->$fields[2].' ' : '');
				return $v;
			} else {
				return '';
			}
		} else {
			return $val;
		}	
	}	
	
	public static function langOption()
	{
		$lang = scandir(app_path().'/lang/');
		$t = array();
		foreach($lang as $value) {
			if($value === '.' || $value === '..') {continue;} 
				if(is_dir(app_path().'/lang/' . $value))
				{
					$fp = file_get_contents(app_path().'/lang/'.$value.'/info.json');
					$fp = json_decode($fp,true);
					$t[] =  $fp ;
				}	
			
		}	
		return $t;
	}

	public static function langShow(){
		$lang = Session::get('lang') == '' ? CNF_LANG : Session::get('lang');
		$fp = file_get_contents(app_path().'/lang/'.$lang.'/info.json');
		$fp = json_decode($fp,true);
		return $fp['name'];
	}
	
	
	public static function themeOption()
	{
		$lang = scandir(app_path().'/views/layouts/');
		$t = array();
		foreach($lang as $value) {
			if($value === '.' || $value === '..') {continue;} 
				if(is_dir(app_path().'/views/layouts/' . $value))
				{
					$fp = file_get_contents(app_path().'/views/layouts/'.$value.'/info.json');
					$fp = json_decode($fp,true);
					$t[] =  $fp ;
				}	
			
		}	
		return $t;
	}
		
	public static function avatar( $width =75)
	{
		$avatar = '<img alt="" src="http://www.gravatar.com/avatar/'.md5(Session::get('email')).'" class="img-circle" width="'.$width.'" />';
		$Q = DB::table("tb_users")->where("id",'=',Session::get('uid'))->get();
		$row = $Q[0];
		$files =  './uploads/users/'.$row->avatar ;
		if($row->avatar !='' ) 	
		{
			if( file_exists($files))
			{
				return  '<img src="'.URL::to('uploads/users').'/'.$row->avatar.'" border="0" width="'.$width.'" class="img-circle" />';
			} else {
				return $avatar;
			}	
		} else {
			return $avatar;
		}
	}

	
	public static function BBCode2Html($text) {
	
		$emotion =  URL::to('sximo/js/plugins/markitup/images/emoticons/');
		
		$text = trim($text);
	
		// BBCode [code]
		if (!function_exists('escape')) {
			function escape($s) {
				global $text;
				$text = strip_tags($text);
				$code = $s[1];
				$code = htmlspecialchars($code);
				$code = str_replace("[", "&#91;", $code);
				$code = str_replace("]", "&#93;", $code);
				return '<pre class="prettyprint linenums"><code>'.$code.'</code></pre>';
			}	
		}
		$text = preg_replace_callback('/\[code\](.*?)\[\/code\]/ms', "escape", $text);
	
		// Smileys to find...
		$in = array( 	 ':)', 	
						 ':D',
						 ':o',
						 ':p',
						 ':(',
						 ';)'
		);
		// And replace them by...
		$out = array(	 '<img alt=":)" src="'.$emotion.'emoticon-happy.png" />',
						 '<img alt=":D" src="'.$emotion.'emoticon-smile.png" />',
						 '<img alt=":o" src="'.$emotion.'emoticon-surprised.png" />',
						 '<img alt=":p" src="'.$emotion.'emoticon-tongue.png" />',
						 '<img alt=":(" src="'.$emotion.'emoticon-unhappy.png" />',
						 '<img alt=";)" src="'.$emotion.'emoticon-wink.png" />'
		);
		$text = str_replace($in, $out, $text);
		
		// BBCode to find...
		$in = array( 	 '/\[b\](.*?)\[\/b\]/ms',	
						 '/\[div\="?(.*?)"?](.*?)\[\/div\]/ms',
						 '/\[i\](.*?)\[\/i\]/ms',
						 '/\[u\](.*?)\[\/u\]/ms',
						 '/\[img\](.*?)\[\/img\]/ms',
						 '/\[email\](.*?)\[\/email\]/ms',
						 '/\[url\="?(.*?)"?\](.*?)\[\/url\]/ms',
						 '/\[size\="?(.*?)"?\](.*?)\[\/size\]/ms',
						 '/\[color\="?(.*?)"?\](.*?)\[\/color\]/ms',
						 '/\[quote](.*?)\[\/quote\]/ms',
						 '/\[list\=(.*?)\](.*?)\[\/list\]/ms',
						 '/\[list\](.*?)\[\/list\]/ms',
						 '/\[\*\]\s?(.*?)\n/ms'
		);
		// And replace them by...
		$out = array(	 '<strong>\1</strong>',
						 '<div class="\1">\2</div>',
						 '<em>\1</em>',
						 '<u>\1</u>',
						 '<img src="\1" alt="\1" />',
						 '<a href="mailto:\1">\1</a>',
						 '<a href="\1">\2</a>',
						 '<span style="font-size:\1%">\2</span>',
						 '<span style="color:\1">\2</span>',
						 '<blockquote>\1</blockquote>',
						 '<ol start="\1">\2</ol>',
						 '<ul>\1</ul>',
						 '<li>\1</li>'
		);
		$text = preg_replace($in, $out, $text);
			
		// paragraphs
		$text = str_replace("\r", "", $text);
		$text = "<p>".preg_replace("/(\n){2,}/", "</p><p>", $text)."</p>";
		$text = nl2br($text);
		
		// clean some tags to remain strict
		// not very elegant, but it works. No time to do better ;)
		if (!function_exists('removeBr')) {
			function removeBr($s) {
				return str_replace("<br />", "", $s[0]);
			}
		}	
		$text = preg_replace_callback('/<pre>(.*?)<\/pre>/ms', "removeBr", $text);
		$text = preg_replace('/<p><pre>(.*?)<\/pre><\/p>/ms', "<pre>\\1</pre>", $text);
		
		$text = preg_replace_callback('/<ul>(.*?)<\/ul>/ms', "removeBr", $text);
		$text = preg_replace('/<p><ul>(.*?)<\/ul><\/p>/ms', "<ul>\\1</ul>", $text);
		
		return $text;
	}	

	public static function removesign($str)
    {
        $coDau=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă","ằ","ắ"
        ,"ặ","ẳ","ẵ","è","é","ẹ","ẻ","ẽ","ê","ề","ế","ệ","ể","ễ","ì","í","ị","ỉ","ĩ",
            "ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ"
        ,"ờ","ớ","ợ","ở","ỡ",
            "ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
            "ỳ","ý","ỵ","ỷ","ỹ",
            "đ",
            "À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă"
        ,"Ằ","Ắ","Ặ","Ẳ","Ẵ",
            "È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
            "Ì","Í","Ị","Ỉ","Ĩ",
            "Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ"
        ,"Ờ","Ớ","Ợ","Ở","Ỡ",
            "Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
            "Ỳ","Ý","Ỵ","Ỷ","Ỹ",
            "Đ","ê","ù","à");
        $khongDau=array("a","a","a","a","a","a","a","a","a","a","a"
        ,"a","a","a","a","a","a",
            "e","e","e","e","e","e","e","e","e","e","e",
            "i","i","i","i","i",
            "o","o","o","o","o","o","o","o","o","o","o","o"
        ,"o","o","o","o","o",
            "u","u","u","u","u","u","u","u","u","u","u",
            "y","y","y","y","y",
            "d",
            "A","A","A","A","A","A","A","A","A","A","A","A"
        ,"A","A","A","A","A",
            "E","E","E","E","E","E","E","E","E","E","E",
            "I","I","I","I","I",
            "O","O","O","O","O","O","O","O","O","O","O","O"
        ,"O","O","O","O","O",
            "U","U","U","U","U","U","U","U","U","U","U",
            "Y","Y","Y","Y","Y",
            "D","e","u","a");
        return str_replace($coDau,$khongDau,$str);
    }
	
	public static function seoUrl($str, $separator = 'dash', $lowercase = FALSE)
	{
		$coDau=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă","ằ","ắ"
        ,"ặ","ẳ","ẵ","è","é","ẹ","ẻ","ẽ","ê","ề","ế","ệ","ể","ễ","ì","í","ị","ỉ","ĩ",
            "ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ"
        ,"ờ","ớ","ợ","ở","ỡ",
            "ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
            "ỳ","ý","ỵ","ỷ","ỹ",
            "đ",
            "À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă"
        ,"Ằ","Ắ","Ặ","Ẳ","Ẵ",
            "È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
            "Ì","Í","Ị","Ỉ","Ĩ",
            "Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ"
        ,"Ờ","Ớ","Ợ","Ở","Ỡ",
            "Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
            "Ỳ","Ý","Ỵ","Ỷ","Ỹ",
            "Đ","ê","ù","à");
        $khongDau=array("a","a","a","a","a","a","a","a","a","a","a"
        ,"a","a","a","a","a","a",
            "e","e","e","e","e","e","e","e","e","e","e",
            "i","i","i","i","i",
            "o","o","o","o","o","o","o","o","o","o","o","o"
        ,"o","o","o","o","o",
            "u","u","u","u","u","u","u","u","u","u","u",
            "y","y","y","y","y",
            "d",
            "A","A","A","A","A","A","A","A","A","A","A","A"
        ,"A","A","A","A","A",
            "E","E","E","E","E","E","E","E","E","E","E",
            "I","I","I","I","I",
            "O","O","O","O","O","O","O","O","O","O","O","O"
        ,"O","O","O","O","O",
            "U","U","U","U","U","U","U","U","U","U","U",
            "Y","Y","Y","Y","Y",
            "D","e","u","a");
        $str = str_replace($coDau,$khongDau,$str);
		if ($separator == 'dash')
		{
			$search		= '_';
			$replace	= '-';
		}
		else
		{
			$search		= '-';
			$replace	= '_';
		}
	
		$trans = array(
					'&\#\d+?;'				=> '',
					'&\S+?;'				=> '',
					'\s+'					=> $replace,
					'[^a-z0-9\-\._]'		=> '',
					$replace.'+'			=> $replace,
					$replace.'$'			=> $replace,
					'^'.$replace			=> $replace,
					'\.+$'					=> ''
			  );
	
		$str = strip_tags($str);
	
		foreach ($trans as $key => $val)
		{
			$str = preg_replace("#".$key."#i", $val, $str);
		}
	
		if ($lowercase === TRUE)
		{
			$str = strtolower($str);
		}
		
		return trim(stripslashes(strtolower($str)));
	}	
	
	
	static function renderHtml( $html )
	{
	
		$html = preg_replace( '/(\.+\/)+uploads/Usi' , URL::to('uploads') ,  $html );
	//	$content = str_replace($pattern , URL::to('').'/', $content );
        preg_match_all ( "#<([a-z]+)( .*)?(?!/)>#iU", $html, $result );
        $openedtags = $result[1];
        #put all closed tags into an array
        preg_match_all ( "#</([a-z]+)>#iU", $html, $result );
        $closedtags = $result[1];
        $len_opened = count ( $openedtags );
        # all tags are closed
        if( count ( $closedtags ) == $len_opened )
        {
       	 return $html;
        }
        $openedtags = array_reverse ( $openedtags );
        # close tags
        for( $i = 0; $i < $len_opened; $i++ )
        {
            if ( !in_array ( $openedtags[$i], $closedtags ) )
            {
            $html .= "</" . $openedtags[$i] . ">";
            }
            else
            {
            unset ( $closedtags[array_search ( $openedtags[$i], $closedtags)] );
            }
        }
        return $html;
	
  
	
	} 
	
	static public function initTinyMce()
	{
	
	}

	static public function initMarkitUp()
	{
		$html =  HTML::style('sximo/js/plugins/markitup/skins/simple/style.css');
		$html .=  HTML::style('sximo/js/plugins/markitup/sets/default/style.css');
		$html .=  HTML::script('sximo/js/plugins/markitup/jquery.markitup.js');
		$html .=  HTML::script('sximo/js/plugins/markitup/sets/default/set.js');
		return $html;
		
	}
	
	 	 		
			
}
