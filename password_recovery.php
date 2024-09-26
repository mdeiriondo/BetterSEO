<?php
// Replace these variables with your own database credentials
$host = 'localhost';
$username = 'your_username';
$password = 'your_password';
$database = 'your_database';

// Connect to the database
$mysqli = new mysqli($host, $username, $password, $database);

// Check for any connection error
if ($mysqli->connect_error) {
    die('Connection Error: ' . $mysqli->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the submitted email and new password from the form
    $_userName = $_POST['username'];
    $newPassword = $_POST['new_password'];

    // Prepare a SELECT statement to check if the email exists in the database
    $stmt = $mysqli->prepare('SELECT userName FROM users WHERE userName = ?');
    $stmt->bind_param('s', $_userName);
    $stmt->execute();
    $stmt->store_result();

    // Check if the email exists in the database
    if ($stmt->num_rows === 1) {
        // Prepare an UPDATE statement to change the user's password
        $stmt = $mysqli->prepare('UPDATE users SET password = ? WHERE UserName = ?');
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt->bind_param('ss', $hashedPassword, $_userName);
        $stmt->execute();

        if ($stmt->affected_rows === 1) {
            // Password changed successfully
            echo 'Password changed successfully!';
        } else {
            // Failed to change the password
            echo 'Failed to change the password.';
        }
    } else {
        // Email not found in the database
        echo 'Email not found.';
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Password Reset Form</title>
</head>
<body>
    <h2>Password Reset</h2>
    <form method="POST" action="">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="new_password">New Password:</label><br>
        <input type="password" id="new_password" name="new_password" required><br><br>

        <input type="submit" value="Reset Password">
    </form>
</body>
</html>
