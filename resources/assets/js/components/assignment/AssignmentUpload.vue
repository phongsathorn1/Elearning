<template>
    <div class="assignment-upload-box" v-if="loaded">
        <div v-if="status">
            <div v-if="status.returned">
                Returned
            </div>
            <div v-else>
                In progress
            </div>
            <b>Comment from teacher: </b>{{ status.comment }}
            <b>Score: </b>{{ status.score }}
        </div>
        <upload
            v-if="!is_done"
            :callback="`/api/classroom/${classroomId}/assignment/${assignmentId}/upload`"
            v-on:complete="uploadedFile"
            v-on:remove="removeFile"
            :uploadFiles="uploaded_files"
        ></upload>
        <div v-for="file in uploaded_files">
            <div @click="download(file)">{{ file.name }}</div>
        </div>
        <button type="button" class="btn btn-success" @click="confirm" v-if="!is_done">Send</button>
    </div>
</template>

<script>
import upload from '../block/upload.vue'

export default {
    props: ['classroomId', 'assignmentId'],
    data(){
        return {
            uploaded_files: [],
            loaded: false,
            is_done: '',
            status: {},
            classroom_id: this.classroomId,
            assignment_id: this.assignmentId,
            token: this.$auth.getToken(),
            options: {
                url: `/api/classroom/${this.$route.params.id}/assignment/${this.$route.params.assignment_id}/upload`,
                paramName: 'file',
                headers: {
                    Authorization: 'Bearer ' + this.$auth.getToken()
                }
            }
        }
    },
    components:{
        upload
    },
    created(){
        axios.get(`api/classroom/${this.classroom_id}/assignment/${this.assignment_id}`, {
            headers:{
                Authorization: 'Bearer ' + this.token
            }
        })
        .then(response => {
            this.uploaded_files = response.data.uploaded_files
            this.is_done = response.data.is_done
            this.status = response.data.status
            this.loaded = true
        })
    },
    methods:{
        uploadedFile(file){
            this.uploaded_files = file
        },
        removeFile(file){
            this.uploaded_files = file
        },
        confirm(){
            axios.get(`api/classroom/${this.classroom_id}/assignment/${this.assignment_id}/confirm`, {
                headers: {
                    Authorization: 'Bearer ' + this.token
                }
            }).then(response => {
                this.$router.push(`/classroom/${this.classroom_id}`)
            })
        },
        download(file){
            axios.get(`api/assignment/download/${file.id}`, {
                headers: {
                    Authorization: 'Bearer ' + this.token
                }
            }).then(response => {
                window.open(response.data.download_url, "_self")
            })
        }
    }
}
</script>

