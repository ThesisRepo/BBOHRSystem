let getters = {
  todos: state => {
      return state.todos
  },
  profileUrl: state => {
      return state.profileUrl
  },
  notificationCount: state => {
    return state.notificationCount
}
}
export default getters