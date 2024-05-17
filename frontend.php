<!DOCTYPE html>
<noscript>
    Sorry, Javascript is required to view this page!
</noscript>

<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=Roboto+Flex:opsz,wght@8..144,100..1000&display=swap" rel="stylesheet">

    <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/gh/iconoir-icons/iconoir@main/css/iconoir.css"
    />
    <link rel="stylesheet" href="/frontend/dist/index.css">

    <link id="favicon" rel="icon" href="/favicon.svg">
    <meta name="darkreader-lock">
</head>

<body>
<div class="header">
    HEADER AREA
</div>
<div class="pages">
    <div page="home" class="page page-closed">
        <?= include("views/gallery.php"); ?>
    </div>
    <div page="gallery" class="page page-closed">
        <?= include("views/gallery.php"); ?>
    </div>
    <div page="portfolio" class="page page-closed">
        <?= include("views/portfolio.php"); ?>
    </div>
</div>
</body>


<script rel="preload" src="/frontend/dist/index.bundle.js" type="module"></script>
</html>
