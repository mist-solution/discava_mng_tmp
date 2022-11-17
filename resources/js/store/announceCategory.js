import axios from "../axios"

const state = {
    categories: []
 }
const getters = {
    getCategories: (state) => {
        return state.categories;
    },
    getCategoryById: (state) => (id) => {
        const category = state.categories.find((category) => {
            return category.id === id
        });
        if (category) {
            return category;
        } else {
            return null;
        }
    }
};
const actions = {
    fetchCategories(context) {
        return axios.get('/api/announceCategory').then((res) => {
            context.commit('setCategories', res.data.announceCategories);
        })
    },
}
const mutations = {
    setCategories(state, categories) {
        state.categories = categories;
    },
}

export default {
    namespaced: true, // 名前空間を有効にする
    state,
    getters,
    mutations,
    actions
}