<template>
    <div class="container">
        <div class="card">
            <div class="form-group">
                <label for="post">Post</label>
                <textarea class="form-control" rows="3" id="detail" v-model="detail"></textarea>
            </div>
            <button type="submit" class="btn btn-default" @click="post">Post</button>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                detail: '',
                token: this.$auth.getToken()
            }
        },
        created(){
            axios.get('api/post/' + this.$route.params.post_id, {
                headers:{
                    Authorization: 'Bearer ' + this.token
                }
            }).then(response => {
                this.detail = response.data.detail
            })
        },
        methods:{
            post(){
                var data = {
                    'post': this.detail
                }
                axios.patch('/api/post/' + this.$route.params.post_id, data, {
                    headers:{
                        Authorization: 'Bearer ' + this.token
                    }
                }).then(response => {
                    this.$router.push('/classroom/' + this.$route.params.id)
                })
            }
        }
    }
</script>