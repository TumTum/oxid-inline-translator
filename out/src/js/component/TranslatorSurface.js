/**
 * Input Felder oder Title haben den Span drinnen und sollten entfernt werden
 */
class TranslatorSurface {

    constructor() {
    }

    modification() {
        $('input').each((findex, fitem) => {this.__findSpanInputs(findex, fitem);});
    }

    __findSpanInputs(fIndex, fItem) {
        var span = undefined,
            attribute = '';

        if (fItem.placeholder.match(/tmconv/)) {
            span = $(fItem.placeholder);
            attribute = 'placeholder'
        } else if(fItem.value.match(/tmconv/)) {
            span = $(fItem.value);
            attribute = 'value'
        }

        if (span !== undefined) {
            var input = $(fItem);
            input.addClass(span.attr('class'));
            input.attr(attribute, span.html());
            input.data(span.data());
        }
    };
}

export default TranslatorSurface
