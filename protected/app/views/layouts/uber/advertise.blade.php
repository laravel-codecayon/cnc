{{--*/ $advertise = SiteHelpers::getAdvertise(1) /*--}}
                @if(count($advertise) >0)
                <div class="box ads">
                    <div><a href="{{$advertise[0]->advertise_link}}"><img src="{{URL::to('')}}/uploads/advertise/thumb/{{$advertise[0]->image}}"></a></div>
                </div><!-- ads -->
                @endif