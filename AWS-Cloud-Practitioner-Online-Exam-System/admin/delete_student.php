<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$id = intval($_GET['id']);

/* DELETE STUDENT */
mysqli_query($conn,
    "DELETE FROM students WHERE id='$id'");

header("Location: manage_students.php");
exit();
