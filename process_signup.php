<?php
session_start();
include 'db.php'; // Include database connection file

$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $family_name = $_POST['family_name'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $profile_picture = $_FILES['profile_picture']['tmp_name'];

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email address";
    }
    
    // Validate mobile
    if (!preg_match("/^[0-9]{10}$/", $mobile)) {
        $errors['mobile'] = "Invalid mobile number";
    }

    // Validate names
    if (empty($first_name)) {
        $errors['first_name'] = "First name is required";
    }
    if (empty($middle_name)) {
        $errors['middle_name'] = "Middle name is required";
    }
    if (empty($last_name)) {
        $errors['last_name'] = "Last name is required";
    }
    if (empty($family_name)) {
        $errors['family_name'] = "Family name is required";
    }

    // Validate password
    if (strlen($password) < 8 || !preg_match("/[A-Z]/", $password) || !preg_match("/[a-z]/", $password) || !preg_match("/[0-9]/", $password) || !preg_match("/[\W]/", $password) || preg_match("/\s/", $password)) {
        $errors['password'] = "Password must be at least 8 characters long and include an uppercase letter, a lowercase letter, a number, and a special character";
    }

    // Validate confirm password
    if ($password !== $confirm_password) {
        $errors['confirm_password'] = "Passwords do not match";
    }

    if (empty($errors)) {
        // Hash the password before storing it in the database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Default role_id for a new user
        $role_id_query = "SELECT id FROM roles WHERE role_name='user'";
        $stmt = $conn->prepare($role_id_query);
        $stmt->execute();
        $role_row = $stmt->fetch(PDO::FETCH_ASSOC);
        $role_id = $role_row['id'];

        // Read the profile picture file
        $profile_picture_data = file_get_contents($profile_picture);

        // Insert the user into the database
        $sql = "INSERT INTO users (email, mobile, first_name, middle_name, last_name, family_name, password, role_id, profile_picture) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt->execute([$email, $mobile, $first_name, $middle_name, $last_name, $family_name, $hashed_password, $role_id, $profile_picture_data])) {
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $first_name . " " . $middle_name . " " . $last_name;
            $_SESSION['role'] = 'user';
            header("Location: welcome.php");
            exit();
        } else {
            echo "Error in registration";
        }
    } else {
        // Store errors in session to display on the form
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
        header("Location: signup.php");
        exit();
    }
}
?>
