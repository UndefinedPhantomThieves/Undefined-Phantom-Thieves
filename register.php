<?php
session_start();
include 'database/db.php';
include 'includes/functions.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (usernameExists($conn, $username)) {
        $error = "Username already exists.";
    } elseif (emailExists($conn, $email)) {
        $error = "Email already exists.";
    } else {
        $passwordHash = hashPassword($password);
        $token = bin2hex(random_bytes(32));

        $sql = "INSERT INTO users (username, email, password_hash, role, verify_token) 
                VALUES (?, ?, ?, 'BUYER', ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $passwordHash, $token);
        mysqli_stmt_execute($stmt);

        if (sendVerificationEmail($email, $username, $token)) {
            $success = "Registration successful! Please check your email to verify your account.";
        } else {
            $success = "Registration successful, but failed to send verification email.";
        }

        $user_id = mysqli_insert_id($conn);
    }
}
?>

<?php include 'includes/header.php'; ?>

<main class="register-container">
    <h2>Register</h2>

    <?php if (!empty($error)): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p style="color:green;"><?php echo $success; ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login here</a></p>
</main>

<?php include 'includes/footer.php'; ?>
