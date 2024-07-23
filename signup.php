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
    <title>Sign Up</title>
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

            // Validate mobile
            const mobile = document.getElementById('mobile');
            const mobilePattern = /^[0-9]{10}$/;
            if (!mobilePattern.test(mobile.value)) {
                document.getElementById('mobile-error').innerText = 'Invalid mobile number';
                isValid = false;
            }

            // Validate first name
            const firstName = document.getElementById('first_name');
            if (firstName.value.trim() === '') {
                document.getElementById('first_name-error').innerText = 'First name is required';
                isValid = false;
            }

            // Validate middle name
            const middleName = document.getElementById('middle_name');
            if (middleName.value.trim() === '') {
                document.getElementById('middle_name-error').innerText = 'Middle name is required';
                isValid = false;
            }

            // Validate last name
            const lastName = document.getElementById('last_name');
            if (lastName.value.trim() === '') {
                document.getElementById('last_name-error').innerText = 'Last name is required';
                isValid = false;
            }

            // Validate family name
            const familyName = document.getElementById('family_name');
            if (familyName.value.trim() === '') {
                document.getElementById('family_name-error').innerText = 'Family name is required';
                isValid = false;
            }

            // Validate password
            const password = document.getElementById('password');
            const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\W]).{8,}$/;
            if (!passwordPattern.test(password.value)) {
                document.getElementById('password-error').innerText = 'Password must be at least 8 characters long and include an uppercase letter, a lowercase letter, a number, and a special character';
                isValid = false;
            }

            // Validate confirm password
            const confirmPassword = document.getElementById('confirm_password');
            if (password.value !== confirmPassword.value) {
                document.getElementById('confirm_password-error').innerText = 'Passwords do not match';
                isValid = false;
            }

            return isValid;
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <h2>Create an Account</h2>
        <form onsubmit="return validateForm()" action="process_signup.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($form_data['email']) ? $form_data['email'] : ''; ?>" required>
                <div id="email-error" class="error-message"><?php echo isset($errors['email']) ? $errors['email'] : ''; ?></div>
            </div>
            <div class="form-group">
                <label for="mobile">Mobile:</label>
                <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo isset($form_data['mobile']) ? $form_data['mobile'] : ''; ?>" required pattern="\d{10}">
                <div id="mobile-error" class="error-message"><?php echo isset($errors['mobile']) ? $errors['mobile'] : ''; ?></div>
            </div>
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo isset($form_data['first_name']) ? $form_data['first_name'] : ''; ?>" required>
                <div id="first_name-error" class="error-message"><?php echo isset($errors['first_name']) ? $errors['first_name'] : ''; ?></div>
            </div>
            <div class="form-group">
                <label for="middle_name">Middle Name:</label>
                <input type="text" class="form-control" id="middle_name" name="middle_name" value="<?php echo isset($form_data['middle_name']) ? $form_data['middle_name'] : ''; ?>" required>
                <div id="middle_name-error" class="error-message"><?php echo isset($errors['middle_name']) ? $errors['middle_name'] : ''; ?></div>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo isset($form_data['last_name']) ? $form_data['last_name'] : ''; ?>" required>
                <div id="last_name-error" class="error-message"><?php echo isset($errors['last_name']) ? $errors['last_name'] : ''; ?></div>
            </div>
            <div class="form-group">
                <label for="family_name">Family Name:</label>
                <input type="text" class="form-control" id="family_name" name="family_name" value="<?php echo isset($form_data['family_name']) ? $form_data['family_name'] : ''; ?>" required>
                <div id="family_name-error" class="error-message"><?php echo isset($errors['family_name']) ? $errors['family_name'] : ''; ?></div>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <div id="password-error" class="error-message"><?php echo isset($errors['password']) ? $errors['password'] : ''; ?></div>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                <div id="confirm_password-error" class="error-message"><?php echo isset($errors['confirm_password']) ? $errors['confirm_password'] : ''; ?></div>
            </div>
            <div class="form-group">
                <label for="profile_picture">Profile Picture:</label>
                <input type="file" class="form-control" id="profile_picture" name="profile_picture" required>
            </div>
            <button type="submit" class="btn btn-primary">Sign Up</button>
        </form>
    </div>
</body>
</html>
