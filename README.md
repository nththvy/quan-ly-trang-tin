# 📰 Trang Tin Điện Tử Viettel An Giang

> Một hệ thống quản lý nội dung tin tức nội bộ cho doanh nghiệp, hỗ trợ phân quyền, kiểm duyệt và xuất bản bài viết nhiều cấp.

## 📌 Mô tả dự án

Hệ thống được xây dựng trong thời gian thực tập tại Viettel An Giang, với mục tiêu phát triển một nền tảng xuất bản và quản lý bài viết hiện đại, chặt chẽ và linh hoạt. Người dùng trong hệ thống được phân quyền theo vai trò rõ ràng: **Admin, Writer, Editor, Approver, User** – đảm bảo toàn bộ quy trình từ viết, duyệt đến xuất bản được kiểm soát nghiêm ngặt.

Các tính năng chính bao gồm:
- Quản lý bài viết theo quy trình 5 bước: Nháp → Gửi duyệt → Biên tập → Phê duyệt → Xuất bản
- Quản lý danh mục, từ khóa, bình luận, người dùng và vai trò
- Hệ thống bình luận có kiểm duyệt
- Dashboard quản trị thống kê bài viết, lượt xem
- Giao diện thân thiện, dễ sử dụng, responsive với Bootstrap 5

---

## ⚙️ Công nghệ sử dụng

| Công nghệ | Mô tả |
|----------|-------|
| PHP 8.2 | Ngôn ngữ chính |
| Laravel 12 | Framework backend |
| MySQL | Cơ sở dữ liệu quan hệ |
| Laravel UI | Hệ thống giao diện auth |
| Spatie Permission | Gói phân quyền người dùng |
| Bootstrap 5.3 | Thiết kế giao diện responsive |
| CKEditor 5 | Trình soạn thảo nội dung |
| jQuery 3.6.4 | Tương tác client-side |

---

## 🚀 Hướng dẫn cài đặt

### 🔧 Yêu cầu
- XAMPP (Apache + MySQL)
- Composer (PHP dependency manager)

### 📥 Các bước triển khai local:

```bash
# Clone project về máy
git clone https://github.com/your-username/trang-tin-viettel.git

cd trang-tin-viettel

# Cài đặt thư viện Laravel
composer install

# Tạo file .env từ mẫu và cấu hình DB
cp .env.example .env

# Khởi tạo key ứng dụng
php artisan key:generate

# Cập nhật thông tin DB trong .env, ví dụ:
# DB_DATABASE=trangtin
# DB_USERNAME=root
# DB_PASSWORD=

# Tạo database từ phpMyAdmin hoặc dòng lệnh
php artisan migrate
php artisan db:seed

# Chạy server
php artisan serve

