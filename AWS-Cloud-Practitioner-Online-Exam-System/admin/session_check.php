<?php
// Auto-expire session on browser close
ini_set('session.cookie_lifetime', 0);
ini_set('session.gc_maxlifetime', 600); // 10 minutes

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Inactivity timeout
if (isset($_SESSION['last_activity']) &&
    (time() - $_SESSION['last_activity']) > 600) {

    session_unset();
    session_destroy();
    header("Location: admin_login.php?timeout=1");
    exit();
}

$_SESSION['last_activity'] = time();
