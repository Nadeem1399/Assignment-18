<?php
include 'db_connect.php'; // Ensure the database connection is included

// Check if editid is set
$id = $_GET['editid'] ?? '';

if ($id) {
    try {
        // Prepare and execute SQL statement to fetch user data
        $stmt = $pdo->prepare("SELECT * FROM users WHERE ID = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Display user data in a form for editing
            echo "<h2>Edit User</h2>";
            echo "<form action='update_process.php' method='post'>
                    <input type='hidden' name='id' value='{$user['ID']}'>
                    <label for='username'>Username:</label>
                    <input type='text' id='username' name='username' value='{$user['username']}' required><br>

                    <label for='firstname'>First Name:</label>
                    <input type='text' id='firstname' name='firstname' value='{$user['firstname']}' required><br>

                    <label for='lastname'>Last Name:</label>
                    <input type='text' id='lastname' name='lastname' value='{$user['lastname']}' required><br>

                    <label for='province'>Province:</label>
                    <select id='province' name='province' required>";
            
            // List of provinces
            $provinces = ['Ontario', 'Quebec', 'British Columbia', 'Alberta', 'Manitoba', 'Saskatchewan', 'Nova Scotia', 'New Brunswick', 'Prince Edward Island', 'Newfoundland and Labrador'];
            
            foreach ($provinces as $province) {
                $selected = ($user['province'] == $province) ? 'selected' : '';
                echo "<option value='$province' $selected>$province</option>";
            }
            
            echo "  </select><br>

                    <label for='email'>Email:</label>
                    <input type='email' id='email' name='email' value='{$user['email']}' required><br>

                    <input type='submit' value='Update'>
                  </form>";
        } else {
            echo "User not found.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "No user ID provided.";
}
?>
