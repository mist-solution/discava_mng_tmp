import axios from "../axios"

const state = {
    users: null,
    deleteUserId: "",
}
const getters = {
    getUsers: (state) => {
        return state.users;
    },
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
    setDeleteUserId(context, deleteUserId) {
        context.commit('setDeleteUserId', deleteUserId);
    },
    async getUserById(context, id) {
        const res = await axios.get('/api/enduser/' + id);
        return res.data;
    },
}
const mutations = {
    setUsers(state, users) {
        state.users = users;
    },
    setDeleteUserId(state, deleteUserId) {
        state.deleteUserId = deleteUserId;
    },
}

export default {
    namespaced: true, // 名前空間を有効にする
    state,
    getters,
    mutations,
    actions
}