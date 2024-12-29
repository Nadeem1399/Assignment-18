<?php
include 'db.php'; 

$conn = getDB();

if ($conn) {
    echo "Database connection successful!";
} else {
    echo "Failed to connect to the database.";
}
?>
