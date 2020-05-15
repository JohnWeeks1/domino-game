require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router'

Vue.use(VueRouter);

const routes = [
    {
        path: '/home',
        name: 'home',
        component: require('./components/AddPlayersComponent.vue').default
    },
    {
        path: '/player-list',
        name: 'player-list',
        component: require('./components/PlayerListComponent.vue').default
    },
    {
        path: '/select-dominoes/:player_id',
        name: 'select-dominoes',
        component: require('./components/SelectDominoesComponent.vue').default
    },
    {
        path: '/game',
        name: 'game',
        component: require('./components/GameComponent.vue').default
    }
];

const router = new VueRouter({
    mode: 'history',
    routes
});

const app = new Vue({
    el: '#app',
    router
});
