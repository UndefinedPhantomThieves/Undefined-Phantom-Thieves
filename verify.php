<?php
session_start();
include 'database/db.php';

$token = $_GET['token'] ?? '';

$message = '';

if (!empty($token)) {
    // Look up user by token
    $sql = "SELECT user_id FROM users WHERE verify_token = ? AND verified = 0";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $token);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $update = "UPDATE users SET verified = 1, verify_token = NULL WHERE user_id = ?";
        $stmt = mysqli_prepare($conn, $update);
        mysqli_stmt_bind_param($stmt, "i", $row['user_id']);
        mysqli_stmt_execute($stmt);

        $message = "Your account has been successfully verified! You can now log in.";
    } else {
        $message = "Invalid or expired verification link.";
    }
} else {
    $message = "No verification token provided.";
}
?>

<?php include 'includes/header.php'; ?>

<main class="verify-container">
    <h2>Email Verification</h2>
    <p><?php echo $message; ?></p>
    <p><a href="login.php">Go to Login</a></p>
</main>

<?php include 'includes/footer.php'; ?>
