<?php

namespace tm\InlineTranslator\Application\Controller;

/**
 * Autor: Tobias Matthaiou <225997+TumTum@users.noreply.github.com>
 * Date: 27.11.17
 * Time: 11:49
 */

use tm\InlineTranslator\Helper\TranslatorConfig;
use tm\InlineTranslator\Lib\ClearCache;
use tm\InlineTranslator\Lib\Language\IdentFinder;
use OxidEsales\Eshop\Application\Controller\FrontendController;
use OxidEsales\Eshop\Application\Model\Content as oxContent;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\Eshop\Core\Registry as oxRegistry;
use OxidEsales\Eshop\Core\Output as oxOutput;
use OxidEsales\Eshop\Core\Request;

/**
 * Class TranslatorController
 *
 * @package tm\InlineTranslator\Application\Controller
 */
class TranslatorController extends FrontendController
{
    /**
     * If active load components
     * By default active
     *
     * @var array
     */
    protected $_blLoadComponents = false;

    /**
     * Flag if this object is a component or not
     *
     * @var bool
     */
    protected $_blIsComponent = true;

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        TranslatorConfig::setDeactive();
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $this->outputJson(['error' => 'no function called']);
    }

    /**
     * Sucht das Orginal
     */
    public function getOrginal()
    {
        $translation  = $this->getConfig()->getRequestParameter('translation');
        if (empty($translation) || !isset($translation['type']) || !isset($translation['ident'])) {
            $this->outputJson(['error' => 'no translation id\'s received']);
        }

        $data['content'] = 'not found';

        switch ($translation['type']) {
            case 'tmident':
                $data = $this->getCMS($translation['ident']);
                break;
            case 'tmtrans':
                $data = $this->getMultilang($translation['ident']);
                break;
            default:
                $data['error'] = 'translation-type is unknown. ';
        }


        $this->outputJson($data);
    }

    protected function getCMS($ident)
    {
        $data = ['content' => [], 'error' => ''];
        /** @var oxContent $oxContent */
        $oxContent = oxNew(oxContent::class);
        if ($oxContent->loadByIdent($ident)) {
            $data['content']['from'] = $oxContent->getFieldDataFromBase('oxcontent');
            $data['content']['to']   = $oxContent->getFieldData('oxcontent');
            if (empty($data['content']['to'])) {
                $data['content']['to'] = $data['content']['from'];
            }
        } else {
            $data['error'] = $ident . ' not found in DB';
        }

        return $data;
    }

    protected function getMultilang($ident)
    {
        $language = oxRegistry::getLang();
        $data['content']['from'] = $language->translateString($ident, TranslatorConfig::getTranslateFromId());
        $data['content']['to'] = $language->translateString($ident, TranslatorConfig::getTranslateToId());

        if ($language->isTranslated() == false) {
            $data['content']['to'] = $data['content']['from'];
        }

        return $data;
    }

    /**
     * Sichert die Translation ab.
     * Ist sicherheits gefährlich wenn jemand was anderes Abespeichert was er nicht machen soll
     */
    public function saveTranslatedContent()
    {
        $request = oxRegistry::get(Request::class);
        $translation = $request->getRequestParameter('translation');
        $newContent  = $request->getRequestParameter('newcontent');

        if (empty($translation) || !isset($translation['type']) || !isset($translation['ident']) || empty($newContent)) {
            $this->outputJson(['error' => 'no translation id\'s received']);
        }

        $data['content'] = 'not found';

        switch ($translation['type']) {
            case 'tmident':
                $data = $this->saveCMS($translation['ident'], $newContent);
                break;
            case 'tmtrans':
                $data = $this->saveMultilang($translation['ident'], $newContent);
                break;
            default:
                $data['error'] = 'translation-type is unknown. ';
        }

        $this->outputJson($data);
    }

    /**
     * Save the Content in der DB
     *
     * @param $ident
     * @param $newContent
     */
    public function saveCMS($ident, $newContent)
    {
        $oxContent = oxNew(oxContent::class);
        if (!$oxContent->loadByIdent($ident)) {
            ['error' => "Bitte lege diesen Snippet `{$ident}` selbst im Backen an."];
        }

        $oxContent->oxcontents__oxcontent->setValue($newContent, Field::T_RAW);
        $oxContent->oxcontents__oxactive->setValue(1, Field::T_RAW);
        $oxContent->save();

        return ['content' => "CMS-Snippet {$ident} wurde erfolgreich aktualisiert"];
    }

    /**
     * @param $ident
     * @param $newContent
     *
     * @return array
     */
    public function saveMultilang($ident, $newContent)
    {
        $identFinder = new IdentFinder();
        $langFile = $identFinder->getLangFile($ident);

        try {
            $langFile->write($ident, $newContent);
        } catch (\Exception $exception ) {
            return ['error' => 'Can\'t be saved: ' . $exception->getMessage()];
        }

        ClearCache::languageFiles();

        return ['content' => "Übersetzung wurde erfolgreich gespeichert."];
    }

    /**
     * @param $data
     */
    protected function outputJson($data)
    {
        /** @var oxOutput $oxoutput */
        $oxoutput = oxNew(oxOutput::class);
        $oxoutput->setCharset($this->getCharSet());
        $oxoutput->setOutputFormat(oxOutput::OUTPUT_FORMAT_JSON);
        $oxoutput->sendHeaders();
        $oxoutput->output('content', $data['content']);
        $oxoutput->output('error',  $data['error']);
        $oxoutput->flushOutput();

        oxRegistry::getUtils()->showMessageAndExit('');
    }
}
