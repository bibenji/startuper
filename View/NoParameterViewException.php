<?php

namespace View;

class NoParameterViewException extends \Exception
{    
    const DEFAULT_MESSAGE = 'Error: No parameter "%s" in current view;

    public function __construct($parameterName, $message = self::DEFAULT_MESSAGE)
    {
        $this->message = sprintf($message, $parameterName);
    }
}
