<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Office Equipment Store</title>
    <style>
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
            color: #ffffff;
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
        .text-page {
            text-align: center;
            padding: 40px;
            background: #ffffff;
            border-radius: 8px;
        }
    </style>
</head>
<body>

    <header>
        <a href="home.php">[HOME]</a>
        <a href="categories.php">[CATEGORIES]</a>
        <a href="about.php">[ABOUT US]</a>
    </header>

    <div class="banner">
        <h1>Design Your Perfect Workspace.</h1>
    </div>

    <div class="container">