<?php
session_start();
include "config/db.php";

if (!isset($_SESSION['result_user'])) {
    header("Location: view_result_login.php");
    exit();
}

$student_id = $_SESSION['result_user'];

// Fetch latest result
$resultRes = mysqli_query($conn,
"SELECT * FROM results
 WHERE student_id='$student_id'
 ORDER BY id DESC LIMIT 1");

$resultRow = mysqli_fetch_assoc($resultRes);

// Fetch answers with questions
$answerRes = mysqli_query($conn,
"SELECT q.question,
        q.correct_answer,
        a.answer
 FROM answers a
 JOIN questions q ON a.question_id = q.id
 WHERE a.student_id='$student_id'");
?>

<!DOCTYPE html>
<html>
<head>
<title>Exam Result</title>
<link rel="stylesheet" href="css/style.css">
<style>
.review {
    width: 900px;
}
.correct { color: green; }
.wrong { color: red; }
</style>
</head>
<body>

<div class="container review">
    <h2>Your Exam Result</h2>

    <p style="text-align:center;font-size:18px;">
        Score: <strong><?php echo $resultRow['score']; ?> / 1000</strong><br>
        Result: <strong><?php echo $resultRow['result']; ?></strong>
    </p>

    <hr>

    <?php $i = 1; while ($row = mysqli_fetch_assoc($answerRes)) { ?>
        <p><strong>Q<?php echo $i++; ?>.</strong>
           <?php echo $row['question']; ?></p>

        <p>
            Your Answer:
            <span class="<?php echo ($row['answer']==$row['correct_answer'])?'correct':'wrong'; ?>">
                <?php echo $row['answer']; ?>
            </span>
        </p>

        <p>
            Correct Answer:
            <strong><?php echo $row['correct_answer']; ?></strong>
        </p>

        <hr>
    <?php } ?>
</div>

</body>
</html>
