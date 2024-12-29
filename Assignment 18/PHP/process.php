<?php
// Initialize variables and error messages
$errors = [];
$data = [];

// Retrieve form data and validate
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$firstName = isset($_POST['firstName']) ? trim($_POST['firstName']) : '';
$lastName = isset($_POST['lastName']) ? trim($_POST['lastName']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';
$confirmPassword = isset($_POST['confirmPassword']) ? trim($_POST['confirmPassword']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$province = isset($_POST['province']) ? trim($_POST['province']) : '';
$acceptTerms = isset($_POST['acceptTerms']) ? true : false;

// Validate required fields
if (empty($username)) $errors[] = 'Username is required.';
if (empty($firstName)) $errors[] = 'First name is required.';
if (empty($lastName)) $errors[] = 'Last name is required.';
if (empty($password)) $errors[] = 'Password is required.';
if (empty($confirmPassword)) $errors[] = 'Confirm password is required.';
if (empty($email)) $errors[] = 'Email address is required.';
if (empty($province)) $errors[] = 'Province is required.';
if (!$acceptTerms) $errors[] = 'You must accept the terms and conditions.';

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email format.';

// Validate password confirmation
if ($password !== $confirmPassword) $errors[] = 'Passwords do not match.';

// Check for errors
if (!empty($errors)) {
    // Display errors
    foreach ($errors as $error) {
        echo "<p>$error</p>";
    }
} else {
    // Display form results
    echo "Username: $username<br>";
    echo "Name: $firstName $lastName<br>";
    echo "Password: $password<br>";
    echo "Email: $email<br>";
    echo "Province: $province<br>";
    echo "Accept Terms: " . ($acceptTerms ? 'True' : 'False') . "<br>";
}
?>
