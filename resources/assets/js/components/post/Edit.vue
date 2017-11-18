<template>
    <div class="container">
        <post
            :detail="form"
            v-on:post="post"
        ></post>
        <upload
            :callback="'/api/attachment/upload'"
            :upload-files='attachments'
            v-on:complete="uploadedFile"
            v-on:remove="removeFile"
        ></upload>
    </div>
</template>

<script>
    import post from '../block/post.vue'
    import upload from '../block/upload.vue';

    export default {
        data(){
            return {
                form:{
                    detail: ''
                },
                token: this.$auth.getToken(),
                attachments: [],
            }
        },
        components:{
            upload,
            post
        },
        created(){
            axios.get('api/post/' + this.$route.params.post_id, {
                headers:{
                    Authorization: 'Bearer ' + this.token
                }
            }).then(response => {
                this.form.detail = response.data.detail
                for(let file of response.data.attachments){
                    this.attachments.push({
                        'filename' : file.filepath,
                        'name': file.name
                    })
                }
            })
        },
        methods:{
            post(form){
                var data = {
                    post: form.detail,
                    files: this.attachments
                }
                axios.patch('/api/post/' + this.$route.params.post_id, data, {
                    headers:{
                        Authorization: 'Bearer ' + this.token
                    }
                }).then(response => {
                    this.$router.push('/classroom/' + this.$route.params.id)
                })
            },
            uploadedFile(file){
                this.attachments = file
            },
            removeFile(file){
                this.attachments = file
            }
        }
    }
</script>