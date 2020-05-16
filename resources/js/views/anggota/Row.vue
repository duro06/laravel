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
    <td>
      <span :class="[statusClass, 'tombol']"> {{ status }} </span>
    </td>
    <td>
      <button :class="['button', warna]" @click="gantiStatus">{{ keterangan }}</button>
    </td>
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
      return this.data.status == 1
        ? 'Belum Aktif'
        : this.data.status == 2
        ? 'Aktif'
        : this.data.status == 3
        ? 'Berhenti'
        : 'data tidak ditemukan';
    },
    statusClass() {
      return this.data.status == 1
        ? 'yellow'
        : this.data.status == 2
        ? 'green'
        : this.data.status == 3
        ? 'red'
        : 'yellow';
    },
    warna() {
      return this.data.status == 2 ? 'is-danger' : 'warna-tema';
    },
    keterangan() {
      return this.data.status == 1
        ? 'aktifkan'
        : this.data.status == 2
        ? 'berhenti'
        : this.data.status == 3
        ? 're-aktivasi'
        : 'aktivasi';
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
    },
    gantiStatus() {
      let status =
        this.data.status == 1 ? 2 : this.data.status == 2 ? 3 : this.data.status == 3 ? 2 : 2;
      this.$emit('gantiStatus', status);
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
  background-color: #ecf5d0;
  color: black;
}
.tombol {
  display: inline-flex;

  padding: 10px;
  border-radius: 5px;
}
.yellow {
  color: yellowgreen;
  font-weight: 700;
}
.red {
  color: red;
  font-weight: 700;
}
.green {
  color: #00913e;
  font-weight: 700;
}
</style>
