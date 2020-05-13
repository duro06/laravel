import Vue from 'vue';
import Router from 'vue-router';

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
      name: 'Home'
    }
  },
  {
    path: '/test',
    name: 'test',
    component: () => import(/* webpackChunkName: "test" */ './views/test/Test.vue'),
    meta: {
      name: 'test'
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
      },
      {
        path: 'logout',
        name: 'logout',
        component: () => import(/* webpackChunkName: "logout" */ './views/auth/Logout.vue'),
        meta: {
          loggedIn: true
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

export default router;
