<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Kết quả bài tập</h1>
    <?php
    // Kết nối cơ sở dữ liệu
    $conn = new mysqli("localhost", "root", "", "tracnghiem");
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    // Lấy đáp án đúng từ cơ sở dữ liệu
    $sql = "SELECT id, correct_answer FROM questions";
    $result = $conn->query($sql);

    $answers = []; // Lưu trữ đáp án đúng
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $answers[$row['id']] = $row['correct_answer'];
        }
    }

    $score = 0;
    $totalQuestions = count($answers);

    // Kiểm tra đáp án của người dùng
    foreach ($answers as $questionId => $correctAnswer) {
        if (isset($_POST["question$questionId"])) {
            $userAnswer = $_POST["question$questionId"];
            if ($userAnswer === $correctAnswer) {
                $score++;
            }
        }
    }

    // Hiển thị kết quả
    echo "<div class='alert alert-success text-center'>";
    echo "Bạn trả lời đúng <strong>$score</strong>/$totalQuestions câu.";
    echo "</div>";

    $conn->close();
    ?>
    <a href="index.php" class="btn btn-primary">Làm lại</a>
</div>
</body>
</html>
