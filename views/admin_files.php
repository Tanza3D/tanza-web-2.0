<?php
$baseDir = __DIR__ . '/../int/auto-up';
$webPath = '/int/auto-up';

// Handle deletion via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_folder'])) {
    header('Content-Type: application/json');
    
    $folderName = basename($_POST['delete_folder']);
    $folderPath = $baseDir . '/' . $folderName;
    
    if (!is_dir($folderPath) || strpos(realpath($folderPath), realpath($baseDir)) !== 0) {
        echo json_encode(['success' => false, 'error' => 'Invalid folder']);
        exit;
    }
    
    $files = glob($folderPath . '/*');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
    
    if (rmdir($folderPath)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to delete folder']);
    }
    exit;
}

function getFileType($filename) {
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    
    $images = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp'];
    $audio = ['mp3', 'wav', 'ogg', 'flac', 'm4a', 'aac'];
    $video = ['mp4', 'webm', 'ogv', 'mov'];
    
    if (in_array($ext, $images)) return 'image';
    if (in_array($ext, $audio)) return 'audio';
    if (in_array($ext, $video)) return 'video';
    return 'other';
}

function formatFileSize($bytes) {
    if ($bytes >= 1073741824) return round($bytes / 1073741824, 2) . ' GB';
    if ($bytes >= 1048576) return round($bytes / 1048576, 2) . ' MB';
    if ($bytes >= 1024) return round($bytes / 1024, 2) . ' KB';
    return $bytes . ' B';
}
?>

<style>
    .au-file-item { background: rgba(255,255,255,0.05); padding: 1rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); margin-bottom: 0.75rem; }
    .au-file-header { display: flex; justify-content: space-between; align-items: center; gap: 1rem; }
    .au-file-info { display: flex; flex-direction: column; gap: 0.25rem; min-width: 0; flex: 1; }
    .au-file-meta { display: flex; align-items: center; gap: 0.5rem; }
    .au-folder-name { font-size: 0.8rem; opacity: 0.5; font-family: monospace; }
    .au-file-name { font-family: monospace; color: #e94560; font-size: 30px !important; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .au-pill { background: #e94560; color: #fff; padding: 0.2rem 0.6rem; border-radius: 999px; font-size: 0.75rem; font-family: monospace; white-space: nowrap; }
    .au-date { opacity: 0.5; font-size: 0.8rem; white-space: nowrap; }
    .au-delete-btn { background: #e94560; color: #fff; border: none; padding: 0.5rem 1rem; border-radius: 4px; cursor: pointer; flex-shrink: 0; }
    .au-delete-btn:hover { background: #ff6b6b; }
    .au-delete-btn:disabled { background: #555; cursor: not-allowed; }
    .au-preview { margin-top: 0.75rem; }
    .au-preview img { max-width: 100%; max-height: 300px; border-radius: 4px; }
    .au-preview audio { width: 100%; }
    .au-preview video { max-width: 100%; max-height: 300px; border-radius: 4px; }
    .au-empty { opacity: 0.5; font-style: italic; }
    .au-count { opacity: 0.6; }
    .au-load-btn { background: rgba(255,255,255,0.1); border: 1px dashed rgba(255,255,255,0.3); color: #fff; padding: 2rem; border-radius: 4px; cursor: pointer; width: 100%; text-align: center; }
    .au-load-btn:hover { background: rgba(255,255,255,0.15); }
</style>

<div class="admin_header">
    Auto-Upload Manager
</div>
<div class="admin_page">
    <?php
    if (!is_dir($baseDir)) {
        echo '<p class="au-empty">Directory not found: ' . htmlspecialchars($baseDir) . '</p>';
    } else {
        $folders = glob($baseDir . '/*', GLOB_ONLYDIR);
        $items = [];
        
        foreach ($folders as $folder) {
            $folderName = basename($folder);
            $files = glob($folder . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    $items[] = [
                        'folder' => $folderName,
                        'file' => basename($file),
                        'type' => getFileType($file),
                        'size' => filesize($file),
                        'date' => filemtime($file)
                    ];
                }
            }
        }
        
        // Sort by date, oldest first
        usort($items, fn($a, $b) => $a['date'] <=> $b['date']);
        
        echo '<p class="au-count">Found ' . count($items) . ' file(s) in ' . count($folders) . ' folder(s)</p>';
        
        if (empty($items)) {
            echo '<p class="au-empty">No files found.</p>';
        } else {
            echo '<div id="item-list">';
            foreach ($items as $item) {
                $filePath = $webPath . '/' . $item['folder'] . '/' . $item['file'];
                $isLargeImage = $item['type'] === 'image' && $item['size'] > 15 * 1024 * 1024;
                
                echo '<div class="au-file-item" data-folder="' . htmlspecialchars($item['folder']) . '">';
                echo '<div class="au-file-header">';
                echo '<div class="au-file-info">';
                echo '<div class="au-file-meta">';
                echo '<span class="au-pill">' . formatFileSize($item['size']) . '</span>';
                echo '<span class="au-date">' . date('Y-m-d H:i', $item['date']) . '</span>';
                echo '</div>';
                echo '<span class="au-folder-name">/' . htmlspecialchars($item['folder']) . '/</span>';
                echo '<span class="au-file-name">' . htmlspecialchars($item['file']) . '</span>';
                echo '</div>';
                echo '<button class="au-delete-btn" onclick="auDeleteFolder(\'' . htmlspecialchars($item['folder'], ENT_QUOTES) . '\', this)">Delete</button>';
                echo '</div>';
                
                // Embed preview based on type
                if ($item['type'] === 'image') {
                    if ($isLargeImage) {
                        echo '<div class="au-preview"><button class="au-load-btn" onclick="auLoadImage(this, \'' . htmlspecialchars($filePath, ENT_QUOTES) . '\')">Click to load image (' . formatFileSize($item['size']) . ')</button></div>';
                    } else {
                        echo '<div class="au-preview"><img src="' . htmlspecialchars($filePath) . '" alt="' . htmlspecialchars($item['file']) . '"></div>';
                    }
                } elseif ($item['type'] === 'audio') {
                    echo '<div class="au-preview"><audio controls src="' . htmlspecialchars($filePath) . '"></audio></div>';
                } elseif ($item['type'] === 'video') {
                    echo '<div class="au-preview"><video controls src="' . htmlspecialchars($filePath) . '"></video></div>';
                }
                
                echo '</div>';
            }
            echo '</div>';
        }
    }
    ?>
</div>

<script>
function auLoadImage(btn, src) {
    const img = document.createElement('img');
    img.src = src;
    img.alt = 'Loaded image';
    btn.replaceWith(img);
}

async function auDeleteFolder(folderName, btn) {
    if (!confirm('Delete folder "' + folderName + '" and its contents?')) return;
    
    btn.disabled = true;
    btn.textContent = 'Deleting...';
    
    try {
        const response = await fetch(window.location.href, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'delete_folder=' + encodeURIComponent(folderName)
        });
        
        const result = await response.json();
        
        if (result.success) {
            const item = btn.closest('.au-file-item');
            item.style.opacity = '0';
            item.style.transition = 'opacity 0.3s';
            setTimeout(() => item.remove(), 300);
        } else {
            alert('Failed to delete: ' + (result.error || 'Unknown error'));
            btn.disabled = false;
            btn.textContent = 'Delete';
        }
    } catch (e) {
        alert('Error: ' + e.message);
        btn.disabled = false;
        btn.textContent = 'Delete';
    }
}
</script>