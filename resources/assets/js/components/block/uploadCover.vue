<template>
    <vue-clip 
        :options="options"
        :on-complete="uploadComplete"
    >
        <template slot="clip-uploader-action">
            <div class="cover-upload-overlay">
                <div class="dz-message">
                    <span>Drag & drop or click here to change cover</span>
                </div>
            </div>
        </template>

        <template slot="clip-uploader-body" slot-scope="props">
            <div class="cover-uploading" v-for="file in props.files" v-if="file.status != 'success'">
                <spinner></spinner><span class="loading-msg">Uploading...</span>
            </div>
        </template>
    </vue-clip>
</template>

<script>
    import spinner from '../elements/spinner.vue'

    export default {
        props: ['classroomId'],
        data() {
            return {
                options: {
                    url: `/api/classroom/${this.classroomId}/cover`,
                    paramName: 'file',
                    headers: {
                        Authorization: 'Bearer ' + this.$auth.getToken()
                    }
                }
            }
        },
        components:{
            spinner
        },
        methods:{
            uploadComplete(file, status, xhr){
                var cover_url = JSON.parse(xhr.response).cover_url
                this.$emit('uploaded', cover_url)
            }
        }
    }
</script>