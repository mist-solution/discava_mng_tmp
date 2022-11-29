import axios from "../axios"

const state = {
    shopUsers: [],
    shopSelect: {},
}
const getters = {
    getShopUsers: (state) => {
        return state.shopUsers;
    },
    getShopSelect: (state) => {
        return state.shopSelect;
    },
    getShopUserById: (state) => (id) => {
        const shopUser = state.shopUsers.find((shopUser) => {
            return shopUser.id === id
        });
        if (shopUser) {
            return shopUser;
        } else {
            return null;
        }
    }
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
    setShopSelect(state, shopSelect) {
        state.shopSelect = shopSelect;
    },
}

export default {
    namespaced: true, // 名前空間を有効にする
    state,
    getters,
    mutations,
    actions
}