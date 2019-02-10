export default function ({ store, redirect, route }) {
    if (!store.state.auth.loggedIn) {
        return redirect({ name: 'auth-signin' })
    }

    return Promise.resolve()
}