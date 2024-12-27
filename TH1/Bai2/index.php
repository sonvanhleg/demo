<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài tập trắc nghiệm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Bài tập trắc nghiệm</h1>
    <form action="result.php" method="post">
        <?php
        // Kết nối cơ sở dữ liệu
        $conn = new mysqli("localhost", "root", "", "tracnghiem");
        if ($conn->connect_error) {
            die("Kết nối thất bại: " . $conn->connect_error);
        }

        // Lấy danh sách câu hỏi
        $sql = "SELECT * FROM questions";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $index = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<div class='card mb-4'>";
                echo "<div class='card-header'><strong>Câu $index: {$row['question_text']}</strong></div>";
                echo "<div class='card-body'>";

                // Tạo danh sách đáp án
                foreach (['a', 'b', 'c', 'd'] as $option) {
                    $answer = $row["option_$option"];
                    if ($answer) {
                        echo "<div class='form-check'>";
                        echo "<input class='form-check-input' type='radio' name='question{$row['id']}' value='{$option}' id='question{$row['id']}{$option}'>";
                        echo "<label class='form-check-label' for='question{$row['id']}{$option}'>{$answer}</label>";
                        echo "</div>";
                    }
                }
                echo "</div>";
                echo "</div>";
                $index++;
            }
        } else {
            echo "<p class='text-danger'>Không có câu hỏi nào!</p>";
        }
        $conn->close();
        ?>
        <button type="submit" class="btn btn-primary">Nộp bài</button>
    </form>
</div>
</body>
</html>
