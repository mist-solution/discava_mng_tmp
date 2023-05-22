const state = {
    galleryHintMessagesInLibrary: null,
    galleryHintMessagesInFolder: null,
}
const getters = {

}

const mutations = {
    setGalleryHintMessagesLibrary(state, messages) {
        state.galleryHintMessagesInLibrary = messages;
        console.log("galleryHintMessagesInLibrary 1")
        console.log(messages)
    },
    setGalleryHintMessagesFolder(state, messages) {
        state.galleryHintMessagesInFolder = messages;
        console.log("galleryHintMessagesInFolder 1")
        console.log(messages)
    },
};

const actions = {
    setGalleryHintMessagesLibrary(context, messages) {
        context.commit('setGalleryHintMessagesLibrary', messages);
        console.log("setGalleryHintMessagesLibrary 2")
        console.log(messages)
    },
    setGalleryHintMessagesFolder(context, messages) {
        context.commit('setGalleryHintMessagesFolder', messages);
        console.log("setGalleryHintMessagesFolder 2")
        console.log(messages)
    },
};

export default {
    namespaced: true, // 名前空間を有効にする
    state,
    getters,
    mutations,
    actions
}