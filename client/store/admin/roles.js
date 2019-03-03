import api from '../../api'

export const state = () => ({
	roles: [],
	role: {}
})

export const mutations = {
	SET_ROLES (state, roles) {
		state.roles = roles
	},

	SET_ROLE (state, role) {
		state.role = role
	}
}

export const getters = {
	roles (state) {
		return state.roles
	},

	role (state) {
		return state.role
	}
}

export const actions = {
  async index ({ commit }) {
  	let response = await api.roles.index()

    commit('SET_ROLES', response.data.data)
  },

  async show ({ commit }, roleId) {
  	let response = await api.roles.show(roleId)

    commit('SET_ROLE', response.data.data)
  },

  async store ({ commit }, { form }) {
    try {
      let response = await api.roles.store(form)

      return response
    } catch (e) {
      return e.response
    }
  }
}