const state = {
    displayLimit: 10,
    displaySort: "id",
    displayPage: 1,
    displayNewsStatus: 1,
    displayNewsAddAccount: "",
    displayCheckedItems: [],
    displaySearchAddDateBegin: "",
    displaySearchAddDateEnd: "",
    displaySearchUpdDateBegin: "",
    displaySearchUpdDateEnd: "",
    displaySearchNewsCol: "",
    displaySearchNews: "",
    displaySearchCategory: "",
    totalCount: 0,
}
const getters = {
    displayLimit: (state) => state.displayLimit,
    displaySort: (state) => state.displaySort,
    displayPage: (state) => state.displayPage,
    displayNewsStatus: (state) => state.displayNewsStatus,
    displayNewsAddAccount: (state) => state.displayNewsAddAccount,
    displayCheckedItems: (state) => state.displayCheckedItems,
    displaySearchAddDateBegin: (state) => state.displaySearchAddDateBegin,
    displaySearchAddDateEnd: (state) => state.displaySearchAddDateEnd,
    displaySearchUpdDateBegin: (state) => state.displaySearchUpdDateBegin,
    displaySearchUpdDateEnd: (state) => state.displaySearchUpdDateEnd,
    displaySearchNewsCol: (state) => state.displaySearchNewsCol,
    displaySearchNews: (state) => state.displaySearchNews,
    displaySearchCategory: (state) => state.displaySearchCategory,
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
    setDisplaySearchAddDateBegin(state, searchAddDateBegin) {
        state.displaySearchAddDateBegin = searchAddDateBegin;
    },
    setDisplaySearchAddDateEnd(state, searchAddDateEnd) {
        state.displaySearchAddDateEnd = searchAddDateEnd;
    },
    setDisplaySearchUpdDateBegin(state, searchUpddDateBegin) {
        state.displaySearchUpdDateBegin = searchUpddDateBegin;
    },
    setDisplaySearchUpdDateEnd(state, searchUpdDateEnd) {
        state.displaySearchUpdDateEnd = searchUpdDateEnd;
    },
    setDisplaySearchNewsCol(state, searchNewsCol) {
        state.displaySearchNewsCol = searchNewsCol;
    },
    setDisplaySearchNews(state, searchNews) {
        state.displaySearchNews = searchNews;
    },
    setDisplaySearchCategory(state, searchCategory) {
        state.displaySearchCategory = searchCategory;
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
    setDisplaySearchAddDateBegin(context, searchAddDateBegin) {
        context.commit('setDisplaySearchAddDateBegin', searchAddDateBegin);
    },
    setDisplaySearchAddDateEnd(context, searchAddDateEnd) {
        context.commit('setDisplaySearchAddDateEnd', searchAddDateEnd);
    },
    setDisplaySearchUpdDateBegin(context, searchUpdDateBegin) {
        context.commit('setDisplaySearchUpdDateBegin', searchUpdDateBegin);
    },
    setDisplaySearchUpdDateEnd(context, searchUpdDateEnd) {
        context.commit('setDisplaySearchUpdDateEnd', searchUpdDateEnd);
    },
    setDisplaySearchNewsCol(context, searchNewsCol) {
        context.commit('setDisplaySearchNewsCol', searchNewsCol);
    },
    setDisplaySearchNews(context, searchNews) {
        context.commit('setDisplaySearchNews', searchNews);
    },
    setDisplaySearchCategory(context, searchCategory) {
        context.commit('setDisplaySearchCategory', searchCategory);
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