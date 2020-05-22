import { http, httpFile } from '../services/http_service';
const state = () => ({
  user: {},
  users: [],
  meta: {
    current: 1,
    last: 2
  },
  page: 1, //UNTUK MENCATAT PAGE PAGINATE YANG SEDANG DIAKSES
  sortBy: 'created_at', //default sorting
  sortByDesc: true,
  per_page: 5, //UNTUK MENCATAT PER PAGE NYA,
  search: ''
});

const mutations = {
  setUser(state, payload) {
    state.user = payload;
  },
  delUser(state) {
    state.user = {};
  },
  setUsers(state, payload) {
    state.users = payload;
  },
  delUsers(state) {
    state.users = [];
  },
  setMeta(state, payload) {
    (state.meta.current = payload.current), (state.meta.last = payload.last);
  },
  setPage(state, payload) {
    state.page = payload;
  },
  setPerPage(state, payload) {
    state.per_page = payload;
  }
};

const actions = {
  getAllUsers({ commit, state }, payload) {
    let search = typeof payload != 'undefined' ? payload : '';
    let sorting = state.sortByDesc ? 'DESC' : 'ASC';
    let params = {
      params: {
        page: state.page,
        per_page: state.per_page,
        q: search,
        sortby: state.sortBy,
        sortbydesc: sorting
      }
    };
    return new Promise(resolve => {
      http()
        .get('user/all', params)
        .then(res => {
          console.log(res.data.data);
          let anu = res.data.data.data;
          let meta = {
            current: anu.current_page,
            last: anu.last_page
          };
          commit('setMeta', meta);
          console.log('page', meta);
          commit('setUsers', res.data.data.data.data);
          resolve(res.data);
        });
    });
  },
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
  },
  changePage({ commit }, payload) {
    commit('setPage', payload);
  },
  changePerPage({ commit }, payload) {
    commit('setPerPage', payload);
  }
};

export default {
  namespaced: true,
  state,
  actions,
  mutations
};
