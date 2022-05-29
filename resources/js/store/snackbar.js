const state = {
    snackbar: false,
    text: '',
    color: ''
}

const mutations = {
    setSuccess: (state, text) => {
        state.snackbar = true;
        state.text = text;
        state.color = "success"
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
