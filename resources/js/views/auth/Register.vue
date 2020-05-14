<template>
  <section class="hero is-fullheight is-flex-mobile">
    <div class="hero-body">
      <div class="container has-text-centered">
        <div class="column is-5 is-offset-4 box">
          <div class="field fadeInUp">
            <figure class="avatar">
              <img :src="logo" />
            </figure>
          </div>
          <form
            action="#"
            @submit.prevent="register"
            class="is-light is-danger has-text-left login-form"
          >
            <div class="field fadeInUp">
              <div class="field">
                <div class="control has-icons-left">
                  <input
                    @change="NameValidation"
                    :class="['input', className]"
                    type="name"
                    placeholder="Nama"
                    name="name"
                    autocomplete="on"
                    v-model="user.name"
                  />
                  <span class="icon is-small is-left">
                    <i class="fas fa-portrait"></i>
                  </span>
                </div>
                <p :class="['help', 'align-left', className]">
                  {{ validName }}
                </p>
              </div>
            </div>

            <div class="field fadeInUp">
              <div class="field">
                <div class="control has-icons-left has-icons-right">
                  <input
                    @change="formValidation"
                    :class="['input', classDanger]"
                    type="email"
                    name="email"
                    autocomplete="on"
                    placeholder="Email"
                    v-model="user.email"
                  />
                  <span class="icon is-small is-left">
                    <i class="fas fa-envelope"></i>
                  </span>
                  <span class="icon is-small is-right" :style="{ visibility: visClass }">
                    <i class="fas fa-exclamation-triangle"></i>
                  </span>
                </div>
                <p :class="['help', 'align-left', classDanger]">
                  {{ validMail }}
                </p>
              </div>
            </div>

            <div class="field fadeInUp">
              <div class="field">
                <div class="control has-icons-left has-icons-right">
                  <input
                    @change="validasiAlamat"
                    :class="['input', classAddress]"
                    type="text"
                    name="alamat"
                    autocomplete="on"
                    placeholder="Alamat"
                    v-model="user.alamat"
                  />
                  <span class="icon is-small is-left">
                    <i class="fas fa-map-marker-alt"></i>
                  </span>
                  <span class="icon is-small is-right" :style="{ visibility: visAddress }">
                    <i class="fas fa-exclamation-triangle"></i>
                  </span>
                </div>
                <p :class="['help', 'align-left', classAddress]">
                  {{ validAddress }}
                </p>
              </div>
            </div>

            <div class="field fadeInUp">
              <div class="field">
                <div class="control has-icons-left has-icons-right">
                  <input
                    @change="validasiTelepon"
                    :class="['input', classPhone]"
                    type="number"
                    name="telepon"
                    autocomplete="on"
                    placeholder="Telepon"
                    v-model="user.telepon"
                  />
                  <span class="icon is-small is-left">
                    <i class="fas fa-phone"></i>
                  </span>
                  <span class="icon is-small is-right" :style="{ visibility: visPhone }">
                    <i class="fas fa-exclamation-triangle"></i>
                  </span>
                </div>
                <p :class="['help', 'align-left', classPhone]">
                  {{ validPhone }}
                </p>
              </div>
            </div>

            <div class="field fadeInUp">
              <div class="field">
                <div class="control has-icons-left">
                  <div :class="['select', valSelect, 'is-small']">
                    <select v-model="user.role" @change="validasiSelect">
                      <option value="">Daftar sebagai</option>
                      <option v-for="(level, t) in levels" :key="t">
                        {{ level.nama }}
                      </option>
                    </select>
                  </div>
                  <span class="icon is-small is-left">
                    <i class="far fa-id-card"></i>
                  </span>
                </div>
                <p :class="['help', 'align-left', 'is-danger']" :style="{ display: classSelect }">
                  {{ validSelect }}
                </p>
              </div>
            </div>

            <div class="field fadeInUp">
              <div class="field">
                <div class="control has-icons-left has-icons-right">
                  <input
                    @change="passOk"
                    :class="['input', validPass]"
                    type="password"
                    placeholder="Password"
                    v-model="user.password"
                  />
                  <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                  </span>
                  <span class="icon is-small is-right is-success" :style="{ visibility: visPass }">
                    <i class="fas fa-check"></i>
                  </span>
                </div>
                <p :class="['help', 'lign-left', validPass]">
                  {{ passCheck }}
                </p>
              </div>
            </div>

            <div class="field fadeInUp">
              <div class="field">
                <div class="control has-icons-left has-icons-right">
                  <input
                    :class="['input', classKonfirm]"
                    type="password"
                    placeholder="Konfirmasi Password"
                    v-model="user.password_confirmation"
                  />
                  <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                  </span>
                  <span class="icon is-small is-right is-success" :style="{ visibility: kPass }">
                    <i class="fas fa-check"></i>
                  </span>
                </div>
                <p :class="['help', 'lign-left', konfirm()]">
                  {{ passKonfirm }}
                </p>
              </div>
            </div>

            <div class="field fadeInUp">
              <div class="has-text-centered">
                <button
                  :class="[
                    'button',
                    'is-vcentered',
                    'is-primary',
                    'is-outlined',
                    loading,
                    ,
                    'is-rounded'
                  ]"
                  @click.prevent="register"
                >
                  Daftar
                </button>
              </div>
            </div>
          </form>
        </div>
        <div class="field fadeInUp">
          <div class="has-text-centered">
            <router-link :to="{ name: 'login' }">
              Sudah Punya Akun?
              <strong style="text-decoration:underline;">Log in</strong>
              Sekarang !
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
// import * as pusher from "@/services/pusher_service.js";
export default {
  name: 'signup',
  data() {
    return {
      // data User
      user: {
        name: '',
        email: '',
        alamat: '',
        telepon: '',
        role: '',
        password: '',
        password_confirmation: ''
      },
      // pilihan Role
      levels: [
        // { id: "", nama: "Pilih bagian" },
        { id: 2, nama: 'Admin' },
        { id: 3, nama: 'Anggota' }
      ],
      //validasi select
      valSelect: '',
      classSelect: 'hidden',
      validSelect: '',
      //validasi nama
      className: '',
      validName: '',
      //validasi email
      classDanger: '',
      visClass: 'hidden',
      validMail: '',

      //validasi alamat
      classAddress: '',
      visAddress: 'hidden',
      validAddress: '',

      //validasi telepon
      classPhone: '',
      visPhone: 'hidden',
      validPhone: '',
      //validasi password
      validPass: '',
      visPass: 'hidden',
      passCheck: '',
      //validasi konfirmasi password
      classKonfirm: '',
      kPass: 'hidden',
      passKonfirm: '',

      loading: '', // kelas bulma button spinner 'is-loading'
      Vmail: false, //boolean validasi email
      Vpass: false, //boolean validasi password
      // validasi usernama, ga di pake sekarang, tapi simpen dulu aja
      reg2: /^[a-z0-9]+$/i,
      // validasi email
      reg: /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/
    };
  },
  // backup plan kalo gagal redirect ke halaman waiting, untuk menuggu verifikasi
  // updated() {
  //   if (localStorage.getItem("waiting_verivication")) {
  //     this.$router.replace(this.$route.query.redirect || "/waiting");
  //   }
  // },
  computed: {
    logo() {
      return this.$store.getters['auth/storageUrl'] + '/galleries_images/logo.png';
    }
  },

  methods: {
    register: function() {
      console.log('register');
      // shortcut this
      const vm = this;
      //jika email dan password valid
      if (
        vm.Vpass == true &&
        vm.Vmail == true &&
        this.user.nama != '' &&
        this.user.alamat != '' &&
        this.user.telepon != '' &&
        this.user.role != ''
      ) {
        console.log('register Valid');
        vm.loading = 'is-loading'; // button spinner enable
        //panggil fungsi "register" di action nya vuex, bawa data user
        vm.$store
          .dispatch('auth/register', this.user)
          .then(response => {
            // pusher.register(response.data.data.id);
            // tampilkan flas message
            this.flashMessage.success({
              message: response.data.message,
              time: 5000
            });
            vm.loading = ''; // button spinner
            this.errors = [];
            this.$router.replace({ name: 'home' }, () => {}); // arahkan ke halaman waiting untuk menuggu verifikasi
          })
          .catch(error => {
            if (error) {
              console.log('error', error.response.status);
              //jika email sudah ada yang pake kosongkan dah kasih tanda
              let email = '';
              let role = '';
              switch (error.response.status) {
                case 422:
                  email = error.response.data.errors.email;
                  role = error.response.data.errors.role;
                  if (email) {
                    this.user.email = '';
                    this.mailString(
                      'is-danger',
                      'visible',
                      error.response.data.errors.email[0] +
                        '\n' +
                        ' Please use another email address',
                      false
                    );
                  }
                  if (role) {
                    this.valSelect = 'is-danger';
                    this.classSelect = 'inherit';
                    this.validSelect =
                      error.response.data.errors.role[0] + '\n' + ' Please choose one';
                  }

                  this.errors = error.response.data.errors;
                  break;

                case 500:
                  this.flashMessage.error({
                    message: error.response.data.message + ' Please refresh',
                    time: 5000
                  });
                  break;

                case 405:
                  this.flashMessage.error({
                    message: error.response.data.message + ' Make some',
                    time: 5000
                  });
                  break;

                default:
                  this.flashMessage.error({
                    message: 'Some error occured, Please Try Again!',
                    time: 5000
                  });
                  break;
              }

              vm.loading = ''; // button spinner disable
            }
          })
          .then(function() {
            // always executed
          });
        //jika tidak cek semua data, jika ada salahsatu yang kosong panggil semua validasi
      } else if (
        vm.user.name == '' ||
        vm.user.email == '' ||
        vm.user.alamat == '' ||
        vm.user.role == '' ||
        vm.user.telepon == '' ||
        vm.user.password == ''
      ) {
        vm.NameValidation();
        vm.validasiAlamat();
        vm.validasiSelect();
        vm.validasiTelepon();
        vm.formValidation();
        vm.passOk();
        this.flashMessage.error({
          message: 'silahkan isi dahulu yang belum di isi',
          time: 5000
        });
      } else {
        this.flashMessage.error({
          message: 'silahkan isi dahulu yang belum di isi',
          time: 5000
        });
      }
    },
    //= ===================== ngisi pesan aja ===============
    mailString(kelas, visib, pesan, pass) {
      const vm = this;
      vm.classDanger = kelas;
      vm.visClass = visib;
      vm.validMail = pesan;
      vm.Vmail = pass;
    },
    passString(kelas, visib, pesan, pass) {
      const vm = this;
      vm.validPass = kelas;
      vm.visPass = visib;
      vm.passCheck = pesan;
      vm.Vpass = pass;
    },
    //= ===================== Validasi nama ===============
    NameValidation() {
      if (this.user.name == '') {
        this.className = 'is-danger';
        this.validName = 'Nama tidak boleh kosong';
      } else {
        this.className = '';
        this.validName = '';
      }
    },
    //= ===================== Validasi Level ===============

    validasiSelect() {
      if (this.user.role == '') {
        this.valSelect = 'is-danger';
        this.classSelect = 'inherit';
        this.validSelect = 'Pilih salas satu';
      } else {
        this.valSelect = '';
        this.classSelect = 'none';
        this.validSelect = '';
      }
    },

    //= ===================== Validasi Alamat ===============

    validasiAlamat() {
      if (this.user.alamat == '') {
        this.classAddress = 'is-danger';
        this.visAddress = 'visible';
        this.validAddress = 'Tidak boleh kosong';
      } else {
        this.classAddress = '';
        this.visAddress = 'hidden';
        this.validAddress = '';
      }
    },
    //= ===================== Validasi Telepon ===============

    validasiTelepon() {
      if (this.user.telepon == '') {
        this.classPhone = 'is-danger';
        this.visPhone = 'visible';
        this.validPhone = 'Tidak boleh kosong';
      } else {
        this.classPhone = '';
        this.visPhone = 'hidden';
        this.validPhone = '';
      }
    },
    // //====================== Validasi konfirm password ===============
    konfirm() {
      const vm = this;
      if (
        vm.user.password != vm.user.password_confirmation &&
        vm.user.password_confirmation != ''
      ) {
        vm.classKonfirm = 'is-danger';
        vm.kPass = 'hidden';
        vm.passKonfirm = 'Tidak sama';
        vm.Vpass = false;
      } else if (
        vm.user.password == vm.user.password_confirmation &&
        vm.user.password_confirmation != ''
      ) {
        vm.classKonfirm = 'is-success';
        vm.kPass = 'visible';
        vm.passKonfirm = '';
        vm.Vpass = true;
      } else {
        vm.classKonfirm = '';
        vm.kPass = 'hidden';
        vm.passKonfirm = '';
      }
    },
    //= ================ validasi email =====================
    formValidation: function() {
      const vm = this;
      if (vm.user.email != '') {
        if (vm.reg.test(vm.user.email) == false) {
          vm.mailString('is-danger', 'visible', 'periksa kembali email anda', false);
        } else if (vm.reg.test(vm.user.email) == true) {
          vm.mailString('is-success', 'hidden', '', true);
        }
      } else if (vm.user.email >= 80) {
        vm.mailString('is-danger', 'visible', 'tidak boleh lebih dari 80 karakter', false);
      } else if (vm.user.email == '') {
        vm.mailString('is-danger', 'visible', 'tidak boleh kosong', false);
      } else {
        vm.mailString('', 'hidden', '', false);
      }
      return vm.classDanger;
    },
    //= ================== validasi Password ==================
    passOk: function() {
      const vm = this;
      if (vm.user.email != '' && vm.validMail == '' && vm.user.password != '') {
        if (vm.user.password.length <= 5) {
          vm.passString('is-danger', 'hidden', 'password anda kurang dari 6 karakter', false);
        } else {
          vm.passString('is-success', 'visible', '', true);
        }
      } else if (vm.user.password != '' && vm.user.email == '') {
        vm.passString('is-danger', 'hidden', 'Email anda kosong', false);
      } else if (vm.user.password != '' && vm.validMail != '') {
        vm.passString('is-danger', 'hidden', 'Email anda belum valid', false);
      } else if (vm.user.password == '' && vm.user.email != '') {
        vm.passString('is-warning', 'hidden', 'Password tidak boleh kosong', false);
      } else if (vm.user.password == '' && vm.user.email == '') {
        vm.passString('is-danger', 'hidden', 'Password tidak boleh kosong', false);
      } else {
        vm.passString('', 'hidden', '', false);
      }
      return vm.validPass;
    }
  }
};
</script>

<style scoped>
@keyframes fadeInUp {
  0% {
    opacity: 0;
    -webkit-transform: translate3d(0, 30%, 0);
    -ms-transform: translate3d(0, 30%, 0);
    transform: translate3d(0, 30%, 0);
  }
  100% {
    opacity: 1;
    -webkit-transform: none;
    -ms-transform: none;
    transform: none;
  }
}

.fadeInUp {
  animation-name: fadeInUp;
  animation-timing-function: ease-out;
}

/* @import "../../assets/css/login.css"; */
.hero-body {
  padding-top: 20px;
  padding-bottom: 20px;
}

img {
  width: 20%;
  height: auto;
}
.slide-fade-enter-active {
  transition: all 0.8s ease;
}
.slide-fade-leave-active {
  transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}
.slide-fade-enter, .slide-fade-leave-to
/* .slide-fade-leave-active below version 2.1.8 */ {
  transform: translateX(10px);
  opacity: 0;
}
</style>
