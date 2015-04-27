@if(isset($menu) && $menu == "index")
{{--*/ $news = SiteHelpers::getMenuNews(); /*--}}
@if($news != '')
<div id="news">
            <div class="block">
            <div class="top container move">
                <img src="images/home-icon4.png">
                <h2>some news from us</h2>
            </div>
            <div class="news-content container move">
            	<?php
            		$i = 1;
            		foreach($news as $item){
            			if($i == 1){
            	?>
							<div class="featured-news">
			                    <div class="item">
			                        <div class="image"><a href="{{URL::to('')}}/tin-tuc/{{$item->news_alias}}-{{$item->news_id}}.html" title="{{$item->news_name}}"><img alt="{{$item->news_name}}" src="{{URL::to('')}}/uploads/news/thumb/{{$item->news_picture}}"></a></div>
			                        <div class="meta"><span class="date">{{date('d/m/Y',$item->created)}}</span><span class="comment">50 Comment (s) </span></div>
			                        <h3 class="title"><a href="#">{{$item->news_name}}</a></h3>
			                        <p class="content">{{$item->news_description}}</p>
			                    </div><!--item-->
			                </div>
            	<?php
            			}else{
            				if($i == 2){
            					echo '<div class="latest-news">';
            				}
            	?>
								<div class="item">
			                        <div class="meta"><span class="date">{{$item->news_name}}</span><span class="comment">50 Comment (s) </span></div>
			                        <div class="image"><a href="{{URL::to('')}}/tin-tuc/{{$item->news_alias}}-{{$item->news_id}}.html" title="{{$item->news_name}}"><img alt="{{$item->news_name}}" src="{{URL::to('')}}/uploads/news/thumb/small_{{$item->news_picture}}"></a></div>
			                        <h3 class="title"><a href="{{URL::to('')}}/tin-tuc/{{$item->news_alias}}-{{$item->news_id}}.html" title="{{$item->news_name}}">{{$item->news_name}}</a></h3>
			                        <p class="content">{{$item->news_description}}</p>
			                    </div>
            	<?php
            			}
            			$i++;
            		}
            	?>
            	</div>
            </div><!--news-content-->
            </div>
        </div><!--news-->
@endif
@endif