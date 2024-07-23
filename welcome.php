<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h1>
        <p>Your email: <?php echo htmlspecialchars($_SESSION['email']); ?></p>
        <p>This is a static welcome message.</p>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</body>
</html>
