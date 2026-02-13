<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$student_id = intval($_GET['student_id']);
$attempt_no = intval($_GET['attempt']);

/* FETCH RESULT */
$res = mysqli_query($conn,
    "SELECT r.*, s.name, s.email
     FROM results r
     JOIN students s ON r.student_id = s.id
     WHERE r.student_id='$student_id'
     AND r.attempt_no='$attempt_no'
     LIMIT 1");

$result = mysqli_fetch_assoc($res);

/* FETCH ANSWERS FOR THIS ATTEMPT */
$answers = mysqli_query($conn,
    "SELECT a.*, q.question, q.correct_answer
     FROM answers a
     JOIN questions q ON a.question_id = q.id
     WHERE a.student_id='$student_id'
     AND a.attempt_no='$attempt_no'");
?>

<!DOCTYPE html>
<html>
<head>
<title>Attempt Details</title>
<link rel="stylesheet" href="../css/style.css">

<style>
.review { width: 1000px; }
.correct { color: green; font-weight: bold; }
.wrong { color: red; font-weight: bold; }
hr { margin: 20px 0; }
</style>
</head>

<body>

<div class="container review">

<h2>Attempt Details</h2>

<p><strong>Student:</strong> <?php echo $result['name']; ?></p>
<p><strong>Email:</strong> <?php echo $result['email']; ?></p>
<p><strong>Attempt No:</strong> <?php echo $result['attempt_no']; ?></p>
<p><strong>Score:</strong> <?php echo $result['score']; ?> / 1000</p>
<p><strong>Result:</strong>
<span class="<?php echo strtolower($result['result']); ?>">
<?php echo $result['result']; ?>
</span>
</p>

<hr>

<?php
$qno = 1;
while ($row = mysqli_fetch_assoc($answers)) {

    $userArr = explode(",", $row['answer']);
    $correctArr = explode(",", $row['correct_answer']);
?>

<p><strong>Q<?php echo $qno++; ?>.</strong>
<?php echo htmlspecialchars($row['question']); ?></p>

<p>Your Answer:</p>
<ul>
<?php
foreach ($userArr as $ua) {
    $opt = mysqli_query($conn,
        "SELECT option_text FROM options
         WHERE question_id='{$row['question_id']}'
         AND option_value='$ua'");
    $optRow = mysqli_fetch_assoc($opt);

    if ($optRow) {
        $class = in_array($ua, $correctArr) ? 'correct' : 'wrong';
        echo "<li class='$class'>$ua) "
            . htmlspecialchars($optRow['option_text'])
            . "</li>";
    }
}
?>
</ul>

<p>Correct Answer:</p>
<ul>
<?php
foreach ($correctArr as $ca) {
    $opt = mysqli_query($conn,
        "SELECT option_text FROM options
         WHERE question_id='{$row['question_id']}'
         AND option_value='$ca'");
    $optRow = mysqli_fetch_assoc($opt);

    if ($optRow) {
        echo "<li class='correct'>$ca) "
            . htmlspecialchars($optRow['option_text'])
            . "</li>";
    }
}
?>
</ul>

<hr>

<?php } ?>

<button type="button"
        onclick="window.location.href='view_results.php';"
        class="btn-cancel">
    Back
</button>

</div>

</body>
</html>
