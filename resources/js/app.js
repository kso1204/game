
require('./bootstrap');

window.Vue = require('vue');

import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';

Vue.use(ViewUI);

//import router from './router'

import common from './common'
import store from './store'

Vue.mixin(common)

Vue.component('profile', require('./components/profile.vue').default);
Vue.component('stage', require('./components/stage.vue').default);
Vue.component('ranking', require('./components/ranking.vue').default);


const app = new Vue({
    el: '#app',
    store,
});
