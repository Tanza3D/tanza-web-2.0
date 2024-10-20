<?php
$is_admin = false;
session_start();

if(isset($_SESSION['admin']) && $_SESSION['admin'] == true) $is_admin = true;

$router->get("/login", function () {
   header("Location: " . LOGIN_URL );
});
$router->get("/oauth", function () {
    $post = [
        'client_id' => CLIENT_ID,
        'client_secret' => CLIENT_SECRET,
        'code' => $_GET['code'],
        'grant_type' => 'authorization_code'
    ];

    $ch = curl_init(UNTONE_ID . '/api/oauth/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    $response = curl_exec($ch);
    $response = json_decode($response, true);
    $token = $response['access_token'];



    $headers = [
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json'
    ];
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, UNTONE_ID . "/api/users/me");
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    $response = json_decode(curl_exec($curl), true);

    if($response['id'] == 1) $_SESSION['admin'] = 1;
    header("Location: /admin/gallery");
});

if($is_admin) {
    $router->get("/admin/gallery", function () {
        Page("gallery_admin");
    });
    $router->get("/admin/portfolio", function () {
        Page("admin_portfolio");
    });
    $router->get("/admin/portfolio/{id}", function ($id) {
        Page("admin_portfolio_edit", $id);
    });

    $router->post("/admin/api/portfolio", function () {
        echo json_encode(\Database\Connection::execSimpleSelect("SELECT * FROM Portfolio ORDER BY Date DESC"));
    });

    $router->post("/admin/api/portfolio/upload", function () {
        // ahem
        \Data\Portfolio::UploadNew($_FILES, $_POST['id']);
    });

    $router->post("/admin/api/portfolio/update/{id}", function ($id) {
        // ahem
        \Data\Portfolio::Update($_POST, $id);
    });
}