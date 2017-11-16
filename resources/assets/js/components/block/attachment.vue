<template>
    <div class="attachment" v-if="files">
        <ul>
            <li v-for="file in files" @click="download(file)">{{ file.name }}</li>
        </ul>
    </div>
</template>

<script>
export default {
    props: ['files'],
    data(){
        return {
            token: this.$auth.getToken()
        }
    },
    methods:{
        download(file){
            axios.get(`api/attachment/download/${file.filepath}`, {
                headers: {
                    Authorization: 'Bearer ' + this.token
                }
            }).then(response => {
                window.open(response.data.download_url, "_blank")
            })
        }
    }
}
</script>
