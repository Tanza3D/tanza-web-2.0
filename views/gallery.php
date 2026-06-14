<?php
if(\Database\Memcache::get("gallery") == null) {
    $url = 'https://anthera.art/api/qgallery';

    $body = json_encode([
        'query' => '@author=1 @order=date-created',
        'offset' => 0,
        'limit' => 500,
    ]);

    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $body,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '', // handles gzip/deflate/zstd decompression automatically,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
        ]
    ]);

    $response = curl_exec($ch);
    $error = curl_error($ch);

    curl_close($ch);
    if ($error) {
        throw new RuntimeException("cURL error: $error");
    }

    \Database\Memcache::set("gallery", $response, 36000);
} else {
    $response = \Database\Memcache::get("gallery");
}
$data = json_decode($response, true);

\Site\Embed::SetTitle("Tanza / Gallery");
\Site\Embed::SetDescription("Here you can find all my best art from over the years!");
?>
<script>
    const posts = <?php echo json_encode($data); ?>;
</script>
<div class="cool-header">
    <div>
        <h1>Gallery</h1>
        <a href="https://anthera.art/@tanza" class="anthera">
            <img src="https://i1.anthera.art/u/1/pfp-tiny.jpg?1775408978">
            View my profile on Anthera!
        </a>
    </div>
    <p>Here you can find all my best art from over the years!</p>
    <p>This page pulls data from my Anthera profile using its API! You can view art I've commissioned on Anthera as well.</p>

</div>

<div class="gallery-outer">
    <div id="gallery-sidebar" class="gallery-sidebar"></div>
    <div id="gallery-grid" class="gallery-grid"></div>
</div>