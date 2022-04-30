import Vuex from 'vuex';
import sidebar from './sidebar';

export default new Vuex.Store({
    modules: {
        sidebar: sidebar,
    }
});