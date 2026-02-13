<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$id = intval($_GET['id']);

/* UPDATE STUDENT */
if (isset($_POST['update'])) {

    $name  = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    if (!empty($password)) {

        // Hash new password
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        mysqli_query($conn,
            "UPDATE students 
             SET name='$name', 
                 email='$email', 
                 phone='$phone', 
                 password='$hashed'
             WHERE id='$id'");
    } else {

        // Keep old password
        mysqli_query($conn,
            "UPDATE students 
             SET name='$name', 
                 email='$email', 
                 phone='$phone'
             WHERE id='$id'");
    }

    header("Location: manage_students.php");
    exit();
}

/* FETCH STUDENT */
$result = mysqli_query($conn,
    "SELECT * FROM students WHERE id='$id'");
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Student</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="container">
<h2>Edit Student</h2>

<form method="post">

    <input type="text" name="name"
           value="<?php echo htmlspecialchars($row['name']); ?>" required>

    <input type="email" name="email"
           value="<?php echo htmlspecialchars($row['email']); ?>" required>

    <input type="text" name="phone"
           value="<?php echo htmlspecialchars($row['phone']); ?>" required>

    <!-- New Password Field -->
    <input type="password" name="password"
           placeholder="New Password (leave empty to keep old)">

    <button name="update">Update</button>

</form>

<br>
<a href="manage_students.php" class="btn-cancel">Cancel</a>

</div>
</body>
</html>
