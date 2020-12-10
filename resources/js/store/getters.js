let getters = {
    todos: state => {
        return state.todos
    },
    profileUrl: state => {
        return state.profileUrl
    },
    notificationCount: state => {
        return state.notificationCount
    },
    notifications: state => {
        return state.notifications
    },
}
export default getters