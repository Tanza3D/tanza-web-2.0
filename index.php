<?php
// Require composer autoloader
require __DIR__ . '/vendor/autoload.php';

// Create Router instance
$router = new \Bramus\Router\Router();


$router->get("/home", function() {
   include("frontend.php");
});
$router->get("/portfolio", function() {
    include("frontend.php");
});
$router->get("/gallery", function() {
    include("frontend.php");
});


$router->set404(function() {
    header('HTTP/1.1 404 Not Found');
    include("frontend.php");
});


$router->run();