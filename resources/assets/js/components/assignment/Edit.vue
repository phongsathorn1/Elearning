<template>
    <div class="container">
        <assignment-post :detail="form" v-on:submit="edit"></assignment-post>
        <upload
            :callback="'/api/attachment/upload'"
            :upload-files='attachments'
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
                post_id: this.$route.params.post_id,
                attachments: [],
            }
        },
        created(){
            axios.get(`api/classroom/${this.classroom_id}/assignment/${this.post_id}/post`, {
                headers:{
                    Authorization: 'Bearer ' + this.token
                }
            }).then(response => {
                this.form.title = response.data.post.title
                this.form.detail = response.data.post.detail
                this.form.duedate = response.data.post.due_time.split(' ')[0]
                this.form.duetime = response.data.post.due_time.split(' ')[1].substring(0, 5)
                this.form.score = response.data.post.score
                for(let file of response.data.attachments){
                    this.attachments.push({
                        'filename' : file.filepath,
                        'name': file.name
                    })
                }
            })
        },
        methods:{
            edit(form){
                var data = {
                    title: form.title,
                    detail: form.detail,
                    due_time: form.duedate + ' ' + form.duetime,
                    score: form.score,
                    files: this.attachments
                }

                axios.patch(`api/classroom/${this.classroom_id}/assignment/${this.post_id}/post`, data, {
                    headers:{
                        Authorization: 'Bearer ' + this.token
                    }
                })
                .then(response => {
                    this.$router.go(-1)
                })
            },
            uploadedFile(file){
                this.attachments = file
            },
            removeFile(file){
                this.attachments = file
            }
        },
        components: {
            upload,
            'assignmentPost': assignmentPost
        }
    }
</script>