const state = {
    snackbar: false,
    text: '',
    color: '',
    timeout: '1500',
}

const mutations = {
    setSuccess: (state, text) => {
        state.snackbar = true;
        state.text = text;
        state.color = "success"
    },
    setSuccessWithTime: (state, { text, timeout }) => {
        state.snackbar = true;
        state.text = text;
        state.color = "success";
        state.timeout = timeout;
    },
    setWarning: (state, text) => {
        state.snackbar = true;
        state.text = text;
        state.color = "warn"
    },
    setError: (state, text) => {
        state.snackbar = true;
        state.text = text;
        state.color = "error"
    },
    unsetSnackbar: () => {
        state.snackbar = false;
        state.text = "";
    },
}

const actions = {
    openSuccess: ({ commit }, text) => {
        commit("setSuccess", text);
    },
    openSuccessWithTime: ({ commit }, { text, timeout }) => {
        commit("setSuccessWithTime", { text, timeout });
    },
    openWarning: ({ commit }, text) => {
        commit("setWarning", text);
    },
    openError: ({ commit }, text) => {
        commit("setError", text);
    },
    closeSnackbar: ({ commit }) => {
        commit("unsetSnackbar");
    },
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
}
