<?php
// Start a PHP session
session_start();

// Check if the user is already logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // Redirect the user to the home page or any other authorized page
    if ($_SESSION['username'] == 'admin'){
        header('Location: manage.php');
        exit;
    }
    header('Location: dashboard.php');

    // echo json_encode($_SESSION);
    exit;
}

// Check if the login form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loginUsername = $_POST['username'];
    $loginPassword = $_POST['password'];

    // Establish a database connection
    $servername = "localhost";
    $username = "u996275341_productfeed";
    $password = "$[i3yKh;8";
    $dbname = "u996275341_productfeed";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // $conn->select_db('u996275341_productfeed');

    // Prepare and execute the query to fetch user data
    $query = "SELECT * FROM users WHERE UserName = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $loginUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a matching user is found
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        // Verify the password
        if (password_verify($loginPassword, $row['Password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $loginUsername;
        if ($_SESSION['username'] == 'admin'){
            header('Location: manage.php');
            exit;
        }

            header('Location: dashboard.php');
            exit;
        }
    }

    // Authentication failed, show an error message
    $error = 'Invalid username or password';

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="https://use.typekit.net/aay6fmr.css">
    <style>
        :root {
            font-family: "proxima-nova", sans-serif;;
            --primary-color: #445d72;
            --alt-color: #829cb4;
            --light-blue: #eef3f7;
            --grey: #e6e6e6;
            --medium-grey: #ccc;
            --dark-grey: #445d72;
            font-size: 18px;
        }
        body {
            display: flex;
            align-items: center;
            height: 100vh;
            justify-content: center;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: var(--light-blue);
        }
        .container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            box-sizing: border-box;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group input[type="submit"] {
            background-color: var(--primary-color);
            font-size: 18px;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        img.logo{
            margin: auto;
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <img alt="logo" class="logo" src='assets/logo.svg'>
        <h2>Dashboard Login</h2>

        <?php if (isset($error)) { ?>
            <div class="error"><?php echo $error; ?></div>
        <?php } ?>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <input type="submit" value="Login">
            </div>
        </form>
    </div>
</body>
</html>
