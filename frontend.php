<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="/frontend/dist/index.css?2">
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=Roboto+Flex:opsz,wght@8..144,100..1000&display=swap"
          rel="stylesheet">

    <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/gh/iconoir-icons/iconoir@main/css/iconoir.css"
    />

    <link id="favicon" rel="icon" href="/favicon.svg">
    <meta name="darkreader-lock">
    <title>Tanza</title>


    <link rel="stylesheet" href="/frontend/dist/<?= $pagename ?>.css?2">

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
    <meta property="og:site_name" content="Osekai"/>


    <meta name="description" content="<?= Site\Embed::$title ?>">
    <meta name="keywords" content="<?= Site\Embed::$tags ?>">
    <meta name="description" content="<?= Site\Embed::$description ?>">


    <meta name="twitter:site" content="Osekai">
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
<div class="header-links">
    <a href="/portfolio">PORTFOLIO</a>
    <a href="/gallery">GALLERY</a>
    <a href="/">HOME</a>
</div>
<div class="pages">
    <div class="page">
        <?= $page ?>
    </div>
</div>
</body>

<script src="/frontend/dist/<?= $pagename ?>.bundle.js" type="module"></script>

<script rel="preload" src="/frontend/dist/index.bundle.js" type="module"></script>
</html>
