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
        return await axios.get('/api/authoritySet').then((res) => {
            context.commit('setAuthoritySet', res.data.authoritySets);
        })
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