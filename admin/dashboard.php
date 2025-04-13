<?php 
session_start();
if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php");
    exit();
}

include '../includes/header.php';
?>

<div class="content">
    <div class="dashboard-box">
        <h2>📊 Welcome to Admin Dashboard</h2>
        <p>Manage students, view records, and more!</p>

        <div class="search-student-container">
            <form action="../includes/search_student.php" method="GET" class="search-student-form">
                <div class="form-row">
                    <select name="filter" required>
                        <option value="">🔍 Search Student By</option>
                        <option value="id">By ID</option>
                        <option value="name">By Name</option>
                        <option value="class">By Class</option>
                        <option value="course">By Course</option>
                    </select>

                    <input type="text" name="query" placeholder="Enter value..." required>
                    <button type="submit">Search</button>
                </div>

                <div class="form-row">
                    <a href="../includes/add_student.php" class="btn-action">➕ Add Students</a>
                    <a href="../includes/students.php" class="btn-action">📋 View All Students</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
