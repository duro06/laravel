import Vue from 'vue';
import Vuex from 'vuex';
import auth from './stores/store_auth';
import user from './stores/store_user';

Vue.use(Vuex);

export default new Vuex.Store({
  modules:{
   auth,
   user 
  },
  state:{},
  getters:{},
  mutations:{},
  actions:{}
  
});