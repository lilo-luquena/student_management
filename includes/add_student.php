<?php
include '../config/db_connect.php';
include '../includes/header.php';

// Fetch courses for the select list
$courses = [];
try {
    $stmt = $pdo->query("SELECT id, course_name FROM courses");
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p class='error-msg'>❌ Failed to load courses: " . $e->getMessage() . "</p>";
}

$studentAdded = false;
$studentData = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $age = $_POST["age"];
    $class = $_POST["class"];
    $course = $_POST["course_name"];

    $photo = $_FILES["photo"];
    $target_dir = "../public/uploads/";
    $photo_name = uniqid() . "_" . basename($photo["name"]);
    $target_file = $target_dir . $photo_name;

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (move_uploaded_file($photo["tmp_name"], $target_file)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO students (name, age, class, course, photo) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $age, $class, $course, $photo_name]);

            $last_id = $pdo->lastInsertId();
            $studentAdded = true;

             
            $stmt = $pdo->prepare("
                SELECT s.*, course_name AS course_name 
                FROM students s 
                LEFT JOIN courses c ON s.course = c.id 
                WHERE s.id = ?
            ");
            $stmt->execute([$last_id]);
            $studentData = $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo "<p class='error-msg'>❌ Error inserting student: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p class='error-msg'>❌ Failed to upload photo.</p>";
    }
}
?>

<div class="form-wrapper">
    <h2>Add New Student</h2>

    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Student Name" required>
        <input type="number" name="age" placeholder="Age" required>
        <input type="text" name="class" placeholder="Class" required>

        <select name="course_name" required>
            <option value="">-- Select a course --</option>
            <?php foreach ($courses as $course): ?>
                <option value="<?= $course['id'] ?>"><?= htmlspecialchars($course['course_name']) ?></option>
            <?php endforeach; ?>
        </select>

        <input type="file" name="photo" accept="image/*" required>

        <div class="form-actions" style="display: flex; justify-content: space-between; gap: 15px;">
            <button type="submit">Add Student</button>
            <a href="students.php"><button type="button">Cancel</button></a>
        </div>
    </form>

    <?php if ($studentAdded && $studentData): ?>
        <p class="success-msg">✅ Student added successfully!</p>

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
            <tr>
                <td><?= $studentData['id'] ?></td>
                <td><img src="../public/uploads/<?= htmlspecialchars($studentData['photo']) ?>" alt="Student Photo"></td>
                <td><?= htmlspecialchars($studentData['name']) ?></td>
                <td><?= htmlspecialchars($studentData['age']) ?></td>
                <td><?= htmlspecialchars($studentData['class']) ?></td>
                <td><?= htmlspecialchars($studentData['course_name']) ?></td>
                <td class="actions">
                    <a href="edit_student.php?id=<?= $studentData['id'] ?>">✏️ Edit</a>
                    <a href="delete_student.php?id=<?= $studentData['id'] ?>" onclick="return confirm('Are you sure you want to delete this student?')">🗑️ Delete</a>
                </td>
            </tr>
        </table>

        <div class="actions" style="margin-top: 20px;">
            <a href="add_student.php" class="btn-action">➕ Add Another Student</a>
            <a href="../admin/dashboard.php" class="btn-action">🏠 Back to Dashboard</a>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
