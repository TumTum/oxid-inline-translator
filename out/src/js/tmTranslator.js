'use strict';

import Translator from './component/Translator';
import TranslatorSurface from './component/TranslatorSurface';

(function($) {
    const tmTrans   = new Translator(),
          tmSurface = new TranslatorSurface()

    tmSurface.modification();

    $('.tmconv').click(function (event) {
        if (event.shiftKey === false) {
            event.preventDefault();
            tmTrans.showModal(this);
            return false;
        }
    });
})(jQuery);
