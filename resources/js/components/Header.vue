<template>
  <div class="header">
   <nav class="navbar has-shadow is-fixed-top" role="navigation">
    <button v-on:click="hideSidebar" class="button   " id="sidebarToggle" >
      <i class="fas fa-bars"></i>
    </button>
    
      <div class="container is-fullwidth">
        <!-- <div class="navbar-start" :style="{ display: khusus }"> 
          <div class="navbar-brand">
            <div class="mega-ul">
              <div class="one-icon mega-li navbar-item">
                 <a @click.prevent="goBack" class="mega-link">
                  <span class="mega-icon"
                    ><i class="fas fa-arrow-left"></i
                  ></span>
                </a> 
              </div>
            </div>
          </div> 
        </div> -->
        <!-- <div class="navbar-end" :style="{ display: umum }"> -->
          <div class="navbar-brand is-pulled-right">
            <ul class="mega-ul ">
                <!-- @click="tampil" -->
              <li
                class="one-icon mega-li navbar-item"
                data-target="notif"
              >
                <a href="javascript:void(0)" class="mega-link">
                  <span class="mega-icon"><i class="fa fa-bell"></i></span>
                  <!-- <span class="tag is-danger" v-if="PesanNotif.length">{{
                    PesanNotif.length
                  }}</span> -->
                </a>
              </li>
              <li
                class=" navbar-item">
                <router-link :to="{ name:'login' }" class="mega-link">
                  <!-- <span class="mega-icon"><i class="fa fa-sign-in-alt"></i></span> -->
                  <div class="menu-text-icon">Login</div>
                </router-link>
              </li>
              
              <li
                class="one-icon mega-li navbar-item"
                data-target="user"
              >
                <a href="javascript:void(0)" class="mega-link">
                  <span class="mega-image">
                    <img :src="userImage" alt="example image">               
                  </span>
                  
                </a>
              </li>
              
            </ul>
          <!-- </div> -->
        </div>
      </div>
    </nav>
    <div id="user" class="navbar-menu"></div>
    <div
      id="notif"
      class="navbar-menu"
      :class="{ 'is-active': isActive }"
    >
      <!-- <div class="abu has-text-centered">
        <a
          href=""
          v-if="notification.length"
          class="is-fullwidth is-light is-small"
          @click.prevent="allIsRead"
        >
          <i> Tandai semua telah dibaca </i>
        </a>
      </div>
      <div class="dropdown-content">
        <div
          class="navbar-end has-text-centered loop"
          v-if="notification.length"
        >
          <div class="ulang" v-for="(pesan, n) in notification" :key="n">
            <Notification :data="pesan" @tutup="hantutup" />
          </div>
        </div>
      </div> -->
    </div>
  </div>
</template>

<script>
export default {
name:'headnav',
data(){
  return{
    isActive:false
  }
},
computed:{
  PesanNotif(){
    return []
  },
  userImage(){
    // return 'http://laravel.test/users_images/nouser.png'
    return this.$store.getters['auth/serverUrl'] + '/users_images/nouser.png'
  }
},
methods:{
  hideSidebar: function(e) {
    e.preventDefault();
    document.querySelector("body").classList.toggle("sb-sidenav-toggled");
  },
}
}
</script>

<style>

</style>