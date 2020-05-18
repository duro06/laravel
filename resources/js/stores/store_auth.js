import { http } from '../services/http_service';
const state = () => ({
  server: 'http://laravel.test',
  cookies: '',
  token: localStorage.getItem('token') || null
});

const mutations = {};

const actions = {
  register(context, data) {
    console.log('data', data);
    return new Promise((resolve, reject) => {
      http()
        .post('auth/register', data)
        .then(res => {
          resolve(res);
        })
        .catch(err => {
          reject(err);
        });
    });
  }
};

const getters = {
  loggedIn(state) {
    return state.token !== null;
  },
  apiUrl(state) {
    return state.server + '/api';
  },
  storageUrl(state) {
    return state.server + '/storage/';
  },
  serverUrl(state) {
    return state.server;
  }
};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
};
