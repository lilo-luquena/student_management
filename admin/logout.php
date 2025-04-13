<?php
session_start();
session_destroy();
include '../includes/header.php';
?>

<div class="form-wrapper">
    <h2>🚪 You have been logged out.</h2>
    <p>You will be redirected to the login page shortly...</p>
    <a href="admin_login.php">Click here if not redirected</a>
</div>

<script>
    setTimeout(() => {
        window.location.href = 'admin_login.php';
    }, 3000);
</script>

<?php include '../includes/footer.php'; ?>
