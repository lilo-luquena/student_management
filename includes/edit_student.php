<?php
include '../config/db_connect.php';
include '../includes/header.php';

// check if student ID is provided
if (!isset($_GET['id'])) {
    echo "<p class='error-msg'>❌ No student selected.</p>";
    include '../includes/footer.php';
    exit();
}

$id = $_GET['id'];

// fetch student data from the database
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

// show error if student is not found
if (!$student) {
    echo "<p class='error-msg'>❌ Student not found.</p>";
    include '../includes/footer.php';
    exit();
}

// fetch courses for dropdown
$courses = [];
try {
    $stmt = $pdo->query("SELECT id, course_name FROM courses");
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p class='error-msg'>❌ Failed to load courses: " . $e->getMessage() . "</p>";
}

// handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $age = $_POST["age"];
    $class = $_POST["class"];
    $course = $_POST["course"];
    $photo_sql = "";
    $params = [$name, $age, $class, $course];

    if (!empty($_FILES['photo']['name'])) {
        $photo = $_FILES["photo"];
        $target_dir = "../public/uploads/";
        $photo_name = uniqid() . "_" . basename($photo["name"]);
        $target_file = $target_dir . $photo_name;

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        if (move_uploaded_file($photo["tmp_name"], $target_file)) {
            $photo_sql = ", photo = ?";
            $params[] = $photo_name;
        } else {
            echo "<p class='error-msg'>❌ Failed to upload new photo.</p>";
        }
    }

    $params[] = $id;

    $update_sql = "UPDATE students SET name = ?, age = ?, class = ?, course = ? $photo_sql WHERE id = ?";
    $stmt = $pdo->prepare($update_sql);

    if ($stmt->execute($params)) {
        header("Location: students.php");
        exit();
    } else {
        echo "<p class='error-msg'>❌ Error updating student.</p>";
    }
}
?>

<div class="form-wrapper">
    <h2>Edit Student</h2>

    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" value="<?= htmlspecialchars($student['name']) ?>" placeholder="Name" required>
        <input type="number" name="age" value="<?= htmlspecialchars($student['age']) ?>" placeholder="Age" required>
        <input type="text" name="class" value="<?= htmlspecialchars($student['class']) ?>" placeholder="Class" required>

        <!-- ✅ Trocar input por select, mantendo visual -->
        <select name="course" required>
            <option value="">-- Select a course --</option>
            <?php foreach ($courses as $course): ?>
                <option value="<?= $course['id'] ?>" <?= ($student['course'] == $course['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($course['course_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <?php if (!empty($student['photo'])): ?>
            <img src="../public/uploads/<?= htmlspecialchars($student['photo']) ?>" alt="Student Photo">
        <?php endif; ?>

        <input type="file" name="photo" accept="image/*">

        <div class="form-actions">
            <button type="submit">Update</button>
            <a href="students.php">
                <button type="button">Cancel</button>
            </a>
        </div>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
