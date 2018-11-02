<?php

namespace Engine;

use Exception;
use StdClass;

class Request
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const ERROR_NO_PARAM = 'Erreur : aucun paramètre existant avec cette clé';
            
    protected $documentRoot;
    protected $uri;    
    protected $method;    
    protected $params;
    
    public function __construct()
    {
        $data = $_SERVER ?? [];
        
        $this->documentRoot = ['DOCUMENT_ROOT'] ?? '';        
        $this->method = $data['REQUEST_METHOD'] ?? self::METHOD_GET;        
        
        foreach ($_POST as $key => $value) {
            $_POST['$key'] = htmlspecialchars($value);
        }
        
        $this->params = array_merge($_GET, $_POST);   
        
        if ($data['REQUEST_URI']) {
            $stdUri = $this->makeUri($data['REQUEST_URI']);
            $this->uri = $stdUri->uri;
            $this->params = array_merge($this->params, $stdUri->params);
        } else {
            $this->uri = '';
        }
    }
    
    public function makeUri($string)
    {
        $stdUri = new StdClass();
        $stdUri->uri = '';
        $stdUri->params = [];       
        
        $explodedUri = explode('?', $string);
        
        if (isset($explodedUri[1])) {
            $stdUri->uri = array_shift($explodedUri);
            
            $explodedQueryParams = explode('&', $explodedUri[0]);
            foreach ($explodedQueryParams as $queryParam) {
                list($key, $value) = explode('=', $queryParam);
                $stdUri->params[$key] = $value;
            }
        } else {
            $stdUri->uri = $string;
        }

        return $stdUri;
    }
    
    public function getMethod()
    {
        return $this->method;
    }
    
    public function getUri()
    {
        return $this->uri;
    }
    
    public function getParams()
    {
        return $this->params;
    }
    
    public function getParam($key)
    {
        if (isset($this->params[$key])) {
            return $this->params[$key];
        }
        return NULL;
    }
    
    public function addParams(array $data)
    {
        $this->params = array_merge($this->params, $data);
    }
}
