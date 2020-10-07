<?php

namespace spec\tm\InlineTranslator\Lib\Language\PhpParser;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use PhpParser\NodeVisitorAbstract;

class LangArraySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(\tm\InlineTranslator\Lib\Language\PhpParser\LangArray::class);
        $this->shouldHaveType(NodeVisitorAbstract::class);
    }

    public function let()
    {
        $this->beConstructedWith('KEY', 'VALUE');
    }
}
