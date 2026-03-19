Bài 1
Luồng hoạt động của ứng dụng
1. Người dùng truy cập link web .../public/index.php.
2. index.php (Front Controller) được chạy.
3. Nó kiểm tra $_GET['action']. Mặc định là index.
4. Nó tạo một SinhvienController.
5. Nó gọi phương thức index() của controller.
6. index() gọi getAllStudents() từ SinhvienModel để lấy dữ liệu từ CSDL.
7. index() nạp file views/student_list.php và truyền dữ liệu sinh viên vào để hiển thị.
8. Khi người dùng submit form, họ được gửi đến .../public/index.php?action=add.
9. Front Controller sẽ gọi phương thức add() của controller.
10. add() lấy dữ liệu từ $_POST, gọi addStudent() trong Model để lưu vào CSDL.
11.Sau khi lưu, add() chuyển hướng người dùng về lại trang chủ.

Bài 2-3
Kiến thức cần nắm trong bài thực hành này:
● Cách truyền tham số (id) qua URL.
● Viết câu lệnh SQL SELECT ... WHERE để lấy một bản ghi duy nhất.
● Sử dụng thẻ <input type="hidden"> để gửi dữ liệu ẩn trong form
sinhvien_edit.php.
● Viết câu lệnh SQL UPDATE để chỉnh sửa dữ liệu đã có.

Bài 4
Sau 4 bài thực hành, các em đã nắm vững các kiến thức sau:
❖ Sử dụng Composer để quản lý dự án và tự động nạp class.
❖ Tổ chức code theo cấu trúc gần giống mô hình MVC (Model-View-Controller).
❖ Tương tác với cơ sở dữ liệu MySQL một cách an toàn bằng PDO và Prepared
Statements.
❖ Xây dựng các chức năng Create, Read, Update, Delete.
❖ Xử lý form, tham số trên URL và chuyển hướng trang.