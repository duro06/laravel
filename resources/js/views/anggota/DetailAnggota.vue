<template>
  <div class="detail">
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
                  <td class="no-border">{{ member.name }}</td>
                </tr>
                <tr>
                  <th class="no-border">ID Koperasi</th>
                  <td class="no-border">{{ member.id_koperasi }}</td>
                </tr>
                <tr>
                  <th class="no-border">Alamat</th>
                  <td class="no-border">{{ member.alamat }}</td>
                </tr>
                <tr>
                  <th class="no-border">Nomor Telepon</th>
                  <td class="no-border">{{ member.telepon }}</td>
                </tr>
                <tr>
                  <th class="no-border">Kelompok</th>
                  <td class="no-border">{{ member.id_kelompok }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <button class="button warna-tema" style="margin-top:20px" @click="editProfile">
            <span class="icon-dibutton"><i class="fas fa-pencil-alt"></i></span> Edit
          </button>
        </div>
        <div class="column is-4">
          <h1 class="has-text-centered"><B>Hak Anggota</B></h1>
          <table class="table is-fullwidth">
            <tbody>
              <tr>
                <th class="no-border">Simpanan Pokok</th>
                <td class="no-border">{{ member.simpanan_pokok }}</td>
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
              <input-label label="Simpanan Pokok" iconLeft="fa-money-check-alt" placeholder="Simpanan Pokok" v-model="user.simPok"></input-label>
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
  </div>
</template>

<script>
import * as auth from '../../services/auth_service';
import { mapState, mapActions } from 'vuex';
export default {
  name: 'detail-anggota',
  components: {
    Modal: () => import(/* webpackChunkName: "modal" */ '../../components/base/Modal'),
    'input-label': () => import(/* webpackChunkName: "input" */ '../../components/base/InputValidate')
  },
  data() {
    return {
      displayImage: '',
      user: {},
      loading: '',
      modalEdit: false,
      disable: false
    };
  },
  created() {
    this.getMemberById(this.$route.params.id).then(() => {
      this.loadImage();
    });
  },
  mounted() {},
  computed: {
    ...mapState('member', {
      member: state => state.member
    })
  },
  methods: {
    ...mapActions('member', ['getMemberById']),
    submit() {},

    editProfile() {
      this.user.simPok = this.user.simpanan_pokok;
      console.log('simpok', this.user.simPok);
      this.modalEdit = true;
    },

    handleEdit() {
      this.modalEdit = false;
    },
    loadImage: function() {
      let image = this.member.image;
      console.log(image);
      console.log(this.member);
      this.user = this.member;
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
        const response = await auth.updateImage(this.user.id, formData);
        console.log(response);
        this.flashMessage.success({
          message: 'Avatar has been updated successfully!',
          time: 5000
        });
        this.user.image = response.data.image;
      } catch (error) {
        this.flashMessage.error({
          message: error.response.data.message,
          time: 5000
        });
      }
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
// .tengahin {
//   margin-top: 30px;
// }
</style>
