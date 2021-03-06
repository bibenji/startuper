<?php

namespace Entity;

use ReflectionClass;
use ReflectionProperty;

class Base
{
    protected $id;
    protected $mapping = [ 
        // 'dbColumn' => 'propertyName',
        'id' => 'id' 
    ];
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getMapping()
    {
        return $this->mapping;
    }
    
    public static function arrayToEntity($data, Base $instance)
    {        
        if ($data && is_array($data)) {
            foreach ($data as $dbColumn => $value) {
                if (method_exists($instance, 'set' . ucfirst($dbColumn)))
                    $method = 'set' . ucfirst($dbColumn);
                elseif (isset($instance->mapping[$dbColumn]))
                    $method = 'set' . ucfirst($instance->mapping[$dbColumn]);
                    
                if (isset($method)) {
                    $instance->$method($data[$dbColumn]);
                    unset($method);
                }                    
            }
                            
            return $instance;
        }
        
        return FALSE;
    }
    
    public function entityToArray()
    {
        $data = [];
        
        $reflect = new ReflectionClass($this);
        $props = $reflect->getProperties(ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PRIVATE);
        
        foreach ($props as $prop) {
            if ('mapping' === $prop->getName()) continue;
            
            $method = 'get' . ucfirst($prop->getName());
            $dbProperty = array_search($prop->getName(), $this->mapping) ? array_search($prop->getName(), $this->mapping) : strtolower($prop->getName());
                        
            // revient à faire method_exists
            $data[$dbProperty] = $this->$method() ?? NULL;
        }        
        
        return $data;
    }
    
    public function getTableName()
    {
        $rc = new \ReflectionClass($this);
        return strtolower($rc->getShortName()) . 's';
    }
}
