import Vue from 'vue'
import Vuex from 'vuex'
import createLogger from 'vuex/dist/logger'
import settings from './modules/settings.js'
import results from './modules/results.js'

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        settings,
        results
    },
    plugins: [createLogger({})]
});