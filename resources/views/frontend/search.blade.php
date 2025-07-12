@extends('layouts.frontend')
@section('title', $title. ' - Viettel ')

@section('content')
<!-- Main Breadcrumb Start -->
<div class="main--breadcrumb">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ route('frontend.home') }}" class="btn-link"><i class="fa fm fa-home"></i>Home</a></li>
            <li class="active"><span>{{ $title }}</span></li>
        </ul>
    </div>
</div>
<!-- Main Breadcrumb End -->

<!-- Main Content Section Start -->
<div class="main-content--section pbottom--30">
    <div class="container">
        <div class="row">
            <!-- Main Content Start -->
            <div class="main--content col-md-12 col-sm-7" data-sticky-content="true">
                <div class="sticky-content-inner">
                    <div class="row">

                        <!-- Books and Magazine Start -->
                        <div class="col-md-12 ptop--30 pbottom--30">
                            <!-- Post Items Title Start -->
                            <div class="post--items-title" data-ajax="tab">
                                <h2 class="h4">{{ $articles->total() }} {{ $title }}: <span style="color: black;" class="h4">{{$keyword}}</span></h2>
                                <!-- Bộ lọc danh mục -->
                                <form method="GET" action="{{ route('frontend.search') }}" class="mb-3">
                                    <input type="hidden" name="keyword" value="{{ $keyword }}">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <label for="category_id">Lọc theo danh mục:</label>
                                            <select name="category_id" id="category_id" class="form-select" style="font-size: 1.5rem; padding: 5px;" onchange="this.form.submit()">
                                                <option value="">-- Tất cả danh mục --</option>
                                                @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- Post Items Title End -->

                            <!-- Post Items Start -->
                            <div class="post--items post--items-2" data-ajax-content="outer">
                                <ul class="nav" data-ajax-content="inner">

                                    @forelse($articles as $article) <li>
                                        <!-- Post Item Start -->
                                        <div class="post--item">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="post--img">
                                                        <a href="{{ route('frontend.article.show', ['category_slug' => $article->category->slug, 'article_slug' => $article->title_slug]) }}"
                                                            class="thumb"><img
                                                                src="{{ $article->image ? env('APP_URL') . '/storage/app/' . $article->image : asset('storage/placeholders/user_placeholder.jpg') }}"
                                                                alt=""></a>
                                                        <a href="{{ route('frontend.categories.show', ['slug' => $article->category->slug]) }}"
                                                            class="cat">{{ $article->category->name }}</a>

                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="post--info">
                                                        <ul class="nav meta">
                                                            <li><span>{{ $article->writer->name }}</a></li>
                                                            <li><span>{{ $article->updated_at->locale('vi')->diffForHumans() }}</span></li>
                                                            <li><a href="#"><i class="fa fm fa-eye"></i>{{ $article->views }}</span></li>
                                                            <li><a href=""><i class="fa fm fa-comments"></i>{{ $article->comments_count }}</a></li>
                                                        </ul>
                                                        <div class="title">
                                                            <h2 class="h3" style="color:black"><a
                                                                    href="{{ route('frontend.article.show', ['category_slug' => $article->category->slug, 'article_slug' => $article->title_slug]) }}"
                                                                    class="btn-link">{{ $article->title }}</a></h3>
                                                        </div>
                                                    </div>

                                                    <div class="post--content">
                                                        <p>{{ $article->summary }}</p>
                                                    </div>

                                                    <div class="post--action">
                                                        <a class="btn btn-link" href="">Đọc thêm</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Post Item End -->
                                    </li>

                                    <li>
                                        <!-- Divider Start -->
                                        <hr class="divider">
                                        <!-- Divider End -->
                                    </li>

                                    @empty
                                    <li>
                                        <p class="lead">Không tìm thấy bài viết phù hợp với từ khóa.</p>
                                    </li>
                                    @endforelse
                                </ul>
                                {{ $articles->links() }}

                            </div>
                            <!-- Post Items End -->

                        </div>
                        <!-- Books and Magazine End -->
                        <!-- Photo Gallery Start -->
                    </div>
                </div>
            </div>
            <!-- Main Content End -->

            <!-- Main Sidebar Start -->
            
        </div>
    </div>
</div>
<!-- Main Content Section End -->
@endsection