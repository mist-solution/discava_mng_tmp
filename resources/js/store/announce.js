const state = {
    announce: {},
    displayLimit: 10,
    displaySort: "id",
    displayPage: 1,
    displayAnnounceStatus: 1,
    displayAnnounceAddAccount: "",
    displayCheckedItems: [],
    displaySearchAddDateBegin: "",
    displaySearchAddDateEnd: "",
    displaySearchUpdDateBegin: "",
    displaySearchUpdDateEnd: "",
    displaySearchAnnounceCol: "",
    displaySearchAnnounce: "",
    displaySearchCategory: "",
    displayListsItemKey: "notCheckLists",
    deleteAnnounceId: "",
    approvalProcessKey: "",
    approvalAnnounceId: "",
    approvalAnnounceStatus: "",
    approvalReturnComment: "",
    totalCount: 0,
}
const getters = {
    getAnnounce: (state) => {
        return state.announce;
    },
    displayLimit: (state) => state.displayLimit,
    displaySort: (state) => state.displaySort,
    displayPage: (state) => state.displayPage,
    displayAnnounceStatus: (state) => state.displayAnnounceStatus,
    displayAnnounceAddAccount: (state) => state.displayAnnounceAddAccount,
    displayCheckedItems: (state) => state.displayCheckedItems,
    displaySearchAddDateBegin: (state) => state.displaySearchAddDateBegin,
    displaySearchAddDateEnd: (state) => state.displaySearchAddDateEnd,
    displaySearchUpdDateBegin: (state) => state.displaySearchUpdDateBegin,
    displaySearchUpdDateEnd: (state) => state.displaySearchUpdDateEnd,
    displaySearchAnnounceCol: (state) => state.displaySearchAnnounceCol,
    displaySearchAnnounce: (state) => state.displaySearchAnnounce,
    displaySearchCategory: (state) => state.displaySearchCategory,
    displayListsItemKey: (state) => state.displayListsItemKey,
    deleteAnnounceId: (state) => state.deleteAnnounceId,
    approvalProcessKey: (state) => state.approvalProcessKey,
    approvalAnnounceId: (state) => state.approvalAnnounceId,
    approvalAnnounceStatus: (state) => state.approvalAnnounceStatus,
    approvalReturnComment: (state) => state.approvalReturnComment,
    totalCount: (state) => state.totalCount,
}

const mutations = {
    setAnnounce(state, announce) {
        state.announce = announce;
    },
    setDisplayLimit(state, count) {
        state.displayLimit = count;
    },
    setDisplaySort(state, sort) {
        state.displaySort = sort;
    },
    setDisplayPage(state, page) {
        state.displayPage = page;
    },
    setDisplayAnnounceStatus(state, announceStatus) {
        state.displayAnnounceStatus = announceStatus;
    },
    setDisplayAnnounceAddAccount(state, announceAddAccount) {
        state.displayAnnounceAddAccount = announceAddAccount;
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
    setDisplaySearchAnnounceCol(state, searchAnnounceCol) {
        state.displaySearchAnnounceCol = searchAnnounceCol;
    },
    setDisplaySearchAnnounce(state, searchAnnounce) {
        state.displaySearchAnnounce = searchAnnounce;
    },
    setDisplaySearchCategory(state, searchCategory) {
        state.displaySearchCategory = searchCategory;
    },
    setDisplayListsItemKey(state, listsItemKey) {
        state.displayListsItemKey = listsItemKey;
    },
    setDeleteAnnounceId(state, deleteAnnounceId) {
        state.deleteAnnounceId = deleteAnnounceId;
    },
    setApprovalProcessKey(state, approvalProcessKey) {
        state.approvalProcessKey = approvalProcessKey;
    },
    setApprovalAnnounceId(state, approvalAnnounceId) {
        state.approvalAnnounceId = approvalAnnounceId;
    },
    setApprovalAnnounceStatus(state, approvalAnnounceStatus) {
        state.approvalAnnounceStatus = approvalAnnounceStatus;
    },
    setApprovalReturnComment(state, approvalReturnComment) {
        state.approvalReturnComment = approvalReturnComment;
    },
    setTotalCount(state, count) {
        state.totalCount = count;
    },
}
const actions = {
    async getAnnounce(context, id) {
        const res = await axios.get('/api/announce/' + id);
        return res.data;
    },
    setDisplayLimit(context, count) {
        context.commit('setDisplayLimit', count);
    },
    setDisplaySort(context, sort) {
        context.commit('setDisplaySort', sort);
    },
    setDisplayPage(context, page) {
        context.commit('setDisplayPage', page);
    },
    setDisplayAnnounceStatus(context, announceStatus) {
        context.commit('setDisplayAnnounceStatus', announceStatus);
    },
    setDisplayAnnounceAddAccount(context, announceAddAccount) {
        context.commit('setDisplayAnnounceAddAccount', announceAddAccount);
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
    setDisplaySearchAnnounceCol(context, searchAnnounceCol) {
        context.commit('setDisplaySearchAnnounceCol', searchAnnounceCol);
    },
    setDisplaySearchAnnounce(context, searchAnnounce) {
        context.commit('setDisplaySearchAnnounce', searchAnnounce);
    },
    setDisplaySearchCategory(context, searchCategory) {
        context.commit('setDisplaySearchCategory', searchCategory);
    },
    setDisplayListsItemKey(context, listsItemKey) {
        context.commit('setDisplayListsItemKey', listsItemKey);
    },
    setDeleteAnnounceId(context, deleteAnnounceId) {
        context.commit('setDeleteAnnounceId', deleteAnnounceId);
    },
    setApprovalProcessKey(context, approvalProcessKey) {
        context.commit('setApprovalProcessKey', approvalProcessKey);
    },
    setApprovalAnnounceId(context, approvalAnnounceId) {
        context.commit('setApprovalAnnounceId', approvalAnnounceId);
    },
    setApprovalAnnounceStatus(context, approvalAnnounceStatus) {
        context.commit('setApprovalAnnounceStatus', approvalAnnounceStatus);
    },
    setApprovalReturnComment(context, approvalReturnComment) {
        context.commit('setApprovalReturnComment', approvalReturnComment);
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