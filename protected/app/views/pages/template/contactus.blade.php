<div id="contact-page">
        <div id="contact-us" class="block">
            <div class="top container move"><img src="{{ asset('sximo/themes/dongho/images/contact-icon.png')}}"><h2>{{Lang::get('layout.send_us_your_ideas')}}</h2></div>
            <div class="container content move">
                <div class="company-info">
                    <h3>{{Lang::get('layout.contact_info')}}</h3>
                    <ul>
                        <li><i class="fa fa-map-marker"></i><div><span>{{Lang::get('layout.address')}}</span><p>{{CNF_ADDRESS}}</p></div></li>
                        <li><i class="fa fa-phone"></i><div><span>{{Lang::get('layout.phone')}}</span><p>{{CNF_PHONE}}</p></div></li>
                        <li><i class="fa fa-clock-o"></i><div><span>{{Lang::get('layout.work_hour')}}</span><p>{{CNF_WORK}}</p></div></li>
                    </ul>
                </div><!-- company-info -->
                <div class="message">
                    <h3>{{Lang::get('layout.leave_message')}}</h3>
                    @if(Session::has('message_contact'))
                                 {{ Session::get('message_contact') }}
                            @endif
                            <ul class="parsley-error-list">
                              @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                              @endforeach
                            </ul>
                    <form method="post" action="{{URL::to('')}}/home/contactform">
                    <div class="left">
                        <input type="text" value="{{$input['name']}}" class="form-control" name="name" placeholder="{{Lang::get('layout.name')}}">
                        <input type="text" value="{{$input['email']}}" class="form-control" name="email" placeholder="{{Lang::get('layout.email')}}">
                        <input type="text" value="{{$input['website']}}" class="form-control" name="website" placeholder="Website">
                    </div>
                    <textarea class="form-control" name="comment" placeholder="{{Lang::get('layout.comment')}}">{{$input['comment']}}</textarea>
                    <button type="submit">{{Lang::get('layout.send_to_us')}}</button>
                    </form>
                </div><!-- message -->
            </div>
        </div><!-- block -->
        <div class="map clearfix"></div><!-- map -->
    </div><!-- contact-page -->