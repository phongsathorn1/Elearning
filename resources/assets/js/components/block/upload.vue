<template>
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
</template>

<script>
export default {
    props: ['callback'],
    data(){
        return {
            uploaded_files: [],
            options: {
                url: this.callback,
                paramName: 'file',
                headers: {
                    Authorization: 'Bearer ' + this.$auth.getToken()
                }
            }
        }
    },
    methods:{
        removeFile(file){
            var index = this.uploaded_files.findIndex(x => x.id == file.id)
            this.uploaded_files.splice(index, 1)
            this.$emit('remove', this.uploaded_files)
        },
        uploadComplete(file, status, xhr){
            this.uploaded_files.push(JSON.parse(xhr.response))
            this.$emit('complete', this.uploaded_files)
        },
    }
}
</script>