<template>
  <div class="canvas">
    <h1 class="judul"><b>Daftar anggota</b></h1>
    <div class="field atas">
      <button class="button warna-tema" @click="add">
        <span class="icon-dibutton"><i class="fa fa-plus-circle"></i></span> Tambah Anggota
      </button>
      <Search :load="sLoad" @search="handleSearch" v-model="search" class="anak" />
    </div>
    <table class="table is-hoverable is-fullwidth">
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
        <Row
          v-for="(item, apem) in members"
          :key="apem"
          :data="item"
          :index="apem"
          @gantiStatus="ganti"
        />
      </tbody>
    </table>
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
              <input-label
                iconLeft="fa-portrait"
                placeholder="Nama"
                label="Nama"
                v-model="user.name"
              ></input-label>
              <input-label
                iconLeft="fa-phone"
                placeholder="Nomor Telepon"
                label="Telepon"
                v-model="user.telepon"
              ></input-label>
              <input-label
                iconLeft="fa-map-marker-alt"
                placeholder="Alamat"
                label="Alamat"
                v-model="user.alamat"
              ></input-label>
              <input-label
                pesan="Nomor anggota di isi angka, jika kosong akan terisi otomatis"
                iconLeft="fa-id-card"
                placeholder="Nomor Anggota"
                label="ID Anggota"
                v-model="user.id_koperasi"
              ></input-label>
              <input-label
                pesan="Simpanan pokok kosongi jika memang belum ada"
                label="Simpanan Pokok"
                iconLeft="fa-money-check-alt"
                placeholder="Simpanan Pokok"
                v-model="user.simPok"
              ></input-label>
            </div>
          </div>
        </section>
        <footer slot="footer" class="modal-card-foot ">
          <button
            class="button warna-tema is-rounded"
            :class="loading"
            @click.prevent="submit"
            :disabled="disable"
          >
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
              <input-label
                label="Simpanan Pokok"
                iconLeft="fa-money-check-alt"
                placeholder="Simpanan Pokok"
                v-model="user.simPok"
              ></input-label>
            </div>
          </div>
        </section>
        <footer slot="footer" class="modal-card-foot ">
          <button
            class="button warna-tema is-rounded"
            :class="loading"
            @click.prevent="status"
            :disabled="disable"
          >
            Kirimkan
          </button>
          <button class="button is-rounded" @click.prevent="handleStatus">
            Batal
          </button>
        </footer>
      </Modal>
    </transition>
  </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';
export default {
  name: 'anggota',
  components: {
    Modal: () => import(/* webpackChunkName: "modal" */ '../../components/base/Modal'),
    Search: () => import(/* webpackChunkName: "search" */ '../../components/base/Search'),
    Row: () => import(/* webpackChunkName: "row" */ './Row'),
    'input-label': () =>
      import(/* webpackChunkName: "input" */ '../../components/base/InputValidate')
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
      user: { name: '', alamat: '', telepon: '', id_koperasi: '', simPok: 0 }
    };
  },
  created() {
    this.getMember();
  },
  computed: {
    ...mapState('member', {
      members: state => state.member
    }),
    statusText() {
      return this.newStatus == 2
        ? 'Anda akan mengaktifkana anggota ini pastikan nilai simpanan pokok, dan pastikan simpanan pokok telah anda terima'
        : this.newStatus == 3
        ? 'Anda akan memberhentikan anggota ini, pastikan semua hak anggota siap diberikan'
        : 'tidak ada keterangan';
    }
  },
  methods: {
    ...mapActions('member', ['addMember', 'getMember', 'resetStatus']),
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
      this.disable = true;
      this.loading = 'is-loading';
      this.addMember(this.user)
        .then(() => {
          this.disable = false;
          this.loading = '';
          this.showModal = false;
          this.getMember();
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
      this.modalStatus = true;
      this.newStatus = value;
    },
    handleStatus() {
      this.modalStatus = false;
    },
    status() {}
  },
  destroyed() {
    this.resetStatus;
  }
};
</script>

<style scoped>
.atas {
  display: flex;
  justify-content: space-between;
}
.anak {
  flex-grow: 2;
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
