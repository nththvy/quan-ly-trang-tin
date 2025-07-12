<!--sidebar wrapper -->
<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <h4 style="color:rgb(178, 0, 0)" class="logo-text">Trang quản trị</h4>
        </div>
        <div style="color:rgb(178, 0, 0)" class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{ route('admin.home') }}">
                <div class="parent-icon"><i class='bx bx-home-circle'></i></div>
                <div class="menu-title">Bảng điều khiển</div>
            </a>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-message-square-edit'></i>
                </div>
                <div class="menu-title">Bài viết</div>
            </a>

            <ul>
                <li> <a href="{{ route('admin.articles') }}"><i class="bx bx-right-arrow-alt"></i>Tất cả bài viết</a>
                </li>

                <li> <a href="{{ route('admin.articles.create') }}"><i class="bx bx-right-arrow-alt"></i>Thêm bài viết mới</a>
                </li>

            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-menu'></i>
                </div>
                <div class="menu-title">Danh mục bài viết</div>
            </a>

            <ul>
                <li> <a href="{{ route('admin.categories') }}"><i class="bx bx-right-arrow-alt"></i>Tất cả danh mục</a>
                </li>

                <li> <a href="{{ route('admin.categories.create') }}"><i class="bx bx-right-arrow-alt"></i>Thêm danh mục mới</a>
                </li>

            </ul>
        </li>
        <li>
            <a href="{{ route('admin.tags') }}">
                <div class="parent-icon"><i class='bx bx-purchase-tag'></i></div>
                <div class="menu-title">Từ khóa</div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.tags') }}">
                <div class="parent-icon"><i class='bx bx-purchase-tag'></i></div>
                <div class="menu-title">Chức năng mới</div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.statuses') }}">
                <div class="parent-icon"><i class='bx bx-check-circle'></i></div>
                <div class="menu-title">Tình trạng</div>
            </a>
        </li>
        <hr>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-key'></i>
                </div>
                <div class="menu-title">Phân Quyền</div>
            </a>

            <ul>
                <li> <a href="{{ route('admin.roles') }}"><i class="bx bx-right-arrow-alt"></i>Tất cả vai trò</a>
                </li>

                <li> <a href="{{ route('admin.roles.create') }}"><i class="bx bx-right-arrow-alt"></i>Thêm vai trò mới</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-user'></i>
                </div>
                <div class="menu-title">Tài khoản</div>
            </a>

            <ul>

                <li> <a href="{{ route('admin.users') }}"><i class="bx bx-right-arrow-alt"></i>Tất cả tài khoản</a>
                </li>

                <li> <a href="{{ route('admin.users.create') }}"><i class="bx bx-right-arrow-alt"></i>Thêm tài khoản mới</a>
                </li>

            </ul>
        </li>
        <li>
            <a href="{{ route('admin.comments') }}">
                <div class="parent-icon"><i class='bx bx-message-dots'></i></div>
                <div class="menu-title">Bình luận</div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.subscribers') }}">
                <div class="parent-icon"><i class='bx bx-envelope'></i></div>
                <div class="menu-title">Email đăng ký nhận tin</div>
            </a>
        </li>
        <li>
            <a href="{{ route('frontend.home') }}">
                <div class="parent-icon"><i class='bx bx-pointer'></i></div>
                <div class="menu-title">Trang chủ</div>
            </a>
        </li>


    </ul>
    <!--end navigation-->
</div>
<!--end sidebar wrapper -->