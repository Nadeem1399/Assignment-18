<?php
function getDB() {
    $host = 'localhost';   // or your host, if different
    $port = 3307;          
    $db_name = 'store';    // your database name
    $username = 'root'; // your database username
    $password = 'sha1'; // your database password

    try {
        // Notice the inclusion of the port number in the DSN
        $conn = new PDO("mysql:host=$host;port=$port;dbname=$db_name", $username, $password);
        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die("Could not connect to the database $db_name :" . $e->getMessage());
    }
}
?>
