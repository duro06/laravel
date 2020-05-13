<template>
  <div class="field">
    <p class="help align-left is-danger" :style="{ display: hasError }">
      {{ error }}
    </p>
    <p class="control has-icons-left has-icons-right">
      <input
        @change="validate"
        :class="['input', mailClass]"
        :type="tipe"
        :placeholder="placeholder"
        data-lpignore="true"
        v-model="input"
      />
      <span v-if="iconLeft" class="icon is-small is-left">
        <i :class="['fas', iconLeft]"></i>
      </span>
      <span v-if="iconRight" class="icon is-small is-right" :style="{ visibility: visible }">
        <i :class="['fas', iconRight]"></i>
      </span>
    </p>
    <p :class="['help', 'align-left', mailClass]" :style="{ visibility: visible }">
      {{ message }}
    </p>
  </div>
</template>

<script>
export default {
  name: 'input-validation',
  props: {
    iconLeft: {
      type: String,
      default: ''
    },
    iconRight: {
      type: String,
      default: ''
    },
    error: {
      type: String,
      default: ''
    },
    placeholder: {
      type: String,
      default: 'input'
    },
    tipe: {
      type: String,
      default: 'input'
    }
  },
  data() {
    return {
      input: '',
      mailClass: '',
      visible: 'hidden',
      message: '',
      reg: /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/
    };
  },
  computed: {
    // iconLeft() {
    //   if (this.data.iconLeft) {
    //     return this.data.iconLeft;
    //   } else return '';
    // },
    // iconRight() {
    //   if (this.data.iconLeft) {
    //     return this.data.iconLeft;
    //   } else return '';
    // },
    hasError() {
      if (this.error) {
        return 'inherit';
      } else return 'none';
    }
    // holder() {
    //   if (this.data.placeholder) {
    //     return this.data.placeholder;
    //   } else return '';
    // },
    // type() {
    //   if (this.data.type) {
    //     return this.data.type;
    //   } else return 'input';
    // },
    // error() {
    //   if (this.data.error) {
    //     return this.data.error;
    //   } else return '';
    // }
  },
  methods: {
    mailString(kelas, visib, pesan) {
      const vm = this;
      vm.mailClass = kelas;
      vm.visible = visib;
      vm.message = pesan;
    },
    validate() {
      const vm = this;
      if (vm.input == '') {
        vm.mailString('is-danger', 'visible', 'tidak boleh kosong');
      } else {
        vm.mailString('is-success', 'hidden', '');
        this.$emit('input', this.input);
      }
    }
  }
};
</script>

<style></style>
