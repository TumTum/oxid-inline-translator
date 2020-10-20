import Vue from 'vue';
import path from 'path';
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';

Vue.use(Vuetify);

const files = require.context('./vue/', true, /\.vue$/i);
files.keys().map(key => {
    const tagName = path.basename(key, '.vue');
    console.log(tagName);
    Vue.component(tagName, files(key).default)
});

let app = new Vue({
    el: '#translatoreditor',
    vuetify: new Vuetify(),
});


