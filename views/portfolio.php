<?php
if(isset($_GET['item'])) {
    General::Redirect("/portfolio/" . $_GET['item']);
    exit;
}
function url_get_contents($Url)
{
    if (!function_exists('curl_init')) {
        die('CURL is not installed!');
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

use Database\Connection;

$items = Connection::execSimpleSelect("SELECT * FROM Portfolio WHERE Visible = 1");
if (1 == 0) {
    $collections = Connection::execSimpleSelect("
    SELECT PortfolioCollections.*, 
           JSON_ARRAYAGG(
               JSON_OBJECT(
                    'ID', Portfolio.ID,
                    'Name', Portfolio.Name,
                    'Images', Portfolio.Images,
               'Ratio', Portfolio.Ratio
               )
           ) AS Items
    FROM PortfolioCollections 
    LEFT JOIN PortfolioCollectionItems ON PortfolioCollectionItems.Collection = PortfolioCollections.ID 
    LEFT JOIN Portfolio ON PortfolioCollectionItems.Item = Portfolio.ID
    WHERE PortfolioCollections.Visible = 1
    GROUP BY PortfolioCollections.ID
");

    foreach ($collections as &$collection) {
        $collection['Items'] = json_decode($collection['Items'], true);
        $collection['Images'] = [];

        foreach ($collection['Items'] as $item) {
            $collection['Images'][] = "/img/portfolio/" . $item['ID'] . "/medium.png";
            foreach ($item['Images'] as $image) {
                if ($image == "0.png") continue;
                $collection['Images'][] = "/img/portfolio/" . $item['ID'] . "/" . $image;
            }
        }
    }
}


$extra = \Database\Memcache::get("covers");

if ($extra == null) {
    $arrContextOptions = array(
            "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
            ),
    );

    $extra = url_get_contents("https://untonemusic.com/api/tanzacovers", false, stream_context_create($arrContextOptions));

    // "Any time the constant 86400 appears in your code, there is a good chance you're doing something that's not quite right."
    // sincerely go fuck yourself
    \Database\Memcache::set("covers", $extra, 86400);
}

$extra = json_decode($extra, true);
foreach ($extra as $e) $items[] = $e;


usort($items, function ($a, $b) {
    return strtotime($b['Date']) - strtotime($a['Date']);
});

//foreach($items as $item) $item['Images'] = json_decode($item['Images'], true);
for ($x = 0; $x < count($items); $x++) $items[$x]['Images'] = json_decode($items[$x]['Images'], true);


\Site\Embed::SetDescription("Here, you can find all the design work I've done, including company branding, website design, product design, and more!");
\Site\Embed::SetTitle("Tanza's Portfolio");
\Site\Embed::SetBannerImage("/public/img/workbanner.png");


?>
<script>
    const PortfolioItems = <?= json_encode($items) ?>;
</script>


<div class="cool-header">
    <h1>Portfolio</h1>
    <p>On this page, you can find all the design work I've done, including company branding, website design, product
        design,
        and more! Website design will also include information on the development process!</p>
</div>

<div class="page-container">
    <div class="portfolio-grid hide" id="portfolio-grid">

    </div>
</div>

