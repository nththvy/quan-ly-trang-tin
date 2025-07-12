<div class="row">
    <!-- Main Content Start -->
    <div class="main--content col-md-8 col-sm-7" data-sticky-content="true">
        <div class="sticky-content-inner">
            <div class="row">
                <!-- Danh mục 7-->
                <div class="col-md-6 ptop--30 pbottom--30">
                    <!-- Post Items Title Start -->
                    <div class="post--items-title" data-ajax="tab">

                        <h2 class="h4">{{$category_7->name}}</h2>

                    </div>
                    <!-- Post Items Title End -->
                    <!-- Post Items Start -->
                    <div class="post--items post--items-3" data-ajax-content="outer">
                        <ul class="nav" data-ajax-content="inner">

                            @if($articles_category_7->isNotEmpty())
                            @php $firstArticle = $articles_category_7->first(); @endphp
                            <li>
                                <!-- Post Item Start -->
                                <div class="post--item post--layout-1">
                                    <div class="post--img">
                                        <a href="" class="thumb">
                                            <img src="{{ $firstArticle->image ? env('APP_URL') . '/storage/app/' . $firstArticle->image : asset('storage/placeholders/user_placeholder.jpg') }}" alt="{{ $firstArticle->title }}">
                                        </a>
                                        <a href="javascript:;" class="icon"><i class="fa fa-flash"></i></a>

                                        <div class="post--info">
                                            <ul class="nav meta">
                                                <li><a href="javascript:;">{{ $firstArticle->writer->name ?? 'Tác giả' }}</a></li>
                                                <li><a href="javascript:;">{{ $firstArticle->created_at->locale('vi')->diffForHumans() }}</a></li>
                                            </ul>

                                            <div class="title">
                                                <h3 class="h4">
                                                    <a href="" class="btn-link">
                                                        {{ $firstArticle->title }}
                                                    </a>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Post Item End -->
                            </li>

                            <!-- Hiển thị các bài viết còn lại -->
                            @foreach($articles_category_7->skip(1) as $article)
                            <li>
                                <!-- Post Item Start -->
                                <div class="post--item post--layout-3">
                                    <div class="post--img">
                                        <a href="" class="thumb">
                                            <img src="{{ $article->image ? env('APP_URL') . '/storage/app/' . $article->image : asset('storage/placeholders/user_placeholder.jpg') }}" alt="{{ $article->title }}">
                                        </a>

                                        <div class="post--info">
                                            <ul class="nav meta">
                                                <li><a href="javascript:;">{{ $article->writer->name ?? 'Tác giả' }}</a></li>
                                                <li><a href="javascript:;">{{ $article->created_at->locale('vi')->diffForHumans() }}</a></li>
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
                            @else
                            <li>
                                <p>Hiện tại không có bài viết nào.</p>
                            </li>
                            @endif
                        </ul>
                    </div>

                    <!-- Post Items End -->
                </div>
                <!-- Health and fitness End -->

                <!-- Lifestyle Start -->
                <div class="col-md-6 ptop--30 pbottom--30">
                    <!-- Post Items Title Start -->
                    <div class="post--items-title" data-ajax="tab">
                        <h2 class="h4">{{ $category_8->name }}</h2>


                    </div>
                    <!-- Post Items Title End -->
                    @if($articles_category_8->isNotEmpty())
                    @php $firstArticle = $articles_category_8->first(); @endphp
                    <!-- Post Items Start -->
                    <div class="post--items post--items-2" data-ajax-content="outer">
                        <ul class="nav row gutter--15" data-ajax-content="inner">

                            <li class="col-xs-12">
                                <!-- Post Item Start -->
                                <div class="post--item post--layout-1">
                                    <div class="post--img">
                                        <a href=""
                                            class="thumb"><img
                                                src="{{ $firstArticle->image ? env('APP_URL') . '/storage/app/' . $firstArticle->image : asset('storage/placeholders/user_placeholder.jpg') }}" alt=""
                                                alt=""></a>
                                        <a href=""
                                            class="cat"></a>
                                        <a href="" class="icon"><i class="fa fa-heart-o"></i></a>

                                        <div class="post--info">
                                            <ul class="nav meta">
                                                <li><a href="javascript:;">{{ $firstArticle->writer->name }}</a></li>
                                                <li><a href="javascript:;">{{ $firstArticle->created_at->locale('vi')->diffForHumans()  }}</a></li>
                                            </ul>

                                            <div class="title">
                                                <h3 class="h4"><a
                                                        href=""
                                                        class="btn-link">{{ $firstArticle->title }}</a>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Post Item End -->

                            </li>
                            @foreach($articles_category_8->skip(1)->take(4) as $article)
                            @if ($loop->index === 0 || $loop->index === 2)
                            <li class="col-xs-12">
                                <!-- Divider Start -->
                                <hr class="divider">
                                <!-- Divider End -->
                            </li>
                            @endif

                            <li class="col-xs-6">
                                <!-- Post Item Start -->
                                <div class="post--item post--layout-2">
                                    <div class="post--img">
                                        <a href="" class="thumb">
                                            <img src="{{ $article->image ? env('APP_URL') . '/storage/app/' . $article->image : asset('storage/placeholders/user_placeholder.jpg') }}" alt="{{ $article->title }}">
                                        </a>

                                        <div class="post--info">
                                            <ul class="nav meta">
                                                <li><a href="javascript:;">{{ $article->writer->name ?? 'Tác giả' }}</a></li>
                                                <li><a href="javascript:;">{{ $article->created_at->locale('vi')->diffForHumans() }}</a></li>
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
                            @endif

                        </ul>

                    </div>
                    <!-- Post Items End -->
                </div>
                <!-- Lifestyle End -->



                <!-- Photo Gallery Start -->

                <!-- Photo Gallery End -->
            </div>
        </div>
    </div>
    <!-- Main Content End -->

    <!-- Main Sidebar Start -->
    <div class="main--sidebar col-md-4 col-sm-5 ptop--30 pbottom--30" data-sticky-content="true">
        <div class="sticky-content-inner">
            <!-- Widget Start -->
             
            <!-- Widget Start -->

            <!-- Widget End -->

            <!-- Widget Start -->

            <!-- Widget End -->

        </div>
    </div> <!-- Main Sidebar End -->
</div>