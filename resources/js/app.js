
require('./bootstrap');

window.Vue = require('vue');

//import router from './router'

import common from './common'
import store from './store'

Vue.mixin(common)

Vue.component('stage', require('./components/stage.vue').default);


const app = new Vue({
    el: '#app',
    store,
});
