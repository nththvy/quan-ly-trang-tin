@extends("layouts.app")

@section("wrapper")
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Vai trò</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href=#><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Sửa vai trò</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body p-4">
                <h5 class="card-title">Sửa vai trò: {{ $role->name }}</h5>
                <hr />
                <form action="{{ route('admin.roles.update', $role) }}" method="POST">
                    @csrf


                    <div class="form-body mt-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="border border-3 p-4 rounded">
                                    <div class="mb-3">
                                        <label for="inputRoleName" class="form-label">Tên vai trò</label>
                                        <input type="text" value="{{ old('name', $role->name) }}" name="name" required
                                            class="form-control" id="inputRoleName" placeholder="Nhập vai trò">

                                        @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Phần permission -->
                                    <div class="mb-3">
                                        <label class="form-label">Phân quyền</label>
                                        <div class="row">
                                            @foreach($permissions as $permission)
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input"
                                                        type="checkbox"
                                                        name="permissions[]"
                                                        value="{{ $permission->name }}"
                                                        id="permission_{{ $permission->id }}"
                                                        {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        @error('permissions')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <button class="btn btn-primary" type="submit">Cập nhật vai trò</button>
                                    <a class="btn btn-danger"
                                        onclick="return confirm('Bạn có chắc muốn xóa vai trò {{ $role->name }} không?')"
                                        href="{{ route('admin.roles.delete', ['id' => $role->id]) }}">
                                        Xóa vai trò
                                    </a>

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
<script>
    $(document).ready(function() {

        setTimeout(() => {
            $(".general-message").fadeOut();
        }, 5000);

    });
</script>

@endsection