<?php
session_start();
include "../config/db.php";

/* ADMIN LOGIN CHECK */
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$id = intval($_GET['id']);

/* FETCH ADMIN */
$res = mysqli_query($conn,
    "SELECT * FROM admins WHERE id='$id'");
$row = mysqli_fetch_assoc($res);

/* BLOCK EDIT IF DEFAULT ADMIN */
if ($row && $row['is_default'] == 1) {
    header("Location: manage_admins.php");
    exit();
}

/* UPDATE ADMIN */
if (isset($_POST['update'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($password)) {

        $hashed = password_hash($password, PASSWORD_DEFAULT);

        mysqli_query($conn,
            "UPDATE admins
             SET username='$username',
                 password='$hashed'
             WHERE id='$id'");
    } else {

        mysqli_query($conn,
            "UPDATE admins
             SET username='$username'
             WHERE id='$id'");
    }

    header("Location: manage_admins.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Admin</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="container">
<h2>Edit Admin</h2>

<form method="post">

<input type="text" name="username"
       value="<?php echo htmlspecialchars($row['username']); ?>"
       required>

<input type="password" name="password"
       placeholder="New Password (leave empty to keep old)">

<button name="update">Update</button>

</form>

<br>
<a href="manage_admins.php" class="btn-cancel">Cancel</a>

</div>

</body>
</html>
