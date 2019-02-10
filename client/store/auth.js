import api from '../api'
import {setAuthToken, resetAuthToken} from '../utils/auth'
import cookies from 'js-cookie'

export const state = () => ({
  user: null,
  loggedIn: false
})

export const getters = {
  authenticated (store) {
    return store.loggedIn
  },

  user (store) {
    return store.user
  }
}

export const mutations = {
  SET_USER (store, data) {
    store.user = data
  },

  RESET_USER (store) {
    store.user = null
  },

  SET_LOGGEDIN (store, loggedIn) {
    store.loggedIn = loggedIn
  }
}

export const actions = {
  fetch ({ commit }) {
    return api.auth.me()
      .then(response => {
        commit('SET_USER', response.data.data)
        commit('SET_LOGGEDIN', true)

        return response
      })
      .catch(error => {
        commit('RESET_USER')
        commit('SET_LOGGEDIN', false)

        return error
      })
  },

  login ({commit}, data) {
    return api.auth.login(data)
      .then(response => {
        commit('SET_USER', response.data.data)
        commit('SET_LOGGEDIN', true)

        setAuthToken(response.data.meta.token)

        cookies.set('x-access-token', response.data.meta.token, {expires: 7})

        return response
      })
  },

  register ({commit}, data) {
    return api.auth.register(data)
      .then(response => {
        commit('SET_USER', response.data.data)
        commit('SET_LOGGEDIN', true)

        setAuthToken(response.data.meta.token)

        cookies.set('x-access-token', response.data.meta.token, {expires: 7})

        return response
      })
  },

  reset ({commit}) {
    commit('RESET_USER')
    commit('SET_LOGGEDIN', false)

    resetAuthToken()

    cookies.remove('x-access-token')

    return Promise.resolve()
  },

  logout ({commit}) {
    return api.auth.logout()
      .then(response => {
        commit('RESET_USER')
        commit('SET_LOGGEDIN', false)

        resetAuthToken()

        cookies.remove('x-access-token')

        return Promise.resolve()
      })
  }
}