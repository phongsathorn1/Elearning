<template>
    <div class="container">
        <post
            :detail="form"
            v-on:post="post"
        ></post>
    </div>
</template>

<script>
    import post from '../block/post.vue'

    export default {
        data(){
            return {
                form:{
                    detail: ''
                },
                token: this.$auth.getToken()
            }
        },
        components:{
            post,
        },
        created(){
            axios.get('api/post/' + this.$route.params.post_id, {
                headers:{
                    Authorization: 'Bearer ' + this.token
                }
            }).then(response => {
                this.form.detail = response.data.detail
            })
        },
        methods:{
            post(form){
                var data = {
                    'post': form.detail
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