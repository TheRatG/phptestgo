import * as types from '../mutation-types';

const state = {
    rightCount: 0,
    totalCount: 0,
    questions: [],
};

const getters = {
    rightCount: state => state.rightCount,
    totalCount: state => state.totalCount,
    questions: state => state.questions,
};

const mutations = {
    [types.UPDATE_RESULTS](state, payload) {
        state.rightCount = payload.rightCount;
        state.totalCount = payload.totalCount;
        state.questions = payload.questions;
    },
};

const actions = {
    updateResults({commit}, payload) {
        commit(types.UPDATE_RESULTS, payload);
    },
};

export default {
    state,
    getters,
    actions,
    mutations,
};