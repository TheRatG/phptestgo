import * as types from '../mutation-types';

const state = {
    questionCount: 10,
    selectedCategories: [],
};

const getters = {
    questionCount: state => state.questionCount,
    selectedCategories: state => state.selectedCategories,
};

const mutations = {
    [types.UPDATE_SETTINGS](state, payload) {
        state.questionCount = payload.questionCount;
        state.selectedCategories = payload.selectedCategories;
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