<?php

namespace Engine\Captcha;

class Reverse implements CaptchaInterface
{
    const DEFAULT_LABEL = 'Ecrire les lettres dans l\'ordre inverse';
    const DEFAULT_LENGTH = 6;
    
    protected $phrase;
    
    public function __construct($label = self::DEFAULT_LABEL, $length = self:: DEFAULT_LENGTH, $includeNumbers = TRUE, $includeUpper = TRUE, $includeLower = TRUE, $includeSpecial = FALSE, $otherChars = NULL, array $suppressChars = NULL)
    {
        $this->label = $label;
        $this->phrase = new Phrase($length, $includeNumbers, $includeUpper, $includeLower, $includeSpecial, $otherChars, $suppressChars);
    }
    
    public function getLabel()
    {
        return $this->label;
    }
    
    public function getImage()
    {
        return strrev($this->phrase->getPhrase());
    }
    
    public function getPhrase()
    {
        return $this->phrase->getPhrase();
    }
}
