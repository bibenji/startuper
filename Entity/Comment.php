<?php

namespace Entity;

class Comment extends Base
{
    protected $date;
    protected $comment;
    protected $user;
    
    public function setDate($date)
    {
        $this->date = $date;
    }
    
    public function getDate()
    {
        return $this->date;
    }
    
    public function setComment($comment)
    {        
        $this->comment = $comment;
    }
    
    public function getComment()
    {        
        return $this->comment;
    }
    
    public function setUser(User $user)
    {
        $this->user = $user;
    }
    
    public function getUser()
    {
        return $this->user;
    }
}
