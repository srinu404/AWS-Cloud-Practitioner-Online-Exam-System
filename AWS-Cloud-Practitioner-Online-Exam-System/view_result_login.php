<?php
session_start();
include "config/db.php";

$error = "";

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $res = mysqli_query($conn,
        "SELECT * FROM students WHERE email='$email'");
    $row = mysqli_fetch_assoc($res);

    if ($row && password_verify($password, $row['password'])) {
        $_SESSION['result_user'] = $row['id'];
        header("Location: view_result.php");
        exit();
    } else {
        $error = "Invalid login details";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>View Result Login</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <h2>View Exam Result</h2>

    <?php if ($error) { ?>
        <p style="color:red;text-align:center;"><?php echo $error; ?></p>
    <?php } ?>

    <form method="post">
        <input type="email" name="email" placeholder="Registered Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button name="login">View Result</button>
    </form>
</div>

</body>
</html>
