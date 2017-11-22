<template>
    <vue-clip 
        :options="options"
        :on-complete="uploadComplete"
    >
        <template slot="clip-uploader-action">
            <div class="profile-upload-overlay">
                <div class="dz-message">
                    <span>Change avatar</span>
                </div>
            </div>
        </template>
    </vue-clip>
</template>

<script>
    export default {
        props: ['callback'],
        data() {
            return {
                options: {
                    url: this.callback,
                    paramName: 'file',
                    required: ['image/*'],
                    headers: {
                        Authorization: 'Bearer ' + this.$auth.getToken()
                    }
                }
            }
        },
        methods:{
            uploadComplete(file, status, xhr){
                var avatar_url = JSON.parse(xhr.response).avatar_url
                this.$emit('uploaded', avatar_url)
            }
        }
    }
</script>