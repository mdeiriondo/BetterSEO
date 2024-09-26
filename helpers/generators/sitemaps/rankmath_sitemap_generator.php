<?php

$php_code_start = '<?php
namespace RankMath\\Sitemap\\Providers;

// Uncomment if having issues with RankMath Caching
// add_filter( \'rank_math/sitemap/enable_caching\', \'__return_false\');

class Custom implements Provider {

	public function handles_type( $type ) {
		return \'custom\' === $type;
	}

	public function get_index_links( $max_entries ) {
		return [
			[
				\'loc\'     => \\RankMath\\Sitemap\\Router::get_base_url( \'custom-sitemap.xml\' ),
				\'lastmod\' => \'\',
			]
		];
	}

	public function get_sitemap_links( $type, $max_entries, $current_page ) {
        
';
$php_code_end = ' } } ';

function generate_rankmath_sitemap($product_list, $user_id)
{
    $array_request_url =  'https://betterseo.gorilion.com/output/rankmath_sitemaps/' . $user_id . '/sitemap_array.php';
    global $php_code_start;
    global $php_code_end;

    $php_code = $php_code_start;
    $php_code .= ' 
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "' . $array_request_url . '",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
    ));
    $response = curl_exec($curl); // Server responds with a text array, which is then converted to a PHP array
    $response = stripcslashes($response);
    $err = curl_error($curl);
    if(empty($err)){
        $product_list = json_decode($response, true);
    }
    curl_close($curl);
    return $product_list;

    ';
    $php_code .= $php_code_end;
    // Generate the array response for rankmath sitemap
    $array_response = '[';
    foreach ($product_list as $product) {
        $image_link = $product['image'];
        $images = '';
        if (!empty($image_link)) {
            $images =  ",
            \"images\" : {";
            $images .= "\"src\" : \"" . $image_link . "\",";
            $images .= "\"title\" : \"" . addslashes($product['title']) . "\" }";
        }
        $new_entry = "
        {
            \"loc\" : \"" . $product['link'] . "\"" . $images .  "
        },";
        //$php_code .= $new_entry;
        $array_response .= $new_entry;
    }
    $array_response = rtrim($array_response, ",");
    $array_response .= ']';

    return array("php_code" => $php_code, "rankmath_array" => $array_response);
}


if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
    // DEBUGGING PURPOSES ONLY
    require_once '../../fetchers/fetch_ecellar.php';
    $api = 'CA05DD84-7594-4BE6-9C45-7D3D4B1BC579';
    $results = fetch_ecellar($api);
    $client = array();
    $client['link'] = "abc.com/product/";
    $client['brand'] = 'DavisEstates';
    //echo gettype($client);
    //echo $client['link'];
    //echo json_encode($client);
    $processed_array = process_ecellar($results, $client);
    //echo 'json: ';
    //echo json_encode($processed_array);

    echo "<pre>";
    echo generate_rankmath_sitemap($processed_array);
    echo "</pre>";
}
