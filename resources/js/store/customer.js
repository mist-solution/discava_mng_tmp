import axios from "../axios"

const state = {
    customers: null
 }
const getters = {
    getCustomers: (state) => {
        return state.customers;
    },
    getCustomerById: (state) => (id) => {
        const customer = state.customers.find((customer) => {
            return customer.id === id
        });
        if (customer) {
            return customer;
        } else {
            return null;
        }
    }
};
const actions = {
    fetchCustomers(context) {
        axios.get('/api/customer').then((res) => {
            context.commit('setCustomers', res.data.customers);
        })
    },
}
const mutations = {
    setCustomers(state, customers) {
        state.customers = customers;
    },
}

export default {
    namespaced: true, // 名前空間を有効にする
    state,
    getters,
    mutations,
    actions
}