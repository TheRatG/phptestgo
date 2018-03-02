import * as types from '../mutation-types';

const state = {
    questionCount: 10,
    selectedCategories: [],
    hideMultipleChoice: true,
};

const getters = {
    questionCount: state => state.questionCount,
    selectedCategories: state => state.selectedCategories,
    hideMultipleChoice: state => state.hideMultipleChoice,
};

const mutations = {
    [types.UPDATE_SETTINGS](state, payload) {
        state.questionCount = payload.questionCount;
        state.selectedCategories = payload.selectedCategories;
        state.hideMultipleChoice = payload.hideMultipleChoice;
    },
};

const actions = {
    updateSettings({commit}, payload) {
        commit(types.UPDATE_SETTINGS, payload);
    },
};

export default {
    state,
    getters,
    actions,
    mutations,
};