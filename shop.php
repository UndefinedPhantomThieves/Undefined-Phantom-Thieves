<?php
session_start();
include 'database/db.php';
include 'includes/header.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$message = '';
if (isset($_GET['add'])) {
    $product_id = (int) $_GET['add'];

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]++;
    } else {
        $_SESSION['cart'][$product_id] = 1;
    }

    $message = "Item added to cart!";
}

$sql = "SELECT * FROM inventory"; 
$result = mysqli_query($conn, $sql);
?>

<section class="shop-center">
    <h2>Office Furniture Collection</h2>
    <p>Browse our items below:</p>
</section>

<?php if (!empty($message)): ?>
    <p style="color:green;"><?php echo $message; ?></p>
<?php endif; ?>

<div class="shop-container">
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="product-card">
            <h3><?php echo htmlspecialchars($row['product_name']); ?></h3>
            
            <img src="assets/images/products/<?php echo htmlspecialchars($row['image']); ?>" 
                 alt="<?php echo htmlspecialchars($row['product_name']); ?>" 
                 class="product-image" style="max-width:200px; height:auto;">
            
            <p><?php echo htmlspecialchars($row['description']); ?></p>
            <p>₱<?php echo number_format($row['price'], 2); ?></p>
            <p>Stock: <?php echo $row['stock_quantity']; ?></p>
            
            <form action="shop.php" method="GET">
                <input type="hidden" name="add" value="<?php echo $row['product_id']; ?>">
                <button type="submit" class="btn-cart">Add to Cart</button>
            </form>

        </div>
    <?php endwhile; ?>
</div>

<?php include 'includes/footer.php'; ?>
