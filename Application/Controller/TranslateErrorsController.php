<?php
/**
 * Autor: Tobias Matthaiou <225997+TumTum@users.noreply.github.com>
 * Date: 19.10.20
 * Time: 15:57
 */

namespace tm\InlineTranslator\Application\Controller;

use OxidEsales\Eshop\Application\Controller\FrontendController;
use OxidEsales\Eshop\Core\Registry;
use tm\InlineTranslator\Helper\TranslatorConfig;

/**
 * Class TransleteErrorsController
 * @package tm\InlineTranslator\Application\Controller
 */
class TranslateErrorsController extends FrontendController
{
    public $_sThisTemplate = 'translate_errors_page.tpl';

    /**
     * @inheritDoc
     */
    public function render()
    {
        $this->addTplParam("lang_strings", $this->encodeVueJson($this->findErrorString()));
        $this->addTplParam("langIdToTranslate", TranslatorConfig::getTranslateToId());

        return parent::render();
    }

    /**
     * @return array
     */
    private function findErrorString()
    {
        $language = Registry::getLang();

        $fatal_warn_errors = array_merge(
            $language->getSimilarByKey('error', TranslatorConfig::getTranslateFromId()),
            $language->getSimilarByKey('fail', TranslatorConfig::getTranslateFromId()),
            $language->getSimilarByKey('warn', TranslatorConfig::getTranslateFromId()),
            $language->getSimilarByKey('danger', TranslatorConfig::getTranslateFromId()),
            $language->getSimilarByKey('alert', TranslatorConfig::getTranslateFromId()),
            $language->getSimilarByKey('notice', TranslatorConfig::getTranslateFromId()),
            $language->getSimilarByKey('dialog', TranslatorConfig::getTranslateFromId()),
            $language->getSimilarByKey('promt', TranslatorConfig::getTranslateFromId()),
            $language->getSimilarByKey('MONTH', TranslatorConfig::getTranslateFromId()),
            $language->getSimilarByKey('DAY', TranslatorConfig::getTranslateFromId()),
            $language->getSimilarByKey('YEAR', TranslatorConfig::getTranslateFromId())
        );

        array_walk($fatal_warn_errors, [$this, 'addTargetLanganguage']);

        return $fatal_warn_errors;
    }

    /**
     * @param $value
     * @param $lang_key
     */
    protected function addTargetLanganguage(&$value, $lang_key)
    {
        $language = Registry::getLang();
        $translateStringTo = $language->originTranslateString($lang_key, TranslatorConfig::getTranslateToId());
        if ($language->isTranslated() == false) {
            $translateStringTo = '';
        }
        $value = [
            'from' => $value,
            'to' => $translateStringTo
        ];
    }

    /**
     * @param $data
     * @return string
     */
    protected function encodeVueJson($data)
    {
        if (is_array($data)) {
            array_walk_recursive($data, function (&$item) {
                if (is_string($item)) {
                    $item = html_entity_decode($item, ENT_QUOTES);
                }
            });
        } elseif (is_string($data)) {
            $data = html_entity_decode($data, ENT_QUOTES);
        }

        return \json_encode($data, JSON_HEX_APOS | JSON_HEX_QUOT );
    }
}
