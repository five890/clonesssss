<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/app/configs/db.php';

use app\controllers\AccountController;
use app\controllers\PaymentController;
use Buki\Router\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$router = new Router([
    'paths' => [
        'controllers' => './app/controllers',
        'middlewares' => './app/middlewares',
    ],
    'namespaces' => [
        'controllers' => 'app\\controllers',
        'middlewares' => 'app\\middlewares',
    ],
    'debug' => true,
]);

// Habilitar CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// API Routes
$router->get('/token/validate', "TokenController@validate");

$router->group('/account', function (Router $router) {
    ($ac = new AccountController())->main($router);
});

$router->group('/payment', function (Router $router) {
    ($ac = new PaymentController())->main($router);
});

// Serve static files from storage
$router->get('/storage/:filename', "StorageController@handle");

// Manual handling for assets and frontend to avoid router conflicts
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// 1. Check if it's a physical file in the root or assets folder
$file = __DIR__ . $uri;
if ($uri !== '/' && is_file($file)) {
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    $mimes = [
        'css' => 'text/css',
        'js'  => 'application/javascript',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'svg' => 'image/svg+xml',
        'woff' => 'font/woff',
        'woff2' => 'font/woff2',
    ];
    if (isset($mimes[$ext])) {
        header("Content-Type: " . $mimes[$ext]);
    }
    readfile($file);
    exit;
}

// 2. If it's an API route, let the router handle it
if (strpos($uri, '/account') === 0 || strpos($uri, '/payment') === 0 || strpos($uri, '/token') === 0 || strpos($uri, '/storage') === 0) {
    $router->run();
    exit;
}

// 3. For everything else, serve the React index.html
$indexFile = __DIR__ . '/index.html';
if (file_exists($indexFile)) {
    readfile($indexFile);
} else {
    echo "Frontend not found.";
}
exit;
