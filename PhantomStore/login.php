<?php
session_start();

// Database connection
$host = "localhost";
$dbname = "phantomdb";
$dbuser = "root";
$dbpass = "";

$error = "";

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

// If already logged in, redirect by role
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'ADMIN') {
        header("Location: admin/dashboard.php");
        exit();
    } elseif ($_SESSION['role'] === 'SELLER') {
        header("Location: seller/dashboard.php");
        exit();
    } elseif ($_SESSION['role'] === 'BUYER') {
        header("Location: buyer/dashboard.php");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $error = "Please enter both username and password.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if ($user['status'] !== 'ACTIVE') {
                $error = "This account is inactive.";
            } else {
                // Works for both plain-text demo passwords and hashed passwords
                $passwordMatches = password_verify($password, $user['password_hash']) || $password === $user['password_hash'];

                if ($passwordMatches) {
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role'] = $user['role'];

                    if ($user['role'] === 'ADMIN') {
                        header("Location: admin/dashboard.php");
                        exit();
                    } elseif ($user['role'] === 'SELLER') {
                        header("Location: seller/dashboard.php");
                        exit();
                    } else {
                        header("Location: buyer/dashboard.php");
                        exit();
                    }
                } else {
                    $error = "Invalid username or password.";
                }
            }
        } else {
            $error = "Invalid username or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Phantom Store</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f4f4;
            color: #111;
        }

        .topbar {
            background: #0b0b0b;
            color: #fff;
            padding: 18px 0;
            text-align: center;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .topbar a {
            color: #fff;
            text-decoration: none;
            margin: 0 28px;
            font-size: 18px;
            display: inline-block;
        }

        .hero {
            background: #8f1f24;
            color: #fff;
            text-align: center;
            padding: 42px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.15);
        }

        .hero h1 {
            font-size: 36px;
            letter-spacing: 1px;
            font-weight: 800;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 36px 20px 50px;
        }

        .card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .card-header {
            background: #111;
            color: #fff;
            padding: 18px 22px;
            font-size: 20px;
            font-weight: 800;
        }

        .card-body {
            padding: 22px;
        }

        .notice {
            background: #fff3cd;
            border: 1px solid #ffe69c;
            color: #664d03;
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-weight: 700;
            line-height: 1.5;
        }

        .error {
            background: #f8d7da;
            border: 1px solid #f1aeb5;
            color: #842029;
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-weight: 700;
        }

        .tag {
            display: inline-block;
            background: #111;
            color: #fff;
            padding: 8px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.5px;
            margin-bottom: 16px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        label {
            display: block;
            font-weight: 700;
            margin-bottom: 6px;
            font-size: 14px;
        }

        input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 15px;
            outline: none;
            background: #fff;
        }

        input:focus {
            border-color: #8f1f24;
            box-shadow: 0 0 0 3px rgba(143,31,36,0.12);
        }

        .btn {
            display: inline-block;
            width: 100%;
            background: #8f1f24;
            color: #fff;
            border: none;
            padding: 14px 18px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .btn:hover {
            background: #6f171b;
        }

        .small-note {
            margin-top: 12px;
            font-size: 13px;
            color: #666;
            line-height: 1.5;
        }

        .footer-note {
            text-align: center;
            padding: 24px 20px 36px;
            color: #555;
            font-size: 13px;
        }

        .links {
            margin-top: 18px;
            font-size: 14px;
        }

        .links a {
            color: #8f1f24;
            text-decoration: none;
            font-weight: 700;
        }

        @media (max-width: 900px) {
            .topbar a {
                margin: 0 12px;
                font-size: 15px;
            }

            .hero h1 {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>

    <div class="topbar">
        <a href="index.php">[HOME]</a>
        <a href="buyer/dashboard.php">[SHOP]</a>
        <a href="register.php">[REGISTER]</a>
    </div>

    <div class="hero">
        <h1>LOGIN</h1>
    </div>

    <div class="container">
        <div class="tag">PHANTOM STORE</div>

        <div class="notice">
            This login page is for educational purposes only.
            It is a school demo system and does not connect to a real commercial service.
        </div>

        <?php if ($error !== ""): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">Sign In</div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" required>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" required>
                    </div>

                    <button type="submit" class="btn">[LOGIN]</button>
                </form>

                <div class="links">
                    No account yet? <a href="register.php">Register here</a>.
                </div>

                <p class="small-note">
                    Demo roles used by this system: ADMIN, SELLER, and BUYER.
                </p>
            </div>
        </div>
    </div>

    <div class="footer-note">
        Phantom Store | Educational Project Only
    </div>

</body>
</html>