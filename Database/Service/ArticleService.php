<?php

namespace Database\Service;

use PDO;
use Entity\Article;
use Entity\Comment;
use Entity\User;
use Database\{Connection, Finder};

class ArticleService extends AbstractService
{   
    public function fetchByCategory($offset, $limit, $category = NULL)
    {
        $sql = Finder::select('articles', 'articles.*')->where('published = :published');
        
        if ($category) {            
            $sql
                ->join(Finder::LEFT_JOIN, 'article_category ac', 'ac.article_id', 'articles.id')
                ->join(Finder::LEFT_JOIN, 'categories c', 'c.id', 'ac.category_id')
                ->like('c.name', $category)
            ;
        }
        
        $sql
            ->offset($offset)
            ->limit($limit)
        ;
        
        $stmt = $this->connection->pdo->prepare($sql->getSql());
        
        $stmt->execute(['published' => TRUE]);
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {            
            yield $this->fetchCommentsForArticle(Article::arrayToEntity($row, new Article()));            
        }
    }
    
    public function fetchById($id)
    {
        $sql = Finder::select('articles')->where('articles.id = :id')->getSql();        
        $stmt = $this->connection->pdo->prepare($sql);
        $stmt->execute(['id' => (int) $id]);
        
        // return $stmt->fetchObject('Entity\Article');
        
        // $stmt->setFetchMode(PDO::FETCH_INTO, new Article());
        // return $stmt->fetch();
        
        return Article::arrayToEntity($stmt->fetch(PDO::FETCH_ASSOC), new Article());
    }
    
    private function fetchCommentsForArticle(Article $article, $offset = NULL, $limit = NULL)
    {
        $sql = Finder::select('comments')            
            ->join(Finder::LEFT_JOIN, 'users', 'users.id', 'comments.user_id')
            ->where('article_id = :articleId')
            ->order('ORDER BY comments.date DESC')
        ;
        
        if ($offset)
            $sql->offset($offset);
        if ($limit)
            $sql->limit($limit);
            
        $stmt = $this->connection->pdo->prepare($sql->getSql());                
                
        $stmt->execute(['articleId' => (int) $article->getId()]);        
        
        $comments = [];
        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {            
            $comment = Comment::arrayToEntity($result, new Comment());            
            $user = User::arrayToEntity($result, new User());            
            $comment->setUser($user);
            $comments[] = $comment;            
        }
        $article->setComments($comments);                
        
        return $article;
    }
    
    public function fetchByIdWithComments($id, $offset, $limit)
    {
        return $this->fetchCommentsForArticle($this->fetchById($id), $offset, $limit);
    }
    
    public function countByCategories()
    {
        $sql = 'SELECT c.name name, COUNT(*) count FROM articles a, article_category ac, categories c
                WHERE a.id = ac.article_id AND ac.category_id = c.id AND published = 1
                GROUP BY c.name';
        
        $stmt = $this->connection->pdo->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    public function countByCategory($category = NULL)
    {
        $sql = Finder::select('articles', 'COUNT(*)')->where('published = :published');
        
        if ($category) {
            $sql
            ->join(Finder::LEFT_JOIN, 'article_category ac', 'ac.article_id', 'articles.id')
            ->join(Finder::LEFT_JOIN, 'categories c', 'c.id', 'ac.category_id')
            ->like('c.name', $category)
            ;
        }
        
        $stmt = $this->connection->pdo->prepare($sql->getSql());
        
        $stmt->execute(['published' => TRUE]);
        
        return $stmt->fetch()[0];        
    }
    
    public function getLastArticles($nb = 3)
    {
        $sql = 'SELECT * FROM articles
                WHERE published = 1
                ORDER BY createdAt DESC
                LIMIT '.(int) $nb;
        
        $stmt = $this->connection->pdo->prepare($sql);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            yield Article::arrayToEntity($row, new Article());
        }        
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
        $sql = 'DELETE FROM ' . $instance->getTableName () . ' WHERE id = :id';
        $stmt = $this->connection->pdo->prepare($sql);
        $stmt->execute (['id' => $instance->getId()]);
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
        
        foreach($values as $column => $value) {
            $sql .= $column . ' = :' . $column . ',';
        }
        
        // get rid of trailing ','
        $sql = substr($sql, 0, - 1) . $where;
        
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
