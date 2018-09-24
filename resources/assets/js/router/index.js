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
      name: 'Patient',
      component: require('../components/patients/patient'),
      beforeEnter: ifAuthenticated,
    },
    // User Profile
    {
      path: '/account/profile',
      name: 'Profile',
      component: require('../components/account/profile'),
      beforeEnter: ifAuthenticated,
    },
    // Lab Configurations
    {
      path: '/labconfiguration/healthunit',
      name: 'HealthUnit',
      component: require('../components/labconfiguration/healthunit'),
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/labconfiguration/organization',
      name: 'Organization',
      component: require('../components/labconfiguration/organization'),
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
      name: 'LabSection',
      component: require('../components/testcatalog/testtypecategory'),
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/testcatalog/specimentype',
      name: 'SpecimenType',
      component: require('../components/testcatalog/specimentype'),
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/testcatalog/testtype/:testTypeId/measure/:measureId/measurerange/:measureRangeId/breakpoint',
      name: 'BreakPoint',
      component: require('../components/testcatalog/testtype/measure/measurerange/breakpoint'),
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/testcatalog/testtype/:testTypeId/measure/:measureId/measurerange',
      name: 'MeasureRange',
      component: require('../components/testcatalog/testtype/measure/measurerange/index'),
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/testcatalog/testtype/:testTypeId/specimentype',
      name: 'TestTypeSpecimenType',
      component: require('../components/testcatalog/testtype/specimentype'),
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/testcatalog/testtype/:testTypeId/measure',
      name: 'Measure',
      component: require('../components/testcatalog/testtype/measure/index'),
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/testcatalog/testtype',
      name: 'TestType',
      component: require('../components/testcatalog/testtype/index'),
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/testcatalog/specimenrejectionreason',
      name: 'RejectionReason',
      component: require('../components/testcatalog/specimenrejectionreason'),
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/testcatalog/antibiotic',
      name: 'Antibiotic',
      component: require('../components/testcatalog/testtype/antibiotic'),
      beforeEnter: ifAuthenticated,
    },
    // Access Control
    {
      path: '/accesscontrol/useraccounts',
      name: 'UserAccount',
      component: require('../components/accesscontrol/useraccounts'),
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/accesscontrol/permissions',
      name: 'Permission',
      component: require('../components/accesscontrol/permissions'),
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/accesscontrol/role',
      name: 'Role',
      component: require('../components/accesscontrol/role'),
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/accesscontrol/roleusers',
      name: 'RoleUser',
      component: require('../components/accesscontrol/roleusers'),
      beforeEnter: ifAuthenticated,
    },
    //Routine and Reference Testing
    {
      path: '/test/:testId/measure/:measureId/result/:resultId/measurerange/:measureRangeId',
      name: 'TestCultureSusceptibility',
      component: require('../components/test/culture/susceptibility'),
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/test/:testId/measure/:measureId',
      name: 'TestCulture',
      component: require('../components/test/culture/isolatedorganism'),
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/test/index',
      name: 'Test',
      component: require('../components/test/index'),
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/encounter/index',
      name: 'Encounter',
      component: require('../components/encounter/index'),
      beforeEnter: ifAuthenticated,
    },
    //Quality Control
    {
      path: '/qualitycontrol/lot',
      name: 'Lot',
      component: require('../components/qualitycontrol/lot'),
      beforeEnter: ifAuthenticated,
    },
    // General Stats
    {
      path: '/stats/',
      name: 'Stats',
      component: require('../components/statistics/system/index'),
      beforeEnter: ifAuthenticated,
    },
    //All Users Stats
    {
      path: '/stats/users',
      name: 'user_stats',
      component: require('../components/statistics/users/index'),
      beforeEnter: ifAuthenticated,
    },
    //Single User Stats
    {
      path: '/stats/users/:id',
      name: 'single_user_stats',
      component: require('../components/statistics/users/single'),
      beforeEnter: ifAuthenticated,
    },
    //All Tests Stats
    {
      path: '/stats/tests',
      name: 'tests_stats',
      component: require('../components/statistics/tests/index'),
      beforeEnter: ifAuthenticated,
    },
    //All Specimen Stats
    {
      path: '/stats/specimen',
      name: 'specimen_stats',
      component: require('../components/statistics/specimen/index'),
    },
    //Search Tests Stats
    {
      path: '/stats/tests/search',
      name: 'tests_stats_search',
      component: require('../components/statistics/tests/search'),
      beforeEnter: ifAuthenticated,
    },
    //Search Tests Stats
    {
      path: '/stats/tests/type',
      name: 'tests_stats_type',
      component: require('../components/statistics/tests/type'),
      beforeEnter: ifAuthenticated,
    },
    //Reports
    {
      path: '/reports/infection',
      name: 'infection_report',
      component: require('../components/reports/infection'),
      beforeEnter: ifAuthenticated,
    },
    //Patient Reports
    {
      path: '/reports/patients',
      name: 'patient_reports',
      component: require('../components/reports/patient/index'),
      beforeEnter: ifAuthenticated,
    },
    //Patient Reports
    {
      path: '/reports/patients/:id',
      name: 'patient_reports_single',
      component: require('../components/reports/patient/single'),
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/qualitycontrol/controltest',
      name: 'ControlTest',
      component: require('../components/qualitycontrol/controltest'),
      beforeEnter: ifAuthenticated,
    },
  ],
})
