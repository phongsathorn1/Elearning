<template>
    <div class="container margin-container">
        <post
            :detail="form"
            v-on:post="post"
        ></post>
        <upload
            :callback="'/api/attachment/upload'"
            v-on:complete="uploadedFile"
            v-on:remove="removeFile"
        ></upload>
    </div>
</template>

<script>
    import upload from '../block/upload.vue'
    import post from '../block/post.vue'

    export default {
        data() {
            return {
                form:{
                    detail: ''
                },
                uploaded_files: []
            }
        },
        components:{
            upload,
            post
        },
        methods: {
            store(token, classroom_id, form){
                var data = {
                    'post' : form.detail,
                    'classroom_id': classroom_id,
                    'files' : this.uploaded_files
                }

                axios.post('api/post', data, {
                    headers:{
                        Authorization: 'Bearer ' + token
                    }
                }).then(response => {
                    this.$router.push('/classroom/' + classroom_id)
                }).catch(error => {
                    this.$router.push('/')
                })
            },
            post(form){
                var classroom_id = this.$route.params.id
                var token = this.$auth.getToken()

                axios.get('api/classroom/' + classroom_id, {
                    headers:{
                        Authorization: 'Bearer ' + token
                    }
                }).then(response => {
                    this.store(token, classroom_id, form)
                }).catch(error => {
                    this.$router.push('/')
                })
            },
            uploadedFile(file){
                this.uploaded_files = file
            },
            removeFile(file){
                this.uploaded_files = file
            }
        }
    }
</script>