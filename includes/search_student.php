<?php
include '../config/db_connect.php';
include '../includes/header.php';

$filter = $_GET['filter'] ?? '';
$query = $_GET['query'] ?? '';

echo "<div class='student-list-wrapper'>";
echo "<h2>🔍 Search Results</h2>";

if ($filter && $query) {
    $sql = "SELECT * FROM students WHERE $filter LIKE ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["%$query%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($results) {
        echo "<table>
            <tr>
                <th>ID</th>
                <th>Photo</th>
                <th>Name</th>
                <th>Age</th>
                <th>Class</th>
                <th>Course</th>
                <th>Actions</th>
            </tr>";

        foreach ($results as $student) {
            echo "<tr>
                <td>{$student['id']}</td>
                <td><img src='../public/uploads/{$student['photo']}' alt='Student Photo'></td>
                <td>{$student['name']}</td>
                <td>{$student['age']}</td>
                <td>{$student['class']}</td>
                <td>{$student['course']}</td>
                <td class='actions'>
                    <a href='edit_student.php?id={$student['id']}'>✏️ Edit</a>
                    <a href='delete_student.php?id={$student['id']}' onclick=\"return confirm('Are you sure you want to delete this student?')\">🗑️ Delete</a>
                </td>
            </tr>";
        }

        echo "</table>";
    } else {
        echo "<p class='error-msg'>❌ No results found for '<strong>" . htmlspecialchars($query) . "</strong>'.</p>";
    }
} else {
    echo "<p class='error-msg'>❌ Invalid search input.</p>";
}

echo "<div class='actions'><a href='../admin/dashboard.php'>⬅ Back to Dashboard</a></div>";
echo "</div>"; // Fecha student-list-wrapper

include '../includes/footer.php';
