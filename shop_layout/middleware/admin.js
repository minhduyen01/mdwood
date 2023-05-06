export default function ({ $auth, next, store }) {
  let user = $auth.state.user
  if (!$auth.state.loggedIn || user.role == 0) {
    return next('/admin/login')
  }
}
