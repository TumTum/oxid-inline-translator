<?php
/**
 * Autor: Tobias Matthaiou <225997+TumTum@users.noreply.github.com>
 * Date: 12.02.18
 * Time: 09:58
 */

namespace tm\InlineTranslator\Lib\Language;

use tm\InlineTranslator\Helper\TranslatorConfig;
use OxidEsales\Eshop\Core\Registry;

/**
 * Class FileController
 *
 * @package tm\InlineTranslator\Lib\Language
 */
class IdentFinder
{
    /**
     * Findet die Passende Langfile
     *
     * @param $ident
     *
     * @return LangFile
     */
    public function getLangFile($ident)
    {
        $index         = Registry::getUtils()->getLangCache(TranslatorConfig::getIndexCacheName());
        $languageNames = Registry::getLang()->getLanguageNames();

        if (isset($index[$ident])) {
            $langFile = new LangFile($index[$ident]);
        } else {
            $langFile = new LangFile([$this->getStdLangPath()]);
        }

        $langFile->init($languageNames[TranslatorConfig::getTranslateToId()]);

        return $langFile;
    }

    /**
     * Erstellt den Standard Path wieder her
     *
     * @return string
     */
    protected function getStdLangPath()
    {
        $config = Registry::getConfig();
        $theme = $config->getConfigParam("sTheme");
        $theme = $config->getConfigParam("sCustomTheme") ?: $theme;
        $applicationDirectory = $config->getAppDir();
        $languageAbbreviation = TranslatorConfig::getTranslateTo();

        return $applicationDirectory . 'views/' . $theme . '/' . $languageAbbreviation . '/lang.php';
    }
}
