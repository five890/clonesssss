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

// Função para servir o Frontend
$serveFrontend = function() {
    $indexFile = __DIR__ . '/index.html';
    if (file_exists($indexFile)) {
        echo file_get_contents($indexFile);
    } else {
        echo "Frontend not found.";
    }
};

// Rota para a página inicial
$router->get('/', $serveFrontend);

// Catch-all route for React SPA and Static Files
$router->any('/*:any', function($any) use ($serveFrontend) {
    $file = __DIR__ . '/' . $any;
    
    // Se o arquivo existir fisicamente, serve ele (CSS, JS, Imagens)
    if (is_file($file)) {
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
        echo file_get_contents($file);
        return;
    }

    // Caso contrário, serve o index.html (SPA Routing)
    $serveFrontend();
});

$router->run();
