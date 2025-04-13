<?php
session_start();
include '../config/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    try {
        $stmt = $pdo->prepare("SELECT id, password FROM admins WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        // Comparando a senha informada com a armazenada diretamente (sem password_verify)
       // Comparando a senha informada com a armazenada com SHA-256
        if ($admin && hash('sha256', $password) === $admin['password']) {
            $_SESSION["admin_id"] = $admin["id"];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "❌ Invalid credentials!";
        }

    } catch (PDOException $e) {
        $error = "❌ Query failed: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../public/style.css">
    <style>
        body {
            background-color: #f0f4f8;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-box {
            background-color: #fff;
            padding: 40px;
            border-radius: 30px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 450px;
            width: 100%;
        }

        .login-box h2 {
            margin-bottom: 20px;
        }

        .login-box p {
            color: #555;
            margin-bottom: 25px;
        }

        .login-box input {
            width: 90%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 25px;
            font-size: 15px;
            box-sizing: border-box;
        }

        .login-box button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .login-box button:hover {
            background-color: #0056b3;
        }

        .forgot-password {
            margin-top: 15px;
            display: block;
            color: #007bff;
            font-size: 14px;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>🔐 Admin Login</h2>
    <p>Please enter your username and password to access the system.</p>

    <?php if (!empty($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>

    <a class="forgot-password" href="admin_reset_passw.php">Forgot your password?</a>
</div>

</body>
</html>
