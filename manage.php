<?php
$servername = "localhost";
$dbUsername = "u996275341_productfeed";
$dbPassword = "$[i3yKh;8";
$dbname = "u996275341_productfeed";
session_start();

if (isset($_POST['logout'])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect the user to the login page or any other desired page
    header('Location: index.php');
    exit;
}

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false) {
    echo "Unauthorized access";
    exit;
}
if (!isset($_SESSION['username']) || $_SESSION['username'] != 'admin'){
    echo "Unauthorized access";
    exit;
}

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $passkey = $_POST['passkey'];
    $api = $_POST['api'];
    $brand = $_POST['brand'];
    $link = $_POST['link'];
    $platform = $_POST['platform'];
    $collection = $_POST['collection'];
    $tenant = $_POST['tenant'];
    $product_page_name = $_POST['product_page_name'];
    $seo_plugin = $_POST['seo_plugin'];

    // Hash the password before storing it in the database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password, passkey, api, brand, link, platform, collection, tenant, product_page_name, seo_plugin)
            VALUES ('$username', '$hashedPassword', '$passkey', '$api', '$brand', '$link', '$platform', '$collection', '$tenant', '$product_page_name', '$seo_plugin')";

    if ($conn->query($sql) === true) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        h2 {
            text-align: center;
        }

        form {
            width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 12px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .logout {
            text-align: center;
            margin-top: 20px;
        }

        .button {
            background-color: #ccc;
            color: #000;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #ddd;
        }
        #generate-passkey{
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h2>Registration Form</h2>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br><br>

        <label for="passkey">Passkey:</label>
        <input type="text" name="passkey" required>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" id="generate-passkey" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
  <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
  <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
</svg><br><br>

        <label for="api">API:</label>
        <input type="text" name="api"><br><br>

        <label for="brand">Brand:</label>
        <input type="text" name="brand" required><br><br>

        <label for="product_page_name">Product Page Name:</label>
        <input type="text" name="product_page_name" placeholder="product"><br><br>

        <label for="link">Link:</label>
        <input type="text" name="link" required><br><br>

        <label for="platform">Platform:</label>
        <select name="platform" required>
            <option value="c7">c7</option>
            <option value="ecellar">ecellar</option>
        </select><br><br>


        <label for="collection">Collection:</label>
        <input type="text" name="collection"><br><br>

        <label for="tenant">Tenant:</label>
        <input type="text" name="tenant"><br><br>

        <label for="seo_plugin">SEO Plugin:</label>
        <select name="seo_plugin" required>
            <option value="yoast">Yoast</option>
            <option value="rankmath">RankMath</option>
        </select><br><br>

        <input type="submit" name="submit" value="Register">
    </form>
        <div class="logout">
            <form method="POST" action="">
                <input class="button" type="submit" name="logout" value="Logout">
            </form>
        </div>
        <script>
            function generatePassword() {
                var length = 8,
                charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
                retVal = "";
                for (var i = 0, n = charset.length; i < length; ++i) {
                    retVal += charset.charAt(Math.floor(Math.random() * n));
                }
                return retVal;
            }
            document.getElementById("generate-passkey").onclick = function(e){
                document.getElementsByName('passkey')[0].value = generatePassword();
            }
        </script>
</body>
</html>
