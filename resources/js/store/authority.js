import axios from "../axios"

const state = {
    authority: null
 }
const getters = {
    getAuthority: (state) => {
        return state.authority;
    },
};
const actions = {
    async fetchAllAuthority(context, id) {
        const res = await axios.get('/api/authority')
        context.commit('setAuthority', res.data.authority);
    
        const authority = res.data.authority[0];
        let response = {};
        if (authority) {
            response['authority_set_id'] = authority.authority_set_id;
            response['mate_function_id'] = authority.mate_function_id;
            response['function_auth_flg'] = authority.function_auth_flg;
            response['read_auth_flg'] = authority.read_auth_flg;
            response['update_auth_flg'] = authority.update_auth_flg;
            response['create_auth_flg'] = authority.create_auth_flg;
            response['delete_auth_flg'] = authority.delete_auth_flg;
            response['request_auth_flg'] = authority.request_auth_flg;
            response['approval_auth_flg'] = authority.approval_auth_flg;
            return response;
        } else {
            return null;
        };
    },
}

const mutations = {
    setAuthority(state, authority) {
        state.authority = authority;
    },
}

export default {
    namespaced: true, // 名前空間を有効にする
    state,
    getters,
    mutations,
    actions
}