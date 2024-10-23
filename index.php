<?php
// Require composer autoloader
include("config.php");
include("autoload.php");
require __DIR__ . '/vendor/autoload.php';

// Create Router instance
$router = new \Bramus\Router\Router();

if ($_SERVER['SERVER_NAME'] == "tanza.work") {
    Site::$work = true;
}

if(php_sapi_name() == "cli") {
    switch ($argv[1] ?? null) {
        case 'task':
            \Tasks\Tasks::RunSpecific($argv[2]);
            break;
        default:
            echo "Use command 'task' to run task\n";
            break;
    }
    exit;
}

function Page($page, $vars = []) {
    ob_start();
    include "views/$page.php";
    $pagename = $page;
    $page = ob_get_clean();
    include("frontend.php");
}


$router->get("/", function() {
   Page("home");
});
$router->get("/portfolio", function() {
    Page("portfolio");
});
$router->get("/gallery", function() {
    Page("gallery");
});
$router->post("/contact", function() {
    $try = \Database\Memcache::get("contact_from_".$_SERVER['REMOTE_ADDR']);
    if($try == true) echo json_encode("too_fast");

    Email::Send($_POST['from'], $_POST['name'], "tanza.me / contact form", $_POST['body']);

    \Database\Memcache::set("contact_from_".$_SERVER['REMOTE_ADDR'], true, 30);
    echo json_encode("ok");
});

include("admin.php");


$router->set404(function() {
    header('HTTP/1.1 404 Not Found');
    Page("404");
});


$router->run();