<?php
/**
 * Autor: Tobias Matthaiou <225997+TumTum@users.noreply.github.com>
 * Date: 12.02.18
 * Time: 10:12
 */

namespace tm\InlineTranslator\Lib;

/**
 * Class ClearCache
 * @package tm\InlineTranslator\Lib
 */
class ClearCache
{
    /**
     * Löscht den Cache mit den Language Files
     */
    static public function languageFiles()
    {
        $compileDir = \OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('sCompileDir');

        $sPath     = realpath($compileDir);
        $cachelang = glob($sPath . '/*langcache*');

        foreach ($cachelang as $file) {
            @unlink($file);
        }
    }
}
