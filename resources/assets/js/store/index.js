import Vue from 'vue'
import Vuex from 'vuex'
import user from './modules/user'
import auth from './modules/auth'
import { abilityPlugin, ability as appAbility } from './ability'
Vue.use(Vuex)

export const ability = appAbility
const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
    plugins: [
    abilityPlugin
  ],

  modules: {
    user,
    auth,
  },
  strict: debug,
})


