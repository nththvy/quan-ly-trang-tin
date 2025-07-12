@props(['outstanding_posts_hots', 'outstanding_posts_latest'])

<!-- Widget Start -->
<div class="widget">
    <div class="widget--title">
        <h2 class="h4">Tin tức nổi bật</h2>
        <i class="icon fa fa-newspaper-o"></i>
    </div>

    <!-- List Widgets Start -->
    <div class="list--widget list--widget-1">
        <div class="list--widget-nav" data-ajax="tab">
            <ul class="nav nav-justified">
                <li class="active">
                    <a class="outstandPosts" href="#" data-ajax-action="load_widget_hot_news">Tin nóng</a>
                </li>
                <li>
                    <a class="outstandPosts" href="#" data-ajax-action="load_widget_latest_news">Bài viết mới nhất</a>
                </li>
            </ul>
        </div>

        <!-- Post Items Start -->
        <div class="post--items post--items-3" data-ajax-content="outer">
            <ul class="nav listPost" data-ajax-content="inner">
                <!-- Hiển thị bài viết "Tin nóng" -->
                @foreach($outstanding_posts_hots as $outstanding_post)
                <li>
                    <div class="post--item post--layout-3">
                        <div class="post--img">
                            <a href="" class="thumb">
                                    <img src="{{ $outstanding_post->image ? asset('storage/app/' . $outstanding_post->image) : asset('storage/placeholders/placeholder-image.png') }}" alt="">
                            </a>
                            <div class="post--info">
                                <ul class="nav meta">
                                    <li><a href="javascript:;">{{ $outstanding_post->created_at->locale('vi')->diffForHumans() }}</a></li>
                                    <li><a href="javascript:;"><i class="fa fm fa-comments"></i>{{ count($outstanding_post->comments) }}</a></li>
                                    <li><span><i class="fa fm fa-eye"></i>{{ $outstanding_post->views }}</span></li>
                                </ul>

                                <div class="title">
                                    <h3 class="h4"><a href="" class="btn-link">
        {{ $outstanding_post->title }}</a></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>

            <!-- Hiển thị bài viết "Bài viết mới nhất" khi nhấn tab -->
            <ul class="nav listPost" data-ajax-content="inner">
                @foreach($outstanding_posts_latest as $outstanding_post)
                <li>
                    <div class="post--item post--layout-3">
                        <div class="post--img">
                            <a href="" class="thumb">
                                    <img src="{{ $outstanding_post->image ? asset('storage/app/' . $outstanding_post->image) : asset('storage/placeholders/placeholder-image.png') }}" alt="">
                            </a>
                            <div class="post--info">
                                <ul class="nav meta">
                                    <li><a href="javascript:;">{{ $outstanding_post->created_at->locale('vi')->diffForHumans() }}</a></li>
                                    <li><a href="javascript:;"><i class="fa fm fa-comments"></i>{{ count($outstanding_post->comments) }}</a></li>
                                    <li><span><i class="fa fm fa-eye"></i>{{ $outstanding_post->views }}</span></li>
                                </ul>

                                <div class="title">
                                    <h3 class="h4"><a href="" class="btn-link">{{ $outstanding_post->title }}</a></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        <!-- Post Items End -->
    </div>
    <!-- List Widgets End -->
</div>
<!-- Widget End -->


@section('custom_js')

<script>
    setTimeout(() => {
        $(".global-message").fadeOut();
    }, 5000)
</script>

<script>
    const outstandPosts = document.querySelectorAll('.outstandPosts');
    outstandPosts.forEach((item, index) => {
        $(item).click(function(e) {
            const ListPost = $('.listPost');
            const ListPost_item = $('.listPost li');
            ListPost_item.remove();

            if (index == 0) {
                // Hiển thị bài viết "Tin nóng"
                const htmls = `@foreach($outstanding_posts_hots as $outstanding_posts_hot)
                    <li>
                        <div class="post--item post--layout-3">
                            <div class="post--img">
                                <a href="" class="thumb">
                                    <img src="{{ $outstanding_post_hot->image ? asset('storage/app/' . $outstanding_post->image) : asset('storage/placeholders/placeholder-image.png') }}" alt="">
                                </a>
                                <div class="post--info">
                                    <ul class="nav meta">
                                        <li><a href="javascript:;">{{ $outstanding_posts_hot->created_at->locale('vi')->diffForHumans() }}</a></li>
                                        <li><a href="javascript:;"><i class="fa fm fa-comments"></i>{{ count($outstanding_posts_hot->comments) }}</a></li>
                                        <li><span><i class="fa fm fa-eye"></i>{{ $outstanding_posts_hot->views }}</span></li>
                                    </ul>
                                    <div class="title">
                                        <h3 class="h4"><a href="" class="btn-link">{{ $outstanding_posts_hot->title }}</a></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach`;
                ListPost.append(htmls);
            }

            if (index == 1) {
                // Hiển thị bài viết "Bài viết mới nhất"
                const htmls = `@foreach($outstanding_posts_latest as $outstanding_posts_latest_item)
                    <li>
                        <div class="post--item post--layout-3">
                            <div class="post--img">
                                <a href="" class="thumb">
                                    <img src="{{ $outstanding_post_latest->image ? asset('storage/app/' . $outstanding_post->image) : asset('storage/placeholders/placeholder-image.png') }}" alt="">
                                </a>
                                <div class="post--info">
                                    <ul class="nav meta">
                                        <li><a href="javascript:;">{{ $outstanding_posts_latest_item->created_at->locale('vi')->diffForHumans() }}</a></li>
                                        <li><a href="javascript:;"><i class="fa fm fa-comments"></i>{{ count($outstanding_posts_latest_item->comments) }}</a></li>
                                        <li><span><i class="fa fm fa-eye"></i>{{ $outstanding_posts_latest_item->views }}</span></li>
                                    </ul>
                                    <div class="title">
                                        <h3 class="h4"><a href="" class="btn-link">{{ $outstanding_posts_latest_item->title }}</a></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach`;
                ListPost.append(htmls);
            }
        });
    });
</script>


@endsection