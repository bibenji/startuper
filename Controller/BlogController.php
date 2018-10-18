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
		$generator = $articleService->fetchByPublished();
						
		// 	$sql = Finder::select('articles')->getSql();
		
		// 	$prePaginate = new Paginate(
		// 		Finder::select('articles'),
		// 		1,
		// 		10
		// 	);
		
		// 	$generator = $prePaginate->paginate($connection, PDO::FETCH_ASSOC);
		
		// 	$arrayIterator = fetchArticles($sql, $connection);
			
		$iterator = new ArrayIterator(iterator_to_array($generator));
			
		// 	$iterator = filterArticlesFetched($iterator);
			
		// 	$iterator = limitArticlesFiltered($iterator, $offset, $limit);
		
		// var_dump($limitIterator);
		
		// while ($limitIterator->valid()) {
		// 	var_dump($limitIterator->current());
		// 	$limitIterator->next();
		// }
		
		$this->renderView('View\BlogView', [
			'iterator' => $iterator,				
		]);
		
// 		include(__DIR__.'/vues/blog.php');
		
// 		include(__DIR__.'/vues/layout.php');
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
			public function accept()
			{
				$current = $this->current();
				// 			var_dump('1' === $current['published']);
				
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
