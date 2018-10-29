<?php

namespace Engine;

class Router
{
    const DEFAULT_MATCH = 'default';

    protected $config;
    protected $uri;
    
    public function __construct($config)
    {
        $this->config = $config;
        $this->uri = $_SERVER['REQUEST_URI'];
    }
        
    public function match()
    {   
        $fullControllerName = 'Controller\HomeController';
        $params = '';
                
        foreach ($this->config as $name => $route) {
            if (preg_match($route['uri'], $this->uri, $matches)) {                
                $fullControllerName = 'Controller\\'.$route['controller'];                
                if (!empty($route['params'])) {                    
                    foreach ($route['params'] as $index => $param) {
                        $params .= $matches[$index+1].', ';
                    }
                    $params = rtrim($params, ', ');
                }
                break;
            }            
        }        
        
        return [
            'fullControllerName' => $fullControllerName,
            'params' => $params,
        ];
    }
}
