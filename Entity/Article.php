<?php

namespace Entity;

class Article extends Base
{
    protected $createdAt;
    protected $updatedAt;
    protected $title;
    protected $categories;
    protected $resume;
    protected $picture;
    protected $content;
    protected $published;
    protected $comments;    
    
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }
    
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }
    
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
    
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    public function getTitle()
    {        
        return $this->title;
    }
    
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }
    
    public function getCategories()
    {
        return explode(',', $this->categories);
    }
    
    public function setResume($resume)
    {
        $this->resume = $resume;
    }
    
    public function getResume()
    {
        return $this->resume;    
    }
    
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }
    
    public function getPicture()
    {
        return $this->picture;
    }
    
    public function setContent($content)
    {
        $this->content = $content;
    }
    
    public function getContent()
    {
        return $this->content;
    }
    
    public function setPublished($published)
    {
        $this->published = $published;
    }
    
    public function getPublished()
    {
        return $this->published;
    }
    
    public function addComment(Comment $comment)
    {
        $this->comments[] = $comment;
    }
    
    public function setComments($comments)
    {
        $this->comments = $comments;
    }
    
    public function getComments()
    {
        return $this->comments;
    }
}
