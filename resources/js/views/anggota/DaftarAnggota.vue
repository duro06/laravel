<template>
  <div class="canvas">
    <div class="detail" v-if="detail">
      <router-view></router-view>
    </div>
    <div class="view" v-if="!detail">
      <h1 class="judul"><b>Daftar anggota</b></h1>
      <div class="field atas">
        <button class="button warna-tema" @click="add">
          <span class="icon-dibutton"><i class="fa fa-plus-circle"></i></span> Tambah Anggota
        </button>
        <Pilih class="sodara" @select="pilih" :levels="levels" judul="per halaman" />
        <Search :load="sLoad" @search="handleSearch" v-model="search" class="anak" placeholder="Cari Nama" />
      </div>
      <table class="table is-hoverable is-fullwidth" v-if="members.length">
        <thead>
          <tr>
            <th><abbr title="Gambar">Foto</abbr></th>
            <th><abbr title="nama">Identitas</abbr></th>
            <th><abbr title="Alamat">Alamat</abbr></th>
            <th><abbr title="Kelompok">Kelompok</abbr></th>
            <th><abbr title="status anggota">Status</abbr></th>
            <th><abbr title="Action"> </abbr></th>
          </tr>
        </thead>
        <tbody>
          <Row v-for="(item, apem) in members" :key="apem" :data="item" :index="apem" @gantiStatus="ganti" />
        </tbody>
      </table>
      <div class="kosong has-text-centered" v-if="!members.length">Tidak ada data</div>
      <Paginate
        :current="meta.current"
        :last="meta.last"
        @first="firstPage"
        @next="nextPage"
        @prev="prevPage"
        @last="lastPage"
        v-if="members.length"
      />
      <transition name="modal">
        <Modal v-if="showModal" @close="handleModal" class="modal">
          <header slot="header" class="modal-card-head">
            <p class="modal-card-title ">
              Tambah Anggota
            </p>
          </header>
          <section slot="body" class="modal-card-body ">
            <div class="masuk ">
              <div class="control">
                <input-label iconLeft="fa-portrait" placeholder="Nama" label="Nama" v-model="user.name"> </input-label>
                <input-label
                  pesan="Di isi angka saja, jangan ada spasi atau huruf selain angka"
                  iconLeft="fa-phone"
                  placeholder="Nomor Telepon"
                  label="Telepon"
                  v-model="user.telepon"
                ></input-label>
                <input-label iconLeft="fa-map-marker-alt" placeholder="Alamat" label="Alamat" v-model="user.alamat"></input-label>
                <input-label
                  pesan="Nomor anggota di isi angka, jika kosong akan terisi otomatis"
                  iconLeft="fa-id-card"
                  placeholder="Nomor Anggota"
                  label="ID Anggota"
                  v-model="user.id_koperasi"
                ></input-label>
                <input-number
                  pesan="Simpanan pokok kosongi jika memang belum ada"
                  label="Simpanan Pokok"
                  iconLeft="fa-money-check-alt"
                  placeholder="Simpanan Pokok"
                  v-model="user.simPok"
                ></input-number>
              </div>
            </div>
          </section>
          <footer slot="footer" class="modal-card-foot ">
            <button class="button warna-tema is-rounded" :class="loading" @click.prevent="submit" :disabled="disable">
              Kirimkan
            </button>
            <button class="button is-rounded" @click.prevent="handleModal">
              Batal
            </button>
          </footer>
        </Modal>
      </transition>
      <transition name="modal">
        <Modal v-if="modalStatus" @close="handleStatus" class="modal">
          <header slot="header" class="modal-card-head">
            <p class="modal-card-title ">
              Ganti Status Anggota
            </p>
          </header>
          <section slot="body" class="modal-card-body ">
            <div class="masuk ">
              <div class="control">
                <p>{{ statusText }}</p>
                <input-number
                  v-if="newStatus == 2"
                  label="Simpanan Pokok"
                  iconLeft="fa-money-check-alt"
                  placeholder="Simpanan Pokok"
                  v-model="user.simPok"
                ></input-number>
              </div>
            </div>
          </section>
          <footer slot="footer" class="modal-card-foot ">
            <button class="button warna-tema is-rounded" :class="loading" @click.prevent="status" :disabled="disable">
              Kirimkan
            </button>
            <button class="button is-rounded" @click.prevent="handleStatus">
              Batal
            </button>
          </footer>
        </Modal>
      </transition>
    </div>
  </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';
export default {
  name: 'anggota',
  components: {
    Modal: () => import(/* webpackChunkName: "modal" */ '../../components/base/Modal'),
    Search: () => import(/* webpackChunkName: "search" */ '../../components/base/Search'),
    Paginate: () => import(/* webpackChunkName: "paginate" */ '../../components/base/Pagination'),
    Pilih: () => import(/* webpackChunkName: "select" */ '../../components/base/Select'),
    Row: () => import(/* webpackChunkName: "row" */ './Row'),
    'input-label': () => import(/* webpackChunkName: "input" */ '../../components/base/InputValidate'),
    'input-number': () => import(/* webpackChunkName: "input-number" */ '../../components/base/InputNumber')
  },
  data() {
    return {
      selected: '',
      showModal: false,
      modalStatus: false,
      newStatus: '',
      disable: false,
      loading: '',
      sLoad: '',
      search: '',
      user: { name: '', alamat: '', telepon: '', id_koperasi: '', simPok: '0', id: '', status: '' },
      meta: { first: 1, next: 2, prev: 1, last: 2 },
      levels: [5, 10, 25, 50]
    };
  },
  created() {
    this.getMember();
  },
  computed: {
    ...mapState('member', {
      members: state => state.members
    }),
    statusText() {
      return this.newStatus == 2
        ? 'Anda akan mengaktifkana anggota ini pastikan nilai simpanan pokok, dan pastikan simpanan pokok telah anda terima'
        : this.newStatus == 3
        ? 'Anda akan memberhentikan anggota ini, pastikan semua hak anggota siap diberikan'
        : 'tidak ada keterangan';
    },
    detail() {
      return this.$route.path.includes('detail') ? true : false;
    }
  },
  methods: {
    ...mapActions('member', ['addMember', 'getMember', 'resetStatus', 'updateStatus', 'changePage', 'changePerPage', 'changeStatus']),
    masuk() {
      this.selected = 'is-selected';
    },
    keluar() {
      this.selected = '';
    },
    add() {
      this.showModal = true;
    },
    handleModal() {
      this.showModal = false;
    },
    submit() {
      console.log(this.user);
      let status = this.user.simPok == 0 ? 1 : 2;
      this.disable = true;
      this.loading = 'is-loading';
      this.addMember(this.user)
        .then(() => {
          this.disable = false;
          this.loading = '';
          this.showModal = false;
          this.changeStatus(status);
          this.getMember();
          this.user = { name: '', alamat: '', telepon: '', id_koperasi: '', simPok: '0', id: '', status: '' };
        })
        .catch(() => {
          this.showModal = false;
          this.loading = '';
          this.disable = false;
        });
    },
    handleSearch(value) {
      this.sLoad = 'is-loading';
      this.search = value;
      this.getMember(value).then(() => {
        this.sLoad = '';
        console.log(this.sLoad);
      });
      console.log(this.sLoad);
    },
    ganti(value) {
      console.log(value);
      if (value == 2) {
        this.user.simPok = 50000;
      }
      this.newStatus = value.status;
      this.user.status = value.status;
      this.user.id = value.id;
      this.modalStatus = true;
    },
    handleStatus() {
      this.modalStatus = false;
    },
    status() {
      this.disable = true;
      this.loading = 'is-loading';
      this.updateStatus(this.user)
        .then(res => {
          this.disable = false;
          this.loading = '';
          console.log('user', this.user, 'res', res);
          this.modalStatus = false;
          this.resetStatus();
          this.getMember();
          this.flashMessage.success({
            message: res.data.message,
            time: 5000
          });
        })
        .catch(err => {
          this.disable = false;
          this.loading = '';
          console.log(err.response);
          this.flashMessage.error({
            message: err.response.data.message,
            time: 5000
          });
        });
    },
    firstPage(value) {
      this.changePage(value);
      this.getMember();
    },
    nextPage(value) {
      this.changePage(value);
      this.getMember();
    },
    prevPage(value) {
      this.changePage(value);
      this.getMember();
    },
    lastPage(value) {
      this.changePage(value);
      this.getMember();
    },
    pilih(value) {
      this.changePerPage(value);
      this.getMember();
    }
  },
  destroyed() {
    this.resetStatus();
  }
};
</script>

<style scoped>
.kosong {
  font-size: 30px;
  font-weight: 700;
  font-style: italic;
}
.atas {
  display: flex;
  justify-content: space-between;
}
.anak {
  flex-grow: 2;
  margin-left: 10px;
}
.sodara {
  margin-left: 10px;
}
.table td,
.table th {
  vertical-align: middle;
}
.masuk {
  padding: 5px 10px;
}
.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}
</style>
