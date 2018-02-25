import Vue from 'vue'
import VueRouter from 'vue-router';

import settings from './components/Settings';
import questions from './components/Questions';
import results from './components/Results';

Vue.use(VueRouter);

const routes = [
    {path: '/settings', name: 'Settings', icon: 'settings', badge: '', component: settings},
    {path: '/questions', name: 'Questions', icon: 'list', badge: '', component: questions},
    {path: '/results', name: 'Results', icon: 'assignment', badge: '', component: results},
    {path: '*', redirect: '/settings'}
];

export default new VueRouter({
    routes
});