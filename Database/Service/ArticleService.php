<?php

namespace Database\Service;

use PDO;
use Entity\Article;
use Database\{Connection, Finder};

class ArticleService extends AbstractService
{

	
	public function fetchByPublished($published = TRUE)
	{		
		$stmt = $this->connection->pdo->prepare(
			Finder::select('articles')
				->where('published = :published')
				->getSql()
		);		
		$stmt->execute(['published' => $published]);		
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {			
			yield Article::arrayToEntity($row, new Article());
		}
	}
	
	public function fetchById($id)
	{
		$stmt = $this->connection->pdo->prepare(
				Finder::select('articles')
				->where('id = :id')
				->getSql()
				);
		$stmt->execute(['id' => (int) $id]);
		
		// 		return $stmt->fetchObject('Entity\Article');
		
		// 		$stmt->setFetchMode(PDO::FETCH_INTO, new Article());
		// 		return $stmt->fetch();
		
		return Article::arrayToEntity($stmt->fetch(PDO::FETCH_ASSOC), new Article());
	}
	
	public function save($instance)
	{
		if ($instance->getId() && $this->fetchById($instance->getId())) {
			return $this->doUpdate($instance);
		} else {
			return $this->doInsert($instance);
		}
	}
	
	public function remove($instance)
	{
		$sql = 'DELETE FROM ' . $instance->getTableName() . ' WHERE id = :id';
		$stmt = $this->connection->pdo->prepare($sql);
		$stmt->execute(['id' => $instance->getId()]);
		return ($this->fetchById($instance->getId())) ? FALSE : TRUE;
	}
	
	protected function doUpdate($instance)
	{
		$values = $instance->entityToArray();
		$update = 'UPDATE ' . $instance->getTableName();
		$where = ' WHERE id = ' . $instance->getId();
		
		// unset ID as we want do not want this to be updated
		unset($values['id']);
		
		return $this->flush($update, $values, $where);
	}
	
	protected function doInsert($instance)
	{
		$values = $instance->entityToArray();
		
		$id = $values['id'];		
		
		$insert = 'INSERT INTO ' . $instance->getTableName() . ' ';
		if ($this->flush($insert, $values)) {
			return $this->fetchById($id);			
		} else {
			return FALSE;
		}		
	}
	
	protected function flush($sql, $values, $where = '')
	{
		$sql .= ' SET ';
		
		foreach ($values as $column => $value) {
			$sql .= $column . ' = :' . $column . ',';
		}
		
		// get rid of trailing ','
		$sql = substr($sql, 0, -1) . $where;
		
		$success = FALSE;
		
		try {
			$stmt = $this->connection->pdo->prepare($sql);
			$stmt->execute($values);
			$success = TRUE;
		} catch (PDOException $e) {
			error_log(__METHOD__ . ':' . __LINE__ . ':' . $e->getMessage());
			$success = FALSE;
		} catch (Throwable $e) {
			error_log(__METHOD__ . ':' . __LINE__ . ':' . $e->getMessage());
			$success = FALSE;
		}
		
		return $success;
	}
}