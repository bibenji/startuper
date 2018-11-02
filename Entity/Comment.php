<?php

namespace Entity;

use DateTime;
use Error;

class Comment extends Base
{   
    protected $article;
    protected $parent;
    protected $user;
    protected $date;
    protected $pseudo;
    protected $comment;
    
    protected $mapping = [
        'id' => 'id',
        'article_id' => 'article',
        'comment_id' => 'parent',
        'user_id' => 'user',
        'date' => 'date',
        'pseudo' => 'pseudo',
        'comment' => 'comment',
    ];
    
    public function __construct()
    {
        $this->date = new DateTime();
    }
    
    public function setDate($date)
    {
        if ($date instanceof DateTime) {
            $this->date = $date;
        } else {
            if (preg_match('/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/', $date, $matches)) {
                $this->date = \DateTime::createFromFormat('Y-m-d H:i:s', $date);
            } else {
                throw new Error('Erreur : Le format de date est invalide');
            }
        }
    }
    
    public function getDate()
    {
        return $this->date;
    }
    
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
    }
    
    public function getPseudo()
    {
        return $this->pseudo;
    }
    
    public function setComment($comment)
    {        
        $this->comment = $comment;
    }
    
    public function getComment()
    {        
        return $this->comment;
    }
    
    public function setUser($user)
    {
        $this->user = $user;
    }
    
    public function getUser()
    {
        return $this->user;
    }
    
    public function setArticle($article)
    {
        $this->article = $article;
    }
        
    public function getArticle()
    {
        return $this->article;
    }
    
    public function setParent($comment)
    {
        $this->parent = $comment;
    }
    
    public function getParent()
    {
        return $this->parent;
    }
        
    public function entityToArray()
    {
        $data = parent::entityToArray();
        
        if ($data['article_id'] instanceof Article) {
            $data['article_id'] = $data['article_id']->getId();
        }        
        
        if ($data['date'] instanceof DateTime) {
            $data['date'] = $data['date']->format('Y-m-d H:i:s');
        }        
                
        return $data;
    }
}
