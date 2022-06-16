const state = {
    displayLimit: 10,
    displaySort: "id",
    displayPage: 1,
    displayNewsStatus: 1,
    displayNewsAddAccount: "",
    displayCheckedItems: [],
    totalCount: 0,
}
const getters = {
    displayLimit: (state) => state.displayLimit,
    displaySort: (state) => state.displaySort,
    displayPage: (state) => state.displayPage,
    displayNewsStatus: (state) => state.displayNewsStatus,
    displayNewsAddAccount: (state) => state.displayNewsAddAccount,
    displayCheckedItems: (state) => state.displayCheckedItems,
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
    setDisplayNewsStatus(state, newsStatus) {
        state.displayNewsStatus = newsStatus;
    },
    setDisplayNewsAddAccount(state, newsAddAccount) {
        state.displayNewsAddAccount = newsAddAccount;
    },
    setDisplayCheckedItems(state, checkedItems) {
        state.displayCheckedItems = checkedItems;
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
    setDisplayNewsStatus(context, newsStatus) {
        context.commit('setDisplayNewsStatus', newsStatus);
    },
    setDisplayNewsAddAccount(context, newsAddAccount) {
        context.commit('setDisplayNewsAddAccount', newsAddAccount);
    },
    setDisplayCheckedItems(context, checkedItems) {
        context.commit('setDisplayCheckedItems', checkedItems);
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