<?php
include '../config/db_connect.php';
include '../includes/header.php'; 

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $pdo->prepare("SELECT photo FROM students WHERE id = ?");
    $stmt->execute([$id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($student && !empty($student['photo'])) {
        $photo_path = "../public/uploads/" . $student['photo'];
        if (file_exists($photo_path)) {
            unlink($photo_path);  
        }
    }

    $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
    if ($stmt->execute([$id])) {
        header("Location: students.php");
        exit();
    } else {
        echo "<p style='color: red;'>❌ Failed to delete student.</p>";
    }

} else {
    echo "<p style='color: red;'>❌ Student ID not found!</p>";
}

include '../includes/footer.php';  
