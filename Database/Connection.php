<?php

namespace Database;

use PDO;
use PDOException;

class Connection
{
    const ERROR_UNABLE = 'ERROR: Unable to create database connection';
    
    public $pdo;
    
    public function __construct(array $config)
    {
        $dsn = $config['driver'] . ':host='.$config['host'] . ';port='.$config['port'] . ';dbname='.$config['dbname'] . ';charset='.$config['charset'];
        
        try {
            $this->pdo = new PDO($dsn, $config['user'], $config['password'], [PDO::ATTR_ERRMODE => $config['errmode']]);
        } catch (PDOException $e) {
            // var_dump($e->getMessage());
            exit();
        }
    }
}
