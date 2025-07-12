@extends('layouts.frontend')
@section('title', $title. ' - Viettel ')

@section('content')
<!-- Main Breadcrumb Start -->
<div class="main--breadcrumb">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ route('frontend.home') }}" class="btn-link"><i class="fa fm fa-home"></i>Trang chủ</a></li>
            <li class="active"><span>{{ $title }}</span></li>
        </ul>
    </div>
</div>
<!-- Main Breadcrumb End -->

<!-- Main Content Start -->
<div class="main-content--section pbottom--30">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="main--content col-md-12" data-sticky-content="true">
                <div class="sticky-content-inner">
                    <!-- Filter by Category -->
                    <form method="GET" action="{{ route('frontend.articles.latest') }}" class="mb-3">
                        <div class="form-group">
                            <label for="category_id">Lọc theo danh mục:</label>
                            <select name="category_id" id="category_id" class="form-control" onchange="this.form.submit()">
                                <option value="">Tất cả</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    <!-- Loop through articles -->
                    @foreach($articles as $article)
                    <div class="block-21 d-flex animate-box post">
                        <a href="{{ route('frontend.article.show', ['category_slug' => $article->category->slug, 'article_slug' => $article->title_slug]) }}"
                            class="blog-img"
                            style="background-image: url({{ $article->image ? env('APP_URL') . '/storage/app/' . $article->image : asset('storage/placeholders/user_placeholder.jpg') }});">
                        </a>
                        <div class="text">
                            <h3 class="heading">
                                <a href="{{ route('frontend.article.show', ['category_slug' => $article->category->slug, 'article_slug' => $article->title_slug]) }}">
                                    {{ $article->title }}
                                </a>
                            </h3>
                            <p class="excerpt">{{ $article->summary }}</p>
                            <div class="meta">
                                <div>
                                    <span class="icon-calendar"></span>
                                    {{ ucfirst($article->updated_at->locale('vi')->translatedFormat('l')) }}, {{ $article->updated_at->format('d/m/Y') }}
                                </div>
                                <div>
                                    <span class="icon-user2"></span> {{ $article->writer->name }}
                                </div>
                                <div class="comments-count">
                                    <a href="{{ route('frontend.article.show', ['category_slug' => $article->category->slug, 'article_slug' => $article->title_slug]) }}#post-comments">
                                        <span class="icon-chat"></span> {{ $article->comments_count }}
                                    </a>
                                </div>
                                <div>
                                    <span class="icon-eye"></span> {{ $article->views }} lượt xem
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
                <!-- Pagination -->
                {{ $articles->links() }}
            </div>
        </div>
    </div>
</div>
<!-- Main Content End -->
@endsection
