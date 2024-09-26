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
            'loc' => 'https://vasantiwines.com/collection/all-wines/2021-cabernet-franc',
            'images' => [ ['src' => 'https://images.commerce7.com/vasanti-estate-winery/images/original/vasanti-cabfranc-fron-1690305069640.jpg','title' => '2021 Cabernet Franc', ],],
        ],
        [
            'loc' => 'https://vasantiwines.com/collection/all-wines/2021-cabernet-merlot',
            'images' => [ ['src' => 'https://images.commerce7.com/vasanti-estate-winery/images/original/cm1-1692662151146.png','title' => '2021 Cabernet Merlot', ],],
        ],
        [
            'loc' => 'https://vasantiwines.com/collection/all-wines/2021-cabernet-sauvignon',
            'images' => [ ['src' => 'https://images.commerce7.com/vasanti-estate-winery/images/original/vasanti-cabsav-fron-1690305819949.jpg','title' => '2021 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://vasantiwines.com/collection/all-wines/2021-merlot',
            'images' => [ ['src' => 'https://images.commerce7.com/vasanti-estate-winery/images/original/merlot-1692662201029.png','title' => '2021 Merlot', ],],
        ],
        [
            'loc' => 'https://vasantiwines.com/collection/all-wines/2022-rose',
            'images' => [ ['src' => 'https://images.commerce7.com/vasanti-estate-winery/images/original/csr-1692662297459.png','title' => '2022 Cabernet Sauvignon Rosé', ],],
        ],
        [
            'loc' => 'https://vasantiwines.com/collection/all-wines/2022-chardonnay',
            'images' => [ ['src' => 'https://images.commerce7.com/vasanti-estate-winery/images/original/chard-1692662241793.png','title' => '2022 Chardonnay', ],],
        ],
        [
            'loc' => 'https://vasantiwines.com/collection/all-wines/gift-card',
            'images' => [ ['src' => 'https://images.commerce7.com/vasanti-estate-winery/images/original/100-1701116732936.png','title' => 'Gift Card', ],],
        ],
	];

		return $links;
	}

}
