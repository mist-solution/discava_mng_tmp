import axios from "../axios"

const state = {
    authoritySet: {},
    authoritySetDisplay: {}
 }
const getters = {
    getAuthoritySet: (state) => {
        return state.authoritySet;
    },
    getAuthoritySetDisplay: (state) => {
        return state.authoritySetDisplay;
    },
};
const actions = {
    async fetchAllAuthoritySet(context, id) {
        return await axios.get('/api/authoritySet').then((res) => {
            context.commit('setAuthoritySet', res.data.authoritySets);
        })
    },
    async fetchAllAuthoritySetDisplay(context, id) {
        return await axios.get('/api/authoritySet').then((res) => {
            context.commit('setAuthoritySetDisplay', res.data.authoritySets);
            state.authoritySetDisplay.push({ id: 'none', name: '該当なし'});
        })
    },
}

const mutations = {
    setAuthoritySet(state, authoritySet) {
        state.authoritySet = authoritySet;
    },
    setAuthoritySetDisplay(state, authoritySet) {
        state.authoritySetDisplay = authoritySet;
    },
}

export default {
    namespaced: true, // 名前空間を有効にする
    state,
    getters,
    mutations,
    actions
}