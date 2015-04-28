<div id="news-page" class="container block">
        <div class="top container move"><img src="{{ asset('sximo/themes/dongho/images/news-icon.png')}}"><h2>{{Lang::get('layout.some_good_news_from_here')}}</h2></div>
        <div class="row move">
            <div class="news-2column col-md-8">
                <div class="news-heading"><h3>{{Lang::get('layout.company_news')}}</h3></div>
                <div class="row">
                    {{$news1}}
                </div><!--row -->        
                
            </div><!-- news-2column -->
            
            <div class="news-1column col-md-4">
                <div class="news-heading"><h3>Recruitment</h3></div>
                <div class="wrapper">
                    {{$news2}}
                </div><!-- wrapper -->
            </div><!-- news-1column -->
            
            <div class="news-3column col-md-12">
                <div class="news-heading"><h3>Publication</h3></div>
                <div class="row">
                    {{$news3}}
                </div><!-- row -->
            </div><!-- news-3column -->
        </div><!-- row -->
    </div><!-- contact-page -->