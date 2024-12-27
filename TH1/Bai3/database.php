<?php
include 'connection.php';

$file = fopen("KTPM3.csv", "r");

fgetcsv($file);

$stmt = $conn->prepare("INSERT INTO students (username, password, lastname, firstname, city, email, course1) VALUES (?, ?, ?, ?, ?, ?, ?)");

// Liên kết các tham số
$stmt->bind_param("sssssss", $username, $password, $lastname, $firstname, $city, $email, $course1);

// Đọc và chèn dữ liệu từ CSV vào cơ sở dữ liệu
while (($data = fgetcsv($file)) !== FALSE) {
    $username = $data[0];
    $password = $data[1];
    $lastname = $data[2];
    $firstname = $data[3];
    $city = $data[4];
    $email = $data[5];
    $course1 = $data[6];

    $stmt->execute();
}

echo "Dữ liệu đã được nhập thành công";

$stmt->close();
$conn->close();
?>
