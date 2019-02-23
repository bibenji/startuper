<?php

namespace Controller;

use Database\{Connection, Finder, Paginate, Service\ArticleService};
use ArrayIterator;

class BlogController extends BaseController
{
    const MAX_ARTICLES_PER_PAGE = 10;
    const DEFAULT_PAGE = 1;
    
    public function handle()
    {   
        $articleService = new ArticleService($this->connection);
        
        $countByCategories = $articleService->countByCategories();
        $lastArticles = $articleService->getLastArticles();
        
        $category = $this->request->getParam('category') ?? NULL;
                
        $currentPage = $this->request->getParam('page') ?? self::DEFAULT_PAGE;
        $totalArticles = $articleService->countByCategory($category);
        $totalPages = ceil(((int) $totalArticles) / self::MAX_ARTICLES_PER_PAGE);
        
        $limit = self::MAX_ARTICLES_PER_PAGE;
        $offset = ($currentPage - 1) * self::MAX_ARTICLES_PER_PAGE;
        $prev = $currentPage + 1 <= $totalPages ? $currentPage + 1 : NULL;
        $next = $currentPage - 1 >= 1 ? $currentPage - 1 : NULL;
                
        $generator = $articleService->fetchByCategory($offset, $limit, $category);
                
        $iterator = new ArrayIterator(iterator_to_array($generator));
                
        $this->renderView('View\BlogView', [ 
            'iterator' => $iterator,
            'countByCategories' => $countByCategories,
            'lastArticles' => $lastArticles,
            'next' => $next,
            'prev' => $prev,
        ]);
    }
    
    private function fetchArticles($sql, $connection)
    {
        $iterator = new ArrayIterator();
        $stmt = $connection->pdo->query($sql);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $iterator->append($row);
        }
        return $iterator;
    }
    
    private function filterArticlesFetched(ArrayIterator $iterator)
    {
        $f = new class($iterator) extends FilterIterator {
            public function accept() {
                $current = $this->current();
                return ('1' === $current->getPublished());
            }
        };
        return $f;
    }
    
    private function limitArticlesFiltered($iterator, $offset, $limit)
    {
        $l = new LimitIterator($iterator, $offset, $limit);
        return $l;
    }
}
