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
            'loc' => 'https://www.bricoleurvineyards.com/product/2018-cabernet-sauvignon-magnum',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/cab-mag-1697654929052.png','title' => '2018 Cabernet Sauvignon Magnum', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/2018-pinot-noir-magnum-special-selection',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/015_bricoleur_03132023_paigegreen_crop-1693337147314.jpg','title' => '2018 Pinot Noir  Special Selection Magnum', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/2019-pinot-noir-magnum',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/011_bricoleur_03132023_paigegreen_crop-1681774564991.jpg','title' => '2019 Pinot Noir Magnum', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/2021-pinot-noir',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/pn-with-award-badge-1699926651838.png','title' => '2021 Pinot Noir', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/2021-rockpile-zinfandel',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/007_bricoleur_03132023_paigegreen_crop-1689290318219.png','title' => '2021 Rockpile Zinfandel', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/2021-rockpile-zinfandel-magnum',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/006_bricoleur_03132023_paigegreen_crop-1700500076189.jpg','title' => '2021 Rockpile Zinfandel Magnum', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/2021-the-last-note-late-harvest',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/012_bricoleur_studio_bottles_04132022_paigegreen-1666896197096.jpg','title' => '2021 The Last Note Late Harvest', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/2022-chardonnay',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/chard-with-award-badge-1699905316173.png','title' => '2022 Chardonnay', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/2022-sauvignon-blanc',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/019_bricoleur_studio_bottles_04132022_paigegreen-1689311073948.jpg','title' => '2022 Sauvignon Blanc', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/2022-viognier',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/007_bricoleur_studio_bottles_04132022_paigegreen-1680213317311.jpg','title' => '2022 Viognier', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/4th-annual-bastille-day-celebration',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/img_6814-1704934141623.jpg','title' => '4th Annual Bastille Day Celebration', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/5th-annual-harvest-party',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/382_bricoleur_03312022_paigegreen-1705003926354.jpg','title' => '5th Annual Harvest Party', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/6th-annual-fall-club-dinner',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/c265993e-e397-4bea-ad0f-e3ba7f60ca92-1704934673658.jpg','title' => '6th Annual Fall Club Dinner', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/8-person-rooted-for-vineyard-residence'
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/amber-glass-spray-bottle',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/8abts__77648-1444852890-1638816495449.jpg','title' => 'Amber Glass Spray Bottle', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/black-bronze-cheese-set-3',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/screen-shot-2022-09-26-at-2-53-28-pm-1664229219201.png','title' => 'Arendal Cheese Knife Set Of 3 - Black/bronze', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/bk-at-home-in-the-wine-country',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/9781423654957-us-1665014011782.jpeg','title' => 'At Home In The Wine Country', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/8-person-atelier-bricoleur',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/atelier-1664922236762.png','title' => 'Atelier Bricoleur', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/e-gift-card',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/gift-card-1670457444850.png','title' => 'Bricoleur Vineyards E-gift Card', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/bricoleur-holiday-concert',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/_ch10967-1705005063145.jpg','title' => 'Bricoleur Vineyards Holiday Concert', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/bricoleur-vineyards-holiday-market',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/2023-12-10-bricoleur-b-11-2-1705004497613.jpg','title' => 'Bricoleur Vineyards Holiday Market', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/bricoleur-vineyards-wine-paired-dinner',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/img_4235-1705020044023.jpg','title' => 'Bricoleur Vineyards Wine Paired Dinner', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/cruets-set-2',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/be-home_glass-and-mango-wood-cruet-set-of-2_92-04_10dfb54e-42de-4b72-b50e-67c6713fdd1d_2000x-1664818648073.jpeg','title' => 'Brisbane Cruets, Set Of 2', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/glass-decanter',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/c3db291f-00f8-45fc-b378-8bfceb873dff_1_201_a-1664300875360.jpeg','title' => 'Brisbane Glass Wine Decanter, Medium', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/butter-love-hardwork-bricoleur-exclusive-breakable-chocolate-wine-bottle',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/039_bricoleur_chocolate_09212022_paigegreen-1673043966050.png','title' => 'Butter Love &amp; Hardwork Bricoleur Exclusive Breakable Chocolate Wine Bottle', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/butter-love-hardwork-chocolate-bar-zinfandel-gift-set'
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/cast-iron-tapers',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/cast-iron-tapers-1679347386528.jpg','title' => 'Cast Iron Taper', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/celebrity-guest-chef-chris-ford-cooking-class',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/img_4065-2-1704912996139.jpg','title' => 'Celebrity Guest Chef Chris Ford - Cooking Class', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/celebrity-guest-chef-chris-ford-wine-dinner',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/img_4728-2-1704913037019.jpg','title' => 'Celebrity Guest Chef Chris Ford - Wine Paired Dinner', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/enso-village-and-the-appellation-virtual-cooking-class-wine-bundle',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/img_3241-2-1669062221731.png','title' => 'Enso Village And The Appellation Virtual Cooking Class Wine Bundle', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/estate-extra-virgin-olive-oil',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/img_3590-1683154127158.jpg','title' => 'Estate Extra Virgin Olive Oil', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/estate-made-pasta-sauce',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/screen-shot-2023-06-13-at-3-16-04-pm-1686694588137.png','title' => 'Estate-made Pasta Sauce', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/family-style-with-bricoleur-june-28th',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/img_8195-1704931936442.jpg','title' => 'Family Style With Bricoleur', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/family-style-with-bricoleur-august-23rd',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/img_2571-1704933706134.jpg','title' => 'Family Style With Bricoleur', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/family-style-with-bricoleur-october-25th',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/img_1810-1704934320584.jpg','title' => 'Family Style With Bricoleur', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/two-tone-plush-frosted-sherpa-bricoleur-blanket',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/img_1146-1637196779381.jpg','title' => 'Frosted Sherpa Bricoleur Blanket', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/garden-seeding-class-with-farmer-mikey',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/img_3050-1706292837438.jpg','title' => 'Garden Seeding Class With Farmer Mikey', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/glass-tea-infuser'
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/graf-lantz-square-coasters',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/1616f921-bcf5-460c-9297-19d494f065e4_1_201_a-1666912296777.jpeg','title' => 'Graf Lantz Square Coasters', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/unisex-green-tee'
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/grey-bricoleur-vineyards-hat',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/img_8714-1582681787221.jpg','title' => 'Grey Bricoleur Vineyards Hat', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/guest-chef-neal-fraser-wine-paired-dinner',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/neal-fraser_chef-portrait-1704915008587.jpg','title' => 'Guest Chef Neal Fraser Wine Paired Dinner', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/hawaiian-imu-dinner-with-kainoa-horcajo',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/kainoa-2-1704918149378.jpg','title' => 'Hawaiian Imu Dinner With Kainoa Horcajo', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/healdsburg-wine-food-experience',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/screen-shot-2022-05-09-at-10-43-00-am-1652118281336-1705005837290.jpg','title' => 'Healdsburg Wine &amp; Food Experience', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/olive-herringbone-recycled-wool-picnic-blanket-with-strap'
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/himalayan-bark-candle',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/04c642ec-2a6d-4ad6-ada0-24fad80010ce_1_201_a-1667170068244.jpeg','title' => 'Himalayan Bark Candle', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/hog-island-oyster-lover-s-cookbook',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/3ef3802b-b97c-47f9-bac6-35b38aada609_1_201_a-1665446680510.jpeg','title' => 'Hog Island Oyster Lover\'s Cookbook', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/isla-rose-brut-rose',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/isla-with-badge-1696211953902.png','title' => 'Isla Rose Brut Rosé', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/local-love',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/img_0897-1588359605512.jpg','title' => 'Local Love', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/neroli-blossom-reed-diffuser',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/neroli-diffuser-1654895704262.png','title' => 'Makana: Neroli Blossom Reed Diffuser', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/mini-olive-board',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/f9776750-d64e-45a8-a0a1-51f6f1a938b4_1_201_a-1665446305447.jpeg','title' => 'Mini Olive Board', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/mothers-day-sale-6-bottles-of-2019-rose-of-pinot-noir',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/img_6726-1611976230286.jpg','title' => 'Mother\'s Day Sale: 6 Bottles Of 2019 Rosé Of Pinot Noir', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/navy-navy-hat',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/img_8713-1582682056023.jpg','title' => 'Navy Bricoleur Vineyards Hat', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/niko-coupe',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/niko-coupe-1694652931065.jpg','title' => 'Niko Coupe', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/-flying-by-the-seat-of-our-pants-brut',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/011_bricoleur_studio_bottles_04132022_paigegreen-1652141289252.jpg','title' => 'North Coast Brut', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/north-coast-brut-magnum',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/008_bricoleur_03132023_paigegreen_crop-1681774181407.jpg','title' => 'North Coast Brut Magnum', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/nye-bubbly-case-sale',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/2w6a0757-1703033290234.jpg','title' => 'Nye Bubbly Case Sale', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/nye-bubbly-half-case-sale',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/2w6a0765-1703032973500.jpg','title' => 'Nye Bubbly Half Case Sale', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/olive-oil-collection',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/img_0711-1637283092905.jpg','title' => 'Olive Oil Collection', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/olive-oil-infusion-kit',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/bricoleur_09192023_paigegreen_u6a6505-1697573172941.jpg','title' => 'Olive Oil Infusion Kit', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/olive-spreaders-set-4',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/be-home_olive-wood-spreaders-set-of-4_50-01_2000x-1669760235912.jpg','title' => 'Olive Wood Spreaders, Set Of 4', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/pinot-lovers-package',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/pinot-1586794624911.jpg','title' => 'Pinot Lovers Collection (shipping Included)', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/bedside-carafe-and-tumbler-set',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/screen-shot-2022-09-26-at-3-03-46-pm-1664229839530.png','title' => 'Premium Recycled Glass Bedside Carafe &amp; Tumbler Set', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/ready-to-gift-chardonnay-case',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/ready-to-gift-1664315061754.jpg','title' => 'Ready To Gift - Chardonnay Case', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/ready-to-gift-mixed-case',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/ready-to-gift-1664315061754.jpg','title' => 'Ready To Gift - Mixed Case', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/ready-to-gift-north-coast-brut',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/ready-to-gift-1664315061754.jpg','title' => 'Ready To Gift - North Coast Brut Case', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/ready-to-gift-pinot-noir-case',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/ready-to-gift-1664315061754.jpg','title' => 'Ready To Gift - Pinot Noir Case', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/red-wine-lovers-package',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/redwineloverscollection-1586794656743.jpg','title' => 'Red Wine Lovers Collection (shipping Included)', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/residence-dog-stay',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/photo-sep-27-8-34-53-am-1645219718220.jpg','title' => 'Residence Dog Stay', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/riddle-oil-x-bricoleur',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/img_0716-1637102407991.jpg','title' => 'Riddle Oil X Bricoleur', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/seasonings-salts-and-spices-kit',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/img_0703-1636615599712.jpg','title' => 'Seasonings &amp; Salts Collection', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/cloche-matches',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/smoke-match-cloche-desk-1694653909558.jpg','title' => 'Skeem Cloche Matches', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/sweet-tobacco-wooden-candle-20-inch',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/large-1657648937174.jpeg','title' => 'Sweet Tobacco Wooden Candle - 20 Inch', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/tot-tax-for-vineyard-residence-only'
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/under-21-ticket'
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/wine-bottle-opener',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/img_9142-1580857630754.jpg','title' => 'Wine Bottle Opener', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/wine-river-cruise-on-the-seine',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/amawaterways-amalyra-rouen-seine-e1550143580386-1687x995-4-1699404931255.jpg','title' => 'Wine River Cruise On The Seine', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/winter-club-pick-up-party',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/_ch10226-1704913152331.jpg','title' => 'Winter Club Pick Up Party', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/wood-olive-boat',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/91b58ace-af85-4b1a-b77e-7244e0f0f9d1-1665444333335.png','title' => 'Wood Olive Boat', ],],
        ],
        [
            'loc' => 'https://www.bricoleurvineyards.com/product/weekly-yoga-at-bricoleur-vineyards',
            'images' => [ ['src' => 'https://images.commerce7.com/bricoleur-vineyards-llc/images/original/018-1617220746500.jpg','title' => 'Yoga At Bricoleur Vineyards', ],],
        ],
	];

		return $links;
	}

}
