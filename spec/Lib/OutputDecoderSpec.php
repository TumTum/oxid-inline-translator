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
        $actual = self::c('simple_tag.html');
        $expect = self::c('simple_tag_expect.html');

        $this->decode($actual)->shouldBe($expect);
    }

    public function it_can_convert_Quotes_singel()
    {
        $actual = self::c('Quotes_singel.html');
        $expect = self::c('Quotes_singel_expect.html');

        $this->decode($actual)->shouldBe($expect);
    }

    public function it_can_convert_Quotes_double()
    {
        $actual = self::c('Quotes_double.html');
        $expect = self::c('Quotes_double_expect.html');

        $this->decode($actual)->shouldBe($expect);
    }

    public function it_can_convert_is_admin_mode()
    {
        $actual = self::c('AdminMode.html');
        $expect = self::c('AdminMode_expect.html');

        $this->decode($actual)->shouldBe($expect);
    }

    public function it_can_double_tmtrans()
    {
        $actual = self::c('double_tags.html');
        $expect = self::c('double_tags_expect.html');

        $this->decode($actual)->shouldBe($expect);
    }

    private static function c($filename)
    {
        return trim(file_get_contents(__DIR__ . '/../clam/'.$filename));
    }
}
