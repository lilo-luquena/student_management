<?php
include '../config/db_connect.php';

$success = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    if ($new_password !== $confirm_password) {
        $error = "❌ Passwords do not match!";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT id FROM admins WHERE username = ?");
            $stmt->execute([$username]);

            if ($stmt->rowCount() > 0) {
                $hashed_password = hash('sha256', $new_password);
                $update = $pdo->prepare("UPDATE admins SET password = ? WHERE username = ?");
                $update->execute([$hashed_password, $username]);
                $success = "✅ Password updated successfully!";
            } else {
                $error = "❌ Admin not found.";
            }
        } catch (PDOException $e) {
            $error = "❌ Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Admin Password</title>
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

        .reset-box {
            background-color: #fff;
            padding: 40px;
            border-radius: 30px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 450px;
            width: 100%;
        }

        .reset-box h2 {
            margin-bottom: 20px;
        }

        .reset-box input {
            width: 90%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 25px;
            font-size: 15px;
        }

        .reset-box button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
        }

        .reset-box button:hover {
            background-color: #218838;
        }

        .success {
            color: green;
            margin-bottom: 15px;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }

        a {
            display: block;
            margin-top: 15px;
            color: #007bff;
        }
    </style>
</head>
<body>

<div class="reset-box">
    <h2>🔁 Reset Admin Password</h2>

    <?php if (!empty($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="new_password" placeholder="New Password" required><br>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required><br>
        <button type="submit">Reset Password</button>
    </form>

    <a href="admin_login.php">⬅ Back to Login</a>
</div>

</body>
</html>
