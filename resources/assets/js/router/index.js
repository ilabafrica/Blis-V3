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
    {
      path: '/patients/patient',
      name: 'Patients',
      component: require('../components/patients/patient'),
      beforeEnter: ifAuthenticated,
    },
    // Lab Configurations
    {
      path: '/labconfiguration/specimentype',
      name: 'SpecimenType',
      component: require('../components/labconfiguration/specimentype'),
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/labconfiguration/healthunit',
      name: 'HealthUnit',
      component: require('../components/labconfiguration/healthunit'),
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/labconfiguration/facility',
      name: 'Facility',
      component: require('../components/labconfiguration/facility'),
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/labconfiguration/interfacedequipment',
      name: 'InterfacedEquipment',
      component: require('../components/labconfiguration/interfacedequipment'),
      beforeEnter: ifAuthenticated,
    },
    // Test Catalog
    {
      path: '/testcatalog/testtypecategory',
      name: 'LabSections',
      component: require('../components/testcatalog/testtypecategory'),
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/testcatalog/drug',
      name: 'Drugs',
      component: require('../components/testcatalog/drug'),
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
    //Quality Control
    {
      path: '/qualitycontrol/lot',
      name: 'Lot',
      component: require('../components/qualitycontrol/lot'),
      beforeEnter: ifAuthenticated,
    },
  ],
})
