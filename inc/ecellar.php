<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ------------------------------------------------------------------
 * eCELLAR INTEGRATION
 * ------------------------------------------------------------------
 *
 * CPT registration, batch sync, template reuse, OpenGraph, and SPA
 * meta overwrite for eCellar-powered product pages.
 * ------------------------------------------------------------------
 */


/* =====================================================================
 * 1. CPT REGISTRATION
 * ===================================================================== */

add_action( 'init', 'betterseo_register_ecellar_product_cpt' );

function betterseo_register_ecellar_product_cpt() {
	if ( get_option( 'betterseo_platform', 'commerce7' ) !== 'ecellar' ) {
		return;
	}

	$api_key   = get_option( 'betterseo_ecellar_api_key', '' );
	$shop_path = get_option( 'betterseo_ecellar_shop_path', '' );

	if ( empty( $api_key ) || empty( $shop_path ) ) {
		return;
	}

	register_post_type( 'ecellar_product', array(
		'labels'              => array(
			'name'          => 'BetterSEO Products',
			'singular_name' => 'BetterSEO Product',
			'add_new'       => 'Add New Product',
			'add_new_item'  => 'Add New BetterSEO Product',
			'edit_item'     => 'Edit BetterSEO Product',
		),
		'public'              => true,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'has_archive'         => true,
		'rewrite'             => array(
			'slug'       => $shop_path . '/product',
			'with_front' => false,
		),
		'supports'            => array( 'title', 'editor', 'elementor' ),
		'show_in_rest'        => true,
		'show_in_menu'        => false,
		'menu_icon'           => 'dashicons-products',
	) );

	$cpt_slug = $shop_path . '/product';
	add_rewrite_rule(
		'^' . preg_quote( $cpt_slug, '/' ) . '/([^/]+)/?$',
		'index.php?ecellar_product=$matches[1]',
		'top'
	);

	// Route all other SPA subpaths (e.g. /shop/categorieslist/...) to the shop page
	// Excludes /shop/product/ which is handled by the CPT rule above
	$shop_page = get_page_by_path( $shop_path );
	if ( $shop_page ) {
		add_rewrite_rule(
			'^' . preg_quote( $shop_path, '/' ) . '/(?!product/)(.*)$',
			'index.php?page_id=' . $shop_page->ID,
			'top'
		);
	}

	update_option( 'betterseo_ecellar_product_owned', true );
}

// URL-decode the ecellar_product query var before WP sanitizes it
// so accented slugs (e.g. Cuv%C3%A9e) match the sanitized post_name correctly
add_filter( 'request', function ( $query_vars ) {
	if ( ! empty( $query_vars['ecellar_product'] ) ) {
		$query_vars['ecellar_product'] = rawurldecode( $query_vars['ecellar_product'] );
	}
	return $query_vars;
} );

// On CPT product pages, swap the sanitized URL to the raw eCellar slug
// before eCellar's SPA reads it — so it loads the correct product
add_action( 'wp_head', function () {
	if ( ! is_singular( 'ecellar_product' ) ) {
		return;
	}
	$post     = get_queried_object();
	$raw_slug = get_post_meta( $post->ID, '_ecellar_slug', true );
	if ( empty( $raw_slug ) ) {
		return;
	}
	?>
<script>
(function(){
	var raw   = <?php echo json_encode( $raw_slug ); ?>;
	var parts = location.pathname.replace(/\/$/, '').split('/');
	parts[parts.length - 1] = raw;
	var newPath = parts.join('/') + '/';
	if (location.pathname !== newPath) {
		history.replaceState(null, '', newPath + location.search + location.hash);
	}
})();
</script>
	<?php
}, 1 );

add_filter( 'redirect_canonical', function ( $redirect_url, $requested_url ) {
	if ( is_singular( 'ecellar_product' ) ) {
		return false;
	}
	$shop_path = get_option( 'betterseo_ecellar_shop_path', '' );
	if ( ! empty( $shop_path ) ) {
		$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? strtok( $_SERVER['REQUEST_URI'], '?' ) : '';
		if ( strpos( $request_uri, '/' . $shop_path . '/product/' ) !== false ) {
			return false;
		}
	}
	return $redirect_url;
}, 10, 2 );


/* =====================================================================
 * 2. AJAX SYNC TRIGGER
 * ===================================================================== */

add_action( 'wp_ajax_betterseo_ecellar_trigger_sync', 'betterseo_ecellar_ajax_trigger_sync' );
add_action( 'wp_ajax_nopriv_betterseo_ecellar_trigger_sync', 'betterseo_ecellar_ajax_trigger_sync' );

function betterseo_ecellar_ajax_trigger_sync() {
	$lock = get_option( 'betterseo_ecellar_sync_lock' );
	if ( $lock && ( time() - $lock ) < 300 ) {
		wp_send_json_success( array( 'skipped' => true ) );
		return;
	}
	betterseo_log( 'BetterSEO eCellar: Sync triggered via empty-state AJAX' );
	wp_clear_scheduled_hook( 'betterseo_run_ecellar_sync' );
	wp_schedule_single_event( time() + 1, 'betterseo_run_ecellar_sync' );
	if ( function_exists( 'spawn_cron' ) ) {
		spawn_cron();
	}
	wp_send_json_success();
}


/* =====================================================================
 * 3. BATCH SYNC
 * ===================================================================== */

function betterseo_sync_ecellar_products() {
	betterseo_log( 'BetterSEO eCellar: betterseo_sync_ecellar_products() called' );

	if ( get_option( 'betterseo_platform', 'commerce7' ) !== 'ecellar' ) {
		betterseo_log( 'BetterSEO eCellar: Skipping - platform is not ecellar' );
		return;
	}
	if ( ! post_type_exists( 'ecellar_product' ) ) {
		betterseo_log( 'BetterSEO eCellar: Skipping - CPT ecellar_product not registered' );
		return;
	}
	$api_key = get_option( 'betterseo_ecellar_api_key', '' );
	if ( empty( $api_key ) ) {
		betterseo_log( 'BetterSEO eCellar: Skipping - API key is empty' );
		return;
	}

	$batch_meta      = get_option( 'betterseo_ecellar_batch_meta' );
	$is_continuation = ( is_array( $batch_meta ) && isset( $batch_meta['offset'] ) );

	if ( ! $is_continuation ) {
		$lock = get_option( 'betterseo_ecellar_sync_lock' );
		if ( $lock && ( time() - $lock ) < 900 ) {
			betterseo_log( 'BetterSEO eCellar: Skipping - sync lock active (' . ( time() - $lock ) . 's ago)' );
			return;
		}
		update_option( 'betterseo_ecellar_sync_lock', time(), false );
	} else {
		betterseo_log( 'BetterSEO eCellar: Continuing batch from offset ' . $batch_meta['offset'] );
	}

	set_time_limit( 120 );
	ini_set( 'memory_limit', '256M' );

	$products = betterseo_fetch_ecellar_products( $api_key );
	if ( empty( $products ) ) {
		betterseo_log( 'BetterSEO eCellar: No products returned from API - aborting sync' );
		delete_option( 'betterseo_ecellar_batch_meta' );
		delete_option( 'betterseo_ecellar_sync_lock' );
		return;
	}

	$total = count( $products );

	if ( ! $is_continuation ) {
		$batch_meta = array(
			'offset'  => 0,
			'total'   => $total,
			'created' => 0,
			'updated' => 0,
			'skipped' => 0,
			'errors'  => 0,
			'start'   => time(),
		);
		betterseo_log( 'BetterSEO eCellar: Sync started - ' . $total . ' products' );
	}

	$batch_size = 50;
	$end        = min( $batch_meta['offset'] + $batch_size, $total );

	betterseo_log( 'BetterSEO eCellar: Processing items ' . $batch_meta['offset'] . ' to ' . ( $end - 1 ) );

	for ( $i = $batch_meta['offset']; $i < $end; $i++ ) {
		try {
			$result = betterseo_create_or_update_ecellar_product_post( $products[ $i ] );
			if ( $result === 'created' ) {
				$batch_meta['created']++;
			} elseif ( $result === 'updated' ) {
				$batch_meta['updated']++;
			} elseif ( $result === false ) {
				$batch_meta['skipped']++;
			}
		} catch ( Exception $e ) {
			$batch_meta['errors']++;
			betterseo_log( 'BetterSEO eCellar: Exception on item ' . $i . ' - ' . $e->getMessage() );
		}
	}

	$batch_meta['offset'] = $end;

	if ( $batch_meta['offset'] < $total ) {
		update_option( 'betterseo_ecellar_batch_meta', $batch_meta, false );
		betterseo_log( 'BetterSEO eCellar: Batch complete - ' . $batch_meta['offset'] . '/' . $total . ' | Created: ' . $batch_meta['created'] . ', Updated: ' . $batch_meta['updated'] . ', Skipped: ' . $batch_meta['skipped'] . ', Errors: ' . $batch_meta['errors'] );
		wp_schedule_single_event( time() + 2, 'betterseo_run_ecellar_sync' );
		if ( function_exists( 'spawn_cron' ) ) {
			spawn_cron();
		}
	} else {
		betterseo_log( 'BetterSEO eCellar: Sync complete - Created: ' . $batch_meta['created'] . ', Updated: ' . $batch_meta['updated'] . ', Skipped: ' . $batch_meta['skipped'] . ', Errors: ' . $batch_meta['errors'] );
		delete_option( 'betterseo_ecellar_batch_meta' );
		delete_option( 'betterseo_ecellar_sync_lock' );
		flush_rewrite_rules();
	}
}


/* =====================================================================
 * 4. API FETCH
 * ===================================================================== */

function betterseo_fetch_ecellar_products( $api_key ) {
	betterseo_log( 'BetterSEO eCellar: FETCHING products from eCellar API - Time: ' . date( 'Y-m-d H:i:s' ) );

	$curl = curl_init( 'https://public.ecellar-api.com/v1/products' );
	curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $curl, CURLOPT_HTTPHEADER, array( 'X-API-Key: ' . $api_key, 'User-Agent: WordPress' ) );
	curl_setopt( $curl, CURLOPT_TIMEOUT, 30 );

	$response  = curl_exec( $curl );
	$http_code = curl_getinfo( $curl, CURLINFO_HTTP_CODE );
	curl_close( $curl );

	if ( $response === false || $http_code !== 200 ) {
		betterseo_log( 'BetterSEO eCellar: API error (HTTP ' . $http_code . ')' );
		return array();
	}

	betterseo_log( 'BetterSEO eCellar: API response received (HTTP ' . $http_code . '), length: ' . strlen( $response ) . ' bytes' );

	$data = json_decode( $response, true );

	if ( isset( $data['products'] ) && is_array( $data['products'] ) ) {
		betterseo_log( 'BetterSEO eCellar: Parsed wrapped response - ' . count( $data['products'] ) . ' products' );
		return $data['products'];
	}

	if ( is_array( $data ) ) {
		betterseo_log( 'BetterSEO eCellar: Parsed flat array response - ' . count( $data ) . ' products' );
		return $data;
	}

	betterseo_log( 'BetterSEO eCellar: Invalid API response format - raw: ' . substr( $response, 0, 200 ) );
	return array();
}


/* =====================================================================
 * 4. CREATE / UPDATE CPT POST
 * ===================================================================== */

function betterseo_create_or_update_ecellar_product_post( $product ) {
	$raw_slug = $product['slug'] ?? '';
	if ( empty( $raw_slug ) ) {
		betterseo_log( 'BetterSEO eCellar: Product missing slug, skipping' );
		return false;
	}

	$slug            = $raw_slug;
	$sanitized_slug  = sanitize_title( $raw_slug );
	$title           = $product['product_name'] ?? $slug;
	$product_id      = $product['product_id'] ?? '';

	global $wpdb;

	$existing_id = $wpdb->get_var( $wpdb->prepare(
		"SELECT ID FROM {$wpdb->posts} WHERE post_name = %s AND post_type = 'ecellar_product' LIMIT 1",
		$sanitized_slug
	) );

	$post_data = array(
		'post_title'   => $title,
		'post_name'    => $sanitized_slug,
		'post_content' => '<div id="ecellar-content"></div>',
		'post_status'  => 'publish',
		'post_type'    => 'ecellar_product',
		'post_author'  => 1,
	);

	if ( $existing_id ) {
		$post_data['ID'] = $existing_id;
		wp_update_post( $post_data );
		update_post_meta( $existing_id, '_ecellar_product_id', $product_id );
		update_post_meta( $existing_id, '_ecellar_slug', $slug );
		betterseo_log( "BetterSEO eCellar: Updated post - Slug: $slug, ID: $existing_id" );
		return 'updated';
	}

	$post_id = wp_insert_post( $post_data );
	if ( is_wp_error( $post_id ) ) {
		betterseo_log( 'BetterSEO eCellar: Error creating post for slug: ' . $slug . ' - ' . $post_id->get_error_message() );
		return false;
	}

	update_post_meta( $post_id, '_ecellar_product_id', $product_id );
	update_post_meta( $post_id, '_ecellar_slug', $slug );
	update_post_meta( $post_id, '_elementor_edit_mode', 'builder' );

	betterseo_log( "BetterSEO eCellar: Created post - Slug: $slug, ID: $post_id" );
	return 'created';
}


/* =====================================================================
 * 5. SCHEDULE HELPER
 * ===================================================================== */

function betterseo_schedule_ecellar_sync( $delay_seconds = 0, $spawn = false ) {
	if ( get_option( 'betterseo_platform', 'commerce7' ) !== 'ecellar' ) {
		return;
	}
	if ( ! post_type_exists( 'ecellar_product' ) ) {
		return;
	}
	if ( empty( get_option( 'betterseo_ecellar_api_key', '' ) ) ) {
		return;
	}

	$delay_seconds = max( 1, (int) $delay_seconds );
	$timestamp     = time() + $delay_seconds;

	if ( ! wp_next_scheduled( 'betterseo_run_ecellar_sync' ) ) {
		wp_schedule_single_event( $timestamp, 'betterseo_run_ecellar_sync' );
		if ( $spawn && function_exists( 'spawn_cron' ) ) {
			spawn_cron();
		}
	}
}


/* =====================================================================
 * 6. API KEY CHANGE HANDLER
 * ===================================================================== */

add_action( 'update_option_betterseo_ecellar_shop_path', 'betterseo_on_ecellar_shop_path_change', 10, 3 );

function betterseo_on_ecellar_shop_path_change( $old_value, $value, $option ) {
	if ( $value === $old_value ) {
		return;
	}
	// Re-register CPT with new slug and flush rewrite rules
	betterseo_register_ecellar_product_cpt();
	flush_rewrite_rules();
	betterseo_log( 'BetterSEO eCellar: Shop path changed to "' . $value . '", rewrite rules flushed' );
}

add_action( 'update_option_betterseo_ecellar_api_key', 'betterseo_on_ecellar_api_key_change', 10, 3 );

function betterseo_on_ecellar_api_key_change( $old_value, $value, $option ) {
	if ( empty( $value ) || $value === $old_value ) {
		return;
	}

	betterseo_log( 'BetterSEO eCellar: API key changed, scheduling immediate async sync' );

	wp_clear_scheduled_hook( 'betterseo_run_ecellar_sync' );
	wp_schedule_single_event( time() + 1, 'betterseo_run_ecellar_sync' );

	if ( function_exists( 'spawn_cron' ) ) {
		spawn_cron();
	}
}


/* =====================================================================
 * 7. 404 HANDLER + SPA SUB-PAGE HANDLER
 * ===================================================================== */

// Serve the shop page for SPA sub-paths (categories, cart, etc.) that WP doesn't know about.
// Hook into the_posts — fires before handle_404() and before Elementor's wp action check,
// so Elementor fully initializes for the shop page.
add_filter( 'the_posts', 'betterseo_ecellar_spa_inject_shop_page', 10, 2 );

function betterseo_ecellar_spa_inject_shop_page( $posts, $query ) {
	if ( ! $query->is_main_query() || ! empty( $posts ) ) {
		return $posts;
	}
	if ( get_option( 'betterseo_platform', 'commerce7' ) !== 'ecellar' ) {
		return $posts;
	}

	$shop_path = get_option( 'betterseo_ecellar_shop_path', '' );
	if ( empty( $shop_path ) ) {
		return $posts;
	}

	$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? strtok( $_SERVER['REQUEST_URI'], '?' ) : '';
	$request_uri = trim( $request_uri, '/' );

	$pattern = '#^' . preg_quote( $shop_path, '#' ) . '/(?!product/)(.+)$#';
	if ( ! preg_match( $pattern, $request_uri ) ) {
		return $posts;
	}

	$shop_page = get_page_by_path( $shop_path );
	if ( ! $shop_page ) {
		return $posts;
	}

	// Returning the shop page here means handle_404() sees a result and won't set is_404.
	// Elementor's wp action hook then sees the correct page and fully initializes.
	$query->is_404            = false;
	$query->is_page           = true;
	$query->is_singular       = true;
	$query->queried_object    = $shop_page;
	$query->queried_object_id = $shop_page->ID;
	status_header( 200 );

	return array( $shop_page );
}

add_action( 'template_redirect', 'betterseo_handle_ecellar_product_404' );

function betterseo_handle_ecellar_product_404() {
	if ( get_option( 'betterseo_platform', 'commerce7' ) !== 'ecellar' ) {
		return;
	}

	$shop_path = get_option( 'betterseo_ecellar_shop_path', '' );
	if ( empty( $shop_path ) || ! is_404() ) {
		return;
	}

	$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : '';
	$request_uri = strtok( $request_uri, '?' );
	$request_uri = trim( $request_uri, '/' );

	$pattern = '#^' . preg_quote( $shop_path, '#' ) . '/product/([^/]+)$#';
	if ( ! preg_match( $pattern, $request_uri, $matches ) ) {
		return;
	}

	$slug      = rawurldecode( $matches[1] );
	$sanitized = sanitize_title( $slug );

	// If slug differs from sanitized (e.g. has accents/uppercase),
	// check if the post exists with the sanitized slug and redirect to it
	if ( $slug !== $sanitized ) {
		$existing = get_posts( array(
			'post_type'      => 'ecellar_product',
			'name'           => $sanitized,
			'posts_per_page' => 1,
			'post_status'    => 'publish',
		) );
		if ( ! empty( $existing ) ) {
			wp_redirect( get_permalink( $existing[0]->ID ), 302 );
			exit;
		}
	}

	betterseo_log( "BetterSEO eCellar: 404 detected for slug: $slug - Triggering sync" );

	if ( get_transient( 'betterseo_ecellar_last_404_sync' ) ) {
		betterseo_log( 'BetterSEO eCellar: Sync already triggered recently, skipping' );
		return;
	}

	set_transient( 'betterseo_ecellar_last_404_sync', time(), 5 * MINUTE_IN_SECONDS );
	betterseo_log( 'BetterSEO eCellar: Sync scheduled via 404 handler' );
	betterseo_schedule_ecellar_sync( 1, true );
}


/* =====================================================================
 * 8. FRONTEND LAYOUT CSS
 * ===================================================================== */

add_action( 'wp_head', 'betterseo_ecellar_product_layout_css', 30 );

function betterseo_ecellar_product_layout_css() {
	if ( ! is_singular( 'ecellar_product' ) ) {
		return;
	}

	echo '<style id="betterseo-ecellar-product-layout">'
		. '#ecellar-content{max-width:1200px;margin:0 auto;padding:0 20px;box-sizing:border-box;}'
		. '.single-ecellar_product .entry-title{display:none;}'
		. '</style>';
}


/* =====================================================================
 * 9. OPENGRAPH META TAGS
 * ===================================================================== */

add_action( 'wp_head', 'gorilion_opengraph_ecellar' );

function gorilion_opengraph_ecellar() {
	$platform = get_option( 'betterseo_platform' );
	if ( $platform !== 'ecellar' ) {
		return;
	}

	$ecellar_api_key = get_option( 'betterseo_ecellar_api_key' );
	global $post;

	if ( empty( $post ) ) {
		return;
	}

	$shop_path = get_option( 'betterseo_ecellar_shop_path', '' );
	$is_cpt    = is_singular( 'ecellar_product' );
	$is_page   = ( ! $is_cpt && ! empty( $shop_path ) && $post->post_name === $shop_path );
	$queried   = get_queried_object();

	if ( ! $is_page && ! $is_cpt ) {
		return;
	}

	$key = $ecellar_api_key;

	// In CPT mode use get_queried_object() — $post is swapped by template_include
	if ( $is_cpt ) {
		$result = get_post_meta( $queried->ID, '_ecellar_slug', true ) ?: ( $queried->post_name ?? '' );
	} else {
		$request_url = trim( $_SERVER['REQUEST_URI'], '/' );

		if ( str_contains( $request_url, 'product/' ) ) {
			$result = end( explode( '/', $request_url ) );
		} elseif ( ! empty( $_SERVER['QUERY_STRING'] ) ) {
			parse_str( $_SERVER['QUERY_STRING'], $queryParams );
			if ( ! empty( $queryParams['slug'] ) ) {
				$result = $queryParams['slug'];
			}
		}
	}


	if ( empty( $result ) ) {
		return;
	}

	$headers      = array( 'X-API-Key: ' . $key, 'User-Agent: WordPress' );
	$result_encoded = rawurlencode( $result );

	// Fetch product data
	$curl = curl_init( 'https://public.ecellar-api.com/v1/products/' . $result_encoded );
	curl_setopt_array( $curl, array(
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HTTPHEADER     => $headers,
	) );
	$responseData = curl_exec( $curl );

	// Fetch metadata
	$curl2 = curl_init( 'https://public.ecellar-api.com/v1/products/' . $result_encoded . '/metadata' );
	curl_setopt_array( $curl2, array(
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HTTPHEADER     => $headers,
	) );
	$responseMetadata = curl_exec( $curl2 );

	if ( $responseData === false || empty( $responseData ) ) {
		echo '<!-- BetterSEO eCellar: Error fetching product data: ' . esc_html( curl_error( $curl ) ) . ' -->' . PHP_EOL;
		curl_close( $curl );
		curl_close( $curl2 );
		return;
	}
	curl_close( $curl );
	curl_close( $curl2 );

	$response         = json_decode( $responseData );
	$responseMetadata = json_decode( $responseMetadata );

	// Clean helpers
	$clean_text = function ( $val ) {
		if ( ! is_string( $val ) ) {
			$val = (string) $val;
		}
		$val = html_entity_decode( $val, ENT_QUOTES | ENT_HTML5, 'UTF-8' );
		$val = preg_replace( '/<\s*br\b[^>]*>/i', ' ', $val );
		$val = strip_tags( $val );
		$val = preg_replace( '/\s+/u', ' ', $val );
		$val = str_replace( '"', '', $val );
		return trim( $val );
	};

	// --- CASE 1: ARRAY response (catalog) ---
	if ( is_array( $response ) ) {
		$encoded    = json_encode( $response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
		$site_title = get_bloginfo( 'name' );
		$url        = 'https://' . rtrim( $_SERVER['HTTP_HOST'], '/' ) . '/' . trim( $_SERVER['REQUEST_URI'], '/' );

		echo '<!-- BetterSEO meta :: VERSION ' . BETTERSEO_VERSION . ' :: ECELLAR -->' . PHP_EOL;
		echo '<meta name="description" content="" />' . PHP_EOL;
		echo '<meta name="keywords" content="" />' . PHP_EOL;
		echo "<link rel=\"canonical\" href=\"{$url}\"/>" . PHP_EOL;
		echo '<meta property="og:type" content="product" />' . PHP_EOL;
		echo '<meta property="og:title" content="" />' . PHP_EOL;
		echo '<meta property="og:description" content="" />' . PHP_EOL;
		echo '<meta property="og:image" content="" />' . PHP_EOL;
		echo '<meta property="og:site_name" content="' . esc_attr( $site_title ) . '" />' . PHP_EOL;
		echo '<script type="application/ld+json" class="ecellar-jsonld">{}</script>' . PHP_EOL;
		?>
<script>
	(function(){
		var catalog = <?php echo $encoded; ?>;

		function clean(t){
			t = (t || "").toString();
			t = t.replace(/<\s*br\s*\/?>/gi, ' ');
			t = t.replace(/<[^>]+>/g, '');
			t = t.replace(/\s+/g, ' ').trim();
			return t.replace(/"/g, '');
		}

		function setMeta(selector, attr, value){
			var el = document.querySelector(selector);
			if(!el){
				el = document.createElement('meta');
				if (selector.indexOf('property="') !== -1) {
					el.setAttribute('property', selector.match(/property="([^"]+)"/)[1]);
				} else if (selector.indexOf('name="') !== -1) {
					el.setAttribute('name', selector.match(/name="([^"]+)"/)[1]);
				}
				document.head.appendChild(el);
			}
			if (el.getAttribute(attr) !== value) el.setAttribute(attr, value);
		}

		function applyFrom(prod){
			if(!prod) return;

			var title = clean(prod.product_name || "");
			var desc  = clean(prod.description || "");
			if (desc.length > 200) desc = desc.slice(0,200);
			var img   = prod.image_1 || prod.header_image || "";
			var price = prod.price || "";
			var site  = <?php echo json_encode( $site_title ); ?>;

			if (document.title !== title) document.title = title;
			setMeta('meta[property="og:title"]', 'content', title);
			setMeta('meta[name="description"]', 'content', desc);
			setMeta('meta[property="og:description"]', 'content', desc);
			if (img) setMeta('meta[property="og:image"]', 'content', img);

			var ld = {
				"@context":"http://schema.org",
				"@type":"Product",
				"name": title,
				"image": img || undefined,
				"description": desc,
				"brand": {"@type":"Brand","name": site},
				"offers": {"@type":"Offer","priceCurrency":"USD","price": String(price || "")}
			};
			var s = document.querySelector('script[type="application/ld+json"].ecellar-jsonld');
			if (!s){ s = document.createElement('script'); s.type='application/ld+json'; s.className='ecellar-jsonld'; document.head.appendChild(s); }
			s.textContent = JSON.stringify(ld);
		}

		function getCurrentId(){
			var sel = ['.ecp_ProductDetail > [data-ecp-id]','.ecp_ProductDetail [data-ecp-id]','[data-ecp-id]'];
			for (var i=0;i<sel.length;i++){
				var el = document.querySelector(sel[i]);
				if (el) {
					var v = el.getAttribute('data-ecp-id');
					if (v && v.trim() !== '') return String(v).trim();
				}
			}
			return null;
		}

		function tryResolve(){
			var pid = getCurrentId();
			if (!pid) { console.warn('BetterSEO eCellar: data-ecp-id not found yet.'); return false; }
			console.log('BetterSEO eCellar: resolved data-ecp-id =', pid);
			var prod = catalog.find(function(it){ return String(it.product_id) === String(pid); });
			if (!prod) { console.warn('BetterSEO eCellar: product id ' + pid + ' not found in catalog.'); return false; }
			applyFrom(prod);
			return true;
		}

		if (!tryResolve()){
			var attempts = 0;
			var iv = setInterval(function(){ attempts++; if (tryResolve() || attempts >= 10) clearInterval(iv); }, 500);
		}

		var host = document.querySelector('.ecp_ProductDetail') || document.body;
		var mo = new MutationObserver(function(){ tryResolve(); });
		mo.observe(host, {subtree:true, childList:true, attributes:true, attributeFilter:['data-ecp-id']});
		setTimeout(function(){ try { mo.disconnect(); } catch(e){} }, 10000);
	})();
</script>
		<?php
		return;
	}

	// --- CASE 2: Single product object ---
	$title_src   = $responseMetadata->meta_title ?? $response->product_name ?? '';
	$title       = $clean_text( $title_src );
	$desc_src    = $responseMetadata->meta_description ?? '';
	$description = mb_substr( $clean_text( $desc_src ), 0, 200 );
	$keywords    = $clean_text( $responseMetadata->meta_keywords ?? '' );
	$price       = isset( $response->price ) ? ( $response->price / 1.00 ) : '';
	$img         = ! empty( $response->image_1 ) ? $response->image_1 : ( $response->header_image ?? '' );
	$site_title  = get_bloginfo( 'name' );
	$url         = 'https://' . rtrim( $_SERVER['HTTP_HOST'], '/' ) . '/' . trim( $_SERVER['REQUEST_URI'], '/' );

	add_filter( 'pre_get_document_title', fn() => $title, 99 );
	add_filter( 'document_title_parts', fn( $parts ) => array( 'title' => $title ), 99 );
	add_filter( 'wpseo_title', fn() => $title, 99 );
	add_filter( 'rank_math/frontend/title', fn() => $title, 99 );

	echo '<!-- BetterSEO meta :: VERSION ' . BETTERSEO_VERSION . ' -->' . PHP_EOL;
	echo "<meta name=\"description\" content=\"{$description}\"/>" . PHP_EOL;
	echo "<meta name=\"keywords\" content=\"{$keywords}\"/>" . PHP_EOL;
	echo "<link rel=\"canonical\" href=\"{$url}\"/>" . PHP_EOL;
	echo '<meta property="og:type" content="product" />' . PHP_EOL;
	echo "<meta property=\"og:title\" content=\"{$title}\"/>" . PHP_EOL;
	echo "<meta property=\"og:description\" content=\"{$description}\"/>" . PHP_EOL;
	echo "<meta property=\"og:image\" content=\"{$img}\"/>" . PHP_EOL;
	echo "<meta property=\"og:image:secure_url\" content=\"{$img}\"/>" . PHP_EOL;
	echo '<meta property="og:image:width" content="1200"/>' . PHP_EOL;
	echo '<meta property="og:image:height" content="630"/>' . PHP_EOL;
	echo "<meta property=\"og:url\" content=\"{$url}\"/>" . PHP_EOL;
	echo "<meta property=\"og:site_name\" content=\"{$site_title}\" />" . PHP_EOL;
	echo '<meta name="twitter:card" content="summary_large_image"/>' . PHP_EOL;
	echo "<meta name=\"twitter:image\" content=\"{$img}\"/>" . PHP_EOL;

	echo '<script type="application/ld+json">' . PHP_EOL;
	echo json_encode( array(
		'@context'    => 'http://schema.org',
		'@type'       => 'Product',
		'name'        => $title,
		'image'       => $img,
		'description' => $description,
		'brand'       => array(
			'@type' => 'Brand',
			'name'  => $site_title,
			'logo'  => esc_url( wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' )[0] ?? '' ),
		),
		'offers'      => array(
			'@type'         => 'Offer',
			'priceCurrency' => 'USD',
			'price'         => $price,
		),
	), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
	echo '</script>' . PHP_EOL;
}


/* =====================================================================
 * 10. EARLY TITLE RESOLVER (page mode only)
 * ===================================================================== */

add_action( 'wp', 'betterseo_ecellar_early_title_resolver', 1 );

function betterseo_ecellar_early_title_resolver() {
	if ( get_option( 'betterseo_platform' ) !== 'ecellar' ) {
		return;
	}

	global $post;
	if ( empty( $post ) ) {
		return;
	}

	// Only run in page mode (not for CPT posts — they have their own title)
	if ( $post->post_type === 'ecellar_product' ) {
		return;
	}

	$shop_path = get_option( 'betterseo_ecellar_shop_path', '' );
	if ( empty( $shop_path ) || $post->post_name !== $shop_path ) {
		return;
	}

	// Resolve slug from URL
	$request_url = trim( $_SERVER['REQUEST_URI'] ?? '', '/' );
	$slug        = '';

	if ( $request_url && strpos( $request_url, 'product/' ) !== false ) {
		$parts = explode( '/', $request_url );
		$slug  = rawurldecode( end( $parts ) );
	} elseif ( ! empty( $_SERVER['QUERY_STRING'] ) ) {
		parse_str( $_SERVER['QUERY_STRING'], $qp );
		if ( ! empty( $qp['slug'] ) ) {
			$slug = $qp['slug'];
		}
	}

	if ( ! $slug ) {
		return;
	}

	$slug_api = rawurlencode( $slug );
	$key      = get_option( 'betterseo_ecellar_api_key' );
	$headers  = array( "X-API-Key: {$key}", 'User-Agent: WordPress' );

	$curl = curl_init( "https://public.ecellar-api.com/v1/products/{$slug}/metadata" );
	curl_setopt_array( $curl, array(
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HTTPHEADER     => $headers,
		CURLOPT_TIMEOUT        => 5,
	) );
	$metaRaw = curl_exec( $curl );
	curl_close( $curl );

	$metaObj = $metaRaw ? json_decode( $metaRaw ) : null;

	if ( empty( $metaObj->meta_title ) ) {
		$curl = curl_init( "https://public.ecellar-api.com/v1/products/{$slug_api}" );
		curl_setopt_array( $curl, array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER     => $headers,
			CURLOPT_TIMEOUT        => 5,
		) );
		$prodRaw = curl_exec( $curl );
		curl_close( $curl );
		$prodObj  = $prodRaw ? json_decode( $prodRaw ) : null;
		$rawTitle = $metaObj->meta_title ?? ( $prodObj->product_name ?? '' );
	} else {
		$rawTitle = $metaObj->meta_title;
	}

	$clean = function ( $val ) {
		if ( ! is_string( $val ) ) {
			$val = (string) $val;
		}
		$val = html_entity_decode( $val, ENT_QUOTES | ENT_HTML5, 'UTF-8' );
		$val = preg_replace( '/<\s*br\b[^>]*>/i', ' ', $val );
		$val = strip_tags( $val );
		$val = preg_replace( '/\s+/u', ' ', $val );
		$val = str_replace( '"', '', $val );
		return trim( $val );
	};

	$finalTitle = $clean( $rawTitle );
	if ( $finalTitle === '' ) {
		return;
	}

	$GLOBALS['gorilion_ecellar_final_title'] = $finalTitle;

	$force = function () use ( $finalTitle ) { return $finalTitle; };
	add_filter( 'pre_get_document_title', $force, PHP_INT_MAX );
	add_filter( 'document_title_parts', function ( $parts ) use ( $finalTitle ) {
		$parts['title'] = $finalTitle;
		return $parts;
	}, PHP_INT_MAX );
	add_filter( 'wpseo_title', $force, PHP_INT_MAX );
	add_filter( 'rank_math/frontend/title', $force, PHP_INT_MAX );

	add_action( 'wp_print_scripts', function () use ( $finalTitle ) {
		echo '<script>if(document && document.title!=="' . esc_js( $finalTitle ) . '"){document.title="' . esc_js( $finalTitle ) . '";}</script>';
	}, PHP_INT_MAX );
}


/* =====================================================================
 * 11. CLIENT-SIDE TITLE WATCHER (page mode only)
 * ===================================================================== */

add_action( 'wp_print_scripts', 'betterseo_ecellar_title_watcher_script', PHP_INT_MAX );

function betterseo_ecellar_title_watcher_script() {
	if ( empty( $GLOBALS['gorilion_ecellar_final_title'] ) ) {
		return;
	}
	$finalTitle = $GLOBALS['gorilion_ecellar_final_title'];
	?>
<script>
	(function () {
		var DESIRED = <?php echo json_encode( $finalTitle, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ); ?>;

		function clean(s) {
			s = (s || '').toString();
			var t = document.createElement('textarea'); t.innerHTML = s; s = t.value;
			s = s.replace(/<\s*br\s*\/?>/gi, ' ');
			s = s.replace(/<[^>]*>/g, ' ');
			s = s.replace(/\s+/g, ' ').trim();
			return s.replace(/"/g, '');
		}

		function apply() {
			if (clean(document.title) !== DESIRED) { document.title = DESIRED; }
			[
				['meta[property="og:title"]','content'],
				['meta[name="twitter:title"]','content'],
				['meta[name="title"]','content']
			].forEach(function (pair) {
				var el = document.querySelector(pair[0]);
				if (el && clean(el.getAttribute(pair[1])) !== DESIRED) {
					el.setAttribute(pair[1], DESIRED);
				}
			});
		}

		apply();

		var stopAt = Date.now() + 8000;
		var mo = new MutationObserver(function () {
			apply();
			if (Date.now() > stopAt) mo.disconnect();
		});
		mo.observe(document.head || document.documentElement, {
			subtree: true, childList: true, attributes: true, attributeFilter: ['content']
		});

		window.addEventListener('load', function () {
			setTimeout(apply, 0);
			setTimeout(apply, 1200);
			setTimeout(apply, 3500);
		});
	})();
</script>
	<?php
}


/* =====================================================================
 * 12. SPA META OVERWRITE
 * ===================================================================== */

add_action( 'wp_print_scripts', 'betterseo_ecellar_spa_script', PHP_INT_MAX - 1 );

function betterseo_ecellar_spa_script() {
	if ( get_option( 'betterseo_platform' ) !== 'ecellar' ) {
		return;
	}

	global $post;
	if ( empty( $post ) ) {
		return;
	}

	$shop_path = get_option( 'betterseo_ecellar_shop_path', '' );
	$is_cpt    = is_singular( 'ecellar_product' );
	$is_page   = ( ! $is_cpt && ! empty( $shop_path ) && $post->post_name === $shop_path );

	if ( ! $is_page && ! $is_cpt ) {
		return;
	}

	$site_title = get_bloginfo( 'name' );
	?>
<script>
	(function(){
		function cleanTitle(t){
			t = (t || "").toString();
			t = t.replace(/<\s*br\s*\/?>/gi, ' ');
			t = t.replace(/<[^>]+>/g, '');
			t = t.replace(/\s+/g, ' ').trim();
			return t.replace(/"/g, '');
		}
		var _titleDesc = Object.getOwnPropertyDescriptor(Document.prototype, 'title') || Object.getOwnPropertyDescriptor(HTMLDocument.prototype, 'title');
		if (_titleDesc && _titleDesc.set) {
			Object.defineProperty(document, 'title', {
				get: function(){ return _titleDesc.get.call(document); },
				set: function(v){ _titleDesc.set.call(document, cleanTitle(v)); },
				configurable: true
			});
		}

		function q(s){return document.querySelector(s);}
		function getParam(n){ try{ return new URL(location.href).searchParams.get(n); }catch(e){ return null; } }
		function clean(s){
			s = (s || "").toString();
			var t = document.createElement('textarea'); t.innerHTML = s; s = t.value;
			s = s.replace(/<\s*br\b[^>]*>/gi, ' ');
			s = s.replace(/<[^>]*>/g, '');
			s = s.replace(/\s+/g, ' ').trim();
			return s.replace(/"/g, '');
		}
		function titleCase(str){
			str = (str || '').toLowerCase().replace(/[-_]+/g,' ').replace(/\s+/g,' ').trim();
			return str.replace(/\b\w/g, c => c.toUpperCase());
		}
		function setMeta(selector, attr, value){
			var el = q(selector);
			if(!el){
				el = document.createElement('meta');
				if (selector.indexOf('property="') !== -1) el.setAttribute('property', selector.match(/property="([^"]+)"/)[1]);
				else if (selector.indexOf('name="') !== -1) el.setAttribute('name', selector.match(/name="([^"]+)"/)[1]);
				(document.head||document.documentElement).appendChild(el);
			}
			value = (value==null) ? '' : String(value);
			if (el.getAttribute(attr) !== value) el.setAttribute(attr, value);
		}
		function setLink(rel, href){
			var el = q('link[rel="'+rel+'"]');
			if(!el){ el = document.createElement('link'); el.setAttribute('rel', rel); (document.head||document.documentElement).appendChild(el); }
			if (href && el.getAttribute('href') !== href) el.setAttribute('href', href);
		}
		function isCategoryView(){ return (getParam('view') === 'products' && !!getParam('slug')); }

		function collectProduct(){
			var nameEl = q('.ecp_ProductDetail [data-ecp-name]') || q('.ecp_ProductDetail h1') || q('.ecp-columns-right h2') || q('.product_title');
			var descEl = q('.ecp_ProductDetail [data-ecp-description]') || q('.ecp_ProductDetail .product-description') || q('.ecp-columns-right p');
			var imgEl  = q('.ecp_ProductDetail img[data-ecp-image], .ecp_ProductDetail img[src]');
			var title = clean((nameEl && (nameEl.getAttribute('data-ecp-name') || nameEl.innerHTML || nameEl.textContent)) ||
							  (q('meta[property="og:title"]') && q('meta[property="og:title"]').content) ||
							  document.title);
			var desc  = clean((descEl && (descEl.getAttribute('data-ecp-description') || descEl.innerHTML || descEl.textContent)) ||
							  (q('meta[name="description"]') && q('meta[name="description"]').content) ||
							  (q('meta[property="og:description"]') && q('meta[property="og:description"]').content) || '');
			if (desc.length > 200) desc = desc.slice(0,200);
			var img   = (imgEl && (imgEl.getAttribute('data-ecp-image') || imgEl.src)) ||
				(q('meta[property="og:image"]') && q('meta[property="og:image"]').content) || '';
			var priceEl = q('[data-ecp-price]') || q('[data-price]') || q('.product-price, .price');
			var price = priceEl ? clean(priceEl.getAttribute('data-ecp-price') || priceEl.getAttribute('data-price') || priceEl.textContent) : '';
			return { title, desc, img, price, url: location.href };
		}
		function collectCategory(){
			var catTitleEl = q('.ecp_ProductList [data-ecp-collection-name]') ||
				q('.ecp_ProductList h1') || q('.collection-title') ||
				q('.ecp-columns-right h1') || q('.ecp-columns-right h2');
			var title = clean((catTitleEl && (catTitleEl.getAttribute?.('data-ecp-collection-name') || catTitleEl.innerHTML || catTitleEl.textContent)));
			if (!title) title = (function(){ var s=getParam('slug')||''; return s?titleCase(s):''; })();
			var descEl = q('.ecp_ProductList .collection-description') || q('.ecp-columns-right p');
			var desc = clean(descEl ? (descEl.innerHTML || descEl.textContent) : '');
			if (desc.length > 200) desc = desc.slice(0,200);
			var imgEl = q('.ecp_ProductList img[data-ecp-image], .ecp_ProductList img[src]');
			var img = imgEl ? (imgEl.getAttribute('data-ecp-image') || imgEl.src) : (q('meta[property="og:image"]')?.content || '');
			return { title, desc, img, price: '', url: location.href };
		}

		var isApplying = false;
		var lastApplied = {title:'', desc:'', img:'', url:''};
		function apply(d){
			if(!d) return;
			if (d.title === lastApplied.title && d.desc===lastApplied.desc && d.img===lastApplied.img && d.url===lastApplied.url) return;
			isApplying = true;

			if (d.title && document.title !== d.title) document.title = d.title;
			if (d.url){ setLink('canonical', d.url); setMeta('meta[property="og:url"]','content', d.url); }
			if (d.desc){ setMeta('meta[name="description"]','content', d.desc); setMeta('meta[property="og:description"]','content', d.desc); setMeta('meta[name="twitter:description"]','content', d.desc); }
			if (d.title){ setMeta('meta[property="og:title"]','content', d.title); setMeta('meta[name="title"]','content', d.title); setMeta('meta[name="twitter:title"]','content', d.title); }
			if (d.img){ setMeta('meta[property="og:image"]','content', d.img); setMeta('meta[name="twitter:image"]','content', d.img); }
			setMeta('meta[property="og:site_name"]','content', <?php echo json_encode( $site_title ); ?>);
			setMeta('meta[name="twitter:card"]','content', 'summary_large_image');

			if (!isCategoryView()){
				try{
					var s = document.querySelector('script[type="application/ld+json"].ecellar-jsonld');
					if (!s){ s = document.createElement('script'); s.type='application/ld+json'; s.className='ecellar-jsonld'; (document.head||document.documentElement).appendChild(s); }
					s.textContent = JSON.stringify({
						"@context":"http://schema.org","@type":"Product",
						"name": d.title || undefined,
						"image": d.img || undefined,
						"description": d.desc || undefined,
						"brand": {"@type":"Brand","name": <?php echo json_encode( $site_title ); ?>},
						"offers": {"@type":"Offer","priceCurrency":"USD","price": (d.price?String(d.price):undefined)}
					});
				}catch(e){}
			}
			lastApplied = {title:d.title, desc:d.desc, img:d.img, url:d.url};
			setTimeout(function(){ isApplying = false; }, 0);
		}

		var tDebounce = null;
		function scheduleApply(delay){
			if (tDebounce) clearTimeout(tDebounce);
			tDebounce = setTimeout(function(){ apply(isCategoryView() ? collectCategory() : collectProduct()); }, delay || 0);
		}

		var lastHref = location.href;
		function onUrlMaybeChanged(){
			if (location.href !== lastHref){
				lastHref = location.href;
				scheduleApply(0); scheduleApply(400); scheduleApply(1200);
			}
		}
		document.addEventListener('click', function(){ setTimeout(onUrlMaybeChanged, 0); setTimeout(onUrlMaybeChanged, 200); }, true);
		['pushState','replaceState'].forEach(function(fn){
			var orig = history[fn]; if(!orig) return;
			history[fn] = function(){ var ret = orig.apply(this, arguments); onUrlMaybeChanged(); return ret; };
		});
		window.addEventListener('popstate', onUrlMaybeChanged);
		window.addEventListener('hashchange', onUrlMaybeChanged);

		var headMO = new MutationObserver(function(muts){
			if (isApplying) return;
			var relevant = muts.some(function(m){ return m.type==='attributes' && ['content','href'].includes(m.attributeName); });
			if (relevant) scheduleApply(80);
		});
		headMO.observe(document.head || document.documentElement, {subtree:true, attributes:true, attributeFilter:['content','href']});

		var host = q('.ecp_ProductDetail') || document.body;
		var bodyMO = new MutationObserver(function(){ if (!isApplying) scheduleApply(120); });
		bodyMO.observe(host, {subtree:true, childList:true, attributes:true});

		function runInitial(){ scheduleApply(0); scheduleApply(400); scheduleApply(1200); }
		if (document.readyState === 'complete' || document.readyState === 'interactive'){ runInitial(); }
		else { document.addEventListener('DOMContentLoaded', runInitial); window.addEventListener('load', runInitial); }

		// Empty-state detector: if Elementor posts widget shows nothing-found, trigger a sync and reload
		(function(){
			var ajaxUrl = <?php echo json_encode( admin_url( 'admin-ajax.php' ) ); ?>;
			var triggered = false;
			function checkEmpty() {
				if ( triggered ) return;
				var el = document.querySelector( '.elementor-posts-nothing-found' );
				if ( el && el.offsetParent !== null ) {
					triggered = true;
					betterseo_log_empty();
					var xhr = new XMLHttpRequest();
					xhr.open( 'POST', ajaxUrl );
					xhr.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
					xhr.onload = function() { setTimeout( function(){ location.reload(); }, 3000 ); };
					xhr.send( 'action=betterseo_ecellar_trigger_sync' );
				}
			}
			function betterseo_log_empty(){ try{ console.log('BetterSEO eCellar: empty state detected, triggering sync'); }catch(e){} }
			setTimeout( checkEmpty, 1500 );
			setTimeout( checkEmpty, 4000 );
		})();
	})();
</script>
	<?php
}
