<?php
/**
 * Autor: Tobias Matthaiou <225997+TumTum@users.noreply.github.com>
 * Date: 09.02.18
 * Time: 07:13
 */

namespace tm\InlineTranslator\Application\Core;

use tm\InlineTranslator\Helper\TranslatorConfig;

/**
 * Class ViewConfig
 *
 * @package tm\InlineTranslator\Application\Core
 */
class ViewConfig extends ViewConfig_parent
{
    /**
     * @return string
     */
    public function tmTranslatorConfigFrom()
    {
        return TranslatorConfig::getTranslateFrom();
    }

    /**
     * @return string
     */
    public function tmTranslatorConfigTo()
    {
        return TranslatorConfig::getTranslateTo();
    }
}
