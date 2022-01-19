import axios from 'axios'

export default {

    state: {
        userList: [],
        userMessage: []
    },
    mutations: {
        userList(state, payload) {
            return state.userList = payload
        },
        userMessage(state, payload) {
            return state.userMessage = payload
        }
    },
    actions: {
        userList(context) {
            axios.get('/chat')
                .then(response => {
                    context.commit("userList", response.data);
                })
        },
        userMessage(context, payload) {
            axios.get('/user/message/' + payload)
                .then(response => {
                    context.commit("userMessage", response.data);
                })
        }
    },
    //getters used to call mutations
    getters: {
        userList(state) {
            return state.userList
        },
        userMessage(state) {
            return state.userMessage
        }
    },

}