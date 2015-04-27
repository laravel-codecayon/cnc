<section class="row_section" style='  '><div class="container"><div class="row"><div class="col-lg-9 col-md-9 col-sm-12 col-xs-12"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><section class="clearfix">       

    	<section class="breadcrumbs clearfix">
	        <a href="{{URL::to('')}}" title="Trang chủ"><i class="fa fa-home"></i></a>
	            	&nbsp;&nbsp;/&nbsp;&nbsp;<a href="{{URL::to('')}}/tin-tuc.html">Tin tức</a>
	            	            					</section>

</section></div></div><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
   <section class="clearfix">

				<section id="acc">
							@foreach($data as $item)
                            <article class="itemblog">
                                <div class="row">
                                    <div class="img-blog col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <a href="{{URL::to('')}}/tin-tuc/{{$item->news_alias}}-{{$item->news_id}}.html" title="{{$item->news_name}}">
                                                <img src="{{URL::to('')}}/uploads/news/thumb/{{$item->news_picture}}" alt="{{$item->news_name}}">
                                        </a>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                        <a href="{{URL::to('')}}/tin-tuc/{{$item->news_alias}}-{{$item->news_id}}.html" title="{{$item->news_name}}">
                                            <h2>{{$item->news_name}}</h2>
                                        </a>
                                        <div class="date">
                                            <i class="fa fa-calendar"></i>&nbsp;&nbsp; {{date('d/m/Y',$item->created)}}                                       </div>
                                        <p>
                                        {{$item->news_name}}</p>
                                    </div>
                                </div>
                            </article>
							@endforeach

							{{ $pagination->appends(array("page"=>$page))->links('pagination_site') }}
				</section>
				<!--End listitem-->
</section>