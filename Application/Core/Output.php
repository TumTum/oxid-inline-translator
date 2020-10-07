<?php

namespace tm\InlineTranslator\Application\Core;

/**
 * Autor: Tobias Matthaiou <225997+TumTum@users.noreply.github.com>
 * Date: 24.11.17
 * Time: 06:45
 */

use tm\InlineTranslator\Helper\TranslatorConfig;
use tm\InlineTranslator\Lib\OutputDecoder;

/**
 * Class Output
 */
class Output extends Output_parent
{
    public function process($sValue, $sClassName)
    {
        if (TranslatorConfig::isActive() == false) {
            return parent::process($sValue, $sClassName);
        }

        $output = parent::process($sValue, $sClassName);

        $outputDecoder = new OutputDecoder();
        return $outputDecoder->decode($output);
    }
}
