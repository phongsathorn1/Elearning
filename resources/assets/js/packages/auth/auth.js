export default function(Vue) {
    Vue.auth = {
        setToken (token, expire) {
            localStorage.setItem('token', token)
            localStorage.setItem('expire', expire + Date.now())
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

        getPersonalData(){
            var data = localStorage.getItem('personal')

            if(!data){
                return null
            }

            return JSON.parse(data)
        },

        revokeToken () {
            localStorage.removeItem('token')
            localStorage.removeItem('expire')
            localStorage.removeItem('personal')

            console.log('logout completed')
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