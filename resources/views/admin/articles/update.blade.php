@extends("layouts.app")
@section("style")
<!-- <link href="{{ asset('admin_dashboard_assets/plugins/Drag-And-Drop/dist/imageuploadify.min.css') }}" rel="stylesheet" /> -->

<link href="{{ asset('public/admin_dashboard_assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('public/admin_dashboard_assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />

<link href="{{ asset('public/admin_dashboard_assets/plugins/input-tags/css/tagsinput.css') }}" rel="stylesheet" />

<style>
	.ck-editor__editable {
		min-height: 500px;
		max-height: 600px;
		overflow-y: auto;
	}
</style>
@endsection
@section("wrapper")
<div class="page-wrapper">
	<div class="page-content">
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="breadcrumb-title pe-3">Bài viết</div>
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href=""><i class="bx bx-home-alt"></i></a></li>
						<li class="breadcrumb-item active" aria-current="page">Chỉnh sửa bài viết</li>
					</ol>
				</nav>
			</div>
		</div>

		<div class="card">
			<div class="card-body p-4">
				<h5 class="card-title">Chỉnh sửa bài viết: {{$article->title}}</h5>
				<hr />
				<form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-body mt-4">
						<div class="row">
							<div class="col-lg-12">
								<div class="border border-3 p-4 rounded">
									<div class="mb-3">
										<label class="form-label">Tiêu đề bài viết</label>
										<input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
											value="{{ old('title', $article->title) }}" required>
										@error('title') <p class="text-danger">{{ $message }}</p> @enderror
									</div>

									<div class="mb-3">
										<label class="form-label">Mô tả</label>
										<textarea name="summary" class="form-control" rows="3">{{ old('summary', $article->summary) }}</textarea>
										@error('summary') <p class="text-danger">{{ $message }}</p> @enderror
									</div>

									<div class="mb-3">
										<label class="form-label">Danh mục bài viết</label>
										<select name="category_id" class="single-select">
											@foreach($categories as $key => $category)
											<option value="{{ $key }}" {{ old('category_id', $article->category_id) == $key ? 'selected' : '' }}>
												{{ $category }}
											</option>
											@endforeach
										</select>
										@error('category_id') <p class="text-danger">{{ $message }}</p> @enderror
									</div>

									<div class="mb-3">
										<label class="form-label">Từ khóa</label>
										<select name="tags[]" id="tags" class="form-control select2" multiple="multiple">
											@foreach($tags as $id => $name)
											<option value="{{ $name }}"
												@if(collect(old('tags', $article->tags->pluck('name')->toArray()))->contains($name)) selected @endif>
												{{ $name }}
											</option>
											@endforeach
										</select>
									</div>

									<div class="row">
										<div class="col-md-8">
											<div class="mb-3">
												<label for="input_image" class="form-label">Hình ảnh bài viết</label>

												@if(!empty($article->image))
												<img class="d-block rounded img-thumbnail mb-2"
													src="{{ env('APP_URL') . '/storage/app/' . $article->image }}"
													width="100" />
												<span class="d-block small text-danger">Bỏ trống nếu muốn giữ nguyên ảnh cũ.</span>
												@endif

												<input name="image" type="file" class="form-control @error('image') is-invalid @enderror" id="input_image">

												@error('image')
												<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
												@enderror
											</div>
										</div>
									</div>
									<div class="mb-3">
										<label class="form-label">Nội dung bài viết</label>
										<textarea name="content" id="content" class="form-control" rows="3">{{ old('content', $article->content) }}</textarea>
										@error('content') <p class="text-danger">{{ $message }}</p> @enderror
									</div>

									<button class="btn btn-primary" type="submit">Cập nhật bài viết</button>
									<button class="btn btn-secondary" id="closeFormBtn" type="button">Hủy</button>

								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>

	</div>
</div>
@endsection

@section("script")
<script src="{{ asset('public/admin_dashboard_assets/plugins/select2/js/select2.min.js') }}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
<script>
	ClassicEditor
		.create(document.querySelector('#content'), {
			ckfinder: {
				uploadUrl: "{{ route('admin.articles.uploadImage') }}?_token={{ csrf_token() }}" // Truyền CSRF token vào URL
			}
		})
		.then(editor => {
			editorInstance = editor; // Lưu instance để sử dụng sau này
		})
		.catch(error => {
			console.error('Lỗi khi khởi tạo CKEditor:', error);
		});


	$(document).ready(function() {
		//tạo select2 cho tags
		$('#tags').select2({
			tags: true, // Cho phép nhập từ khóa mới
			tokenSeparators: [',', ';'], // Dấu phẩy hoặc khoảng trắng để thêm từ khóa
			placeholder: "Chọn hoặc nhập từ khóa...",
			allowClear: true
		});

		//kiểm tra tiêu đề trùng lặp
		$("#inputProductTitle").on("keyup", function() {
			var title = $(this).val();
			var errorContainer = $("#titleError");

			if (title.length > 3) { // Chỉ kiểm tra nếu có ít nhất 3 ký tự
				$.ajax({
					url: "{{ route('admin.check.title') }}",
					type: "GET",
					data: {
						title: title
					},
					success: function(response) {
						if (response.exists) {
							errorContainer.text("Tiêu đề này đã tồn tại, vui lòng chọn tiêu đề khác.");
							errorContainer.addClass("text-danger");
						} else {
							errorContainer.text("");
							errorContainer.removeClass("text-danger");
						}
					}
				});
			} else {
				errorContainer.text("");
				errorContainer.removeClass("text-danger");
			}
		});

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

	//xử lý nút nhập lại
	document.getElementById("resetFormBtn").addEventListener("click", function(event) {
		event.preventDefault(); // Ngăn chặn form reload ngay lập tức

		if (confirm("Bạn có chắc chắn muốn nhập lại không?")) {
			document.getElementById("articleForm").reset(); // Reset form

			// Reset các select2
			$("#tags").val(null).trigger("change");
			$(".single-select").val(null).trigger("change");

			// Kiểm tra CKEditor 5 đã khởi tạo chưa, nếu có thì reset nội dung
			if (editorInstance) {
				editorInstance.setData(''); // Xóa nội dung CKEditor 5
			}

			// Reset ảnh xem trước
			const inputImage = document.getElementById("input_image");
			const imagePreviewContainer = document.getElementById("image_preview_container");
			const imagePreview = document.getElementById("image_preview");

			inputImage.value = ""; // Xóa file đã chọn
			imagePreviewContainer.style.display = "none"; // Ẩn phần xem trước
			imagePreview.src = ""; // Xóa ảnh xem trước
		}
	});

	//xử lý nút đóng
	document.getElementById("closeFormBtn").addEventListener("click", function(event) {
		event.preventDefault(); // Ngăn chặn hành động mặc định

		let confirmSave = confirm("Bạn có muốn lưu bài viết không?");

		if (confirmSave) {
			console.log("Gửi form để lưu bài viết...");
			document.getElementById("articleForm").submit(); // Gửi form đến controller
		} else {
			console.log("Không lưu, quay về danh sách.");
			window.location.href = "{{ route('admin.articles') }}"; // Chuyển hướng về danh sách bài viết
		}
	});

	document.addEventListener("DOMContentLoaded", function() {
		const inputImage = document.getElementById("input_image");
		const imagePreviewContainer = document.getElementById("image_preview_container");
		const imagePreview = document.getElementById("image_preview");
		const removeImageBtn = document.getElementById("remove_image");
		const deleteImageInput = document.getElementById("delete_image"); // Lấy input ẩn

		if (!inputImage || !imagePreviewContainer || !imagePreview || !removeImageBtn || !deleteImageInput) {
			console.error("Không tìm thấy phần tử HTML cần thiết.");
			return;
		}

		// Khi chọn ảnh mới
		inputImage.addEventListener("change", function(event) {
			const file = event.target.files[0];

			if (file) {
				const reader = new FileReader();

				reader.onload = function(e) {
					imagePreview.src = e.target.result;
					imagePreviewContainer.style.display = "block";
					deleteImageInput.value = "0"; // Không xóa ảnh cũ nếu chọn ảnh mới
				};

				reader.readAsDataURL(file);
			}
		});

		// Khi bấm nút "X" để xóa ảnh
		removeImageBtn.addEventListener("click", function() {
			inputImage.value = ""; // Xóa file đã chọn
			imagePreview.src = ""; // Xóa ảnh xem trước
			imagePreviewContainer.style.display = "none"; // Ẩn ảnh
			deleteImageInput.value = "1"; // Đánh dấu ảnh sẽ bị xóa khi cập nhật
		});
	});
</script>

@endsection