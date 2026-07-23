<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$current_page = basename($_SERVER['PHP_SELF']);
$admin_pages = ['dashboard.php', 'add.php', 'inventory.php', 'log.php', 'seller.php'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phantom Office Furniture</title>
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/style.css">
</head>
<body>

<header>
    <div class="header-container">

        <div class="header-section">
            <h1>Phantom Store</h1>
        </div>

        <nav>
            <a href="<?php echo $base_url; ?>/index.php">Home</a>
            <a href="<?php echo $base_url; ?>/shop.php">Shop</a>
            <a href="<?php echo $base_url; ?>/about.php">About</a>

            <?php if (isset($_SESSION['role'])): ?>
                <a href="<?php echo $base_url; ?>/cart.php">Cart</a>
            <?php endif; ?>

            <?php if (!isset($_SESSION['role'])): ?>
                <a href="<?php echo $base_url; ?>/login.php">Login</a>
            <?php endif; ?>

            <?php if (
                isset($_SESSION['role']) &&
                ($_SESSION['role'] === 'ADMIN' || $_SESSION['role'] === 'SELLER') &&
                !in_array($current_page, $admin_pages)
            ): ?>
                <a href="<?php echo $base_url; ?>/admin/dashboard.php">Dashboard</a>
            <?php endif; ?>

            <?php if (isset($_SESSION['role'])): ?>
                <a href="<?php echo $base_url; ?>/logout.php">Logout</a>
            <?php endif; ?>
        </nav>

    </div>
</header>


<main>
