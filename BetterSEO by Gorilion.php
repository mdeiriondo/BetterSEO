<?php
/**
 * Plugin Name: BetterSEO by Gorilion
 * Plugin URI: https://www.gorilion.com/better-seo/
 * Description: Dynamically enable code for Rank Math or Yoast SEO, and update from GitHub.
 * Version: 2.1
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

// Set to true to enable debug logging via error_log().
if (!defined('BETTERSEO_DEBUG')) {
	define('BETTERSEO_DEBUG', false);
}

function betterseo_log($message) {
	if (BETTERSEO_DEBUG) {
		error_log($message);
	}
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
	if (post_type_exists('ecellar_product') && !get_option('betterseo_ecellar_product_owned')) {
		wp_die(__('BetterSEO by Gorilion cannot be activated because the post type "ecellar_product" already exists.', 'gorilion-seo-switcher'));
	}

	// If eCellar was already configured, restore cron so sync keeps running
	if (
		get_option('betterseo_platform', 'commerce7') === 'ecellar' &&
		get_option('betterseo_ecellar_api_key', '') !== '' &&
		get_option('betterseo_ecellar_shop_path', '') !== ''
	) {
		wp_clear_scheduled_hook('betterseo_run_ecellar_sync');
		wp_clear_scheduled_hook('betterseo_daily_ecellar_sync');
		wp_schedule_single_event(time() + 5, 'betterseo_run_ecellar_sync');
		wp_schedule_event(time() + DAY_IN_SECONDS, 'daily', 'betterseo_daily_ecellar_sync');
	}

	// Flush rewrite rules
	flush_rewrite_rules();
}

// Cron handlers for product sync.
add_action('betterseo_daily_product_sync',  'betterseo_sync_c7_products');
add_action('betterseo_run_product_sync',    'betterseo_sync_c7_products');
add_action('betterseo_daily_ecellar_sync',  'betterseo_sync_ecellar_products');
add_action('betterseo_run_ecellar_sync',    'betterseo_sync_ecellar_products');

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
	wp_clear_scheduled_hook('betterseo_daily_ecellar_sync');
	wp_clear_scheduled_hook('betterseo_run_ecellar_sync');
	
	// Flush rewrite rules
	flush_rewrite_rules();
}

/**
 * Minimal schema piece class for injecting Product schema into Yoast's @graph.
 * Implements the two methods Yoast calls on every piece (duck-typed, no interface required).
 */
class BetterSEO_Product_Schema_Piece {
	private $schema;
	public function __construct( array $schema ) {
		$this->schema = $schema;
	}
	public function is_needed() { return true; }
	public function generate()  { return $this->schema; }
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

// eCellar integration
require_once plugin_dir_path(__FILE__) . 'inc/ecellar.php';


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
	// eCellar shop path (e.g. product-detail, shop)
	register_setting(
		'gorilion_seo_switcher_settings_group',
		'betterseo_ecellar_shop_path'
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
	betterseo_log('BetterSEO: Tenant ID changed, scheduling immediate async sync');
	
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
add_action('update_option_betterseo_ecellar_api_key', 'betterseo_on_ecellar_credentials_change', 10, 3);
add_action('update_option_betterseo_ecellar_shop_path', 'betterseo_on_ecellar_credentials_change', 10, 3);
add_action('added_option', 'betterseo_on_ecellar_option_added', 10, 2);

function betterseo_on_ecellar_option_added( $option, $value ) {
	if ( $option !== 'betterseo_ecellar_api_key' && $option !== 'betterseo_ecellar_shop_path' ) {
		return;
	}
	betterseo_maybe_schedule_ecellar_sync();
}

function betterseo_on_ecellar_credentials_change( $old_value, $value, $option ) {
	betterseo_maybe_schedule_ecellar_sync();
}

function betterseo_maybe_schedule_ecellar_sync() {
	if ( get_option('betterseo_platform', 'commerce7') !== 'ecellar' ) {
		return;
	}
	if ( get_option('betterseo_ecellar_api_key', '') === '' || get_option('betterseo_ecellar_shop_path', '') === '' ) {
		return;
	}
	flush_rewrite_rules();
	wp_clear_scheduled_hook('betterseo_run_ecellar_sync');
	wp_schedule_single_event(time() + 1, 'betterseo_run_ecellar_sync');
	if ( function_exists('spawn_cron') ) {
		spawn_cron();
	}
}

function betterseo_on_platform_change($old_value, $value, $option) {
	if ($value === 'ecellar') {
		// eCellar is always CPT mode
		update_option('betterseo_mode', 'cpt');
		flush_rewrite_rules();
		// Only schedule sync if credentials are already present
		if ( get_option('betterseo_ecellar_api_key', '') !== '' && get_option('betterseo_ecellar_shop_path', '') !== '' ) {
			wp_clear_scheduled_hook( 'betterseo_run_ecellar_sync' );
			wp_schedule_single_event( time() + 1, 'betterseo_run_ecellar_sync' );
			if ( function_exists( 'spawn_cron' ) ) {
				spawn_cron();
			}
		}
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
	if (betterseo_get_mode() === 'cpt' && get_option('betterseo_platform', 'commerce7') !== 'ecellar') {
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
		betterseo_log('BetterSEO: Sync started - ' . $total . ' products');
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
		betterseo_log('BetterSEO: Batch complete - ' . $batch_meta['offset'] . '/' . $total);
		wp_schedule_single_event(time() + 2, 'betterseo_run_product_sync');
		if (function_exists('spawn_cron')) spawn_cron();
	} else {
		betterseo_log('BetterSEO: Sync complete - Created: ' . $batch_meta['created'] . ', Updated: ' . $batch_meta['updated']);
		delete_option('betterseo_batch_meta');
		delete_option('betterseo_sync_lock');
		flush_rewrite_rules();
	}
}

function betterseo_fetch_c7_products($tenant_id) {
	// Log API fetch attempt to monitor sync frequency
	betterseo_log('BetterSEO: FETCHING products from Commerce7 API - Tenant: ' . $tenant_id . ' - Time: ' . date('Y-m-d H:i:s'));
	
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
			betterseo_log('BetterSEO: Commerce7 API error on page ' . $page . ' - ' . $error . ' (HTTP ' . $http_code . ')');
			curl_close($curl);
			break;
		}

		curl_close($curl);

		$data = json_decode($response, true);
		if (!isset($data['products']) || !is_array($data['products'])) {
			betterseo_log('BetterSEO: Invalid Commerce7 API response format on page ' . $page);
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
			$slug = $product['slug'];
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
		betterseo_log('BetterSEO: Product missing slug, skipping');
		return false;
	}

	$slug = $product['slug'];
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

		betterseo_log("BetterSEO: Updated product post - Slug: $slug, ID: {$existing_posts[0]->ID}");
		return 'updated';
	} else {
		$post_id = wp_insert_post($post_data);

		if (is_wp_error($post_id)) {
			betterseo_log('BetterSEO: Error creating post for slug: ' . $slug . ' - ' . $post_id->get_error_message());
			return false;
		}

		update_post_meta($post_id, '_c7_product_id', $c7_product_id);
		update_post_meta($post_id, '_c7_slug', $slug);

		update_post_meta($post_id, '_elementor_edit_mode', 'builder');

		betterseo_log("BetterSEO: Created product post - Slug: $slug, ID: $post_id");
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

	betterseo_log("BetterSEO: 404 detected for product slug: $slug - Triggering full product sync");

	$last_sync = get_transient('betterseo_last_404_sync');
	if ($last_sync) {
		betterseo_log("BetterSEO: Sync already triggered recently, skipping");
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
                <tr valign="top" class="field-ecellar">
                    <th scope="row">eCellar Shop Path</th>
                    <td>
                        <input type="text" name="betterseo_ecellar_shop_path" value="<?php echo esc_attr(get_option('betterseo_ecellar_shop_path', '')); ?>" />
                        <p class="description">Slug of the products page (e.g. <code>product-detail</code> or <code>shop</code>). Used as the URL prefix for products and to reuse the Elementor template of that page.</p>
                    </td>
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

			$ecellar_shop_path = get_option('betterseo_ecellar_shop_path', '');
			if (
				$post->post_type === 'c7_product' ||
				$post->post_type === 'ecellar_product' ||
				$post->post_name === 'product' ||
				$post->post_name === 'collection' ||
				( ! empty($ecellar_shop_path) && $post->post_name === $ecellar_shop_path )
			) {
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

				echo '<script type="application/ld+json">' . wp_json_encode( [
								'@context'    => 'http://schema.org',
								'@type'       => 'Product',
								'name'        => $title,
								'image'       => esc_url( $img ),
								'description' => $description,
								'brand'       => [
									'@type' => 'Brand',
									'name'  => $site_title,
									'logo'  => esc_url( wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' )[0] ),
								],
								'offers'      => [
									'@type'         => 'Offer',
									'priceCurrency' => 'USD',
									'price'         => $price,
								],
							], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
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

			$captured_post = $post;
			add_filter('wpseo_schema_graph_pieces', function( $pieces, $context ) use ( $captured_post ) {
				$seo = betterseo_get_c7_product_seo_data_for_post( $captured_post );
				if ( ! is_array( $seo ) || empty( $seo['title'] ) ) {
					return $pieces;
				}

				$permalink = get_permalink( $captured_post );
				$schema    = array(
					'@type'            => 'Product',
					'@id'              => $permalink . '#product',
					'name'             => $seo['title'],
					'url'              => $permalink,
					'mainEntityOfPage' => $permalink,
					'brand'            => array(
						'@type' => 'Brand',
						'name'  => get_bloginfo( 'name' ),
					),
				);

				if ( ! empty( $seo['description'] ) ) {
					$schema['description'] = html_entity_decode( $seo['description'], ENT_QUOTES | ENT_HTML5, 'UTF-8' );
				}
				if ( ! empty( $seo['image'] ) ) {
					$schema['image'] = $seo['image'];
				}
				if ( ! empty( $seo['sku'] ) ) {
					$schema['sku'] = $seo['sku'];
				}
				if ( $seo['price'] !== '' ) {
					$schema['offers'] = array(
						'@type'         => 'Offer',
						'@id'           => $permalink . '#offer',
						'url'           => $permalink,
						'priceCurrency' => 'USD',
						'price'         => (string) $seo['price'],
						'availability'  => 'https://schema.org/InStock',
					);
				}

				$pieces[] = new BetterSEO_Product_Schema_Piece( $schema );
				return $pieces;
			}, 99, 2 );
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

			$price = '';
			if (isset($data['variants'][0]['price']) && $data['variants'][0]['price'] !== '') {
				$price = (float) $data['variants'][0]['price'] / 100.0;
			}

			$sku = '';
			if (!empty($data['variants'][0]['sku'])) {
				$sku = (string) $data['variants'][0]['sku'];
			}

			$result = array(
				'title'       => $title,
				'description' => $desc,
				'image'       => $img,
				'price'       => $price,
				'sku'         => $sku,
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

	}
};




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

