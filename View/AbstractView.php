<?php

namespace View;

abstract class AbstractView implements ViewInterface
{	
    protected $parameters = [];        

    public function init($parameters)
    {		
        // foreach ($parameters as $key => $value) {
        //     $$key = $value;
        // }
        $this->parameters = $parameters;
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->parameters)) {
            return $this->parameters[$name];
        } else {
            throw new NoParameterViewException($name);
        }
    }
}
