<template>
    <div class="container">
        <assignment-post :detail="form" v-on:submit="add" :errors="post_errors"></assignment-post>
        <upload
            :callback="'/api/attachment/upload'"
            v-on:complete="uploadedFile"
            v-on:remove="removeFile"
        ></upload>
    </div>
</template>

<script>
    import upload from '../block/upload.vue';
    import assignmentPost from '../block/assignment.vue';

    export default {
        data(){
            return {
                form: {
                    title: '',
                    detail: '',
                    duedate: '',
                    duetime: '',
                    score: 0
                },
                classroom_id: this.$route.params.id,
                token: this.$auth.getToken(),
                uploaded_files: [],
                post_errors: []
            }
        },
        methods:{
            add(form){
                var data = {
                    title: form.title,
                    detail: form.detail,
                    duetime: form.duedate + ' ' + form.duetime,
                    classroom_id: this.classroom_id,
                    score: form.score,
                    files: this.uploaded_files
                }

                axios.post(`api/classroom/${this.classroom_id}/assignment`, data, {
                    headers:{
                        Authorization: 'Bearer ' + this.token
                    }
                }).then(response => {
                    this.$router.go(-1)
                }).catch(error => {
                    this.post_errors = error.response.data.errors
                })
            },
            uploadedFile(file){
                this.uploaded_files = file
            },
            removeFile(file){
                this.uploaded_files = file
            }
        },
        components: {
            upload,
            'assignmentPost': assignmentPost
        }
    }
</script>

