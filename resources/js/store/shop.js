import axios from "../axios"

const state = {
    shops: null,
}
const getters = {
    getShops: (state) => state.shops,
};
const actions = {
    async fetchShops(context) {
        await axios.get('/api/shops').then((res) => {
            context.commit('setShops', res.data.shops);
        });
    },
}
const mutations = {
    setShops(state, shops) {
        state.shops = shops;
    },
}

export default {
    namespaced: true, // 名前空間を有効にする
    state,
    getters,
    mutations,
    actions
}