import Vuex from 'vuex';
import sidebar from './sidebar';
import news from './news';
import enduser from './enduser';
import snackbar from './snackbar';

export default new Vuex.Store({
    modules: {
        sidebar: sidebar,
        news: news,
        enduser: enduser,
        snackbar: snackbar,
    }
});