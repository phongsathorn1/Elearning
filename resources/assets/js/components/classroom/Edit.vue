<template>
    <div class="container">
        <div class="form-group">
            <label for="name">Classroom name</label>
            <input type="text" class="form-control" id="name" placeholder="Classroom name" v-model="classroom.name">
        </div>
        <div class="form-group">
            <label for="description">description</label>
            <textarea class="form-control" id="description" rows="3" v-model="classroom.description"></textarea>
        </div>
        <button type="submit" class="btn btn-default" @click="update">Update</button>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                classroom : {
                    id: this.$route.params.id,
                    name : '',
                    description: ''
                },
                token: this.$auth.getToken()
            }
        },
        created(){
            axios.get(`api/classroom/${this.classroom.id}/get`, {
                headers:{
                    Authorization: 'Bearer ' + this.token
                }
            }).then(response => {
                this.classroom = response.data
            })
        },
        methods:{
            update(){
                var data = this.classroom
                axios.patch(`api/classroom/${this.classroom.id}`, data, {
                    headers:{
                        Authorization: 'Bearer ' + this.token
                    }
                }).then(response => {
                    this.$router.push(`/classroom/${this.classroom.id}`)
                })
            }
        }
    }
</script>

