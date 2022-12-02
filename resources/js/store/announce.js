import axios from "../axios"

const state = {
    announce: {}
 }
const actions = {
    async getAnnounce(context, id) {
        const res = await axios.get('/api/announce/' + id);
        return res.data;
    },
}

export default {
    namespaced: true, // 名前空間を有効にする
    state,
    getters,
    mutations,
    actions
}