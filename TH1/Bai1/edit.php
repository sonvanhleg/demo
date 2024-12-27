<?php
// Kết nối đến database
include('database.php');

// Lấy ID từ query string
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Truy vấn thông tin của hoa theo ID
    $sql = "SELECT * FROM flower_info WHERE id = $id";
    $result = $conn->query($sql);

    // Kiểm tra nếu tồn tại bản ghi
    if ($result->num_rows > 0) {
        $flower = $result->fetch_assoc();
    } else {
        echo "Không tìm thấy thông tin hoa!";
        exit();
    }
} else {
    echo "ID không hợp lệ!";
    exit();
}

// Xử lý khi người dùng gửi form sửa
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $image = $_FILES['image'];

    // Kiểm tra xem có upload file mới hay không
    if (isset($image) && $image['error'] === UPLOAD_ERR_OK) {
        $targetDir = "uploads/";
        $fileName = basename($image['name']);
        $targetFilePath = $targetDir . $fileName;

        // Tạo thư mục nếu chưa tồn tại
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Di chuyển file upload đến thư mục đích
        if (move_uploaded_file($image['tmp_name'], $targetFilePath)) {
            $imagePath = $targetFilePath; // Lấy đường dẫn mới của ảnh
        } else {
            echo "Lỗi: Không thể tải file lên.";
            exit();
        }
    } else {
        // Nếu không upload ảnh mới, giữ nguyên ảnh cũ
        $imagePath = $flower['image'];
    }

    // Cập nhật thông tin hoa
    $sqlUpdate = "UPDATE flower_info SET name = '$name', description = '$description', image = '$imagePath' WHERE id = $id";
    if ($conn->query($sqlUpdate) === TRUE) {
        header("Location: admin.php"); // Chuyển hướng về trang danh sách
        exit();
    } else {
        echo "Lỗi khi cập nhật: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa thông tin loài hoa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="my-4">Sửa thông tin loài hoa</h2>
        <form action="edit.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Tên hoa</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $flower['name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea class="form-control" id="description" name="description" rows="4" required><?php echo $flower['description']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Chọn ảnh mới (nếu có)</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                <p class="mt-2">Ảnh hiện tại:</p>
                <img src="<?php echo $flower['image']; ?>" alt="<?php echo $flower['name']; ?>" style="max-width: 200px;">
            </div>
            <button type="submit" class="btn btn-success">Xác nhận sửa</button>
            <a href="admin.php" class="btn btn-secondary">Hủy</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
