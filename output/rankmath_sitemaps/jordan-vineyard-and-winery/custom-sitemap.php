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
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-1976',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1976-alexander-valley-jordan-cabernet-sauvignon_library_c7-thumbnails_layers-1616040002811.jpg','title' => '1976 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-1978',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1978-alexander-valley-jordan-cabernet-sauvignon_library_c7-thumbnails_layers-1616040066711.jpg','title' => '1978 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-1979',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1979-russian-river-jordan-chardonnay_library_c7-thumbnails_layers-1616261689458.jpg','title' => '1979 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-1980',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1980-alexander-valley-jordan-cabernet-sauvignon_library_c7-thumbnails_layers-1616040121429.jpg','title' => '1980 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-1980',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1980-russian-river-jordan-chardonnay_library_c7-thumbnails_layers-1616261721667.jpg','title' => '1980 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-1981',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1981-alexander-valley-jordan-cabernet-sauvignon_library_c7-thumbnails_layers-1616040160239.jpg','title' => '1981 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-1981',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1981-russian-river-jordan-chardonnay_library_c7-thumbnails_layers-1616261748009.jpg','title' => '1981 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-1982',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1982-alexander-valley-jordan-cabernet-sauvignon_library_c7-thumbnails_layers-1616040197712.jpg','title' => '1982 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-1982',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1982-russian-river-jordan-chardonnay_library_c7-thumbnails_layers-1616261770727.jpg','title' => '1982 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-1983',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1983-alexander-valley-jordan-cabernet-sauvignon_library_c7-thumbnails_layers-1616040262141.jpg','title' => '1983 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-1983',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1983-russian-river-jordan-chardonnay_library_c7-thumbnails_layers-1616261803216.jpg','title' => '1983 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-1984',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1984-alexander-valley-jordan-cabernet-sauvignon_library_c7-thumbnails_layers-1616040297757.jpg','title' => '1984 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-1984',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1984-russian-river-jordan-chardonnay_library_c7-thumbnails_layers-1616261826725.jpg','title' => '1984 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-1985',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1985-alexander-valley-jordan-cabernet-sauvignon_library_c7-thumbnails_layers-1616040333666.jpg','title' => '1985 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-1985',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1985-russian-river-jordan-chardonnay_library_c7-thumbnails_layers-1616261876262.jpg','title' => '1985 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-1986',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1986-alexander-valley-jordan-cabernet-sauvignon_library_c7-thumbnails_layers-1616040468640.jpg','title' => '1986 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-1986',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1986-russian-river-jordan-chardonnay_library_c7-thumbnails_layers-1616261902331.jpg','title' => '1986 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-1987',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1987-alexander-valley-jordan-cabernet-sauvignon_library_c7-thumbnails_layers-1616040505031.jpg','title' => '1987 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-1987',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1987-russian-river-jordan-chardonnay_library_c7-thumbnails_layers-1616261933946.jpg','title' => '1987 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-1988',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1988-alexander-valley-jordan-cabernet-sauvignon_library_c7-thumbnails_layers-1616040554914.jpg','title' => '1988 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-1988',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1988-russian-river-jordan-chardonnay_library_c7-thumbnails_layers-1616261958626.jpg','title' => '1988 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-1989',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1989-alexander-valley-jordan-cabernet-sauvignon_library_c7-thumbnails_layers-1616040586513.jpg','title' => '1989 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-1989',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1989-russian-river-jordan-chardonnay_library_c7-thumbnails_layers-1616261997355.jpg','title' => '1989 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-1990',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1990-alexander-valley-jordan-cabernet-sauvignon_library_c7-thumbnails_layers-1616040619400.jpg','title' => '1990 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-1990',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1990-russian-river-jordan-chardonnay_library_c7-thumbnails_layers-1616262020616.jpg','title' => '1990 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-1991',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1991-alexander-valley-jordan-cabernet-sauvignon_library_c7-thumbnails_layers-1616042176304.jpg','title' => '1991 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-1991',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1991-russian-river-jordan-chardonnay_library_c7-thumbnails_layers-1616262045851.jpg','title' => '1991 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-1992',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1992-alexander-valley-jordan-cabernet-sauvignon_library_c7-thumbnails_layers-1616042230335.jpg','title' => '1992 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-1992',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1992-russian-river-jordan-chardonnay_library_c7-thumbnails_layers-1616262068310.jpg','title' => '1992 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-1993',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1993-alexander-valley-jordan-cabernet-sauvignon_library_c7-thumbnails_layers-1616042269159.jpg','title' => '1993 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-1993',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1993-russian-river-jordan-chardonnay_library_c7-thumbnails_layers-1616262090235.jpg','title' => '1993 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-1994',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1994-alexander-valley-jordan-cabernet-sauvignon_library_c7-thumbnails_layers-1616042308475.jpg','title' => '1994 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-1994',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1994-russian-river-jordan-chardonnay_library_c7-thumbnails_layers-1616262112016.jpg','title' => '1994 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-1995',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1995-alexander-valley-jordan-cabernet-sauvignon_library_c7-thumbnails_layers-1616042400024.jpg','title' => '1995 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-1995',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1995-russian-river-jordan-chardonnay_library_c7-thumbnails_layers-1616262136718.jpg','title' => '1995 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-1996',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1996-alexander-valley-jordan-cabernet-sauvignon_library_c7-thumbnails_layers-1616042441446.jpg','title' => '1996 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-1996',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1996-russian-river-jordan-chardonnay_library_c7-thumbnails_layers-1616262164350.jpg','title' => '1996 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-1997',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1997-alexander-valley-jordan-cabernet-sauvignon_library_c7-thumbnails_layers-1616042477811.jpg','title' => '1997 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-1997',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1997-russian-river-jordan-chardonnay_library_c7-thumbnails_layers-1616262190441.jpg','title' => '1997 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-1998',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1998-alexander-valley-jordan-cabernet-sauvignon_library_c7-thumbnails_layers-1616042522114.jpg','title' => '1998 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-1998',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1998-russian-river-jordan-chardonnay_library_c7-thumbnails_layers-1616262213748.jpg','title' => '1998 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-1999',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1999-alexander-valley-jordan-cabernet-sauvignon_library_c7-thumbnails_layers-1616042558460.jpg','title' => '1999 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-1999',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1999-russian-river-jordan-chardonnay_library_c7-thumbnails_layers-1616262235690.jpg','title' => '1999 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-2000',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2000-alexander-valley-jordan-cabernet-sauvignon_library_c7-thumbnails_layers-1616042604571.jpg','title' => '2000 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-2000',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2000-russian-river-jordan-chardonnay_library_c7-thumbnails_layers-1616262259316.jpg','title' => '2000 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-magnum-2001-wood-box',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1-5l-2001-cabernet-sauvignon-c7-shop-thumbnail-1616197995211-1629651636880.jpeg','title' => '2001 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-2001',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2001-alexander-valley-jordan-cabernet-sauvignon_library_c7-thumbnails_layers-1616042655004.jpg','title' => '2001 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-magnum-2001',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1-5l-2001-cabernet-sauvignon-c7-shop-thumbnail-1616197995211.jpg','title' => '2001 Cabernet Sauvignon (no Box)', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-2001',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2001-russian-river-jordan-chardonnay_library_c7-thumbnails_layers-1616262282418.jpg','title' => '2001 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-magnum-2002-wood-box',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1-5l-2002-cabernet-sauvignon-c7-shop-thumbnail-1631638716054.jpg','title' => '2002 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-2002',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2002-alexander-valley-jordan-cabernet-sauvignon_library_c7-thumbnails_layers-1616042693642.jpg','title' => '2002 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/2002-cabernet-sauvignon',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/jordan-logo-webthumb2014-1621531964188-1-1660582787526.jpg','title' => '2002 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-2002',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2002-russian-river-jordan-chardonnay_library_c7-thumbnails_layers-1616262322602.jpg','title' => '2002 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-2003',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2003-alexander-valley-jordan-cabernet-sauvignon_c7_shop_thumbnails_layers-1646338007073.jpg','title' => '2003 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-2003',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2003-russian-river-jordan-chardonnay_library_c7-thumbnails_layers-1616262344435.jpg','title' => '2003 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-magnum-2004-wood-box',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1-5l-2004-cabernet-sauvignon-c7-shop-thumbnail-1616199274714-1629652871051.jpeg','title' => '2004 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-2004',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2004-alexander-valley-jordan-cabernet-sauvignon_c7_shop_thumbnails_layers-1646337972287.jpg','title' => '2004 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-2004',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2004-russian-river-jordan-chardonnay_library_c7-thumbnails_layers-1616262368153.jpg','title' => '2004 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-2005',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2005-alexander-valley-jordan-cabernet-sauvignon_c7_shop_thumbnails_layers-1646337949020.jpg','title' => '2005 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-magnum-2005-wood-box',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1-5l-2005-cabernet-sauvignon-c7-shop-thumbnail-1616199307947-1629653100403.jpeg','title' => '2005 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-2005',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2005-russian-river-jordan-chardonnay_library_c7-thumbnails_layers-1616262390460.jpg','title' => '2005 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-magnum-2006-wood-box',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1-5l-2006-cabernet-sauvignon-c7-shop-thumbnail-1616199356167-1629653317392.jpeg','title' => '2006 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-2006',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2006-alexander-valley-jordan-cabernet-sauvignon_c7_shop_thumbnails_layers-1646337905437.jpg','title' => '2006 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-2006',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2006-russian-river-jordan-chardonnay_library_c7-thumbnails_layers-1616262412906.jpg','title' => '2006 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/2006-signed-magnum-in-wine-boxes',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1-5l-2006-cabernet-sauvignon-c7-shop-thumbnail-1616199356167-1629653317392-1668045188651.jpeg','title' => '2006 Signed Magnum In Wood Box', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-magnum-2007-wood-box',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1-5l-2001-cabernet-sauvignon-c7-shop-thumbnail-1616197995211-1629651636880.jpeg','title' => '2007 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-2007',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2007-alexander-valley-jordan-cabernet-sauvignon_c7_shop_thumbnails_layers-1646337877059.jpg','title' => '2007 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-2007',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2007-russian-river-jordan-chardonnay_library_c7-thumbnails_layers-1616262444002.jpg','title' => '2007 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-magnum-2008-wood-box',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1-5l-2008-cabernet-sauvignon-c7-shop-thumbnail-1616199459015-1629653551830.jpeg','title' => '2008 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-2008',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2008-alexander-valley-jordan-cabernet-sauvignon_c7_shop_thumbnails_layers-1627833840652.jpg','title' => '2008 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-2008',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2008-russian-river-jordan-chardonnay_library_c7-thumbnails_layers-1616262466854.jpg','title' => '2008 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-2009',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2009-cabernetsauvignon_c7_shop_thumbnails_layers-1616452819746.jpg','title' => '2009 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-magnum-2009-wood-box',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1-5l-2009-cabernet-sauvignon-c7-shop-thumbnail-1616199487464-1629734902141.jpeg','title' => '2009 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-2009',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2009-russian-river-jordan-chardonnay_library_c7-thumbnails_layers-1616262488342.jpg','title' => '2009 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-2010',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2010-cabernetsauvignon_c7_shop_thumbnails_layers-1616452795181.jpg','title' => '2010 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-magnum-2010-wood-box',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1-5l-2010-cabernet-sauvignon-c7-shop-thumbnail-1616199533615-1629735148238.jpeg','title' => '2010 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-2010',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2010-russian-river-jordan-chardonnay_library_c7-thumbnails_layers-1616262511575.jpg','title' => '2010 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/2010-2014-2016-cabernet-sauvignon-3-bottles'
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-2011',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2011-cabernetsauvignon_c7_shop_thumbnails_layers-1616452771212.jpg','title' => '2011 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-magnum-2011-wood-box',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1-5l-2011-cabernet-sauvignon-c7-shop-thumbnail-1616199563533-1629735388815.jpeg','title' => '2011 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-2012',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2012-cabernetsauvignon_c7_shop_thumbnails_layers-1616452747783.jpg','title' => '2012 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-magnum-2012-wood-box',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1-5l-2012-cabernet-sauvignon-c7-shop-thumbnail-1638207460373.jpg','title' => '2012 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-magnum-2013-wood-box',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1-5l-2013-cabernet-sauvignon-c7-shop-thumbnail-1631638767528.jpg','title' => '2013 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-2013',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2013-cabernetsauvignon_c7_shop_thumbnails_layers-1616452722473.jpg','title' => '2013 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/2013-through-2018-cabernet-sauvignon-in-wood-box-6-bottles',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/jordan_cabernet_6bottle_woodbox-c7-shop-thumbnail-1661187462950.jpg','title' => '2013 Through 2018 Cabernet Sauvignon In Wood Box', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-magnum-2014-wood-box',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1-5l-2014-cabernet-sauvignon-c7-shop-thumbnail-1616199819363-1629735668571.jpeg','title' => '2014 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-2014',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2014-cabernetsauvignon_c7_shop_thumbnails_layers-1616452686973.jpg','title' => '2014 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/2014-2015-2016-cabernet-in-wood-box-12-bottles',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/jordan_cabernet_12bottles_woodbox-c7-shop-thumbnail-1661186870441.jpg','title' => '2014, 2015 &amp; 2016 Cabernet In Wood Box - 12 Bottles', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/2015-cabernet-sauvignon-3l',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/3l-2015-cabernet-sauvignon-c7-shop-thumbnail-1682903358119.png','title' => '2015 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-magnum-2015-wood-box',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2015-jordan-winery-cabernet-sauvignon-magnum-1-5-wood-box-c7-shop-thumbnail-2-1633456495955.jpg','title' => '2015 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-2015',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2015-cabernetsauvignon_c7_shop_thumbnails_layers-1616452660617.jpg','title' => '2015 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-2016',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2016-cabernetsauvignon_c7_shop_thumbnails_layers-1616452621883.jpg','title' => '2016 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-18l-2016',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2016-jordan-winery-cabernet-sauvignon-melchior-18l-c7-shop-thumbnail-0823-1633455914336.jpg','title' => '2016 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-magnum-2016-wood-box',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2015-jordan-winery-cabernet-sauvignon-magnum-1-5-wood-box-c7-shop-thumbnail-2-1633456495955.jpg','title' => '2016 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/2015-cabernet-sauvignon-duplicate1',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2015-jordan-winery-cabernet-sauvignon-magnum-1-5l-c7-shop-thumbnail-1-1633456165018.jpg','title' => '2016 Cabernet Sauvignon (no Box)', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/2016-cabernet-sauvignon-etched-magnum',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2016-cabernet-1-5l-etched--jordan_5275_f-1654545365876.jpg','title' => '2016 Cabernet Sauvignon Etched Magnum', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-2017',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2017-cabernetsauvignon_c7_shop_thumbnails_layers-1621556023177.jpg','title' => '2017 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/2017-cabernet-sauvignon-magnum-wood-box',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/jordan-2017-magnum-1-5l_thumbnail-1682033215424.jpg','title' => '2017 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-2017',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2017-russian-river-jordan-chardonnay-c7-thumbnail-1616038621508.jpg','title' => '2017 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-2018',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2018-alexander-valley-jordan-cabernet-sauvignon_c7_shop_thumbnails_layers-1646166844249.jpg','title' => '2018 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/2018-cabernet-sauvignon-duplicate',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2018-cabernet-sauvignon-melchior-18l-thumbnail-1682902786467.png','title' => '2018 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-2018',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2018-russian-river-jordan-chardonnay-c7-thumbnail-1616038647542.jpg','title' => '2018 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/2019-cabernet-2021-chardonnay-in-gift-box',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2bottlebox_2021ch_2019cs_thumbnail-1682030675252.jpg','title' => '2019 Cabernet &amp; 2021 Chardonnay In Gift Box', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/2019-cabernet-2021-chardonnay-in-wood-box',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/jordan_2016-cabernet_2018-chardonnay_2bottles_woodbox-c7-shop-thumbnail-1652818198298.jpg','title' => '2019 Cabernet &amp; 2021 Chardonnay In Wood Box', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/2019-cabernet-2021-chardonnay-in-wood-box-six-bottles',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/jordan_cabernet_chardonnay_6bottle_woodbox-c7-shop-thumbnail-1652818543520.jpg','title' => '2019 Cabernet &amp; 2021 Chardonnay In Wood Box', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cabernet-sauvignon-2019',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2019-alexander-valley-jordan--cabernetsauvignon_c7_shop_thumbnails_layers-1678121574609.jpg','title' => '2019 Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/cabernet-olive-oil-in-gift-box',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/3bottlebox_2019csx2_2022evoo_thumbnail-1682031128606.jpg','title' => '2019 Cabernet Sauvignon &amp; 2022 Olive Oil In Gift Box', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/2019-cabernet-sauvignon-in-gift-box',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1bottlebox_2019cs_thumbnail-1682029738290.jpg','title' => '2019 Cabernet Sauvignon In Gift Box', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-2019',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2019-chardonnay_shop_thumbnails_layers-1621555965892.jpg','title' => '2019 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/2020-chardonnay-magnum',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2020-jordan-chardonnay-magnum-1-5l-thumbnail--2-1665162581114.jpg','title' => '2020 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-2020',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2020-chardonnay_shop_thumbnails_layers-1646166795859.jpg','title' => '2020 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chardonnay-2021',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2017-chardonnay_shop_thumbnails_layers-1678120905381.png','title' => '2021 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/2021-chardonnay-in-gift-box',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1bottlebox_2021ch_thumbnail-1682029835733.jpg','title' => '2021 Chardonnay In Gift Box', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/2022-jordan-estate-extra-virgin-olive-oil',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2022_shop_thumbnail_jordan_culinaryproducts_oliveoildish4-1678826048221.jpg','title' => '2022 Jordan Estate Extra Virgin Olive Oil', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/2022-jordan-estate-extra-virgin-olive-oil-in-gift-box',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/1bottlebox_2022-evoo_thumbnail-1678826936211.jpg','title' => '2022 Jordan Estate Extra Virgin Olive Oil In Gift Box', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/caviar-sampler-gift-set',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/jordan_culinaryproducts_caviar-sampler-c7-shop-thumbnail-1616196403889.jpg','title' => 'Caviar Sampler Gift Set', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/caviar-tasting-feb-13',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/jordan-winery-alfresco-lunch-c7-thumbnail-1644941139148-1698964462454.jpg','title' => 'Caviar Tasting At Vista Point-feb 13', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/caviar-tasting-feb-15',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/jordan-winery-alfresco-lunch-c7-thumbnail-1644941139148-1698964462454.jpg','title' => 'Caviar Tasting At Vista Point-feb 15', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/caviar-tasting-feb-16',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/jordan-winery-alfresco-lunch-c7-thumbnail-1644941139148-1698964462454.jpg','title' => 'Caviar Tasting At Vista Point-feb 16', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/champagne-saber-engraved',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/jordan_wineaccessory_champagnesaber-c7-shop-thumbnail-1616039442262.jpg','title' => 'Champagne Saber - Engraved', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/crystal-ornament',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2023-jordan-holiday-ornament-c7-thumbnail-1699908233670.jpg','title' => 'Crystal Jordan Ornament', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/engraved-durand-wine-opener',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/jordan_accessorybeauty_durandcorkcrew-c7-shop-thumbnail-1616039060027.jpg','title' => 'Engraved Durand Wine Opener', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/fete-dautomne-at-jordan',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/jordan-winery-big-bottle-dinner-4633-c7-thumbnail-1616457403666.jpg','title' => 'Fall Dinner-november 11', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/gift-box-1-bottle',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/jordan-1-gift-box-shop-thumbnail-1674840572525.jpg','title' => 'Gift Box - 1 Bottle', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/luxury-chocolate-gift-box',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/jordan_culinaryproducts_le-belge-chocolates_c7-shop-thumbnail-1616197418938.jpg','title' => 'Gourmet Chocolate Gift Box', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/baccarat-decanter-jordan50th',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/jordan-winery-baccarat-decanter-thumbnail-c7-1678202593871.jpg','title' => 'Jordan 50th Anniversary Baccarat Decanter', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/black-twill-stylish-baseball-cap',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2022-9-2-jordan-winery-hat-shop-thumbnail-1662157728947.jpg','title' => 'Jordan Black Baseball Cap', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-winery-champagne-bouchon',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/jordan_accessorybeauty_bouchon-c7-shop-thumbnail-1616038843805.jpg','title' => 'Jordan Champagne Bouchon', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/square-marble-coasters-chateau',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2023-jordan-chateau-coaster-thumbnail-c7-1697057941862.jpg','title' => 'Jordan Chateau Coaster', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-chefs-reserve-caviar-by-tsar-nicoulai',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/jordan_culinaryproducts_chefs-reserve-caviar-c7-shop-thumbnail-2-1616196745301.jpg','title' => 'Jordan Chef’s Reserve Caviar', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-cuvee-by-champagne-ar-lenoble',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/jordan-cuvee-by-champagne-ar-lenoble-c7-shop-thumbnail-1620060206642.jpg','title' => 'Jordan Cuvée By Champagne Ar Lenoble', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-olive-wood-cheese-board',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/jordan_culinaryproducts_oliveboard_c7-shop-thumbnail-1616084667249.jpg','title' => 'Jordan Etched Olive Wood Cheese Board', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/unique-wine-bottle-stoppers',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/jordan_wineaccessory_bottlestopper-c7-shop-thumbnail-1616039374407.jpg','title' => 'Jordan Grapevine Bottle Stopper', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/square-marble-coasters-logo',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2023-jordan-logo-coaster-thumbnail-c7-1697057999843.jpg','title' => 'Jordan Logo Coaster', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-reclaimed-wood-barrel-corkscrew',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/jordan_accessorybeauty_waiters-corkscrew-c7-shop-thumbnail-1616039302782.jpg','title' => 'Jordan Reclaimed Wine Barrel Waiter’s Corkscrew', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/jordan-signature-trio-collection-in-gift-box-3-bottles',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/3bottlebox_2021ch_2019cs_2022evoo_thumbnail-1682031649806.jpg','title' => 'Jordan Signature Trio Collection In Gift Box', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/virtual-gift-card',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2048x1759_jordan-winery-library-and-cellar-room-renovations-architecture-photos-web-36-1705436871579.jpg','title' => 'Jordan Virtual Gift Card', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/library-cabernet-2-bottles'
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/riedel-amadeo-decanter-engraved',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/jordan-riedel-amadeo-decanter---engraved_c7-shop-thumbnail-1704415217404.jpg','title' => 'Riedel Amadeo Decanter - Engraved', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/riedel-champagne-wine-glass-engraved',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/jordan_accessorybeauty_riedel-champagne-wine-glass-c7-shop-thumbnail-1616039188162.jpg','title' => 'Riedel Champagne Wine Glass - Engraved', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/riedel-vinum-wine-glass-bordeaux',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/jordan_accessorybeauty_riedel-vinum-bordeaux-glass-c7-shop-thumbnail-1616039253648.jpg','title' => 'Riedel Vinum Bordeaux Glass - Engraved', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/riedel-vinum-wine-glass-chardonnay',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/jordan_wineaccessory_riedelchardonnayglass-c7-shop-thumbnail-1616039630905.jpg','title' => 'Riedel Vinum Chardonnay Glass - Engraved', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/olive-oil-dipping-dish',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/jordan_culinaryproducts_oliveoildish_c7-shop-thumbnail-2-1616085104867.jpg','title' => 'Terraced Olive Oil Dipping Dish', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/wine-lovers-spice-blends-kit',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/2021-9-13-jordan-winery-spice-blends-kit-c7-shop-thumbnail-1631565015970.jpg','title' => 'Wine Lover’s Spice Blends', ],],
        ],
        [
            'loc' => 'https://www.jordanwinery.com/product/wooden-box-1-magnum-bottle',
            'images' => [ ['src' => 'https://images.commerce7.com/jordan-vineyard-and-winery/images/original/jordan_cabernet_2014_magnum_woodbox3-c7-shop-thumbnail-1618335498685.jpg','title' => 'Wooden Box 1 Magnum Bottle', ],],
        ],
	];

		return $links;
	}

}
