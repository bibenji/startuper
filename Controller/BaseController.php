<?php

namespace Controller;

use Database\Connection;
use View\LayoutView;
use Engine\Request;
use Engine\Session;

class BaseController
{
    protected $connection;
    protected $session;
    protected $request;
    protected $messages;
    
    public function __construct(Connection $connection, Session $session, Request $request)
    {
        $this->connection = $connection;
        $this->session = $session;
        $this->request = $request;
    }
    
    protected function renderView($viewName, $parameters)
    {        
        $parameters['messages'] = $this->messages;
        
        $currentView = new $viewName();
        $currentContent = $currentView->render($parameters);
        $layoutView = new LayoutView();
        $fullView = $layoutView->render(['content' => $currentContent]);
        echo $fullView;
    }
    
    public function getRequest()
    {
        return $this->request;
    }
    
    public function addMessage($message)
    {
        $this->messages[] = $message;
    }
    
    public function getMessages()
    {
        return $this->messages;
    }
}
