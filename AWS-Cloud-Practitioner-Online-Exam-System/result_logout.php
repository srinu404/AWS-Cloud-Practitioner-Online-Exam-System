<?php
session_start();
unset($_SESSION['result_user']);
header("Location: view_result_login.php");
exit();
