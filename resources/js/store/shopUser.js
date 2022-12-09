import axios from "../axios"

const state = {
    shopUsers: null,
    shopSelect: null,
}
const getters = {
    shopUsers: (state) => state.shopUsers,
    shopSelect: (state) => state.shopSelect,
};
const actions = {
    async fetchShopUsers(context) {
        await axios.get('/api/shopusers').then((res) => {
            context.commit('setShopUsers', res.data.shopUsers);
        });
    },
    async fetchShopUsersWithLogout(context) {
        await axios.get('/api/shopusers').then((res) => {
            context.commit('setShopUsers', res.data.shopUsers);
            state.shopUsers.push({ shop_id: 'logout', shop_name: 'ログアウト'});
        });
    },
    async getShopSelection(context){
        const res = await axios.get('/api/shopselect');
        context.commit('setShopSelect', res.data.shopSelect);

        const shopSelect = res.data.shopSelect[0];
        let response = {};
        if (shopSelect) {
            response['shop_id'] = shopSelect.shop_id;
            response['shop_name'] = shopSelect.shop_name;
            return response;
        } else {
            return null;
        };

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