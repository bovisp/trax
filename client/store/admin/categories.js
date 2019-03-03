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
	},

  updateCategory (state, categories) {
    for (var i = 0; i < categories.length; i++) {
      categories[i].order = i + 1
    }

    state.categories = categories
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
  },

  async updateOrder ({ dispatch, state }) {
    let categories =  await state.categories.map(category => {
      return {
        id: category.id,
        order: category.order
      }
    })

    try {
      let response = await api.categories.updateOrder(categories)

      return response
    } catch (e) {
      return e.response
    }
  }
}