const state = {
    displayLimit: 10,
    displaySort: "id",
    displayPage: 1,
    totalCount: 0,
}
const getters = {
    displayLimit: (state) => state.displayLimit,
    displaySort: (state) => state.displaySort,
    displayPage: (state) => state.displayPage,
    totalCount: (state) => state.totalCount,
}
const mutations = {
    setDisplayLimit(state, count) {
        state.displayLimit = count;
    },
    setDisplaySort(state, sort) {
        state.displaySort = sort;
    },
    setDisplayPage(state, page) {
        state.displayPage = page;
    },
    setTotalCount(state, count) {
        state.totalCount = count;
    },
}
const actions = {
    setDisplayLimit(context, count) {
        context.commit('setDisplayLimit', count);
    },
    setDisplaySort(context, sort) {
        context.commit('setDisplaySort', sort);
    },
    setDisplayPage(context, page) {
        context.commit('setDisplayPage', page);
    },
    setTotalCount(context, count) {
        context.commit('setTotalCount', count)
    }
}

export default {
    namespaced: true, // 名前空間を有効にする
    state,
    getters,
    mutations,
    actions
}