const state = {
    galleryHintMessages: null,
}
const getters = {

}

const mutations = {
    setGalleryHintMessages(state, messages) {
        state.galleryHintMessages = messages;
    },
}
const actions = {
    setGalleryHintMessages(context, messages) {
        context.commit('setGalleryHintMessages', messages)
    },
}

export default {
    namespaced: true, // 名前空間を有効にする
    state,
    getters,
    mutations,
    actions
}