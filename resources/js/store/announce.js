import axios from "../axios"

const state = {
    announce: {}
 }
const getters = {
    getAnnounce: (state) => {
        return state.announce;
    },
};
const actions = {
    async getAnnounce(context, id) {
        const res = await axios.get('/api/announce/' + id);
        return res.data;
    },
}

const mutations = {
    setAnnounce(state, announce) {
        state.announce = announce;
    },
}

export default {
    namespaced: true, // 名前空間を有効にする
    state,
    getters,
    mutations,
    actions
}