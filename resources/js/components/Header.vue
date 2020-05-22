<template>
  <div class="header">
    <nav class="navbar has-shadow is-fixed-top" role="navigation">
      <div class="navbar-menu is-active">
        <div class="avatar has-text-centered">
          <img :src="logo" alt="logo" />
        </div>
        <div class="navbar-start">
          <div class="mega-ul navbar-menu">
            <div :class="['navbar-item', currentPage.includes('home') ? activeClass : '']">
              <router-link :to="{ name: 'home' }" class="mega-link" exact>
                <div class="menu-text-icon">Home</div>
              </router-link>
            </div>
          </div>
          <div class="mega-ul navbar-menu">
            <div class="navbar-item" v-if="loggedIn">
              <router-link :to="{ name: 'dashboard' }" class="mega-link" exact>
                <div class="menu-text-icon">Dashboard</div>
              </router-link>
            </div>
          </div>
          <div class="mega-ul navbar-menu">
            <div class="navbar-item has-dropdown is-hoverable" v-if="loggedIn">
              <a href="javascript:void(0)" class="navbar-link menu-text-icon" exact>
                <div class="menu-text-icon">Daftar Anggota</div>
              </a>
              <div class="navbar-dropdown">
                <a href="javascript:void(0)" class="navbar-item menu-text-icon" @click.prevent="anggotaAktif" exact>
                  <div class="menu-text-icon">Anggota Aktif</div>
                </a>
                <a href="javascript:void(0)" class="navbar-item menu-text-icon" @click.prevent="anggotaBelum" exact>
                  <div class="menu-text-icon">Anggota Belum Aktif</div>
                </a>
                <a href="javascript:void(0)" class="navbar-item menu-text-icon" @click.prevent="anggotaBerhenti" exact>
                  <div class="menu-text-icon">Anggota Berhenti</div>
                </a>
              </div>
            </div>
          </div>
          <div class="navbar-item has-dropdown is-hoverable" v-if="loggedIn">
            <a class="navbar-link menu-text-icon" exact>
              Menu
            </a>
            <!--  -->
            <div class="navbar-dropdown">
              <router-link to="/user-list" v-if="adminInCharge" class="navbar-item menu-text-icon" exact>
                List User
              </router-link>
              <router-link to="/contact" class="navbar-item menu-text-icon" exact>
                Contact
              </router-link>
              <hr class="navbar-divider" />
              <router-link to="/issue" class="navbar-item menu-text-icon" exact>
                Report an issue
              </router-link>
            </div>
          </div>
        </div>
        <div class="navbar-brand">
          <div class="navbar-end">
            <ul class="mega-ul ">
              <!-- @click="tampil" -->
              <li class="one-icon mega-li navbar-item" data-target="notif">
                <a href="javascript:void(0)" class="mega-link">
                  <span class="mega-icon"><i class="fa fa-bell"></i></span>
                  <!-- <span class="tag is-danger" v-if="PesanNotif.length">{{
                    PesanNotif.length
                  }}</span> -->
                </a>
              </li>
              <li :class="[' navbar-item', currentPage.includes('login') ? activeClass : '']" v-if="!loggedIn">
                <router-link :to="{ name: 'login' }" class="mega-link" exact>
                  <div class="menu-text-icon">Login</div>
                </router-link>
              </li>

              <li class="one-icon mega-li navbar-item has-dropdown is-hoverable" v-if="loggedIn">
                <a href="javascript:void(0)" class="mega-link" exact>
                  <span class="mega-image">
                    <img :src="userImage" alt="example image" />
                  </span>
                </a>
                <div class="navbar-dropdown user">
                  <router-link :to="{ name: 'profile' }" class="navbar-item menu-text-icon">
                    Profile
                  </router-link>

                  <hr class="navbar-divider" />

                  <a class="navbar-item menu-text-icon" @click.prevent="logout" exact>
                    <div class="menu-text-icon">Logout</div>
                  </a>
                </div>
              </li>
              <li class="one-icon mega-li navbar-item">
                <router-link :to="{ name: 'about' }" class="navbar-item menu-text-icon" exact>
                  Tentang Koperasi
                </router-link>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
    <div id="user" class="navbar-menu" :class="{ 'is-active': userActive }">
      <div class="abu has-text-centered"></div>
    </div>
    <div id="notif" class="navbar-menu" :class="{ 'is-active': isActive }">
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
import { mapActions } from 'vuex';
import * as auth from '../services/auth_service';
export default {
  name: 'headnav',
  data() {
    return {
      isActive: false,
      userActive: false,
      disable: false,
      activeClass: 'active'
    };
  },
  computed: {
    adminInCharge() {
      return this.$store.state.user.user.role == 'Admin' && this.$store.state.user.user.status == 1 ? true : false;
    },
    PesanNotif() {
      return [];
    },
    userImage() {
      return this.$store.state.user.user.image == null
        ? this.$store.getters['auth/storageUrl'] + `users_images/nouser.png`
        : this.$store.getters['auth/storageUrl'] + this.$store.state.user.user.image;
    },
    loggedIn() {
      return this.$store.getters['auth/loggedIn'];
    },
    currentPage() {
      return this.$route.path;
    },
    logo() {
      return this.$store.getters['auth/storageUrl'] + 'galleries_images/logo.png';
    }
  },
  watch: {
    userImage: {
      handler: 'loadImage',
      immediate: true
    }
  },
  methods: {
    ...mapActions('member', ['changeStatus', 'getMember']),
    hideSidebar: function(e) {
      e.preventDefault();
      document.querySelector('body').classList.toggle('sb-sidenav-toggled');
    },
    loadImage: function() {
      let image = this.$store.state.user.user.image;
      if (image !== null) {
        return (this.displayImage = this.$store.getters['auth/storageUrl'] + image);
      }
      return (this.displayImage = this.$store.getters['auth/storageUrl'] + `users_images/nouser.png`);
    },
    logout() {
      this.disable = true;
      console.log('logout');
      auth.logout().then(() => {
        this.disable = false;
        location.reload();
      });
    },
    tampilUser() {
      this.userActive = !this.userActive;
    },
    anggotaBelum() {
      this.changeStatus(1);
      this.$router.replace(this.$route.query.redirect || { name: 'anggota' }, () => {});
      this.getMember();
    },
    anggotaAktif() {
      this.changeStatus(2);
      this.$router.replace(this.$route.query.redirect || { name: 'anggota' }, () => {});
      this.getMember();
    },
    anggotaBerhenti() {
      this.changeStatus(3);
      this.$router.replace(this.$route.query.redirect || { name: 'anggota' }, () => {});
      this.getMember();
    }
  }
};
</script>

<style lang="scss" scoped>
.avatar {
  img {
    height: 45px;
    width: auto;
  }
  margin-top: 5px;
  margin-left: 20px;
  margin-right: 10px;
}
.user {
  margin-left: 0px;
}
.navbar-item img {
  max-height: 2rem;
}
</style>
