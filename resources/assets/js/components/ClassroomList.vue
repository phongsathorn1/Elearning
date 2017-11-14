<template>
    <div id="classroom" style="min-height: 500px">
        <div class="page-header">
            <div class="container">
                <h1>Your Classroom</h1>
                <router-link to="classroom/create" class="btn btn-default">Create class</router-link>
            </div>
        </div>
        <div class="container">
            <div class="classroom-list col-md-4" v-for="classroom in classrooms">
                <div class="card">
                    <div class="classroom-list-head">
                        <router-link :to="'/classroom/'+classroom.id">{{ classroom.name }}</router-link>
                    </div>
                    <div class="classroom-description">
                        {{ classroom.description }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                classrooms: '',
                status: false
            }
        },
        mounted(){
            var token = this.$auth.getToken()

            axios.get('api/classroom', {
                headers:{
                    Authorization: 'Bearer '+token
                }
            }).then(response => {
                this.classrooms = response.data
            })
        }
    }
</script>