<template>
    <transition name="fade" mode="out-in">
        <div class="container">
            <div class="class-post-item">
                <div class="class-meta">
                    <div class="class-post-user class-meta-item" v-if="assignment_post.user.name">
                        {{ assignment_post.user.name }}
                    </div>
                    <div class="class-post-time class-meta-item">
                        {{ assignment_post.created_at }}
                    </div>
                    <div class="clearfix"></div>
                </div>
                <h3>{{ assignment_post.title }}</h3>
                <p>{{ assignment_post.detail }}</p>
            </div>

            <div class="assignment-upload-box" v-if="this.$role == 'is_student'">

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

            <div class="assignment-done-box" v-if="this.$role != 'is_student'">
                <div class="assignment-done-list" v-for="done in all_done" @click="activeId(done.id)">
                    {{ done.user.name }}, score {{ done.score }}, {{ done.files.length }} files
                    <div class="assignment-done-files" v-if="done.id == active_id">
                        <div class="assignment-done-item" v-for="file in done.files">
                            {{ file.name }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        data(){
            return {
                assignment_post: {
                    user: {}
                },
                classroom_id: this.$route.params.id,
                assignment_id: this.$route.params.assignment_id,
                token: this.$auth.getToken(),
                uploaded_files: [],
                is_done: '',
                all_done: [],
                active_id: '',
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
                this.assignment_post = response.data.assignment
                this.uploaded_files = response.data.uploaded_files
                this.is_done = response.data.is_done
            })

            axios.get(`api/classroom/${this.classroom_id}/assignment/${this.assignment_id}/done`, {
                headers:{
                    Authorization: 'Bearer ' + this.token
                }
            })
            .then(response => {
                this.all_done = response.data
            })
        },
        methods:{
            removeFile(file){
                // this.$refs.vc.removeFile(file)
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
            },
            activeId(id){
                if(this.active_id == id){
                    this.active_id = 0
                }else{
                    this.active_id = id
                }
                
            }
        }
    }
</script>

