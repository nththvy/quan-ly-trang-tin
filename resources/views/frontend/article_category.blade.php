@extends('layouts.frontend')

@section('title', $category->name . ' - Viettel')

@section('content')

<!-- Main Breadcrumb Start -->
<div class="main--breadcrumb">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ route('frontend.home') }}" class="btn-link"><i class="fa fm fa-home"></i>Trang Chủ</a></li>
            <li class="active"><span>{{ $category->name }}</span></li>
        </ul>
    </div>
</div>
<!-- Main Breadcrumb End -->

<div class="main-content--section pbottom--30">
    <div class="container">
        <div class="row">
            <div class="main--content col-md-8" data-sticky-content="true">
                <div class="sticky-content-inner">
                    <div class="post--item post--single post--title-largest pd--30-0">

                        @forelse($articles as $article)
                        <div class="block-21 d-flex animate-box post">
                            <a href="{{ route('frontend.article.show', ['category_slug' => $article->category->slug, 'article_slug' => $article->title_slug]) }}" class="blog-img"
                                style="background-image: url({{ $article->image ? env('APP_URL') . '/storage/app/' . $article->image : asset('storage/placeholders/user_placeholder.jpg') }});">
                            </a>
                            <div class="text">
                                <h3 class="heading">
                                    <a href="{{ route('frontend.article.show', ['category_slug' => $article->category->slug, 'article_slug' => $article->title_slug]) }}">{{ $article->title }}</a>
                                </h3>
                                <p class="excerpt">{{ $article->summary }}</p>
                                <div class="meta">
                                    <div>
                                        <a class="date" href="#">
                                            <span class="icon-calendar"></span>{{ $article->created_at->locale('vi')->diffForHumans() }}
                                        </a>
                                    </div>
                                    <div>
                                        <a href="#"><span class="icon-user2"></span>{{ $article->writer->name }}</a>
                                    </div>
                                    <div class="comments-count">
                                        <a href="{{ route('frontend.article.show', ['category_slug' => $article->category->slug, 'article_slug' => $article->title_slug]) }}#post-comments">
                                            <span class="icon-chat"></span> {{ count($article->comments) }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p class="lead">Không có bài viết nào trong danh mục này.</p>
                        @endforelse

                        {{-- Phân trang --}}
                        {{ $articles->links() }}

                    </div>
                </div>
            </div>

            <!-- SIDEBAR: start -->
            <!-- Main Sidebar Start -->
            <div class="main--sidebar col-md-4 ptop--30 pbottom--30" data-sticky-content="true">
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

                                    @foreach($articles_hot as $article)
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

@endsection