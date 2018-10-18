<?php

// Autoload
require_once __DIR__ . '/Autoload/Loader.php';
Autoload\Loader::init ( __DIR__ );

// Init connection to db
use Database\{Connection, Service\UserService};
define ( 'DB_CONFIG_FILE', '/config/db.config.php' );

try {
	$connection = new Connection ( include __DIR__ . DB_CONFIG_FILE );
} catch (Throwable $e) {
	echo $e->getMessage ();
}

// $userService = new UserService($connection);
// $result = $userService->fetchById(1);
// echo $result->getUsername();
// // echo $result->getEmail();
// foreach ($result->getComments()() as $comment) {
// 	var_dump($comment);
// }

$filename = 'index.html';

function phpToHTML($filename)
{
	$file = new SplFileObject($filename);
	
	function getContent($file)
	{
		while (!$file->eof()) {
			yield $file->fgets();
		}
	}
	
	$content = getContent($file);
	
	foreach ($content as $part) {
		echo $part;
	}	
}

$uri = ltrim($_SERVER['REQUEST_URI'], '/');
switch ($uri) {	
	case 'blog':
		$controller = new Controller\BlogController($connection);
		$controller->handle();
// 		$filename = 'blog.html';
// 		require_once(__DIR__.'/blog.php');
	break;
	case 'article':
		$filename = 'article.html';
	default:
		phpToHTML($filename);
}
