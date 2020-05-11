<template>
  <div class="main">
   <Header/>
     <router-view/>
  
  </div>
</template>

<script>
export default {
 name:'app',
 components:{
  Header:()=>import(/* webpackChunkName: "header" */ './components/Header'),
  // Sidebar:()=>import(/* webpackChunkName: "header" */ './components/Sidebar')
 }

}
</script>

<style lang="scss">
.main{
 margin: 55px 10px;
}

</style>