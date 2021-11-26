import Vue from 'vue';
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';
import TranslateEditor from './vue/translateEditor'

Vue.use(Vuetify);

let app = new Vue({
    el: '#translatoreditor',
    components: {
        TranslateEditor
    },
    vuetify: new Vuetify(),
});


