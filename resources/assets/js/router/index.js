import Vue from 'vue'
import Router from 'vue-router'
import Home from '../components/home'
import Login from '../components/login.vue'
import Loading from '../components/loading.vue'
import SideBar from '../components/sidebar.vue'
import store from '../store'

Vue.use(Router)

const ifNotAuthenticated = (to, from, next) => {
  if (!store.getters.isAuthenticated) {
    next()
    return
  }
  next('/login')
}

const ifLoading = (to, from, next) => {
console.log('this is a loading affair');
  if (store.getters.authStatus === 'loading') {
    next()
    return
  }
  next('/loading')
}

const ifAuthenticated = (to, from, next) => {
  if (store.getters.isAuthenticated) {
    next()
    return
  }
  next('/')
}


export default new Router({
  routes: [
    {
      path: '/login',
      name: 'Login',
      component: Login,
      beforeEnter: ifNotAuthenticated,
    },
    {
      path: '/loading',
      name: 'Loading',
      component: Loading,
      beforeEnter: ifLoading,
    },
    {
      path: '/',
      name: 'Home',
      component: Home,
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/sidebar',
      name: 'SideBar',
      component: SideBar,
    },
  ],
})
