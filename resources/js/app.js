require('./bootstrap');

window.Vue = require('vue');

Vue.component('domino-component', require('./components/DominoComponent.vue').default);
Vue.component('select-dominoes-component', require('./components/SelectDominoesComponent.vue').default);
Vue.component('players-component', require('./components/PlayersComponent.vue').default);
Vue.component('game-component', require('./components/GameComponent.vue').default);

const app = new Vue({
    el: '#app',
});
