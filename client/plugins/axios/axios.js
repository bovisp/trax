import axios from 'axios'

export default ({ store }) => {
	axios.interceptors.response.use(
		response => response,

		error => {
			if (error.response.status === 422) {
				console.log(error.response.data.errors)
				store.dispatch('validation/setErrors', error.response.data.errors)
			}

			return Promise.reject(error)
		}
	)

	axios.interceptors.request.use(
		config => {
			store.dispatch('validation/clearErrors')

			return config
		},
		
		error => {
			return Promise.reject(error);
		}
	);
}