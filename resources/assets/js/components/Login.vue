<template>
    <transition name="fade">
        <div class="container">
            <form v-on:submit.prevent="login">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" placeholder="Username" v-model="form.username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Password" v-model="form.password">
                </div>
                <button type="submit" class="btn btn-default">Login</button>
                <div class="alert alert-danger" role="alert" v-if="login_error">The username or password is incorrect.</div>
            </form>
        </div>
    </transition>
</template>

<script>
    export default {
        data (){
            return{
                form:{
                    username: '',
                    password: ''
                },
                login_error: false
            }
        },

        methods: {
            login () {
                var data = {
                    'grant_type': 'password',
                    'client_id': 2,
                    'client_secret': '8jjUbNiwZdb8egKf4J4TSMyRUe6kfbLHXejBcC2h',
                    'username': this.form.username,
                    'password': this.form.password
                }

                axios.post('oauth/token', data)
                .then(response => {
                    this.$auth.setToken(response.data.access_token, response.data.expires_in + Date.now())
                    this.$router.push('/')
                    this.setData()
                })
                .catch(response => {
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
                    this.$auth.setPersonalData(response.data)
                    this.$store.commit('storeUser', response.data)
                })
            }
        }
    }
</script>