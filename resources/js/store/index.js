import Vuex from 'vuex';
import sidebar from './sidebar';
import enduser from './enduser';
import customer from './customer';
import announce from './announce';
import announceCategory from './announceCategory';
import snackbar from './snackbar';
import shopUser from './shopUser';
import authority from './authority';
import authoritySet from './authoritySet';
import shop from './shop';
import library from './library';
import gallery from './gallery';

export default new Vuex.Store({
    modules: {
        sidebar: sidebar,
        enduser: enduser,
        customer: customer,
        announce: announce,
        announceCategory: announceCategory,
        snackbar: snackbar,
        shopUser: shopUser,
        authority: authority,
        authoritySet: authoritySet,
        shop: shop,
        library: library,
        gallery: gallery,
    }
});