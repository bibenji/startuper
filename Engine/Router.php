<?php

namespace Engine;

class Router
{
    const DEFAULT_MATCH = 'default';
    
    protected $request;
    protected $config;
    protected $uri;
    
    public function __construct(Request $request, array $config)
    {        
        $this->request = $request;
        $this->config = $config;
        $this->uri = $this->request->getUri();
    }
        
    public function match()
    {   
        $fullControllerName = 'Controller\HomeController';
        $params = [];
                
        foreach ($this->config as $name => $route) {
            if (preg_match($route['uri'], $this->uri, $matches)) {                
                $fullControllerName = 'Controller\\'.$route['controller'];                
                if (!empty($route['params'])) {                    
                    foreach ($route['params'] as $index => $param) {
                        $params[$param] = $matches[$index+1];
                    }                    
                }
                break;
            }            
        }        
        
        $this->request->addParams($params);
        
        return [
            'fullControllerName' => $fullControllerName,
            'params' => implode(', ', $params), // params passés sous forme de string
        ];
    }
}
