<template>
  <tr>
    <!-- <tr class="inner" :class="selected"> -->
    <td>{{ data.nama }}</td>
    <!-- </tr> -->
    <td class="has-text-right">
      <div v-if="!data.deleted_at">
        <a class="is-info button button-ditabel" @click.prevent="edit" :disable="disable">
          <span class="icon-dibutton"><i class="fas fa-pencil-alt"></i></span> Edit
        </a>
        <a :class="['is-danger', 'button', 'button-ditabel', loadingDel]" @click.prevent="hapus" :disable="disable">
          <span class="icon-dibutton"><i class="fas fa-trash-alt"></i></span> Hapus
        </a>
      </div>
      <div v-if="data.deleted_at">
        <a :class="['is-danger', 'button', 'button-ditabel', loadingDel]" @click.prevent="restore" :disable="disable">
          <span class="icon-dibutton"><i class="fas fa-trash-restore"></i></span> Kembalikan
        </a>
      </div>
    </td>
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
          name: ''
        };
      }
    },
    index: Number,
    load: String
  },
  data() {
    return {
      selected: '',
      loading: this.load,
      disable: false,
      loadingDel: ''
    };
  },
  computed: {},
  methods: {
    ...mapActions('dana', ['getHakAnggota', 'editData', 'deleteData', 'restoreData']),
    masuk() {
      this.selected = 'is-selected';
    },
    keluar() {
      this.selected = '';
    },
    edit() {
      this.$emit('edit', this.data);
    },
    hapus() {
      this.loadingDel = 'is-loading';
      this.disable = true;
      let data = new FormData();
      data.append('id', this.data.id);
      this.deleteData(data).then(() => {
        this.disable = false;
        this.getHakAnggota();
        this.loadingDel = '';
      });
      this.$emit('delete', this.data);
    },
    restore() {
      this.loadingDel = 'is-loading';
      this.disable = true;
      let data = new FormData();
      data.append('id', this.data.id);
      this.restoreData(data).then(() => {
        this.disable = false;
        this.getHakAnggota();
        this.loadingDel = '';
      });
      this.$emit('restore', this.data);
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

.button-ditabel {
  height: 2em;
}
</style>
