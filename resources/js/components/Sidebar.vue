<template>
  <div id="layoutSidenav_nav">
    <aside class="navbar-menu">
      <button v-on:click="hideSidebar" class="button" id="sidebarToggle">
        <i class="fas fa-bars"></i>
      </button>
      sidebar
    </aside>
  </div>
</template>

<script>
export default {
  name: 'sidebar',
  methods: {
    hideSidebar: function(e) {
      e.preventDefault();
      document.querySelector('body').classList.toggle('sb-sidenav-toggled');
    }
  }
};
</script>

<style></style>
