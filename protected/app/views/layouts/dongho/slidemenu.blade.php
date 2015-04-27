@if(isset($menu) && $menu == "index")
{{--*/ $slide = SiteHelpers::getSlide(); /*--}}

<div id="slider-text" class="home animated fadeIn">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
          <!-- Indicators -->
          <ol class="carousel-indicators">
          	<?php
			  	$i = 0;
              	foreach($slide as $sl){
					$class = $i == 0 ? 'class="active"' : '';
				?>
					<li data-target="#carousel-example-generic" data-slide-to="{{$i}}" {{$class}}></li>
                <?php
					$i++;
				}
			   ?>
          </ol>

          <!-- Wrapper for slides -->
          <div class="carousel-inner" role="listbox">
          	<?php
			  	$i = 0;
              	foreach($slide as $sl){
					$class = $i == 0 ? 'active' : '';
			?>
			<div class="item {{$class}}">
              {{$sl->content}}
              <a href="{{$sl->slideshow_link}}" class="more">{{ Lang::get('layout.see_more') }}</a>
            </div>
            <?php
            	$i++;}
            ?>
          </div>
          <!-- Controls -->
          <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">{{ Lang::get('layout.pre') }}</span>
          </a>
          <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">{{ Lang::get('layout.next') }}</span>
          </a>
        </div>    
    </div><!-- slider-text -->    

@endif