<?php
session_start();

if (isset($_SESSION['admin_id'])) {
    header("Location: admin/dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="public/style.css">
    <style>
        body {
            background-color: #f0f4f8;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .welcome-box {
            background-color: white;
            padding: 40px;
            border-radius: 30px; 
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 500px;
        }

        .welcome-box h1 {
            margin-bottom: 20px;
            font-size: 28px;
            color: #333;
        }

        .welcome-box p {
            font-size: 16px;
            color: #555;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .welcome-box button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .welcome-box button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="welcome-box">
    <h1>🎓 Welcome to the Student Management System</h1>
    <p>
        This system allows administrators to manage student data efficiently.<br>
        Register students, update information, upload photos, and more!
    </p>
    <a href="admin/admin_login.php">
        <button>🔐 Login as Admin</button>
    </a>
</div>

</body>
</html>
