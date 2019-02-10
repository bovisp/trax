export default function ({ store, redirect, route }) {
    if (!store.state.auth.loggedIn) {
        return redirect({ name: 'auth-signin' })
    }

    if (store.state.auth.user.roles === null || store.state.auth.user.roles.name !== 'administrator') {
        return redirect({ name: 'dashboard' })
    }

    return Promise.resolve()
}