import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import Auth from './packages/auth/auth.js'

Vue.use(Vuex)
Vue.use(Auth)

export const store = new Vuex.Store({
    state:{
        isLoggedIn: !!localStorage.getItem("token"),
        user: {
            role: {}
        },
        baseUrl: Laravel.baseUrl
    },
    mutations:{
        storeUser(state, data){
            state.user = data
            state.isLoggedIn = true
        },
        getPersonal(state, data){
            state.user = data
        },
        removePersonal(state){
            state.user = {
                role: {}
            }
            state.isLoggedIn = false
        }
    },
    getters:{
        getUserId: state => {
            return state.user.id
        },
        getRole : state => {
            return state.user.role.actions
        },
        isTeacher: state => {
            return state.user.role.actions == "is_teacher"
        },
        isStudent: state => {
            return state.user.role.actions == "is_student"
        },
        getName: state => {
            return state.user.name
        },
        baseUrl: state => {
            return state.baseUrl
        }
    },
    actions:{
        getPersonal({ commit, state }){
            if(state.isLoggedIn){
                axios.get('api/me', {
                    headers: {
                        Authorization: 'Bearer ' + Vue.auth.getToken()
                    }
                }).then(response => {
                    commit('getPersonal', response.data)
                })
            }
        }
    }
})