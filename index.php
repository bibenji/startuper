<?php

require_once __DIR__ . '/Autoload/Loader.php';
Autoload\Loader::init ( __DIR__ );


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
// 		$filename = 'blog.html';
		require_once(__DIR__.'/blog.php');
	break;
	case 'article':
		$filename = 'article.html';
	default:
		phpToHTML($filename);
}
