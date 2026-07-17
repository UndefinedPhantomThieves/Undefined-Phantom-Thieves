<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Office Equipment Store</title>
    <style>
        /* Base Colors & Setup */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #f5f5f5;
            color: #000000;
        }

        /* 1. Navigation Bar */
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

        /* 2. Red Banner */
        .banner {
            background-color: #8b1e23;
            color: #ffffff;
            text-align: center;
            padding: 40px 20px;
        }
        .banner h1 {
            font-size: 28px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* 3. Main Container & Product Grid */
        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        /* 4. Product Cards Layout */
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
            color: #ffffff;
        }
        .card-body h2 {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .btn {
            display: inline-block;
            background-color: #8b1e23;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 25px;
            font-weight: bold;
            font-size: 12px;
            border-radius: 4px;
            margin-top: 10px;
        }
        .btn:hover {
            background-color: #a7242a;
        }

        /* Simple text page style */
        .text-page {
            text-align: center;
            padding: 40px;
            background: #ffffff;
            border-radius: 8px;
        }
    </style>
</head>
<body>

    <!-- 1. Header Navigation -->
    <header>
        <a href="home.php">[HOME]</a>
        <a href="categories.php">[CATEGORIES]</a>
        <a href="about_us.php">[ABOUT US]</a>
    </header>

    <!-- 2. Red Heading Banner -->
    <div class="banner">
        <h1>Design Your Perfect Workspace.</h1>
    </div>

    <!-- 3. Dynamic Page Content Layout -->
    <div class="container">
        <?php
        // Get the current page from the URL, default to 'home' if empty
        $page = isset($_GET['page']) ? $_GET['page'] : 'home';

        // --- PAGE 1: HOME PAGE (Shows exactly 1 Desk and 1 Chair) ---
        if ($page == 'home') {
        ?>
            <div class="grid">
                <!-- Desk Product -->
                <div class="card">
                    <img src="https://images.unsplash.com/photo-1595515106969-1ce29566ff1c?auto=format&fit=crop&q=80&w=600" alt="Desk">
                    <div class="card-body">
                        <h2>[THE PRODUCTIVE SETUP]</h2>
                        <a href="#" class="btn">[SHOP BUNDLE]</a>
                    </div>
                </div>

                <!-- Chair Product -->
                <div class="card">
                    <img src="https://images.unsplash.com/photo-1580481072645-022f9a6dbf27?auto=format&fit=crop&q=80&w=600" alt="Chair">
                    <div class="card-body">
                        <h2>[THE ERGONOMIC SUITE]</h2>
                        <a href="#" class="btn">[SHOP BUNDLE]</a>
                    </div>
                </div>
            </div>
        <?php 
        } 
        // --- PAGE 2: CATEGORIES PAGE (Shows 2 Desks and 2 Chairs) ---
        elseif ($page == 'categories') {
        ?>
            <div class="grid">
                <!-- Desk 1 -->
                <div class="card">
                    <img src="https://images.unsplash.com/photo-1595515106969-1ce29566ff1c?auto=format&fit=crop&q=80&w=600" alt="Desk 1">
                    <div class="card-body">
                        <h2>[OFFICE DESK - MODEL A]</h2>
                        <a href="#" class="btn">[SHOP NOW]</a>
                    </div>
                </div>

                <!-- Desk 2 -->
                <div class="card">
                    <img src="https://images.unsplash.com/photo-1518455027359-f3f8164ba6bd?auto=format&fit=crop&q=80&w=600" alt="Desk 2">
                    <div class="card-body">
                        <h2>[EXECUTIVE DESK - MODEL B]</h2>
                        <a href="#" class="btn">[SHOP NOW]</a>
                    </div>
                </div>

                <!-- Chair 1 -->
                <div class="card">
                    <img src="https://images.unsplash.com/photo-1580481072645-022f9a6dbf27?auto=format&fit=crop&q=80&w=600" alt="Chair 1">
                    <div class="card-body">
                        <h2>[ERGONOMIC CHAIR - V1]</h2>
                        <a href="#" class="btn">[SHOP NOW]</a>
                    </div>
                </div>

                <!-- Chair 2 -->
                <div class="card">
                    <img src="https://images.unsplash.com/photo-1688574921106-cf7eb48cb7fa?auto=format&fit=crop&q=80&w=600" alt="Chair 2">
                    <div class="card-body">
                        <h2>[PREMIUM MESH CHAIR - V2]</h2>
                        <a href="#" class="btn">[SHOP NOW]</a>
                    </div>
                </div>
            </div>
        <?php 
        } 
        // --- PAGE 3: ABOUT US PAGE ---
        elseif ($page == 'about') {
        ?>
            <div class="text-page">
                <h2>About Us</h2>
                <p style="margin-top: 15px; color: #555;">We provide high-quality, professional office furniture designed to maximize comfort and productivity.</p>
            </div>
        <?php 
        } 
        ?>
    </div>

</body>
</html>