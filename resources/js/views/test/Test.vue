<template>
  <div class="main">
    <email @email="handleMail" :error="mailError" />
    <input-validasi
      @input="handleInput"
      :error="inputError"
      :iconLeft="left"
      placeholder="Telepon"
    />

    <button class="button is-success" @click="kumpul">coba</button>
  </div>
</template>

<script>
export default {
  name: 'test',
  components: {
    email: () => import('../../components/base/InputEmail.vue'),
    'input-validasi': () => import('../../components/base/InputValidate.vue')
  },
  data() {
    return {
      left: 'fa-phone',
      mailError: '',
      inputError: '',
      toggle: false
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
    }
  }
};
</script>

<style></style>
