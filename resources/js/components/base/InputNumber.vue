<template>
  <div class="field is-horizontal">
    <div class="field-label is-normal">
      <label class="label">{{ label }}</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="help align-left is-danger" :style="{ display: hasError }">
          {{ error }}
        </p>
        <span class="pemberitahuan" v-if="pesan"> <B>*</B> {{ pesan }} </span>
        <p class="control has-icons-left has-icons-right">
          <input :class="['input', mailClass]" :type="tipe" :placeholder="placeholder" data-lpignore="true" v-model="input" />
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
    </div>
  </div>
</template>

<script>
export default {
  name: 'input-validation',

  props: {
    value: {
      type: String,
      required: true
    },
    label: {
      type: String,
      default: ''
    },
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
    },
    pesan: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      mailClass: '',
      visible: 'hidden',
      message: ''
    };
  },
  computed: {
    hasError() {
      if (this.error) {
        return 'inherit';
      } else return 'none';
    },
    input: {
      get() {
        let value = this.value.split('.');
        let decimal = typeof value[1] !== 'undefined' ? '.' + value[1] : '';

        return Number(value[0]).toLocaleString('en-GB') + decimal;
        // return value;
      },
      set(newValue) {
        // this.$emit('input', newValue.replace(/,/g, ''));
        this.$emit('input', newValue.replace(/[^0-9]/g, ''));
      }
    }
  },
  watch: {
    // input() {
    //   this.input = this.input.replace(/[^0-9]/g, '');
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
