<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

if (!isset($_GET['id'])) {
    header("Location: admin_dashboard.php");
    exit();
}

$id = $_GET['id'];
$sql = "SELECT users.id, users.email, users.first_name, users.middle_name, users.last_name, users.family_name, users.created_at, users.mobile, roles.role_name, users.profile_picture 
        FROM users 
        JOIN roles ON users.role_id = roles.id 
        WHERE users.id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header("Location: admin_dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>View User</h2>
        <a href="admin_dashboard.php" class="btn btn-secondary mb-3">Back to Dashboard</a>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($user['first_name'] . " " . $user['middle_name'] . " " . $user['last_name'] . " " . $user['family_name']); ?></h5>
                <p class="card-text">Email: <?php echo htmlspecialchars($user['email']); ?></p>
                <p class="card-text">Mobile: <?php echo htmlspecialchars($user['mobile']); ?></p>
                <p class="card-text">Role: <?php echo htmlspecialchars($user['role_name']); ?></p>
                <p class="card-text">Created At: <?php echo htmlspecialchars($user['created_at']); ?></p>
                <?php if (!empty($user['profile_picture'])) { ?>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($user['profile_picture']); ?>" alt="Profile Picture" style="max-width: 200px; max-height: 200px;"/>
                <?php } else { ?>
                    <p class="card-text">No Profile Picture</p>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>
<?php
$conn->close();
?>
