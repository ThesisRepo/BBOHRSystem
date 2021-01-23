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
    isLoading: state => {
        return state.isLoading
    },
    roleList: state => {
        return state.roleList;
    },
    message: state => {
        return state.message;
    },
    show: state => {
        return state.show;
    },
    screenSize: state => {
        return state.screenSize;
    },
    hasSmallScreen: state => {
        return state.hasSmallScreen;
    }
}
export default getters