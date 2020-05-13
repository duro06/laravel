<template>
  <div class="main">
    <FlashMessage
      position="right top"
      style="z-index: 19999 !important; position: fixed;"
    ></FlashMessage>
    <Header />
    <router-view />
  </div>
</template>

<script>
export default {
  name: 'app',
  components: {
    Header: () => import(/* webpackChunkName: "header" */ './components/Header')
    // Sidebar:()=>import(/* webpackChunkName: "header" */ './components/Sidebar')
  }
};
</script>

<style lang="scss">
.main {
  margin: 55px 10px;
}
</style>
