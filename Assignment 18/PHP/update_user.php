<?php
session_start();
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = "sha1"; // Your MySQL password
$dbname = "store"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_COOKIE['loggedin']) || $_COOKIE['loggedin'] !== 'true') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id']; // Ensure you have a way to get the user's ID
    $username = strip_tags($_POST['username']);
    $password = strip_tags($_POST['password']);
    $hashed_password = sha1($password);

    $stmt = $conn->prepare("UPDATE users SET username = ?, password = ? WHERE id = ?");
    $stmt->bind_param("ssi", $username, $hashed_password, $user_id);
    
    if ($stmt->execute()) {
        echo "User updated successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
</head>
<body>
    < action="update_user.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" id="updateEmail" name="updateEmail" required pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" title="Please enter a valid email address.">
        <br>
    
        <button type="submit">Update</button>
    </form>
</body>
</html>
