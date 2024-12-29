<?php
// Start output buffering
ob_start();

// Start the session
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "sha1";
$dbname = "store"; 

// Error log file path
$error_log_file = 'logerrors.txt';

// Function to log errors to a file
function log_error($message) {
    global $error_log_file;
    $timestamp = date('Y-m-d H:i:s');
    $error_message = "$timestamp - $message\n";
    file_put_contents($error_log_file, $error_message, FILE_APPEND);
}

// Create connection
try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Handle registration
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve and sanitize input
        $firstname = strip_tags($_POST['firstname']);
        $lastname = strip_tags($_POST['lastname']);
        $email = strip_tags($_POST['email']);
        $username = strip_tags($_POST['username']);
        $province = strip_tags($_POST['province']); // Ensure this field is included
        $password = strip_tags($_POST['password']);
        $hashed_password = sha1($password);

        // Prepare SQL statement
        $sql = "INSERT INTO users (firstname, lastname, email, username, province, password) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        // Bind parameters
        $stmt->bind_param('ssssss', $firstname, $lastname, $email, $username, $province, $hashed_password);

        // Execute statement
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }

        echo "Registration successful!";
        $stmt->close();
    }

    $conn->close();

} catch (Exception $e) {
    // Log the error message
    log_error($e->getMessage());
    // Display a user-friendly message
    echo "<p>Sorry, an error occurred. Please try again later.</p>";
}

// End output buffering and flush output
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://www.google.com/recaptcha/api.js?render=6LcCUUsqAAAAANcKyW7XAJRReWTlavRRX_NortBd"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        #registrationForm {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <form action="register.php" method="post" id="registrationForm">
        <div class="form-group">
            <label for="firstName">First Name:</label>
            <input type="text" id="firstName" name="firstName" required>
        </div>
        
        <div class="form-group">
            <label for="lastName">Last Name:</label>
            <input type="text" id="lastName" name="lastName" required>
        </div>
        
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <div class="form-group">
            <label for="password2">Confirm Password:</label>
            <input type="password" id="password2" name="password2" required>
        </div>
        
        <div class="form-group">
            <label for="province">Province:</label>
            <select id="province" name="province" required>
                <option value="Ontario">Ontario</option>
                <option value="Alberta">Alberta</option>
                <!-- Add other provinces as needed -->
            </select>
        </div>
        
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label>
                <input type="checkbox" id="terms" name="terms" required>
                I agree to the terms and conditions
            </label>
        </div>

        <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
        <input type="submit" value="Register">
    </form>

    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('6LcCUUsqAAAAANcKyW7XAJRReWTlavRRX_NortBd', { action: 'register' }).then(function(token) {
                document.getElementById('recaptchaResponse').value = token;
            });
        });
    </script>
</body>
</html>
