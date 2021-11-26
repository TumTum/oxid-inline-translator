(()=>{"use strict";var a,t={557:()=>{function a(a,t){for(var e=0;e<t.length;e++){var n=t[e];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(a,n.key,n)}}const t=function(){function t(){!function(a,t){if(!(a instanceof t))throw new TypeError("Cannot call a class as a function")}(this,t);var a=this;a.modal=$("#tmTransModal"),a.trans={data:{},text:""},a.ajax_url="/index.php?cl=tmTranslator&fnc=",a.modal.title=a.modal.find("#tmTransModalLabel"),a.modal.orginal=a.modal.find("#tmTransModalOrginal"),a.modal.orginalPreview=a.modal.find("#tmTransOrginalPreview"),a.modal.translated=a.modal.find("#tmTransModalTranslated"),a.modal.alert_msg=a.modal.find("#error"),a.modal.alert_success=a.modal.find("#success"),a.modal.alerts=a.modal.find(".alert"),a.modal.btn_edit=a.modal.find(".jsedit"),a.modal.btn_preview=a.modal.find(".jspreview"),a.modal.preview_area=a.modal.find(".preview"),a.modal.on("show.bs.modal",(function(t){return a._initModal(t)})),a.modal.find("#tmTransSaveButton").click((function(t){return a._sendForm(t)})),a.modal.btn_edit.click((function(t){return a._editorMode(t)})),a.modal.btn_preview.click((function(t){return a._previewMode(t)}))}var e,n,o;return e=t,(n=[{key:"showModal",value:function(a){var t=$(a);this.trans.text=t.html(),this.trans.data=t.data(),this.modal.modal("show")}},{key:"_initModal",value:function(a){var t="CMS-Seiten";"tmtrans"===this.trans.data.type&&(t="Datei"),this.modal.title.html("<samp>type: <code>"+t+"</code> id: <code>"+this.trans.data.ident+"</code></samp>"),this.modal.orginal.show().val("").attr("placeholder","... laden ..."),this.modal.translated.show().val("").attr("placeholder","... laden ...").attr("readonly","readonly"),this.modal.alerts.hide().html(""),this.modal.preview_area.hide().html(""),this.__activeButton(this.modal.btn_edit),this._loadOrginalText()}},{key:"_loadOrginalText",value:function(){var a=this,t={translation:this.trans.data};$.post(this.ajax_url+"getOrginal",t).done((function(t){a.__ajaxShowCode(t)})).fail((function(t){a.__ajaxShowFaild(t)}))}},{key:"_sendForm",value:function(a){var t=this,e={translation:this.trans.data,newcontent:this.modal.translated.val()};$.post(this.ajax_url+"saveTranslatedContent",e).done((function(a){t.__ajaxDataSaved(a)})).fail((function(a){t.__ajaxShowFaild(a)}))}},{key:"_showError",value:function(a){this.modal.alert_msg.html("Error: "+a).fadeIn()}},{key:"_showSuccess",value:function(a,t){this.modal.alert_success.html(a).fadeIn({complete:t})}},{key:"_previewMode",value:function(a){a.preventDefault();var t=$(a.toElement),e=t.data("textarea-for");if(void 0!==e){var n=this.modal[e],o=n.next();this.__activeButton(t),n.hide(),o.html(n.val()).show()}}},{key:"_editorMode",value:function(a){a.preventDefault();var t=$(a.toElement),e=t.data("textarea-for"),n=this.modal[e],o=n.next();this.__activeButton(t),n.show(),o.html("").hide()}},{key:"__activeButton",value:function(a){a.parent().find(".btn").removeClass("active"),a.addClass("active")}},{key:"__ajaxDataSaved",value:function(a){a.error&&this._showError(a.error),a.content&&this._showSuccess(a.content,(function(){confirm("Soll diese Seite neu geladen werden?")&&window.location.reload(!1),this.modal.modal("hide")}))}},{key:"__ajaxShowCode",value:function(a){a.error&&this._showError("[loadOrginalText] "+a.error),this.modal.orginal.val(a.content.from),this.modal.translated.val(a.content.to).attr("readonly",null),this.modal.orginalPreview.click()}},{key:"__ajaxShowFaild",value:function(a){console.error(a),this._showError("[loadOrginalText] "+a)}}])&&a(e.prototype,n),o&&a(e,o),t}();function e(a,t){for(var e=0;e<t.length;e++){var n=t[e];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(a,n.key,n)}}const n=function(){function a(){!function(a,t){if(!(a instanceof t))throw new TypeError("Cannot call a class as a function")}(this,a)}var t,n,o;return t=a,(n=[{key:"modification",value:function(){var a=this;$("input").each((function(t,e){a.__findSpanInputs(t,e)}))}},{key:"__findSpanInputs",value:function(a,t){var e=void 0,n="";if(t.placeholder.match(/tmconv/)?(e=$(t.placeholder),n="placeholder"):t.value.match(/tmconv/)&&(e=$(t.value),n="value"),void 0!==e){var o=$(t);o.addClass(e.attr("class")),o.attr(n,e.html()),o.data(e.data())}}}])&&e(t.prototype,n),o&&e(t,o),a}();!function(a){var e=new t;(new n).modification(),a(".tmconv").click((function(a){if(!1===a.shiftKey)return a.preventDefault(),e.showModal(this),!1}))}(jQuery)},614:()=>{}},e={};function n(a){var o=e[a];if(void 0!==o)return o.exports;var r=e[a]={exports:{}};return t[a](r,r.exports,n),r.exports}n.m=t,a=[],n.O=(t,e,o,r)=>{if(!e){var i=1/0;for(c=0;c<a.length;c++){for(var[e,o,r]=a[c],l=!0,d=0;d<e.length;d++)(!1&r||i>=r)&&Object.keys(n.O).every((a=>n.O[a](e[d])))?e.splice(d--,1):(l=!1,r<i&&(i=r));if(l){a.splice(c--,1);var s=o();void 0!==s&&(t=s)}}return t}r=r||0;for(var c=a.length;c>0&&a[c-1][2]>r;c--)a[c]=a[c-1];a[c]=[e,o,r]},n.o=(a,t)=>Object.prototype.hasOwnProperty.call(a,t),(()=>{var a={631:0,769:0};n.O.j=t=>0===a[t];var t=(t,e)=>{var o,r,[i,l,d]=e,s=0;if(i.some((t=>0!==a[t]))){for(o in l)n.o(l,o)&&(n.m[o]=l[o]);if(d)var c=d(n)}for(t&&t(e);s<i.length;s++)r=i[s],n.o(a,r)&&a[r]&&a[r][0](),a[i[s]]=0;return n.O(c)},e=self.webpackChunk_tm_inlinetranslator=self.webpackChunk_tm_inlinetranslator||[];e.forEach(t.bind(null,0)),e.push=t.bind(null,e.push.bind(e))})(),n.O(void 0,[769],(()=>n(557)));var o=n.O(void 0,[769],(()=>n(614)));o=n.O(o)})();