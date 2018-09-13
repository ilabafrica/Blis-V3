import Vue from 'vue'
import apiCall from '../../utils/api'
import { AUTH_LOGOUT } from '../actions/auth'
import { USER_REQUEST, USER_ERROR, USER_SUCCESS } from '../actions/user'

const state = { status: '', profile: {}}

const getters = {
  getProfile: state => state.profile,
  isProfileLoaded: state => !!state.profile.name,
}

const actions = {
  [USER_REQUEST]: ({commit, dispatch}) => {
    commit(USER_REQUEST)

    apiCall({url: '/api/get-user', method: 'GET' })
      .then(resp => {
        commit(USER_SUCCESS, resp)
      })
      .catch(resp => {
        commit(USER_ERROR)
        dispatch(AUTH_LOGOUT)
        window.location.reload(true);
      })
  },
}

const mutations = {
  [USER_REQUEST]: (state) => {
    state.status = 'loading'
  },
  [USER_SUCCESS]: (state, resp) => {
    state.status = 'success'
    Vue.set(state, 'profile', resp)
  },
  [USER_ERROR]: (state) => {
    state.status = 'error'
  },
  [AUTH_LOGOUT]: (state) => {
    state.profile = {}
  }
}

export default {
  state,
  getters,
  actions,
  mutations,
}
