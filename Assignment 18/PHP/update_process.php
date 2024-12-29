<?php
include 'db_connect.php'; // Ensure the database connection is included

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $id = $_POST['id'];
    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $province = $_POST['province'];
    $email = $_POST['email'];

    try {
        // Prepare and execute SQL statement to update user data
        $stmt = $pdo->prepare("UPDATE users SET username = :username, firstname = :firstname, lastname = :lastname, province = :province, email = :email WHERE ID = :id");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':province', $province);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "User updated successfully.";
        } else {
            echo "Error updating user.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
