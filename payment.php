<?php
session_start();
include 'database/db.php';
include 'includes/header.php';

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT username, email FROM users WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (isset($_POST['cart'])) {
    $_SESSION['checkout_cart'] = $_POST['cart'];
}
?>

<main class="payment-container">
    <div style="margin-bottom:15px;">
        <a href="cart.php" class="btn-return">← Return to Cart</a>
    </div>

    <h2>Checkout Information</h2>
    <p>Confirm your details before purchase:</p>

    <form action="receipt.php" method="POST">
        <label for="fullname">Full Name:</label><br>
        <input type="text" id="fullname" name="fullname" 
               value="<?php echo htmlspecialchars($user['username']); ?>" readonly><br><br>

        <label for="email">Email Address:</label><br>
        <input type="email" id="email" name="email" 
               value="<?php echo htmlspecialchars($user['email']); ?>" readonly><br><br>

        <label for="address">Shipping Address:</label><br>
        <textarea id="address" name="address" rows="3" required></textarea><br><br>

        <button type="submit" name="confirm">Confirm Purchase</button>
    </form>
</main>

<?php include 'includes/footer.php'; ?>
