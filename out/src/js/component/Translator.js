class Translator {

    constructor() {
        let self = this;
        self.modal = $('#tmTransModal');
        self.trans = {data: {}, text: ''};
        self.ajax_url = '/index.php?cl=tmTranslator&fnc=';

        self.modal.title = self.modal.find('#tmTransModalLabel');
        self.modal.orginal = self.modal.find('#tmTransModalOrginal');
        self.modal.orginalPreview = self.modal.find('#tmTransOrginalPreview');
        self.modal.translated = self.modal.find('#tmTransModalTranslated');
        self.modal.alert_msg = self.modal.find('#error');
        self.modal.alert_success = self.modal.find('#success');
        self.modal.alerts = self.modal.find('.alert');
        self.modal.btn_edit = self.modal.find('.jsedit');
        self.modal.btn_preview = self.modal.find('.jspreview');
        self.modal.preview_area = self.modal.find('.preview');

        self.modal.on('show.bs.modal', (event) => self._initModal(event));
        self.modal.find('#tmTransSaveButton').click((event) => self._sendForm(event));
        self.modal.btn_edit.click((event) => self._editorMode(event));
        self.modal.btn_preview.click((event) => self._previewMode(event));
    }

    showModal(fElement) {
        let element = $(fElement);
        this.trans.text = element.html();
        this.trans.data = element.data();

        this.modal.modal('show');
    }

    _initModal(event) {
        var type = 'CMS-Seiten';
        if (this.trans.data.type === 'tmtrans') {
            type = 'Datei'
        }

        this.modal.title.html('<samp>type: <code>' + type + '</code> id: <code>' + this.trans.data.ident + '</code></samp>');
        this.modal.orginal.show().val('').attr('placeholder', '... laden ...');
        this.modal.translated.show().val('').attr('placeholder', '... laden ...').attr('readonly', 'readonly');
        this.modal.alerts.hide().html('');
        this.modal.preview_area.hide().html('');

        this.__activeButton(this.modal.btn_edit);

        this._loadOrginalText();
    }

    _loadOrginalText() {
        var form = {translation: this.trans.data};
        $.post(this.ajax_url + 'getOrginal', form)
            .done((data) => {
                this.__ajaxShowCode(data)
            })
            .fail((data) => {
                this.__ajaxShowFaild(data)
            })
    }

    _sendForm(event) {
        var form = {
            translation: this.trans.data,
            newcontent: this.modal.translated.val()
        };
        $.post(this.ajax_url + 'saveTranslatedContent', form)
            .done((data) => {
                this.__ajaxDataSaved(data)
            })
            .fail((data) => {
                this.__ajaxShowFaild(data)
            })
    }

    _showError(msg) {
        this.modal.alert_msg.html('Error: ' + msg).fadeIn();
    }

    _showSuccess(msg, callback) {
        this.modal.alert_success.html(msg).fadeIn({complete: callback});
    }

    _previewMode(event) {
        event.preventDefault();

        var button = $(event.toElement),
            target = button.data('textarea-for');

        if (target === undefined) {
            return ;
        }

        let textarea = this.modal[target],
            preview = textarea.next()
        ;

        this.__activeButton(button);

        textarea.hide();
        preview.html(textarea.val()).show();
    }

    _editorMode(event) {
        event.preventDefault();
        var button = $(event.toElement),
            target = button.data('textarea-for'),
            textarea = this.modal[target],
            preview = textarea.next()
        ;

        this.__activeButton(button);

        textarea.show();
        preview.html('').hide();
    }

    __activeButton(button) {
        button.parent().find('.btn').removeClass('active');
        button.addClass('active');
    }

    __ajaxDataSaved(data) {
        if (data.error) {
            this._showError(data.error);
        }
        if (data.content) {
            this._showSuccess(data.content, function () {
                if (confirm('Soll diese Seite neu geladen werden?')) {
                    window.location.reload(false);
                }
                this.modal.modal("hide");
            });

        }
    }

    __ajaxShowCode(data) {
        if (data.error) {
            this._showError('[loadOrginalText] ' + data.error);
        }
        this.modal.orginal.val(data.content.from);
        this.modal.translated.val(data.content.to).attr('readonly', null);
        this.modal.orginalPreview.click();
    }

    __ajaxShowFaild(data) {
        console.error(data);
        this._showError('[loadOrginalText] ' + data);
    }
}

export default Translator
