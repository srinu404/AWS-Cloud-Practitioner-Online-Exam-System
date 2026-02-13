<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$id = $_GET['id'];

/* Delete related answers */
mysqli_query($conn,
    "DELETE FROM answers WHERE question_id='$id'");

/* Delete related options */
mysqli_query($conn,
    "DELETE FROM options WHERE question_id='$id'");

/* Delete question */
mysqli_query($conn,
    "DELETE FROM questions WHERE id='$id'");

header("Location: manage_questions.php");
exit();
