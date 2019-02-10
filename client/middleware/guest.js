export default function ({store, redirect, route}) {
  const userIsLoggedIn = !!store.state.auth.user

  if (userIsLoggedIn) {
    return redirect({ name: 'dashboard' })
  }
  
  return Promise.resolve()
}