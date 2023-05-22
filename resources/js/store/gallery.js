const state = {
    galleryHintMessagesInLibrary: null,
    galleryHintMessagesInFolder: null,
}
const getters = {

}

const mutations = {
    setGalleryHintMessagesLibrary(state, messages) {
        state.galleryHintMessagesInLibrary = messages;
    },
    setGalleryHintMessagesFolder(state, messages) {
        state.galleryHintMessagesInFolder = messages;
    },
};

const actions = {
    setGalleryHintMessagesLibrary(context, messages) {
        context.commit('setGalleryHintMessagesLibrary', messages);
    },
    setGalleryHintMessagesFolder(context, messages) {
        context.commit('setGalleryHintMessagesFolder', messages);
    },
};

export default {
    namespaced: true, // 名前空間を有効にする
    state,
    getters,
    mutations,
    actions
}