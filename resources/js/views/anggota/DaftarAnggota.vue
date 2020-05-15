<template>
  <div class="canvas">
    <h1 class="judul"><b>Daftar anggota</b></h1>
    <button class="button warna-tema" @click="add">
      <span class="icon-dibutton"><i class="fa fa-plus-circle"></i></span> Tambah Anggota
    </button>
    <table class="table is-hoverable">
      <thead>
        <tr>
          <th>No</th>
          <th><abbr title="nama">Nama</abbr></th>
          <th><abbr title="Nomor Anggota">No Anggota</abbr></th>
          <th><abbr title="Gambar">Foto</abbr></th>
          <th><abbr title="Alamat">Alamat</abbr></th>
          <th><abbr title="Nomor Telepon yang digunakan">Telepon</abbr></th>
          <th><abbr title="Kelompok">Kelompok</abbr></th>
          <th><abbr title="Simpanan Pokok">SP</abbr></th>
          <th><abbr title="Simpanan Wajib">SW</abbr></th>
          <th><abbr title="Simpanan Wajib Pinjam">SWP</abbr></th>
          <th><abbr title="Simpanan Hari Raya">SHR</abbr></th>
          <th><abbr title="Sisa Hasil Usaha">SHU</abbr></th>
        </tr>
      </thead>
      <tbody>
        <tr @mouseenter="masuk" @mouseleave="keluar" :class="selected">
          <th>1</th>
          <td>
            <a href="https://en.wikipedia.org/wiki/Leicester_City_F.C." title="Leicester City F.C."
              >Leicester City</a
            >
            <strong>(C)</strong>
          </td>
          <td>38</td>
          <td>23</td>
          <td>12</td>
          <td>3</td>
          <td>68</td>
          <td>36</td>
          <td>+32</td>
          <td>81</td>
          <td>
            Qualification for the
            <a
              href="https://en.wikipedia.org/wiki/2016%E2%80%9317_UEFA_Champions_League#Group_stage"
              title="2016–17 UEFA Champions League"
              >Champions League group stage</a
            >
          </td>
        </tr>

        <tr :class="selected">
          <th>4</th>
          <td>
            <a
              href="https://en.wikipedia.org/wiki/Manchester_City_F.C."
              title="Manchester City F.C."
              >Manchester City</a
            >
          </td>
          <td>38</td>
          <td>19</td>
          <td>9</td>
          <td>10</td>
          <td>71</td>
          <td>41</td>
          <td>+30</td>
          <td>66</td>
          <td>
            Qualification for the
            <a
              href="https://en.wikipedia.org/wiki/2016%E2%80%9317_UEFA_Champions_League#Play-off_round"
              title="2016–17 UEFA Champions League"
              >Champions League play-off round</a
            >
          </td>
        </tr>
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
              <input-validasi
                iconLeft="fa-portrait"
                placeholder="Nama"
                @input="nama"
              ></input-validasi>
              <input-validasi
                iconLeft="fa-phone"
                placeholder="Nomor Telepon"
                @input="telepon"
              ></input-validasi>
              <input-validasi
                iconLeft="fa-map-marker-alt"
                placeholder="Alamat"
                @input="alamat"
              ></input-validasi>
              <span class="pemberitahuan">
                <b>*</b> Nomor anggota di isi angka, jika kosong akan terisi otomatis
              </span>
              <input-validasi
                iconLeft="fa-id-card"
                placeholder="Nomor Anggota"
                @input="nomor"
              ></input-validasi>
            </div>
          </div>
        </section>
        <footer slot="footer" class="modal-card-foot ">
          <button
            class="button warna-tema is-small is-rounded"
            @click.prevent="submit"
            :disabled="disable"
          >
            Kirimkan
          </button>
          <button class="button is-small is-rounded" @click.prevent="handleModal">
            Batal
          </button>
        </footer>
      </Modal>
    </transition>
  </div>
</template>

<script>
export default {
  name: 'anggota',
  components: {
    Modal: () => import(/* webpackChunkName: "modal" */ '../../components/base/Modal'),
    'input-validasi': () =>
      import(/* webpackChunkName: "modal" */ '../../components/base/InputValidate')
  },
  data() {
    return {
      selected: '',
      showModal: false,
      disable: false,
      user: { nama: '', alamat: '', telepon: '', id_koperasi: '' }
    };
  },
  methods: {
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
    nama(value) {
      this.user.nama = value;
      console.log(value);
    },
    telepon(value) {
      this.user.telepon = value;
      console.log(value);
    },
    alamat(value) {
      this.user.alamat = value;
      console.log(value);
    },
    nomor(value) {
      this.user.id_koperasi = value;
      console.log(value);
    },
    submit() {}
  }
};
</script>

<style scoped>
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
