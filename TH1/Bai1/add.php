<?php
include('database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $name = $_POST['name'];
    $description = $_POST['description'];

    // Kiểm tra và xử lý file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "uploads/"; // Thư mục lưu trữ file upload
        $fileName = basename($_FILES['image']['name']);
        $targetFilePath = $targetDir . $fileName;

        // Kiểm tra và đảm bảo thư mục tồn tại
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Di chuyển file upload đến thư mục đích
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            // Lưu đường dẫn ảnh vào database
            $sql = "INSERT INTO flower_info (name, description, image) VALUES ('$name', '$description', '$targetFilePath')";
            if ($conn->query($sql) === TRUE) {
                header("Location: admin.php"); // Chuyển hướng về trang danh sách hoa
                exit();
            } else {
                echo "Lỗi khi thêm dữ liệu: " . $conn->error;
            }
        } else {
            echo "Lỗi: Không thể tải file lên.";
        }
    } else {
        echo "Lỗi: Vui lòng chọn file hợp lệ.";
    }
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm loài hoa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="my-4">Thêm loài hoa mới</h2>
        <!-- Form với enctype để hỗ trợ upload file -->
        <form action="add.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Tên hoa</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Chọn ảnh</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Thêm</button>
            <a href="admin.php" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
</body>
</html>


<?php
$conn->close();
?>
