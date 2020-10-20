<?php

$sMetadataVersion = '2.1';

$aModule = array(
    'id'            => 'tmInlineTranslator',
    'title'         => "Inline Translator",
    'description'   => 'OXID eShop Module Translate the Shop by click on text',
    'thumbnail'     => '',
    'version'       => '1.0',
    'author'        => 'Tobias Matthaiou',
    'url'           => 'http://www.tobimat.eu',
    'email'         => '225997+TumTum@users.noreply.github.com',

    'extend'        => [
        OxidEsales\Eshop\Core\Language::class             => \tm\InlineTranslator\Application\Core\Language::class,
        OxidEsales\Eshop\Core\Output::class               => \tm\InlineTranslator\Application\Core\Output::class,
        OxidEsales\Eshop\Core\Utils::class                => \tm\InlineTranslator\Application\Core\Utils::class,
        OxidEsales\Eshop\Core\ViewConfig::class           => \tm\InlineTranslator\Application\Core\ViewConfig::class,
        OxidEsales\Eshop\Application\Model\Content::class => \tm\InlineTranslator\Application\Model\Content::class
    ],
    'controllers'         => [
        'tmTranslator'  => \tm\InlineTranslator\Application\Controller\TranslatorController::class,
        'tmTranslateErrors'  => \tm\InlineTranslator\Application\Controller\TranslateErrorsController::class
    ],
    'templates'     => [
        'translate_errors_page.tpl' => 'tm/InlineTranslator/Application/views/tpl/translate_errors_page.tpl'
    ],
    'blocks'        => [
        [
            'template' => 'layout/base.tpl',
            'block'    => 'base_style',
            'file'     => 'Application/views/blocks/tmTrans_include_style.tpl',
        ],
        [
            'template' => 'layout/base.tpl',
            'block'    => 'base_js',
            'file'     => 'Application/views/blocks/tmTrans_include_js.tpl',
        ],
        [
            'template' => 'layout/footer.tpl',
            'block'    => 'footer_main',
            'file'     => 'Application/views/blocks/tmTrans_modal.tpl',
        ],
    ],
    'events'        => [
        'onActivate'      => '\tm\InlineTranslator\Helper\TranslatorInitEvents::onModuleActivation',
        'onDeactivate'    => '\tm\InlineTranslator\Helper\TranslatorInitEvents::onModuleDeactivation',
    ],
    'settings'      => [
        ['group' => 'MAIN', 'name' => 'tmTranslateFrom', 'type' => 'str',    'value' => 'de'],
        ['group' => 'MAIN', 'name' => 'tmTranslateTo',   'type' => 'str',    'value' => ''],
    ],
    'smartyPluginDirectories' => []
);
