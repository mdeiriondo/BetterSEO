<?php
// Place this file in the root of your theme folder
namespace RankMath\Sitemap\Providers;

defined( 'ABSPATH' ) || exit;

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
	$links     = [

        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2013_PHASE_V_CABERNET_SAUVIGNON',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_97.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2014_PHASE_V_CABERNET_SAUVIGNON',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_121.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2016_PHASE_V_CABERNET_SAUVIGNON',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_198.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2016_PHASE_V_CELLARIUM_1.5L',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_298.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2017_PHASE_V_CABERNET_SAUVIGNON',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_289.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2017_PHASE_V_CELLARIUM_1.5L',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_333.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2018_PHASE_V_CABERNET_SAUVIGNON',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_308.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2018_PHASE_V_CELLARIUM_1.5L',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_375.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2016_PHASE_V_PETITE_SIRAH',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_253.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2017_PHASE_V_PETITE_SIRAH',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_290.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2017_PHASE_V_PETITE_SIRAH_1.5L',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_342.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2018_PHASE_V_PETITE_SIRAH',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_307.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2019_Davis_Estates_Classic_Chase',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_381.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2021_Davis_Estates_Sauvignon_Blanc',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_347.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2015_PHASE_V_CABERNET_SAUVIGNON',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_154.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2021_Davis_Estates_Pinot_Noir',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_379.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2022_Davis_Estates_Chardonnay',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_414.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2015_PHASE_V_PETITE_SIRAH',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_153.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2021_Davis_Estates_Cabernet_Franc',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_415.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2018_Davis_Estates_Zephyr',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_367.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2018_Davis_Estates_Zephyr_1.5L',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_370.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2019_Davis_Estates_Merlot',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_404.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2017_Davis_Estates_Cabernet_Sauvignon_Calistoga_1.5L',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_273.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2017_Davis_Estates_Cabernet_Sauvignon_Calistoga_3L',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_274.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2017_Davis_Estates_Cabernet_Sauvignon_Calistoga_6L',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_275.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2017_Davis_Estates_Cabernet_Sauvignon_Oakville_1.5L',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_265.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2017_Davis_Estates_Cabernet_Sauvignon_Oakville_3L',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_266.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2017_Davis_Estates_Cabernet_Sauvignon_Oakville_6L',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_267.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2017_Davis_Estates_Cabernet_Sauvignon_Rutherford_1.5L',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_295.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2017_Davis_Estates_Cabernet_Sauvignon_Rutherford_3L',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_296.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2017_Davis_Estates_Cabernet_Sauvignon_Rutherford_6L',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_297.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2018_Davis_Estates_Cabernet_Sauvignon_1.5L',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_350.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2018_Davis_Estates_Cabernet_Sauvignon_Calistoga',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_316.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2018_Davis_Estates_Cabernet_Sauvignon_Calistoga_1.5L',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_338.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2018_Davis_Estates_Cabernet_Sauvignon_Calistoga_3L',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_339.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2018_Davis_Estates_Cabernet_Sauvignon_Calistoga_6L',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_340.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2018_Davis_Estates_Cabernet_Sauvignon_Oakville',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_304.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2018_Davis_Estates_Cabernet_Sauvignon_Oakville_1.5L',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_305.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2018_Davis_Estates_Cabernet_Sauvignon_Oakville_3L',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_372.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2018_Davis_Estates_Cabernet_Sauvignon_Oakville_6L',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_373.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2018_Davis_Estates_Cabernet_Sauvignon_Rutherford',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_343.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2018_Davis_Estates_Cabernet_Sauvignon_Rutherford_1.5L',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_352.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2018_Davis_Estates_Cabernet_Sauvignon_Rutherford_3L',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_353.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2018_Davis_Estates_Cabernet_Sauvignon_Rutherford_6L',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_354.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2019_Davis_Estates_Cabernet_Sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_382.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2019_Davis_Estates_Cabernet_Sauvignon_1.5L',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_383.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2019_Davis_Estates_Cabernet_Sauvignon_Rutherford',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_351.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2019_Davis_Estates_Cabernet_Sauvignon_Rutherford_1.5L',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_355.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2019_Davis_Estates_Cabernet_Sauvignon_Rutherford_3L',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_356.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2017_Davis_Estates_Zephyr_1.5L',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_312.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2017_Davis_Estates_Cabernet_Sauvignon_Howell_Mountain_1.5L',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_270.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2017_Davis_Estates_Cabernet_Sauvignon_Howell_Mountain_6L',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_272.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2019_Davis_Estates_Cabernet_Sauvignon_Howell_Mountain',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_397.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2019_Davis_Estates_Cabernet_Sauvignon_Howell_Mountain_1.5L',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_419.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2019_Davis_Estates_Cabernet_Sauvignon_Howell_Mountain_3L',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_420.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2019_Davis_Estates_Cabernet_Sauvignon_Howell_Mountain_6L',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_421.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2014_Pinwheel_Late_Harvest_Chardonnay_(Dessert_Wine)',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_50.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.davisestates.com/product-detail/product/2014_Pinwheel_Late_Harvest_Cabernet_Franc_(Dessert_Wine)',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/davisestates/prod_header_68.png','title' => '{', ],],
        ],
	];

		return $links;
	}

}
