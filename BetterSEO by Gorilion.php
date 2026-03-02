<?php
/**
 * Plugin Name: BetterSEO by Gorilion
 * Plugin URI: https://www.gorilion.com/better-seo/
 * Description: Dynamically enable code for Rank Math or Yoast SEO, and update from GitHub.
 * Version: 1.42
 * Author: Gorilion
 * Author URI: https://www.gorilion.com
 * License: GPL2
 * Text Domain: gorilion-seo-switcher
 *
 * -----------------------------------------------------------------------
 * This plugin allows an admin to choose which SEO plugin (Rank Math or Yoast)
 * they use. Depending on that choice, it hooks specific functions into 'wp_head'
 * and optionally disables certain SEO plugin features.
 *
 * Additionally, it supports GitHub-based updates if the Plugin Update Checker
 * library is included in a "plugin-update-checker" subfolder.
 * -----------------------------------------------------------------------
 */

// Prevent direct file access.
if (!defined('ABSPATH')) {
	exit;
}

if (!defined('BETTERSEO_VERSION')) {
	$data = get_file_data(__FILE__, array('Version' => 'Version'), 'plugin');
	define('BETTERSEO_VERSION', isset($data['Version']) ? $data['Version'] : '');
}

/**
 * ------------------------------------------------------------------
 * PLUGIN ACTIVATION HOOK
 * ------------------------------------------------------------------
 */
register_activation_hook(__FILE__, 'betterseo_activation');
function betterseo_activation() {
	// Don't make assumptions on first install - wait for user to configure settings
	// Only check if c7_product CPT already exists from another plugin
	if (post_type_exists('c7_product') && !get_option('betterseo_c7_product_owned')) {
		wp_die(__('BetterSEO by Gorilion cannot be activated because the post type "c7_product" already exists.', 'gorilion-seo-switcher'));
	}
	
	// Flush rewrite rules
	flush_rewrite_rules();
}

// Cron handlers for product sync.
add_action('betterseo_daily_product_sync', 'betterseo_sync_c7_products');
add_action('betterseo_run_product_sync', 'betterseo_sync_c7_products');

function betterseo_schedule_product_sync($delay_seconds = 0, $spawn = false) {
	if (betterseo_get_mode() !== 'cpt') {
		return;
	}

	$platform = get_option('betterseo_platform', 'commerce7');
	if ($platform !== 'commerce7') {
		return;
	}

	if (!post_type_exists('c7_product')) {
		return;
	}

	$tenant_id = get_option('betterseo_tenant_id', '');
	if (empty($tenant_id)) {
		return;
	}
	
	$delay_seconds = max(1, (int) $delay_seconds);
	$timestamp = time() + $delay_seconds;
	if (!wp_next_scheduled('betterseo_run_product_sync')) {
		wp_schedule_single_event($timestamp, 'betterseo_run_product_sync');
		if ($spawn && function_exists('spawn_cron')) {
			spawn_cron();
		}
	}
}

/**
 * ------------------------------------------------------------------
 * PLUGIN DEACTIVATION HOOK
 * ------------------------------------------------------------------
 */
register_deactivation_hook(__FILE__, 'betterseo_deactivation');
function betterseo_deactivation() {
	// Clear scheduled cron jobs
	wp_clear_scheduled_hook('betterseo_daily_product_sync');
	wp_clear_scheduled_hook('betterseo_run_product_sync');
	
	// Flush rewrite rules
	flush_rewrite_rules();
}

/**
 * ------------------------------------------------------------------
 * 1) GITHUB PLUGIN UPDATE CONFIGURATION
 * ------------------------------------------------------------------
 */

$puc_path = plugin_dir_path(__FILE__) . 'plugin-update-checker/plugin-update-checker.php';
if (file_exists($puc_path)) {
	require_once $puc_path;
	$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
		'https://github.com/mdeiriondo/BetterSEO',
		__FILE__,
		'BetterSEO by Gorilion'
	);
	$myUpdateChecker->setBranch('main');
}


/**
 * ------------------------------------------------------------------
 * 2) ADMIN SETTINGS PAGE
 * ------------------------------------------------------------------
 *
 * This adds a page under "Settings" that lets you choose Rank Math or Yoast,
 * and also configure the Tenant ID.
 */
add_action('admin_menu', 'gorilion_seo_switcher_admin_menu');

function gorilion_seo_switcher_admin_menu()
{
	add_options_page(
		'BetterSEO Configuration',  // Page title
		'BetterSEO',                // Menu title
		'manage_options',           // Capability required
		'gorilion_seo_switcher',    // Menu slug
		'gorilion_seo_switcher_options_page'  // Callback function
	);
}

// Register the settings where we store the user's choices.
add_action('admin_init', 'gorilion_seo_switcher_register_settings');

function gorilion_seo_switcher_register_settings()
{
	// Register the SEO plugin choice setting.
	register_setting(
		'gorilion_seo_switcher_settings_group',
		'gorilion_seo_switcher_choice'
	);
	// Register the Tenant ID setting.
	register_setting(
		'gorilion_seo_switcher_settings_group',
		'betterseo_tenant_id'
	);
	// Platform selector: commerce7 | ecellar
	register_setting(
		'gorilion_seo_switcher_settings_group', 
		'betterseo_platform'
	);
	// eCellar credentials
	register_setting(
		'gorilion_seo_switcher_settings_group', 
		'betterseo_ecellar_api_key'
	);
	// BetterSEO fields
	register_setting(
		'gorilion_seo_switcher_settings_group',
		'betterseo_user'
	);
	// Mode: 'cpt' (new) or 'page' (legacy)
	register_setting(
		'gorilion_seo_switcher_settings_group',
		'betterseo_mode'
	);
}

/**
 * Trash /product page when settings are saved in CPT + Commerce7 mode
 */
add_action('update_option_betterseo_mode', 'betterseo_trash_product_page_on_save', 10, 3);
add_action('update_option_gorilion_seo_switcher_choice', 'betterseo_trash_product_page_on_save', 10, 3);
function betterseo_trash_product_page_on_save($old_value, $value, $option) {
    if (betterseo_get_mode() === 'cpt' && get_option('betterseo_platform', 'commerce7') === 'commerce7') {
        $product_page = get_page_by_path('product');
        if ($product_page instanceof WP_Post && $product_page->post_status !== 'trash') {
            wp_trash_post($product_page->ID);
        }
    }
}
 
add_action('update_option_betterseo_tenant_id', 'betterseo_on_tenant_change', 10, 3);

add_action('update_option_betterseo_tenant_id', 'betterseo_on_tenant_change', 10, 3);

function betterseo_on_tenant_change($old_value, $value, $option) {
	if (empty($value) || $value === $old_value) {
		return;
	}
	// Schedule sync to run asynchronously (non-blocking)
	error_log('BetterSEO: Tenant ID changed, scheduling immediate async sync');
	
	// Clear any existing scheduled sync first
	wp_clear_scheduled_hook('betterseo_run_product_sync');
	
	// Schedule for immediate execution (1 second delay)
	wp_schedule_single_event(time() + 1, 'betterseo_run_product_sync');
	
	// Force WordPress to spawn the cron process immediately in the background
	if (function_exists('spawn_cron')) {
		spawn_cron();
	}
}

add_action('update_option_betterseo_platform', 'betterseo_on_platform_change', 10, 3);

function betterseo_on_platform_change($old_value, $value, $option) {
	if ($value === 'ecellar') {
		// eCellar always uses Page mode (legacy) - just set the mode, don't create anything
		update_option('betterseo_mode', 'page');
	} elseif ($value === 'commerce7') {
		// Commerce7 defaults to CPT mode - trigger full setup
		update_option('betterseo_mode', 'cpt');
		betterseo_migrate_to_cpt_mode();
	}
}

function betterseo_get_mode() {
	$mode = get_option('betterseo_mode', 'cpt');
	return ($mode === 'page') ? 'page' : 'cpt';
}

/**
 * Migrate to legacy PAGE mode (rollback from CPT mode).
 */
function betterseo_migrate_to_page_mode() {
	// 1) Ensure /product page exists with required content.
	//    Do not run any manual SQL; just rely on core helpers and create if missing.
	$product_page = get_page_by_path('product');
	if ($product_page instanceof WP_Post) {
		wp_update_post(array(
			'ID'          => $product_page->ID,
			'post_status' => 'publish',
		));
	} else {
		$page_id = wp_insert_post(array(
			'post_title'   => 'Product',
			'post_name'    => 'product',
			'post_content' => '<div id="c7-content"></div>',
			'post_status'  => 'publish',
			'post_type'    => 'page',
		));
		if ($page_id && !is_wp_error($page_id)) {
			$product_page = get_post($page_id);
		}
	}

	// 2) Re-enable Redirection rules for /product
	global $wpdb;
	$table_items = $wpdb->prefix . 'redirection_items';
	if ($wpdb->get_var($wpdb->prepare('SHOW TABLES LIKE %s', $table_items)) === $table_items) {
		$wpdb->query(
			$wpdb->prepare(
				"UPDATE {$table_items} SET status = 'enabled' WHERE (url IN (%s, %s) OR match_url IN (%s, %s))",
				'/product',
				'/product/',
				'/product',
				'/product/'
			)
		);
	}

	// 3) Delete all c7_product posts only if they were created by this plugin
	if (get_option('betterseo_c7_product_owned')) {
		$cpt_posts = get_posts(array(
			'post_type'      => 'c7_product',
			'post_status'    => 'any',
			'posts_per_page' => -1,
			'fields'         => 'ids',
		));
		if (!empty($cpt_posts)) {
			foreach ($cpt_posts as $post_id) {
				wp_delete_post($post_id, true);
			}
		}
		delete_option('betterseo_c7_product_owned');
	}

	// 4) Unschedule Commerce7 sync cron
	$timestamp = wp_next_scheduled('betterseo_daily_product_sync');
	if ($timestamp) {
		wp_unschedule_event($timestamp, 'betterseo_daily_product_sync');
	}

	// 5) Switch mode flag
	update_option('betterseo_mode', 'page');
}

/**
 * Migrate to CPT mode (from legacy PAGE mode).
 */
function betterseo_migrate_to_cpt_mode() {
	// 1) Delete /product page to avoid conflicts
	$product_page = get_page_by_path('product');
	if ($product_page instanceof WP_Post) {
		// Move the page to trash instead of permanently deleting it, so any
		// custom layout (e.g. Elementor) can be restored when rolling back.
		wp_trash_post($product_page->ID);
	}

	// 2) Disable Redirection rules for /product
	global $wpdb;
	$table_items = $wpdb->prefix . 'redirection_items';
	if ($wpdb->get_var($wpdb->prepare('SHOW TABLES LIKE %s', $table_items)) === $table_items) {
		$wpdb->query(
			$wpdb->prepare(
				"UPDATE {$table_items} SET status = 'disabled' WHERE (url IN (%s, %s) OR match_url IN (%s, %s))",
				'/product',
				'/product/',
				'/product',
				'/product/'
			)
		);
	}

	// 3) Ensure cron is scheduled for Commerce7 sync (sync function itself guards by platform/mode)
	if (!wp_next_scheduled('betterseo_daily_product_sync')) {
		wp_schedule_event(time(), 'daily', 'betterseo_daily_product_sync');
	}

	// 4) Switch mode flag
	update_option('betterseo_mode', 'cpt');
	
	// 5) Flush rewrite rules so /product/slug URLs work immediately
	flush_rewrite_rules();
	
	// 6) Trigger initial sync
	betterseo_schedule_product_sync(1, true);
}

/**
 * ------------------------------------------------------------------
 * REGISTER CUSTOM POST TYPE FOR PRODUCTS
 * ------------------------------------------------------------------
 */
add_action('init', 'betterseo_register_product_cpt');
function betterseo_register_product_cpt() {
	if (betterseo_get_mode() === 'cpt') {
		register_post_type('c7_product', array(
			'labels' => array(
				'name' => 'BetterSEO Products',
				'singular_name' => 'BetterSEO Product',
				'add_new' => 'Add New Product',
				'add_new_item' => 'Add New BetterSEO Product',
				'edit_item' => 'Edit BetterSEO Product'
			),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'has_archive' => true,
			'rewrite' => array(
				'slug'       => 'product',
				'with_front' => false,
			),
			'supports' => array('title', 'editor', 'elementor'),
			'show_in_rest' => true,
			'show_in_menu' => false,
			'menu_icon' => 'dashicons-products'
		));
	}
}

/**
 * ------------------------------------------------------------------
 * COMMERCE7 PRODUCT SYNC FUNCTIONS
 * ------------------------------------------------------------------
 * Fetch all products from Commerce7 and create/update WordPress posts
 */
function betterseo_sync_c7_products() {
	// Validate prerequisites
	if (betterseo_get_mode() !== 'cpt') return;
	$platform = get_option('betterseo_platform', 'commerce7');
	if ($platform === 'ecellar') return;
	if (!post_type_exists('c7_product')) return;
	$tenant_id = get_option('betterseo_tenant_id', '');
	if (empty($tenant_id)) return;

	// Check for batch metadata (lightweight - only offset/counts)
	$batch_meta = get_option('betterseo_batch_meta');
	$is_continuation = (is_array($batch_meta) && isset($batch_meta['offset']));
	
	// Lock check only for new sync
	if (!$is_continuation) {
		$lock = get_option('betterseo_sync_lock');
		if ($lock && (time() - $lock) < 900) return;
		update_option('betterseo_sync_lock', time(), false);
	}

	set_time_limit(120);
	ini_set('memory_limit', '256M');
	
	// Fetch products (every batch re-fetches to avoid storing large arrays)
	$products = betterseo_fetch_c7_products($tenant_id);
	if (empty($products)) {
		delete_option('betterseo_batch_meta');
		delete_option('betterseo_sync_lock');
		return;
	}

	$available = array_values(array_filter($products, function($p) {
		return isset($p['webStatus']) && $p['webStatus'] === 'Available';
	}));
	
	$total = count($available);
	
	// Initialize or continue
	if (!$is_continuation) {
		$batch_meta = array('offset' => 0, 'total' => $total, 'created' => 0, 'updated' => 0, 'skipped' => 0, 'errors' => 0, 'start' => time());
		error_log('BetterSEO: Sync started - ' . $total . ' products');
	}
	
	$batch_size = 50;
	$end = min($batch_meta['offset'] + $batch_size, $total);
	
	for ($i = $batch_meta['offset']; $i < $end; $i++) {
		try {
			$result = betterseo_create_or_update_product_post($available[$i]);
			if ($result === 'created') $batch_meta['created']++;
			elseif ($result === 'updated') $batch_meta['updated']++;
			elseif ($result === false) $batch_meta['skipped']++;
		} catch (Exception $e) {
			$batch_meta['errors']++;
		}
	}
	
	$batch_meta['offset'] = $end;
	
	if ($batch_meta['offset'] < $total) {
		update_option('betterseo_batch_meta', $batch_meta, false);
		error_log('BetterSEO: Batch complete - ' . $batch_meta['offset'] . '/' . $total);
		wp_schedule_single_event(time() + 2, 'betterseo_run_product_sync');
		if (function_exists('spawn_cron')) spawn_cron();
	} else {
		error_log('BetterSEO: Sync complete - Created: ' . $batch_meta['created'] . ', Updated: ' . $batch_meta['updated']);
		delete_option('betterseo_batch_meta');
		delete_option('betterseo_sync_lock');
	}
}

function betterseo_fetch_c7_products($tenant_id) {
	// Log API fetch attempt to monitor sync frequency
	error_log('BetterSEO: FETCHING products from Commerce7 API - Tenant: ' . $tenant_id . ' - Time: ' . date('Y-m-d H:i:s'));
	
	$base_url   = 'https://api.commerce7.com/v1/product/for-web';
	$headers    = array('tenant: ' . $tenant_id);
	$all_items  = array();
	$page       = 1;

	// Paginate through all product pages until an empty result set is returned.
	while (true) {
		$url = $base_url . '?page=' . $page;
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);

		$response  = curl_exec($curl);
		$http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		if ($response === false || $http_code !== 200) {
			$error = curl_error($curl);
			error_log('BetterSEO: Commerce7 API error on page ' . $page . ' - ' . $error . ' (HTTP ' . $http_code . ')');
			curl_close($curl);
			break;
		}

		curl_close($curl);

		$data = json_decode($response, true);
		if (!isset($data['products']) || !is_array($data['products'])) {
			error_log('BetterSEO: Invalid Commerce7 API response format on page ' . $page);
			break;
		}

		$page_items = $data['products'];
		if (empty($page_items)) {
			// No more products.
			break;
		}

		$all_items = array_merge($all_items, $page_items);
		$page++;
	}

	return $all_items;
}

function betterseo_validate_and_sync_for_tenant($tenant_id) {
	// Only validate and sync in CPT mode for Commerce7
	if (betterseo_get_mode() !== 'cpt') {
		return;
	}

	$platform = get_option('betterseo_platform', 'commerce7');
	if ($platform !== 'commerce7') {
		return;
	}

	$products = betterseo_fetch_c7_products($tenant_id);
	if (empty($products)) {
		wp_die(__('BetterSEO by Gorilion cannot validate Commerce7 products for the configured tenant. No products were returned from the API.', 'gorilion-seo-switcher'));
	}

	$slug = '';
	foreach ($products as $product) {
		if (!empty($product['slug'])) {
			$slug = sanitize_title($product['slug']);
			break;
		}
	}

	if (empty($slug)) {
		wp_die(__('BetterSEO by Gorilion cannot validate Commerce7 products because no product with a slug was found.', 'gorilion-seo-switcher'));
	}

	$url = home_url('/product/' . $slug . '/');
	$response = wp_remote_get($url, array('timeout' => 5));
	if (is_wp_error($response)) {
		wp_die(__('BetterSEO by Gorilion could not verify the /product route for Commerce7 products due to an HTTP error when requesting the product URL.', 'gorilion-seo-switcher'));
	}

	// If validation passes, perform a full sync using the current tenant
	betterseo_schedule_product_sync(1, true);
}

/**
 * Create or update a WordPress post for a Commerce7 product
 */
function betterseo_create_or_update_product_post($product) {
	if (empty($product['slug'])) {
		error_log('BetterSEO: Product missing slug, skipping');
		return false;
	}

	$slug = sanitize_title($product['slug']);
	$title = isset($product['title']) ? $product['title'] : (isset($product['name']) ? $product['name'] : $slug);
	$c7_product_id = isset($product['id']) ? $product['id'] : '';

	$existing_posts = get_posts(array(
		'post_type' => 'c7_product',
		'name' => $slug,
		'posts_per_page' => 1,
		'post_status' => 'any'
	));

	$post_content = '<div id="c7-content"></div>';

	$post_data = array(
		'post_title' => $title,
		'post_name' => $slug,
		'post_content' => $post_content,
		'post_status' => 'publish',
		'post_type' => 'c7_product',
		'post_author' => 1
	);

	if (!empty($existing_posts)) {
		$post_data['ID'] = $existing_posts[0]->ID;
		wp_update_post($post_data);

		update_post_meta($existing_posts[0]->ID, '_c7_product_id', $c7_product_id);
		update_post_meta($existing_posts[0]->ID, '_c7_slug', $slug);

		error_log("BetterSEO: Updated product post - Slug: $slug, ID: {$existing_posts[0]->ID}");
		return 'updated';
	} else {
		$post_id = wp_insert_post($post_data);

		if (is_wp_error($post_id)) {
			error_log('BetterSEO: Error creating post for slug: ' . $slug . ' - ' . $post_id->get_error_message());
			return false;
		}

		update_post_meta($post_id, '_c7_product_id', $c7_product_id);
		update_post_meta($post_id, '_c7_slug', $slug);

		update_post_meta($post_id, '_elementor_edit_mode', 'builder');

		error_log("BetterSEO: Created product post - Slug: $slug, ID: $post_id");
		return 'created';
	}
}

/**
 * ------------------------------------------------------------------
 * 404 HANDLER - TRIGGER FULL PRODUCT SYNC
 * ------------------------------------------------------------------
 */
add_action('template_redirect', 'betterseo_handle_product_404');

function betterseo_handle_product_404() {
	// Only use the 404 sync handler in CPT mode
	if (betterseo_get_mode() !== 'cpt') {
		return;
	}

	$platform = get_option('betterseo_platform', 'commerce7');
	if ($platform !== 'commerce7' || !is_404()) {
		return;
	}

	$request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
	$request_uri = strtok($request_uri, '?');
	$request_uri = trim($request_uri, '/');

	if (!preg_match('#^product/([^/]+)$#', $request_uri, $matches)) {
		return;
	}

	$slug = $matches[1];

	error_log("BetterSEO: 404 detected for product slug: $slug - Triggering full product sync");

	$last_sync = get_transient('betterseo_last_404_sync');
	if ($last_sync) {
		error_log("BetterSEO: Sync already triggered recently, skipping");
		return;
	}

	// Set transient to prevent multiple syncs within 5 minutes
	set_transient('betterseo_last_404_sync', time(), 5 * MINUTE_IN_SECONDS);

	betterseo_schedule_product_sync(1, true);
	// Sync is now async via cron; do not attempt redirect within this request.
}

/**
 * ------------------------------------------------------------------
 * FRONTEND LAYOUT HELPERS FOR C7 PRODUCT PAGES
 * ------------------------------------------------------------------
 *
 * 1) Constrain the Commerce7 container width so it does not overflow
 *    on single c7_product pages.
 * 2) Hide the default theme .entry-title for c7_product singles to
 *    avoid duplicate titles when the layout/template already prints
 *    the product title.
 */
add_action('wp_head', 'betterseo_c7_product_layout_css', 30);
function betterseo_c7_product_layout_css()
{
	if (!is_singular('c7_product')) {
		return;
	}

	echo '<style id="betterseo-c7-product-layout">'
		. '#c7-content{max-width:1200px;margin:0 auto;padding:0 20px;box-sizing:border-box;}'
		. '.single-c7_product .entry-title{display:none;}'
		. '</style>';
}

/**
 * Display the settings page form.
 */
function gorilion_seo_switcher_options_page()
{
    // Handle mode migration actions (rollback / switch to new CPT mode).
    if (!empty($_POST['betterseo_migrate_mode'])) {
        check_admin_referer('betterseo_migrate_mode_action');
        $action = sanitize_text_field(wp_unslash($_POST['betterseo_migrate_mode']));
        if ($action === 'to_page') {
            betterseo_migrate_to_page_mode();
        } elseif ($action === 'to_cpt') {
            betterseo_migrate_to_cpt_mode();
        }
    }

    $current_mode = betterseo_get_mode();
    ?>
    <div class="wrap">
        <h1>BetterSEO Configuration</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('gorilion_seo_switcher_settings_group');
            do_settings_sections('gorilion_seo_switcher_settings_group');

            // Current settings
            $choice              = get_option('gorilion_seo_switcher_choice', 'rankmath');
            $tenant_id           = get_option('betterseo_tenant_id', '');
            $betterseo_platform  = get_option('betterseo_platform', 'commerce7');
            $ecellar_api_key     = get_option('betterseo_ecellar_api_key', '');
            $betterseo_user      = get_option('betterseo_user', '');

            // Build Commerce7 Admin URL only when platform is commerce7 and tenant is present
            $commerce7_admin_url = '';
            if ($betterseo_platform === 'commerce7' && !empty($tenant_id)) {
                // Sanitize tenant for subdomain usage
                $tenant_clean = strtolower(preg_replace('/[^a-z0-9\-]/i', '', $tenant_id));
                $commerce7_admin_url = sprintf('https://%s.admin.platform.commerce7.com/login', $tenant_clean);
            }
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Which SEO plugin do you use?</th>
                    <td>
                        <label>
                            <input type="radio" name="gorilion_seo_switcher_choice" value="rankmath" <?php checked($choice, 'rankmath'); ?>>
                            Rank Math
                        </label>
                        <br/>
                        <label>
                            <input type="radio" name="gorilion_seo_switcher_choice" value="yoast" <?php checked($choice, 'yoast'); ?>>
                            Yoast SEO
                        </label>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Platform</th>
                    <td>
                        <label><input type="radio" name="betterseo_platform" value="commerce7" <?php checked($betterseo_platform, 'commerce7'); ?>> Commerce7</label><br/>
                        <label><input type="radio" name="betterseo_platform" value="ecellar" <?php checked($betterseo_platform, 'ecellar'); ?>> eCellar</label>
                    </td>
                </tr>
                <tr valign="top" class="field-commerce7">
                    <th scope="row">Tenant ID for Warehouse</th>
                    <td>
                        <input type="text" name="betterseo_tenant_id" value="<?php echo esc_attr($tenant_id); ?>" />
                    </td>
                </tr>
                <tr valign="top" class="field-ecellar">
                    <th scope="row">eCellar API Key</th>
                    <td><input type="text" name="betterseo_ecellar_api_key" value="<?php echo esc_attr($ecellar_api_key); ?>" /></td>
                </tr>
                <?php if ( $current_mode !== 'cpt' || $betterseo_platform !== 'commerce7' ) : ?>
                <tr valign="top">
                    <th scope="row">BetterSEO Username</th>
                    <td><input type="text" name="betterseo_user" value="<?php echo esc_attr($betterseo_user); ?>" /></td>
                </tr>
                <?php endif; ?>
            </table>

            <?php submit_button(); ?>
        </form>
        <div class="betterseo-links">
            <p>
                <a href="https://www.gorilion.com/better-seo/" target="_blank" rel="noopener">BetterSEO by Gorilion</a>
                <?php if (!empty($commerce7_admin_url)) : ?>
                    &nbsp;-&nbsp;
                    <a href="<?php echo esc_url($commerce7_admin_url); ?>" target="_blank" rel="noopener">
                        Commerce7 Admin
                    </a>
                <?php endif; ?>
            </p>
        </div>

        <details style="margin:16px 0;border:1px solid #c3c4c7;border-radius:4px;padding:12px 16px;background:#f6f7f7;">
            <summary style="cursor:pointer;font-weight:600;font-size:14px;color:#1d2327;"><i style="font-style:italic;color:#2271b1;font-weight:700;">i</i> Instructions &amp; Common Issues</summary>
            <ul style="margin:12px 0 0 16px;font-size:13px;line-height:1.8;">
                <li><strong>Rank Math sitemap returning 404:</strong> Go to Rank Math &rarr; Sitemap Settings, change Links per Sitemap (e.g. 200 &rarr; 201) and save. Then go to Settings &rarr; Permalinks and click Save Changes. <a href="https://rankmath.com/kb/sitemap-404-error/" target="_blank" rel="noopener">Learn more</a>.</li>
                <li><strong>Commerce7 plugin routes</strong> (only if the Commerce7 plugin is installed): Go to Commerce7 Settings &rarr; Override Frontend Routes, set to Yes and save. Then change the product route to &ldquo;products&rdquo; and save.</li>
                <li><strong>Products not showing:</strong> Create a file named <code>single-c7_product.php</code> in your theme folder with this content:<br><pre style="background:#fff;border:1px solid #ddd;padding:8px;margin:6px 0;font-size:11px;line-height:1.6;">&lt;?php
get_header();
if ( have_posts() ) {
  while ( have_posts() ) {
    the_post();
    the_content();
  }
}
get_footer();</pre></li>
                <li><strong>Elementor (CPT mode, if using Elementor):</strong> Go to Theme Builder &rarr; Single Post and create a template matching your old product page or create a custom one.</li>
                <li><strong>Changes not reflected:</strong> Go to Settings &rarr; Permalinks and click Save Changes, then clear your caching plugin cache.</li>
            </ul>
        </details>

        <?php if ($betterseo_platform === 'commerce7') : ?>
        <h2>Mode &amp; Rollback</h2>
        <p>Current mode: <strong><?php echo esc_html($current_mode === 'cpt' ? 'New CPT mode' : 'Legacy PAGE mode'); ?></strong></p>
        <form method="post">
            <?php wp_nonce_field('betterseo_migrate_mode_action'); ?>
            <?php if ($current_mode === 'cpt') : ?>
                <p>
                    <input type="hidden" name="betterseo_migrate_mode" value="to_page" />
                    <?php submit_button('Rollback to legacy PAGE mode', 'secondary', 'submit', false); ?>
                </p>
            <?php else : ?>
                <p>
                    <input type="hidden" name="betterseo_migrate_mode" value="to_cpt" />
                    <?php submit_button('Switch to new CPT mode', 'secondary', 'submit', false); ?>
                </p>
            <?php endif; ?>
        </form>
        <?php endif; ?>
    </div>

    <script>
    jQuery(document).ready(function($){
        // Toggle visibility of platform-specific rows
        function togglePlatformFields() {
            var platform = $('input[name="betterseo_platform"]:checked').val();
            if (platform === 'commerce7') {
                $('.field-commerce7').show();
                $('.field-ecellar').hide();
            } else if (platform === 'ecellar') {
                $('.field-ecellar').show();
                $('.field-commerce7').hide();
            }
        }
        togglePlatformFields();
        $('input[name="betterseo_platform"]').on('change', togglePlatformFields);
    });
    </script>
    <?php
}

/**
 * ADMIN: Display an admin notice if REQUEST_URI or REDIRECT_URL is missing.
 */
function betterseo_missing_request_notice()
{
	echo '<div class="notice notice-error">
            <p>Your server needs to have REQUEST_URI or REDIRECT_URL for BetterSEO to function correctly.</p>
          </div>';
}

/**
 * ------------------------------------------------------------------
 * 3) CODE INJECTION BASED ON SELECTED SEO PLUGIN
 * ------------------------------------------------------------------
 */
add_action('plugins_loaded', 'gorilion_seo_switcher_inject_functions');

function gorilion_seo_switcher_inject_functions()
{
	$choice = get_option('gorilion_seo_switcher_choice', 'rankmath');
	$platform = get_option('betterseo_platform', 'commerce7');

	if ($choice === 'rankmath') {
		// --------------------------------------------------
		// RANK MATH CODE BLOCK
		// --------------------------------------------------

		add_action('wp_head', 'rankmath_disable_features', 1);

		function rankmath_disable_features()
		{
			global $post;
			// Safety check: $post might be null on some pages.
			if (!is_object($post)) {
				return;
			}

			if ($post->post_type === 'c7_product' || $post->post_name === 'product' || $post->post_name === 'collection' || $post->post_name == "product-detail" || $post->post_name == "shop") {
				remove_all_actions('rank_math/head');
			}
		}

		// Custom sitemap provider: only needed in legacy PAGE mode or non-Commerce7 platforms.
		// In CPT + Commerce7 mode, RankMath indexes c7_product posts natively.
		if ( betterseo_get_mode() !== 'cpt' || get_option('betterseo_platform', 'commerce7') !== 'commerce7' ) {

			// Load the Custom provider class only if Rank Math's interface exists.
			add_action('init', function () {
				if (interface_exists('\RankMath\Sitemap\Providers\Provider')) {
					$provider_file = plugin_dir_path(__FILE__) . 'inc/rankmath-custom-sitemap.php';
					if (file_exists($provider_file)) {
						require_once $provider_file;
					}
				}
			}, 1);

			// Register the provider; fall back silently if anything fails.
			add_filter('rank_math/sitemap/providers', function ($providers) {
				if (class_exists('\RankMath\Sitemap\Providers\Custom')) {
					try {
						$providers['custom'] = new \RankMath\Sitemap\Providers\Custom();
					} catch (\Throwable $e) {
						// Keep Rank Math defaults if instantiation fails.
					}
				}
				return $providers;
			}, 50);

			// Disable sitemap caching during testing to force a fresh index build.
			add_filter('rank_math/sitemap/enable_caching', '__return_false');

		}


		add_action('wp_head', 'gorilion_opengraph_rankmath');

		function gorilion_opengraph_rankmath()
		{
			global $post;
			if (!is_object($post)) {
				return;
			}

			$mode = betterseo_get_mode();
	
			if ($post->post_name === 'product' || $post->post_name === 'shop' || $post->post_type === 'c7_product') {
				add_filter('wpseo_canonical', '__return_false');
			}

			// Get the request URL to determine slug.
			$request_url = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
			$request_url = trim($request_url, '/');
			$parts = explode('/', $request_url);
			$result = end($parts);

			if (!$result || $result === '' || $result === 'product' || $post->post_name == "product-detail" || $post->post_name == "shop") {
				$redirect_url = isset($_SERVER['REDIRECT_URL']) ? $_SERVER['REDIRECT_URL'] : '';
				$redirect_url = trim($redirect_url, '/');
				$parts2 = explode('/', $redirect_url);
				$result = end($parts2);
			}
			if (!$result || $result === '' || $result === 'product' || $post->post_name == "product-detail" || $post->post_name == "shop") {
				if (is_admin()) {
					add_action('admin_notices', 'betterseo_missing_request_notice');
				}
			}

			// Platform check (only run Commerce7 blocks if platform is commerce7)
			$betterseo_platform = get_option('betterseo_platform');

			// If it's a "collection" page (Commerce7 only).
			if ($betterseo_platform === 'commerce7' && $post->post_name === 'collection') {
				$tenant_id = get_option('betterseo_tenant_id', 'default-tenant-id');
				$collection_url_base = 'https://api.commerce7.com/v1/product/for-web?&collectionSlug=';
				$url = $collection_url_base . $result;
				$headers = array('tenant: ' . $tenant_id);

				$curl = curl_init($url);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
				$response = curl_exec($curl);
				if ($response) {
					$response = json_decode($response);
					$new_title = isset($response->collection->seo->title) ? $response->collection->seo->title : '';
					$new_description = isset($response->collection->seo->description) ? $response->collection->seo->description : '';

					echo '<!-- BetterSEO meta -->';
					echo '<title>' . $new_title . "</title>\n";
					echo '<meta name="description" content="' . $new_description . "\"/>\n";
				}
			}

			// If it's a product page (Commerce7 only).
			if ($betterseo_platform === 'commerce7' && ($post->post_type === 'c7_product' || $post->post_name === 'product')) {
				$tenant_id = get_option('betterseo_tenant_id', 'default-tenant-id');
				$url = 'https://api.commerce7.com/v1/product/slug/' . $result . '/for-web';
				$headers = array('tenant: ' . $tenant_id);

				$curl = curl_init($url);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

				$responseData = curl_exec($curl);
				if ($responseData === false || empty($responseData)) {
					$error = curl_error($curl);
					echo 'Error from curl: ' . esc_html($error);
				} else {
					curl_close($curl);
					$response = json_decode($responseData);
				}

				// Avoid warnings if data doesn't exist.
				$price = isset($response->variants[0]->price) ? $response->variants[0]->price / 100.0 : '';
				$description = isset($response->seo->description) ? $response->seo->description : '';
				$wine = isset($response->wine) ? $response->wine : array();
				$title = isset($response->seo->title) ? $response->seo->title : '';
				$sku = isset($response->variants[0]->sku) ? $response->variants[0]->sku : '';
				$img = isset($response->image) ? $response->image : '';

				$keywords = implode(',', array($title, $sku, implode(',', (array) $wine)));
				$full_url = 'https://' . rtrim($_SERVER['HTTP_HOST'], '/') . '/' . $request_url;
				$site_title = get_bloginfo('name');

				echo '<!-- BetterSEO meta :: VERSION ' . BETTERSEO_VERSION . ' :: RANKMATH -->';
				echo '<title>' . $title . "</title>\n";
				echo '<meta name="description" content="' . $description . "\"/>\n";
				echo '<meta name="keywords" content="' . $keywords . "\">\n";
				echo '<link rel="canonical" href="' . esc_url($full_url) . "\"/>\n";
				echo "<meta property=\"og:type\" content=\"product\" />\n";
				echo '<meta property="og:title" content="' . $title . "\"/>\n";
				echo '<meta property="og:description" content="' . $description . "\"/>\n";
				echo '<meta property="og:image" content="' . esc_url($img) . "\"/>\n";
				echo '<meta property="og:url" content="' . esc_url($full_url) . "\"/>\n";
				echo '<meta property="og:site_name" content="' . esc_attr($site_title) . "\" />\n";
				echo "<meta name=\"twitter:card\" content=\"summary_large_image\" />\n";

				echo '<script type="application/ld+json">
                        {
                            "@context": "http://schema.org",
                            "@type": "Product",
                            "name": "' . esc_js($title) . '",
                            "image": "' . esc_url($img) . '",
                            "description": "' . esc_js($description) . '",
                            "brand": {
                                "@type": "Brand",
                                "name": "' . esc_js($site_title) . '",
                                "logo": "' . esc_url(wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full')[0]) . '"
                            },
                            "offers": {
                                "@type": "Offer",
                                "priceCurrency": "USD",
                                "price": "' . esc_js($price) . '"
                            }
                        }
                      </script>';
			}
		}
	} else {
		// --------------------------------------------------
		// YOAST SEO CODE BLOCK
		// --------------------------------------------------
		add_action('wp', 'betterseo_setup_yoast_product_overrides');
		function betterseo_setup_yoast_product_overrides() {
			global $post;
			if (!is_singular('c7_product')) {
				return;
			}
			if (get_option('betterseo_platform', 'commerce7') !== 'commerce7') {
				return;
			}

			add_filter('wpseo_title', 'betterseo_yoast_product_title', 99);
			add_filter('wpseo_metadesc', 'betterseo_yoast_product_metadesc', 99);
			add_filter('wpseo_opengraph_title', 'betterseo_yoast_product_title', 99);
			add_filter('wpseo_opengraph_desc', 'betterseo_yoast_product_metadesc', 99);
			add_filter('wpseo_opengraph_image', 'betterseo_yoast_product_image', 99);
			add_filter('wpseo_twitter_image', 'betterseo_yoast_product_image', 99);
			add_action('wp_head', 'gorilion_opengraph_yoast', 99);
		}

		function betterseo_get_c7_product_seo_data_for_post($post) {
			if (!($post instanceof WP_Post)) {
				return null;
			}
			$tenant_id = get_option('betterseo_tenant_id', '');
			if (empty($tenant_id)) {
				return null;
			}
			$slug = $post->post_name;
			if (empty($slug)) {
				return null;
			}

			$cache_key = 'betterseo_c7_seo_' . md5($tenant_id . '|' . $slug);
			$cached = get_transient($cache_key);
			if (is_array($cached)) {
				return $cached;
			}

			$url = 'https://api.commerce7.com/v1/product/slug/' . urlencode($slug) . '/for-web';
			$response = wp_remote_get($url, array(
				'timeout' => 10,
				'headers' => array('tenant' => $tenant_id),
			));
			if (is_wp_error($response)) {
				return null;
			}
			$code = wp_remote_retrieve_response_code($response);
			$body = wp_remote_retrieve_body($response);
			if ((int) $code !== 200 || empty($body)) {
				return null;
			}
			$data = json_decode($body, true);
			if (!is_array($data)) {
				return null;
			}

			$title = '';
			if (!empty($data['seo']['title'])) {
				$title = (string) $data['seo']['title'];
			} elseif (!empty($data['title'])) {
				$title = (string) $data['title'];
			}

			$desc = '';
			if (!empty($data['seo']['description'])) {
				$desc = (string) $data['seo']['description'];
			}

			$img = '';
			if (!empty($data['image'])) {
				$img = (string) $data['image'];
			} elseif (!empty($data['images'][0]['url'])) {
				$img = (string) $data['images'][0]['url'];
			}

			$result = array(
				'title' => $title,
				'description' => $desc,
				'image' => $img,
			);
			set_transient($cache_key, $result, 10 * MINUTE_IN_SECONDS);
			return $result;
		}

		function betterseo_yoast_product_title($current) {
			global $post;
			$seo = betterseo_get_c7_product_seo_data_for_post($post);
			if (is_array($seo) && !empty($seo['title'])) {
				return $seo['title'];
			}
			return $current;
		}

		function betterseo_yoast_product_metadesc($current) {
			global $post;
			$seo = betterseo_get_c7_product_seo_data_for_post($post);
			if (is_array($seo) && !empty($seo['description'])) {
				return $seo['description'];
			}
			return $current;
		}

		function betterseo_yoast_product_image($current) {
			global $post;
			$seo = betterseo_get_c7_product_seo_data_for_post($post);
			if (is_array($seo) && !empty($seo['image'])) {
				return $seo['image'];
			}
			return $current;
		}

		function gorilion_opengraph_yoast()
		{
			global $post;
			if (!is_object($post)) {
				return;
			}

			// This function is used to output extra structured data for product pages.
			// Yoast output for title/description/OG is controlled via wpseo_* filters.

			// Similar logic to get $result from the request URI.
			$request_url = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
			$request_url = trim($request_url, '/');
			$parts = explode('/', $request_url);
			$result = end($parts);

			if (!$result || $result === '' || $result === 'product' || $post->post_name === 'shop' || $post->post_name == "product-detail") {
				$redirect_url = isset($_SERVER['REDIRECT_URL']) ? $_SERVER['REDIRECT_URL'] : '';
				$redirect_url = trim($redirect_url, '/');
				$parts2 = explode('/', $redirect_url);
				$result = end($parts2);
			}
			if (!$result || $result === '' || $result === 'product' || $post->post_name === 'shop' || $post->post_name == "product-detail") {
				if (is_admin()) {
					add_action('admin_notices', 'betterseo_missing_request_notice');
				}
			}

			// Platform check (only run Commerce7 blocks if platform is commerce7)
			$betterseo_platform = get_option('betterseo_platform');

			// If it's a "collection" page (Commerce7 only).
			if ($betterseo_platform === 'commerce7' && $post->post_name === 'collection') {
				$tenant_id = get_option('betterseo_tenant_id', 'default-tenant-id');
				$collection_url_base = 'https://api.commerce7.com/v1/product/for-web?&collectionSlug=';
				$url = $collection_url_base . $result;
				$headers = array('tenant: ' . $tenant_id);
				$curl = curl_init($url);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
				$response = curl_exec($curl);
				if ($response) {
					$response = json_decode($response);
					$new_title = isset($response->collection->seo->title) ? $response->collection->seo->title : '';
					$new_description = isset($response->collection->seo->description) ? $response->collection->seo->description : '';

					echo '<!-- BetterSEO meta :: VERSION ' . BETTERSEO_VERSION . ' :: YOASTSEO -->'."\n";
					echo '<title>' . $new_title . "</title>\n";
					echo '<meta name="description" content="' . $new_description . "\"/>\n";
				}
			}

			// If it's a product page (Commerce7 only).
			if ($betterseo_platform === 'commerce7' && ($post->post_type === 'c7_product' || $post->post_name === 'product')) {
				$tenant_id = get_option('betterseo_tenant_id', 'default-tenant-id');
				$url = 'https://api.commerce7.com/v1/product/slug/' . $result . '/for-web';
				$headers = array('tenant: ' . $tenant_id);

				$curl = curl_init($url);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

				$responseData = curl_exec($curl);
				if ($responseData === false || empty($responseData)) {
					$error = curl_error($curl);
					echo 'Error from curl: ' . esc_html($error);
				} else {
					curl_close($curl);
					$response = json_decode($responseData);
				}

				$price = isset($response->variants[0]->price) ? $response->variants[0]->price / 100.0 : '';
				$description = isset($response->seo->description) ? $response->seo->description : '';
				$wine = isset($response->wine) ? $response->wine : array();
				$title = isset($response->seo->title) ? $response->seo->title : '';
				$sku = isset($response->variants[0]->sku) ? $response->variants[0]->sku : '';
				$img = isset($response->image) ? $response->image : '';

				$keywords = implode(',', array($title, $sku, implode(',', (array) $wine)));
				$full_url = 'https://' . rtrim($_SERVER['HTTP_HOST'], '/') . '/' . $request_url . '/' . $result;
				$site_title = get_bloginfo('name');

				echo '<!-- BetterSEO meta :: VERSION ' . BETTERSEO_VERSION . ' :: YOASTSEO -->'."\n";
				if (!empty($img)) {
					echo '<meta property="og:image" content="' . esc_url($img) . '" />' . "\n";
				}
				echo '<script type="application/ld+json">
                        {
                            "@context": "http://schema.org",
                            "@type": "Product",
                            "name": "' . esc_js($title) . '",
                            "image": "' . esc_url($img) . '",
                            "description": "' . esc_js($description) . '",
                            "brand": {
                                "@type": "Brand",
                                "name": "' . esc_js($site_title) . '",
                                "logo": "' . esc_url(wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full')[0]) . '"
                            },
                            "offers": {
                                "@type": "Offer",
                                "priceCurrency": "USD",
                                "price": "' . esc_js($price) . '"
                            }
                        }
                      </script>';
			}
		}
	}
};


/** --------------------
 * eCellar integration
 * ------------------ */
add_action("wp_head", "gorilion_opengraph_ecellar");
function gorilion_opengraph_ecellar() {
	$platform = get_option('betterseo_platform');
	if ($platform != "ecellar") return;

	$ecellar_api_key = get_option('betterseo_ecellar_api_key');
	global $post;

	if ($post->post_name == "product-detail" || $post->post_name == "shop") {
		$key = $ecellar_api_key;
		$request_url = trim($_SERVER["REQUEST_URI"], "/");

		if (str_contains($request_url, "product/")) {
			$result = end(explode("/", $request_url));
		} elseif (!empty($_SERVER["QUERY_STRING"])) {
			parse_str($_SERVER["QUERY_STRING"], $queryParams);
			if (!empty($queryParams["slug"])) $result = $queryParams["slug"];
		}

		$headers = array("X-API-Key: " . $key, "User-Agent: WordPress");

		// Fetch product data
		$curl = curl_init("https://public.ecellar-api.com/v1/products/" . $result);
		curl_setopt_array($curl, [
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER     => $headers,
		]);
		$responseData = curl_exec($curl);

		// Fetch metadata
		$curl2 = curl_init("https://public.ecellar-api.com/v1/products/" . $result . "/metadata");
		curl_setopt_array($curl2, [
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER     => $headers,
		]);
		$responseMetadata = curl_exec($curl2);

		if ($responseData === false || empty($responseData)) {
			echo "Error from curl: " . curl_error($curl);
			return;
		}
		curl_close($curl);
		curl_close($curl2);

		$response         = json_decode($responseData);
		$responseMetadata = json_decode($responseMetadata);

		// Clean helpers
		$clean_text = function($val) {
			if (!is_string($val)) $val = (string)$val;
			$val = html_entity_decode($val, ENT_QUOTES | ENT_HTML5, 'UTF-8');
			$val = preg_replace('/<\s*br\b[^>]*>/i', ' ', $val);
			$val = strip_tags($val);
			$val = preg_replace('/\s+/u', ' ', $val);
			$val = str_replace('"', '', $val);
			return trim($val);
		};

		// --- CASE 1: ARRAY response (catalog) ---
		if (is_array($response)) {
			$encoded = json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

			// Server-side scaffold so meta tags exist before JS updates
			$site_title = get_bloginfo("name");
			$url        = "https://" . rtrim($_SERVER["HTTP_HOST"], "/") . "/" . trim($_SERVER["REQUEST_URI"], "/");

			echo '<!-- BetterSEO meta :: VERSION ' . BETTERSEO_VERSION . ' :: ECELLAR -->' . PHP_EOL;
			echo '<meta name="description" content="" />' . PHP_EOL;
			echo '<meta name="keywords" content="" />' . PHP_EOL;
			echo "<link rel=\"canonical\" href=\"{$url}\"/>" . PHP_EOL;
			echo '<meta property="og:type" content="product" />' . PHP_EOL;
			echo '<meta property="og:title" content="" />' . PHP_EOL;
			echo '<meta property="og:description" content="" />' . PHP_EOL;
			echo '<meta property="og:image" content="" />' . PHP_EOL;
			echo '<meta property="og:site_name" content="' . esc_attr($site_title) . '" />' . PHP_EOL;
			echo '<script type="application/ld+json" class="ecellar-jsonld">{}</script>' . PHP_EOL;

?>
<script>
	(function(){
		var catalog = <?php echo $encoded; ?>;

		console.group("%cBetterSEO eCellar Data","color:green;font-weight:bold;");
		console.log("Full Array Response:", catalog);
		console.groupEnd();

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
			var site  = <?php echo json_encode($site_title); ?>;

			// Update title + metas
			if (document.title !== title) document.title = title;
			setMeta('meta[property="og:title"]', 'content', title);
			setMeta('meta[name="description"]', 'content', desc);
			setMeta('meta[property="og:description"]', 'content', desc);
			if (img) setMeta('meta[property="og:image"]', 'content', img);

			// JSON-LD
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

			// Logs for debugging
			console.group('%cBetterSEO eCellar Matched','color:purple;font-weight:bold;');
			console.log('Found product_id:', prod.product_id);
			console.log('Product:', prod);
			console.groupEnd();
		}

		// Find data-ecp-id with robust strategies
		function getCurrentId(){
			var sel = [
				'.ecp_ProductDetail > [data-ecp-id]',
				'.ecp_ProductDetail [data-ecp-id]',
				'[data-ecp-id]'
			];
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
			if (!pid) {
				console.warn('BetterSEO eCellar: data-ecp-id not found yet.');
				return false;
			}
			console.log('BetterSEO eCellar: resolved data-ecp-id =', pid);
			var prod = catalog.find(function(it){ return String(it.product_id) === String(pid); });
			if (!prod) {
				console.warn('BetterSEO eCellar: product id ' + pid + ' not found in array.');
				return false;
			}
			applyFrom(prod);
			return true;
		}

		// Immediate try + scheduled retries
		if (!tryResolve()){
			var attempts = 0;
			var maxAttempts = 10; // ~5s total
			var iv = setInterval(function(){
				attempts++;
				if (tryResolve() || attempts >= maxAttempts) clearInterval(iv);
			}, 500);
		}

		// Observe late DOM inserts under .ecp_ProductDetail
		var host = document.querySelector('.ecp_ProductDetail') || document.body;
		var mo = new MutationObserver(function(){
			tryResolve();
		});
		mo.observe(host, {subtree:true, childList:true, attributes:true, attributeFilter:['data-ecp-id']});
		// Auto-stop after 10s
		setTimeout(function(){ try { mo.disconnect(); } catch(e){} }, 10000);
	})();
</script>
<?php
			return;
		}

		// --- CASE 2: Single product object ---
		$title_src   = $responseMetadata->meta_title ?? $response->product_name ?? '';
		$title       = $clean_text($title_src);
		$desc_src    = $responseMetadata->meta_description ?? '';
		$description = mb_substr($clean_text($desc_src), 0, 200);
		$keywords    = $clean_text($responseMetadata->meta_keywords ?? '');
		$price       = isset($response->price) ? ($response->price / 1.00) : '';
		$img         = !empty($response->image_1) ? $response->image_1 : ($response->header_image ?? '');
		$site_title  = get_bloginfo("name");
		$url         = "https://" . rtrim($_SERVER["HTTP_HOST"], "/") . "/" . trim($_SERVER["REQUEST_URI"], "/");

		// Force document <title> via filters
		add_filter('pre_get_document_title', fn() => $title, 99);
		add_filter('document_title_parts', fn($parts) => ['title' => $title], 99);
		add_filter('wpseo_title', fn() => $title, 99);
		add_filter('rank_math/frontend/title', fn() => $title, 99);

		echo '<!-- BetterSEO meta :: VERSION ' . BETTERSEO_VERSION . ' -->' . PHP_EOL;
		echo "<meta name=\"description\" content=\"{$description}\"/>" . PHP_EOL;
		echo "<meta name=\"keywords\" content=\"{$keywords}\"/>" . PHP_EOL;
		echo "<link rel=\"canonical\" href=\"{$url}\"/>" . PHP_EOL;
		echo "<meta property=\"og:type\" content=\"product\" />" . PHP_EOL;
		echo "<meta property=\"og:title\" content=\"{$title}\"/>" . PHP_EOL;
		echo "<meta property=\"og:description\" content=\"{$description}\"/>" . PHP_EOL;
		echo "<meta property=\"og:image\" content=\"{$img}\"/>" . PHP_EOL;
		echo "<meta property=\"og:url\" content=\"{$url}\"/>" . PHP_EOL;
		echo "<meta property=\"og:site_name\" content=\"{$site_title}\" />" . PHP_EOL;

		// JSON-LD
		echo '<script type="application/ld+json">' . PHP_EOL;
		echo json_encode([
			"@context" => "http://schema.org",
			"@type"    => "Product",
			"name"     => $title,
			"image"    => $img,
			"description" => $description,
			"brand"    => [
				"@type" => "Brand",
				"name"  => $site_title,
				"logo"  => esc_url(wp_get_attachment_image_src(get_theme_mod("custom_logo"), "full")[0] ?? ''),
			],
			"offers"   => [
				"@type"         => "Offer",
				"priceCurrency" => "USD",
				"price"         => $price,
			]
		], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
		echo '</script>' . PHP_EOL;
	}
}


// Early resolver + hard lock for <title>
add_action('wp', function () {
	// Only for eCellar on product-detail/shop
	if (get_option('betterseo_platform') !== 'ecellar') return;

	global $post;
	if (empty($post) || !in_array($post->post_name, ['product-detail','shop'], true)) return;

	// Resolve slug
	$request_url = trim($_SERVER['REQUEST_URI'] ?? '', '/');
	$slug = '';
	if ($request_url && strpos($request_url, 'product/') !== false) {
		$parts = explode('/', $request_url);
		$slug  = rawurldecode(end($parts));
	} elseif (!empty($_SERVER['QUERY_STRING'])) {
		parse_str($_SERVER['QUERY_STRING'], $qp);
		if (!empty($qp['slug'])) $slug = $qp['slug'];
	}
	if (!$slug) return;
	$slug_api = rawurlencode($slug);

	// Fast metadata-only API call
	$key = get_option('betterseo_ecellar_api_key');
	$headers = ["X-API-Key: {$key}", "User-Agent: WordPress"];

	$curl = curl_init("https://public.ecellar-api.com/v1/products/{$slug}/metadata");
	curl_setopt_array($curl, [
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HTTPHEADER     => $headers,
		CURLOPT_TIMEOUT        => 5,
	]);
	$metaRaw = curl_exec($curl);
	curl_close($curl);

	$metaObj = $metaRaw ? json_decode($metaRaw) : null;

	// Fallback to product name if meta_title is empty
	if (empty($metaObj->meta_title)) {
		$curl = curl_init("https://public.ecellar-api.com/v1/products/{$slug_api}");
		curl_setopt_array($curl, [
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER     => $headers,
			CURLOPT_TIMEOUT        => 5,
		]);
		$prodRaw = curl_exec($curl);
		curl_close($curl);
		$prodObj  = $prodRaw ? json_decode($prodRaw) : null;
		$rawTitle = $metaObj->meta_title ?? ($prodObj->product_name ?? '');
	} else {
		$rawTitle = $metaObj->meta_title;
	}

	// Normalize text (<br>, spaces, quotes)
	$clean = function($val) {
		if (!is_string($val)) $val = (string)$val;
		$val = html_entity_decode($val, ENT_QUOTES|ENT_HTML5, 'UTF-8');
		$val = preg_replace('/<\s*br\b[^>]*>/i', ' ', $val);
		$val = strip_tags($val);
		$val = preg_replace('/\s+/u', ' ', $val);
		$val = str_replace('"', '', $val);
		return trim($val);
	};
	$finalTitle = $clean($rawTitle);
	if ($finalTitle === '') return;

	// Store globally for later hooks
	$GLOBALS['gorilion_ecellar_final_title'] = $finalTitle;

	// Force titles at max priority
	$force = function() use ($finalTitle) { return $finalTitle; };
	add_filter('pre_get_document_title', $force, PHP_INT_MAX);           // Core
	add_filter('document_title_parts', function($parts) use ($finalTitle){
		$parts['title'] = $finalTitle; return $parts;
	}, PHP_INT_MAX);

	add_filter('wpseo_title', $force, PHP_INT_MAX);                       // Yoast
	add_filter('rank_math/frontend/title', $force, PHP_INT_MAX);          // Rank Math

	// client-side safety net if theme prints <title> manually
	add_action('wp_print_scripts', function() use ($finalTitle){
		echo '<script>if(document && document.title!=="'.esc_js($finalTitle).'"){document.title="'.esc_js($finalTitle).'";}</script>';
	}, PHP_INT_MAX);
}, 1);

// Client-side watcher to prevent late overrides
add_action('wp_print_scripts', function () {
	if (empty($GLOBALS['gorilion_ecellar_final_title'])) return;
	$finalTitle = $GLOBALS['gorilion_ecellar_final_title'];
?>
<script>
	(function () {
		var DESIRED = <?php echo json_encode($finalTitle, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>;

		function clean(s) {
			s = (s || '').toString();
			var t = document.createElement('textarea'); t.innerHTML = s; s = t.value;
			s = s.replace(/<\s*br\s*\/?>/gi, ' ');
			s = s.replace(/<[^>]*>/g, ' ');
			s = s.replace(/\s+/g, ' ').trim();
			return s.replace(/"/g, '');
		}

		function apply() {
			// <title>
			if (clean(document.title) !== DESIRED) {
				document.title = DESIRED;
			}
			// og:title / twitter:title / name="title"
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

		// Apply now
		apply();

		// Watch for late mutations (plugins/widgets)
		var stopAt = Date.now() + 8000;
		var mo = new MutationObserver(function () {
			apply();
			if (Date.now() > stopAt) mo.disconnect();
		});
		mo.observe(document.head || document.documentElement, {
			subtree: true,
			childList: true,
			attributes: true,
			attributeFilter: ['content']
		});

		// Re-apply after load for deferred hydration
		window.addEventListener('load', function () {
			setTimeout(apply, 0);
			setTimeout(apply, 1200);
			setTimeout(apply, 3500);
		});
	})();
</script>
<?php
}, PHP_INT_MAX);

/**
 * Ensure Elementor Theme Builder considers c7_product for header/footer locations.
 * This mirrors the user-provided snippet and lives inside the plugin so no
 * theme-level changes are required.
 */
add_action('elementor/theme/register_locations', function ($locations_manager) {
	// This ensures Elementor knows to look for locations on this CPT.
	// Returning true here does not change Elementor's behavior, but having
	// the hook attached guarantees the CPT is evaluated during location
	// registration for setups that rely on this pattern.
	if (is_singular('c7_product')) {
		return true;
	}
});

/** ---------------
 * SPA overwrite
 * ------------- */
add_action('wp_print_scripts', function () {
	if (get_option('betterseo_platform') !== 'ecellar') return;
	global $post;
	if (empty($post) || !in_array($post->post_name, ['product-detail','shop'], true)) return;

	$site_title = get_bloginfo("name");
?>
<script>
	(function(){
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
				q('.ecp_ProductList h1') ||
				q('.collection-title') ||
				q('.ecp-columns-right h1') ||
				q('.ecp-columns-right h2');
			var title = clean( (catTitleEl && (catTitleEl.getAttribute?.('data-ecp-collection-name') || catTitleEl.innerHTML || catTitleEl.textContent)) );
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
				setMeta('meta[property="og:site_name"]','content', <?php echo json_encode($site_title); ?>);
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
							"brand": {"@type":"Brand","name": <?php echo json_encode($site_title); ?>},
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
					tDebounce = setTimeout(function(){
						apply(isCategoryView() ? collectCategory() : collectProduct());
					}, delay || 0);
				}

				var lastHref = location.href;
				function onUrlMaybeChanged(){
					if (location.href !== lastHref){
						lastHref = location.href;
						scheduleApply(0);
						scheduleApply(400);
						scheduleApply(1200);
					}
				}
				document.addEventListener('click', function(e){
					setTimeout(onUrlMaybeChanged, 0);
					setTimeout(onUrlMaybeChanged, 200);
				}, true);
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
			})();
</script>
<?php
}, PHP_INT_MAX - 1);