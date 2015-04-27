@if(isset($menu) && $menu == "index")
{{--*/ $hot = SiteHelpers::getProductHot(); /*--}}
@if($hot != '')
<section class="row-section top-html " style='  '>
	<div class="container">
		<section class="clearfix" id="block-feature">
			<div class="line"> </div>
			<div class="row">
				@foreach($hot as $pro)
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
					<div class="feature">
					<div class="image"><a href="{{URL::to('')}}/chi-tiet/{{$pro->slug}}-{{$pro->ProductID}}.html" title="{{$pro->ProductName}}"><img alt="{{$pro->ProductName}}" class="trans-hover" src="{{URL::to('')}}/uploads/products/thumb/{{$pro->image2}}" title="{{$pro->ProductName}}" /> </a></div>

						<p>{{{$pro->ProductName}}} {{{$pro->ProductCode}}}</p>
					</div>
				</div>
				@endforeach

			</div>

			<div class="line"> </div>
		</section>
	</div>
</section>
@endif
@endif