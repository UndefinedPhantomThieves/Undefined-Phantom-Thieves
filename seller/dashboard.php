<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SESSION['role'] !== 'SELLER') {
    if ($_SESSION['role'] === 'ADMIN') {
        header("Location: ../admin/dashboard.php");
    } else {
        header("Location: ../buyer/dashboard.php");
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard | Office Equipment Store</title>
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
        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .notice {
            background: #fff3cd;
            border: 1px solid #ffe69c;
            color: #664d03;
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 700;
        }
        .top-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }
        .top-actions h2 {
            font-size: 22px;
        }
        .btn {
            display: inline-block;
            background-color: #8b1e23;
            color: #fff;
            text-decoration: none;
            padding: 10px 25px;
            font-weight: bold;
            font-size: 12px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #a7242a;
        }
        .btn-dark {
            background: #222;
        }
        .btn-dark:hover {
            background: #444;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }
        .card {
            background-color: #1a1a1a;
            border-radius: 8px;
            overflow: hidden;
            position: relative;
            height: 400px;
        }
        .card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .card-body {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0,0,0,0.95) 60%);
            padding: 30px 20px 20px 20px;
            text-align: center;
            color: #fff;
        }
        .card-body h2 {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .card-actions {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
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
        <h1>Seller Dashboard</h1>
    </div>

    <div class="container">
        <div class="notice">
            This seller page is for educational purposes only.
        </div>

        <div class="top-actions">
            <h2>My Products</h2>
            <a href="#" class="btn">[ADD NEW PRODUCT]</a>
        </div>

        <div class="grid">
            <div class="card">
                <img src="https://images.unsplash.com/photo-1595515106969-1ce29566ff1c?auto=format&fit=crop&q=80&w=600" alt="Desk">
                <div class="card-body">
                    <h2>[THE PRODUCTIVE SETUP]</h2>
                    <div class="card-actions">
                        <a href="#" class="btn">[EDIT]</a>
                        <a href="#" class="btn btn-dark">[DELETE]</a>
                    </div>
                </div>
            </div>

            <div class="card">
                <img src="https://images.unsplash.com/photo-1580481072645-022f9a6dbf27?auto=format&fit=crop&q=80&w=600" alt="Chair">
                <div class="card-body">
                    <h2>[THE ERGONOMIC SUITE]</h2>
                    <div class="card-actions">
                        <a href="#" class="btn">[EDIT]</a>
                        <a href="#" class="btn btn-dark">[DELETE]</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-note">
        Phantom Store | Seller Dashboard | Educational Project Only
    </div>

</body>
</html>