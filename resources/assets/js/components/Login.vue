<template>
    <div id="login-page">
        <div class="container">
            <div class="login-form col-md-6 col-md-offset-3 col-xs-10 col-xs-offset-1">
                <img v-bind:src="`${baseUrl}/images/logo-full.svg`" class="login-logo" height="100px">
                <form v-on:submit.prevent="login">
                    <div class="form-group">
                        <input type="text" class="form-control" id="username" required v-model="form.username">
                        <label for="username">Username</label>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="password" required v-model="form.password">
                        <label for="username">Password</label>
                        <span class="login-error" v-if="login_error"><span class="glyphicon glyphicon-alert"></span> The username or password is incorrect.</span>
                    </div>
                    <div class="text-center" v-if="loading">
                        <spinner></spinner><span class="loading-msg">Logging in...</span>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-default">Login</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="object">
            <div class="overlay-bg">
            </div>
            <div class="star-1">
                <img v-bind:src="`${baseUrl}/images/login/star_Ly4.png`" class="img-responsive">
            </div>
            <div class="star-2">
                <img v-bind:src="`${baseUrl}/images/login/star2_Ly4.png`" class="img-responsive">
            </div>
            <div class="mountain mountain-5"></div>
            <div class="mountain mountain-4"></div>
            <div class="mountain mountain-3"></div>
            <div class="mountain mountain-2"></div>
            <div class="mountain mountain-1"></div>
            <div class="cloud cloud-4"></div>
            <div class="cloud cloud-3"></div>
            <div class="cloud cloud-2"></div>
            <div class="cloud cloud-1"></div>
        </div>
    </div>
</template>

<script>
    import config from '../config.js'
    import spinner from './elements/spinner.vue'

    export default {
        data (){
            return{
                form:{
                    username: '',
                    password: ''
                },
                login_error: false,
                loading: false,
                baseUrl: this.$store.getters.baseUrl
            }
        },
        components:{
            spinner
        },
        methods: {
            login () {
                this.login_error = false;
                this.loading = true;
                var data = {
                    'grant_type': config.grant_type,
                    'client_id': config.client_id,
                    'client_secret': config.client_secret,
                    'username': this.form.username,
                    'password': this.form.password
                }

                axios.post('oauth/token', data)
                .then(response => {
                    this.$auth.setToken(response.data.access_token, response.data.expires_in + Date.now())
                    this.setData()
                })
                .catch(response => {
                    this.loading = false
                    this.login_error = true
                })
            },
            setData () {
                axios.get('api/me', {
                    headers:{
                        Authorization: 'Bearer ' + this.$auth.getToken()
                    }
                })
                .then(response => {
                    this.$store.commit('storeUser', response.data)
                    this.$router.push('/')
                })
            }
        }
    }
    
</script>
