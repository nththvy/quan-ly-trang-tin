@extends('layout.app')

@section('title', 'Không có quyền truy cập')

@section('content')
<div class="container mt-5 text-center">
    <h1 class="text-danger">Bạn không có quyền truy cập vào trang này</h1>
    <p class="mt-3">Vui lòng liên hệ quản trị viên nếu bạn nghĩ đây là lỗi.</p>
    <a href="{{ url('/') }}" class="btn btn-primary mt-3">Quay lại trang chủ</a>
</div>
@endsection