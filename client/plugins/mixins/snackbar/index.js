import Vue from 'vue'

const Snackbar = {
	install (Vue, options) {
		Vue.mixin({
			methods: {
				successSnackbar (message) {
					this.$snackbar.open({
	                    message,
	                    type: 'is-success',
	                    duration: 3000
	                })
				}
			}
		})
	}
}

Vue.use(Snackbar)