<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: view_feedback.php");
    exit();
}

$id = intval($_GET['id']);

/* Get PDF file */
$result = mysqli_query($conn,
    "SELECT pdf_file FROM contact_messages WHERE id='$id'");

$row = mysqli_fetch_assoc($result);

if ($row) {

    if (!empty($row['pdf_file'])) {

        $filePath = "../uploads/" . $row['pdf_file'];

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    mysqli_query($conn,
        "DELETE FROM contact_messages WHERE id='$id'");
}

header("Location: view_feedback.php");
exit();
