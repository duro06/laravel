<template>
  <div class="canvas">
    <div class="canvas">
      <div class="columns">
        <div class="column is-3">
          <div class="bingkai">
            <div class="bingkai2">
              <!-- <figure class="image is-4by5"> -->
              <div class="avatar-profile">
                <img class="avatar-ku" :src="displayImage" ref="displayAvatarImage" alt="avatar" />
                <div class="edit-avatar">
                  <input type="file" ref="editAvatar" id="image" @change="attachImage" />
                  <label for="image"> Change Avatar </label>
                </div>
              </div>
              <!-- </figure> -->
            </div>
          </div>
        </div>
        <div class="column is-5">
          <h1 class="has-text-centered"><B> Identitas </B></h1>
          <div class="tengahin">
            <table class="table is-fullwidth">
              <tbody>
                <tr>
                  <th class="no-border">Nama</th>
                  <td class="no-border">{{ user.name }}</td>
                </tr>
                <tr>
                  <th class="no-border">ID Koperasi</th>
                  <td class="no-border has-button-right" v-if="hasIdKop">
                    {{ user.member.id_koperasi }}
                    <span v-if="hasIdKop && adminInCharge">
                      <a :class="['button', 'warna-tema', 'tombol', loading]" @click.prevent="pisahkan" :disable="disable">
                        <span class="icon-dibutton"><i class="fas fa-unlink"></i></span> Pisahkan
                      </a>
                    </span>
                  </td>
                  <td class="no-border" v-if="!hasIdKop">
                    <button class="button warna-tema" @click="hasMember">Tautkan dengan data anggota</button>
                  </td>
                </tr>
                <tr>
                  <th class="no-border">Alamat</th>
                  <td class="no-border">{{ user.alamat }}</td>
                </tr>
                <tr>
                  <th class="no-border">Nomor Telepon</th>
                  <td class="no-border">{{ user.telepon }}</td>
                </tr>
                <tr>
                  <th class="no-border">Kelompok</th>
                  <td class="no-border">{{ kelompok }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <button class="button warna-tema" style="margin-top:20px" @click="editProfile">
            <span class="icon-dibutton"><i class="fas fa-pencil-alt"></i></span> Edit
          </button>
        </div>
        <div class="column is-4" v-if="hasIdKop">
          <h1 class="has-text-centered"><B>Hak Anggota</B></h1>
          <table class="table is-fullwidth">
            <tbody>
              <tr>
                <th class="no-border">Simpanan Pokok</th>
                <td class="no-border">{{ simpananPokok }}</td>
              </tr>
              <tr>
                <th class="no-border">Simpanan Wajib</th>
                <td class="no-border">data belum siap</td>
              </tr>
              <tr>
                <th class="no-border">Simpanan Wajib Pinjam</th>
                <td class="no-border">data belum siap</td>
              </tr>
              <tr>
                <th class="no-border">Simpanan Hari Raya</th>
                <td class="no-border">data belum siap</td>
              </tr>
              <tr>
                <th class="no-border">Sisa Hasil Usaha</th>
                <td class="no-border">data belum siap</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <transition name="modal">
      <Modal v-if="modalEdit" @close="handleEdit" class="modal">
        <header slot="header" class="modal-card-head">
          <p class="modal-card-title ">
            Ganti Status Anggota
          </p>
        </header>
        <section slot="body" class="modal-card-body ">
          <div class="masuk ">
            <div class="control">
              <input-label label="Nama" iconLeft="fa-money-check-alt" placeholder="Nama" v-model="user.name" :value="user.name"></input-label>
              <!-- <div class="field is-horizontal">
                <div class="field-label is-normal">
                  <label class="label">Email</label>
                </div>
                <div class="field-body">
                  <div class="field">
                    <p class="control">
                      <input-email v-model="user.email" :value="user.email"></input-email>
                    </p>
                  </div>
                </div>
              </div> -->
              <input-label label="Alamat" iconLeft="fa-money-check-alt" placeholder="Alamat" v-model="user.alamat"></input-label>
              <input-label label="Telepon" iconLeft="fa-money-check-alt" placeholder="Telepon" v-model="user.telepon"></input-label>
            </div>
          </div>
        </section>
        <footer slot="footer" class="modal-card-foot ">
          <button class="button warna-tema is-rounded" :class="loading" @click.prevent="submit" :disabled="disable">
            Kirimkan
          </button>
          <button class="button is-rounded" @click.prevent="handleEdit">
            Batal
          </button>
        </footer>
      </Modal>
    </transition>
    <transition name="modal">
      <Modal v-if="modalCari" @close="handleCari" class="modal">
        <header slot="header" class="modal-card-head">
          <p class="modal-card-title ">
            Tautkan dengan anggota
          </p>
        </header>
        <section slot="body" class="modal-card-body ">
          <div class="masuk ">
            <div class="control">
              <Search :load="loading" @search="handleSearch" v-model="search" class="anak" placeholder="Cari Nama" />
            </div>
            <table class="table  is-fullwidth" v-if="members.length">
              <thead>
                <tr>
                  <th><abbr title="Gambar">Foto</abbr></th>
                  <th><abbr title="status anggota">Nama</abbr></th>
                  <th><abbr title="Action"> </abbr></th>
                  <th><abbr title="Action"> </abbr></th>
                </tr>
              </thead>
              <tbody>
                <Row v-for="(item, apem) in members" :key="apem" :data="item" :index="apem" @done="handleCari" />
              </tbody>
            </table>
          </div>
        </section>
        <footer slot="footer" class="modal-card-foot ">
          <button class="button is-rounded" @click.prevent="handleCari">
            Batal
          </button>
        </footer>
      </Modal>
    </transition>
  </div>
</template>

<script>
import * as auth from '../../services/auth_service';
import { mapState, mapActions } from 'vuex';
export default {
  name: 'detail-anggota',
  components: {
    Modal: () => import(/* webpackChunkName: "modal" */ '../../components/base/Modal'),
    'input-label': () => import(/* webpackChunkName: "input-label" */ '../../components/base/InputValidate'),
    Search: () => import(/* webpackChunkName: "input-search" */ '../../components/base/Search'),
    Row: () => import(/* webpackChunkName: "input-row" */ './Row')
  },
  data() {
    return {
      displayImage: '',
      user: {},
      loading: '',
      modalEdit: false,
      modalCari: false,
      disable: false,
      search: ''
    };
  },
  created() {
    //   this.getUser(this.$route.params.id).then(() => {
    // this.loadImage();
    //   });
  },
  watch: {
    User: {
      handler: 'loadImage',
      immediate: true
    }
  },
  computed: {
    ...mapState('user', {
      User: state => state.user
    }),
    ...mapState('member', {
      members: state => state.members
    }),
    kelompok() {
      return this.user.member == undefined
        ? 'tidak tertaut dengan member'
        : this.user.member.id_kelompok == null
        ? 'belum ada kelompok'
        : 'data kelompok belum ada';
    },
    hasIdKop() {
      return this.user.member == undefined ? false : true;
    },
    adminInCharge() {
      return this.User.role == 'Admin' && this.User.status == 1 ? true : false;
    },
    simpananPokok() {
      return this.user.member.simpanan_pokok != 0 ? 'Rp ' + new Intl.NumberFormat().format(this.user.member.simpanan_pokok) : 0;
    }
  },
  methods: {
    ...mapActions('user', ['getUser', 'updateImage', 'unlinkToMember']),
    ...mapActions('member', ['getMember']),
    pisahkan() {
      this.loading = 'is-loading';
      this.unlinkToMember().then(() => {
        this.loading = '';
        this.getUser();
      });
    },
    hasMember() {
      this.modalCari = true;
    },
    cari(data) {
      console.log(data);
    },
    handleCari() {
      this.modalCari = false;
    },
    handleSearch(value) {
      this.search = value;
      this.loading = 'is-loading';
      this.getMember(value).then(() => {
        this.loading = '';
      });
    },
    submit() {
      this.disable = true;
      this.loading = 'is-loading';
      this.updateProfile(this.user).then(() => {
        this.getUser();
        this.disable = false;
        this.loading = '';
        this.modalEdit = false;
      });
    },

    editProfile() {
      this.user.simPok = this.user.simpanan_pokok;
      this.modalEdit = true;
    },

    handleEdit() {
      this.modalEdit = false;
    },
    loadImage: function() {
      let image = this.User.image;
      this.user = this.User;
      if (image !== null) {
        return (this.displayImage = this.$store.getters['auth/storageUrl'] + image);
      }
      return (this.displayImage = this.$store.getters['auth/storageUrl'] + `users_images/nouser.png`);
    },

    attachImage: async function() {
      this.user.image = this.$refs.editAvatar.files[0];
      let reader = new FileReader();

      reader.addEventListener(
        'load',
        function() {
          this.$refs.displayAvatarImage.src = reader.result;
        }.bind(this),
        false
      );

      reader.readAsDataURL(this.user.image);

      const formData = new FormData();
      formData.append('image', this.user.image);
      formData.append('_method', 'put');
      formData.append('id', this.user.id);

      try {
        const response = await auth.updateUserImage(this.user.id, formData);

        this.getUser();
        this.flashMessage.success({
          message: 'Avatar has been updated successfully!',
          time: 5000
        });
        this.user.image = response.data.image;
        // eslint-disable-next-line no-empty
      } catch {}
    }
  }
};
</script>

<style lang="scss" scooped>
.bingkai {
  border: 2px solid gray;
  padding: 3px;
  border-radius: 9px;
}
.bingkai2 {
  border: 1px solid gray;
  padding: 6px;
  border-radius: 5px;
}
table {
  th,
  td,
  .no-border {
    border: 0px solid;
    border-width: 0px 0px 0px;
  }
}
h1 {
  margin-bottom: 40px;
}
.has-button-right {
  display: flex;
  justify-content: space-between;
}

.tombol {
  display: inline-flex;
  padding: 5px 10px;
  border-radius: 5px;
}
// .edit-avatar {
//   margin-left: -19px;
// }
</style>
