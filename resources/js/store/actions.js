
let actions = {
    ChangeProfileUrl({commit}, payload) {
        axios.post('update_profile_img/' + payload.user, payload.profileUrl).then(res => {
              commit('ChangeProfileUrl', res.data.profile_url)
        }).catch(err => {
            console.log(err)
        })
    },
    getNotifications({commit}, payload) {
        axios.get('notifications/' + payload.user_id).then(res => {
              commit('getNotifications', res.data);
        }).catch(err => {
            console.log(err)
        })
    },
    getCountUnreadNotifications({commit}, payload) {
        axios.get('notifications/unread/count/' + payload.user_id).then(res => {
              commit('newNotificationCount', res.data);
        }).catch(err => {
            console.log(err)
        })
    },
    readNotification({commit}, payload) {
        axios.get('notifications/read/' + payload.id).then(res => {
            commit('notificationCountMinus');
            commit('unreadANotification', payload.id);
        }).catch(err => {
            console.log(err)
        })
    },
    moreNotification({commit, getters}, payload) {
        axios.post('notifications/more/' + payload.user_id, {limit:getters.notifications.length}).then(res => {
            commit('getNotifications', res.data);
            // commit('unreadANotification', payload.id);
        }).catch(err => {
            console.log(err)
        })
    },
    markAllReadNotification({commit}, payload) {
        axios.get('notifications/mark_as_read/' + payload.user_id).then(res => {
            commit('unreadAllNotification');
            commit('nullifyNotifications');
        }).catch(err => {
            console.log(err)
        })
    }
}
export default actions