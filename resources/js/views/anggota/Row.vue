<template>
  <tr @mouseenter="masuk" @mouseleave="keluar" :class="selected" @click="detail">
    <td>
      <div class="avatar has-text-centered">
        <img :src="foto" alt="logo" />
      </div>
    </td>

    <td>
      <tr class="inner" :class="selected">
        <td class="dalam-tabel"><i class="fas fa-portrait"></i></td>
        <td class="dalam-tabel">{{ data.name }}</td>
      </tr>
      <tr class="inner" :class="selected">
        <td class="dalam-tabel"><i class="fas fa-id-card"></i></td>
        <td class="dalam-tabel">{{ data.id_koperasi }}</td>
      </tr>
      <tr class="inner" :class="selected">
        <td class="dalam-tabel"><i class="fas fa-phone"></i></td>
        <td class="dalam-tabel">{{ data.telepon }}</td>
      </tr>
      <!-- <p><i class="fas fa-portrait"></i> {{ data.name }}</p>
      <p><i class="fas fa-id-card"></i> {{ data.id_koperasi }}</p>
      <p><i class="fas fa-phone"></i> {{ data.telepon }}</p> -->
    </td>

    <td>{{ data.alamat }}</td>

    <td>{{ kelompok }}</td>
    <td>{{ status }}</td>
    <td>detail</td>
  </tr>
</template>

<script>
export default {
  name: 'tabel-row',
  props: {
    data: {
      type: Object,
      default() {
        return {
          name: '',
          id_koperasi: '',
          image: '',
          alamat: '',
          telepon: '',
          id_kelompok: 'belum masuk',
          simwa: 0,
          simwapi: 0,
          simpok: 0,
          simhara: 0,
          sihasu: 0,
          status: ''
        };
      }
    },
    index: Number
  },
  data() {
    return {
      selected: ''
    };
  },
  computed: {
    foto() {
      return this.$store.getters['auth/serverUrl'] + this.data.image;
    },
    kelompok() {
      if (this.id_kelompok != null) {
        return this.id_kelompok;
      } else {
        return 'belum masuk kelompok';
      }
    },
    status() {
      switch (this.data.status) {
        case 1:
          return 'belum aktif';
          // eslint-disable-next-line no-unreachable
          break;
        case 2:
          return 'aktif';
          // eslint-disable-next-line no-unreachable
          break;
        case 3:
          return 'berhenti';
          // eslint-disable-next-line no-unreachable
          break;

        default:
          return 'data tidak ditemukan';
          // eslint-disable-next-line no-unreachable
          break;
      }
    }
  },
  methods: {
    masuk() {
      this.selected = 'is-selected';
    },
    keluar() {
      this.selected = '';
    },
    detail() {
      console.log(this.data.id);
    }
  }
};
</script>

<style lang="scss" scoped>
th,
td {
  vertical-align: middle;
}
.dalam-tabel {
  border: 0px solid;
}
tr.is-selected {
  background-color: #00913f;
}
</style>
