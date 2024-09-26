<?php
include_once('httpful.phar');
include_once 'helpers/fetchers/fetch_ecellar.php';
include_once 'helpers/generators/sitemaps/rankmath_sitemap_generator.php';
header('Content-type:application/xml');
// get URL parameters
$base = "";
$ecellar_base = "https://public.ecellar-api.com/v1/products/";
$c7_base = "https://api.commerce7.com/v1/product/for-web/";
$api = '';
$passkey = filter_input(INPUT_GET, "passkey", FILTER_SANITIZE_STRING);
$passkey = $passkey ? $passkey : $_POST['passkey'];
$userID = filter_input(INPUT_GET, "userID", FILTER_SANITIZE_STRING);
$userID = $userID ? $userID : $_POST['userID'];
// echo  json_encode($_POST);
//function urlencode_apostrophes($text)
//{
//$encodedText = str_replace("'", "%27", $text);
//return $encodedText;
//}

// Example USE:
// https://productfeed.gorilion.com/?userID=meadowcroft&passkey=NRQ6w7myEFRSAwrf


function debug_log($message)
{
    // if the $message is an object write to the log with pretty print
    if (is_array($message)) {
        $message = json_encode($message, JSON_PRETTY_PRINT);
    }
    // if the $message is json, then decode it and encode it again with the JSON_PRETTY_PRINT option
    else if (is_string($message) && is_array(json_decode($message, true)) && (json_last_error() == JSON_ERROR_NONE)) {
        $message = json_encode(json_decode($message, true), JSON_PRETTY_PRINT);
    }
    $log = fopen("debug.log", "a");
    fwrite($log, $message . "\n");
    fclose($log);
}

session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false) {
    parse_str($_SERVER['QUERY_STRING'], $get_array);
    if (!isset($_POST['userID'])) {
        echo 'tenantId not set';
        // header('Location: index.php');
        exit;
    }
    $c7_view = true;
}
$servername = "localhost";
$dbUsername = "u996275341_productfeed";
$dbPassword = "$[i3yKh;8";
$dbname = "u996275341_productfeed";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($c7_view != true) {
    $the_query = "SELECT passkey, api, brand, link, platform, collection, tenant, product_page_name, seo_plugin FROM users WHERE UserName = '" . $_SESSION['username'] . "'";
} else {
    $the_query = "SELECT username, passkey, api, brand, link, product_page_name, platform, collection, tenant, seo_plugin  FROM users WHERE tenant = '" . $_POST['userID'] . "'";
    // $username = $get_array['tenantId'];
}

// echo $the_query;
$result = $conn->query($the_query);
$client_result = $result->fetch_assoc();
// echo json_encode($client_result['passkey']);
// echo json_encode($userID);
// echo json_encode($passkey);


if ($userID == null || $passkey == null || $passkey != $client_result['passkey']) {
    // checking for valid input
    if (!isset($c7_view)) {
        echo '<ERROR>Invalid credentials</ERROR>';
        exit;
    }
}
// Setting up valid response
$objDateTime = new DateTime('NOW');
$xml_base = '<?xml version="1.0" encoding="UTF-8"?' . '><rss xmlns:g="http://base.google.com/ns/1.0" version="2.0"> <channel> <created_at>' . $objDateTime->format("Y-m-d H:i") . '</created_at>';

$api = $client_result['api'];
$platform = $client_result['platform'];
$tenant = $client_result['tenant'];
$brand = $client_result['brand'];
$product_page_name = $client_result['product_page_name'];

$link_base = rtrim($client_result['link'], '/') . '/';
$product_list = [];
$debug = '';

if ($platform == 'ecellar') {
    if ($api == '') { // No API key
        echo '<ERROR>Configuration missing API Key</ERROR></rss>';
        exit;
    }
    $response = fetch_ecellar($api);
    $product_list = process_ecellar($response, $client_result, $api);
} elseif ($platform == 'c7') {
    $is_end = false;
    $page_count = 1;
    $base = $c7_base;
    // $base = $base . '?collectionSlug=' . $client_result['collection'];
    $base = $base . '?webStatus=Available';
    while (!$is_end) {
        $response = \Httpful\Request::get($base . '&page=' . $page_count)->expectsJson()->addHeader('tenant', $tenant)->send();
        $products = $response->body->products;
        if (!empty($products)) {
            $page_count += 1;
            foreach ($products as $product) {
                $debug .= json_encode($product);
                // $xml = $xml . '<pre>' . htmlspecialchars(json_encode($product)) . '</pre>';
                $sku = $product->variants[0]->sku;
                $sku = ($sku == null) ? $product->id : $sku;
                $title = ucwords(strtolower(htmlspecialchars($product->title)));
                $description = htmlspecialchars(str_replace("&nbsp;", " ", htmlspecialchars_decode(strip_tags($product->content), ENT_HTML5)));
                $description = ($description) ? $description : 'No Description Currently Available';
                $link = urlencode_apostrophes(htmlspecialchars($link_base . trim($product->slug)));
                $image = urlencode_apostrophes(htmlspecialchars($product->image));
                $price = number_format((float) $product->variants[0]->price / 100.00, 2, '.', '');
                $summary = htmlspecialchars(str_replace("&nbsp;", " ", $product->teaser));
                if ($product->variants[0]->hasInventory == "true") {
                    $stock = 'in stock';
                } else {
                    $stock = 'out of stock';
                }
                $product_id = $product->id;
                $weight = $product->variants[0]->weight;
                $volume = $product->variants[0]->volumeInML;
                $volume = ($volume == null) ? '750' : $volume;
                $type = '421';
                $count = $product->variants[0]->inventory[0]->availableForSaleCount;
                $count = ($count == null) ? 0 : $count;
                $color = $product->wine->type;
                $varietal = $product->wine->varietal;
                $appellation = $product->wine->appellation;
                $country = $product->wine->countryCode;
                $vintage = $product->wine->vintage;
                $region = $product->wine->region;
                array_push($product_list, [
                    'sku' => $sku,
                    'title' => $title,
                    'description' => $description,
                    'link' => $link,
                    'image' => $image,
                    'price' => $price,
                    'summary' => $summary,
                    'stock' => $stock,
                    'product_id' => $product_id,
                    'weight' => $weight . 'lb',
                    'type' => $type,
                    'volume' => $volume,
                    'brand' => $brand,
                    'count' => $count,
                    'color' => $color,
                    'varietal' => $varietal,
                    'appellation' => $appellation,
                    'vintage' => $vintage,
                    'region' => $region,
                    'country' => $country,
                ]);
            }
        } else {
            $is_end = true;
        }
    }
}

// Generate Rankmath SITEMAP
$php_code_and_rankmath_array = generate_rankmath_sitemap($product_list, $userID);
$rankmath_php_code = $php_code_and_rankmath_array["php_code"];
$rankmath_array = $php_code_and_rankmath_array["rankmath_array"];

$xml = $xml_base;
// Generate google and facebook product feeds -- ATM they are the same
foreach ($product_list as $product) {
    $xml = $xml . '<item>
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

// Generate vivino product feed
$timestamp = new DateTime();
$timestampString = $timestamp->format("Y-m-d\TH:i:s.u\Z");
$vivino = '<vivino-product-list>
<meta-data>
    <feed-generation-date>' . $timestampString . '</feed-generation-date>
</meta-data>
';
foreach ($product_list as $product) {
    $vivino = $vivino . '<product>
    <product-name>' . $product['title'] . '</product-name>
    <price>' . $product['price'] . '</price>
    <quantity-is-minimum>false</quantity-is-minimum>
    <bottle_size>' . $product['volume'] . ' ml</bottle_size>
    <bottle_quantity>1</bottle_quantity>
    <link>' . $product['link'] . '</link>
    <inventory-count>' . $product['count'] . '</inventory-count>
    <product-id>' . $product['product_id'] . '</product-id>
    <extras>
        <producer>' . $brand . '</producer>
        <appellation>' . $product['appellation'] . '</appellation>
        <vintage>' . $product['vintage'] . '</vintage>
        <country>' . $product['country'] . '</country>
        <color>' . $product['color'] . '</color>
        <varietal>' . $product['varietal'] . '</varietal>
    </extras>
</product>
';
}
$vivino = $vivino . '</vivino-product-list>';

$google_sitemap = '<?xml version="1.0" encoding="UTF-8"?' . '><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
foreach ($product_list as $product) {
    $google_sitemap = $google_sitemap . ' <url> <loc>' . $product['link'] . '</loc> </url>';
}
$google_sitemap = $google_sitemap . '</urlset>';


$xml = $xml . '</channel></rss>';
$google_feed_path = 'output/feeds/' . $userID . '_productfeed.xml';
$facebook_feed_path = 'output/feeds/' . $userID . '_facebook_productfeed.xml';
$vivino_feed_path = 'output/feeds/' . $userID . '_vivino_productfeed.xml';
$google_sitemap_path = 'output/sitemaps/' . $userID . '_product_sitemap.xml';
$rankmath_sitemap_base_path = 'output/rankmath_sitemaps/' . $userID;
$rankmath_sitemap_path = $rankmath_sitemap_base_path . '/sitemap_array.php';
file_put_contents($google_feed_path, $xml);
file_put_contents($facebook_feed_path, $xml);
file_put_contents($vivino_feed_path, $vivino);
file_put_contents($google_sitemap_path, $google_sitemap);
if (!is_dir($rankmath_sitemap_base_path)) {
    // Create the directory if it doesn't exist
    mkdir($rankmath_sitemap_base_path, 0777, true);  // The third argument ensures recursive creation of nested directories
}
file_put_contents($rankmath_sitemap_path, $rankmath_array);

// Generate functions.php
$functionsphp_path = 'output/functionsphp/' . $userID . '_functions.php';
$functions = '// CODE STARTS HERE
// Add these to your functions.php file in your theme folder
';
file_put_contents($rankmath_sitemap_base_path . '/custom_sitemap_provider.php', $rankmath_php_code);

if ($client_result['seo_plugin'] == 'yoast') {
    $functions .= '
add_action("template_redirect", "remove_wpseo_from_product");
function remove_wpseo_from_product() {
    global $post;
    if ($post->post_name == "' . $product_page_name . '" || $post->post_name == "collection") {
        $front_end = YoastSEO()->classes->get("Yoast\WP\SEO\Integrations\Front_End_Integration");

        remove_action( "wpseo_head", [ $front_end, "present_head" ], -9999 );

    }
}
';
} elseif ($client_result['seo_plugin'] == 'rankmath') {
    $functions .= '
// This namespace has to be at the top of your functions.php file, after <?php
include_once "custom_sitemap_provider.php";
add_action( "wp_head", "rankmath_disable_features",1);
function rankmath_disable_features() {
    global $post;
    if ($post->post_name == "' . $product_page_name . '" || $post->post_name == "collection") {
        remove_all_actions( "rank_math/head");
    }
}
add_filter("rank_math/sitemap/providers", function( $external_providers ) {
	$external_providers["custom"] = new \RankMath\Sitemap\Providers\Custom();
	return $external_providers;
});
';
}

$c7_collection_section = '';
if ($platform == 'c7') {
    $c7_collection_section = ' 
    if ($post->post_name == "collection") {
        //https://api.commerce7.com/v1/product/for-web?&collectionSlug=
        $collection_url_base = "https://api.commerce7.com/v1/product/for-web?&collectionSlug=";
        //Make API request to get collection details by slug, grab the title
        $url = $collection_url_base . $result;
        $headers = array(
            "tenant: ' . $tenant . '"
        );
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($curl);
        // Print response hidden
        if ($response) {
            $response = json_decode($response);
            $new_title = $response->collection->seo->title;
            $new_description = $response->collection->seo->description;
            echo "<!-- Gorilion meta -->";
            echo "<title>" . $new_title . "</title>" . PHP_EOL;
            echo "<meta name=\"description\" content=\"" . $new_description . "\"/>" . PHP_EOL;
        }
    }
    ';
}

$functions .= '
add_action("wp_head", "gorilion_opengraph");
function gorilion_opengraph(){
	global $post;

	//Remove Canonical from header
	if ($post->post_name == "' . $product_page_name . '") {
		add_filter( "wpseo_canonical", "__return_false" );
	}

    $request_url = $_SERVER["REQUEST_URI"];
    $request_url = trim($request_url, "\/");
    $result = end(explode("/", $request_url));

    if (!$result || $result == "" || $result == "' . $product_page_name . '") {
        $redirect_url = $_SERVER["REDIRECT_URL"];
        $redirect_url = trim($redirect_url, "\/");
        $result = end(explode("/", $redirect_url));
    }
    if (!$result || $result == "" || $result == "' . $product_page_name . '") {
        echo "<!-- Your server either needs request_url or redirect_uri enabled and supporting passtrhrough urls  -->";
    }

'
    . $c7_collection_section .

    ' 
    if ($post->post_name == "' . $product_page_name . '") {
    $curl = null;
    // platform = ' . $platform . '
    ';
if ($platform == 'c7') {
    $functions .= '
        $url = "https://api.commerce7.com/v1/product/slug/" . $result . "/for-web";
        $headers = array(
            "tenant: ' . $tenant . '" 
        );
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $responseData = curl_exec($curl);

        $response = "";
        if ($responseData === false || empty($responseData)) {
            // Error handling
            $error = curl_error($curl);
            echo "Error from curl: " . $error;
        } else {
            // Close the cURL request
            curl_close($curl);
            // Decode the JSON response
            $response = json_decode($responseData);
        }

        $price = $response->variants[0]->price / 100.00;
        $description = $response->seo->description;
        $wine = $response->wine;
        $title = $response->seo->title;
        $sku = $response->variants[0]->sku;
        $img = $response->image;
        $keywords =  implode(",", [$title, $sku, implode(",", (array)$wine)]);
		';
} elseif ($platform == 'ecellar') {
    $functions .= '
        $key = "' . $api . '"; // to be swapped out
        if (str_contains($request_url, "product/")){
            $result = end(explode("/", $request_url));
        }
        elseif (!empty($_SERVER["QUERY_STRING"])){
            $queryString = $_SERVER["QUERY_STRING"];
            // Parse the query string
            parse_str($queryString, $queryParams);
            // Check if "slug" is set in the query parameters
            if (isset($queryParams["slug"])) {
                $result = $queryParams["slug"];
            }
        }
        $url = "https://public.ecellar-api.com/v1/products/" . $result;
        $headers = array(
            "X-API-Key: " . $key,
            "User-Agent: WordPress" // Replace with your desired user agent
        );
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $responseData = curl_exec($curl);

        $url = "https://public.ecellar-api.com/v1/products/" . $result . "/metadata";
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $responseMetadata = curl_exec($curl);

        if ($responseData === false || empty($responseData)) {
            // Error handling
            $error = curl_error($curl);
            echo "Error from curl: " . $error;
        } else {
            // Close the cURL request
            curl_close($curl);
            // Decode the JSON response
            $response = json_decode($responseData);
            $responseMetadata = json_decode($responseMetadata);
        }
        $title = $responseMetadata->meta_title;
        if($title == null || $title == ""){
            $title = $response->product_name;
        }
        $price = $response->price / 1.00;
        $description = str_replace(\'"\', \'\', strip_tags($responseMetadata->meta_description));
        $description = substr($description, 0 , 200);
        $wine = $response->wine;
        $sku = $response->SKU;
        $img = $response->image_1 ? $response->image_1 : $response->header_image;
        //$keywords =  implode(",", [$title, $sku, implode(",", (array)$wine)]);
        $keywords = $responseMetadata->meta_keywords;

		';
}
$functions .= '
        // Get data
        $url = "https://" . rtrim($_SERVER["HTTP_HOST"], "/") . "/" . $request_url;
        echo "<!-- Gorilion meta :: VERSION 1.2 -->";
		$site_title = get_bloginfo( "name" );
        echo "<title>" . $title . "</title>" . PHP_EOL;
        echo "<meta name=\"description\" content=\"" . $description . "\"/>" . PHP_EOL;
        echo "<meta name=\"keywords\" content=\"" . $keywords . "\">" . PHP_EOL;
        echo "<link rel=\"canonical\" href=\"" . $url . "\"/>" . PHP_EOL;
        echo "<meta property=\"og:type\" content=\"product\" />" . PHP_EOL;
        echo "<meta property=\"og:title\" content=\"" . $title . "\"/>" . PHP_EOL;
        echo "<meta property=\"og:description\" content=\"" . $description . "\"/>" . PHP_EOL;
        echo "<meta property=\"og:image\" content=\"" . $img . "\"/>" . PHP_EOL;
        echo "<meta property=\"og:url\" content=\"" . $url . "\"/>" . PHP_EOL;
        echo "<meta property=\"og:site_name\" content=\"".$site_title."\" />" . PHP_EOL;
        echo "<meta name=\"twitter:card\" content=\"summary_large_image\" />" . PHP_EOL;
        echo \'<script type="application/ld+json">
                {
                    "@context" : "http://schema.org",
                    "@type" : "Product",
                    "name" : "\' .$title .\'",
                    "image" : "\' . $img . \'",
                    "description" : "\' . $description .\'",
                    "brand" : {
                        "@type" : "Brand",
                        "name" : "\' . $site_title . \'",
                        "logo" : "\' . esc_url( wp_get_attachment_image_src( get_theme_mod( "custom_logo" ), "full" )[0] ) . \'"
                    },
                    "offers" : {
                        "@type" : "Offer",
                        "priceCurrency" : "USD",
                        "price" : "\' . $price . \'"
                    }
                }
              </script>\';
    }
}
              // CODE ENDS HERE
';
file_put_contents($functionsphp_path, $functions);

// file_put_contents('DEBUG.json', $debug);
print($functions);
