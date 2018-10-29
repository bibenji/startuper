<?php

namespace Database;

class Finder
{
    const LEFT_JOIN = 'LEFT JOIN ';
    const RIGHT_JOIN = 'RIGHT JOIN ';
    const INNER_JOIN = 'INNER JOIN ';
            
    public static $sql = '';
    public static $instance = NULL;
    public static $prefix = '';
    public static $join = [];
    public static $where = [];
    public static $control = ['', ''];
    
    public static function select($tableName, $colsNames = NULL)
    {
        self::$instance = new Finder();
        
        if ($colsNames) {
            self::$prefix = 'SELECT ' . $colsNames . ' FROM ' . $tableName;
        } else {
            self::$prefix = 'SELECT * FROM ' . $tableName;
        }
        
        return self::$instance;
    }    
    
    public static function join($joinType, $tableName, $onCol1, $onCol2)
    {
        self::$join[] = $joinType . $tableName . ' ON ' . $onCol1 . ' = ' . $onCol2;
        return self::$instance;
    }
    
    public static function where($a = NULL)
    {
        self::$where[0] = ' WHERE ' . $a;
        return self::$instance;
    }
    
    public static function like($a, $b)
    {
        self::$where[] = trim('AND ' . $a . ' LIKE "' . $b . '"');
        return self::$instance;
    }
    
    public static function and($a = NULL)
    {
        self::$where[] = trim('AND ' . $a);
        return self::$instance;
    }
    
    public static function or($a = NULL)
    {
        self::$where[] = trim('OR ' . $a);
        return self::$instance;
    }
    
    public static function in(array $a)
    {
        self::$where[] = 'IN ( ' . implode(',', $a) . ' )';
        return self::$instance;
    }
    
    public static function not($a = NULL)
    {
        self::$where[] = trim('NOT ' . $a);
        return self::$instance;
    }
    
    public static function limit($limit)
    {
        self::$control[0] = 'LIMIT ' . $limit;
        return self::$instance;
    }
    
    public static function offset($offset)
    {
        self::$control[1] = 'OFFSET ' . $offset;
        return self::$instance;
    }
    
    public static function getSql()
    {
        self::$sql =
            self::$prefix . ' ' .
            implode(' ', self::$join) . ' ' .
            implode(' ', self::$where) . ' ' .
            self::$control[0] . ' ' .
            self::$control[1]
        ;
        
        preg_replace('/ /', ' ', self::$sql);        
        return trim(self::$sql);
    }
}
