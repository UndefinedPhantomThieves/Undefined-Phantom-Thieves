<?php
session_start();
include 'database/db.php';
include 'includes/header.php';

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}


if (isset($_GET['add'])) {
    $product_id = (int) $_GET['add'];
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]++;
    } else {
        $_SESSION['cart'][$product_id] = 1;
    }
}

if (isset($_GET['remove'])) {
    $product_id = (int) $_GET['remove'];
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
}

$cart_items = [];
if (!empty($_SESSION['cart'])) {
    $ids = implode(',', array_keys($_SESSION['cart']));
    $sql = "SELECT * FROM inventory WHERE product_id IN ($ids)";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $row['quantity'] = $_SESSION['cart'][$row['product_id']];
        $row['subtotal'] = $row['price'] * $row['quantity'];
        $cart_items[] = $row;
    }
}
?>

<main class="cart-container">
    <h2>Your Shopping Cart</h2>

    <?php if (empty($cart_items)): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <table border="1" cellpadding="8">
            <tr>
                <th>Product</th><th>Price</th><th>Quantity</th><th>Subtotal</th><th>Action</th>
            </tr>
            <?php $total = 0; ?>
            <?php foreach ($cart_items as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                    <td>₱<?php echo number_format($item['price'], 2); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>₱<?php echo number_format($item['subtotal'], 2); ?></td>
                    <td>
                        <a href="cart.php?remove=<?php echo $item['product_id']; ?>"
                           onclick="return confirm('Remove this item?');">Remove</a>
                    </td>
                </tr>
                <?php $total += $item['subtotal']; ?>
            <?php endforeach; ?>
            <tr>
                <td colspan="3"><strong>Total</strong></td>
                <td colspan="2">₱<?php echo number_format($total, 2); ?></td>
            </tr>
        </table>

        <a href="shop.php">← Continue Shopping</a>

        <form action="payment.php" method="POST" style="margin-top:15px;">
            <?php foreach ($_SESSION['cart'] as $product_id => $quantity): ?>
                <input type="hidden" name="cart[<?php echo $product_id; ?>]" value="<?php echo $quantity; ?>">
            <?php endforeach; ?>
            <button type="submit" class="btn-purchase">Proceed to Purchase</button>
        </form>
    <?php endif; ?>

</main>

<?php include 'includes/footer.php'; ?>