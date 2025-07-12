@extends("layouts.app")
@section("style")

<link href="{{ asset('public/admin_dashboard_assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('public/admin_dashboard_assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />

@endsection

@section("wrapper")
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Tài khoản</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href=""><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Thêm mới tài khoản</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body p-4">
                <h5 class="card-title">Thêm tài khoản mới</h5>
                <hr />
                <form action="{{ route('admin.users.create') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-body mt-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="border border-3 p-4 rounded">

                                    <div class="mb-3">
                                        <label for="input_name" class="form-label">Họ Tên</label>
                                        <input name="name" type="text" class="form-control" id="input_name" value='{{ old("name") }}'>

                                        @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="input_email" class="form-label">Email</label>
                                        <input name="email" type="email" class="form-control" id="input_email" value='{{ old("email") }}'>

                                        @error('email')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="input_password" class="form-label">Mật khẩu</label>
                                        <input name="password" type="password" class="form-control" id="input_password">

                                        @error('password')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                                        <input name="password_confirmation" type="password" class="form-control" id="password_confirmation">

                                        @error('password_confirmation')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="input_image" class="form-label">Ảnh đại diện</label>
                                        <input name="image" type="file" class="form-control @error('image') is-invalid @enderror" id="input_image">
                                        <!-- Khung hiển thị ảnh xem trước -->
                                        <div id="image_preview_container" class="mt-2" style="display: none; position: relative; width: 100px; height: 60px;">
                                            <img id="image_preview" class="d-block rounded img-thumbnail" style="object-fit: cover; width: 100px; height: 60px;">
                                            <button type="button" id="remove_image" class="btn btn-light btn-sm"
                                                style="position: absolute; top: 5px; right: 5px; border-radius: 50%; padding: 2px 6px; font-size: 12px; line-height: 1;">
                                                &times;
                                            </button>
                                        </div>
                                        @error('image')
                                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="inputProductTitle" class="form-label">Quyền tài khoản</label>
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="p-3 rounded">
                                                    <div class="mb-3">
                                                        <select name="role_id" required class="single-select">
                                                            @foreach( $roles as $key => $role )
                                                            <option value="{{ $key }}">{{ $role }}</option>
                                                            @endforeach
                                                        </select>

                                                        @error('role_id')
                                                        <p class="text-danger">{{ $message }}</p>
                                                        @enderror

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Thêm tài khoản mới</button>

                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>


    </div>
</div>
<!--end page wrapper -->
@endsection

@section("script")
<script src="{{ asset('public/admin_dashboard_assets/plugins/select2/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // $('#image-uploadify').imageuploadify();

        $('.single-select').select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });

        setTimeout(() => {
            $(".general-message").fadeOut();
        }, 5000);

    });

    //xử lý hiển thị ảnh xem trước
	document.addEventListener("DOMContentLoaded", function() {
		const inputImage = document.getElementById("input_image");
		const imagePreviewContainer = document.getElementById("image_preview_container");
		const imagePreview = document.getElementById("image_preview");
		const removeImageBtn = document.getElementById("remove_image");

		if (!inputImage || !imagePreviewContainer || !imagePreview || !removeImageBtn) {
			console.error("Không tìm thấy phần tử HTML cần thiết.");
			return;
		}

		// Khi chọn ảnh, hiển thị ảnh xem trước
		inputImage.addEventListener("change", function(event) {
			const file = event.target.files[0];

			if (file) {
				const reader = new FileReader();

				reader.onload = function(e) {
					imagePreview.src = e.target.result;
					imagePreviewContainer.style.display = "block"; // Hiển thị ảnh xem trước
					console.log("Ảnh đã chọn:", e.target.result); // Debug kiểm tra
				};

				reader.readAsDataURL(file);
			}
		});

		// Khi bấm nút "X" để xóa ảnh
		removeImageBtn.addEventListener("click", function() {
			inputImage.value = ""; // Xóa file đã chọn
			imagePreviewContainer.style.display = "none"; // Ẩn phần xem trước
			imagePreview.src = ""; // Xóa ảnh xem trước
			console.log("Ảnh đã bị xóa.");
		});
	});
</script>

@endsection