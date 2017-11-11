// import axios from 'axios'

export default function(Vue) {
    Vue.auth = {
        setToken (token, expire) {
            localStorage.setItem('token', token)
            localStorage.setItem('expire', expire)
        },

        getToken () {
            var token = localStorage.getItem('token')
            var expire = localStorage.getItem('expire')

            if(!token || !expire){
                return null
            }

            if(Date.now() > parseInt(expire)){
                this.revokeToken()
                return null
            }
            
            return token
        },

        revokeToken () {
            if(this.isAuth()){
                localStorage.removeItem('token')
                localStorage.removeItem('expire')

                console.log('logout completed')
            }
        },

        isAuth () {
            if(this.getToken()){
                return true
            }else{
                return false
            }
        }
    }

    Object.defineProperties(Vue.prototype, {
        $auth: {
            get () {
                return Vue.auth;
            }
        }
    })
}