<?php
/**
 * Autor: Tobias Matthaiou <225997+TumTum@users.noreply.github.com>
 * Date: 15.02.18
 * Time: 10:41
 */

namespace tm\InlineTranslator\Application\Core;

use tm\InlineTranslator\Lib\OutputDecoder;

/**
 * Class Utils
 * @package tm\InlineTranslator\Application\Core
 * @mixin \OxidEsales\Eshop\Core\Utils
 */
class Utils extends Utils_parent
{
    /**
     * @param $sMsg
     */
    public function showMessageAndExit($sMsg)
    {
        $outputDecoder = new OutputDecoder();
        parent::showMessageAndExit($outputDecoder->decode($sMsg));
    }
}
