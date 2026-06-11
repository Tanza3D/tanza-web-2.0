<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="/frontend/dist/index.css?7">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/iconoir-icons/iconoir@main/css/iconoir.css" />
    <link id="favicon" rel="icon" href="/favicon.svg">
    <meta name="darkreader-lock">
    <title>Tanza</title>


    <link rel="stylesheet" href="/frontend/dist/<?= $pagename ?>.css?7">

    <?php
    \Site\Embed::AddTags(Site\Embed::$title);
    ?>


    <meta property="og:title" content="<?= Site\Embed::$title ?>"/>
    <meta property="og:description" content="<?= Site\Embed::$description ?>"/>

    <?php
    if (\Site\Embed::$article['published_time'] != "") {
        ?>
        <meta name="author" content="<?= Site\Embed::$article["author"] ?>">
        <meta property="og:type" content="article">
        <meta property="og:article:published_time" content="<?= Site\Embed::$article["published_time"] ?>"/>
        <meta property="og:article:author" content="<?= Site\Embed::$article["author"] ?>"/>
        <meta property="og:article:section" content="<?= Site\Embed::$article["section"] ?>"/>
        <meta property="og:article:tag" content="<?= Site\Embed::$article["tags"] ?>"/>
        <meta property="og:author:username" content="<?= Site\Embed::$article["author"] ?>"/>
        <?php
    }
    ?>

    <title><?= Site\Embed::$title ?></title>

    <meta property="og:tags" content="<?= Site\Embed::$article["tags"] ?>"/>
    <meta property="og:locale" content="en_GB"/>
    <meta property="og:site_name" content="tanza.me"/>


    <meta name="description" content="<?= Site\Embed::$title ?>">
    <meta name="keywords" content="<?= Site\Embed::$tags ?>">
    <meta name="description" content="<?= Site\Embed::$description ?>">


    <meta name="twitter:site" content="tanza.me">
    <meta name="twitter:title" content="<?= Site\Embed::$title ?>">
    <meta name="twitter:description" content="<?= Site\Embed::$description ?>">
    <?php
    if (\Site\Embed::$large_image) {
        ?>
        <meta name="twitter:card" content="summary_large_image">
        <?php
    } else {
        ?>
        <meta name="twitter:card" content="summary">
        <?php
    }
    if (\Site\Embed::$image != null) {
        if (\Site\Embed::$image_width != null) {
            ?>
            <meta property="og:image:width" content="<?= \Site\Embed::$image_width ?>"/>
            <meta property="og:image:height" content="<?= \Site\Embed::$image_height ?>"/>
            <?php
        }
        ?>
        <meta property="og:image" content="<?= Site\Embed::$image ?>"/>
        <meta property="og:image:alt" content="<?= Site\Embed::$image_alt ?>"/>
        <meta name="twitter:image:src"
              content="<?= Site\Embed::$image_banner == null ? Site\Embed::$image : Site\Embed::$image_banner ?>">
        <?php
    }
    ?>

    <meta property="og:type" content="object"/>
</head>

<body>
<?php
function navLink(string $href, string $label): string
{
    $active = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === $href;
    return '<a href="' . $href . '"' . ($active ? ' class="active"' : '') . '>' . $label . '</a>';
}

?>

<div class="header-links desktop">
    <div>
        <?= navLink('/', 'Home') ?>
        <?= navLink('/about', 'About Me') ?>
    </div>

    <svg width="138" height="56" viewBox="0 0 138 56" fill="none" xmlns="http://www.w3.org/2000/svg" class="logo-anim">
        <path d="M0 0H15.8294V16H0V0Z" fill="#FA31D9" class="t"/>
        <path d="M23.7441 0H39.5735V56H23.7441V0Z" fill="#FA31D9" class="t"/>
        <path d="M98.4265 40H114.256V56H98.4265V40Z" fill="#67ADFF" class="a"/>
        <path d="M98.4265 0L138 36V56L98.4265 20V0Z" fill="#67ADFF" class="a"/>
        <path d="M48.7059 0L77.5808 1.03289e-05L59.9925 16L48.7059 16V0Z" fill="#5A1FFF" class="z"/>
        <path d="M88.2794 40H66.2941L88.2794 20V4.11803e-05L48.7059 36V56H88.2794V40Z" fill="#5A1FFF" class="z"/>
    </svg>


    <div>
        <?= navLink('/portfolio', 'Portfolio') ?>
        <?= navLink('/gallery', 'Artwork') ?>
    </div>
</div>
<div class="header-links-mobile mobile">
    <svg width="138" height="56" viewBox="0 0 138 56" fill="none" xmlns="http://www.w3.org/2000/svg" class="logo-anim">
        <path d="M0 0H15.8294V16H0V0Z" fill="#FA31D9" class="t"/>
        <path d="M23.7441 0H39.5735V56H23.7441V0Z" fill="#FA31D9" class="t"/>
        <path d="M98.4265 40H114.256V56H98.4265V40Z" fill="#67ADFF" class="a"/>
        <path d="M98.4265 0L138 36V56L98.4265 20V0Z" fill="#67ADFF" class="a"/>
        <path d="M48.7059 0L77.5808 1.03289e-05L59.9925 16L48.7059 16V0Z" fill="#5A1FFF" class="z"/>
        <path d="M88.2794 40H66.2941L88.2794 20V4.11803e-05L48.7059 36V56H88.2794V40Z" fill="#5A1FFF" class="z"/>
    </svg>
    <div>
        <?= navLink('/', 'Home') ?>
        <?= navLink('/about', 'About Me') ?>
        <?= navLink('/portfolio', 'Portfolio') ?>
        <?= navLink('/gallery', 'Artwork') ?>
    </div>
</div>
<div class="page">
    <?= $page ?>
</div>

<div class="loader">

</div>
</body>

<script src="/frontend/dist/<?= $pagename ?>.bundle.js?7" type="module"></script>

<script rel="preload" src="/frontend/dist/index.bundle.js?7" type="module"></script>
</html>
