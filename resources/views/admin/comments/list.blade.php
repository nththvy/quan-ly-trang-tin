@extends("layouts.app")
@section('style')
<style>
    .text-wrap-cell {
        max-width: 250px;
        white-space: normal;
        word-break: break-word;
    }

    .comment-title-truncate {
        max-width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .comment-title-truncate:hover {
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
            <div class="breadcrumb-title pe-3">Bình luận</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href=""><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Tất cả bình luận</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                <div class="d-lg-flex align-items-center mb-4 gap-3">
                    <div class="position-relative">
                        <input type="text" class="form-control ps-5 radius-30" placeholder="Tìm kiếm bình luận"> <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">#</th>
                                <th width="8%">Ảnh đại diện</th>
                                <th width="10%">Tên người dùng</th>
                                <th>Bài viết</th>
                                <th>Nội dung bình luận </th>
                                <th width="10%">Ngày tạo</th>
                                <th width="8%">Trạng thái</th>
                                <th width="6%">Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($comments as $comment)
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
                                        src="{{ $comment->user->image ? env('APP_URL') . '/storage/app/' . $comment->user->image : asset('storage/placeholders/user_placeholder.jpg') }}"
                                        alt="">
                                </td>
                                <td>{{ $comment->user->name }}</td>
                                <td class="comment-title-truncate" title="{{ $comment->article->title }}">
                                    {{ $comment->article->title }}
                                </td>
                                <td class="text-wrap-cell">{{ $comment->content }}</td>
                                <td>{{ $comment->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="badge rounded-pill 
                                            @if($comment->status === 'approved') 
                                                text-success bg-light-success 
                                            @elseif($comment->status === 'pending') 
                                                text-warning bg-light-warning 
                                            @endif 
                                            p-2 text-uppercase px-3">
                                        <i class='bx bxs-circle me-1'></i>{{ $comment->status }}
                                    </div>
                                </td>
                                </td>

                                <td>
                                    <div class="d-flex order-actions">
                                        @if($comment->status === 'pending')
                                        <a href="{{ route('admin.comments.approve', $comment->id) }}" class="me-3 text-success" title="Duyệt bình luận">
                                            <i class='bx bx-check-circle'></i>
                                        </a>
                                        @endif

                                        <a href="#" onclick="event.preventDefault(); if(confirm('Bạn có chắc chắn muốn xóa bình luận này không?')) document.getElementById('delete_form_{{ $comment->id }}').submit();" class="text-danger" title="Xóa bình luận">
                                            <i class='bx bx-trash'></i>
                                        </a>

                                        <form method="post" action="{{ route('admin.comments.delete', $comment->id) }}" id="delete_form_{{ $comment->id }}">
                                            @csrf
                                            @method('DELETE')
                                        </form>

                                    </div>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="mt-4">{{ $comments->links() }}</div>

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