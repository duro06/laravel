import { http, httpFile } from '../services/http_service';
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
    return new Promise(resolve => {
      http()
        .get('/user')
        .then(res => {
          context.commit('setUser', res.data);
          // location.reload();
          resolve(res.data);
        });
    });
  },
  removeUser(context) {
    context.commit('delUser');
    localStorage.removeItem('token');
  },
  updateImage(comtext, id, data) {
    // return new Promise(resolve => {
    httpFile().post(`/user/update-image/${id}`, data);
    // .then(res => {
    //   resolve(res);
    // });
    // });
  },
  updateProfile(context, payload) {
    return new Promise(resolve => {
      http()
        .put(`user/update-profile/${payload.id}`, payload)
        .then(res => {
          resolve(res);
        });
    });
  },
  linkToMember(context, payload) {
    return new Promise(resolve => {
      http()
        .post('user/link-to-member', payload)
        .then(res => {
          resolve(res.data);
          console.log(res);
        });
    });
  },
  unlinkToMember(context, payload) {
    return new Promise(resolve => {
      http()
        .post('user/unlink-to-member', payload)
        .then(res => {
          resolve(res.data);
          console.log(res);
        });
    });
  }
};

export default {
  namespaced: true,
  state,
  actions,
  mutations
};
