@extends('layouts.frontend')
@section('style')
<style>
    .post-title-truncate {
        display: block;
        overflow: hidden;
        max-height: 3em;
        /* 2 dòng nếu line-height là 1.5em */
        line-height: 1em;
    }
</style>
@endsection
@section('content')
<div class="wrapper">
    <!-- Main Content Section Start -->
    <div class="main-content--section pbottom--30">
        <div class="container">
            <!-- Main Content Start -->
            <div class="main--content">
                <!-- Post Items Start -->
                <div class="post--items post--items-1 pd--30-0">
                    <div class="row gutter--15">
                        <div class="col-md-6">
                            <div class="row gutter--15">
                                @if(count($new_articles_3))
                                @foreach ($new_articles_3 as $article)
                                <div class="col-xs-6 col-xss-12">
                                    <!-- Post Item Start -->
                                    <div class="post--item post--layout-1 post--title-large">
                                        <div class="post--img">
                                            <a href="{{ route('frontend.article.show', ['category_slug' => $article->category->slug, 'article_slug' => $article->title_slug]) }}" class="thumb">
                                                <img src="{{ $article->image ? asset('storage/app/' . $article->image) : asset('storage/placeholders/user_placeholder.jpg') }}" alt="">
                                            </a>
                                            <a href="" class="cat">{{ $article->category->name }}</a>
                                            <a href="javascript:;" class="icon"><i class="fa fa-flash"></i></a>

                                            <div class="post--info">
                                                <ul class="nav meta">
                                                    <li><a href="javascript:;">{{ $article->writer->name }}</a></li>
                                                    <li><a href="javascript:;">{{ $article->updated_at->locale('vi')->diffForHumans() }}</a></li>
                                                </ul>
                                                <div class="title">
                                                    <h2 class="h4">
                                                        <a href="{{ route('frontend.article.show', ['category_slug' => $article->category->slug, 'article_slug' => $article->title_slug]) }}" class="btn-link post-title-truncate">
                                                            {{ $article->title }}
                                                        </a>
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Post Item End -->
                                </div>
                                @endforeach
                                @else
                                <div class="col-xs-12">
                                    <div class="alert alert-warning text-center">
                                        Không có bài viết nào trong chuyên mục này.
                                    </div>
                                </div>
                                @endif
                                @if(count($new_articles_1))
                                @foreach ($new_articles_1 as $article)
                                <div class="col-xs-6 col-xss-12">
                                    <!-- Post Item Start -->
                                    <div class="post--item post--layout-1 post--title-large">
                                        <div class="post--img">
                                            <a href="{{ route('frontend.article.show', ['category_slug' => $article->category->slug, 'article_slug' => $article->title_slug]) }}" class="thumb">
                                                <img src="{{ $article->image ? asset('storage/app/' . $article->image) : asset('storage/placeholders/user_placeholder.jpg') }}" alt="">
                                            </a>
                                            <a href="" class="cat">{{ $article->category->name }}</a>
                                            <a href="javascript:;" class="icon"><i class="fa fa-flash"></i></a>

                                            <div class="post--info">
                                                <ul class="nav meta">
                                                    <li><a href="javascript:;">{{ $article->writer->name }}</a></li>
                                                    <li><a href="javascript:;">{{ $article->updated_at->locale('vi')->diffForHumans() }}</a></li>
                                                </ul>
                                                <div class="title">
                                                    <h2 class="h4">
                                                        <a href="{{ route('frontend.article.show', ['category_slug' => $article->category->slug, 'article_slug' => $article->title_slug]) }}" class="btn-link post-title-truncate">
                                                            {{ $article->title }}
                                                        </a>
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Post Item End -->
                                </div>
                                @endforeach
                                @else
                                <div class="col-xs-12">
                                    <div class="alert alert-warning text-center">
                                        Không có bài viết nào trong chuyên mục này.
                                    </div>
                                </div>
                                @endif
                            </div> <!-- .row gutter--15 end -->
                        </div> <!-- .col-md-6 end -->

                        <div class="col-md-6">
                            <!-- Post Item Start -->
                            <div class="post--item post--layout-1 post--title-larger">
                                @if ($new_articles_2)
                                <div class="post--img">
                                    <a href="{{ route('frontend.article.show', ['category_slug' => $new_articles_2->category->slug, 'article_slug' => $new_articles_2->title_slug]) }}"
                                        class="thumb"><img src="{{ $new_articles_2->image ? asset('storage/app/' . $new_articles_2->image) : asset('storage/placeholders/user_placeholder.jpg') }}" alt=""></a>

                                    <a href="" class="cat">{{ $new_articles_2->category->name }}</a>

                                    <a href="javascript:;" class="icon"><i class="fa fa-flash"></i></a>

                                    <div class="post--info">
                                        <ul class="nav meta">
                                            <li><a href="javascript:;">{{ $new_articles_2->writer->name }}</a></li>
                                            <li><a href="javascript:;">{{ $new_articles_2->updated_at->locale('vi')->diffForHumans()  }}</a></li>
                                        </ul>

                                        <div class="title">
                                            <h2 class="h4"><a
                                                    href="{{ route('frontend.article.show', ['category_slug' => $new_articles_2->category->slug, 'article_slug' => $new_articles_2->title_slug]) }}"
                                                    class="btn-link">{{ $new_articles_2->title }}</a>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="col-sm-12">
                                    <div class="alert alert-warning text-center">
                                        Không có bài viết nào trong chuyên mục này.
                                    </div>
                                </div>
                                @endif
                            </div>
                            <!-- Post Item End -->
                        </div>
                    </div> <!-- .row gutter--15 end -->
                </div> <!-- .post--items end -->
                <!-- Main Content End -->
            </div> <!-- .main--content end -->

            <div class="row">
                <!-- Main Content Start -->
                <div class="main--content col-md-8 col-sm-7" data-sticky-content="true">
                    <div class="sticky-content-inner">
                        <div class="row">
                            <!--Danh mục 1-->
                            <div class="col-md-6 ptop--30 pbottom--30">
                                <!-- Post Items Title Start -->
                                <div class="post--items-title" data-ajax="tab">

                                    <h2 class="h4">{{$category_1->name}}</h2>

                                </div>
                                <!-- Post Items Title End -->
                                <!-- Post Items Start -->
                                <div class="post--items post--items-3" data-ajax-content="outer">
                                    <ul class="nav" data-ajax-content="inner">

                                        @if($articles_category_1->isNotEmpty())
                                        @php $firstArticle = $articles_category_1->first(); @endphp
                                        <li>
                                            <!-- Post Item Start -->
                                            <div class="post--item post--layout-1">
                                                <div class="post--img">
                                                    <a href="{{ route('frontend.article.show', ['category_slug' => $firstArticle->category->slug, 'article_slug' => $firstArticle->title_slug]) }}" class="thumb">
                                                        <img src="{{ $firstArticle->image ? asset('storage/app/' . $firstArticle->image) : asset('storage/placeholders/user_placeholder.jpg') }}" alt="">
                                                    </a>
                                                    <a href="javascript:;" class="icon"><i class="fa fa-flash"></i></a>

                                                    <div class="post--info">
                                                        <ul class="nav meta">
                                                            <li><a href="javascript:;">{{ $firstArticle->writer->name ?? 'Tác giả' }}</a></li>
                                                            <li><a href="javascript:;">{{ $firstArticle->updated_at->locale('vi')->diffForHumans() }}</a></li>
                                                        </ul>

                                                        <div class="title">
                                                            <h3 class="h4">
                                                                <a href="{{ route('frontend.article.show', ['category_slug' => $firstArticle->category->slug, 'article_slug' => $firstArticle->title_slug]) }}" class="btn-link">
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
                                        @foreach($articles_category_1->skip(1) as $article)
                                        <li>
                                            <!-- Post Item Start -->
                                            <div class="post--item post--layout-3">
                                                <div class="post--img">
                                                    <a href="{{ route('frontend.article.show', ['category_slug' => $article->category->slug, 'article_slug' => $article->title_slug]) }}" class="thumb">
                                                        <img src="{{ $article->image ? asset('storage/app/' . $article->image) : asset('storage/placeholders/user_placeholder.jpg') }}" alt="">
                                                    </a>
                                                    <div class="post--info">
                                                        <ul class="nav meta">
                                                            <li><a href="javascript:;">{{ $article->writer->name ?? 'Tác giả' }}</a></li>
                                                            <li><a href="javascript:;">{{ $article->updated_at->locale('vi')->diffForHumans() }}</a></li>
                                                        </ul>

                                                        <div class="title">
                                                            <h3 class="h4">
                                                                <a href="{{ route('frontend.article.show', ['category_slug' => $article->category->slug, 'article_slug' => $article->title_slug]) }}" class="btn-link">{{ $article->title }}</a>
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

                            <!--Danh mục 2-->
                            <div class="col-md-6 ptop--30 pbottom--30">
                                <!-- Post Items Title Start -->
                                <div class="post--items-title" data-ajax="tab">

                                    <h2 class="h4">{{$category_2->name}}</h2>

                                </div>
                                <!-- Post Items Title End -->
                                <!-- Post Items Start -->
                                <div class="post--items post--items-3" data-ajax-content="outer">
                                    <ul class="nav" data-ajax-content="inner">

                                        @if($articles_category_2->isNotEmpty())
                                        @php $firstArticle = $articles_category_2->first(); @endphp
                                        <li>
                                            <!-- Post Item Start -->
                                            <div class="post--item post--layout-1">
                                                <div class="post--img">
                                                    <a href="{{ route('frontend.article.show', ['category_slug' => $firstArticle->category->slug, 'article_slug' => $firstArticle->title_slug]) }}" class="thumb">
                                                        <img src="{{ $firstArticle->image ? asset('storage/app/' . $firstArticle->image) : asset('storage/placeholders/user_placeholder.jpg') }}" alt="">
                                                    </a>
                                                    <a href="javascript:;" class="icon"><i class="fa fa-flash"></i></a>

                                                    <div class="post--info">
                                                        <ul class="nav meta">
                                                            <li><a href="javascript:;">{{ $firstArticle->writer->name ?? 'Tác giả' }}</a></li>
                                                            <li><a href="javascript:;">{{ $firstArticle->updated_at->locale('vi')->diffForHumans() }}</a></li>
                                                        </ul>

                                                        <div class="title">
                                                            <h3 class="h4">
                                                                <a href="{{ route('frontend.article.show', ['category_slug' => $firstArticle->category->slug, 'article_slug' => $firstArticle->title_slug]) }}" class="btn-link">
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
                                        @foreach($articles_category_2->skip(1) as $article)
                                        <li>
                                            <!-- Post Item Start -->
                                            <div class="post--item post--layout-3">
                                                <div class="post--img">
                                                    <a href="{{ route('frontend.article.show', ['category_slug' => $article->category->slug, 'article_slug' => $article->title_slug]) }}" class="thumb">
                                                        <img src="{{ $article->image ? asset('storage/app/' . $article->image) : asset('storage/placeholders/user_placeholder.jpg') }}" alt="">
                                                    </a>

                                                    <div class="post--info">
                                                        <ul class="nav meta">
                                                            <li><a href="javascript:;">{{ $article->writer->name ?? 'Tác giả' }}</a></li>
                                                            <li><a href="javascript:;">{{ $article->updated_at->locale('vi')->diffForHumans() }}</a></li>
                                                        </ul>

                                                        <div class="title">
                                                            <h3 class="h4">
                                                                <a href="{{ route('frontend.article.show', ['category_slug' => $article->category->slug, 'article_slug' => $article->title_slug]) }}" class="btn-link">{{ $article->title }}</a>
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

                            <!-- Danh mục 3 -->
                            <div class="col-md-12 ptop--30 pbottom--30">
                                <!-- Title -->
                                <div class="post--items-title" data-ajax="tab">
                                    <h2 class="h4">{{ $category_3->name }}</h2>
                                </div>

                                <!-- Post Items Start -->
                                <div class="post--items post--items-2" data-ajax-content="outer">
                                    <ul class="nav row" data-ajax-content="inner">
                                        @if($articles_category_3->isNotEmpty())
                                        @php $firstArticle = $articles_category_3->first(); @endphp

                                        <!-- Left Column: Featured Post -->
                                        <li class="col-md-6">
                                            <div class="post--item post--layout-2">
                                                <div class="post--img">
                                                    <a href="{{ route('frontend.article.show', ['category_slug' => $firstArticle->category->slug, 'article_slug' => $firstArticle->title_slug]) }}" class="thumb">
                                                        <img src="{{ $firstArticle->image ? asset('storage/app/' . $firstArticle->image) : asset('storage/placeholders/user_placeholder.jpg') }}" alt="">
                                                    </a>
                                                    <a href="" class="cat">{{ $firstArticle->category->name }}</a>
                                                    <a href="javascript:;" class="icon"><i class="fa fa-star-o"></i></a>

                                                    <div class="post--info">
                                                        <ul class="nav meta">
                                                            <li><a href="javascript:;">{{ $firstArticle->writer->name ?? 'Tác giả' }}</a></li>
                                                            <li><a href="javascript:;">{{ $firstArticle->updated_at->locale('vi')->diffForHumans() }}</a></li>
                                                        </ul>
                                                        <div class="title">
                                                            <h3 class="h4">
                                                                <a href="{{ route('frontend.article.show', ['category_slug' => $firstArticle->category->slug, 'article_slug' => $firstArticle->title_slug]) }}" class="btn-link">
                                                                    {{ $firstArticle->title }}
                                                                </a>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr class="mar_bottom15">

                                            <ul class="list_news_show_home">
                                                @foreach($articles_category_3->skip(4)->take(3) as $article)
                                                <li class="boder_link_show_home">
                                                    <h3 class="h3">
                                                        <a href="{{ route('frontend.article.show', ['category_slug' => $article->category->slug, 'article_slug' => $article->title_slug]) }}">{{ $article->title }}</a>
                                                    </h3>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </li>

                                        <!-- Right Column: 4 posts -->
                                        <li class="col-md-6">
                                            <ul class="nav row">
                                                <li class="col-xs-12 hidden-md hidden-lg">
                                                    <hr class="divider">
                                                </li>

                                                @foreach($articles_category_3->skip(1)->take(4) as $index => $article)
                                                @if($index == 4)
                                                <li class="col-xs-12">
                                                    <hr class="divider">
                                                </li>
                                                @endif
                                                <li class="col-xs-6">
                                                    <div class="post--item post--layout-2">
                                                        <div class="post--img">
                                                            <a href="{{ route('frontend.article.show', ['category_slug' => $article->category->slug, 'article_slug' => $article->title_slug]) }}" class="thumb">
                                                                <img src="{{ $article->image ? asset('storage/app/' . $article->image) : asset('storage/placeholders/user_placeholder.jpg') }}" alt="">
                                                            </a>
                                                            <div class="post--info">
                                                                <ul class="nav meta">
                                                                    <li><a href="javascript:;">{{ $article->writer->name ?? 'Tác giả' }}</a></li>
                                                                    <li><a href="javascript:;">{{ $article->updated_at->locale('vi')->diffForHumans() }}</a></li>
                                                                </ul>
                                                                <div class="title">
                                                                    <h3 class="h4">
                                                                        <a href="{{ route('frontend.article.show', ['category_slug' => $article->category->slug, 'article_slug' => $article->title_slug]) }}" class="btn-link">
                                                                            {{ $article->title }}
                                                                        </a>
                                                                    </h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                        @else
                                        <li class="col-md-12">
                                            <p>Hiện tại không có bài viết nào.</p>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                                <!-- Post Items End -->
                            </div>
                            <!-- Danh mục 4 -->
                            <div class="col-md-6 ptop--30 pbottom--30">
                                <!-- Post Items Title Start -->
                                <div class="post--items-title" data-ajax="tab">
                                    <h2 class="h4">{{ $category_4->name }}</h2>
                                </div>
                                <!-- Post Items Title End -->

                                <!-- Post Items Start -->
                                <div class="post--items post--items-3" data-ajax-content="outer">
                                    <ul class="nav" data-ajax-content="inner">
                                        @if($articles_category_4->isNotEmpty())
                                        @php
                                        $firstArticle = $articles_category_4->first();
                                        @endphp

                                        <!-- Featured Post -->
                                        <li>
                                            <div class="post--item post--layout-1">
                                                <div class="post--img">
                                                    <a href="" class="thumb">
                                                        <img src="{{ $firstArticle->image ? asset('storage/app/' . $firstArticle->image) : asset('storage/placeholders/user_placeholder.jpg') }}" alt="">
                                                    </a>
                                                    <a href="" class="cat">{{ $firstArticle->category->name }}</a>
                                                    <a href="" class="icon"><i class="fa fa-eye"></i></a>

                                                    <div class="post--info">
                                                        <ul class="nav meta">
                                                            <li><a href="javascript:;">{{ $firstArticle->writer->name }}</a></li>
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
                                        </li>
                                        @foreach($articles_category_4->skip(1)->take(4) as $article)
                                        <li>
                                            <div class="post--item post--layout-3">
                                                <div class="post--img">
                                                    <a href="{{ route('frontend.article.show', ['category_slug' => $article->category->slug, 'article_slug' => $article->title_slug]) }}" class="thumb">
                                                        <img src="{{ $article->image ? asset('storage/app/' . $article->image) : asset('storage/placeholders/user_placeholder.jpg') }}" alt="">
                                                    </a>

                                                    <div class="post--info">
                                                        <ul class="nav meta">
                                                            <li><a href="javascript:;">{{ $article->writer->name }}</a></li>
                                                            <li><a href="javascript:;">{{ $article->created_at->locale('vi')->diffForHumans() }}</a></li>
                                                        </ul>

                                                        <div class="title">
                                                            <h3 class="h4">
                                                                <a href="{{ route('frontend.article.show', ['category_slug' => $article->category->slug, 'article_slug' => $article->title_slug]) }}" class="btn-link">
                                                                    {{ $article->title }}
                                                                </a>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        @endforeach
                                        @endif
                                    </ul>
                                </div>
                                <!-- Post Items End -->
                            </div>
                            <!-- Sports End -->

                            <!-- Danh mục 5-->
                            <div class="col-md-6 ptop--30 pbottom--30">
                                <!-- Post Items Title Start -->
                                <div class="post--items-title" data-ajax="tab">

                                    <h2 class="h4">{{$category_5->name}}</h2>

                                </div>
                                <!-- Post Items Title End -->
                                <!-- Post Items Start -->
                                <div class="post--items post--items-3" data-ajax-content="outer">
                                    <ul class="nav" data-ajax-content="inner">

                                        @if($articles_category_5->isNotEmpty())
                                        @php $firstArticle = $articles_category_5->first(); @endphp
                                        <li>
                                            <!-- Post Item Start -->
                                            <div class="post--item post--layout-1">
                                                <div class="post--img">
                                                    <a href="{{ route('frontend.article.show', ['category_slug' => $firstArticle->category->slug, 'article_slug' => $firstArticle->title_slug]) }}" class="thumb">
                                                        <img src="{{ $firstArticle->image ? asset('storage/app/' . $firstArticle->image) : asset('storage/placeholders/user_placeholder.jpg') }}" alt="">
                                                    </a>
                                                    <a href="javascript:;" class="icon"><i class="fa fa-flash"></i></a>

                                                    <div class="post--info">
                                                        <ul class="nav meta">
                                                            <li><a href="javascript:;">{{ $firstArticle->writer->name ?? 'Tác giả' }}</a></li>
                                                            <li><a href="javascript:;">{{ $firstArticle->created_at->locale('vi')->diffForHumans() }}</a></li>
                                                        </ul>

                                                        <div class="title">
                                                            <h3 class="h4">
                                                                <a href="{{ route('frontend.article.show', ['category_slug' => $firstArticle->category->slug, 'article_slug' => $firstArticle->title_slug]) }}" class="btn-link">
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
                                        @foreach($articles_category_5->skip(1) as $article)
                                        <li>
                                            <!-- Post Item Start -->
                                            <div class="post--item post--layout-3">
                                                <div class="post--img">
                                                    <a href="{{ route('frontend.article.show', ['category_slug' => $article->category->slug, 'article_slug' => $article->title_slug]) }}" class="thumb">
                                                        <img src="{{ $article->image ? asset('storage/app/' . $article->image) : asset('storage/placeholders/user_placeholder.jpg') }}" alt="">
                                                    </a>

                                                    <div class="post--info">
                                                        <ul class="nav meta">
                                                            <li><a href="javascript:;">{{ $article->writer->name ?? 'Tác giả' }}</a></li>
                                                            <li><a href="javascript:;">{{ $article->created_at->locale('vi')->diffForHumans() }}</a></li>
                                                        </ul>

                                                        <div class="title">
                                                            <h3 class="h4">
                                                                <a href="{{ route('frontend.article.show', ['category_slug' => $article->category->slug, 'article_slug' => $article->title_slug]) }}" class="btn-link">{{ $article->title }}</a>
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
                            <!-- Section End -->
                        </div>
                    </div>
                </div>

                @include('frontend.slidebar')

            </div>
            <!-- Main Content Start -->
            <div class="main--content pd--30-0">
                <!-- Post Items Title Start -->
                <div class="post--items-title" data-ajax="tab">
                    <h2 class="h4">{{ $category_6->name }}</h2>
                </div>
                <!-- Post Items Title End -->

                <!-- Post Items Start -->
                <div class="post--items post--items-4" data-ajax-content="outer">
                    <ul class="nav row" data-ajax-content="inner">
                        <li class="col-md-8">
                            <!-- Post Item Start -->
                            @if($articles_category_6->isNotEmpty())
                            @php $firstArticle = $articles_category_6->first(); @endphp
                            <div class="post--item post--layout-1 post--type-video post--title-large">
                                <div class="post--img">
                                    <a href="{{ route('frontend.article.show', ['category_slug' => $firstArticle->category->slug, 'article_slug' => $firstArticle->title_slug]) }}" class="thumb">
                                        <img src="{{ $firstArticle->image ? asset('storage/app/' . $firstArticle->image) : asset('storage/placeholders/user_placeholder.jpg') }}" alt="">
                                        <a href="" class="cat"></a>
                                        <a href="" class="icon"><i class="fa fa-eye"></i></a>

                                        <div class="post--info">
                                            <ul class="nav meta">
                                                <li><a href="javascript:;">{{ $firstArticle->writer->name }}</a></li>
                                                <li><a href="javascript:;">{{ $firstArticle->created_at->locale('vi')->diffForHumans()  }}</a></li>
                                            </ul>

                                            <div class="title">
                                                <h2 class="h4"><a
                                                        href="{{ route('frontend.article.show', ['category_slug' => $firstArticle->category->slug, 'article_slug' => $firstArticle->title_slug]) }}"
                                                        class="btn-link">{{ $firstArticle->title }}</a></h2>
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <!-- Post Item End -->

                            <!-- Divider Start -->
                            <hr class="divider hidden-md hidden-lg">
                            <!-- Divider End -->
                        </li>
                        <li class="col-md-4">
                            <ul class="nav">

                                @foreach($articles_category_6->skip(1) as $article)
                                <li>
                                    <!-- Post Item Start -->
                                    <div class="post--item post--type-audio post--layout-3">
                                        <div class="post--img">
                                            <a href="{{ route('frontend.article.show', ['category_slug' => $article->category->slug, 'article_slug' => $article->title_slug]) }}"
                                                class="thumb">
                                                <img src="{{ $article->image ? asset('storage/app/' . $article->image) : asset('storage/placeholders/user_placeholder.jpg') }}" alt="">
                                            </a>

                                            <div class="post--info">
                                                <ul class="nav meta">
                                                    <li><a href="javascript:;">{{ $article->writer->name }}</a></li>
                                                    <li><a href="javascript:;">{{ $article->created_at->locale('vi')->diffForHumans()  }}</a></li>
                                                </ul>

                                                <div class="title">
                                                    <h3 class="h4"><a
                                                            href="{{ route('frontend.article.show', ['category_slug' => $article->category->slug, 'article_slug' => $article->title_slug]) }}"
                                                            class="btn-link">{{ $article->title }}</a></h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Post Item End -->
                                </li>
                                @endforeach
                                @endif
                            </ul>
                        </li>
                    </ul>


                </div>
                <!-- Post Items End -->
            </div>
            @include('frontend.home1')
            <!-- Main Content End -->
        </div> <!-- .container end -->
    </div> <!-- .main-content--section end -->
</div> <!-- .wrapper end -->

@endsection