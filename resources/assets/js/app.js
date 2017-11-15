require('./bootstrap');

import Vue from 'vue'
import axios from 'axios'
import VueClip from 'vue-clip'

import router from './routes.js'
import App from './App.vue'
import Auth from './packages/auth/auth.js'
import { store } from './store'

Vue.use(Auth)
Vue.use(VueClip)

Vue.prototype.$appName = "Elearning";

router.beforeEach(
    (to, from, next) => {
        if (typeof to.meta.role !== 'undefined') {
            if (Vue.auth.isAuth()) {
                axios.get('api/me', {
                    headers: {
                        Authorization: 'Bearer ' + Vue.auth.getToken()
                    }
                }).then(response => {
                    if (response.data.role.actions != to.meta.role) {
                        next({
                            path: '/'
                        })
                    } else {
                        next()
                    }
                })
            } else {
                next({
                    path: '/'
                })
            }
        }
        else if(to.matched.some(record => record.meta.forVisitors)){
            if(Vue.auth.isAuth()){
                next({
                    path: '/'
                })
            }else{
                return next()
            }
        }
        else if(to.matched.some(record => record.meta.forAuth)){
            if (!Vue.auth.isAuth()) {
                next({
                    path: '/login'
                })
            } else {
                return next()
            }
        }
        else{
            return next()
        }
    }
)

const app = new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App)
});
