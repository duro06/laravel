<template>
  <div class="field fadeInUp">
    <div class="field">
      <div class="control has-icons-left">
        <div class="select">
          <select v-model="selected" @change="pilih">
            <option value="0">{{ judul }}</option>
            <option v-for="(level, t) in levels" :key="t">
              {{ level }}
            </option>
          </select>
        </div>
        <span class="icon is-left" v-if="icon">
          <i :class="['far', icon]"></i>
        </span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'pilih',
  props: {
    judul: {
      type: String,
      default: 'pilih'
    },
    levels: {
      type: Array,
      default() {
        [5, 10, 25, 50];
      }
    },
    icon: {
      tipe: String,
      default: ''
    }
  },
  data() {
    return {
      selected: 5
    };
  },
  methods: {
    pilih() {
      this.$emit('select', this.selected);
    }
  }
};
</script>

<style></style>
