<?php
function url_get_contents ($Url) {
    if (!function_exists('curl_init')){ 
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

$extra = \Database\Memcache::get("covers");

if ($extra == null) {
$arrContextOptions=array(
      "ssl"=>array(
            "verify_peer"=>false,
            "verify_peer_name"=>false,
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
<div class="header header-small">
    <div class="header-left">
        <div class="header-left-bg slant">
            <div class="color-bars">
            </div>
            <div class="slant-inner">
                <svg width="124" height="53" viewBox="0 0 124 53" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0H14.8V15.1429H0V0Z" fill="#FA31D9"/>
                    <path d="M22.2 0H37V53H22.2V0Z" fill="#FA31D9"/>
                    <path d="M88 37.8571H102.4V53H88V37.8571Z" fill="#67ADFF"/>
                    <path d="M88 0L124 34.0714V53L88 18.9286V0Z" fill="#67ADFF"/>
                    <path d="M44 0L70.9971 9.77559e-06L54.5527 15.1428L44 15.1428V0Z" fill="#5A1FFF"/>
                    <path d="M81 37.8572H60.4444L81 18.9286V3.89742e-05L44 34.0714V53H81V37.8572Z" fill="#5A1FFF"/>
                </svg>
                <h1>PORTFOLIO</h1>
                <p>On this page, you can find all the design work I've done, including company branding, website design, product design, and more! Website design will also include information on the development process!</p>
            </div>
        </div>
        <div class="buttons slant">
            <fieldset id="fieldset" style="display: none">
                <!-- i'll do it later-->
                <div>
                    <input type="radio" id="grid" name="view" value="grid" checked />
                    <label for="grid" class="slant-inner">Grid</label>
                </div>

                <div>
                    <input type="radio" id="list-simple" name="view" value="list-simple" />
                    <label for="list-simple" class="slant-inner">Mobile List</label>
                </div>

                <div>
                    <input type="radio" id="list-advanced" name="view" value="list-advanced" />
                    <label for="list-advanced" class="slant-inner">Advanced List</label>
                </div>
            </fieldset>

        </div>
    </div>
    <div class="header-right">
        <div class="header-image slant">
            <img class="slant-inner" src="/img/portfolio/1709491280/medium.png">
        </div>
    </div>
</div>
<div class="full-page-divider"></div>
<div class="page-container">
    <div class="portfolio-grid hide" id="portfolio-grid">

    </div>
</div>

<div class="portfolio-overlay" id="overlay">
    <div class="portfolio-overlay-cover">
        <img src="https://tanza.me/img/portfolio/1697892078/0.png" id="overlay-image">
        <div class="slant title">
            <h1 class="slant-inner" id="overlay-title">Very cool super long title which wraps to the second line!!!</h1>
            <div class="color-bars"></div>
        </div>

        <a class="slant visit" id="overlay-visit" target="_blank">
            <h1 class="slant-inner" id="visit-text">Visit Page</h1>
        </a>
    </div>

    <div class="portfolio-overlay-content markdown-content" id="overlay-content">
        <h1>good morning</h1>
    </div>
</div>
