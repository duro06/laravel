<template>
  <div class="detail">
    halaman detail
    {{ member }}
  </div>
</template>

<script>
import { mapState } from 'vuex';
export default {
  name: 'detail-anggota',
  data() {
    return {};
  },
  computed: {
    ...mapState('member', {
      member: state => state.member
    })
  }
};
</script>

<style></style>
