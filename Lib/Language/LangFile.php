<?php

namespace tm\InlineTranslator\Lib\Language;

use tm\InlineTranslator\Lib\Language\PhpParser\LangArray;
use PhpParser\Error;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter;
use PhpParser\NodeTraverser;

class LangFile
{
    /**
     * @var array
     */
    protected $files;

    /**
     * LangFile constructor.
     * @param array $files
     */
    public function __construct($files)
    {
        $this->files = $files;
    }

    /**
     * Erstellt neue Language Dateien wenn nötig
     *
     * @param string $language die Sprache in der die Datei erstellt werden soll.
     */
    public function init($language)
    {
        foreach ($this->files as $path) {
            if (file_exists($path)) {
                continue;
            }

            $dirname = dirname($path);
            if (!file_exists($dirname)) {
                mkdir($dirname, 0755, true);
            }

            $new_content = file_get_contents(__DIR__ . '/Templates/oxid_lang.tmplate.php');
            file_put_contents($path, str_replace('%LANGUAGE_NAME%', $language, $new_content));
        }
    }

    /**
     * Verändert die Language dateien
     *
     * @param string $key
     * @param string $value
     */
    public function write($key, $value)
    {
        $prettyPrinter = new PrettyPrinter\Standard();
        $nodeTraverser = new NodeTraverser();
        $nodeTraverser->addVisitor(new LangArray($key, $value));

        foreach ($this->files as $path) {
            $ast = $this->createAST($path);

            $nodeTraverser->traverse($ast);

            $content = $prettyPrinter->prettyPrintFile($ast);
            file_put_contents($path, $content);
        }
    }

    /**
     * @param $filename
     */
    protected function createAST($filename)
    {
        $parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);
        try {
            $content = $parser->parse(file_get_contents($filename));
        } catch (Error $e) {
            throw new Error($filename .': '.$e->getMessage(), $e->getAttributes());
        }

        return $content;
    }
}
