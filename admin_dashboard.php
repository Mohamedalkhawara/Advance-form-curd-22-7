<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Fetch all users from the database
$sql = "SELECT users.id, users.email, users.first_name, users.middle_name, users.last_name, users.family_name, users.created_at, users.mobile, roles.role_name, users.profile_picture 
        FROM users 
        JOIN roles ON users.role_id = roles.id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>User Management</h2>
        <a href="logout.php" class="btn btn-danger mb-3">Logout</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Profile Picture</th>
                    <th>Full Name</th>
                    <th>Created At</th>
                    <th>Phone Number</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td>
                        <?php if (!empty($user['profile_picture'])) { ?>
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($user['profile_picture']); ?>" alt="Profile Picture" style="width: 50px; height: 50px;"/>
                        <?php } else { ?>
                            No Picture
                        <?php } ?>
                    </td>
                    <td><?php echo htmlspecialchars($user['first_name'] . " " . $user['middle_name'] . " " . $user['last_name'] . " " . $user['family_name']); ?></td>
                    <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                    <td><?php echo htmlspecialchars($user['mobile']); ?></td>
                    <td><?php echo htmlspecialchars($user['role_name']); ?></td>
                    <td>
                        <a href="view_user.php?id=<?php echo htmlspecialchars($user['id']); ?>" class="btn btn-info">View</a>
                        <a href="edit_user.php?id=<?php echo htmlspecialchars($user['id']); ?>" class="btn btn-warning">Edit</a>
                        <a href="delete_user.php?id=<?php echo htmlspecialchars($user['id']); ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php
$conn->close();
?>
