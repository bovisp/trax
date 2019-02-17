import api from '../../api'

export const state = () => ({})

export const mutations = {}

export const getters = {}

export const actions = {
  async store ({ commit }, { form }) {
    try {
      let response = await api.roles.store(form)

      return response
    } catch (e) {
      return e.response
    }
  }
}