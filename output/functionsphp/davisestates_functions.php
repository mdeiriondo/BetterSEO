// CODE STARTS HERE
// Add these to your functions.php file in your theme folder

// This namespace has to be at the top of your functions.php file, after <?php
include_once "custom_sitemap_provider.php";
add_action( "wp_head", "rankmath_disable_features",1);
function rankmath_disable_features() {
    global $post;
    if ($post->post_name == "product-detail" || $post->post_name == "collection") {
        remove_all_actions( "rank_math/head");
    }
}
add_filter("rank_math/sitemap/providers", function( $external_providers ) {
	$external_providers["custom"] = new \RankMath\Sitemap\Providers\Custom();
	return $external_providers;
});

add_action("wp_head", "gorilion_opengraph");
function gorilion_opengraph(){
	global $post;

	//Remove Canonical from header
	if ($post->post_name == "product-detail") {
		add_filter( "wpseo_canonical", "__return_false" );
	}

    $request_url = $_SERVER["REQUEST_URI"];
    $request_url = trim($request_url, "\/");
    $result = end(explode("/", $request_url));

    if (!$result || $result == "" || $result == "product-detail") {
        $redirect_url = $_SERVER["REDIRECT_URL"];
        $redirect_url = trim($redirect_url, "\/");
        $result = end(explode("/", $redirect_url));
    }
    if (!$result || $result == "" || $result == "product-detail") {
        echo "<!-- Your server either needs request_url or redirect_uri enabled and supporting passtrhrough urls  -->";
    }

 
    if ($post->post_name == "product-detail") {
    $curl = null;
    // platform = ecellar
    
        $key = "15C03217-6124-4FEB-A7DB-038D39643518"; // to be swapped out
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
        $description = str_replace('"', '', strip_tags($responseMetadata->meta_description));
        $description = substr($description, 0 , 200);
        $wine = $response->wine;
        $sku = $response->SKU;
        $img = $response->image_1 ? $response->image_1 : $response->header_image;
        //$keywords =  implode(",", [$title, $sku, implode(",", (array)$wine)]);
        $keywords = $responseMetadata->meta_keywords;

		
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
        echo '<script type="application/ld+json">
                {
                    "@context" : "http://schema.org",
                    "@type" : "Product",
                    "name" : "' .$title .'",
                    "image" : "' . $img . '",
                    "description" : "' . $description .'",
                    "brand" : {
                        "@type" : "Brand",
                        "name" : "' . $site_title . '",
                        "logo" : "' . esc_url( wp_get_attachment_image_src( get_theme_mod( "custom_logo" ), "full" )[0] ) . '"
                    },
                    "offers" : {
                        "@type" : "Offer",
                        "priceCurrency" : "USD",
                        "price" : "' . $price . '"
                    }
                }
              </script>';
    }
}
              // CODE ENDS HERE
