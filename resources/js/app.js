import 'vuetify/dist/vuetify.min.css'
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import vuetify from './vuetify'
import vuex from './store/index'
import { createApp } from 'vue'
import App from './components/app'

import router from "./router";
import store from './store'

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

const app = createApp({
    components: {
        App
    }
});
app.use(router);
app.use(vuex);
app.use(vuetify)
app.mount('#app');