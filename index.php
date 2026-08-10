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

// Habilitar CORS para desenvolvimento
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

// Catch-all route for React SPA
$router->any('/*:any', function() {
    $indexFile = __DIR__ . '/index.html';
    if (file_exists($indexFile)) {
        echo file_get_contents($indexFile);
    } else {
        echo "Frontend not found. Please run npm run build in ui folder.";
    }
});

$router->run();
