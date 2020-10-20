<?php

namespace tm\InlineTranslator\Application\Core;

/**
 * Autor: Tobias Matthaiou <225997+TumTum@users.noreply.github.com>
 * Date: 24.11.17
 * Time: 05:57
 */

use tm\InlineTranslator\Helper\TranslatorConfig;
use OxidEsales\Eshop\Core\Registry as oxRegistry;

/**
 * Class Language
 *
 * @mixin \OxidEsales\Eshop\Core\Language
 */
class Language extends Language_parent
{

    protected $excludeKeywords = [
        'charset',
        'PAGE_TITLE_'
    ];

    /**
     * Wrapper
     * @param $sStringToTranslate
     * @param null $iLang
     * @param null $blAdminMode
     */
    public function translateString($sStringToTranslate, $iLang = null, $blAdminMode = null)
    {
        if ($this->excludeKeywords($sStringToTranslate)) {
            return parent::translateString($sStringToTranslate, $iLang, $blAdminMode);
        }
        // Suche übersetzung von eingestellter sprache
        $sTranslated = parent::translateString($sStringToTranslate, $iLang, $blAdminMode);

        //Wenn nicht dann nimm vom Deutschen
        if ($this->isTranslated() == false) {
            $sTranslated = parent::translateString($sStringToTranslate, TranslatorConfig::getTranslateFromId(), $blAdminMode);
        }

        $sTranslated = base64_encode((string)$sTranslated);

        return "[tmtrans]$sStringToTranslate#$iLang#$blAdminMode#${sTranslated}[/tmtrans]";
    }

    /**
     * Original Funktion aufruf
     *
     * @param $sStringToTranslate
     * @param null $iLang
     * @param null $blAdminMode
     * @return mixed
     */
    public function originTranslateString($sStringToTranslate, $iLang = null, $blAdminMode = null)
    {
        return parent::translateString($sStringToTranslate, $iLang, $blAdminMode);
    }

    /**
     * @param $blAdmin
     * @param $iLang
     * @param $aLangFiles
     * @return string
     */
    public function getIndexFilename($blAdmin, $iLang, $aLangFiles = null)
    {
        return $this->_getLangFileCacheName($blAdmin, $iLang, $aLangFiles) . '_tmtans_index';
    }

    /**
     * Geht die sprachen durch
     *
     * @param bool $blAdmin
     * @param int $iLang
     * @param null $aLangFiles
     * @return mixed
     */
    protected function _getLanguageFileData($blAdmin = false, $iLang = 0, $aLangFiles = null)
    {
        $this->createIndex($blAdmin, $aLangFiles);

        return parent::_getLanguageFileData($blAdmin, $iLang, $aLangFiles);
    }

    /**
     * @param $blAdmin
     * @param $aLangFiles
     */
    protected function createIndex($blAdmin, $aLangFiles)
    {
        $myUtils = oxRegistry::getUtils();

        $langTo = TranslatorConfig::getTranslateTo();
        $langFrom = TranslatorConfig::getTranslateFrom();

        $sCacheName = $this->getIndexFilename($blAdmin, $langTo, $aLangFiles);
        $sIndexCache = $myUtils->getCacheFilePath($sCacheName);

        if ($sIndexCache !== null && file_exists($sIndexCache)) {
            return;
        };

        if ($aLangFiles === null) {
            if ($blAdmin) {
                $aLangFiles = $this->_getAdminLangFilesPathArray(TranslatorConfig::getTranslateFromId());
            } else {
                $aLangFiles = $this->_getLangFilesPathArray(TranslatorConfig::getTranslateFromId());
            }
        }

        $aLangCache = [];

        foreach ($aLangFiles as $sLangFile) {
            if (file_exists($sLangFile) && is_readable($sLangFile)) {
                $aLang = [];

                include $sLangFile;

                unset($aLang['charset']);
                foreach ($aLang as $key => $value) {
                    $aLangCache[$key][] = str_replace('/'.$langFrom. '/', '/'.$langTo. '/', $sLangFile);
                }
            }
        }

        $myUtils->setLangCache($sCacheName, $aLangCache);
    }

    /**
     * @param $sStringToTranslate
     * @return bool
     */
    protected function excludeKeywords($sStringToTranslate)
    {
        if (TranslatorConfig::isActive() === false) {
            return true;
        }
        foreach ($this->excludeKeywords as $key) {
            if (strpos($sStringToTranslate, $key) === 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * Key muss irgenwo drinnen stehen
     * @param $aData
     * @param $sKey
     * @param array $aCollection
     * @return array|mixed
     */
    protected function _collectSimilar($aData, $sKey, $aCollection = [])
    {
        foreach ($aData as $sValKey => $sValue) {
            if (stripos($sValKey, $sKey) !== false) {
                $aCollection[$sValKey] = $sValue;
            }
        }

        return $aCollection;
    }
}

