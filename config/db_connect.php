<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$port = '3307'; 
$db = 'student_db';
$user = 'user_php';
$pass = '123456*';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "✅ Successfully connected to the database!";
} catch (PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage();
}
?>
