import axios from "../axios"

const state = {
    users: null,
    deleteUserId: "",
    userInfo: null,
    endUserErrorMessages: null,
    displayLimit: 10,
    displayPage: 1,
}
const getters = {
    getUsers: (state) => {
        return state.users;
    },
    getUserInfo: (state) => {
        return state.userInfo;
    },
    displayLimit: (state) => state.displayLimit,
    displayPage: (state) => state.displayPage,
    //    getUserById: (state) => (id) => {
    //        const user = state.users.find((user) => {
    //            return user.id == id
    //        });
    //        if (user) {
    //            return user;
    //        } else {
    //            return null;
    //        }
    //    }
}
const actions = {
    fetchUsers(context) {
        axios.get('/api/enduser').then((res) => {
            context.commit('setUsers', res.data.users);
        })
    },
    setDisplayLimit(context, count) {
        context.commit('setDisplayLimit', count);
    },
    setDisplayPage(context, page) {
        context.commit('setDisplayPage', page);
    },
    setDeleteUserId(context, deleteUserId) {
        context.commit('setDeleteUserId', deleteUserId);
    },
    async getUserById(context, id) {
        const res = await axios.get('/api/enduser/' + id);
        return res.data;
    },
    async getUserInfo(context) {
        const res = await axios.get('/api/loginuserinfo')
        context.commit('setUserInfo', res.data.userInfo);

        const userInfo = res.data.userInfo[0];
        let response = {};
        if (userInfo) {
            response['name'] = userInfo.name;
            return response;
        } else {
            return null;
        };
    },
    setEndUserErrorMessages(context, messages) {
        context.commit('setEndUserErrorMessages', messages)
    },
}
const mutations = {
    setUsers(state, users) {
        state.users = users;
    },
    setDeleteUserId(state, deleteUserId) {
        state.deleteUserId = deleteUserId;
    },
    setUserInfo(state, userInfo) {
        state.userInfo = userInfo;
    },
    setEndUserErrorMessages(state, messages) {
        state.endUserErrorMessages = messages;
    },
    setDisplayLimit(state, count) {
        state.displayLimit = count;
    },
    setDisplayPage(state, page) {
        state.displayPage = page;
    },
    
}

export default {
    namespaced: true, // 名前空間を有効にする
    state,
    getters,
    mutations,
    actions
}