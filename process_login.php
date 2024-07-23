<?php
session_start();
include 'db.php'; // Include database connection file

$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email address";
    }

    // Validate password
    if (empty($password)) {
        $errors['password'] = "Password is required";
    }

    if (empty($errors)) {
        // Prepare SQL statement to fetch user data
        $sql = "SELECT users.id, users.email, users.first_name, users.middle_name, users.last_name, users.family_name, users.password, roles.role_name 
                FROM users 
                JOIN roles ON users.role_id = roles.id 
                WHERE users.email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify password
            if (password_verify($password, $user['password'])) {
                $_SESSION['id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['name'] = $user['first_name'] . " " . $user['middle_name'] . " " . $user['last_name'];
                $_SESSION['role'] = $user['role_name'];

                if ($user['role_name'] == 'admin') {
                    header("Location: admin_dashboard.php");
                    exit();
                } else {
                    header("Location: welcome.php");
                    exit();
                }
            } else {
                $errors['login'] = "Incorrect password";
            }
        } else {
            $errors['login'] = "Email not found";
        }
    }

    // Store errors in session to display on the form
    $_SESSION['errors'] = $errors;
    $_SESSION['form_data'] = $_POST;
    header("Location: login.php");
    exit();
}
?>
