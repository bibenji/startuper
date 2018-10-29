<?php

namespace Controller;

use Database\{Connection, Finder, Paginate, Service\ArticleService};

class ArticleController extends BaseController
{
    public function handle($articleId)
    {        
        $articleService = new ArticleService($this->connection);
        $countByCategories = $articleService->fetchCountByCategories();
        $lastArticles = $articleService->getLastArticles();
        $article = $articleService->fetchByIdWithComments($articleId);
        
        $this->renderView('View\ArticleView', [
            'article' => $article,
            'countByCategories' => $countByCategories,
            'lastArticles' => $lastArticles,
        ]);
    }
}
