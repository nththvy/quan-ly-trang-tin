<!-- Main Sidebar Start -->
<div class="main--sidebar col-md-4 col-sm-5 ptop--30 pbottom--30" data-sticky-content="true">
    <div class="sticky-content-inner">
        <!-- Widget Start -->
        <div class="widget">
            <div class="widget--title">
                <h2 class="h4">Tin tức nổi bật</h2>
                <i class="icon fa fa-newspaper-o"></i>
            </div>

            <!-- List Widgets Start -->
            <div class="list--widget list--widget-1">
                <!-- Post Items Start -->
                <div class="post--items post--items-3" data-ajax-content="outer">
                    <ul class="nav" data-ajax-content="inner">

                        @foreach($articles as $article)
                        <li>
                            <!-- Post Item Start -->
                            <div class="post--item post--layout-3">
                                <div class="post--img">
                                    <a href=""
                                        class="thumb"><img width="120"
                                            src="{{ $article->image ? env('APP_URL') . '/storage/app/' . $article->image : asset('storage/placeholders/user_placeholder.jpg') }}"
                                            alt=""></a>

                                    <div class="post--info">
                                        <ul class="nav meta">
                                            <li><a href="javascript:;">{{ $article->created_at->locale('vi')->diffForHumans() }}</a></li>
                                            <li><a href="javascript:;"><i class="fa fm fa-comments"></i>0</a></li>
                                            <li><span><i class="fa fm fa-eye"></i>{{ $article->views }}</span></li>
                                        </ul>

                                        <div class="title">
                                            <h3 class="h4">
                                                <a href="" class="btn-link">{{ $article->title }}</a>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Post Item End -->
                        </li>
                        @endforeach

                    </ul>


                </div>
                <!-- Post Items End -->
            </div>
            <!-- List Widgets End -->
        </div>
        <!-- Widget End -->

        <!-- Bắt đầu Từ khóa -->
        <div class="widget">
            <div class="widget--title  " data-ajax="tab">
                <h2 class="h4">Từ khóa</h2>
            </div>
            <div class="list--widget list--widget-1" data-ajax-content="outer">
                <!-- Post Items Start -->
                <div class="post--items post--items-3">
                    <ul style="padding:20px" class="nav sidebar" data-ajax-content="inner">
                        <div class="side">
                            <!-- <h3 class="sidbar-heading">Từ khóa</h3> -->
                            <div class="block-26">
                                <ul>
                                    @foreach($tags as $tag)
                                    <li><a href="{{ route('frontend.tags.show', ['slug' => $tag->slug]) }}">{{ $tag->name}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Kết thúc từ khóa -->

        <!-- Widget Start -->
        <div class="widget">
            <!-- Ad Widget Start -->
            <div class="ad--widget--banner">
                <div class="row">
                    <div class="col-sm-12">
                        <a
                            href="https://mwc.com.vn/products/giay-sandal-nu-mwc-nusd--2887?c=N%C3%82U">
                            <img src="{{ asset('public/kcnew/frontend/img/ads-img/banner_quangcao1.png') }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
            <!-- Ad Widget End -->
        </div>
        <!-- Widget End -->

        <!-- Widget Start -->
        <div class="widget">
            <div class="widget--title">
                <h2 class="h4">Kết nối với chúng tôi</h2>
                <i class="icon fa fa-share-alt"></i>
            </div>

            <!-- Social Widget Start -->
            <div class="social--widget style--2">
                <ul class="nav row gutter--20">
                    <li class="col-md-12 facebook">
                        <a href="https://www.facebook.com/people/Anh-Tuan/100007007238964">
                            <span class="icon">
                                <i class="fa fa-facebook"></i>
                                <span>Share</span>
                            </span>

                            <span class="text">
                                <span>Facebook</span>
                                <span>3.12 k</span>
                            </span>
                        </a>
                    </li>

                    <li class="col-md-12 twitter">
                        <a href="https://www.facebook.com/people/Anh-Tuan/100007007238964">
                            <span class="icon">
                                <i class="fa fa-twitter"></i>
                                <span>Tweet</span>
                            </span>

                            <span class="text">
                                <span>Twitter</span>
                                <span>869</span>
                            </span>
                        </a>
                    </li>

                    <li class="col-md-12 google-plus">
                        <a href="https://www.facebook.com/people/Anh-Tuan/100007007238964">
                            <span class="icon">
                                <i class="fa fa-google-plus"></i>
                                <span>Share</span>
                            </span>

                            <span class="text">
                                <span>Google+</span>
                                <span>639</span>
                            </span>
                        </a>
                    </li>


                </ul>
            </div>
            <!-- Social Widget End -->
        </div>
        <!-- Widget End -->

        <!-- Widget Start -->
        
        <!-- Widget End -->

        <!-- Widget Start -->
        <div class="widget">
            <div class="widget--title">
                <h2 class="h4">Quảng cáo</h2>
                <i class="icon fa fa-bullhorn"></i>
            </div>

            <!-- Ad Widget Start -->
            <div class="ad--widget--banner">
                <a href="https://mwc.com.vn/products/giay-sandal-nu-mwc-nusd--2887?c=N%C3%82U">
                    <img src="{{ asset('public/kcnew/frontend/img/ads-img/banner_quangcao.png') }}" alt="">
                </a>
            </div>
            <!-- Ad Widget End -->
        </div>
        <!-- Widget End -->
    </div>
</div>
<!-- Main Sidebar End -->