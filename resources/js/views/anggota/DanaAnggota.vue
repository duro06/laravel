<template>
  <div class="dana-anggota">
    <h1 class="judul"><B>Daftar Hak Anggota</B></h1>
    <div class="field">
      <button class="button warna-tema" @click="add">
        <span class="icon-dibutton"><i class="fa fa-plus-circle"></i></span> Input Hak Anggota
      </button>
    </div>
    <table class="table is-hoverable is-fullwidth" v-if="hakAnggota.length">
      <thead>
        <tr>
          <th><abbr title="Gambar">Nama</abbr></th>
          <th class="has-text-right"><abbr title="Action"> Option </abbr></th>
        </tr>
      </thead>
      <tbody>
        <Row v-for="(item, apem) in hakAnggota" :key="apem" :data="item" :index="apem" @edit="edit" @delete="deleteD" :load="loading" />
      </tbody>
    </table>
    <transition name="modal">
      <Modal v-if="addHak" @close="handleHak" class="modal">
        <header slot="header" class="modal-card-head">
          <p class="modal-card-title ">
            Tambah Hak Anggota
          </p>
        </header>
        <section slot="body" class="modal-card-body ">
          <div class="masuk ">
            <div class="control">
              <input-label label="Nama Dana Anggota" iconLeft="fa-list-ul" placeholder="Nama Dana Anggota" v-model="nama" @keyup.enter="submit" />
            </div>
          </div>
        </section>
        <footer slot="footer" class="modal-card-foot ">
          <button class="button warna-tema is-rounded" :class="loading" @click.prevent="submit" :disabled="disable">
            Kirimkan
          </button>
          <button class="button is-rounded" @click.prevent="handleHak">
            Batal
          </button>
        </footer>
      </Modal>
    </transition>
    <transition name="modal">
      <Modal v-if="editHak" @close="handleEdit" class="modal">
        <header slot="header" class="modal-card-head">
          <p class="modal-card-title ">
            Edit Hak Anggota
          </p>
        </header>
        <section slot="body" class="modal-card-body ">
          <div class="masuk ">
            <div class="control">
              <input-label label="Nama Dana Anggota" iconLeft="fa-list-ul" placeholder="Nama Dana Anggota" v-model="nama" @keyup.enter="submitEdit" />
            </div>
          </div>
        </section>
        <footer slot="footer" class="modal-card-foot ">
          <button class="button warna-tema is-rounded" :class="loading" @click.prevent="submitEdit" :disabled="disable">
            Kirimkan
          </button>
          <button class="button is-rounded" @click.prevent="handleEdit">
            Batal
          </button>
        </footer>
      </Modal>
    </transition>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
export default {
  name: 'dana-anggota',
  components: {
    Modal: () => import(/* webpackChunkName: "modal" */ '../../components/base/Modal'),
    'input-label': () => import(/* webpackChunkName: "input" */ '../../components/base/InputValidate'),
    Row: () => import(/* webpackChunkName: "row" */ './Row2')
  },
  data() {
    return {
      data: {},
      nama: '',
      loading: '',
      disable: false,
      addHak: false,
      editHak: false
    };
  },
  created() {
    this.getHakAnggota();
  },
  computed: {
    ...mapState('dana', {
      hakAnggota: state => state.hakAnggota
    })
  },
  methods: {
    ...mapActions('dana', ['addHakAnggota', 'getHakAnggota', 'editData', 'deleteData']),
    add() {
      this.addHak = true;
    },
    handleHak() {
      this.addHak = false;
    },
    edit(value) {
      this.editHak = true;
      this.data = value;
      this.nama = value.nama;
    },
    handleEdit() {
      this.editHak = false;
    },
    submit() {
      this.disable = true;
      this.loading = 'is-loading';

      let data = new FormData();
      data.append('nama', this.nama);
      this.addHakAnggota(data).then(() => {
        this.disable = false;
        this.loading = '';
        this.addHak = false;
        this.getHakAnggota();
      });
    },
    submitEdit() {
      this.disable = true;
      this.loading = 'is-loading';
      let data = new FormData();
      data.append('id', this.data.id);
      data.append('nama', this.nama);
      this.editData(data).then(() => {
        this.disable = false;
        this.loading = '';
        this.editHak = false;
        this.getHakAnggota();
      });
    },
    deleteD() {
      // this.loading='is-loading'
      // let data = new FormData();
      // data.append('id', value.id);
      // this.deleteData(data).then(() => {
      //   this.getHakAnggota();
      //   this.loading = '';
      // });
    }
  }
};
</script>

<style></style>
