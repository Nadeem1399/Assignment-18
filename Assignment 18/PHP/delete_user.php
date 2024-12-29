<?php
include 'db_connect.php'; // Ensure the database connection is included

// Check if delid is set
$id = $_GET['delid'] ?? '';

if ($id) {
    try {
        // Prepare and execute SQL statement to delete user
        $stmt = $pdo->prepare("DELETE FROM users WHERE ID = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "User deleted successfully.";
        } else {
            echo "Error deleting user.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "No user ID provided.";
}
?>

