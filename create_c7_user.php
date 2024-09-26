<?php

function getLastElementAfterSlash($input) {
    // Remove trailing slashes
    $input = rtrim($input, '/');

    // Explode the input string by '/'
    $parts = explode('/', $input);

    // Get the last element if there are slashes, else return the original input
    if (count($parts) > 1) {
        $lastElement = end($parts);
        return $lastElement;
    } else {
        return $input;
    }
}

function randomPassword() {
$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
$pass = array(); //remember to declare $pass as an array
$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
for ($i = 0; $i < 12; $i++) {
$n = rand(0, $alphaLength);
$pass[] = $alphabet[$n];
}
return implode($pass); //turn the array into a string
}


$servername = "localhost";
$dbUsername = "u996275341_productfeed";
$dbPassword = "$[i3yKh;8";
$dbname = "u996275341_productfeed";

$post_json = json_decode(file_get_contents('php://input'), true);
$brand = $post_json['product-brand-name'];
$platform = 'c7';
$tenant = $post_json['tenantId'];
$username = $tenant;
$passkey = $post_json['user']['id'];
$product_page_name = $post_json['wordpress-product-page'];
$product_page_name = getLastElementAfterSlash($product_page_name);
$seo_plugin = $post_json['wordpress-seo-plugin'];
$link = $post_json['product-link-excluding-the-slug'];
$password = randomPassword();
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO users (username, password, brand, link, platform, tenant, product_page_name, seo_plugin)
        VALUES ('$username', '$hashedPassword', '$brand', '$link', '$platform', '$tenant', '$product_page_name', '$seo_plugin')";

if ($conn->query($sql) === true) {
    echo "{'status':'Registration successful!'}";
    // file_put_contents('c7app/result.txt', 'Registration success!');
} else {
    echo "{'Error': '" . $sql . "---" . $conn->error . "'}";
    // file_put_contents('c7app/result.txt', 'Error! ' . $sql . '\n' . $conn->error);
}

//      REEEEE-SPONSE
// {
//     "product-brand-name": "test",
//     "wordpress-product-page": "test",
//     "wordpress-seo-plugin": "Yoast",
//     "tenantId": "crown-point-vineyards",
//     "user": {
//         "id": "f49f47cc-4ab4-4d6f-8ec3-d8ead7f2962c",
//         "firstName": "Sean",
//         "lastName": "Bryant",
//         "email": "sean+seo@seanbryant.com"
//     }
// }





file_put_contents('c7app/json_body_data.json', $post_json);

?>