<?php

use Engine\Router;

return [
    'home' => [
        'uri' => '!^/$!',
        'controller' => 'HomeController',        
    ],
    'blog' => [
        'uri' => '/^\/blog(.*)$/',
        'controller' => 'BlogController',
    ],
    'article' => [
        'uri' => '/^\/article\/(\d+)$/',
        'controller' => 'ArticleController',
        'params' => ['article_id']
    ],
    Router::DEFAULT_MATCH => [
        'uri' => '/^.*$/',
        'controller' => 'HomeController',
    ],
];
