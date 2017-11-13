<template>
    <div class="assignment-upload-box">
        <div v-if="status.returned">
            Returned
        </div>
        <div v-else>
            In progress
        </div>
        {{ status.comment }}
        <vue-clip ref="vc" 
            :options="options"
            :on-complete="uploadComplete"
            v-if="!is_done"
        >
            <template slot="clip-uploader-action">
                <div>
                <div class="dz-message"><h2> Click or Drag and Drop files here upload </h2></div>
                </div>
            </template>

            <template slot="clip-uploader-body" slot-scope="props">
                <div v-for="file in props.files" v-if="file.status != 'success'">
                    <div @click="removeFile(file)">
                        {{ file.name }} {{ file.status }}
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" :aria-valuenow="file.progress" aria-valuemin="0" aria-valuemax="100" v-bind:style="{width: file.progress + '%'}">
                                <span class="sr-only">{{ file.progress }} Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </vue-clip>
        <div v-for="file in uploaded_files">
            <div @click="removeFile(file)">{{ file.name }}</div>
        </div>
        <button type="button" class="btn btn-success" @click="confirm" v-if="!is_done">Send</button>
        {{ this.$role }}
    </div>
</template>

<script>
export default {
    props: ['classroomId', 'assignmentId'],
    data(){
        return {
            uploaded_files: [],
            is_done: '',
            status: {},
            classroom_id: this.classroomId,
            assignment_id: this.assignmentId,
            token: this.$auth.getToken(),
            options: {
                url: `api/classroom/${this.$route.params.id}/assignment/${this.$route.params.assignment_id}/upload`,
                paramName: 'file',
                headers: {
                    Authorization: 'Bearer ' + this.$auth.getToken()
                }
            }
        }
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
        })
    },
    methods:{
        removeFile(file){
            if(this.is_done){
                return false
            }
            var index = this.uploaded_files.findIndex(x => x.id == file.id)
            var data = {
                'file_id': file.id
            }
            axios.post(`api/classroom/${this.classroom_id}/assignment/${this.assignment_id}/remove`, data, {
                headers: {
                    Authorization: 'Bearer ' + this.token
                }
            }).then(response => {
                this.uploaded_files.splice(index, 1)
            })
        },
        uploadComplete(file, status, xhr){
            this.uploaded_files.push(JSON.parse(xhr.response))
        },
        confirm(){
            axios.get(`api/classroom/${this.classroom_id}/assignment/${this.assignment_id}/confirm`, {
                headers: {
                    Authorization: 'Bearer ' + this.token
                }
            }).then(response => {
                this.$router.push(`/classroom/${this.classroom_id}`)
            })
        }
    }
}
</script>

