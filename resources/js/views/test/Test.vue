<template>
  <div class="main">
    <email @email="handleMail" :error="mailError" v-model="mail" :value="mail" />
    <!-- <input-validasi @input="handleInput" :error="inputError" :iconLeft="left" placeholder="Telepon" /> -->

    <button class="button is-success" @click="kumpul">coba</button>
    <button class="button is-success" @click="login">Login Test</button>
    <button class="button is-success" @click="user">Get Member</button>
    <button class="button is-success" @click="logged">test login getters</button>
  </div>
</template>

<script>
import { http } from '../../services/http_service';
export default {
  name: 'test',
  components: {
    email: () => import('../../components/base/InputEmail.vue')
    // 'input-validasi': () => import('../../components/base/InputValidate.vue')
  },
  data() {
    return {
      left: 'fa-phone',
      mailError: '',
      inputError: '',
      toggle: false,
      mail: ''
    };
  },
  methods: {
    handleMail(value) {
      console.log(value);
    },
    handleInput(value) {
      console.log(value);
    },
    kumpul() {
      this.toggle = !this.toggle;
      if (this.toggle) {
        this.mailError = 'nyoba email';
        this.inputError = 'nyoba input';
      } else {
        this.mailError = '';
        this.inputError = '';
      }
    },
    login() {
      return new Promise(() => {
        http()
          .get('/sanctum/csrf-cookie')
          .then(res => {
            console.log('res', res);
          })
          .catch(err => {
            console.log('err', err);
          });
      });
    },
    user() {
      this.$store.dispatch('member/getMember');
    },
    logged() {
      console.log('anggota', this.$store.state.user.user.image);
    }
  }
};
</script>

<style></style>
