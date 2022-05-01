import Vuex from 'vuex';
import sidebar from './sidebar';
import news from './news';

export default new Vuex.Store({
    modules: {
        sidebar: sidebar,
        news: news,
    }
});