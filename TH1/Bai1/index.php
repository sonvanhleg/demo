<?php
include('database.php');

$sql = "SELECT * FROM flower_info";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    ?>
    <!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Danh sách hoa</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .flower-image {
                width: 200px; 
                height: auto;
            }
            .flower-description {
                max-width: 300px; 
            }
            .container {
                margin-top: 30px;
            }
            table th, table td {
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1 class="text-center mb-4">Danh sách các loài hoa</h1>

            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Tên hoa</th>
                        <th>Mô tả</th>
                        <th>Ảnh</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Duyệt qua từng dòng dữ liệu và hiển thị
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td class="flower-description"><?php echo $row['description']; ?></td>
                            <td><img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" class="flower-image"></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
    <?php
} else {
    echo "Không có dữ liệu.";
}

$conn->close();
?>
