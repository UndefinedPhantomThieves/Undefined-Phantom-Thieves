<?php
session_start();

/*
    Demo cart data.
    Replace this with your actual cart session later.
*/
$cart = $_SESSION['cart'] ?? [
    [
        "name" => "Ergonomic Desk Chair",
        "qty" => 1,
        "price" => 2499.00
    ],
    [
        "name" => "Office Desk Lamp",
        "qty" => 2,
        "price" => 799.00
    ]
];

$subtotal = 0;

foreach ($cart as $item) {
    $subtotal += $item['qty'] * $item['price'];
}

$shipping = 0;
$total = $subtotal + $shipping;

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = "This checkout is for educational purposes only. No real order has been placed.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Checkout | Office Equipment Store</title>

    <!-- Link to CSS -->
    <link rel="stylesheet" href="asset/checkout.css">
</head>

<body>

    <div class="topbar">
        <a href="index.php">[HOME]</a>
        <a href="categories.php">[CATEGORIES]</a>
        <a href="about.php">[ABOUT US]</a>
    </div>

    <div class="hero">
        <h1>CHECKOUT</h1>
    </div>

    <div class="container">

        <div class="tag">
            EDUCATION ONLY DEMO
        </div>

        <div class="notice">
            This website is for educational purposes only.
            No payments will be processed and no orders will actually be placed.
            fUCK U nigga
        </div>

        <?php if ($message != "") { ?>
            <div class="success">
                <?php echo $message; ?>
            </div>
        <?php } ?>

        <div class="grid">

            <!-- Customer Information -->
            <div class="card">

                <div class="card-header">
                    Billing Details
                </div>

                <div class="card-body">

                    <form method="POST">

                        <div class="section-title">
                            Customer Information
                        </div>

                        <div class="form-row">

                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" name="firstname" required>
                            </div>

                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" name="lastname" required>
                            </div>

                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" required>
                        </div>

                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" name="phone" required>
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="address" required>
                        </div>

                        <div class="form-group">
                            <label>Order Notes</label>
                            <textarea name="notes"></textarea>
                        </div>

                        <button class="btn" type="submit">
                            [PLACE ORDER]
                        </button>

                        <p class="small-note">
                            Clicking this button will only display a confirmation message.
                            No purchase will be made.
                        </p>

                    </form>

                </div>

            </div>

            <!-- Order Summary -->
            <div class="card">

                <div class="card-header">
                    Order Summary
                </div>

                <div class="card-body">

                    <div class="section-title">
                        Items
                    </div>

                    <?php foreach ($cart as $item) { ?>

                        <div class="order-item">

                            <div>
                                <strong><?php echo $item['name']; ?></strong><br>
                                Qty: <?php echo $item['qty']; ?>
                            </div>

                            <div>
                                ₱<?php echo number_format($item['qty'] * $item['price'], 2); ?>
                            </div>

                        </div>

                    <?php } ?>

                    <div class="summary-box">

                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span>₱<?php echo number_format($subtotal,2); ?></span>
                        </div>

                        <div class="summary-row">
                            <span>Shipping</span>
                            <span>FREE</span>
                        </div>

                        <div class="summary-row total">
                            <span>Total</span>
                            <span>₱<?php echo number_format($total,2); ?></span>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="footer-note">
        Office Equipment Store | Educational Project Only
    </div>

</body>
</html>