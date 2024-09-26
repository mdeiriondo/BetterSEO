// CODE STARTS HERE
// Add these to your functions.php file in your theme folder
add_action("template_redirect", "remove_wpseo_from_product");
function remove_wpseo_from_product() {
    global $post;
    if ($post->post_name == "product-detail") {
        $front_end = YoastSEO()->classes->get("Yoast\WP\SEO\Integrations\Front_End_Integration");

        remove_action( "wpseo_head", [ $front_end, "present_head" ], -9999 );

    }
}

add_action("wp_head", "gorilion_opengraph");
function gorilion_opengraph(){
	global $post;

	//Remove Canonical from header
	if ($post->post_name == "product-detail") {
		add_filter( "wpseo_canonical", "__return_false" );
	}


    if ($post->post_name == "product-detail") {
    $mode = "ecellar";
    $request_url = $_SERVER["REDIRECT_URL"];
    $request_url = trim($request_url, "\/");
    $curl = null;
    
        $result = end(explode("/", $request_url));
        $url = "https://api.commerce7.com/v1/product/slug/" . $result . "/for-web";
        $headers = array(
            "tenant: crown-point-vineyards" 
        );
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $responseData = curl_exec($curl);

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
		
        // Get data
        $url = "https://" . $_SERVER["HTTP_HOST"] . $request_url;
		$site_title = get_bloginfo( "name" );
        echo "<title>" . $title . "</title>" . PHP_EOL;
        echo "<meta name=\"description\" content=\"" . $description . "\"/>" . PHP_EOL;
        echo "<meta name=\"keywords\" content=\"" . $keywords . "\">" . PHP_EOL;
        echo "<link rel=\"canonical\" href=\"" . $url . "\"/>" . PHP_EOL;
        echo "<meta property=\"og:type\" content=\"product\" />" . PHP_EOL;
        echo "<meta property=\"og:title\" content=\"" . $title . "\"/>" . PHP_EOL;
        echo "<meta property=\"og:description\" content=\"" . substr($description, 0 , 200) . "\"/>" . PHP_EOL;
        echo "<meta property=\"og:image\" content=\"" . $img . "\"/>" . PHP_EOL;
        echo "<meta property=\"og:url\" content=\"" . $url . "\"/>" . PHP_EOL;
        echo "<meta property=\"og:site_name\" content=\"".$site_title."\" />" . PHP_EOL;
        echo `<script type="application/ld+json">
                {
                    "@context" : "http://schema.org",
                    "@type" : "Product",
                    "name" : "` . $title . `",
                    "image" : "` . $img . `",
                    "description" : "` . $description . `",
                    "brand" : {
                        "@type" : "Brand",
                        "name" : "`.$site_title.`",
                        "logo" : "`. esc_url( wp_get_attachment_image_src( get_theme_mod( `custom_logo` ), `full` )[0] ) . `"
                    },
                    "offers" : {
                        "@type" : "Offer",
                        "price" : "` . $price . `"
                    }
                }
              </script>`;
    }
}
              // CODE ENDS HERE
