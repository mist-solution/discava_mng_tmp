const state = {
    selectedFolder:"",
    AddDateBegin:"",
    AddDateEnd:"",
    FileFormat:"",
    Caption:"",
}
const getters = {
    selectedFolder: (state) => state.selectedFolder,
    AddDateBegin: (state) => state.AddDateBegin,
    AddDateEnd: (state) => state.AddDateEnd,
    FileFormat: (state) => state.FileFormat,
    Caption: (state) => state.Caption,
}

const mutations = {
    setSelectedFolder(state, selectedFolder) {
        state.selectedFolder = selectedFolder;
    },
    setAddDateBegin(state, AddDateBegin) {
        state.AddDateBegin = AddDateBegin;
    },
    setAddDateEnd(state, AddDateEnd) {
        state.AddDateEnd = AddDateEnd;
    },
    setFileFormat(state, FileFormat) {
        state.FileFormat = FileFormat;
    },
    setCaption(state, Caption) {
        state.Caption = Caption;
    },
}
const actions = {
    setSelectedFolder(context, SelectedFolder) {
        context.commit('setSelectedFolder', SelectedFolder);
    },
    setAddDateBegin(context, AddDateBegin) {
        context.commit('setAddDateBegin', AddDateBegin);
    },
    setAddDateEnd(context, AddDateEnd) {
        context.commit('setAddDateEnd', AddDateEnd);
    },
    setFileFormat(context, FileFormat) {
        context.commit('setFileFormat', FileFormat);
    },
    setCaption(context, Caption) {
        context.commit('setCaption', Caption);
    },
}

export default {
    namespaced: true, // 名前空間を有効にする
    state,
    getters,
    mutations,
    actions
}