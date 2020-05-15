require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router'

Vue.use(VueRouter);

const routes = [
    {
        path: '/home',
        component: require('./components/PlayersComponent.vue').default
    },
    {
        path: '/domino',
        name: 'domino',
        component: require('./components/DominoComponent.vue').default
    },
    {
        path: '/select-dominoes/:id',
        name: 'domino.select',
        component: require('./components/SelectDominoesComponent.vue').default
    },
    {
        path: '/game', component:
        require('./components/GameComponent.vue').default
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
