import Vue from 'vue';

import App from "./App.vue";
import router from "./router.js";
import store from "./store.js";
import FlashMessage from '@smartweb/vue-flash-message';

Vue.use(FlashMessage);

import 'bulma/css/bulma.css'


require('./bootstrap');

new Vue({
    el: "#app",
    router,
    store,
    render: h => h(App),
})