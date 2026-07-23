<?php
session_start();
include '../database/db.php';
include '../includes/header.php';
include '../includes/functions.php';

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['ADMIN','SELLER'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id    = (int)$_POST['category_id'];
    $product_name   = trim($_POST['product_name']);
    $description    = trim($_POST['description']);
    $price          = (float)$_POST['price'];
    $stock_quantity = (int)$_POST['stock_quantity'];

    $image = null;
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "../assets/images/products/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $image = basename($_FILES['image']['name']);
        $targetFile = $targetDir . $image;

        try {
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                throw new Exception("Failed to upload image.");
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

    if (empty($error)) {
        $sql = "INSERT INTO inventory (category_id, product_name, description, price, stock_quantity, image)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "issdis", $category_id, $product_name, $description, $price, $stock_quantity, $image);

        if (mysqli_stmt_execute($stmt)) {
            $success = "Product added successfully!";

            // Record in audit logs
            $activity = "Added new product: $product_name (Category ID: $category_id, Price: $price, Stock: $stock_quantity)";
            logActivity($conn, $_SESSION['user_id'], $activity);
        }
    }
}

$categories = mysqli_query($conn, "SELECT * FROM categories");
?>

<main class="admin-container add-product">
    <div class="top-nav">
        <a href="inventory.php">← Back to Inventory</a>
    </div>

    <h2>Add Product</h2>
    
    <?php if (!empty($error)): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p style="color:green;"><?php echo $success; ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <label>Category:</label>
        <select name="category_id" required>
            <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
                <option value="<?php echo $cat['category_id']; ?>">
                    <?php echo htmlspecialchars($cat['category_name']); ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <label>Product Name:</label>
        <input type="text" name="product_name" required><br><br>

        <label>Description:</label>
        <textarea name="description"></textarea><br><br>

        <label>Price (₱):</label>
        <input type="number" step="0.01" name="price" required><br><br>

        <label>Stock Quantity:</label>
        <input type="number" name="stock_quantity" required><br><br>

        <label>Image:</label>
        <input type="file" name="image" accept="image/*"><br><br>

        <button type="submit">Add Product</button>
    </form>
</main>

<?php include '../includes/footer.php'; ?>
