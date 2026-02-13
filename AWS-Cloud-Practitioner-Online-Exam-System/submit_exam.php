<?php
session_start();
include "config/db.php";

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$score = 0;

/* GET NEXT ATTEMPT NUMBER */
$res = mysqli_query($conn,
    "SELECT MAX(attempt_no) as last_attempt 
     FROM results WHERE student_id='$student_id'");
$data = mysqli_fetch_assoc($res);

$attempt_no = ($data['last_attempt']) 
    ? $data['last_attempt'] + 1 
    : 1;

$started_at = date("Y-m-d H:i:s");

/* PROCESS ANSWERS */
if (isset($_POST['ans'])) {

    foreach ($_POST['ans'] as $qid => $ans) {

        if (is_array($ans)) {
            sort($ans);
            $ans = implode(",", $ans);
        }

        /* STORE ANSWER WITH ATTEMPT */
        mysqli_query($conn,
            "INSERT INTO answers 
             (student_id, question_id, answer, attempt_no)
             VALUES 
             ('$student_id','$qid','$ans','$attempt_no')");

        /* CHECK CORRECT ANSWER */
        $res = mysqli_query($conn,
            "SELECT correct_answer 
             FROM questions WHERE id='$qid'");
        $row = mysqli_fetch_assoc($res);

        if ($row) {
            $correctArr = explode(",", $row['correct_answer']);
            sort($correctArr);
            $correct = implode(",", $correctArr);

            if ($ans === $correct) {
                $score += 15;
            }
        }
    }
}

$result = ($score >= 700) ? "PASS" : "FAIL";
$submitted_at = date("Y-m-d H:i:s");

/* STORE RESULT WITH ATTEMPT */
mysqli_query($conn,
    "INSERT INTO results 
     (student_id, score, result, attempt_no, started_at, submitted_at)
     VALUES 
     ('$student_id','$score','$result','$attempt_no',
      '$started_at','$submitted_at')");

header("Location: result.php?attempt=$attempt_no");
exit();
?>
