<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$id = intval($_GET['id']);

$res = mysqli_query($conn,
    "SELECT file_name FROM study_materials WHERE id='$id'");
$row = mysqli_fetch_assoc($res);

if ($row) {

    unlink("../uploads/" . $row['file_name']);

    mysqli_query($conn,
        "DELETE FROM study_materials WHERE id='$id'");
}

header("Location: manage_materials.php");
exit();
?>
