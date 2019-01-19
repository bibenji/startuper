<?php

namespace Controller;

use Database\Connection;
use View\LayoutView;
use Engine\Request;
use Engine\Session;
use I18n\Locale;

class BaseController
{
    protected $connection;
    protected $session;
    protected $request;
    protected $locale;
    protected $messages;
    
    public function __construct(Connection $connection, Session $session, Request $request, Locale $locale)
    {
        $this->connection = $connection;
        $this->session = $session;
        $this->request = $request;
        $this->locale = $locale;
    }
    
    protected function renderView($viewName, $parameters)
    {        
        $parameters['messages'] = $this->messages;
        
        $currentView = new $viewName();
        $currentContent = $currentView->render(array_merge(['locale' => $this->locale], $parameters));
        $layoutView = new LayoutView();
        $fullView = $layoutView->render([
            'content' => $currentContent,
            'session' => $this->session,            
        ]);
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
