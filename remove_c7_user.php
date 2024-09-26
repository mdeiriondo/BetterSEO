<?php

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
$tenant = $post_json['tenantId'];
$username = $tenant;
// $password = randomPassword();
// $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "DELETE FROM users WHERE username='$username'";

if ($conn->query($sql) === true) {
    echo "{'status':'Removal successful!'}";
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