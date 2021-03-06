<?php

// Autoload
require_once __DIR__ . '/Autoload/Loader.php';
Autoload\Loader::init([
    __DIR__,    
]);

use I18n\Locale;

// Set locale param
$locale = new Locale('fr-FR');

// Init connection to db
use Database\{Connection, Service\UserService};
use Engine\Router;
use Engine\Request;
use Engine\Session;

define('DB_CONFIG_FILE', __DIR__.'/config/db.config.php');
define('ROUTING_CONFIG_FILE', __DIR__.'/config/routing.config.php');

try {
    $connection = new Connection(include DB_CONFIG_FILE);
} catch (Throwable $e) {
    echo $e->getMessage();
}

// $connection->pdo->exec('SET NAMES utf8');

// $userService = new UserService($connection);
// $result = $userService->fetchById(1);
// echo $result->getUsername();
// // echo $result->getEmail();
// foreach ($result->getComments()() as $comment) {
// var_dump($comment);
// }

$filename = 'index.html';
function phpToHTML($filename) {
    $file = new SplFileObject($filename);
    function getContent($file) {
        while (!$file->eof()) {
            yield $file->fgets();
        }
    }
    
    $content = getContent($file);
    
    foreach ($content as $part) {
        echo $part;
    }
}

$session = new Session();
$session->start();

$request = new Request();

$router = new Router($request, include ROUTING_CONFIG_FILE);
$matching = $router->match();

$controller = new $matching['fullControllerName']($connection, $session, $request, $locale);
eval('$controller->handle('.$matching['params'].');');
