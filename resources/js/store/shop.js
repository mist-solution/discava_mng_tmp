import axios from "../axios"

const state = {
    shops: null,
    shopusers: null,
}
const getters = {
    getShops: (state) => state.shops,
    getShopUsers: (state) => state.shopusers,
};
const actions = {
    async fetchShops(context) {
        await axios.get('/api/shops').then((res) => {
            context.commit('setShops', res.data.shops);
        });
    },
    async fetchShopUsers(context,id) {
        await axios.get('/api/shopusers'+ id).then((res) => {
            context.commit('setShopUsers', res.data.shopusers);
        });
    },
}
const mutations = {
    setShops(state, shops) {
        state.shops = shops;
    },
    setShopUsers(state, shopusers) {
        state.shopusers = shopusers;
    },
}

export default {
    namespaced: true, // 名前空間を有効にする
    state,
    getters,
    mutations,
    actions
}