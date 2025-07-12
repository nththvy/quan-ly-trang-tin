@extends("layouts.app")

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
                        <li class="breadcrumb-item"><a href=#><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách bài viết</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body p-4">
                <h5 class="card-title">Xử lý</h5>
                <hr />
                <form action="{{ route('admin.articles.send', $article->id) }} " method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="inputProductTitle" class="form-label">Gửi xử lý</label>
                        <input type="text" value=' {{ old("content" ) }}' name="content" required class="form-control" id="inputProductTitle" placeholder="Nhập nội dung">

                        @error('content')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Writer: Hiển thị lựa chọn gửi cho ai -->
                    @if(Auth::user()->role->name === 'writer')
                    @if(in_array($article->status->status, ['draft', 'đã duyệt yêu cầu chỉnh sửa', 'chờ approver duyệt chỉnh sửa', 'chờ editor duyệt chỉnh sửa']))

                    <div class="mb-3">
                        <label for="sendTo" class="form-label">Gửi đến</label>
                        <select name="send_to" id="sendTo" class="form-control">
                            <option value="all">Gửi cho tất cả</option>
                            <option value="single">Gửi cho một người</option>
                        </select>
                    </div>

                    <div class="mb-3" id="editorSelect" style="display: none;">
                        <label for="editor" class="form-label">Chọn Editor</label>
                        <select name="editor_id" id="editor" class="form-control">
                            @foreach($editors as $editor)
                            <option value="{{ $editor->id }}">{{ $editor->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <script>
                        document.getElementById('sendTo').addEventListener('change', function() {
                            document.getElementById('editorSelect').style.display = this.value === 'single' ? 'block' : 'none';
                        });
                    </script>
                    @endif
                    @endif

                    <!-- Các nút Submit theo vai trò -->
                    @if(Auth::user()->role->name === 'writer' && $article->status->status === 'draft')
                    <button class="btn btn-success" type="submit">Gửi duyệt</button>
                    @endif

                    @if(Auth::user()->role->name === 'editor')
                    @if($article->status->status === 'pending review')
                    <button class="btn btn-success" type="submit">Duyệt bài</button>
                    <button class="btn btn-danger" type="submit" formaction="{{ route('admin.articles.return', $article->id) }}" formmethod="POST">
                        Trả về
                    </button>
                    @elseif($article->status->status === 'chờ editor duyệt chỉnh sửa')
                    <button class="btn btn-primary" type="submit" formaction="{{ route('admin.articles.approve_edit', $article->id) }}" formmethod="POST">
                        Duyệt yêu cầu chỉnh sửa
                    </button>
                    @endif
                    @endif

                    @if(Auth::user()->role->name === 'approver' || Auth::user()->role->name === 'admin')
                    @if($article->status->status === 'pending approve')
                    <button class="btn btn-success" type="submit">Xuất bản bài viết</button>
                    <button class="btn btn-danger" type="submit" formaction="{{ route('admin.articles.return', $article->id) }}" formmethod="POST">
                        Trả về
                    </button>
                    @elseif($article->status->status === 'chờ approver duyệt chỉnh sửa')
                    <button class="btn btn-primary" type="submit" formaction="{{ route('admin.articles.approve_edit', $article->id) }}" formmethod="POST">
                        Duyệt yêu cầu chỉnh sửa
                    </button>
                    @endif
                    @endif

                    @if(Auth::user()->role->name === 'admin')
                    <button class="btn btn-success" type="submit">Xuất bản bài viết</button>
                    @endif
                    @can('request-edit', $article)
                    <button class="btn btn-warning" type="submit" formaction="{{ route('admin.articles.request_edit', $article->id) }}" formmethod="POST">
                        Yêu cầu chỉnh sửa
                    </button>
                    @endcan
                    <a href="{{ route('admin.articles') }}" class="btn btn-secondary">Hủy bỏ</a>
                    @can('unpublish', $article)
                    <!-- Hiển thị nút gỡ xuất bản nếu người dùng có quyền -->
                    <button class="btn btn-warning" type="submit" formaction="{{ route('admin.articles.unpublish', $article->id) }}" formmethod="POST">
                        Gỡ xuất bản
                    </button>
                    @endcan
                </form>
                <hr />
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Lịch sử</h5>
                        <hr />
                        <!-- Hiển thị các ghi chú dưới dạng văn bản liên tục -->
                        <ul class="list-group">
                            @foreach($notes as $note)
                            <li class="list-group-item d-flex">
                                <div>
                                    <strong>Thời gian:</strong> {{ $note->created_at->format('d/m/Y H:i') }} &ndash;
                                    <strong>Trạng thái:</strong> {{ $note->status ? $note->status->status : 'Chưa xác định' }} &ndash;
                                    <strong>Người gửi:</strong> {{ $note->user->name ?? 'Không xác định' }} &ndash;
                                    <strong>Nội dung:</strong> {{ $note->content }}
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
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