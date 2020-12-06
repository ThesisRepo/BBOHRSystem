// Mutations allow us to perform some changes on our data. Create

// let mutations = {
//   ADD_TODO(state, todo) {
//       state.todos.unshift(todo)
//   },
//   CACHE_REMOVED(state, todo) {
//     state.toRemove = todo;
//   },
//   GET_TODOS(state, todos) {
//       state.todos = todos
//   },
//   DELETE_TODO(state, todo) {
//       state.todos.splice(state.todos.indexOf(todo), 1)
//       state.toRemove = null;
//   }
// }
// export default mutations


let mutations = {
    ChangeProfileUrl(state, profileUrl) {
        state.profileUrl = profileUrl
    },
    notificationCountAdd(state) {
        state.notificationCount ++
    },
    newNotificationCount(state, notificationCount) {
        state.notificationCount = notificationCount;
    },
    getNotifications(state, notifications) {
        state.notifications = notifications;
    },
    notificationCountMinus(state) {
        state.notificationCount --
    },
    unreadANotification(state, id) {
        state.notifications= state.notifications.map(function(notif){
            if(notif.id == id) {
                notif.is_seen = 1;
                return notif;
            }else {
                return notif;
            }
        });
    },
    unreadAllNotification(state) {
        state.notifications= state.notifications.map(function(notif){
            notif.is_seen = 1;
            return notif;
        });
    },
    nullifyNotifications(state) {
        state.notificationCount = 0;
    },
    notificationAdd(state, payload) {
        var data = {
            id: payload.data.data.id,
            user_id: payload.data.data.user_id,
            request_type: payload.data.request_type,
            message: payload.data.message,
            is_seen: 0,
            created_at: payload.data.data.created_at
        };
        state.notifications.unshift(data);
    }
}
export default mutations