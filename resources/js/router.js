import Vue from 'vue';
import Router from 'vue-router';
import store from './store';

Vue.use(Router);
const routes = [
  {
    path: '/',
    redirect: {
      name: 'home'
    }
  },
  {
    path: '/home',
    name: 'home',
    component: () => import(/* webpackChunkName: "home" */ './views/Home.vue'),
    meta: {
      name: 'Home',
      loggedIn: true,
      visitor: true
    }
  },
  {
    path: '/test',
    name: 'test',
    component: () => import(/* webpackChunkName: "test" */ './views/test/Test.vue'),
    meta: {
      name: 'test',
      loggedIn: true,
      visitor: true
    }
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: () => import(/* webpackChunkName: "dashboard" */ './views/Dashboard.vue'),
    meta: {
      name: 'dashboard',
      loggedIn: true
    }
  },
  {
    path: '/about',
    name: 'about',
    component: () => import(/* webpackChunkName: "about" */ './views/about/About.vue'),
    meta: {
      name: 'about',
      loggedIn: true
    }
  },
  {
    path: '/anggota',
    name: 'anggota',
    component: () => import(/* webpackChunkName: "daftar-anggota" */ './views/anggota/DaftarAnggota.vue'),
    meta: {
      name: 'daftar-anggota',
      loggedIn: true
    },
    children: [
      {
        path: '/detail',
        name: 'detail',
        component: () => import(/* webpackChunkName: "detail-anggota" */ './views/anggota/DetailAnggota.vue'),
        meta: {
          loggedIn: true
        }
      }
      // {
      //   path: 'register',
      //   name: 'register',
      //   component: () => import(/* webpackChunkName: "register" */ './views/anggota/Register.vue'),
      //   meta: {
      //     loggedIn: true
      //   }
      // }
    ]
  },
  {
    path: '/profile',
    name: 'profile',
    component: () => import(/* webpackChunkName: "profile" */ './views/profile/Profile.vue'),
    meta: {
      name: 'profile',
      loggedIn: true
    }
  },
  {
    path: '/auth',
    name: 'auth',
    component: () => import(/* webpackChunkName: "auth" */ './views/auth/index.vue'),
    meta: {
      name: 'auth'
    },
    children: [
      {
        path: 'login',
        name: 'login',
        component: () => import(/* webpackChunkName: "login" */ './views/auth/Login.vue'),
        meta: {
          visitor: true
        }
      },
      {
        path: 'register',
        name: 'register',
        component: () => import(/* webpackChunkName: "register" */ './views/auth/Register.vue'),
        meta: {
          visitor: true
        }
      }
    ]
  }
];
const router = new Router({
  mode: 'history',
  routes: routes,
  linkActiveClass: 'active'
});

// router beforeach pleced here
router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.loggedIn)) {
    if (store.getters['auth/loggedIn']) {
      next();
    } else {
      next({ name: 'login' });
    }
  } else if (to.matched.some(record => record.meta.visitor)) {
    if (store.getters['auth/loggedIn']) {
      next({ name: 'dashboard' });
    } else {
      next();
    }
  }
});

export default router;
