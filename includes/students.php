<?php
include '../config/db_connect.php';
include '../includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student List</title>
    <link rel="stylesheet" href="../public/style.css">
    <style>
        body {
            background-color: #f0f4f8;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;   
            height: 100vh;
        }

        .content {
            flex: 1;   
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 20px;
        }

        .student-list-box {
            background-color: #fff;
            padding: 40px;
            border-radius: 30px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 100%;
            width: 100%;
            box-sizing: border-box;
        }

        .student-list-box h2 {
            margin-bottom: 20px;
            font-size: 28px;
        }

        .student-list-box p {
            color: #555;
            margin-bottom: 25px;
            font-size: 16px;
        }

        .student-list-box .nav-links a {
            display: inline-block;
            margin: 10px 0;   
            padding: 12px 30px;
            background-color: #007bff;
            color: white;
            border-radius: 25px;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .student-list-box .nav-links a:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #aaa;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        img {
            max-width: 80px;
            height: auto;
        }

        .actions a {
            display: inline-block;
            margin: 5px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border-radius: 25px;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .actions a:hover {
            background-color: #0056b3;
        }

 
    </style>
</head>
<body>

<div class="content">
    <div class="student-list-box">
        <h2>📋 Student List</h2>
        <p>View and manage students.</p>

        <div class="nav-links">
            <a href="add_student.php">➕ Add Student</a>
        </div>

        <table>
            <tr>
                <th>ID</th>
                <th>Photo</th>
                <th>Name</th>
                <th>Age</th>
                <th>Class</th>
                <th>Course</th>
                <th>Actions</th>
            </tr>

            <?php
            $result = $pdo->query("
                SELECT s.*, c.course_name 
                FROM students s
                LEFT JOIN courses c ON s.course = c.id
                ORDER BY s.id ASC
            ");
        
            $students = $result->fetchAll(PDO::FETCH_ASSOC);

            if (count($students) > 0) {
                foreach ($students as $row) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td><img src='../public/uploads/{$row['photo']}' alt='Student Photo'></td>
                        <td>{$row['name']}</td>
                        <td>{$row['age']}</td>
                        <td>{$row['class']}</td>
                        <td>{$row['course_name']}</td>
                        <td class='actions'>
                            <a href='../includes/edit_student.php?id={$row['id']}'>✏️ Edit</a>
                            <a href='../includes/delete_student.php?id={$row['id']}' onclick=\"return confirm('Are you sure you want to delete this student?')\">🗑️ Delete</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No students found.</td></tr>";
            }
            ?>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>


</body>
</html>

 
