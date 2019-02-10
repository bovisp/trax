export default function ({ store }) {
	if (store.authenticated) {
		store.dispatch('auth/fetch')
	}
}