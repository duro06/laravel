import Vue from 'vue';
import Vuex from 'vuex';
import auth from './stores/store_auth';
import user from './stores/store_user';
import member from './stores/store_member';
import dana from './stores/store_dana';

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    auth,
    user,
    member,
    dana
  },
  state: {},
  getters: {},
  mutations: {},
  actions: {}
});
