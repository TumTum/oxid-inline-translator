<!-- Tranlate Modal -->
<div class="modal fade" id="tmTransModal" tabindex="-1" role="dialog" aria-labelledby="tmTransModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <samp>
                        `<abbr title="Die Basis Sprache">[{$oViewConf->tmTranslatorConfigFrom()|@strtoupper}]</abbr> /
                        <abbr title="In dieser Sprache werden die übersetzungen abgespeichert">[{$oViewConf->tmTranslatorConfigTo()|@strtoupper}]</abbr>`
                        aktuell <abbr title="Der Shop zeigt dir diese Sprache an.">`[{$oViewConf->getActLanguageAbbr()|@strtoupper}]`</abbr>
                    </samp>
                    <span id="tmTransModalLabel">Loberon Translator</span>
                </h4>
            </div>
            <div class="modal-body">
                <div id="error" class="alert alert-danger" role="alert" >...</div>
                <form>
                    <div class="form-group">
                        <label class="control-label" for="tmTransModalOrginal">Orginal:</label>

                        <div class="btn-group btn-group-xs" role="group" aria-labelledby="btn-orginal">
                            <button class="btn btn-default jseditor jsedit active" data-textarea-for="orginal">Code</button>
                            <button id="tmTransOrginalPreview" class="btn btn-default jseditor jspreview" data-textarea-for="orginal">Vorschau</button>
                        </div>
                        <textarea class="form-control" id="tmTransModalOrginal" readonly="readonly"></textarea>
                        <div class="preview"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="tmTransModalTranslated" >&Uuml;bersetzung:</label>
                        <div class="btn-group btn-group-xs" role="group" aria-labelledby="btn-translated">
                            <button class="btn btn-default jseditor jsedit active" data-textarea-for="translated">Editor</button>
                            <button class="btn btn-default jseditor jspreview" data-textarea-for="translated">Vorschau</button>
                        </div>
                        <textarea id='tmTransModalTranslated' class="form-control" name="tmTransModalTranslated"></textarea>
                        <div class="preview"></div>
                    </div>
                </form>
                <div id="success" class="alert alert-success" role="alert" >...</div>
            </div>
            <div class="modal-footer">
                <div class="tip">
                    <small><kbd><kbd>Shift</kbd> + <kbd>Maus-Klick</kbd></kbd> führt die Urspungs Aktion aus. Ohne dieses Fenster zu öffnen.</small>
                </div>
                <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
                <button type="button" class="btn btn-primary" id="tmTransSaveButton">Sichern</button>
            </div>
        </div>
    </div>
</div>

[{$smarty.block.parent}]
