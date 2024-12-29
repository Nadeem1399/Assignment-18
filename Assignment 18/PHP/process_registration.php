<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include reCAPTCHA secret key
    $secretKey = "6LcCUUsqAAAAADmiZ0Rjlk61VtpPigEwvXLpRiex";
    $responseKey = $_POST['g-recaptcha-response'];
    $userIP = $_SERVER['REMOTE_ADDR'];

    // Verify reCAPTCHA
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$responseKey}&remoteip={$userIP}");
    $response = json_decode($response);

    if ($response->success) {
        // Capture and sanitize input
        $email = strip_tags(trim($_POST['email']));
        $terms = isset($_POST['terms']) ? strip_tags(trim($_POST['terms'])) : '';
        $province = strip_tags(trim($_POST['province']));
        $password = strip_tags(trim($_POST['password']));
        $password2 = strip_tags(trim($_POST['password2']));

        // Validate the email format
        if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
            die("Invalid email format.");
        }

        // Check if passwords match
        if ($password !== $password2) {
            die("Passwords do not match.");
        }

        // Hash the password (consider using password_hash)
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Prepare data for database insertion
        $email = addslashes($email);
        $terms = addslashes($terms);
        $province = addslashes($province);
        
     
        echo "Registration successful!";
    } else {
        die("CAPTCHA verification failed. Please try again.");
    }
} else {
    die("Invalid request method.");
}
?>
