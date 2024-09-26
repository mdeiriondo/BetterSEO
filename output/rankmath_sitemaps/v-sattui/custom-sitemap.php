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
            'loc' => 'https://www.vsattui.com/product-detail/product/20-Year-Old-Port',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/20-Year-Old-Port.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2003-Morisoli-Vineyard-Cabernet-Sauvignon---Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2003-Morisoli-Vineyard-Cabernet-MAGNUM.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2004-Morisoli-Vineyard-Cabernet-Sauvignon---Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_2093.gif','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2004-Preston-Vineyard-Cabernet-Sauvignon---Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_2164.gif','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2004-Steve-Lee-Reserve-Cabernet-Sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2004-Reserve-Napa-Valley-Cab.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2005-mt-veeder-cabernet-sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2005-Mt.-Veeder-Cabernet.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2006-morisoli-vineyard-cabernet-sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/(08)Morisoli Cab.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2006-Morisoli-Vineyard-Cabernet-Sauvignon---Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2006-Morisoli-Cabernet-Sauvignon1.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2006-mt-veeder-cabernet-sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2006-Mt.-Veeder-Cabernet1.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2006-reserve-cabernet-sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2006-RESERVE-Cabernet-Sauvignon.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2007-morisoli-vineyard-cabernet-sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/07-Morisoli-Cab-1.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2007-Morisoli-Vineyard-Cabernet-Sauvignon---Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2007-Morisoli-Cabernet-Magnum.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2007-vittorios-vineyard-cabernet-sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/07-Vittorio-Cab.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2008-morisoli-vineyard-cabernet-sauvignon-2',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2008-Morisoli-Cabernet.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2008-morisoli-vineyard-cabernet-sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/08-MORI-DMAG-2.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2008-morisoli-vineyard-cabernet-sauvignon-3',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_1394.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2008-paradiso',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2008-Paradiso.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2008-preston-vineyard-cabernet-sauvignon-3',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/(08)-Preston-Cabernet.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2008-preston-vineyard-cabernet-sauvignon---Double-Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_789.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2008-preston-vineyard-cabernet-sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_790.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2008-vittorios-vineyard-cabernet-sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2008-Vittorios-Cabernet-for-web.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2008-vittorios-vineyard-cabernet-sauvignon-2',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2008 Vittorio%27s Cab Sauv Magnum.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2009-morisoli-vineyard-cabernet-sauvignon-3',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2009-Morisoli-Cabernet.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2009-morisoli-vineyard-cabernet-sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/09-MORI-DMAG.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2009-morisoli-vineyard-cabernet-sauvignon-2',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/09-MORI-DMAG2.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2009-paradiso',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2009-Paradiso1.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2009-paradiso-2',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/09-PARADISO-MAG.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2009-preston-vineyard-cabernet-sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/09-PRES-DMAG.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2009-vittorios-vineyard-cabernet-sauvignon-2',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2009-Vittorios-Cab.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2009-vittorios-vineyard-cabernet-sauvignon-3',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/09-VITT-DMAG.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2009-vittorios-vineyard-cabernet-sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/09-VITT-DMAG2.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2010-morisoli-vineyard-cabernet-sauvignon-3',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2010-Morisoli-Cab.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2010-morisoli-vineyard-cabernet-sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/10-MORI-MAG-1.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2010-Mt-Veeder-Cabernet-Sauvignon-Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/10-MT-VEEDER-MAG.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2010-paradiso-3',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2010 Paradiso.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2010-paradiso',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/10-PARADISO-DMAG-1.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2010-paradiso-2',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/10-PARADISO-DMAG.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2010-preston-vineyard-cabernet-sauvignon-2',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2010-Preston-Cab.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2010-vittorios-vineyard-cabernet-sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/10-VITT-MAG2.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2010-vittorios-vineyard-cabernet-sauvignon-3',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/10-VITT-MAG1.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2011-morisoli-vineyard-cabernet-sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/11-MORI-MAG-2.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2011-mt-veeder-cabernet-sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2011-Mt-Veeder-Cabernet-Sauvignon.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2011-Paradiso-Double-Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2011 Paradiso1.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2011-Paradiso---Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2011 Paradiso.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2011-preston-vineyard-cabernet-sauvignon-2',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2011-Preston-Cab.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2011-preston-vineyard-cabernet-sauvignon-3',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/10-PRES-MAG-11.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2011-vittorios-vineyard-cabernet-sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2011-Vittorios-Cabernet.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2011-Vittorio%27s-Vineyard-Cabernet-Sauvignon---Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2011 Vittorio%27s Cabernet.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2012-morisoli-vineyard-cabernet-sauvignon-3',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2012 Morisoli Cabernet.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2012-morisoli-vineyard-cabernet-sauvignon-2',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2012-Morisoli-Cab-MAG NEW.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2012-mt-veeder-cabernet-sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2012-Mt-Veeder-Cabernet.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2012-Mt-Veeder-Cabernet-Sauvignon-Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/12-MT-VEEDER-MAG.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2012-Preston-Cabernet-Sauvignon-Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/12-PRES-MAG.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2012-vittorios-vineyard-cabernet-sauvignon-magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2012-Vittorio-Cab-MAG.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2013-Black-Sears-Vineyard-Zinfandel-Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2013 Black Sears Howell Mountain Zin Magnum NEW.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2013-carsi-vineyard-chardonnay-magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2013-Carsi-Chardonnay-MAG-1.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2013-los-carneros-chardonnay-magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2013-Los-Carneros-Chardonnay-MAG.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2013-Morisoli-Vineyard-Caberent-Sauvignon---Double-Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2013-Morisoli-Cabernet-MAGNUM1.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2013-Morisoli-Vineyard-Cabernet-Sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2013-Morisoli-Cabernet-Sauvignon.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2013-Morisoli-Vineyard-Cabernet-Sauvignon---Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/12-MORI-MAG.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2013-Mt.-Veeder-Cabernet-Sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2013-Mt-Veeder-Cabernet-Sauvignon.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2013-Mt-Veeder-Cabernet Sauvignon-Double-Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_1305.png','title' => '2013 Mt. Veeder Cabernet Sauvignon - Double Magnum', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2013-Mt-Veeder-Cabernet-Sauvignon-Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2013 Mt Veeder Cab (MAGNUM).png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2013-Paradiso-Double-Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2013-Paradiso1.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2013-Paradiso---Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2013-Paradiso2.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2013-Preston-Vineyard-Cabernet-Sauvignon-Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2013 Preston Cab Sauv Magnum NEW.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2013-Vittorio%27s-Vineyard-Cabernet-Sauvignon---Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2013 Vittorio%27s Vin Cab Sauv Magnum NEW.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2014-Anderson-Valley-Pinot-Noir---Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2014 Anderson Valley Pinot Noir Magnum.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2014-Black-Sears-Vineyard-Zinfandel-Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2014-Black-Sears-Zin-Magnum.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2014-Carsi-Vineyard-Chardonnay---Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2014 Carsi Vineyards Chardonnay Magnum.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2014-Los-Carneros-Chardonnay---Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2014 Los Carneros Chardonnay Magnum.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2014-Morisoli-Vineyard-Cabernet-Sauvignon---Double-Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2014-Morisoli-Vin-Cab-Sauv-DBL Magnum-updated.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2014-Morisoli-Vineyard-Cabernet-Sauvignon---Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2014-Morisoli-Vineyards-Cab-Sauv Magnum-updated.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2014-Mt.-Veeder-Cabernet-Sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2014-Mt-Veeder-Cabernet-Sauvignon.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2014-Mt-Veeder-Cabernet-Sauvignon-Double-Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2014-Vittorio%27s-Vin-Cab-Sauv-DBL-Magnum-updated1.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2014-Mt.-Veeder-Cabernet-Sauvignon-Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2014-Mt-Veeder-Cab-Sauv-Magnum-updated.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2014-Paradiso-Double-Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2014-Paradiso2.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2014-Paradiso---Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2014-Paradiso1.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2014-Preston-Vineyard-Cabernet-Sauvignon-Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/12-PRES-MAG2.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2014-Regina',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_13193.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2014-Vittorio%27s-Vineyard-Cabernet-Sauvignon---Double-Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2014-Vittorio%27s-Vin-Cab-Sauv-DBL-Magnum-updated.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2014-Vittorio%27s-Vineyard-Cabernet-Sauvignon---Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2014-Vittorio-Cabernet-Sauvignon-Magnum-updated.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2015-Anderson-Valley-Pinot-Noir---Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2015-Anderson-Valley-Pinot-Noir-Magnum.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2015-Carsi-Vineyard-Chardonnay---Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2015-Carsi-Vineyards-Chardonnay-Magnum.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2015-Grappa-Riserva---Ghino di Tacco',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2015-Grappa-Riserva---Ghino-de-Tacco.png','title' => '2015 Grappa Riserva - Ghino Di Tacco', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2015-Los-Carneros-Chardonnay---Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2015-Los-Carneros-Chardonnay-Magnum.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2015-Morisoli-Vineyard-Cabernet-Sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2015-Morisoli-Vineyards-Cab.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2015-Morisoli-Vineyard-Cabernet-Sauvignon---Double-Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2015-Morisoli-Cab-Sauv-DBL-Magnum-updated.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2015-Morisoli-Vineyard-Cabernet-Sauvignon---Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2015-Morisoli-Cab-Sauv-Magnum-updated.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2015-Mt.-Veeder-Cabernet-Sauvignon---Double-Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2015-Mt-Veeder-Cab-Sauv-DBL Magnum-updated.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2015-Mt.-Veeder-Cabernet-Sauvignon-Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2015-Mt-Veeder-Cab-Sauv-Magnum-updated.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2015-Paradiso-Double-Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_1103.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2015-Paradiso---Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2015-Paradiso---Magnum.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2015-Preston-Cabernet-Sauvignon---Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2015-Preston-Vineyard-Cab-Sauv-Magnum-Updated.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2015-Preston-Vineyard-Cabernet-Sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2015-Preston-Vineyard-Cabernet-Sauvignon1.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2015-Preston-Vineyard-Cabernet-Sauvignon---Double-Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2015-Preston-Cabernet-DBL-Magnum.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2015-Vintage-Port',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2015-Vintage-Port1.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2015-Vittorio%27s-Vineyard-Cabernet-Sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2015-Vittorio-Cabernet-Sauvignon.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2015-Vittorio%27s-Vineyard-Cabernet-Sauvignon---Double-Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2015-Vittorio%27s-Vin-Cab-Sauv-DBL-Magnum-updated.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2015-Vittorio%27s-Vineyard-Cabernet-Sauvignon---Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2015-Vittorio%27s-Cab-Sauv-Magnum-updated.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2016-Anderson-Valley-Pinot-Noir---Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2016-Anderson-Valley-Pinot-Noir-Magnum.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2016-Carsi-Vineyard-Chardonnay---Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2016-Carsi-Vineyards-Chardonnay-Magnum.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2016-Los-Carneros-Chardonnay---Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2016-Los-Carneros-Chardonnay-Magnum.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2016-Los-Carneros-Pinot-Noir---Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2016-Los-Carneros-Pinot-Noir-Magnum.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2016-Morisoli-Vineyard-Cabernet-Sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2016-Morisoli-Vineyards-Cabernet-Sauvignon1.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2016-Morisoli-Vineyard-Cabernet-Sauvignon---Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2016-Morisoli-Cab-Sauv-Magnum-updated.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2016-Morisoli-Vineyard-Cabernet-Sauvignon--Double-Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2016-Morisoli-Cab-Sauv-DBL magnum-updated.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2016-Mt.-Veeder-Cabernet-Sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2016-Mt.-Veeder-Cabernet-Sauvignon1.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2016-Mt.-Veeder-Cabernet-Sauvignon---Double-Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2016-Mt-Veeder-Cab-Sauv-DBL Magnum-updated.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2016-Mt.-Veeder-Cabernet-Sauvignon---Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2016-Mt-Veeder-Cab-Sauv-Magnum-updated.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2016-Paradiso',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2016-Paradiso3.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2016-Paradiso-Double-Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2016-Paradiso2.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2016-Preston-Vineyard-Cabernet-Sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2016-Preston-Vineyard-Cab-Sauv.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2016-Preston-Vineyard-Cabernet-Sauvignon---Double-Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2016-Preston-Cab-Sauv-DBL-Magnum.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2016-Preston-Vineyard-Cabernet-Sauvignon---Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2016-Preston-Vineyard-Cab-Sauv-Magnum-updated.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2016-Vittorio%27s-Vineyard-Cabernet-Sauvignon---Double-Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2016-Vittorio%27s-Vin-Cab-Sauv-DBL Magnum-updated.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2016-Vittorio%27s-Vineyard-Cabernet-Sauvignon---Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2016-Vittorio%27s-Cab-Sauv-Magnum-updated.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2017-Blanc-de-Noir',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2017-Blanc-de-Noir1.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2017-Carsi-Vineyard-Chardonnay---Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2017-Carsi-Vineyards-Chardonnay-Magnum.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2017-Los-Carneros-Chardonnay---Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2017-Los-Carneros-Chardonnay-Magnum.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2017-Morisoli-Vineyard-Cabernet-Sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2017-Morisoli-Cabernet-Sauvignon.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2017-Mt.-Veeder-Cabernet-Sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2017-Mt-Veeder-Cabernet-Sauvignon.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2017-Paradiso---Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2017-Paradiso1.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2017-Rutherford-Dust-Up-Cabernet-Sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2017 Rutherford Dust Up1.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2017-Vittorio%27s-Vineyard-Cabernet-Sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2017-Vittorios-Vineyards-Cabernet-Sauvignon.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2018-Carsi-Vineyard-Chardonnay---Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2018-Carsi-Chardonnay-Magnum.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2018-Morisoli-Vineyard-Cabernet-Sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2017-Morisoli-Cabernet-Sauvignon2.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2018-Paradiso',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2018-Paradiso2.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2018-Paradiso-Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_638.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2018-Prestige-Cuvée-Brut-Rosé',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2018-Prestige-Cuvee-Brut-Rose1.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2018-Preston-Vineyard-Cabernet-Sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2018-Preston-Cabernet-Sauvignon.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2018-Preston-Vineyard-Cabernet-Sauvignon---Magnum',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2018-Preston-Cabernet-Sauvignon-MAGNUM.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2018-Rutherford-Dust-up-Cabernet-Sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_605.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2018-Terra-Forza-Cabernet-Sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2018-Terra-Forza.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/Cab18-Vangone-(MAG)',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_16090.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2018-vittorios-vineyard-cabernet-sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2018-Vittorios-Vineyards-Cabernet-Sauvignon.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2019-Dry-Creek-Zinfandel',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2019-Dry-Creek-Zinfandel.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2019-Monastero-Le-Vallesi-Sangiovese',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2019-Sangiovese---Monastero-Vallesi2.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2019-Morisoli-Vineyard-Cabernet-Sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2019-Morisoli-Vineyard-Cabernet-Sauvignon.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2019-Mounts-Vineyard-Zinfandel',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_15381.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2019-Mt.-Veeder-Cabernet-Sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2019-Mt-Veeder-Cabernet-Sauvignon.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2019-Napa-Valley-Cabernet-Sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_20368.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2019-Paradiso',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_15952.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2019-Preston-Vineyard-Cabernet-Sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_16131.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2019-Reserve-Napa-Valley-Chardonnay',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2019-Reserve-Chardonnay.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2019-Rutherford-Dust-up-Cabernet-Sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_20162.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2019-Sattui-Family-Red',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2019-Sattui-Family-Red.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2019-Sattui-Family-Red-1975-Case',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_20671.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2019-Vangone-Vineyard-Cabernet-Sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_16132.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/Cab19-Vittorio-Vineyard-Cabernet-Sauvignon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_16133.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2019-Vittorio%27s-Vineyard-Petit-Verdot',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_15953.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2020-Cara-Chardonnay',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2020-Cara-Chardonnay.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2020-Duarte-Vineyard-Zinfandel',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2020-Duarte-Zinfandel.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2020-Entanglement-(GSM)',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2020-Entanglement.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2020-Gilsson-Vineyard-Zinfandel',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_20042.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2020-Napa-Valley-Grenache',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_17006.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2020-Napa-Valley-Syrah',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2020-Napa-Valley-Syrah.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2020-Pilgrim-Vineyard-Zinfandel',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_16275.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2020-Quaglia-Vineyard-Zinfandel',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2020-Quaglia-Vineyard-Zinfandel.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2020-Reserve-Chardonnay-Napa-Valley',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_20015.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2021-Alexander-Valley-Cabernet-Franc',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_17161.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2021-Amador-Ridge-Vineyard-Zinfandel',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_17157.jpg','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2021-Bacci-Red-Blend',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2014-Bacci3.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2021-Black-Sears-Zinfandel-(Howell Mountain)',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_17153.png','title' => '2021 Black-sears Zinfandel (howell Mountain)', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2021-Boonville-Ranch-Pinot-Noir',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2021-Booneville-Ranch-Pinot-Noir.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2021-Carsi-Vineyard-Chardonnay',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_20002.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2021-Collina-d%27-Oro-Chardonnay',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_17017.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2021-Collina-d%27Oro-Pinot-Noir',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2021-Collina-d%27Oro-Pinot-Noir.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2021-Collins-Family-Vineyard-Zinfandel',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_17158.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2021-Entanglement-(GSM)',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_17007.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2021-La-Merica',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_20560.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2021-Los-Carneros-Pinot-Noir',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/2021-Los-Carneros-Pinot-Noir.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2021-Napa-Valley-Chardonnay',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_16646.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2021-Napa-Valley-Malbec',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_17160.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2021-Napa-Valley-Merlot',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_17159.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2021-Napa-Valley-Petite-Sirah',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_17163.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2021-Napa-Valley-Syrah',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_17014.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2021-Prestige-Cuvée-Brut',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_20496.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2021-Ramazzotti-Vineyard-Zinfandel',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_17012.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2021-Russian-River-Zinfandel',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_20584.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2021-School-House-Creek-Zinfandel',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_17154.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2022-albarino',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_20103.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2022-Another-World-Riesling',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_20003.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2022-Bacci-Bianco',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_20085.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2022-Bacci-Rosato',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_20086.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2022-Dry-Riesling',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_17001.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2022-Gamay-Rouge',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_20056.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2022-Gamay-Rouge-1975-Case',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_20670.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2022-Los-Carneros-Chardonnay',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_17019.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2022-Moscato',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_1566.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2022-Muscat',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_20105.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2022-Napa-Valley-Sauvignon-Blanc',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_20101.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2022-Napa-Valley-Semillon',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_20102.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2022-Off-Dry-Riesling',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_17179.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2022-Rosato-di-Pinot-Noir',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_20104.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/2022-Tre-Uve-Bianco',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_20084.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/angelica',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/vinsuite/wines/large/Angelica.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/Brandy---Aged-in-Madeira-Barrels',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_1554.jpg','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/Madeira',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_922.png','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/Sweet-Surrender-3-pack',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_20457.jpg','title' => '{', ],],
        ],
        [
            'loc' => 'https://www.vsattui.com/product-detail/product/Wine-Me-Up',
            'images' => [ ['src' => 'https://client-assets.ecellar1.com/vsattui/prod_header_1420.jpg','title' => '{', ],],
        ],
	];

		return $links;
	}

}
