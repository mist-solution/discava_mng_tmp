import axios from "../axios"

const state = {
    shopUsers: []
}
const getters = {
    getShopUsers: (state) => {
        return state.shopUsers;
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
}
const mutations = {
    setShopUsers(state, shopUsers) {
        state.shopUsers = shopUsers;
    },
}

export default {
    namespaced: true, // 名前空間を有効にする
    state,
    getters,
    mutations,
    actions
}