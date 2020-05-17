<template>
  <tr @mouseenter="masuk" @mouseleave="keluar" :class="selected">
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
      <a :class="[statusClass, 'tombol']" @click.prevent="gantiStatus"> {{ status }} </a>
      <a class="warna-tema tombol" @click.prevent="detail">
        <span class="icon-dibutton"><i class="fas fa-pencil-alt"></i></span> Detail
      </a>
    </td>
    <!-- <td>
      <button :class="['button', warna]" >{{ keterangan }}</button>
    </td> -->
  </tr>
</template>

<script>
import { mapActions } from 'vuex';
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
      return this.data.status == 1 ? 'Belum Aktif' : this.data.status == 2 ? 'Aktif' : this.data.status == 3 ? 'Berhenti' : 'data tidak ditemukan';
    },
    icon() {
      return this.data.status == 2 ? 'fa-check' : 'fa-times-circle';
    },
    statusClass() {
      return this.data.status == 1 ? 'yellow' : this.data.status == 2 ? 'warna-tema' : this.data.status == 3 ? 'red' : 'yellow';
    },
    warna() {
      return this.data.status == 2 ? 'is-danger' : 'warna-tema';
    },
    keterangan() {
      return this.data.status == 1 ? 'aktifkan' : this.data.status == 2 ? 'berhenti' : this.data.status == 3 ? 're-aktivasi' : 'aktivasi';
    }
  },
  methods: {
    ...mapActions('member', ['getMemberById']),
    masuk() {
      this.selected = 'is-selected';
    },
    keluar() {
      this.selected = '';
    },
    detail() {
      this.getMemberById(this.data.id).then(() => {
        this.$router.replace(this.$route.query.redirect || { name: 'detail' }, () => {});
      });
    },
    gantiStatus() {
      let status = this.data.status == 1 ? 2 : this.data.status == 2 ? 3 : this.data.status == 3 ? 2 : 2;
      let data = {
        status: status,
        id: this.data.id
      };
      this.$emit('gantiStatus', data);
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
  padding: 5px 10px;
  border-radius: 5px;
}
.yellow {
  background-color: yellowgreen;
  color: black;
  font-weight: 700;
}
.red {
  background-color: red;
  color: white;
  font-weight: 700;
}
.green {
  background-color: #00913e;
  color: white;
  font-weight: 700;
}
</style>
