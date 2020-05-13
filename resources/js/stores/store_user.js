import { http } from '../services/http_service';
const state = () => ({
  user: {}
});

const mutations = {
  setUser(state, payload) {
    state.user = payload;
  },
  delUser(state) {
    state.user = {};
  }
};

const actions = {
  getUser(context) {
    return new Promise(() => {
      http()
        .get('/user')
        .then(res => {
          console.log(res);
          context.commit('setUser', res.data);
        });
    });
  },
  removeUser(context) {
    context.commit('delUser');
    localStorage.removeItem('token');
  }
};

export default {
  namespaced: true,
  state,
  actions,
  mutations
};
