<?php
include 'db_connect.php'; // Ensure the database connection is included

try {
    // Prepare and execute SQL statement to fetch all users
    $stmt = $pdo->prepare("SELECT * FROM users");
    $stmt->execute();
    
    // Fetch all users
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($users) {
        // Display users in a table
        echo "<h2>Registered Users</h2>";
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Province</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>";

        foreach ($users as $user) {
            echo "<tr>
                    <td>{$user['ID']}</td>
                    <td>{$user['username']}</td>
                    <td>{$user['firstname']}</td>
                    <td>{$user['lastname']}</td>
                    <td>{$user['province']}</td>
                    <td>{$user['email']}</td>
                    <td>
                        <a href='edit_user.php?editid={$user['ID']}'>Edit</a> | 
                        <a href='delete_user.php?delid={$user['ID']}'>Delete</a>
                    </td>
                  </tr>";
        }
        
        echo "</table>";
    } else {
        echo "No users found.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
