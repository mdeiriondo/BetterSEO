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
 * 1) GITHUB PLUGIN UPDATE CONFIGURATION
 * ------------------------------------------------------------------
 */

require 'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/mdeiriondo/BetterSEO',
	__FILE__,
	'BetterSEO by Gorilion'
);

// Set the branch that contains the stable release.
$myUpdateChecker->setBranch('main');

/**
 * Dashboard update notifications
 */

/* Force the update check on every admin page load. */
add_action('admin_init', function () use ($myUpdateChecker) {
	$myUpdateChecker->checkForUpdates();
});

/* Display an admin notice across the entire backend when an update is available. */
add_action('admin_notices', function () use ($myUpdateChecker) {
	if (!current_user_can('update_plugins')) return;

	if (isset($_GET['betterseo_dismiss_update'])
		&& wp_verify_nonce($_GET['_wpnonce'] ?? '', 'betterseo_dismiss_update')) {
		update_user_meta(get_current_user_id(), 'betterseo_dismiss_update', '1');
	}

	// Stop showing the notice if the user has dismissed it
	if (get_user_meta(get_current_user_id(), 'betterseo_dismiss_update', true)) return;

	$update = $myUpdateChecker->getUpdate();
	if (!$update) return;

	// Build URLs for "Update now" and "Dismiss"
	$plugin_file = plugin_basename(__FILE__);
	$update_url = wp_nonce_url(
		self_admin_url('update.php?action=upgrade-plugin&plugin=' . urlencode($plugin_file)),
		'upgrade-plugin_' . $plugin_file
	);

	// Optional: link to GitHub release notes or changelog
	$details_url = 'https://github.com/mdeiriondo/BetterSEO/releases';

	// Render the notice
	echo '<div class="notice notice-warning is-dismissible" style="border-left-color:#d63638;">
            <p><strong>BetterSEO by Gorilion</strong>: a new version is available
            (<code>' . esc_html($update->version) . '</code>).
            <a href="' . esc_url($update_url) . '">Update now</a> ·
            <a href="' . esc_url($details_url) . '" target="_blank" rel="noopener">View details</a>
          </div>';
});


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
	register_setting(
		'gorilion_seo_switcher_settings_group',
		'betterseo_wp_product_page_slug'
	);
}

/**
 * Display the settings page form.
 */
function gorilion_seo_switcher_options_page()
{
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
                <tr valign="top">
                    <th scope="row">BetterSEO Username</th>
                    <td><input type="text" name="betterseo_user" value="<?php echo esc_attr($betterseo_user); ?>" /></td>
                </tr>
            </table>

            <?php submit_button(); ?>
        </form>
        <div class="betterseo-links">
            <p>
                <a href="https://betterseo.gorilion.com/" target="_blank" rel="noopener">BetterSEO by Gorilion</a>
                <?php if (!empty($commerce7_admin_url)) : ?>
                    &nbsp;-&nbsp;
                    <a href="<?php echo esc_url($commerce7_admin_url); ?>" target="_blank" rel="noopener">
                        BetterSEO by Gorilion
                    </a>
                <?php endif; ?>
            </p>
        </div>
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

			if ($post->post_name === 'product' || $post->post_name === 'collection' || $post->post_name == "product-detail" || $post->post_name == "shop") {
				remove_all_actions('rank_math/head');
			}
		}

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


		add_action('wp_head', 'gorilion_opengraph_rankmath');

		function gorilion_opengraph_rankmath()
		{
			global $post;
			if (!is_object($post)) {
				return;
			}

			// Remove canonical if it's a product page.
			if ($post->post_name === 'product' || $post->post_name === 'shop') {
				add_filter('wpseo_canonical', '__return_false');
			}

			// Get the request URL to determine slug.
			$request_url = $_SERVER['REQUEST_URI'];
			$request_url = trim($request_url, '/');
			$parts = explode('/', $request_url);
			$result = end($parts);

			// Fallback logic if slug is missing.
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

			// If it's a "product" page (Commerce7 only).
			if ($betterseo_platform === 'commerce7' && $post->post_name === 'product') {
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

				echo '<!-- BetterSEO meta :: VERSION ' . BETTERSEO_VERSION . ' -->';
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

		// Remove Yoast SEO functions
		if (function_exists('wpseo_head')) {
			add_filter('wpseo_json_ld_output', '__return_false');
			add_filter('wpseo_opengraph_output', '__return_false');
			add_filter('wpseo_twitter_output', '__return_false');
			remove_action('wp_head', 'wpseo_head');
			remove_action('wpseo_head', 'wpseo_schema_head');
			remove_action('wpseo_head', 'wpseo_schema_article');
			remove_action('wpseo_head', 'wpseo_schema_webpage');
			remove_action('wpseo_head', 'wpseo_schema_breadcrumb');
			remove_action('wpseo_head', 'wpseo_json_ld');
			remove_action('wpseo_head', 'wpseo_opengraph');
			remove_action('wpseo_head', 'wpseo_twitter');
			remove_action('wpseo_head', 'wpseo_canonical');
			remove_action('wpseo_head', 'wpseo_adjacent_rel_links');
			remove_action('wpseo_head', 'wpseo_metadesc');
			remove_action('wpseo_head', 'wpseo_title');
		}

		add_action('wp_head', 'gorilion_opengraph_yoast');

		// Remove Yoast SEO - Alternative
		add_action("template_redirect", "remove_wpseo_from_product");
		function remove_wpseo_from_product() {
			global $post;
			if ($post->post_name == "product-detail" || $post->post_name == "collection" || $post->post_name == "product" || $post->post_name == "shop") {
				$front_end = YoastSEO()->classes->get("Yoast\WP\SEO\Integrations\Front_End_Integration");
				remove_action( "wpseo_head", [ $front_end, "present_head" ], -9999 );
			}
		}

		function gorilion_opengraph_yoast()
		{
			global $post;
			if (!is_object($post)) {
				return;
			}

			// Remove canonical if it's a product page.
			if ($post->post_name === 'product' || $post->post_name === 'shop' || $post->post_name == "product-detail") {
				add_filter('wpseo_canonical', '__return_false');
			}

			// Check if the Yoast SEO integration class exists
			if (class_exists('Yoast\WP\SEO\Integrations\Front_End_Integration')) {
				$front_end = YoastSEO()->classes->get('Yoast\WP\SEO\Integrations\Front_End_Integration');

				// Check if the 'present_head' method exists in the $front_end object
				if (method_exists($front_end, 'present_head')) {
					remove_action('wpseo_head', [$front_end, 'present_head'], -9999);
				}
			}

			// Similar logic to get $result from the request URI.
			$request_url = $_SERVER['REQUEST_URI'];
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

					echo '<!-- BetterSEO meta -->';
					echo '<title>' . $new_title . "</title>\n";
					echo '<meta name="description" content="' . $new_description . "\"/>\n";
				}
			}

			// If it's a "product" page (Commerce7 only).
			if ($betterseo_platform === 'commerce7' && $post->post_name === 'product') {
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

				echo '<!-- BetterSEO meta :: VERSION ' . BETTERSEO_VERSION . ' -->';
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

			echo '<!-- BetterSEO meta :: VERSION ' . BETTERSEO_VERSION . ' -->' . PHP_EOL;
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