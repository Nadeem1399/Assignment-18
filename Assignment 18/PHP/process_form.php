<?php
include 'db.php'; // Include the database connection file

function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Initialize an array to store potential errors
$errors = [];
$success = false;

// Collect input data
$username = sanitize_input($_POST['username']);
$firstname = sanitize_input($_POST['firstname']);
$lastname = sanitize_input($_POST['lastname']);
$password = sanitize_input($_POST['password']);
$email = sanitize_input($_POST['email']);
$province = sanitize_input($_POST['province']);
$acceptTerms = isset($_POST['acceptTerms']) ? 'True' : 'False';

// Check for empty fields and validate email
if (empty($username)) { $errors['username'] = "Username is required."; }
if (empty($firstname)) { $errors['firstname'] = "First name is required."; }
if (empty($lastname)) { $errors['lastname'] = "Last name is required."; }
if (empty($password)) { $errors['password'] = "Password is required."; }
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors['email'] = "A valid email is required."; }
if (empty($province)) { $errors['province'] = "Province is required."; }
if ($acceptTerms == 'False') { $errors['acceptTerms'] = "You must accept the terms."; }

if (empty($errors)) {
    // Insert data into database if no errors
    $conn = getDB();
    $sql = "INSERT INTO users (username, firstname, lastname, password, province, email) VALUES (?, ?, ?, ?, ?, ?)";
    
    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username, $firstname, $lastname, password_hash($password, PASSWORD_DEFAULT), $province, $email]);
        $success = true;
    } catch (PDOException $e) {
        $errors['database'] = "Error inserting data: " . $e->getMessage();
    }
}

if (!$success || !empty($errors)) {
    // Output errors
    echo "Please correct the following errors:<br>";
    foreach ($errors as $key => $error) {
        echo $error . "<br>";
    }
} else {
    echo "Registration successful.<br>";
    echo "Username: $username<br>";
    echo "Name: $firstname $lastname<br>";
    echo "Email: $email<br>";
    echo "Province: $province<br>";
    echo "Accept Terms: $acceptTerms<br>";
}
?>
