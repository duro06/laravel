<template>
  <nav class="pagination is-centered" role="navigation" aria-label="pagination">
    <a class="pagination-previous" @click="previousPage" v-if="current != 1">Previous</a>
    <a class="pagination-next" @click="nextPage" v-if="current != last">Next page</a>
    <ul class="pagination-list">
      <li v-if="current > 2">
        <a class="pagination-link" aria-label="Goto first page" @click="firstPage">{{ firstP }}</a>
      </li>
      <li v-if="current > 2"><span class="pagination-ellipsis">&hellip;</span></li>
      <li v-if="current > 1">
        <a class="pagination-link" :aria-label="['Goto page', prevP]" @click="previousPage">{{ prevP }}</a>
      </li>
      <li>
        <a class="pagination-link is-current" :aria-label="['Page', current]">{{ currentP }}</a>
      </li>
      <li v-if="current < last - 1">
        <a class="pagination-link" :aria-label="['Goto page', nextP]" @click="nextPage">{{ nextP }}</a>
      </li>
      <li v-if="current < last - 2"><span class="pagination-ellipsis">&hellip;</span></li>
      <li v-if="current != last">
        <a class="pagination-link" :aria-label="['Goto page', last]" @click="lastPage">{{ lastP }}</a>
      </li>
    </ul>
  </nav>
</template>

<script>
import { mapState } from 'vuex';
export default {
  name: 'pagination',

  computed: {
    ...mapState('user', {
      current: state => state.meta.current,
      last: state => state.meta.last
    }),
    currentP() {
      return this.current;
    },
    firstP() {
      return 1;
    },
    prevP() {
      if (this.current > 1) {
        return this.current - 1;
      } else return 1;
    },
    nextP() {
      if (this.current != this.last) {
        return this.current + 1;
      } else return this.last;
    },
    lastP() {
      return this.last;
    }
  },
  methods: {
    firstPage() {
      this.$emit('first', 1);
    },
    nextPage() {
      let next = this.current != this.last ? this.current + 1 : this.last;
      this.$emit('next', next);
    },
    previousPage() {
      let prev = this.current > 1 ? this.current - 1 : 1;
      this.$emit('prev', prev);
    },
    lastPage() {
      this.$emit('last', this.last);
    }
  }
};
</script>

<style></style>
