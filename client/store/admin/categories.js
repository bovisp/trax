import api from '../../api'

export const state = () => ({
	categories: [],
	category: {},
  children: []
})

export const mutations = {
	SET_CATEGORIES (state, categories) {
		state.categories = categories
	},

	SET_CATEGORY (state, category) {
		state.category = category
	},

  SET_CHILDREN (state, children) {
    state.children = children
  },

  UPDATE_CATEGORY_ORDERS (state, categories) {
    for (var i = 0; i < categories.length; i++) {
      categories[i].order = i + 1
    }

    state.categories = categories
  },

  UPDATE_CHILD_ORDERS (state, children) {
    for (var i = 0; i < children.length; i++) {
      children[i].order = i + 1
    }

    state.children = children
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
      commit('SET_CHILDREN', response.data.data.children)
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

  async updateOrder ({ dispatch, state }, children = false) {
    let categories = []

    if (!children) {
      categories =  await state.categories.map(category => {
        return {
          id: category.id,
          order: category.order
        }
      })
    } else {
      categories =  await state.children.map(category => {
        return {
          id: category.id,
          order: category.order
        }
      })
    }

    try {
      let response = await api.categories.updateOrder(categories)

      return response
    } catch (e) {
      return e.response
    }
  }
}