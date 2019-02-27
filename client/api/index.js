import axios from 'axios'

export default {
  auth: {
    me: () => axios.get('auth/me'),
    login: (data) => axios.post('auth/login', data),
    logout: () => axios.post('auth/logout', {}),
    register: (data) => axios.post('auth/register', data)
  },

  roles: {
  	index: () => axios.get('roles'),
  	store: (data) => axios.post('roles', data)
  },

  categories: {
  	index: () => axios.get('categories'),
  	store: (data) => axios.post('categories', data),
    show: (id) => axios.get(`categories/${id}`),
    update: (data, id) => axios.patch(`categories/${id}`, data)
  }
}