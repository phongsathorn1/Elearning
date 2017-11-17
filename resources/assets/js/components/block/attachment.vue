<template>
    <div class="attachment" v-if="files">
        <strong>{{ files.length }} Attachments</strong>
            <div class="attachment-block">
                <div class="attachment-item col-xs-6 col-md-2" v-for="file in files" @click="download(file)">
                    <div class="attachment-thumbnail"
                        :style="`background-image: url('${baseUrl}/thumbnail/file/${file.filepath}')`"
                        v-if="image_extension.includes(file.type)"
                    ></div>
                    <div class="attachment-thumbnail"
                        :class="`file-${file.type}`"
                        v-else
                    ></div>
                    <div class="attachment-filename">
                        <span>{{ file.name }}</span>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['files'],
    data(){
        return {
            temp_image: "data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMjQyIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDI0MiAyMDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzEwMCV4MjAwCkNyZWF0ZWQgd2l0aCBIb2xkZXIuanMgMi42LjAuCkxlYXJuIG1vcmUgYXQgaHR0cDovL2hvbGRlcmpzLmNvbQooYykgMjAxMi0yMDE1IEl2YW4gTWFsb3BpbnNreSAtIGh0dHA6Ly9pbXNreS5jbwotLT48ZGVmcz48c3R5bGUgdHlwZT0idGV4dC9jc3MiPjwhW0NEQVRBWyNob2xkZXJfMTVmYzhjOGY3ZjggdGV4dCB7IGZpbGw6I0FBQUFBQTtmb250LXdlaWdodDpib2xkO2ZvbnQtZmFtaWx5OkFyaWFsLCBIZWx2ZXRpY2EsIE9wZW4gU2Fucywgc2Fucy1zZXJpZiwgbW9ub3NwYWNlO2ZvbnQtc2l6ZToxMnB0IH0gXV0+PC9zdHlsZT48L2RlZnM+PGcgaWQ9ImhvbGRlcl8xNWZjOGM4ZjdmOCI+PHJlY3Qgd2lkdGg9IjI0MiIgaGVpZ2h0PSIyMDAiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSI4OS44NTkzNzUiIHk9IjEwNS4yNzgxMjUiPjI0MngyMDA8L3RleHQ+PC9nPjwvZz48L3N2Zz4=",
            image_extension: ['jpeg', 'jpg', 'png', 'svg', 'gif'],
            baseUrl: this.$store.getters.baseUrl,
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
