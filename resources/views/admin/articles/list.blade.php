@extends("layouts.app")
@section('style')
<style>
    .text-truncate-cell {
        max-width: 390px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: inline-block;
        vertical-align: middle;
    }

    .text-truncate-cell:hover {
        cursor: pointer;
    }
</style>
@endsection
@section("wrapper")
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Bài viết</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href=""><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Tất cả bài viết</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                <div class="d-lg-flex align-items-center mb-4 gap-3">
                    <form method="GET" action="{{ route('admin.articles') }}" class="d-flex align-items-center gap-3 mb-3">

                        <div class="position-relative">
                            <input type="text" name="keyword" class="form-control ps-5 radius-30" placeholder="Tìm kiếm bài viết" value="{{ request('keyword') }}"> <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
                        </div>
                        <select name="status_id" class="form-select w-auto" onchange="this.form.submit()">
                            <option value="">-- Tất cả trạng thái --</option>
                            @foreach($statuses as $status)
                            <option value="{{ $status->id }}" {{ request('status_id') == $status->id ? 'selected' : '' }}>
                                {{ $status->status }}
                            </option>
                            @endforeach
                        </select>
                    </form>
                    <div class="ms-auto"><a href="{{ route('admin.articles.create') }}" class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Thêm bài viết mới</a></div>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">#</th>
                                <th width="6%">Ảnh đại diện</th>
                                <th width="20%">Tiêu đề bài viết</th>
                                <th width="20%">Mô tả</th>
                                <th width="15%">Danh mục</th>
                                <!--<th>Tags</th>-->
                                <th width="7%">Ngày tạo</th>
                                <th width="7%">Trạng thái</th>
                                <th width="5%">Lượt xem</th>
                                <th>Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($articles as $article)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                                        </div>
                                        <div class="ms-2">
                                            <h6 class="mb-0 font-14">{{ $loop->iteration }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <img class=" img-avatar img-thumbnail "
                                        width="50" height="50"
                                        style="margin: auto; background-size: cover;"
                                        src="{{ $article->image ? env('APP_URL') . '/storage/app/' . $article->image : asset('storage/placeholders/user_placeholder.jpg') }}?v={{ time() }}"
                                        alt="">
                                </td>
                                <td>
                                    <span class="text-truncate-cell" title="{{ $article->title }}">
                                        {{ $article->title }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-truncate-cell" title="{{ $article->summary }}">
                                        {{ $article->summary }}
                                    </span>
                                </td>
                                <td>{{ $article->category->name }}</td>
                                <!--<td>
                                    @foreach ($article->tags as $tag)
                                    <span class="badge bg-primary">{{ $tag->name }}</span>
                                    @endforeach
                                </td>-->
                                <td>{{ $article->created_at->format('d/m/Y') }}</td>
                                <!--accessor trong models/status-->
                                <td>
                                    <div class="badge rounded-pill {{ $article->status->badge_class }} p-2 text-uppercase px-3">
                                        <i class='bx bxs-circle me-1'></i>{{ $article->status->status }}
                                    </div>
                                </td>
                                </td>
                                <td>{{ $article->views }}</td>

                                <td>
                                    <div class="d-flex order-actions">
                                        <a href="{{ route('admin.articles.update', $article)}}" class=""><i class='bx bx-edit'></i></a>
                                        <a href="#" onclick="event.preventDefault(); if(confirm('Bạn có muốn xóa bài viết {{ $article->title }} không?')) document.getElementById('delete_form_{{ $article->id }}').submit();" class="ms-3">
                                            <i class='bx bx-trash text-danger'></i>
                                        </a>
                                        <form method="post" action="{{ route('admin.articles.delete', $article) }}" id="delete_form_{{ $article->id }}">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <a href="{{ route('admin.articles.note', $article->id) }}" class="ms-3 btn btn-primary">
                                            <i class="bx bx-send"></i>
                                        </a>

                                    </div>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="mt-4">{{ $articles->links() }}</div>

            </div>
        </div>
    </div>
</div>
<!--end page wrapper -->
@endsection

@section("script")
<script>
    $(document).ready(function() {
        setTimeout(() => {
            $(".general-message").fadeOut();
        }, 5000);

    });
</script>

@endsection