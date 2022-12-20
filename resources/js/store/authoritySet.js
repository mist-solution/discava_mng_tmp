import axios from "../axios"

const state = {
    authoritySet: {}
 }
const getters = {
    getAuthoritySet: (state) => {
        return state.authoritySet;
    },
};
const actions = {
    async fetchAllAuthoritySet(context, id) {
        const res = await axios.get('/api/authoritySet/');
        return res.data;
    },
}

const mutations = {
    setAuthoritySet(state, authoritySet) {
        state.authoritySet = authoritySet;
    },
}

export default {
    namespaced: true, // 名前空間を有効にする
    state,
    getters,
    mutations,
    actions
}