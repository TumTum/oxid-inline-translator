<?php

namespace spec\tm\InlineTranslator\Lib\Language;

use function foo\func;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class LangFileSpec
 * @package spec\tm\InlineTranslator\Lib\Language
 * @mixin \tm\InlineTranslator\Lib\Language\LangFile::class
 */
class LangFileSpec extends ObjectBehavior
{
    /**
     * @var vfsStreamDirectory
     */
    protected $vfilesytem = null;

    /**
     *
     */
    public function it_is_initializable()
    {
        $this->shouldHaveType(\tm\InlineTranslator\Lib\Language\LangFile::class);
    }

    /**
     *
     */
    private function _initVirtualFileSystem()
    {
        if ($this->vfilesytem !== null) {
            return;
        }
        $this->vfilesytem = vfsStream::setup('root', null,
            [
                'Application' => [
                    'translations' => [
                        'fr' => [
                            'lang.php' => '<?php $sLangName  = "Deutsch"; $aLang = ["charset" => "UTF-8", "HOME_HOUSE" => "Zuhause"];'
                        ]
                    ]
                ]
            ]);
    }

    public function let()
    {
        $this->_initVirtualFileSystem();

        $this->beConstructedWith([
            $this->vfilesytem->url() . '/Application/translations/fr/lang.php',
            $this->vfilesytem->url() . '/Application/views/flow/fr/cust_lang.php',
        ]);
    }

    public function it_has_create_new_file()
    {
        $this->init("Deutsch")->shouldExistsFile($this->vfilesytem->url() . '/Application/translations/fr/lang.php');
        $this->init("Deutsch")->shouldExistsFile($this->vfilesytem->url() . '/Application/views/flow/fr/cust_lang.php');
    }

    public function it_can_change_key()
    {
        $this->init("Deutsch");
        $this->write('HOME_HOUSE', 'In der Vila')->shouldFindContentIn('HOME_HOUSE', 'In der Vila', [
            $this->vfilesytem->url() . '/Application/translations/fr/lang.php',
            $this->vfilesytem->url() . '/Application/views/flow/fr/cust_lang.php'
        ]);
    }

    function getMatchers() : array
    {
        return [
            'existsFile'    => function ($mock, $url) { return file_exists($url); },
            'findContentIn' => function ($mock, $key, $value, $files) {
                $sLangName = null;
                $aLang = null;

                foreach ($files as $path) {
                    include $path;

                    if (!isset($aLang[$key])) {
                        throw new FailureException(sprintf(
                            'Key `%s` not found into %s',
                            $key, $path
                        ));
                    } elseif ($aLang[$key] != $value) {
                        throw new FailureException(sprintf(
                            'Expeced $%s=>\'%s\' but get  $%s=>`%s`',
                            $key, $value, $key, $aLang[$key]
                        ));
                    }
                }

                return true;
            }
        ];
    }
}
