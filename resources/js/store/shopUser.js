import axios from "../axios"

const state = {
    shopUsers: [],
    shopSelect: {},
}
const getters = {
    shopUsers: (state) => state.shopUsers,
    shopSelect: (state) => state.shopSelect,

    getShopSelectData: (state) => {
        const shopSelect = state.shopSelect.at(0);
        if (shopSelect) {
            return shopSelect;
        } else {
            return null;
        }
    },
};
const actions = {
    fetchShopUsers(context) {
        return axios.get('/api/shopusers').then((res) => {
            context.commit('setShopUsers', res.data.shopUsers);
        })
    },
    fetchShopSelect(context) {
        return axios.get('/api/shopselect').then((res) => {
            context.commit('setShopSelect', res.data.shopSelect);
        })
    },
}
const mutations = {
    setShopUsers(state, shopUsers) {
        state.shopUsers = shopUsers;
    },
    setShopSelect(state, select) {
        state.shopSelect = select;
    },
}

export default {
    namespaced: true, // 名前空間を有効にする
    state,
    getters,
    mutations,
    actions
}