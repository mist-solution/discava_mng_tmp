const axios = require('axios');

const state = {
    users: null
 }
 const getters = {}
 const actions = {
    getUsers(context) {
        axios.get('api/enduser').then((res) => {
            context.commit('setUsers', res.data.users);
        })
    }
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