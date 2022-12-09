import { useRoute } from "vue-router";

const state = {
//    open: false,
    customer: null,
}
const getters = {
//    open: (state) => state.open,
    customer: (state) => state.customer,
}
const mutations = {
//    toggleOpen(state) {
//        state.open = !state.open;
//    },
    setCustomer(state, customer) {
        state.customer = customer;
    },
}
const actions = {
//    toggleOpen(context) {
//        context.commit('toggleOpen');
//    }
    async fetchCustomerBySession(context) {
        await axios.get('/api/customerSession').then((res) => {
            context.commit('setCustomer', res.data.customer);
        });
    },
}

export default {
    namespaced: true, // 名前空間を有効にする
    state,
    getters,
    mutations,
    actions
}