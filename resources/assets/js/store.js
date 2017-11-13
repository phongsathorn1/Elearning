import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export const store = new Vuex.Store({
    state:{
        isLoggedIn: !!localStorage.getItem("token"),
        user: {}
    },
    mutations:{
        storeUser(state, data){
            state.user = data
            state.isLoggedIn = true
        },
        getPersonal(state){
            state.user = JSON.parse(localStorage.getItem('personal'))
        },
        removePersonal(state){
            state.user = null
            state.isLoggedIn = false
        }
    }
})