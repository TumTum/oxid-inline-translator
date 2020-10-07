<?php

namespace tm\InlineTranslator\Lib\Language\PhpParser;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

/**
 * Class LangArray
 *
 * Verändert die aLang Variable
 *
 * @package tm\InlineTranslator\Lib\Language\PhpParser
 */
class LangArray extends NodeVisitorAbstract
{
    /**
     * @var bool
     */
    protected $isLangArray = false;

    /**
     * @var bool
     */
    protected $isSuccessChanged = false;

    /**
     * @var string
     */
    protected $findKey = '';

    /**
     * @var string
     */
    protected $replaceValue = '';


    /**
     * LangArray constructor.
     *
     * @param $key
     * @param $value
     */
    public function __construct($key, $value)
    {
        $this->findKey   = $key;
        $this->replaceValue = $value;
    }


    /**
     * Sucht die Verknüfung aLang und
     * dann sucht es nach dem Array Item
     *
     * @param Node $node
     * @return int|null|Node|void
     */
    public function enterNode(Node $node)
    {
        if ($this->isLangArray && $node instanceof Node\Expr\ArrayItem) {
            $this->replaceValueIfFounded($node);
        }
        if ($node instanceof Node\Expr\Assign && $node->var->name == "aLang") {
            $this->isLangArray = true;
        }
    }


    /**
     * Beim verlassen der aLang verkünpfung prüft ob überhaubt das
     * der die Value ersetzt wurde, wenn nicht fügt es eine neue hinzu.
     *
     * @param Node $node
     * @return false|int|null|Node|Node[]|void
     */
    public function leaveNode(Node $node)
    {
        if ($node instanceof Node\Expr\Assign && $node->var->name == "aLang") {
            if ($this->isSuccessChanged == false) {
                $this->createNewItem($node);
            }
            $this->reset();
        }
    }

    protected function reset()
    {
        $this->isLangArray      = false;
        $this->isSuccessChanged = false;
    }

    /**
     * @param Node $node
     */
    protected function createNewItem(Node $node)
    {
        $node->expr->items[] = new Node\Expr\ArrayItem(
            new Node\Scalar\String_($this->replaceValue),
            new Node\Scalar\String_($this->findKey)
        );
    }

    /**
     * @param Node $node
     */
    protected function replaceValueIfFounded(Node $node)
    {
        if ($node->key->value == $this->findKey) {
            $node->value->value = $this->replaceValue; // Change Value
            $this->isSuccessChanged = true;
        }
    }

}

