<?php

namespace spec\tm\InlineTranslator\Lib;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;


/**
 * Class OutputDecoderSpec
 * @package spec\tm\InlineTranslator\Lib
 * @mixin \tm\InlineTranslator\Lib\OutputDecoder
 */
class OutputDecoderSpec extends ObjectBehavior
{

    public function it_is_initializable()
    {
        $this->shouldHaveType(\tm\InlineTranslator\Lib\OutputDecoder::class);
    }

    public function it_can_decode_tmtrans()
    {
        $example = "<html><body>[tmtrans]DD_ERR_404_START_TEXT#2##VmllbGxlaWNodCBmaW5kZW4gU2llIGRpZSB2b24gSWhuZW4gZ2V3w7xuc2NodGVuIEluZm9ybWF0aW9uZW4gw7xiZXIgdW5zZXJlIFN0YXJ0c2VpdGU6[/tmtrans]</body>\t\n</html>";
        $ecepted = "<html><body><span class='tmconv' data-type='tmtrans' data-ident='DD_ERR_404_START_TEXT' data-lang='2' data-adminmode='0'>Vielleicht finden Sie die von Ihnen gewünschten Informationen über unsere Startseite:</span></body>\t\n</html>";

        $this->decode($example)->shouldBe($ecepted);
    }
}
