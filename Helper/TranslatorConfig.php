<?php

namespace tm\InlineTranslator\Helper;

/**
 * Autor: Tobias Matthaiou <225997+TumTum@users.noreply.github.com>
 * Date: 27.11.17
 * Time: 12:00
 */

use OxidEsales\Eshop\Core\Exception\ExceptionToDisplay;
use OxidEsales\Eshop\Core\Registry;

/**
 * Class TranslatorConfig
 */
class TranslatorConfig
{
    /**
     * @var bool
     */
    static protected $active = true;

    /**
     * @var integer
     */
    static protected $basicLang = [
        'to'   => null,
        'from' => null,
    ];

    /**
     * @return bool
     */
    static public function isActive()
    {
        return (self::$active && isAdmin() == false);
    }

    /**
     * Set Translation to deaktive
     */
    static public function setDeactive()
    {
        self::$active = false;
    }

    /**
     * @return string
     */
    static public function getTranslateTo()
    {
        $configParam = Registry::getConfig()->getConfigParam('tmTranslateTo');

        if ($configParam === null) {
            $exceptionToDisplay = new ExceptionToDisplay();
            $exceptionToDisplay->setMessage('TranslatorConfig konfigration fehlt: in welche Sprache übersetzt werden soll');

            Registry::getUtilsView()->addErrorToDisplay($exceptionToDisplay);

            return 'xyz';
        }

        return $configParam;
    }

    /**
     * @return int
     */
    static public function getTranslateToId()
    {
        if (static::$basicLang['to'] !== null) {
            return static::$basicLang['to'];
        }

        return static::$basicLang['to'] = self::convertLangToId(static::getTranslateTo());
    }

    /**
     * @return string
     */
    static public function getTranslateFrom()
    {
        return Registry::getConfig()->getConfigParam('tmTranslateFrom');
    }

    /**
     * @return int
     */
    static public function getTranslateFromId()
    {
        if (static::$basicLang['from'] !== null) {
            return static::$basicLang['from'];
        }

        $configParam = Registry::getConfig()->getConfigParam('tmTranslateFrom');
        return static::$basicLang['from'] = self::convertLangToId($configParam);
    }

    /**
     * Cache Filenam
     * e
     * @return string
     */
    static public function getIndexCacheName()
    {
        $LangTo = static::getTranslateTo();

        return Registry::getLang()->getIndexFilename(isAdmin(), $LangTo);
    }

    /**
     * @param $langString
     * @return int
     */
    protected static function convertLangToId($langString)
    {
        $languageIds = Registry::getLang()->getLanguageIds();

        if ($langString === null) {
            return 0;
        }

        $languageAbbr = array_flip($languageIds);

        if (isset($languageAbbr[$langString])) {
            return $languageAbbr[$langString];
        }

        return 0;
    }
}
