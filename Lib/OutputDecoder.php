<?php

namespace tm\InlineTranslator\Lib;

/**
 * Class OutputDecoder
 *
 * @package tm\InlineTranslator\Lib
 */
class OutputDecoder
{
    /**
     * @param $output
     *
     * @return string
     */
    public function decode($output)
    {
        $decodet_output = trim($output);
        $decodet_output = preg_replace_callback('~(.|\n|\r\n)?\[(tmtrans|tmident)\]([^/]+)\[/\2\]~', [$this, 'convertTag'], $decodet_output);

        if ($decodet_output === null) {
            $errorMsg = array_flip(get_defined_constants(true)['pcre'])[preg_last_error()];
            getLogger()->error(
                "Module-Error-InlineTranslator: incorrect output. preg_last_error: $errorMsg",
                ['package' => 'module_tm_InlineTranslator']
            );
            $decodet_output = $output;
        }

        return $decodet_output;
    }

    /**
     * Convert
     *
     * <tmtrans>{Ident}#{Lang}#{AdminMode}#{Translated}</tmtrans> to Span Tag
     * <tmident>{oxloadid}#{Lang}#{0}#{content}</tmident> to Div Tag
     *
     * @param $matches
     */
    private function convertTag($matches)
    {
        list($match, $context, $type, $content) = $matches;

        list($ident, $lang, $adminmode, $text) = explode('#', $content, 4);
        $adminmode = $adminmode ? '1' : '0';
        $text = base64_decode($text);

        $quote = $context == "'" ? '"' : "'";
        $block = $type == 'tmtrans' ? "span" : "div";

        $converted = $context .
            "<${block} " .
            "class=${quote}tmconv${quote} " .
            "data-type=${quote}${type}${quote} " .
            "data-ident=${quote}${ident}${quote} " .
            "data-lang=${quote}${lang}${quote} " .
            "data-adminmode=${quote}${adminmode}${quote}>" .
            $text .
            "</${block}>";


        return $converted;
    }
}
