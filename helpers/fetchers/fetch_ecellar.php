<?php

function urlencode_apostrophes($text)
{
    $encodedText = str_replace("'", "%27", $text);
    return $encodedText;
}

//echo '<h2>This is a test</h2>';
function fetch_ecellar($api_key)
{
    $base = "https://public.ecellar-api.com/v1/products/";
    $headers = array(
        "X-API-Key: " . $api_key,
        "User-Agent: WordPress" // Replace with your desired user agent
    );
    $curl = curl_init($base);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($curl);

    // Execute the cURL request
    $response = curl_exec($curl);

    // Check for errors
    if ($response === false) {
        $error = curl_error($curl);
        echo "cURL Error: " . $error;
    }

    $response = json_decode($response);
    // Close the cURL session
    curl_close($curl);
    return $response;
}


function process_ecellar($products, $client, $api_key)
{
    $product_list = [];
    foreach ($products as $product) {
        if ($product->slug == '') { // No slug -- skip this product
            continue;
        }
        // make API request to get product details by slug
        $curl = curl_init("https://public.ecellar-api.com/v1/products/" . $product->slug . '/metadata');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "X-API-Key: " . $api_key,
            "User-Agent: WordPress" // Replace with your desired user agent
        ));
        $response = curl_exec($curl);
        if ($response === false) {
            $error = curl_error($curl);
            debug_log("cURL Error: " . $error);
        }
        debug_log("response:");
        debug_log($response);
        if (gettype($response) == "string") {
            $response = json_decode($response, true);
        }
        //echo $product->slug;
        //echo $product->product_type;
        if (strtolower($product->product_type) != "wine") {
            continue;
        }
        //echo 'is wine';
        // $debug .= json_encode($product);
        $sku = $product->SKU;
        $sku = ($sku == null) ? $product->product_id : $sku;
        debug_log($response['meta_title']);
        $title = ucwords(strtolower(htmlspecialchars($response['meta_title'])));
        debug_log($title);
        if ($title == null) {
            $title = ucwords(strtolower(htmlspecialchars($product->product_name)));
        }
        $description = htmlspecialchars(str_replace("&nbsp;", " ", htmlspecialchars_decode(strip_tags($product->description), ENT_HTML5)));
        $description = (!empty($description)) ? $description : 'No Description Currently Available';
        //echo 'A';
        //echo htmlspecialchars($client['link'] . trim($product->slug));
        $link = urlencode_apostrophes(htmlspecialchars($client['link'] . trim($product->slug)));
        //echo 'B';
        $image = urlencode_apostrophes(htmlspecialchars($product->header_image));
        $image = ($image == null) ? urlencode_apostrophes(htmlspecialchars($product->image_1)) : $image;
        $image = ($image == null) ? urlencode_apostrophes(htmlspecialchars($product->image_2)) : $image;
        $image = ($image == null) ? urlencode_apostrophes(htmlspecialchars($product->image_3)) : $image;
        $price = number_format($product->price, 2, '.', '');
        $summary = htmlspecialchars(str_replace("&nbsp;", " ", $product->feature_text));
        //echo 'C';
        $stock = 'in stock';
        $product_id = $product->product_id;
        $weight = $product->weight;
        $type = ($product->product_type_id == "4") ? "499969" : "421"; // 421 = wine, 499969 = event tickets
        $volume = '750';
        $count = $product->maximum_quantity;
        $count = ($count == null) ? 0 : $count;
        //echo 'pushing';
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
            'weight' => $weight,
            'type' => $type,
            'volume' => $volume,
            'count' => $count,
            'brand' => $client['brand'],
        ]);
    }
    return $product_list;
}

//$api = 'CA05DD84-7594-4BE6-9C45-7D3D4B1BC579';
//$results = fetch_ecellar($api);
//echo 'fetched';
//$client = array();
//$client['link'] = "abc.com/product/";
//$client['brand'] = 'DavisEstates';
////echo gettype($client);
////echo $client['link'];
////echo json_encode($client);
//$processed_array = process_ecellar($results, $client);
//echo 'json: ';
//echo json_encode($processed_array);