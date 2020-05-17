import { http } from '../services/http_service';

const state = () => ({
  members: [],
  member: {},
  meta: {
    current: 1,
    last: 2
  },
  page: 1, //UNTUK MENCATAT PAGE PAGINATE YANG SEDANG DIAKSES
  sortBy: 'created_at', //default sorting
  sortByDesc: true,
  per_page: 5, //UNTUK MENCATAT PER PAGE NYA,
  search: '',
  status: 2
});

const mutations = {
  setMember(state, payload) {
    state.members = payload;
  },
  delMember(state) {
    state.members = [];
  },
  setStatus(state, payload) {
    state.status = payload;
  },
  resetStatus(state) {
    state.status = 2;
  },
  setMeta(state, payload) {
    (state.meta.current = payload.current), (state.meta.last = payload.last);
  },
  setPage(state, payload) {
    state.page = payload;
  },
  setPerPage(state, payload) {
    state.per_page = payload;
  },
  setMemberById(state, payload) {
    state.member = payload;
  },
  delMemberById(state) {
    state.member = {};
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
          console.log(res.data.data);
          let anu = res.data.data;
          let meta = {
            current: anu.current_page,
            last: anu.last_page
          };
          commit('setMeta', meta);
          console.log('page', meta);
          commit('setMember', res.data.data.data);
          resolve(res.data);
        });
    });
  },
  getMemberById({ commit, state }, payload) {
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
        .get('member/memberById', params)
        .then(res => {
          console.log(res.data.data);

          commit('setMemberById', res.data.data);
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
  },
  changePage({ commit }, payload) {
    commit('setPage', payload);
  },
  changePerPage({ commit }, payload) {
    commit('setPerPage', payload);
  },
  updateMember(context, payload) {
    return new Promise((resolve, reject) => {
      http()
        .post(`member/update`, payload)
        .then(res => {
          resolve(res);
        })
        .catch(err => {
          reject(err);
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
