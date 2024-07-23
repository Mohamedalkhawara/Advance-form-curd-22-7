<?php
session_start();
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : array();
$form_data = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : array();
session_unset(); // Clear session errors and form data
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .error-message {
            color: red;
            font-size: 0.9em;
        }
    </style>
    <script>
        function validateForm() {
            let isValid = true;

            // Clear all previous error messages
            document.querySelectorAll('.error-message').forEach(element => element.innerText = '');

            // Validate email
            const email = document.getElementById('email');
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailPattern.test(email.value)) {
                document.getElementById('email-error').innerText = 'Invalid email address';
                isValid = false;
            }

            // Validate password
            const password = document.getElementById('password');
            if (password.value.trim() === '') {
                document.getElementById('password-error').innerText = 'Password is required';
                isValid = false;
            }

            return isValid;
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <h2>Welcome Back! Please Login</h2>
        <form onsubmit="return validateForm()" action="process_login.php" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($form_data['email']) ? $form_data['email'] : ''; ?>" required>
                <div id="email-error" class="error-message"><?php echo isset($errors['email']) ? $errors['email'] : ''; ?></div>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <div id="password-error" class="error-message"><?php echo isset($errors['password']) ? $errors['password'] : ''; ?></div>
            </div>
            <div class="error-message"><?php echo isset($errors['login']) ? $errors['login'] : ''; ?></div>
            <button type="submit" class="btn btn-primary">Login</button>
            <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
        </form>
    </div>
</body>
</html>
