<?php
echo '<script type="text/javascript" src="https://dev-center.platform.commerce7.com/v2/commerce7.js"></script>';
// $post = json_decode(file_get_contents('php://input'), true);
parse_str($_SERVER['QUERY_STRING'], $get_array);
$tenant = $get_array['tenantId'];
$tenant = is_null($tenant) ? $_POST['tenantId'] : $tenant;
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false) {
    // echo json_encode($get_array);
    // echo json_encode($_POST);
    // echo json_encode($_GET);
    if (is_null($tenant)) {
        echo 'tenantId not set';
        header('Location: index.php');
        exit;
    }
    $c7_view = true;
}
// Check if the logout button is clicked
if (isset($_POST['logout'])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect the user to the login page or any other desired page
    header('Location: index.php');
    exit;
}
$servername = "localhost";
$dbUsername = "u996275341_productfeed";
$dbPassword = "$[i3yKh;8";
$dbname = "u996275341_productfeed";
$username = $_SESSION['username'] ? $_SESSION['username'] : $tenant;

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_POST['product_page_name'])) {
    $productPageName = $_POST['product_page_name'];
    $seo_plugin = $_POST['seo_plugin'];
    $sql = "UPDATE users SET product_page_name = '$productPageName', seo_plugin = '$seo_plugin' WHERE username = '$username'";
    $result = $conn->query($sql);
    if ($conn->affected_rows > 0) {
        echo "<div class='alert'>update successful! Please re-generate your feeds</div>";
    } else {
    }
}

$the_query = "SELECT username, passkey, api, brand, link, product_page_name, platform, collection, tenant, seo_plugin  FROM users WHERE UserName = '" . $username . "'";
if (isset($c7_view) && $c7_view == true) {
    $the_query = "SELECT username, passkey, api, brand, link, product_page_name, platform, collection, tenant, seo_plugin  FROM users WHERE tenant = '" . $tenant . "'";
    $username = $tenant;
}
// echo $the_query;
$result = $conn->query($the_query);
$client_result = $result->fetch_assoc();
// echo json_encode($client_result);

// echo 'Hello, ' . $_SESSION['username'];
$google_feed_path = 'https://productfeed.gorilion.com/output/feeds/' . $username . '_productfeed.xml';
$facebook_feed_path = 'https://productfeed.gorilion.com/output/feeds/' . $username . '_facebook_productfeed.xml';
$vivino_feed_path = 'https://productfeed.gorilion.com/output/feeds/' . $username . '_vivino_productfeed.xml';
$google_sitemap_path = 'https://' . $_SERVER['HTTP_HOST'] . '/output/sitemaps/' . $username . '_product_sitemap.xml';
$function_path = 'https://' . $_SERVER['HTTP_HOST'] . '/output/functionsphp/' . $username . '_functions.php';
$rankmath_sitemap_path = 'output/rankmath_sitemaps/' . $username . '/custom_sitemap_provider.php';


?>

<html>

<head>
    <title>Better SEO</title>
    <link rel="stylesheet" href="https://use.typekit.net/aay6fmr.css">
    <style>
        :root {
            font-family: "proxima-nova", sans-serif;
            ;
            --primary-color: #445d72;
            --alt-color: #829cb4;
            --light-blue: #eef3f7;
            --grey: #e6e6e6;
            --medium-grey: #ccc;
            --dark-grey: #445d72;
            font-size: 18px;
        }

        .hide {
            display: none !important;
        }

        .alert {
            background-color: #99EE99;
            padding: 32px;
            text-align: center;
            width: 100%;
            margin: 0;
        }

        html {
            font-size: 18px;
        }

        body {
            line-height: 1.6;
            max-width: 800px;
            margin: auto;
            <?php echo ($c7_view != true) ? <<<OUT
            background: url('assets/bkgd-gorilla-2x-10pct.jpg');
            background-repeat: no-repeat;
            background-size: contain;
            background-position: right;
            OUT : ""; ?>
        }

        main {
            <?php echo ($c7_view == true) ? <<<OUT
            background: url('assets/bkgd-gorilla-2x-10pct.jpg');
            background-repeat: no-repeat;
            background-size: contain;
            background-position: right;
            OUT : ""; ?>
        }

        main {

            <?php echo ($c7_view == true) ? "" : "margin: 40px 20px;"; ?><?php echo ($c7_view == true) ? "height:700px;" : ""; ?><?php echo ($c7_view == true) ? "overflow:hidden;" : ""; ?><?php echo ($c7_view == true) ? "overflow-y:scroll;" : ""; ?><?php echo ($c7_view == true) ? "background-color:#FFF;" : ""; ?><?php echo ($c7_view == true) ? "padding: 18px;" : ""; ?>
        }

        header {
            display: flex;
            justify-content: space-between;
            padding: 32px;
            flex-wrap: wrap;
            <?php echo ($c7_view == true) ? "background-color:#FFF;" : ""; ?>
        }

        .divider {
            border-bottom: 1px solid var(--grey);
            width: 100%;
            flex-basis: 1;
            flex-shrink: 0;
        }

        select,
        .button,
        input[type=submit] {
            border-radius: 100px;
            padding: 12px 24px;
            font-size: 21px;
            font-weight: bold;
            line-height: 26px;
            transition: all 0.3s ease-in-out;
            background-color: transparent;
            border: solid 1px var(--medium-grey);
        }

        input.update {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: var(--light-blue);
        }

        select,
        input[type=text] {
            font-size: 18px;
            line-height: 26px;
            border: 2px solid var(--dark-grey);
            border-radius: 6px;
            font-weight: 400;
            padding: 8px 16px;
        }

        input.feed-link {
            border: none;
            outline: none;
            padding: 0;
            width: 100%;
            background-color: transparent;
        }

        input.feed-link:focus-visible {}

        label {
            color: var(--primary-color);
            font-weight: bold;
            font-size: 21px;
            line-height: 26px;
            margin-bottom: 6px;
        }

        select {
            appearance: none;
            padding-right: 30px;
        }

        .select-wrapper {
            position: relative;
            display: inline-block;
        }

        .select-wrapper::after {
            content: url('assets/chevron-down.svg');
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .logout-wrapper input {
            <?php echo ($c7_view == true) ? "display:none;" : ""; ?>
        }

        .button:hover,
        input[type=submit]:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: var(--light-blue);
            box-shadow: 4px 4px 4px var(--dark-grey);
        }

        .hello {
            font-size: 42px;
            line-height: 52px;
            font-weight: 300;
        }

        .greeting {
            font-weight: 400;
            color: var(--primary-color);
        }

        .greeting .brand {
            font-weight: bold;
        }

        .two-column {
            display: flex;
        }

        .two-column>* {
            flex-basis: 50%;
            flex-shrink: 1;
            flex-grow: 0;
        }

        .product-page-name-wrapper,
        .seo-plugin-wrapper {
            display: flex;
            flex-direction: column;
        }

        .product-page-name-wrapper>*,
        .seo-plugin-wrapper>* {
            flex-grow: 0;
            width: max-content;
        }

        .margin-top-2 {
            margin-top: 2rem;
        }

        h2,
        h3,
        h4 {
            color: var(--primary-color);
        }

        .generator-wrapper {
            margin-bottom: 4rem;
        }

        .link-wrapper {
            border: 2px solid var(--grey);
            border-radius: 8px;
            display: flex;
            justify-content: start;
            align-items: center;
            overflow-x: hidden;
            white-space: nowrap;
            margin-bottom: 12px;
        }

        .link-copy::before {
            content: url('assets/icon-copy-paste.svg');
            background-color: var(--light-blue);
            margin-right: 16px;
            display: inline-block;
            cursor: pointer;
        }

        .link-download::before {
            content: url('assets/icon-download.svg');
            background-color: var(--grey);
            margin-left: -16px;
            margin-right: 16px;
            display: inline-block;
            cursor: pointer;
        }

        .function-php-code {
            margin-bottom: 32px;
        }

        .function-php-code pre {
            height: 3rem;
            overflow: hidden;
            overflow-y: scroll;
            margin: 0;
        }

        .function-php-code .pre-wrapper {
            display: flex;
            border: 2px solid var(--grey);
            border-radius: 8px;
            align-items: stretch;
        }

        .spacer {
            width: 100%;
            height: 3rem;
        }

        .generator-wrapper form {
            display: flex;
            justify-content: flex-start;
            gap: 10px;
            align-items: flex-end;
        }

        .generator-wrapper form>* {
            flex-grow: 0;
            height: max-content
        }

        textarea {
            width: 100%;
            border: none;
            outline: none;
            resize: none;
            background-color: transparent !important;
            background: none !important;
            user-select: all;
        }
    </style>
</head>

<body>
    <header>
        <div class="logo-wrapper"><img src='assets/logo.svg'></div>
        <div class="logout-wrapper">
            <form method="POST" action="">
                <input class="button" type="submit" name="logout" value="Logout">
            </form>
        </div>
        <div class='divider'></div>
    </header>
    <main>
        <h2 class="greeting">
            <span class="hello">Hello <?php echo $client_result['brand']; ?>,</span><br>Welcome to your <span class='brand'>Better SEO</span> by Gorilion
            Dashboard.

        </h2>
        <div class="intro">
            Below is information you need for your product feeds, product sitemap, and code for integrating Open Graph Social, Better
            Meta Data, Product Schema and more.
            If you need any help with this implementation please reach out to <a href='mailto:sean@gorilion.com'>sean@gorilion.com</a> and we can implement it for you for a small fee.
            The data should be generated automatically, but if you need to change your page name or seo plugin, you will need to click re-generate.
        </div>
        <div class='spacer'></div>
        <div class='divider'></div>
        <div class='spacer'></div>
        <div class="generator-wrapper">
            <!-- <div>Platform:<?php echo $client_result['platform']; ?></div> -->
            <form action="dashboard.php" method="post">
                <div class="product-page-name-wrapper">
                    <label for="product_page_name">WP Product Page Slug</label>
                    <input type="text" id="product_page_name" name="product_page_name" value="<?php echo $client_result['product_page_name'] ?>">
                </div>
                <div class="seo-plugin-wrapper">
                    <label for='seo_plugin'>SEO Plugin</label>
                    <div class="select-wrapper">
                        <select id="seo_plugin" name="seo_plugin">
                            <option value="yoast" <?php echo ($client_result['seo_plugin'] == 'yoast') ? 'selected' : '' ?>>Yoast
                            </option>
                            <option value="rankmath" <?php echo ($client_result['seo_plugin'] == 'rankmath') ? 'selected' : '' ?>>
                                RankMath</option>
                        </select>
                    </div>
                </div>

                <input type='text' id='tenantId' name='tenantId' value="<?php echo $tenant ?>" style='display:none'>
                <input class='update' type="submit" value="Regenerate">
            </form>
            <a class="button hide" id="generate">Generate</a>
            <script>
                function generate() {
                    var data = {
                        'passkey': '<?php echo $client_result['passkey']; ?>',
                        'userID': '<?php echo $username; ?>'
                    }
                    fetch('generate.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: Object.keys(data)
                                .map(key => encodeURIComponent(key) + '=' + encodeURIComponent(data[key]))
                                .join('&')
                        })
                        .then(response => response.text())
                        .then(result => {
                            console.log("Results: ");
                            console.log(result);
                            document.getElementsByClassName("function-php-code")[0].getElementsByTagName("textarea")[0].value = result;
                            // Handle the response from the server
                        })
                        .catch(error => {
                            console.error('Error occurred:', error);
                        });
                };

                function get_code() {
                    fetch('<?php echo $function_path ?>', {
                            method: 'GET'
                        })
                        .then(response => response.text())
                        .then(result => {
                            // console.log(result);
                            document.getElementsByClassName("function-php-code")[0].getElementsByTagName("textarea")[0].value = result;
                            // Handle the response from the server
                        })
                        .catch(error => {
                            console.error('Error occurred:', error);
                        });

                };
                document.getElementById("generate").addEventListener('click', generate);
                window.onload = generate;
            </script>
        </div>
        <div class='divider'></div>
        <div class="sitemaps">
            <h3>Google Sitemap</h3>
            <div> Here is a link to your product sitemap to send to Google. <a href="https://developers.google.com/search/docs/crawling-indexing/sitemaps/build-sitemap#addsitemap" target="_blank">How to submit</a>.</div>
            <div class='link-wrapper sitemap-link'><a class="link-copy"></a><a class="link-download" download href="<?php echo $google_sitemap_path; ?>"></a><input class='feed-link download-link' onClick="this.select();" type='text' value="<?php echo $google_sitemap_path; ?>" /></div>
        </div>
        <div class="product-feeds">
            <h2>Product Feeds</h2>
            <h3>Google</h3>
            <div><a href="https://support.google.com/merchants/answer/7439058?hl=en" target="_blank">How to submit.</a>.</div>
            <div class='link-wrapper'><a class="link-copy"></a><input class='feed-link' onClick="this.select();" type='text' value="<?php echo $google_feed_path; ?>" /></div>
            <h3>Facebook</h3>
            <div><a href="https://www.facebook.com/business/help/125074381480892?id=725943027795860" target="_blank">How to submit.</a>.</div>
            <div class='link-wrapper'><a class="link-copy"></a><input class='feed-link' onClick="this.select();" type='text' value="<?php echo $facebook_feed_path; ?>" /></div>
            <h3>Vivino</h3>
            <div><a href="https://help.vivino.com/s/article/How-do-I-create-my-product-feed-XML?language=en_US" target="_blank">More info.</a>.</div>
            <div class='link-wrapper'><a class="link-copy"></a><input class='feed-link' onClick="this.select();" type='text' value="<?php echo $vivino_feed_path; ?>" /></div>
        </div>
        <div class="function-php-code">
            <h3>The Headless SEO Magic</h3>
            <div>Copy and paste these files into your theme folder's root directory</div>
            <h3>RankMath Custom Sitemap</h3>
            <div class='link-wrapper'><a class="link-copy"></a><a class="link-download" download href="/download.php?file=<?php echo $rankmath_sitemap_path; ?>"></a><input class='feed-link' onClick="this.select();" type='text' value="https://<?php echo $_SERVER['HTTP_HOST'] . '/download.php?file=' . $rankmath_sitemap_path; ?>" /></div>
            <div>Copy and paste this code and insert it into the bottom of your WordPress function.php. Note, server requires $_SERVER['REDIRECT_URL']. Most WP servers have it, and you can request your host to enable it if not enabled. Contact us for more help.</div>
            <div class="pre-wrapper">
                <a class="link-copy"></a>
                <textarea readonly class="feed-link" onClick="this.select();">

                </textarea>

            </div>
        </div>
        <script>
            function copy_to_clipboard(e) {
                let the_text = e.target.parentElement.getElementsByClassName("feed-link")[0].value;
                if (the_text == "" || the_text == null || the_text == undefined) {
                    the_text = e.target.parentElement.getElementsByClassName("feed-link")[0].innerText;
                }
                navigator.clipboard.writeText(the_text);
            }
            document.addEventListener("DOMContentLoaded", function() {
                const linkWrappers = document.getElementsByClassName("link-copy");

                for (const linkWrapper of linkWrappers) {
                    linkWrapper.addEventListener('click', copy_to_clipboard);
                }
            });
        </script>
        <?php if (!isset($tenant)) : ?>
        <?php endif; ?>
    </main>
</body>

</html>