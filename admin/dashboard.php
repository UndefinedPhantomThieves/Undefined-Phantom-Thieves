<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SESSION['role'] !== 'ADMIN') {
    if ($_SESSION['role'] === 'SELLER') {
        header("Location: ../seller/dashboard.php");
    } else {
        header("Location: ../buyer/dashboard.php");
    }
    exit();
}

// Database connection
$host = "localhost";
$dbname = "phantomdb";
$dbuser = "root";
$dbpass = "";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $dbuser,
        $dbpass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Database connection failed.");
}

// Get sellers and buyers
$sellerStmt = $pdo->prepare("SELECT user_id, username, email, status, created_at FROM users WHERE role = 'SELLER' ORDER BY user_id DESC");
$sellerStmt->execute();
$sellers = $sellerStmt->fetchAll(PDO::FETCH_ASSOC);

$buyerStmt = $pdo->prepare("SELECT user_id, username, email, status, created_at FROM users WHERE role = 'BUYER' ORDER BY user_id DESC");
$buyerStmt->execute();
$buyers = $buyerStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Phantom Store</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f5f5f5;
            color: #000;
        }

        header {
            background-color: #0b0b0b;
            padding: 20px;
            text-align: center;
        }

        header a {
            color: #ffffff;
            text-decoration: none;
            margin: 0 20px;
            font-weight: bold;
            font-size: 14px;
            letter-spacing: 1px;
        }

        header a:hover {
            color: #8b1e23;
        }

        .banner {
            background-color: #8b1e23;
            color: #fff;
            text-align: center;
            padding: 40px 20px;
        }

        .banner h1 {
            font-size: 28px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .banner p {
            margin-top: 10px;
            font-size: 14px;
            opacity: 0.95;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px 50px;
        }

        .notice {
            background: #fff3cd;
            border: 1px solid #ffe69c;
            color: #664d03;
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 700;
            line-height: 1.5;
        }

        .section {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
            overflow: hidden;
            margin-bottom: 25px;
        }

        .section h2 {
            background: #111;
            color: #fff;
            padding: 16px 20px;
            font-size: 18px;
            letter-spacing: 1px;
        }

        .section-content {
            padding: 20px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 700px;
        }

        th, td {
            padding: 12px 14px;
            text-align: left;
            border-bottom: 1px solid #e5e5e5;
            font-size: 14px;
        }

        th {
            background: #f8f8f8;
            font-weight: 800;
        }

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            background: #d1e7dd;
            color: #0f5132;
        }

        .footer-note {
            text-align: center;
            padding: 24px 20px 36px;
            color: #555;
            font-size: 13px;
        }
    </style>
</head>
<body>

    <header>
        <a href="dashboard.php">[HOME]</a>
        <a href="../buyer/dashboard.php">[BUYER VIEW]</a>
        <a href="../logout.php">[LOGOUT]</a>
    </header>

    <div class="banner">
        <h1>Admin Dashboard</h1>
        <p>View buyers and sellers only</p>
    </div>

    <div class="container">
        <div class="notice">
            This admin page is for educational purposes only. The admin role is view-only and is used to supervise buyers and sellers.
        </div>

        <div class="section">
            <h2>SELLERS</h2>
            <div class="section-content">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($sellers) > 0): ?>
                            <?php foreach ($sellers as $seller): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($seller['user_id']); ?></td>
                                    <td><?php echo htmlspecialchars($seller['username']); ?></td>
                                    <td><?php echo htmlspecialchars($seller['email']); ?></td>
                                    <td><span class="status"><?php echo htmlspecialchars($seller['status']); ?></span></td>
                                    <td><?php echo htmlspecialchars($seller['created_at']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">No sellers found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="section">
            <h2>BUYERS</h2>
            <div class="section-content">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($buyers) > 0): ?>
                            <?php foreach ($buyers as $buyer): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($buyer['user_id']); ?></td>
                                    <td><?php echo htmlspecialchars($buyer['username']); ?></td>
                                    <td><?php echo htmlspecialchars($buyer['email']); ?></td>
                                    <td><span class="status"><?php echo htmlspecialchars($buyer['status']); ?></span></td>
                                    <td><?php echo htmlspecialchars($buyer['created_at']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">No buyers found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="footer-note">
        Phantom Store | Admin Dashboard | Educational Project Only
    </div>

</body>
</html>