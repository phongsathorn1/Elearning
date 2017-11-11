require('./bootstrap');

import Vue from 'vue'
import router from './routes.js'
import App from './App.vue'
import axios from 'axios'
import Auth from './packages/auth/auth.js'

Vue.use(Auth)

axios.defaults.baseURL = 'http://localhost/elearning/public';

router.beforeEach(
    (to, from, next) => {
        if(to.matched.some(record => record.meta.forVisitors)){
            if(Vue.auth.isAuth()){
                next({
                    path: '/'
                })
            }else{
                return next()
            }
        }else{
            return next()
        }
    }
)

Vue.component('navbar', require('./components/NavbarComponent.vue'));

const app = new Vue({
    el: '#app',
    router,
    render: h => h(App)
});
