import Vue from 'vue'
import Router from 'vue-router'


Vue.use(Router)
const routes=[
 {
    path: "/",
    redirect: {
      name: "home"
    }
  },
  {
    path: "/home",
    name: "home",
    component: () => import(/* webpackChunkName: "home" */ "./views/Home.vue"),
    meta: {
      loggedIn: true,
      waitingVerified: false,
      visitor: false,
      verified: true
    }
    }
]
const router=new Router({
 mode:'history',
 routes:routes,
 linkActiveClass:'active'
})

// router beforeach pleced here


export default router