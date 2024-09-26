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
            'loc' => 'https://www.crownpointvineyards.com/product/2017CrownPointEstateSelection750mlBottle',
            'images' => [ ['src' => 'https://images.commerce7.com/crown-point-vineyards/images/original/2017-estate-selection-lit-1634997535554.png','title' => '2017 Estate Selection', ],],
        ],
        [
            'loc' => 'https://www.crownpointvineyards.com/product/2018-cabernet-sauvignon',
            'images' => [ ['src' => 'https://images.commerce7.com/crown-point-vineyards/images/original/2018-cabernet-sauvignon-1634999185588.png','title' => '2018 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.crownpointvineyards.com/product/2018-estate-selection',
            'images' => [ ['src' => 'https://images.commerce7.com/crown-point-vineyards/images/original/2018-estate-selection-1634998861458.png','title' => '2018 Estate Selection', ],],
        ],
        [
            'loc' => 'https://www.crownpointvineyards.com/product/2019-cabernet-sauvignon',
            'images' => [ ['src' => 'https://images.commerce7.com/crown-point-vineyards/images/original/2019-cabernet-sauvignon-1666731982992.png','title' => '2019 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.crownpointvineyards.com/product/2019-estate-selection',
            'images' => [ ['src' => 'https://images.commerce7.com/crown-point-vineyards/images/original/2019-estate-selection-1666732104355.png','title' => '2019 Estate Selection', ],],
        ],
        [
            'loc' => 'https://www.crownpointvineyards.com/product/reserve-cabernet-sauvignon',
            'images' => [ ['src' => 'https://images.commerce7.com/crown-point-vineyards/images/original/2019-crown-point-cabernet-sauvignon-reserve-1666732271832.png','title' => '2019 Reserve Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.crownpointvineyards.com/product/CrownPointExtraVirginOliveOil2Box',
            'images' => [ ['src' => 'https://images.commerce7.com/crown-point-vineyards/images/original/crown-point-extra-virgin-olive-oil-low-res-1637712347398.png','title' => 'Estate Olive Oil (2-pack)', ],],
        ],
	];

		return $links;
	}

}
