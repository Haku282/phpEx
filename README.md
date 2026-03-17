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
