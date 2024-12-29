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

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle logout
if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    // Unset session variables
    session_unset();
    // Destroy the session
    session_destroy();
    // Redirect to login page
    header("Location: login.php");
    exit();
}

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize input
    $username = strip_tags($_POST['username']);
    $password = strip_tags($_POST['password']);
    $hashed_password = sha1($password);

    // Prepare SQL statement
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $username, $hashed_password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        // Set session variable
        $_SESSION['loggedin'] = true;
        // Redirect to another page after login
        header("Location: welcome.php"); // Redirect to a welcome page or dashboard
        exit();
    } else {
        $error_message = "Invalid username or password";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <?php
    // Display error message if there is any
    if (isset($error_message)) {
        echo "<p>$error_message</p>";
    }
    ?>

    <?php
    // Check if user is logged in
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        echo '<a href="login.php?logout=true">Logout</a>';
    } else {
    ?>
    <form action="login.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        
        <input type="submit" value="Login">
    </form>
    <?php } ?>
</body>
</html>
