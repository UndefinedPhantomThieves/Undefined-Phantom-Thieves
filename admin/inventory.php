<?php
session_start();
include '../database/db.php';
include '../includes/header.php';
include '../includes/functions.php';

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['ADMIN','SELLER'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    $product_id     = (int)$_POST['product_id'];
    $price          = (float)$_POST['price'];
    $stock_quantity = (int)$_POST['stock_quantity'];

    $sql = "UPDATE inventory SET price = ?, stock_quantity = ? WHERE product_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "dii", $price, $stock_quantity, $product_id);
    if (mysqli_stmt_execute($stmt)) {
        logActivity($conn, $_SESSION['user_id'], "Updated product ID $product_id (Price: $price, Stock: $stock_quantity)");
    }
}

if (isset($_GET['delete'])) {
    $product_id = (int)$_GET['delete'];
    $sql = "DELETE FROM inventory WHERE product_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $product_id);
    if (mysqli_stmt_execute($stmt)) {
        logActivity($conn, $_SESSION['user_id'], "Deleted product ID $product_id");
    }
}

$result = mysqli_query($conn, "SELECT i.*, c.category_name 
                               FROM inventory i 
                               JOIN categories c ON i.category_id = c.category_id");
?>

<main class="admin-container inventory">
    <div class="top-nav">
        <a href="dashboard.php">Return to Dashboard</a>
    </div>

    <h2>Inventory</h2>
    <a href="add.php">Add Product</a><br><br>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <form method="POST">
                    <td><?php echo $row['product_id']; ?></td>
                    <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                    <td>
                        <input type="number" step="0.01" name="price" value="<?php echo $row['price']; ?>">
                    </td>
                    <td>
                        <input type="number" name="stock_quantity" value="<?php echo $row['stock_quantity']; ?>">
                    </td>
                    <td>
                        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                        <button type="submit" name="update_product">Update</button>
                        <a href="inventory.php?delete=<?php echo $row['product_id']; ?>" 
                           onclick="return confirm('Delete this product?');">Delete</a>
                    </td>
                </form>
            </tr>
        <?php endwhile; ?>
    </table>
</main>

<?php include '../includes/footer.php'; ?>
