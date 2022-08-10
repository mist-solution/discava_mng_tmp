import Vuex from 'vuex';
import sidebar from './sidebar';
import news from './news';
import enduser from './enduser';
import customer from './customer';
import announceCategory from './announceCategory';
import snackbar from './snackbar';

export default new Vuex.Store({
    modules: {
        sidebar: sidebar,
        news: news,
        enduser: enduser,
        customer: customer,
        announceCategory: announceCategory,
        snackbar: snackbar,
    }
});