<?php
include('httpful.phar');
// get URL parameters
$base = "https://public.ecellar-api.com/v1/products/";
$api = '';
$passkey = filter_input(INPUT_GET,"passkey",FILTER_SANITIZE_STRING);
$userID = filter_input(INPUT_GET,"userID",FILTER_SANITIZE_STRING);

$USERS = [
    'meadowcroft' => [
        'passkey' => 'NRQ6w7myEFRSAwrf',
        'api' => 'EA828C75-55A6-46E3-8BEA-9AE21C1BE222',
        'brand' => 'Meadowcroft',
        'link' => 'https://www.meadowcroftwines.com/shop/?view=product&slug=',
    ],
    'davisestates' => [
        'passkey' => 'g2jBbWDZQt3EdeZ',
        'api' => '15C03217-6124-4FEB-A7DB-038D39643518',
        'brand' => 'Davis Estates',
        'link' => 'https://www.davisestates.com/shop/?view=product&slug=',
    ]

];
if ($userID == null || $USERS[$userID] == null || $passkey == null || $passkey != $USERS[$userID]['passkey']) {
    // checking for valid input
    echo '<ERROR>Invalid credentials</ERROR>';
    exit;
} 
$api = $USERS[$userID]['api'];
$brand = $USERS[$userID]['brand'];
$link_base = $USERS[$userID]['link'];
if( $api == ''){ // No API key
    echo '<ERROR>Configuration missing API Key</ERROR></rss>';
    exit;
}
$response = \Httpful\Request::get($base)->addHeader('X-API-Key', $api)->send();
echo count($response->body);

// Setting up valid response
// Create an item entry for each product
foreach($response->body as $i=>$product){
    $link = $link_base . trim($product->slug) ;
    $new_link = $link;
    $summary = $product->feature_text;
    $description = str_replace("&nbsp;"," ",htmlspecialchars_decode(strip_tags($product->description), ENT_HTML5));
    $title = $product->product_name;
    $image = $product->image_1;
    
    echo '</br>';
    echo 'Item: ' . $i . '  ';
    print_r($product->slug ? $product->slug : 'No slug');
}
?> 