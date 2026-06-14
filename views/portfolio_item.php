<?php
$item_id = $vars;
$item = \Database\Connection::execSelect("SELECT * FROM Portfolio WHERE ID = ?", "i", [$item_id])[0];
$item['Images'] = json_decode($item['Images'], true);

$content = $item['Content'];
foreach ($item['Images'] as $x => $image) {
    $url = $image;
    if (!str_starts_with($url, 'http')) {
        $url = "/img/portfolio/{$item['ID']}/{$image}";
    }
    $content = str_replace("{IMAGE_{$x}}", $url, $content);
}

$coverUrl = $item['Images'][0];
if (!str_starts_with($coverUrl, 'http')) {
    $coverUrl = "/img/portfolio/{$item['ID']}/medium.png";
}

\Site\Embed::SetTitle($item['Name']);
\Site\Embed::SetBannerImage($coverUrl);


?>
<div class="cool-header">
    <h1>Portfolio / <strong><?= htmlspecialchars($item['Name']) ?></strong></h1>
    <img class="blur-img" src="<?= htmlspecialchars($coverUrl) ?>" alt="<?= htmlspecialchars($item['Name']) ?>">
</div>
<div class="page-container">
    <img class="portfolio-header-img" src="<?= htmlspecialchars($coverUrl) ?>" alt="<?= htmlspecialchars($item['Name']) ?>">
    <div class="portfolio-content markdown-content">
        <?= (new \League\CommonMark\CommonMarkConverter())->convert($content) ?>
    </div>
</div>