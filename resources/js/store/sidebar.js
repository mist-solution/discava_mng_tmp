const state = {
    open: false,
}
const getters = {
    open: (state) => state.open,
}
const mutations = {
    toggleOpen(state) {
        state.open = !state.open;
    },
}
const actions = {
    toggleOpen(context) {
        context.commit('toggleOpen');
    }
}

export default {
    namespaced: true, // 名前空間を有効にする
    state,
    getters,
    mutations,
    actions
}