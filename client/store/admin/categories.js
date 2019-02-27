import api from '../../api'

export const state = () => ({
	categories: [],
	category: {}
})

export const mutations = {
	SET_CATEGORIES (state, categories) {
		state.categories = categories
	},

	SET_CATEGORY (state, category) {
		state.category = category
	}
}

export const getters = {
	categories (state) {
		return state.categories
	},

	category (state) {
		return state.category
	}
}

export const actions = {
  async index ({ commit }) {
      let response = await api.categories.index()

      commit('SET_CATEGORIES', response.data.data)
  },

  async show ({ commit }, categoryId) {
      let response = await api.categories.show(categoryId)

      commit('SET_CATEGORY', response.data.data)
  },

  async store ({ commit }, { form }) {
    try {
      let response = await api.categories.store(form)

      return response
    } catch (e) {
      return e.response
    }
  },

  async update ({ commit }, { form, categoryId }) {
    try {
      let response = await api.categories.update(form, categoryId)

      return response
    } catch (e) {
      return e.response
    }
  }
}