<template>
  <div class="login">
    <section class="hero is-fullheight">
      <div class="hero-body">
        <div class="container has-text-centered">
          <div class="column is-5 is-offset-4 box">
            <div class="fadeInUp">
              <h1 class="avatar has-text-centered">
                <img :src="logo" alt="logo" />
              </h1>
            </div>

            <transition name="slide-fade">
              <div class="none">
                <p id="log" class="subtitle has-text-black">
                  Please login to proceed.
                </p>
              </div>
            </transition>
            <form action class="has-text-left">
              <div class="login-form">
                <div role="form" method="post">
                  <div class="field fadeInUp">
                    <p class="help align-left is-danger" :style="{ display: mailMessage }">
                      {{ mail }}
                    </p>
                    <p class="control has-icons-left has-icons-right">
                      <input :class="['input', classDanger]" type="email" placeholder="Email" data-lpignore="true" v-model="user.email" />
                      <span class="icon is-small is-left">
                        <i class="fas fa-envelope"></i>
                      </span>
                      <span
                        class="icon is-small is-right"
                        :style="{
                          visibility: visClass
                        }"
                      >
                        <i class="fas fa-exclamation-triangle"></i>
                      </span>
                    </p>
                    <p :class="['help', 'align-left', classDanger, formValidation()]" :style="{ visibility: visClass }">
                      {{ validMail }}
                    </p>
                  </div>

                  <div class="field fadeInUp">
                    <p class="control has-icons-left has-icons-right">
                      <input :class="['input', passOk()]" type="password" placeholder="Password" data-lpignore="true" v-model="user.password" />
                      <span class="icon is-small is-left">
                        <i class="fas fa-lock"></i>
                      </span>
                      <span class="icon is-small is-right is-success" :style="{ visibility: visPass }">
                        <i class="fas fa-check"></i>
                      </span>
                    </p>
                    <p :class="['help', 'lign-left', passOk()]">
                      {{ passCheck }}
                    </p>
                  </div>

                  <div class="field fadeInUp level">
                    <div class="level-item has-text-centered ">
                      <input type="checkbox" v-model="user.remember" />
                      <label class="checkbox is-size-7 ">
                        Remember me
                      </label>
                    </div>
                  </div>
                  <div class="field fadeInUp">
                    <p class="control">
                      <button
                        @click.prevent="submitForm"
                        :class="['button', 'is-block', 'warna-tema', 'is-fullwidth', loading, 'is-rounded']"
                        :disabled="disable"
                      >
                        Login
                      </button>
                    </p>
                  </div>
                </div>
              </div>
              <hr />
              <div class="forgot-password fadeInUp">
                <p class="has-text-centered has-text-small">
                  Did you
                  <router-link class="is-small" :to="{ path: '/forgot' }">forgot your password</router-link>
                  or
                  <router-link :to="{ name: 'register' }">need an account?</router-link>
                </p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import * as auth from '../../services/auth_service';

export default {
  name: 'login',
  data() {
    return {
      //data user
      user: {
        email: '',
        password: '',
        device_name: navigator.userAgent
      },
      errors: {}, // belum dipakai, ga tau fungsinya juga sih
      disable: false, //disable/enable button login
      classDanger: '', // class valisdasi email
      visClass: 'hidden', //validasi email
      validMail: '', //validasi email
      // untuk ngecek email
      reg: /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
      visPass: 'hidden', //validasi password (class nya, merubah sedikit css nya)
      passCheck: '', //validasi password
      validPass: '', //validasi passsword
      Vmail: false, // boolean email sudah valid atau belum, jika sudah valid bisa masuk proses selanjutnya
      Vpass: false, // boolean password sudah valid atau belum, idem yang atas
      loading: '', // kelas loading button
      mailMessage: 'none', // return mail error 401
      mail: ''
    };
  },
  computed: {
    logo() {
      return this.$store.getters['auth/storageUrl'] + '/galleries_images/logo.png';
    },
    // check isi vuex, sedang login atau tidak
    logged() {
      return this.$store.getters.loggedIn;
    }
  },
  methods: {
    submitForm: async function() {
      //jika email dan password sudah di validai
      if (this.Vpass == true && this.Vmail == true) {
        this.loading = 'is-loading'; // button spinner on
        this.disable = true; //disable button
        try {
          // eslint-disable-next-line no-unused-vars
          const response = await auth.login(this.user); // paggil fungsi login dari auth dengan membawa data user
          this.loading = ''; // button spinner off
          this.disable = false; // button enable
          this.errors = {}; // sepertinya belum berfungsi membesihkan error dengan baik dan benar
          location.reload();
          this.$router.replace(this.$route.query.redirect || { name: 'dashboard' }, () => {});
        } catch (error) {
          // console.log(error);
          this.disable = false; //button enable
          this.loading = ''; //loading spinner off
          if (error.response != undefined) {
            this.user.password = ''; //kosongkan input password
            //pilih pesan error sesuai respon server
            switch (error.response.status) {
              case 422:
                this.errors = error.response.data.errors;
                if (error.response.data.email) {
                  this.mail = error.response.data.email[0];
                  this.mailMessage = 'inherit';
                }
                this.flashMessage.error({
                  message: error.response.data.message,
                  time: 5000
                });

                break;
              case 500:
                this.flashMessage.error({
                  message: error.response.data.message,
                  time: 5000
                });
                break;
              case 401:
                this.classDanger = 'is-danger';
                this.mailMessage = 'inherit';
                this.mail = 'Do you use the registered email address?';
                this.flashMessage.error({
                  message: error.response.data.message,
                  time: 5000
                });
                break;
              case 404:
                this.flashMessage.error({
                  message: error.response.data.message,
                  time: 5000
                });
                break;
              case 405:
                this.flashMessage.error({
                  message: error.response.data.message,
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
          } else {
            this.flashMessage.error({
              tittle: 'Some error occured, Please Try Again!',
              message: error,
              time: 5000
            });
          }
        }
      } else {
        //ini seharusnya hanya terjadi jika formnya kosong
        this.flashMessage.error({
          message: 'Oops..., did you forget to fill the form?',
          time: 4000
        });
      }
    },
    //====================== ngisi pesan aja ===============
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
    //================= validasi email =====================
    formValidation: function() {
      const vm = this;
      if (vm.user.email != '') {
        if (vm.reg.test(vm.user.email) == false) {
          vm.mailString('is-danger', 'visible', 'Check your email', false);
        } else if (vm.reg.test(vm.user.email) == true) {
          vm.mailString('is-success', 'hidden', '', true);
        }
      } else {
        vm.mailString('', 'hidden', '', false);
      }
      // return vm.classDanger;
    },
    //=================== validasi Password ==================
    passOk: function() {
      const vm = this;
      if (vm.user.email != '' && vm.validMail == '' && vm.user.password != '') {
        if (vm.user.password.length <= 5) {
          vm.passString('is-danger', 'hidden', 'your password less than 6 caracter', false);
        } else {
          vm.passString('is-success', 'visible', '', true);
        }
      } else if (vm.user.password != '' && vm.user.email == '') {
        vm.passString('is-danger', 'hidden', 'Your email is empty', false);
      } else if (vm.user.password != '' && vm.validMail != '') {
        vm.passString('is-danger', 'hidden', 'Your email is not valid', false);
      } else if (vm.user.password == '' && vm.user.email != '') {
        vm.passString('is-warning', 'hidden', 'Password is empty', false);
      } else {
        vm.passString('', 'hidden', '', false);
      }
      return vm.validPass;
    }
  }
};
</script>

<style scooped>
#log {
  padding-bottom: 10px;
}
img {
  width: 20%;
  height: auto;
}
</style>
