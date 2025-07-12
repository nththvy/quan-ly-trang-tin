@extends('layouts.frontend')

@section('title', $article->title. ' - Viettel ')

@section('custom_css')
<style>
    .post--body.post--content {
        color: black;
        font-family: "Source Sans Pro", sans-serif;
        font-size: 18px;
    }

    .text.capitalize {
        text-transform: capitalize !important;
    }

    .author-info,
    .post-time {
        margin: 0;
        font-size: 14px !important;
        text-align: right;
    }

    .post--content {
        text-align: justify;
        text-justify: inter-word;
    }

    .text-justify {
        text-align: justify;
        width: 100%;
    }

    .post--image {
        margin-top: 20px;
        width: 100%;
        height: auto;
    }

    .post--image img {
        width: 100%;
        /* Đảm bảo ảnh chiếm toàn bộ chiều rộng của phần chứa */
        height: auto;
        /* Chiều cao tự động để giữ tỷ lệ */
    }
</style>
</style>
</style>
@endsection

@section('content')

<div class="global-message info d-none"></div>

<!-- Main Breadcrumb Start -->
<div class="main--breadcrumb">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ route('frontend.home') }}" class="btn-link"><i class="fa fm fa-home"></i>Trang Chủ</a></li>
            <li><a href="" class="btn-link">{{ $article->category->name }}</a></li>
            <li class="active"><span>{{ $article->title }}</span></li>
        </ul>
    </div>
</div>
<!-- Main Breadcrumb End -->

<!-- Main Content Section Start -->
<div class="main-content--section pbottom--30">
    <div class="container">
        <div class="row">
            <!-- Main Content Start -->
            <div class="main--content col-md-8" data-sticky-content="true">
                <div class="sticky-content-inner">
                    <!-- Post Item Start -->
                    <div class="post--item post--single post--title-largest pd--30-0">
                        <div class="post--cats">
                            <ul class="nav">
                                <li><span><i class="fa fa-folder-open-o"></i></span></li>
                                @foreach($article->tags as $tag)
                                <li><a class="text capitalize" href="">{{ $tag->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="post--info">
                            <ul class="nav meta">
                                <li class="text capitalize"><a href="#">{{ $article->created_at->locale('vi')->translatedFormat('l'), }} {{ $article->created_at->locale('vi')->format('d/m/Y') }}<a></li>
                                <li><a href="#">{{ $article->writer->name }}</a></li>
                                <li><span><i class="fa fm fa-eye"></i>{{ $article->views }}</span></li>
                                <li><a href="#"><i class="fa fm fa-comments-o"></i>{{ $article->comments->count() }}</a></li>
                            </ul>

                            <div class="title">
                                <h2 class="post_title h4 text-justify">{{ $article->title }}</h2>
                            </div>
                        </div>
                        @if($article->image)
                        <div class="post--image text-center mb-3">
                            <img src="{{ $article->image ? env('APP_URL') . '/storage/app/' . $article->image : asset('storage/placeholders/user_placeholder.jpg') }}" alt="Ảnh bài viết" class="img-fluid" style="max-width: 100%; height: auto;">
                        </div>
                        @endif
                        <div class="post--body post--content">
                            {!! $article->summary !!}
                        </div>
                        <div class="post--body post--content">
                            {!! $article->content !!}
                        </div>
                    </div>
                    <!-- Post Item End -->

                    <!-- Advertisement Start -->
                    <div class="ad--space pd--20-0-40">
                        <p class="author-info">Người viết: {{ $article->writer->name }}</p>
                        <p class="post-time">Thời gian: {{ $article->created_at->locale('vi')->diffForHumans() }}</p>
                    </div>
                    <!-- Advertisement End -->

                    <!-- Post Tags Start -->
                    <div class="post--tags">
                        <ul class="nav">
                            <li><span><i class="fa fa-tags"></i> Từ khóa </span></li>
                            @for($i = 0; $i < count($article->tags) ; $i++)
                                <li><a class="text capitalize" href="">{{ $article->tags[$i]->name }}</a></li>
                                @endfor
                        </ul>
                    </div>
                    <!-- Post Tags End -->

                    <!-- Post Social Start -->
                    <div class="post--social pbottom--30">
                        <span class="title"><i class="fa fa-share-alt"></i> Chia sẻ </span>

                        <!-- Social Widget Start -->
                        <div class="social--widget style--4">
                            <ul class="nav">
                                <li><a href="javascript:"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="javascript:"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="javascript:"><i class="fa fa-google-plus"></i></a></li>
                                <li><a href="javascript:"><i class="fa fa-linkedin"></i></a></li>
                                <li><a href="javascript:"><i class="fa fa-rss"></i></a></li>
                                <li><a href="javascript:"><i class="fa fa-youtube-play"></i></a></li>
                            </ul>
                        </div>
                        <!-- Social Widget End -->
                    </div>
                    <!-- Post Social End -->

                    <!-- Comment List Start -->
                    <div class="comment--list pd--30-0">
                        <!-- Post Items Title Start -->
                        <div class="post--items-title">
                            <h2 class="h4">
                                <span class="post_count_comment h4">{{ $countComments }}</span> bình luận
                            </h2>
                            <i class="icon fa fa-comments-o"></i>
                        </div>
                        <!-- Post Items Title End -->

                        <ul class="comment--items nav">
                            @foreach($visibleComments as $comment)
                            <li>
                                <!-- Comment Item Start -->
                                <div class="comment--item clearfix">
                                    <div class="comment--img float--left" style="width: 54px; height: 54px; border-radius: 50%; overflow: hidden; border: 2px solid #fff;">
                                        <img
                                            src="{{ $comment->user->image ? env('APP_URL') . '/storage/app/' . $comment->user->image : asset('storage/placeholders/user_placeholder.jpg') }}"
                                            alt="{{ $comment->user->name }}"
                                            style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <div class="comment--info">
                                        <div class="comment--header clearfix">
                                            <p class="name">{{ $comment->user->name }}</p>
                                            <p class="date">{{ $comment->created_at->locale('vi')->diffForHumans() }}</p>
                                            <a href="javascript:;" class="reply"><i class="fa fa-flag"></i></a>
                                            @if(Auth::check() && Auth::id() === $comment->user_id)
                                            <form action="{{ route('frontend.comment.delete', $comment->id) }}" method="POST"
                                                style="display: inline-block;"
                                                onsubmit="return confirm('Bạn có chắc muốn xóa bình luận này?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="reply" title="Xóa" style="background: none; border: none; padding: 0 0 0 8px;">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                        <div class="comment--content">
                                            <p>{{ $comment->content }}</p>

                                            {{-- Hiển thị thông báo nếu là comment của user hiện tại và chưa được duyệt --}}
                                            @if($comment->status === 'pending' && Auth::check() && Auth::id() === $comment->user_id)
                                            <small class="text-warning"><i class="fa fa-clock-o"></i> Bình luận của bạn đang chờ duyệt</small>
                                            @endif

                                            <p class="star">
                                                <span class="text-left">
                                                    <a href="#" class="reply"><i class="icon-reply"></i></a>
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Comment Item End -->
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Comment List End -->

                    <!-- Comment Form Start -->
                    <div class="comment--form pd--30-0">
                        <!-- Post Items Title Start -->
                        <div class="post--items-title">
                            <h2 class="h4">Viết bình luận</h2>
                            <i class="icon fa fa-pencil-square-o"></i>
                        </div>
                        <!-- Post Items Title End -->

                        <div class="comment-respond">
                            <x-blog.message :status="'success'" />
                            @auth
                            <form method="POST" action="{{ route('frontend.comment.store', $article->id) }}" autocomplete="off">
                                @csrf

                                <div class="row form-group">
                                    <div class="col-md-12">
                                        <textarea name="content" id="message" cols="30" rows="5" class="form-control" placeholder="Đánh giá bài viết này">{{ old('the_comment') }}</textarea>
                                    </div>
                                </div>
                                <small style="color: red; font-size: 14px;" class="comment_error"> </small>
                                <div class="form-group">
                                    <input id="input_comment" type="submit" value="Bình luận" class="send-comment-btn btn btn-primary">
                                </div>
                            </form>
                            @endauth

                            @guest
                            <p class="h4">
                                <a href="{{ route('login') }}">Đăng nhập</a> hoặc
                                <a href="{{ route('register') }}">Đăng ký</a> để bình luận bài viết
                            </p>
                            @endguest
                        </div>
                    </div>
                    <!-- Comment Form End -->


                    <!-- Post Related Start -->
                    <div class="post--related ptop--30">
                        <!-- Post Items Title Start -->
                        <div class="post--items-title" data-ajax="tab">
                            <h2 class="h4">Có thể bạn cũng thích</h2>
                        </div>
                        <!-- Post Items Title End -->

                        <!-- Post Items Start -->
                        <div class="post--items post--items-2" data-ajax-content="outer">
                            <ul class="nav row" data-ajax-content="inner">
                                @foreach($relatedArticles as $relatedArticle)
                                <li class="col-sm-12 pbottom--30">
                                    <!-- Post Item Start -->
                                    <div class="post--item post--layout-3">
                                        <div class="post--img">
                                            <a href="{{ route('frontend.article.show', ['category_slug' => $relatedArticle->category->slug, 'article_slug' => $relatedArticle->title_slug]) }}"
                                                class="thumb">
                                                <img src="{{ $relatedArticle->image ? env('APP_URL') . '/storage/app/' . $relatedArticle->image : asset('storage/placeholders/user_placeholder.jpg') }}"
                                                    alt="">
                                            </a>

                                            <div class="post--info">

                                                <div class="title">
                                                    <h3 class="h4">
                                                        <a href="{{ route('frontend.article.show', ['category_slug' => $relatedArticle->category->slug, 'article_slug' => $relatedArticle->title_slug]) }}" class="btn-link">{{ $relatedArticle->title }}</a>
                                                    </h3>
                                                    <p style="font-size:16px">
                                                        <span>{{ $relatedArticle->summary }}</span>
                                                    </p>
                                                </div>

                                                <ul style="padding-top:10px" class="nav meta ">
                                                    <li><a href="javascript:;">{{ $relatedArticle->writer->name }}</a>
                                                    </li>
                                                    <li><a href="javascript:;">{{ $relatedArticle->created_at->locale('vi')->diffForHumans() }}</a></li>
                                                    <li><a href="javascript:;"><i class="fa fm fa-comments"></i>{{ count($relatedArticle->comments) }}</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Post Item End -->
                                </li>
                                @endforeach

                            </ul>

                            <!-- Preloader Start -->
                            <div class="preloader bg--color-0--b" data-preloader="1">
                                <div class="preloader--inner"></div>
                            </div>
                            <!-- Preloader End -->
                        </div>
                        <!-- Post Items End -->
                    </div>
                    <!-- Post Related End -->

                </div>
            </div>
            <!-- Main Content End -->

            <!-- Main Sidebar Start -->
            <div class="main--sidebar col-md-4 ptop--30 pbottom--30" data-sticky-content="true">
                <div class="sticky-content-inner">

                    <!-- Widget Start -->
                    <div class="widget">
                        <div class="widget--title">
                            <h2 class="h4">Tin tức mới nhất</h2>
                            <i class="icon fa fa-newspaper-o"></i>
                        </div>

                        <!-- List Widgets Start -->
                        <div class="list--widget list--widget-1">
                            <!-- Post Items Start -->
                            <div class="post--items post--items-3" data-ajax-content="outer">
                                <ul class="nav" data-ajax-content="inner">

                                    @foreach($articles_latest as $article)
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



                    <!-- Widget Start -->
                    <x-blog.side-ad_banner />
                    <!-- Widget End -->

                </div>
            </div>
            <!-- Main Sidebar End -->
        </div>
    </div>
</div>
<!-- Main Content Section End -->

@endsection

@section('custom_js')

<script>
    setTimeout(() => {
        $(".global-message").fadeOut();
    }, 5000)
</script>



@endsection