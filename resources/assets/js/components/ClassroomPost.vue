<template>
    <transition name="fade">
    <div class="card">
        <div class="form-group">
            <label for="post">Post</label>
            <textarea id="detail" v-model="detail"></textarea>
        </div>
        <button type="submit" class="btn btn-default" @click="post">Post</button>
    </div>
    </transition>
</template>

<script>
    export default {
        data() {
            return {
                detail: ''
            }
        },
        methods: {
            store(token, classroom_id){
                var data = {
                    'post' : this.detail,
                    'classroom_id': classroom_id
                }

                console.log(token)
                axios.post('api/post', data, {
                    headers:{
                        Authorization: 'Bearer ' + token
                    }
                }).then(response => {
                    this.$router.push('/classroom/' + classroom_id)
                })
            },
            post(){
                var classroom_id = this.$route.params.id
                var token = this.$auth.getToken()

                axios.get('api/classroom/' + classroom_id, {
                    headers:{
                        Authorization: 'Bearer ' + token
                    }
                }).then(response => {
                    this.store(token, classroom_id)
                })
            }
        }
    }
</script>