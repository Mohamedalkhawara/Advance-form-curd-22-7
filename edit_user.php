<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $family_name = $_POST['family_name'];
    $role_id = $_POST['role_id'];

    $sql = "UPDATE users SET email = ?, mobile = ?, first_name = ?, middle_name = ?, last_name = ?, family_name = ?, role_id = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute([$email, $mobile, $first_name, $middle_name, $last_name, $family_name, $role_id, $id])) {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Error updating record";
    }
} else {
    $id = $_GET['id'];
    $sql = "SELECT email, mobile, first_name, middle_name, last_name, family_name, role_id FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit User</h2>
        <form action="edit_user.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="mobile">Mobile:</label>
                <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo htmlspecialchars($user['mobile']); ?>" required pattern="\d{10}">
            </div>
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="middle_name">Middle Name:</label>
                <input type="text" class="form-control" id="middle_name" name="middle_name" value="<?php echo htmlspecialchars($user['middle_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="family_name">Family Name:</label>
                <input type="text" class="form-control" id="family_name" name="family_name" value="<?php echo htmlspecialchars($user['family_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="role_id">Role:</label>
                <select class="form-control" id="role_id" name="role_id">
                    <?php
                    // Fetch all roles from the database
                    $sql = "SELECT id, role_name FROM roles";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($roles as $role) {
                        echo "<option value='" . htmlspecialchars($role['id']) . "'";
                        if ($user['role_id'] == $role['id']) echo " selected";
                        echo ">" . htmlspecialchars($role['role_name']) . "</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
