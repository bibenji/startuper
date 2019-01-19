<?php

namespace Engine\Captcha;

interface CaptchaInterface
{
    public function getLabel();
    public function getImage();
    public function getPhrase();    
}
