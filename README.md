# 🎓 Hệ Thống Quản Lý Sinh Viên (Student Management System)

Dự án PHP quản lý sinh viên được viết theo mô hình kiến trúc **MVC (Model-View-Controller)** và **Front Controller**, sử dụng PDO để tương tác với cơ sở dữ liệu MySQL, và quản lý thư viện thông qua **Composer**.

## ✨ Các Chức Năng Nổi Bật

- **Xác thực người dùng:** Đăng nhập, Đăng ký, Đăng xuất, Đổi mật khẩu.
- **Quản lý danh sách sinh viên (CRUD):** Thêm, Sửa, Xóa và Xem chi tiết thông tin sinh viên.
- **Upload Ảnh Đại Diện:** Hỗ trợ tải lên và hiển thị ảnh đại diện (Avatar) cho từng sinh viên.
- **Tìm kiếm thông minh:** Tìm kiếm sinh viên linh hoạt theo Tên, Email hoặc Số điện thoại (tìm kiếm theo đầu số).
- **Phân trang & Sắp xếp:** Hỗ trợ phân trang danh sách và sắp xếp linh động theo từng cột dữ liệu (ID, Tên, Email, SĐT, ...).
- **Thống kê / Dashboard:** Xem tổng quan và thống kê ứng dụng.
- **Xuất dữ liệu:** Export danh sách sinh viên dưới dạng file CSV.
- **Thông báo Email:** Tích hợp PHPMailer để gửi email thông báo từ hệ thống.
- **Flash Messages:** Thông báo trạng thái thao tác (Thêm thành công, Lỗi...) trực quan trên giao diện.

## 🛠 Công Nghệ Sử Dụng

- **Ngôn ngữ:** PHP (Thuần / Hướng đối tượng OOP)
- **Cơ sở dữ liệu:** MySQL (sử dụng PHP Data Objects - PDO chống SQL Injection)
- **Quản lý dependencies:** Composer (PSR-4 Autoloading)
- **Kiến trúc:** Mô hình MVC (Controllers, Models, Views) + Front-Controller Pattern (`index.php`)
- **Thư viện bên thứ 3:** [PHPMailer](https://github.com/PHPMailer/PHPMailer) (quản lý qua Composer)

## 🚀 Hướng Dẫn Cài Đặt

> **Lưu ý:** Xem chi tiết các yêu cầu về môi trường (PHP, MySQL, Extensions) tại file `requirements.txt` trong mã nguồn.

1. **Clone dự án (hoặc tải mã nguồn):**
   Đưa mã nguồn vào thư mục `htdocs` của XAMPP (ví dụ: `C:\xampp\htdocs\bai01_quanly_sv`).

2. **Cài đặt thư viện:**
   Mở terminal tại thư mục gốc của dự án (`bai01_quanly_sv`) và chạy lệnh sau để tải PHPMailer và thiết lập PSR-4 Autoload:
   ```bash
   composer install
   ```
   *(Đảm bảo máy tính đã cài đặt sẵn Composer).*

3. **Cấu hình Cơ sở dữ liệu:**
   - Tạo CSDL MySQL có tên là `quanlysinhvien` (sử dụng phpMyAdmin hoặc MySQL CLI).
   - Kiểm tra và thay đổi thông tin kết nối DB (Tên đăng nhập, mật khẩu) trong file `src/Database.php` nếu cần thiết (Mặc định: host: `localhost`, username: `root`, password: rỗng).

4. **Cấu hình Email (Tùy chọn):**
   - Mở file `config.php` tại thư mục gốc để cập nhật lại thông tin tài khoản SMTP (`MAIL_USERNAME`, `MAIL_PASSWORD` ứng dụng 16 ký tự) nếu bạn muốn test tính năng gửi mail.

5. **Chạy ứng dụng:**
   - Bật Apache và MySQL thông qua XAMPP Control Panel.
   - Mở trình duyệt và truy cập: `http://localhost/bai01_quanly_sv/public/index.php`

---

## 📂 Luồng Hoạt Động (Cơ bản)

1. Client gửi request tới `public/index.php` (Front Controller).
2. `index.php` phân tích URL (ví dụ: `?action=add`), gọi `Controller` tương ứng (VD: `SinhvienController`, `UserController`).
3. `Controller` tiếp nhận nghiệp vụ, gọi tới `Model` để lấy/cập nhật dữ liệu từ Database.
4. `Model` trả dữ liệu lại cho `Controller`.
5. `Controller` load file `View` tương ứng trong thư mục `views/` và truyền dữ liệu ra giao diện HTML để hiển thị cho người dùng.