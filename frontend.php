<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="/frontend/dist/index.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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


<script rel="preload" src="/frontend/dist/index.bundle.js" type="module"></script>
</html>
