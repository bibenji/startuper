<?php

namespace Engine;

use Error;

class Session
{   
    public function start()
    {
        session_start();
        session_regenerate_id();
    }
    
    public function __call($name, $value)
    {   
        if ('set' === substr($name, 0, 3)) {
            $key = lcfirst(substr($name, 3));            
            $_SESSION[$key] = $value[0];
        } elseif ('get' === substr($name, 0, 3)) {
            $key = lcfirst(substr($name, 3));
            return isset($_SESSION[$key]) ? $_SESSION[$key] : NULL;            
        } else {
            throw new Error('Erreur : méthode non-définie');
        }
    }   
    
    public function stop()
    {
        session_destroy();
    }
}