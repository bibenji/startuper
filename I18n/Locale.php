<?php

namespace I18n;

use \Locale as PhpLocale;
use \IntlDateFormatter;
use \IntlCalendar;

class Locale extends PhpLocale
{
    const FALLBACK_LOCALE = 'fr-FR';

    const DATE_TYPE_FULL = IntlDateFormatter::FULL;
    const DATE_TYPE_SHORT = IntlDateFormatter::SHORT;    

    const ERROR_INTL_DATE_FMT_CREATION = 'Erreur lors de l\'instanciation du formatteur de date international';   

    protected $localeCode;    

    public function __construct($localeString = NULL)
    {
        if ($localeString) {
            // on set manuellement
            $this->setLocaleCode($localeString);
        } else {
            // on prend les infos du navigateur
            $this->setLocaleCode($this->getAcceptLanguage);
        }
    }

    public function setLocaleCode($acceptLangHeader)
    {
        $this->localeCode = $this->acceptFromHttp($acceptLangHeader);
    }
    
    public function getLocaleCode()
    {
        return $this->localeCode;
    }

    public function getAcceptLanguage()
    {
        return $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? self::FALLBACK_LOCALE;
    }

    private function getIntlDateFormatter($type)
    {
        switch ($type) {
            case self::DATE_TYPE_FULL :
                $formatter = new IntlDateFormatter($this->getLocaleCode(), IntlDateFormatter::FULL, IntlDateFormatter::FULL);
                break;
            case self::DATE_TYPE_SHORT :
                $formatter = new IntlDateFormatter($this->getLocaleCode(), IntlDateFormatter::SHORT, IntlDateFormatter::SHORT);
                break;
            default :
                throw new InvalidArgumentException(self::ERROR_INTL_DATE_FMT_CREATION);
        }                

        return $formatter;
    }

    private function formatDate($date, $type, $timeZone = NULL) {
        $dateAsArray = [
            'year' => date('Y'),
            'month' => date('m'),
            'day' => date('d'),
            'hour' => date('H'),
            'minute' => date('i'),
            'second' => date('s'),
        ];
        
        if (is_string($date)) {            
            $explodedDateTime = explode(' ', $date);
            $explodedDate = explode('-', $explodedDateTime[0]);
            $explodedTime = explode(':', $explodedDateTime[1]);
            $dateAsArray['year'] = $explodedDate[0];
            $dateAsArray['month'] = $explodedDate[1];
            $dateAsArray['day'] = $explodedDate[2];
            $dateAsArray['hour'] = $explodedTime[0];
            $dateAsArray['minute'] = $explodedTime[1];
            $dateAsArray['second'] = $explodedTime[2];
        } else if ($date instanceof \DateTime) {            
            $dateAsArray['year'] = $date->format('Y');
            $dateAsArray['month'] = $date->format('m');
            $dateAsArray['day'] = $date->format('d');
            $dateAsArray['hour'] = $date->format('H');
            $dateAsArray['minute'] = $date->format('i');
            $dateAsArray['second'] = $date->format('s');
        }        

        $intlCalendar = IntlCalendar::createInstance($timeZone, $this->getLocaleCode());
        $test = $intlCalendar->set(
            (int)$dateAsArray['year'],
            (int)$dateAsArray['month'],
            (int)$dateAsArray['day'],
            (int)$dateAsArray['hour'],
            (int)$dateAsArray['minute'],
            (int)$dateAsArray['second']
        );

        $formatter = $this->getIntlDateFormatter($type);
        if ($timeZone) {
            $formatter->setTimeZone($timeZone);
        }

        $result = $formatter->format($intlCalendar);

        return ucfirst(rtrim($result, 'UTC'));        
    }

    public function getFullDate($date)
    {
        return $this->formatDate($date, self::DATE_TYPE_FULL);
    }    

    public function getShortDate($date)
    {
        return $this->formatDate($date, self::DATE_TYPE_SHORT);
    }
}
