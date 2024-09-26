        <?php
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://betterseo.gorilion.com/output/rankmath_sitemaps/crown-point-vineyards/sitemap_array.php",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));
        echo "attempting to curl...";
        $response = curl_exec($curl); // Server responds with a text array, which is then converted to a PHP array
        $err = curl_error($curl);
        echo $err;
        if (empty($err)) {
            echo $response;
            $product_list = json_decode($response, true);
            if ($product_list) {
                echo "success";
            }
            echo "var dump";
            var_dump($product_list);
        }

        echo "var dump 2";
        $other_test_encoded = json_decode(strip_tags(preg_replace('/\s+/S', " ", $other_test)), true);
        var_dump($other_test_encoded);


        echo $myJSON;
