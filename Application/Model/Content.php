<?php

namespace tm\InlineTranslator\Application\Model;

/**
 * Date: 25.11.17
 * Time: 08:52
 */

use tm\InlineTranslator\Helper\TranslatorConfig;
use OxidEsales\Eshop\Core\Field;

/**
 * Class Content
 *
 * @mixin \OxidEsales\Eshop\Application\Model\Content
 */
class Content extends Content_parent
{
    /**
     * Mein ersten Fehl versuch noch einmal und im Deutsch Shop Suchen.
     *
     * @param $fetchedContent
     * @param bool $onlyActive
     */
    public function loadByIdent($loadId, $onlyActive = false)
    {
        $bool = parent::loadByIdent($loadId, $onlyActive);
        if ($bool === false) {
            $data = $this->copyFromBaseLanguage($loadId);
            $bool = parent::assignContentData($data);
        }
        return $bool;
    }

    /**
     * @param $dbRecord
     */
    public function assign($dbRecord)
    {
        parent::assign($dbRecord);

        if (TranslatorConfig::isActive() == false) {
            return;
        }

        if ($this->oxcontents__oxcontent) {
            $iLang    = $this->getLanguage();
            $oxloadid = $this->oxcontents__oxloadid->value;
            $content  = $this->oxcontents__oxcontent->value ? $this->oxcontents__oxcontent->value : $this->findContentFromBase();
            $content  = $this->markContent($oxloadid, $iLang, $content);

            $this->oxcontents__oxcontent->setValue($content, Field::T_RAW);
        }

    }

    /**
     * Sucht vom Orginal das CMS
     *
     * @return string
     */
    protected function findContentFromBase()
    {
        $data = $this->findIdentFromBaseLang();
        $this->oxcontents__oxactive->setValue(1, Field::T_RAW); //Damit es Klickbar bleibt

        if (isset($data['OXCONTENT'])) {
            return $data['OXCONTENT'];
        }
        return $this->oxcontents__oxloadid->value;
    }

    /**
     * @param $ident
     * @param $lang
     * @param $text
     * @return string
     */
    protected function markContent($ident, $lang, $text)
    {
        $converted =
            "<div class='tmconv' " .
            "data-type='tmident' " .
            "data-ident='${ident}' " .
            "data-lang='${lang}' " .
            "data-adminmode='0'>" .
            $text .
            "</div>";

        return $converted;
    }

    /**
     * Holt den Orginalen String
     *
     * @param $field
     * @return string
     */
    public function getFieldDataFromBase($field)
    {
        $data = $this->findIdentFromBaseLang();
        $field = strtoupper($field);
        if (isset($data[$field])) {
            return $data[$field];
        }
        return "Error unbekannt Field name: " . $field;
    }

    /**
     * Wenn ein neuer Content angelegt werden muss, dann kann man es klonen vom Original
     */
    public function copyFromBaseLanguage($ident)
    {
        $this->oxcontents__oxloadid = new Field($ident, Field::T_RAW);
        $data = $this->findIdentFromBaseLang();

        if (!empty($data)) {
            unset($data['OXID']);
            $data['OXSHOPID'] = $this->getShopId();
        }

        return $data;
    }

    /**
     * Läd aus der DB die Orginale Übersetzung
     *
     * @return array
     */
    protected function findIdentFromBaseLang()
    {
        $shopIdCache = $this->_iShopId;
        $this->_iShopId = 1;
        $this->_sViewTable = getViewName($this->getCoreTableName(), TranslatorConfig::getTranslateFromId(), $this->getShopId());
        $data = parent::_loadFromDb($this->oxcontents__oxloadid->value);
        $this->_iShopId = $shopIdCache;
        $this->_sViewTable = false;

        return $data;
    }

}
