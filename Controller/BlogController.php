<?php

namespace Controller;

use Database\{Connection, Finder, Paginate, Service\ArticleService};
use ArrayIterator;

class BlogController extends BaseController
{
    public function handle()
    {
        $limit = (int) ($_GET['limit'] ?? 10);
        $page = (int) ($_GET['page'] ?? 0);
        $offset = $page * $limit;
        $prev = ($page > 0) ? $page - 1 : 0;
        $next = $page + 1;
        
        $articleService = new ArticleService($this->connection);
        $countByCategories = $articleService->fetchCountByCategories();
        $lastArticles = $articleService->getLastArticles();
        
        $category = $_GET['category'] ?? NULL;
        $generator = $articleService->fetchByCategory($category);
        
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
