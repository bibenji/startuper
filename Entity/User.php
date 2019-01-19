<?php

namespace Entity;

use Ramsey\Uuid;

class User extends Base
{    
    protected $username;
    protected $email;
    protected $firstname;
    protected $lastname;
    protected $birthdate;
    protected $sex;
    protected $description;
    protected $password;
    protected $startuper;
    protected $comments;

    public function __construct()
    {
        $this->startuper = 0; // marche pas avec FALSE
    }
        
    public function setUsername($username)
    {
        $this->username = $username;
    }
    
    public function getUsername()
    {
        return $this->username;
    }
    
    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    public function getEmail()
    {
        return $this->email;
    }
    
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }
    
    public function getFirstname()
    {
        return $this->firstname;
    }
    
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }
    
    public function getLastname()
    {
        return $this->lastname;
    }
    
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    }
    
    public function getBirthdate()
    {
        return $this->birthdate;
    }
    
    public function setSex($sex)
    {
        $this->sex = $sex;
    }
    
    public function getSex()
    {
        return $this->sex;
    }
    
    public function setDescription($description)
    {
        $this->description = $description;
    }
    
    public function getDescription()
    {
        return $this->description;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setStartuper($startuper)
    {
        $this->startuper = $startuper;
    }

    public function getStartuper()
    {
        return $this->startuper;
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
