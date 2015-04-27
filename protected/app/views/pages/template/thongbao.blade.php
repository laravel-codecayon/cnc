<div class="container">
			<div class="notice">
				  @if(Session::has('message'))
				       {{ Session::get('message') }}
				  @endif
			</div>
		</div>