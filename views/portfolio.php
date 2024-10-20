<?php

use Database\Connection;

$items = Connection::execSimpleSelect("SELECT * FROM Portfolio WHERE Visible = 1");

$extra = \Database\Memcache::get("covers");

if ($extra == null) {
    $extra = file_get_contents("https://untonemusic.com/api/tanzacovers");

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
                <h1>PORTFOLIO</strong></h1>
            </div>
        </div>
        <!--<div class="buttons slant">
            <div class="selected">
                <div class="slant-inner">
                    one<i class="iconoir-hand-brake"></i>
                </div>
            </div>
            <div>
                <div class="slant-inner">
                    two<i class="iconoir-check"></i>
                </div>
            </div>
            <div>
                <div class="slant-inner">
                    three<i class="iconoir-emoji-sing-left-note"></i>
                </div>
            </div>
        </div>
        <div class="buttons-info">
            <div class="left">browsing “Branding” group</div>
            <div class="right">92 items</div>
        </div>-->
    </div>
    <div class="header-right">
        <div class="header-image slant">
            <img class="slant-inner" src="https://tanza.me/img/gallery/original/1696531813_output.png">
        </div>
    </div>
</div>
<div class="full-page-divider"></div>
<div class="page-container">
    <div class="portfolio-grid" id="portfolio-grid">

    </div>
</div>

<div class="portfolio-overlay" id="overlay">
    <div class="portfolio-overlay-cover">
        <img src="https://tanza.me/img/portfolio/1697892078/0.png" id="overlay-image">
        <div class="slant title">
            <h1 class="slant-inner" id="overlay-title">Very cool super long title which wraps to the second line!!!</h1>
            <div class="color-bars"></div>
        </div>
        <a class="slant visit" id="overlay-visit">
            <h1 class="slant-inner" id="visit-text">Visit Page</h1>
        </a>
    </div>
    <div class="portfolio-overlay-content markdown-content" id="overlay-content">
        <h1>good morning</h1>
    </div>
</div>