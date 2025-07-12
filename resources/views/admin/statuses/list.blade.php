@extends("layouts.app")
		
@section("wrapper")
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Tình trạng</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Tất cả tình trạng</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        
        <div class="card">
            <div class="card-body">
                <div class="d-lg-flex align-items-center mb-4 gap-3">
                    <div class="position-relative">
                        <input type="text" class="form-control ps-5 radius-30" placeholder="Tìm kiếm tình trạng"> <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
                    </div>
                    <div class="ms-auto"><a href="{{route('admin.statuses.create')}}" class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Thêm từ khóa mới</a></div>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Mã tình trạng</th>
                                <th>Tên tình trạng</th>
                                <th>Xem chi tiết</th>
                                <th>Ngày tạo</th>
                                <th>Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($statuses as $status)
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
                                <td>{{ $status->status }}</td>
                                <td>
                                    <a class="btn btn-primary btn-sm" href="#">Chi tiết bài viết</a>
                                </td>
                                <td>{{ $status->created_at->format('d/m/Y') }}</td>
                   
                                <td>
                                    <div class="d-flex order-actions">
                                        <a href="{{ route('admin.statuses.update', $status)}}"><i class='bx bxs-edit'></i></a>
                                        <a href="{{ route('admin.statuses.delete', ['id' => $status->id]) }}"
                                            onclick="return confirm('Bạn có muốn xóa từ khóa {{ $status->status }} không?')"
                                            class="ms-3">
                                            <i class='bx bxs-trash text-danger'></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                          
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">{{ $statuses->links() }}</div>

            </div>
        </div>


    </div>
</div>
<!--end page wrapper -->
@endsection

@section("script")
	<script>
		$(document).ready(function () {
		setTimeout(()=>{
				$(".general-message").fadeOut();
		},5000);

		});
	</script>

@endsection
