import { http } from '../services/http_service';

const state = () => ({
  member: [],
  meta: {},
  page: 1, //UNTUK MENCATAT PAGE PAGINATE YANG SEDANG DIAKSES
  sortBy: 'created_at', //default sorting
  sortByDesc: false,
  per_page: 10, //UNTUK MENCATAT PER PAGE NYA,
  search: '',
  status: 2
});

const mutations = {
  setMember(state, payload) {
    state.member = payload;
  },
  delMember(state) {
    state.member = [];
  },
  setStatus(state, payload) {
    state.status = payload;
  },
  resetStatus(state) {
    state.status = 2;
  }
};

const actions = {
  getMember({ commit, state }, payload) {
    let search = typeof payload != 'undefined' ? payload : '';
    let sorting = state.sortByDesc ? 'DESC' : 'ASC';
    let params = {
      params: {
        page: state.page,
        per_page: state.per_page,
        q: search,
        sortby: state.sortBy,
        sortbydesc: sorting,
        ss: state.status
      }
    };
    return new Promise(resolve => {
      http()
        .get('member/anggota', params)
        .then(res => {
          console.log(res.data.data.data);
          commit('setMember', res.data.data.data);
          resolve(res.data);
        });
    });
  },
  addMember(context, payload) {
    return new Promise((resolve, reject) => {
      http()
        .post('member/tambah', payload)
        .then(res => {
          console.log(res.data);
          resolve(res);
        })
        .catch(err => {
          console.log(err);
          reject(err);
        });
    });
  },
  changeStatus({ commit }, payload) {
    commit('setStatus', payload);
  },
  resetStatus({ commit }) {
    commit('resetStatus');
  }
};

export default {
  namespaced: true,
  state,
  actions,
  mutations
};
