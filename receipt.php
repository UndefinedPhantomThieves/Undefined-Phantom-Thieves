<?php
session_start();
include 'database/db.php';
include 'includes/header.php';

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}

$buyer_name    = $_POST['fullname'] ?? '';
$buyer_email   = $_POST['email'] ?? '';
$buyer_address = $_POST['address'] ?? '';

$cart_items = [];
$total = 0;

if (isset($_POST['confirm']) && isset($_SESSION['checkout_cart'])) {
    $orderSql = "INSERT INTO orders (user_id, buyer_name, buyer_email, shipping_address, total_amount, created_at)
                 VALUES (?, ?, ?, ?, 0, NOW())";
    $orderStmt = mysqli_prepare($conn, $orderSql);
    mysqli_stmt_bind_param($orderStmt, "isss", $_SESSION['user_id'], $buyer_name, $buyer_email, $buyer_address);
    mysqli_stmt_execute($orderStmt);
    $order_id = mysqli_insert_id($conn);

    foreach ($_SESSION['checkout_cart'] as $product_id => $quantity) {
        $sql = "UPDATE inventory SET stock_quantity = stock_quantity - ? 
                WHERE product_id = ? AND stock_quantity >= ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iii", $quantity, $product_id, $quantity);
        mysqli_stmt_execute($stmt);

        $sql2 = "SELECT * FROM inventory WHERE product_id = ?";
        $stmt2 = mysqli_prepare($conn, $sql2);
        mysqli_stmt_bind_param($stmt2, "i", $product_id);
        mysqli_stmt_execute($stmt2);
        $result = mysqli_stmt_get_result($stmt2);
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $row['quantity'] = $quantity;
            $row['subtotal'] = $row['price'] * $quantity;
            $cart_items[] = $row;
            $total += $row['subtotal'];

            $itemSql = "INSERT INTO order_items (order_id, product_id, quantity, price, subtotal)
                        VALUES (?, ?, ?, ?, ?)";
            $itemStmt = mysqli_prepare($conn, $itemSql);
            mysqli_stmt_bind_param($itemStmt, "iiidd", $order_id, $product_id, $quantity, $row['price'], $row['subtotal']);
            mysqli_stmt_execute($itemStmt);
        }
    }

    $updateOrderSql = "UPDATE orders SET total_amount = ? WHERE order_id = ?";
    $updateOrderStmt = mysqli_prepare($conn, $updateOrderSql);
    mysqli_stmt_bind_param($updateOrderStmt, "di", $total, $order_id);
    mysqli_stmt_execute($updateOrderStmt);

    $_SESSION['cart'] = [];
    unset($_SESSION['checkout_cart']);
}
?>

<main class="receipt-container">
    <h2>Purchase Receipt</h2>

    <h3>Buyer Information</h3>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($buyer_name); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($buyer_email); ?></p>
    <p><strong>Address:</strong> <?php echo nl2br(htmlspecialchars($buyer_address)); ?></p>

    <h3>Order Summary</h3>
    <?php if (!empty($cart_items)): ?>
        <table border="1" cellpadding="8">
            <tr>
                <th>Product</th><th>Price</th><th>Quantity</th><th>Subtotal</th>
            </tr>
            <?php foreach ($cart_items as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                    <td>₱<?php echo number_format($item['price'], 2); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>₱<?php echo number_format($item['subtotal'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3"><strong>Total Spent</strong></td>
                <td><strong>₱<?php echo number_format($total, 2); ?></strong></td>
            </tr>
        </table>
    <?php else: ?>
        <p>No items found in your order.</p>
    <?php endif; ?>

    <h3>Thank You!</h3>
    <p>Thank you for shopping with Phantom Store. We appreciate your purchase!</p>

    <a href="shop.php">Return to Shop</a>
</main>

<?php include 'includes/footer.php'; ?>
