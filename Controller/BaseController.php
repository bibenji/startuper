<?php

namespace Controller;

use Database\Connection;
use View\LayoutView;

class BaseController
{
    protected $connection;
    
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
    
    protected function renderView($viewName, $parameters)
    {        
        $currentView = new $viewName();
        $currentContent = $currentView->render($parameters);
        $layoutView = new LayoutView();
        $fullView = $layoutView->render(['content' => $currentContent]);
        echo $fullView;
    }
}
