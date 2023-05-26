const state = {
    galleryHintMessagesInLibrary: null,
    galleryHintMessagesInFolder: null,
    galleryCreate: null,
    galleryDelete: null,
    galleryMove: null,
    galleryMove2: null,
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
    setGalleryCreate(state, messages) {
        state.galleryCreate = messages;
    },
    setGalleryDelete(state, messages) {
        state.galleryDelete = messages;
    },
    setGalleryMove(state, messages) {
        state.galleryMove = messages;
    },
    setGalleryMove2(state, messages) {
        state.galleryMove2 = messages;
    }
};

const actions = {
    setGalleryHintMessagesLibrary(context, messages) {
        context.commit('setGalleryHintMessagesLibrary', messages);
    },
    setGalleryHintMessagesFolder(context, messages) {
        context.commit('setGalleryHintMessagesFolder', messages);
    },
    setGalleryCreate(context, messages) {
        context.commit('setGalleryCreate', messages);
    },
    setGalleryDelete(context, messages) {
        context.commit('setGalleryDelete', messages);
    },
    setGalleryMove(context, messages) {
        context.commit('setGalleryMove', messages);
    },
    setGalleryMove2(context, messages) {
        context.commit('setGalleryMove2', messages);
    }
};

export default {
    namespaced: true, // 名前空間を有効にする
    state,
    getters,
    mutations,
    actions
}