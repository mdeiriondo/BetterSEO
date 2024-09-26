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
            'loc' => 'https://wilsoncreek.wpengine.com/product/2018-malbec-ship-only',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/420786-1695753689076.jpg','title' => '2018 Malbec', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/2019-cinsault',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/420253-1695753708019.jpg','title' => '2019 Cinsault', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/2019-family-reserve-meritage',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/424980-1695754598773.jpg','title' => '2019 Family Reserve Meritage', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/2019-family-reserve-syrah',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/419116-1695754345171.jpg','title' => '2019 Family Reserve Syrah', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/2019-family-reserve-zinfandel-ship-only',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/420773-1695754359030.jpg','title' => '2019 Family Reserve Zinfandel', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/2019-gsm-ship-only',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/420752-1695754153543.jpg','title' => '2019 Gsm', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/2019-malbec',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/421612-1695754315850.jpg','title' => '2019 Malbec', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/2019-family-reserve-petite-sirah',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/424012-1695754820128.jpg','title' => '2019 Petite Sirah', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/2020-bourbon-barrel-zinfandel',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/424986-1695753786857.jpg','title' => '2020 Bourbon Barrel Zinfandel', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/2020-cabernet-franc',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/421621-1695753735676.jpg','title' => '2020 Cabernet Franc', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/2020-gsm',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/424018-1695754601118.jpg','title' => '2020 Gsm', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/2020-mourvedre-ship-to-only',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/423061-1695754793486.jpg','title' => '2020 Mourvedre', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/2020-family-reserve-syrah',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/424045-1695755095828.jpg','title' => '2020 Syrah', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/2020-family-reserve-zinfandel',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/422312-1695754305502.jpg','title' => '2020 Zinfandel', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/2021-arroyo-seco-malbec',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/426064-1695753708757.jpg','title' => '2021 Arroyo Seco Malbec', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/2021-arroyo-seco-pinot-noir',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/426067-1695753784690.jpg','title' => '2021 Arroyo Seco Pinot Noir', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/2021-barbera',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/425011-1695754770121.jpg','title' => '2021 Barbera', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/2021-cinsault',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/426113-1695754574539.jpg','title' => '2021 Cinsault', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/2021-double-dog-red',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/425256-1695753689751.jpg','title' => '2021 Double Dog Red', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/2021-ecclesia',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/ecclesia-website-1697129111360.jpeg','title' => '2021 Ecclesia', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/2021-gsm',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/426331-1695754526729.jpg','title' => '2021 Gsm', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/2021-meritage-',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/meritagenew-web-1697732629206.jpg','title' => '2021 Meritage', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/2021-mourvedre',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/425410-1695754947029.jpg','title' => '2021 Mourvedre', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/2021-family-reserve-merlot',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/426485-1695754445098.jpg','title' => '2021 Reserve Merlot', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/2021-family-reserve-syrah',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/426098-1695754039553.jpg','title' => '2021 Syrah', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/2021-vardande-syrah-blend',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/426337-1695754990107.jpg','title' => '2021 Vardande Syrah', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/2022-muscat-canelli',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/426072-1695754870164.jpg','title' => '2022 Arroyo Seco Muscat Canelli', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/2022-golden-jubilee',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/424491-1695754278398.jpg','title' => '2022 Golden Jubilee', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/2022-moscato',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/424701-1695754342368.jpg','title' => '2022 Moscato', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/2022-roussanne',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/425197-1695753929569.jpg','title' => '2022 Roussanne', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/2022-yes-dear-chardonnay',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/425954-1695754925709.jpg','title' => '2022 Yes Dear Chardonnay', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/route-91-almond-black',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/416817-1695754342675.jpg','title' => '2nd Anniversary Route 91 Almond', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/route-91-almond-sparkling-orange',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/416818-1695754306085.jpg','title' => '3rd Anniversary Route 91 Almond', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/route-91-chardonnay',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/416822-1695753694158.jpg','title' => '3rd Anniversary Route 91 Chardonnay', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/route-91-lovewins-country-strong',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/419562-1695754550997.jpg','title' => '4th Anniversary Route 91 Almond', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/5th-year-anniversary--route-91-almond',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/422613-1695754870876.jpg','title' => '5th Anniversary Route 91 Almond', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/5th-year-anniversary-route-91-cabernet',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/422825-1695754547786.jpg','title' => '5th Anniversary Route 91 Cabernet', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/5th-year-anniversary--route-91-peach',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/422614-1695754125402.jpg','title' => '5th Anniversary Route 91 Peach', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/route-91-nation-almond',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/426451-1695754965216.jpg','title' => '6th Anniversary Route 91 Almond', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/route-91-nation-cabernet-blend',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/426495-1695754895093.jpg','title' => '6th Anniversary Route 91 Cabernet', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/route-91-nation-peach',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/426473-1695754341680.jpg','title' => '6th Anniversary Route 91 Peach', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/almond-sparkling-cans-4-pack',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/almond-with-can-1704215153244.png','title' => 'Almond Sparkling Cans 4pk', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/almond-bottle-can-3pk-combo',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/almond-with-can-1704215492957.png','title' => 'Almond Sparkling Combo', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/almond-sparkling-wine',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/422466-1695754677212.jpg','title' => 'Almond Sparkling Wine', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/almond-tini-2pk',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/424024-1695755166152.jpg','title' => 'Almond-tini', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/artist-series-limited-edition-4pk',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/426402-1695754895807.jpg','title' => 'Artist Series Limited Edition 4pk', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/handsome-little-man',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/416017-1695755214240.jpg','title' => 'Baby: Handsome Little Man', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/its-a-boy',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/416025-1695754180528.jpg','title' => 'Baby: It\'s A Boy', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/its-a-girl',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/416026-1695754037784.jpg','title' => 'Baby: It\'s A Girl', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/sweet-little-girl',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/416031-1695754871389.jpg','title' => 'Baby: Sweet Little Girl', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/bbq-2pk',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/425204-1695754770396.jpg','title' => 'Bbq 2pk', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/be-as-bubbly-as-your-drink',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/416023-1695755130286.jpg','title' => 'Be As Bubbly As Your Drink', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/hbd-cheers',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/416061-1695754780168.jpg','title' => 'Birthday: Cheers', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/birthday--from-all-of-us',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/424412-1695754946352.jpg','title' => 'Birthday: From All Of Us', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/happy-birthday-cabernet',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/424475-1695755105311.jpg','title' => 'Birthday: Happy Birthday Cabernet', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/make-a-wish',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/424470-1695754677281.jpg','title' => 'Birthday: Make A Wish', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/happy-birthday-teal',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/424399-1695754598698.jpg','title' => 'Birthday: Teal', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/bosss-day',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/416020-1695754878206.jpg','title' => 'Boss\'s Day', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/brut-187-ml-single-bottle'
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/brut-sparkling-custom-labeled',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/420405-1695754946435.jpg','title' => 'Brut Sparkling Customized', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/brut-sparkling-wine',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/420441-1695753931461.jpg','title' => 'Brut Sparkling Wine', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/special-edition-brut-sparkling',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/426074-1695754498207.jpg','title' => 'Brut Sparkling-limited Edition', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/bulk-corporate-tax-consolidation'
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/can-i-be-frank-sinatra-tribute',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/canibefrank-1701366947034.jpg','title' => 'Can I Be Frank? Sinatra Tribute', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/can-i-be-frank-sinatra-tribute-duplicate3',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/canibefrank-1701366947034.jpg','title' => 'Can I Be Frank? Sinatra Tribute', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/can-i-be-frank-sinatra-tribute-duplicate1',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/canibefrank-1701366947034.jpg','title' => 'Can I Be Frank? Sinatra Tribute', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/can-i-be-frank-sinatra-tribute-duplicate',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/canibefrank-1701366947034.jpg','title' => 'Can I Be Frank? Sinatra Tribute', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/can-i-be-frank-sinatra-tribute-duplicate2',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/canibefrank-1701366947034.jpg','title' => 'Can I Be Frank? Sinatra Tribute', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/can-i-be-frank-sinatra-tribute-duplicate4',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/canibefrank-1701366947034.jpg','title' => 'Can I Be Frank? Sinatra Tribute', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/cheers-to-you',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/416032-1695754743703.jpg','title' => 'Cheers To You', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/coconut-nui-187-split-single-btl'
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/coconut-nui-6pk-sparkling',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/425635-1695754728670.jpg','title' => 'Coconut Nui Sparkling 6pk', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/coconut-nui-sparkling-wine',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/420442-1695754820077.jpg','title' => 'Coconut Nui Sparkling Wine', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/corporate-thankyou-card-insert'
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/crash-crush-ros',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/416662-1695755091226.jpg','title' => 'Crash Crush Rosé', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/credit-creekside-grillefood'
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/decadencia-chocolate-old-vine-zinfandel',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/424013-1695754989630.jpg','title' => 'Decadencia®', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/decadent-cocktail',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/424891-1695753709991.jpg','title' => 'Decadent Cocktail', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/mixed-october-club',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/ecclesia-2nd-photo-1700255679339.jpg','title' => 'December Mixed Club', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/white-cabernet-october-',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/dec-white-cab-club-1700255444557.jpg','title' => 'December White Cabernet Club', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/design-label-fee'
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/dia-de-los-muertos',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/422551-1695754100653.jpg','title' => 'Dia De Los Muertos', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/dress-up-your-pet-day--golden',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/423983-1695755052936.jpg','title' => 'Dress Up Your Pet Day- Golden', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/dress-up-your-pet-day--owl-bee',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/423975-1695754092826.jpg','title' => 'Dress Up Your Pet Day- Owl Bee', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/dress-up-your-pet-day-green-bow',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/423962-1695754793677.jpg','title' => 'Dress Up Your Pet Day-green Bow', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/dress-up-your-pet-day-pig',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/423973-1695754502280.jpg','title' => 'Dress Up Your Pet Day-pig', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/drink-almond--pet-my-dog',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/417170-1695754480026.jpg','title' => 'Drink Almond &amp; Pet My Dog', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/e-gift-card-redeemable-only-online1',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/420011-1695754899260.jpg','title' => 'E-gift Card (redeemable Only Online)', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/e-gift-card-redeemable-only-online2',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/420013-1695754965532.jpg','title' => 'E-gift Card (redeemable Only Online)', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/e-gift-card-redeemable-only-online',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/420012-1695754598848.jpg','title' => 'E-gift Card (redeemable Only Online)', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/employee-appreciation-day',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/418392-1695754090464.jpg','title' => 'Employee Appreciation Day!', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/engagement-sparkling-wine-trio',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/417978-1695754778992.jpg','title' => 'Engagement Sparkling Wine Trio', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/pairs-well-with-sparkling-ring',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/421012-1695754768322.jpg','title' => 'Engagement: Pairs Well With Ring!', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/she-said-yes-almond-sparkling',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/426544-1695755107522.jpg','title' => 'Engagement: She Said Yes!', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/she-said-yes-rose-sparkling',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/426550-1695754100675.jpg','title' => 'Engagement: She Said Yes!', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/rosie-wilsons-favorite-3pk',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/425033-1695755009145.jpg','title' => 'Favorite 3pk', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/freight-interceptredirect-fee'
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/freight-upgrade-increase'
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/gift-card',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/421185-1695753691516.jpg','title' => 'Gift Card', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/congrats-grad',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/416022-1695754454677.jpg','title' => 'Graduation: Congrats', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/graduation-hooray',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/416012-1695754350269.jpg','title' => 'Graduation: Hooray', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/holiday-bubbles-assorted-6pk',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/423739-1695753766136.jpg','title' => 'Holiday Bubbles Assorted 6pk', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/honey-badger-almond',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/416659-1695754987970.jpg','title' => 'Honey Badger Almond', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/icepack-1-6-bottles'
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/icepack-7-12-bottles'
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/its-330-somewhere',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/419293-1695754421097.jpg','title' => 'It\'s 3:30 Somewhere!', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/limoncello-sparkling-cans-4-pack',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/limoncello-and-can-1704215283193.png','title' => 'Limoncello Sparkling Cans 4pk', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/limoncello-bottle-can-3pk-combo',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/limoncello-and-can-1704215915529.png','title' => 'Limoncello Sparkling Combo', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/limoncello-sparkling-lemon-wine',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/420443-1695754080023.jpg','title' => 'Limoncello Sparkling Lemon Wine', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/long-sleeve-bling-logo-shirt',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/417171-1695753745403.jpg','title' => 'Long Sleeve Bling Logo Shirt', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/love-and-laughter',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/416074-1695754086762.jpg','title' => 'Love And Laughter', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/malbec-vintage-3pk',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/malbec-3pkwithspeciallabel-1699462969357.jpg','title' => 'Malbec Vintage 3pk', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/mand-back-187-almond-split-single'
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/mens-long-sleeve-shirt',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/416977-1695753788172.jpg','title' => 'Men\'s Long Sleeve Shirt', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/mi-amore',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/416033-1695755210634.jpg','title' => 'Mi Amore', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/mixed-sparkling-cans-4-pack',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/424634-1695753734219.jpg','title' => 'Mixed Sparkling Cans 4pk', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/my-bottle-of-happy',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/416028-1695755158094.jpg','title' => 'My Bottle Of Happy', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/national-dog-day-corgi',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/422490-1695754153555.jpg','title' => 'National Dog Day Corgi', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/national-dog-day-golden',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/422487-1695754277749.jpg','title' => 'National Dog Day Golden', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/national-mimosa-day-3pk',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/421523-1695754280910.jpg','title' => 'National Mimosa Day! 3pk', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/new-home',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/418340-1695754068459.jpg','title' => 'New Home', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/nv-cinsault',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/424684-1695755126606.jpg','title' => 'Nv Cinsault', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/nv-grenache',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/426159-1695754305798.jpg','title' => 'Nv Grenache', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/nv-plethora',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/418647-1695753900179.jpg','title' => 'Nv Plethora', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/nv-spring-white',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/424696-1695754501090.jpg','title' => 'Nv Spring White', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/nv-vs-cabernet-zinfandel',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/420553-1695754392171.jpg','title' => 'Nv Vs Cabernet Zinfandel', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/old-world-cabernet',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/416665-1695754583214.jpg','title' => 'Old World Cabernet', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/orange-mimosa-sparkling-3pk',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/425134-1695754732485.jpg','title' => 'Orange Mimosa Sparkling 3pk', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/orange-mimosa-sparkling-wine',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/420448-1695755087864.jpg','title' => 'Orange Mimosa Sparkling Wine', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/other--issues-a-credit-through-clover'
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/peach-187-split-single-btl'
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/peach-bellini-sparkling-wine',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/422167-1695754128969.jpg','title' => 'Peach Bellini Sparkling Wine', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/peach-sparkling-cans-4-pack',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/peach-and-can-1704215344036.png','title' => 'Peach Sparkling Cans 4pk', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/peach-bottle-can-3pk-combo',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/peach-and-can-1704215955460.png','title' => 'Peach Sparkling Combo', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/perfect-wine--cheese-pairing',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/426082-1695754535819.jpg','title' => 'Perfect Wine &amp; Cheese Pairing', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/3pk-picnic-pack-favorites',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/422458-1695753972513.jpg','title' => 'Picnic Pack Favorites 3pk', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/plethora-shiners'
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/legacy-realty-sparkling-brut',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/426322-1695754849087.jpg','title' => 'Private: Legacy Realty', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/manoela-cabernet-sauvignon',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/426282-1695753929310.jpg','title' => 'Private: Manoela', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/mtg-custom-labeled-sparkling',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/425578-1695754598804.jpg','title' => 'Private: Mtg', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/revolv3-sparkling-brut',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/425376-1695755127090.jpg','title' => 'Private: Revolv3  Brut', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/revolv3-custom-label-almond',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/425375-1695753810146.jpg','title' => 'Private: Revolv3 Almond', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/revolv3-cabernet-sauvignon',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/425373-1695754420723.jpg','title' => 'Private: Revolv3 Cab', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/stark-carpet-custom-labeled',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/425883-1695754391505.jpg','title' => 'Private: Stark Carpet', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/promotion',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/422845-1695754851231.jpg','title' => 'Promotion', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/rainbow-of-sparkling-4pk',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/424153-1695753841151.jpg','title' => 'Rainbow Of Sparkling 4pk', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/retirement-beach--chairs',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/425873-1695755007078.jpg','title' => 'Retirement: Beach &amp; Chairs', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/happy-retirement-gold-stars',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/425865-1695754965225.jpg','title' => 'Retirement: Gold Stars', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/rose-sparkling-cans-4-pack',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/ros-and-can-1704215738647.png','title' => 'Rose Sparkling Cans 4pk', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/rose-bottle-can-3pk-combo',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/ros-and-can-1704215426868.png','title' => 'Rose Sparkling Combo', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/rose-sparkling-wine',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/420447-1695754768214.jpg','title' => 'Rose Sparkling Wine', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/rose-sparkling--yes-way-rose',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/416679-1695754966107.jpg','title' => 'Rose Sparkling- Yes Way Rose', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/sangria-sparkling-wine',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/420446-1695754874913.jpg','title' => 'Sangria Sparkling Wine', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/sangria-splash-3pk',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/424793-1695754475888.jpg','title' => 'Sangria Splash 3pk', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/sparkling-assorted-12-pack',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/421991-1695755018351.jpg','title' => 'Sparkling Assorted 12pk', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/6pk-sparkling-bubbly-favorites',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/420928-1695754312556.jpg','title' => 'Sparkling Bubbly Favorites 6pk', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/sparkling-sangria-6pk',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/421343-1695754422801.jpg','title' => 'Sparkling Sangria 6pk', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/almond--brut-sparkling-2pk',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/423120-1695755183324.jpg','title' => 'Sparkling Wine 2pk', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/special-edition-malbec-postcard'
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/special-edition-pinot-noir-postcard'
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/summer-splash-6-pk',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/421817-1695753858029.jpg','title' => 'Summer Splash 6 Pk', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/sunset-sparkling-3pk',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/424792-1695755048060.jpg','title' => 'Sunset Sparkling 3pk', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/sweetheart-4pk',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/424091-1695753896375.jpg','title' => 'Sweetheart 4pk', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/the-wilson-creek-story',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/417109-1695754684130.jpg','title' => 'The Wilson Creek Story', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/unisex-hoodie',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/416979-1695754969900.jpg','title' => 'Unisex Hoodie', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/valentine-2022-tic-tac',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/420699-1695754768351.jpg','title' => 'Valentine 2022 Tic-tac', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/valentines-3pk-sparkling-custom-label',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/424131-1695754661972.jpg','title' => 'Valentine\'s 3pk Custom Label', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/valentines-3pk--almond-tini-recipe',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/420802-1695754925493.jpg','title' => 'Valentine\'s Almond-tini Recipe &amp; Sparkling Rose', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/variant-series-6-pack-shipping-included',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/417778-1695754258159.jpg','title' => 'Variant Series 6 Pack-shipping Included', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/virtual-gift-card-25',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/egiftcard-002-1699306718210.jpg','title' => 'Virtual Gift Card', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/4pk-vs-cabernet-zinfandel',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/423927-1695753710607.jpg','title' => 'Vs Cabernet Zinfandel 4pk', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/vs-series-12pk-combo',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/vs-1701456093985.jpg','title' => 'Vs Series 12pk Combo', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/6pk-vs-white-cabernet--cabernet-zinfandel',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/423283-1695753858070.jpg','title' => 'Vs Series 6pk', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/4pk-vs-white-cabernet-lover',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/423926-1695754820127.jpg','title' => 'Vs White Cabernet Lover 4pk', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/nv-variant-series-white-cabernet-sauvignon',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/421137-1695753891206.jpg','title' => 'Vs White Cabernet Sauvignon', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/wakefield-reunion',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/425670-1695755157537.jpg','title' => 'Wakefield Reunion', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/watermelon-sparkling-wine',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/420445-1695755006728.jpg','title' => 'Watermelon Sparkling Wine', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/brides-tribe',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/416680-1695754776834.jpg','title' => 'Wedding: Brides Tribe', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/eat-drink--be-married',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/416049-1695754782403.jpg','title' => 'Wedding: Eat Drink &amp; Be Married', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/cheers-future-mrs',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/416021-1695753693078.jpg','title' => 'Wedding: Future Mrs', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/happily-ever-after',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/416060-1695754468035.jpg','title' => 'Wedding: Happily Ever After', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/id-marry-you',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/423630-1695753841327.jpg','title' => 'Wedding: I\'d Marry You!', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/6-pack-of-marriage-milestone-wines',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/416047-1695754215706.jpg','title' => 'Wedding: Milestone  6-pack', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/mr---mrs-------------blk--wht-design',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/416076-1695754057184.jpg','title' => 'Wedding: Mr. &amp; Mrs.', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/mr---mrs--classic',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/416075-1695755187226.jpg','title' => 'Wedding: Mr. &amp; Mrs. Classic', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/3-pk--white-cabcabzin--almond',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/422390-1695754793667.jpg','title' => 'White Cab, Cabzin &amp; Almond', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/wholesale-adjustment'
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/will-you-bridesmaid',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/416034-1695754833454.jpg','title' => 'Will You Bridesmaid', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/will-you-marry-me',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/416035-1695753974070.jpg','title' => 'Will You Marry Me', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/wilson-creek-logo--2-pack-glassware',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/423887-1695753953934.jpg','title' => 'Wilson Creek Logo- 2 Pack Glassware', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/wine-wishes',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/416676-1695755054585.jpg','title' => 'Wine Wishes', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/winemaker-s-dinner-january-18th',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/winemakersdinner-1701804094885.jpg','title' => 'Winemaker\'s Dinner - January 18th', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/winemakers-dinner-january-24th',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/winemakersdinner-1701804094885.jpg','title' => 'Winemaker\'s Dinner - January 24th', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/winter-mulled-spiced-wine-2pk-with-recipe',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/423308-1695753915929.jpg','title' => 'Winter Mulled Spiced Wine 2pk', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/womans-white-polo-w-colored-logo',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/417172-1695754660831.jpg','title' => 'Woman\'s White Polo W/ Colored Logo', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/womens-long-sleeve-bling-shirt',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/416989-1695754282475.jpg','title' => 'Women\'s Long Sleeve Bling Shirt', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/womens-short-sleeve-bling-shirt',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/416990-1695754250445.jpg','title' => 'Women\'s Short Sleeve Bling Shirt', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/zin-delite-3pk',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/426440-1695753762400.jpg','title' => 'Zin-delite 3pk', ],],
        ],
        [
            'loc' => 'https://wilsoncreek.wpengine.com/product/zin-fanlious-6pk',
            'images' => [ ['src' => 'https://images.commerce7.com/wilson-creek-winery/images/original/426439-1695753734759.jpg','title' => 'Zin-fanlious 6pk', ],],
        ],
	];

		return $links;
	}

}
