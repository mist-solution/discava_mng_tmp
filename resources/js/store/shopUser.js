import axios from "../axios"

const state = {
    shopUsers: null,
    shopSelect: null,
}
const getters = {
    shopUsers: (state) => state.shopUsers,
    shopSelect: (state) => state.shopSelect,

    // getShopSelectData: (state) => {
    //     const shopSelect = state.shopSelect.find(shop => true);
    //     if (shopSelect) {
    //         return shopSelect;
    //     } else {
    //         return null;
    //     }
    // },
};
const actions = {
    fetchShopUsers(context) {
        axios.get('/api/shopusers').then((res) => {
            context.commit('setShopUsers', res.data.shopUsers);
        });
        axios.get('/api/shopselect').then((res) => {
            context.commit('setShopSelect', res.data.shopSelect);
        });
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