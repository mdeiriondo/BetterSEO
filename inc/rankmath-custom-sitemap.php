<?php

namespace RankMath\Sitemap\Providers;

if (!defined('ABSPATH')) { exit; }

// Ensure the Provider interface exists before defining the class
if (!interface_exists(__NAMESPACE__ . '\\Provider')) {
    return;
}

/**
 * Custom Rank Math provider that injects an external sitemap entry
 * into the sitemap index. The external sitemap is served by BetterSEO.
 */
class Custom implements Provider
{
    public function handles_type($type) {
        // Internal type name for this provider
        return $type === 'custom';
    }

    public function get_index_links($max_entries) {
        // Get BetterSEO user dynamically from WP options
        $betterseo_user = get_option('betterseo_user', '');

        // Fallback for safety (in case the option is empty)
        if (empty($betterseo_user)) {
            $betterseo_user = 'gorilion';
        }

        $loc = sprintf(
            'https://betterseo.gorilion.com/output/sitemaps/%s_product_sitemap.xml',
            rawurlencode($betterseo_user)
        );

        return [
            [
                'loc'     => $loc,
                'lastmod' => '', 
            ],
        ];
    }

    public function get_sitemap_links($type, $max_entries, $current_page) {
        // No local URLs are generated — the external server serves the XML.
        return [];
    }
}