<?php
session_start();
include 'database/db.php';
include 'includes/functions.php';

if (isset($_SESSION['user_id'])) {
    logActivity($conn, $_SESSION['user_id'], "Logged out");
}

session_unset();
session_destroy();

header("Location: index.php");
exit();
?>
