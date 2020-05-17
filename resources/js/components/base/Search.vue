<template>
  <div class="cari is-fullwidth">
    <div class="field">
      <div :class="['control', 'has-icons-left', diload]">
        <input class="input " type="string" :placeholder="placeholder" v-model="cari" />
        <span class="icon  is-left">
          <i class="fas fa-search"></i>
        </span>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'search',
  props: {
    value: {
      type: String,
      required: true
    },
    load: String,
    placeholder: {
      type: String,
      default: 'Cari'
    }
  },
  data() {
    return { loading: '', hasil: '' };
  },
  computed: {
    cari: {
      get() {
        let value = this.value;
        return value;
      },
      set(newValue) {
        this.$emit('search', newValue);
      }
    },
    diload() {
      return this.load;
    }
  }
};
</script>
