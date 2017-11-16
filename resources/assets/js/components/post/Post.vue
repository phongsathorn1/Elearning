<template>
    <div class="container">
        <div class="card">
            <div class="form-group">
                <label for="post">Post</label>
                <textarea class="form-control" rows="3" id="detail" v-model="detail"></textarea>
            </div>
            <button type="submit" class="btn btn-default" @click="post">Post</button>
        </div>
        <div class="card">
            <vue-clip ref="vc" 
                :options="options"
                :on-complete="uploadComplete"
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
                <div @click="download(file)">{{ file.name }}</div>
                <div @click="removeFile(file)">delete</div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                detail: '',
                uploaded_files: [],
                options: {
                    url: 'api/attachment/upload',
                    paramName: 'file',
                    headers: {
                        Authorization: 'Bearer ' + this.$auth.getToken()
                    }
                }
            }
        },
        methods: {
            store(token, classroom_id){
                var data = {
                    'post' : this.detail,
                    'classroom_id': classroom_id,
                    'files' : this.uploaded_files
                }

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
            },
            removeFile(file){
                var index = this.uploaded_files.findIndex(x => x.id == file.id)
                this.uploaded_files.splice(index, 1)
            },
            uploadComplete(file, status, xhr){
                this.uploaded_files.push(JSON.parse(xhr.response))
            },
        }
    }
</script>