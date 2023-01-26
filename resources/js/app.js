import 'vuetify/dist/vuetify.min.css'
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import vuetify from './vuetify'
import vuex from './store/index'
import { createApp } from 'vue'
import App from './components/App'
import router from "./router";
import dayjs from 'dayjs'
import 'dayjs/locale/ja'
import AxiosPlugin from './plugins/axios_plugin';
import Vue3EasyDataTable from 'vue3-easy-data-table';
import 'vue3-easy-data-table/dist/style.css';

// ロケール設定
dayjs.locale('ja')

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
app.use(vuetify);
app.use(AxiosPlugin);
app.provide('dayjs', dayjs);
app.component('EasyDataTable', Vue3EasyDataTable);
app.mount('#app');

// adobefont追加（源ノ角ゴシック）
(function(d) {
    var config = {
        kitId: 'zoc8wgl',
        scriptTimeout: 3000,
        async: true
    },
    h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='https://use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
})(document);