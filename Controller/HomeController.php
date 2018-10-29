<?php

namespace Controller;

use Database\{Connection, Finder, Paginate, Service\ArticleService};

class HomeController extends BaseController
{
    public function handle()
    {        
        $articleService = new ArticleService($this->connection);
        $lastArticles = $articleService->getLastArticles();
        
        $this->renderView('View\HomeView', [
            'lastArticles' => $lastArticles,                
        ]);
    }
}
