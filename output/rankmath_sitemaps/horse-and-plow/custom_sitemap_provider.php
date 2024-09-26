<?php
namespace RankMath\Sitemap\Providers;

// Uncomment if having issues with RankMath Caching
// add_filter( 'rank_math/sitemap/enable_caching', '__return_false');

class Custom implements Provider {

	public function handles_type( $type ) {
		return 'custom' === $type;
	}

	public function get_index_links( $max_entries ) {
		return [
			[
				'loc'     => \RankMath\Sitemap\Router::get_base_url( 'custom-sitemap.xml' ),
				'lastmod' => '',
			]
		];
	}

	public function get_sitemap_links( $type, $max_entries, $current_page ) {
        
 
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://betterseo.gorilion.com/output/rankmath_sitemaps/horse-and-plow/sitemap_array.php",
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

     } } 