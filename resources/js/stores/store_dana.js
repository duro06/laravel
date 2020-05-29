import { http } from '../services/http_service';

const state = () => ({
  hakAnggota: [],
  meta: {
    current: 1,
    last: 2
  },
  page: 1, //UNTUK MENCATAT PAGE PAGINATE YANG SEDANG DIAKSES
  sortBy: 'created_at', //default sorting
  sortByDesc: true,
  per_page: 20, //UNTUK MENCATAT PER PAGE NYA,
  search: '',
  mode: ''
});

const mutations = {
  setHakAnggota(state, payload) {
    state.hakAnggota = payload;
  },
  delHakAnggota(state) {
    state.hakAnggota = [];
  },
  changeMode(state, payload) {
    state.mode = payload;
  }
};

const actions = {
  addHakAnggota(context, payload) {
    return new Promise(resolve => {
      http()
        .post('admin/add-hak-anggota', payload)
        .then(res => {
          resolve(res);
        });
    });
  },
  editData(context, payload) {
    return new Promise(resolve => {
      http()
        .post('admin/edit-data', payload)
        .then(res => {
          resolve(res);
        });
    });
  },
  deleteData(context, payload) {
    return new Promise(resolve => {
      http()
        .post('admin/delete-data', payload)
        .then(res => {
          resolve(res);
        });
    });
  },
  restoreData(context, payload) {
    return new Promise(resolve => {
      http()
        .post('admin/kembalikan', payload)
        .then(res => {
          resolve(res);
        });
    });
  },
  getHakAnggota({ commit, state }, payload) {
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
        .get('admin/get-data', params)
        .then(res => {
          console.log(res.data);
          commit('setHakAnggota', res.data.data.data.data);
          commit('changeMode', '');
          resolve(res.data);
        });
    });
  },
  getDeletedHak({ commit, state }, payload) {
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
        .get('admin/tempat-sampah', params)
        .then(res => {
          console.log(res.data.data);
          commit('setHakAnggota', res.data.data.data);
          commit('changeMode', 'trash');
          resolve(res.data);
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
