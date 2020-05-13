<template>
  <div class="field">
    <p class="help align-left is-danger" :style="{ display: hasError }">
      {{ error }}
    </p>
    <p class="control has-icons-left has-icons-right">
      <input
        @change="validate"
        :class="['input', mailClass]"
        type="email"
        placeholder="Email"
        data-lpignore="true"
        v-model="email"
      />
      <span class="icon is-small is-left">
        <i class="fas fa-envelope"></i>
      </span>
      <span class="icon is-small is-right" :style="{ visibility: visib }">
        <i class="fas fa-exclamation-triangle"></i>
      </span>
    </p>
    <p :class="['help', 'align-left', mailClass]" :style="{ visibility: visib }">
      {{ message }}
    </p>
  </div>
</template>

<script>
export default {
  name: 'email-validation',
  props: {
    error: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      email: '',
      mailClass: '',
      visib: 'hidden',
      message: '',
      reg: /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/
    };
  },
  computed: {
    hasError() {
      if (this.error) {
        return 'inherit';
      } else return 'none';
    }
    //   error() {
    //     if (this.error) {
    //       return this.error;
    //     } else return '';
    //   }
  },
  methods: {
    mailString(kelas, visib, pesan) {
      const vm = this;
      vm.mailClass = kelas;
      vm.visib = visib;
      vm.message = pesan;
    },
    validate() {
      const vm = this;
      if (vm.email != '') {
        if (vm.reg.test(vm.email) == false) {
          vm.mailString('is-danger', 'visible', 'periksa kembali email anda');
        } else if (vm.reg.test(vm.email) == true) {
          vm.mailString('is-success', 'hidden', '');
          this.$emit('email', this.email);
        }
      } else if (vm.email >= 80) {
        vm.mailString('is-danger', 'visible', 'tidak boleh lebih dari 80 karakter');
      } else if (vm.email == '') {
        vm.mailString('is-danger', 'visible', 'tidak boleh kosong');
      } else {
        vm.mailString('', 'hidden', '');
        this.$emit('email', this.email);
      }
    }
  }
};
</script>

<style></style>
