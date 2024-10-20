<?php
//print_r($vars);
$info = \Database\Connection::execSelect("SELECT * FROM Portfolio WHERE ID = ?", "i", [$vars])[0];
?>
<script>
    const info = <?= json_encode($info) ?>
</script>
<div class="admin_header">
    Edit <strong><?= $info['Name'] ?></strong>
</div>
<div class="edit">
    <div class="image-grid" id="image-grid">

    </div>
    <div class="edit-page">
        <div class="row">
            <div>
                <h3>Title</h3>
                <input type="text" class="input" id="title"/>
            </div>
            <div>
                <h3>Link</h3>
                <input type="text" class="input" id="link"/>
            </div>
        </div>
        <div>
            <h3>Content</h3>
            <textarea rows="12" class="input" id="content"></textarea>
        </div>
        <div class="row">
            <div>
                <h3>Type</h3>
                <input type="text" class="input" id="type"/>
            </div>
            <div>
                <h3>Date</h3>
                <input type="text" class="input" id="date"/>
            </div>
            <div>
                <h3>Visible</h3>
                <input type="number" class="input" id="visible"/>
            </div>
        </div>
        <div class="row">
            <button class="button right" id="submit">Submit</button>
        </div>
    </div>
</div>