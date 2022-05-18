import Vuex from 'vuex';
import sidebar from './sidebar';
import news from './news';
import enduser from './enduser';

export default new Vuex.Store({
    modules: {
        sidebar: sidebar,
        news: news,
        enduser: enduser,
    }
});