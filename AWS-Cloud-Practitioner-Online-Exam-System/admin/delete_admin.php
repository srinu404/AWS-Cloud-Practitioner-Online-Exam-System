<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$id = intval($_GET['id']);

$res = mysqli_query($conn,
    "SELECT is_default FROM admins WHERE id='$id'");
$row = mysqli_fetch_assoc($res);

if ($row && $row['is_default'] == 0) {
    mysqli_query($conn,
        "DELETE FROM admins WHERE id='$id'");
}

header("Location: manage_admins.php");
exit();
