<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<?php include 'includes/header.php'; ?>

<main>
    <section class="home-container">
        <div class="home-overlay">
            <h2>DESIGN YOUR PERFECT WORKSPACE</h2>
            <h3>The Productive Setup</h3>
            <p>Modern workspace bundle designed for efficiency, comfort, and style.</p>
            <a href="shop.php" class="btn">SHOP NOW</a>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
