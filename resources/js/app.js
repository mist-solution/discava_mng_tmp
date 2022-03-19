import 'vuetify/dist/vuetify.min.css'
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import { createApp } from 'vue'
import HeaderComponent from './components/HeaderComponent';
import ExampleComponent from './components/ExampleComponent'

import router from "./router";

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

const app = createApp({
    components: {
        ExampleComponent,
        HeaderComponent,
    }
});
app.use(router);
app.mount('#app')
