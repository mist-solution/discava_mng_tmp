import axios from "../axios"

const state = {
    users: null
 }
const getters = {
    getUsers: (state) => {
        return state.users;
    },
    getUserById: (state) => (id) => {
        const user = state.users.find((user) => {
            return user.id == id
        });
        if (user) {
            return user;
        } else {
            return null;
        }
    }
};
const actions = {
    fetchUsers(context) {
        axios.get('/api/enduser').then((res) => {
            context.commit('setUsers', res.data.users);
        })
    },
}
const mutations = {
    setUsers(state, users) {
        state.users = users;
    },
}

export default {
    namespaced: true, // 名前空間を有効にする
    state,
    getters,
    mutations,
    actions
}