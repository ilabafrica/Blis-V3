import Vue from 'vue'
import Router from 'vue-router'
import store from '../store'

Vue.use(Router)

const ifNotAuthenticated = (to, from, next) => {
  if (!store.getters.isAuthenticated) {
    next()
    return
  }
    next('/')
}

const ifAuthenticated = (to, from, next) => {
  if (store.getters.isAuthenticated) {
    next()
    return
  }
  next('/login')
}

export default new Router({
  routes: [
    {
      path: '/login',
      name: 'Login',
      component: require('../components/login'),
      beforeEnter: ifNotAuthenticated,
    },
    {
      path: '/',
      name: 'Home',
      component: require('../components/home'),
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/sidebar',
      name: 'SideBar',
      component: require('../components/sidebar'),
    },
    // Lab Configurations
    {
      path: '/labconfiguration/healthunit',
      name: 'HealthUnit',
      component: require('../components/labconfiguration/healthunit'),
      beforeEnter: ifAuthenticated,
    },
    // Access Control
    {
      path: '/accesscontrol/useraccounts',
      name: 'UserAccounts',
      component: require('../components/accesscontrol/useraccounts'),
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/accesscontrol/permissions',
      name: 'Permissions',
      component: require('../components/accesscontrol/permissions'),
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/accesscontrol/roles',
      name: 'Roles',
      component: require('../components/accesscontrol/roles'),
      beforeEnter: ifAuthenticated,
    },
  ],
})
