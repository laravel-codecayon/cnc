
<div class="container">
            <div id="wrap-content">
                <div class="box thread-box guest">
                    <div class="box-heading"><span>Danh sách tin đã đăng</span></div>
                    <ul>
                    @foreach($data as $item)
                        {{ SiteHelpers::templatePost($item) }}
                    @endforeach
                    </ul>
                </div><!-- guest-list -->
                <div class="pages">
                    {{ $pagination->appends(array("page"=>$page))->links('pagination_site') }}
                </div><!-- pages -->
            </div><!-- wrap-content -->
            

        </div><!-- container -->



