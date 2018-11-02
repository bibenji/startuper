<?php

namespace Controller;

use Database\{Connection, Finder, Paginate, Service\ArticleService};
use ArrayIterator;

class BlogController extends BaseController
{
    const MAX_ARTICLES_PER_PAGE = 10;
    
    public function handle()
    {   
        $articleService = new ArticleService($this->connection);
        
        $countByCategories = $articleService->countByCategories();
        $lastArticles = $articleService->getLastArticles();
        
        $category = $this->request->getParam('category') ?? NULL;
                
        $currentPage = $this->request->getParam('page') ?? 1;
        $totalArticles = $articleService->countByCategory($category);
        $totalPages = ceil(((int) $totalArticles) / self::MAX_ARTICLES_PER_PAGE);
        
        $limit = self::MAX_ARTICLES_PER_PAGE;
        $offset = ($currentPage-1)*self::MAX_ARTICLES_PER_PAGE;
        $prev = $currentPage+1 <= $totalPages ? $currentPage+1 : NULL;
        $next = $currentPage-1 >= 1 ? $currentPage-1 : NULL;
                
        $generator = $articleService->fetchByCategory($offset, $limit, $category);
        
        // $sql = Finder::select('articles')->getSql();
        
        // $prePaginate = new Paginate(
        // Finder::select('articles'),
        // 1,
        // 10
        // );
        
        // $generator = $prePaginate->paginate($connection, PDO::FETCH_ASSOC);
        
        // $arrayIterator = fetchArticles($sql, $connection);
        
        $iterator = new ArrayIterator(iterator_to_array($generator));
        
        // $iterator = filterArticlesFetched($iterator);
        
        // $iterator = limitArticlesFiltered($iterator, $offset, $limit);
        
        // var_dump($limitIterator);
        
        // while ($limitIterator->valid()) {
        // var_dump($limitIterator->current());
        // $limitIterator->next();
        // }
        
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
                // var_dump('1' === $current['published']);                
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
