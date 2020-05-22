<template>
  <div class="user-list">
    <h1 class="judul"><b>Daftar anggota</b></h1>
    <div class="field atas">
      <Pilih class="sodara" @select="pilih" :levels="levels" judul="per halaman" />
      <Search :load="loading" @search="handleSearch" v-model="search" class="anak" placeholder="Cari Nama" />
    </div>
    <table class="table is-hoverable is-fullwidth" v-if="users.length">
      <thead>
        <tr>
          <th><abbr title="Gambar">Foto</abbr></th>
          <th><abbr title="nama">Identitas</abbr></th>
          <th><abbr title="Alamat">Alamat</abbr></th>
          <th><abbr title="status keanggotaan">Keanggotaan</abbr></th>
          <th><abbr title="status anggota">Status</abbr></th>
          <th><abbr title="Action"> </abbr></th>
        </tr>
      </thead>
      <tbody>
        <Row v-for="(item, apem) in users" :key="apem" :data="item" :index="apem" />
      </tbody>
    </table>
    <div class="kosong has-text-centered" v-if="!users.length">Tidak ada data</div>
    <Paginate :current="meta.current" :last="meta.last" @first="firstPage" @next="nextPage" @prev="prevPage" @last="lastPage" v-if="users.length" />
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
export default {
  name: 'user-list',
  components: {
    Row: () => import(/* webpackChunkName: "row" */ './Row'),
    Search: () => import(/* webpackChunkName: "search" */ '../../components/base/Search'),
    Paginate: () => import(/* webpackChunkName: "paginate" */ './Paginate'),
    Pilih: () => import(/* webpackChunkName: "select" */ '../../components/base/Select')
  },
  data() {
    return {
      meta: { first: 1, next: 2, prev: 1, last: 2 },
      levels: [5, 10, 25, 50],
      search: '',
      loading: ''
    };
  },
  created() {
    this.getAllUsers();
  },
  computed: {
    ...mapState('user', {
      users: state => state.users
    })
  },
  methods: {
    ...mapActions('user', ['changePage', 'changePerPage', 'getAllUsers']),

    handleSearch(value) {
      this.loading = 'is-loading';
      this.search = value;
      this.getAllUsers(value).then(() => {
        this.loading = '';
        console.log(this.loading);
      });
      console.log(this.loading);
    },
    firstPage(value) {
      this.changePage(value);
      this.getAllUsers();
    },
    nextPage(value) {
      this.changePage(value);
      this.getAllUsers();
    },
    prevPage(value) {
      this.changePage(value);
      this.getAllUsers();
    },
    lastPage(value) {
      this.changePage(value);
      this.getAllUsers();
    },
    pilih(value) {
      this.changePerPage(value);
      this.getAllUsers();
    }
  }
};
</script>

<style lang="scss" scooped>
.sodara {
  margin-left: 10px;
}

.atas {
  display: flex;
  justify-content: space-between;
}

.anak {
  flex-grow: 2;
  margin-left: 10px;
}
</style>
