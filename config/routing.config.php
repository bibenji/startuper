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
    'connexion' => [
        'uri' => '/^\/connexion$/',
        'controller' => 'ConnexionController',        
    ],    
    Router::DEFAULT_MATCH => [
        'uri' => '/^.*$/',
        'controller' => 'HomeController',
    ],
];
