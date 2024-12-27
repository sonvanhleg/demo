<?php
include('database.php');

// Kiểm tra nếu có ID được gửi qua phương thức GET
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Ép kiểu để đảm bảo ID là số nguyên

    // Truy vấn để lấy thông tin ảnh (nếu cần xóa ảnh khỏi thư mục)
    $sqlGetImage = "SELECT image FROM flower_info WHERE id = $id";
    $result = $conn->query($sqlGetImage);
    if ($result->num_rows > 0) {
        $flower = $result->fetch_assoc();
        $imagePath = $flower['image'];

        // Xóa file ảnh nếu tồn tại
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    // Xóa bản ghi khỏi cơ sở dữ liệu
    $sql = "DELETE FROM flower_info WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        header("Location: admin.php"); // Chuyển hướng về trang danh sách
        exit();
    } else {
        echo "Lỗi khi xóa: " . $conn->error;
    }
} else {
    echo "ID không hợp lệ!";
    exit();
}

// Đóng kết nối
$conn->close();
?>
