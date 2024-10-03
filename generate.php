<?php  
include_once('httpful.phar');  
include_once 'helpers/fetchers/fetch_ecellar.php';  
include_once 'helpers/generators/sitemaps/rankmath_sitemap_generator.php';  
include_once 'config.php'; // Include configuration file  
header('Content-type:application/xml');  

session_start();  

// Function to validate session  
function validateSession() {  
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {  
        $passkey = filter_input(INPUT_GET, "passkey", FILTER_SANITIZE_STRING) ?? $_POST['passkey'] ?? null;  
        $userID = filter_input(INPUT_GET, "userID", FILTER_SANITIZE_STRING) ?? $_POST['userID'] ?? null;  

        if (!$userID) {  
            echo 'tenantId no está configurado';  
            exit;  
        }  
        return [$userID, $passkey, true];  
    }  
    return [$_SESSION['username'], null, false];  
}  

// Function to connect to the database  
function connectDatabase() {  
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);  
    if ($conn->connect_error) {  
        die("Connection failed: " . $conn->connect_error);  
    }  
    return $conn;  
}  

// Function to fetch user data  
function fetchUserData($conn, $userID, $isC7View) {  
    if ($isC7View) {  
        $stmt = $conn->prepare("SELECT username, passkey, api, brand, link, product_page_name, platform, collection, tenant, seo_plugin FROM users WHERE tenant = ?");  
        $stmt->bind_param("s", $userID);  
    } else {  
        $stmt = $conn->prepare("SELECT passkey, api, brand, link, platform, collection, tenant, product_page_name, seo_plugin FROM users WHERE UserName = ?");  
        $stmt->bind_param("s", $userID);  
    }  
    $stmt->execute();  
    return $stmt->get_result()->fetch_assoc();  
}  

// Function to validate credentials  
function validateCredentials($userID, $passkey, $clientResult) {  
    if (is_null($userID) || is_null($passkey) || $passkey !== $clientResult['passkey']) {  
        echo '<ERROR>Invalid credentials</ERROR>';  
        exit;  
    }  
}  

// Function to generate XML base  
function generateXMLBase() {  
    $objDateTime = new DateTime('NOW');  
    return '<?xml version="1.0" encoding="UTF-8"?' . '><rss xmlns:g="http://base.google.com/ns/1.0" version="2.0"> <channel> <created_at>' . $objDateTime->format("Y-m-d H:i") . '</created_at>';  
}  

// Main execution  
list($userID, $passkey, $isC7View) = validateSession();  
$conn = connectDatabase();  
$clientResult = fetchUserData($conn, $userID, $isC7View);  
validateCredentials($userID, $passkey, $clientResult);  

$xmlBase = generateXMLBase();  
$api = $clientResult['api'];  
$platform = $clientResult['platform'];  
$tenant = $clientResult['tenant'];  
$brand = $clientResult['brand'];  
$productPageName = $clientResult['product_page_name'];  
$linkBase = rtrim($clientResult['link'], '/') . '/';  

$stmt->close();  
$conn->close();  

$productList = [];  

if ($platform == 'ecellar') {  
    if (empty($api)) { // No API key  
        echo '<ERROR>Configuration missing API Key</ERROR></rss>';  
        exit;  
    }  
    $response = fetch_ecellar($api);  
    $productList = process_ecellar($response, $clientResult, $api);  
} elseif ($platform == 'c7') {  
    $productList = fetchC7Products($tenant, $clientResult);  
}  

// Generate feeds and sitemaps  
generateFeedsAndSitemaps($productList, $userID, $brand, $productPageName);  

// Function to fetch products from C7  
function fetchC7Products($tenant, $clientResult) {  
    $productList = [];  
    $isEnd = false;  
    $pageCount = 1;  
    $base = "https://api.commerce7.com/v1/product/for-web?webStatus=Available"; // Example base URL  

    while (!$isEnd) {  
        $response = \Httpful\Request::get($base . '&page=' . $pageCount)  
            ->expectsJson()  
            ->addHeader('tenant', $tenant)  
            ->send();  

        $products = $response->body->products;  
        if (!empty($products)) {  
            $pageCount += 1;  
            foreach ($products as $product) {  
                $productList[] = processProduct($product, $clientResult);  
            }  
        } else {  
            $isEnd = true;  
        }  
    }  
    return $productList;  
}  

// Function to process individual product  
function processProduct($product, $clientResult) {  
    $sku = $product->variants[0]->sku ?? $product->id;  
    $title = ucwords(strtolower(htmlspecialchars($product->title)));  
    $description = htmlspecialchars(str_replace("&nbsp;", " ", htmlspecialchars_decode(strip_tags($product->content), ENT_HTML5))) ?: 'No Description Currently Available';  
    $link = urlencode_apostrophes(htmlspecialchars($linkBase . trim($product->slug)));  
    $image = urlencode_apostrophes(htmlspecialchars($product->image));  
    $price = number_format((float) $product->variants[0]->price / 100.00, 2, '.', '');  
    $summary = htmlspecialchars(str_replace("&nbsp;", " ", $product->teaser));  
    $stock = $product->variants[0]->hasInventory == "true" ? 'in stock' : 'out of stock';  
    $productId = $product->id;  
    $weight = $product->variants[0]->weight;  
    $volume = $product->variants[0]->volumeInML ?? '750';  
    $type = '421';  
    $count = $product->variants[0]->inventory[0]->availableForSaleCount ?? 0;  
    $color = $product->wine->type;  
    $varietal = $product->wine->varietal;  
    $appellation = $product->wine->appellation;  
    $country = $product->wine->countryCode;  
    $vintage = $product->wine->vintage;  
    $region = $product->wine->region;  

    return [  
        'sku' => $sku,  
        'title' => $title,  
        'description' => $description,  
        'link' => $link,  
        'image' => $image,  
        'price' => $price,  
        'summary' => $summary,  
        'stock' => $stock,  
        'product_id' => $productId,  
        'weight' => $weight . 'lb',  
        'type' => $type,  
        'volume' => $volume,  
        'brand' => $clientResult['brand'],  
        'count' => $count,  
        'color' => $color,  
        'varietal' => $varietal,  
        'appellation' => $appellation,  
        'vintage' => $vintage,  
        'region' => $region,  
        'country' => $country,  
    ];  
}  

// Function to generate feeds and sitemaps  
function generateFeedsAndSitemaps($productList, $userID, $brand, $productPageName) {  
    $xml = $xmlBase;  
    foreach ($productList as $product) {  
        $xml .= '<item>  
            <g:id>' . $product['sku'] . '</g:id>  
            <title>' . $product['title'] . '</title>  
            <description>' . $product['description'] . '</description>  
            <link>' . $product['link'] . '</link>  
            <g:image_link>' . $product['image'] . '</g:image_link>  
            <g:price>' . $product['price'] . ' USD</g:price>  
            <g:brand>' . $product['brand'] . '</g:brand>  
            <g:product_type>Wine</g:product_type>  
            <g:condition>New</g:condition>  
            <summary>' . $product['summary'] . '</summary>  
            <g:availability>' . $product['stock'] . '</g:availability>  
            <product_id>' . $product['product_id'] . '</product_id>  
            <g:product_weight>' . $product['weight'] . '</g:product_weight>  
            <g:google_product_category>' . $product['type'] . '</g:google_product_category>  
            <g:identifier_exists>no</g:identifier_exists>  
            <g:mpn>' . $product['sku'] . '</g:mpn>  
            </item>';  
    }  
    $xml .= '</channel></rss>';  

    // Save feeds and sitemaps  
    $googleFeedPath = 'output/feeds/' . $userID . '_productfeed.xml';  
    file_put_contents($googleFeedPath, $xml);  
    // Additional feed and sitemap generation logic can be added here  
}  

// Output the generated XML  
print($xml);