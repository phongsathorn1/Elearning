<template>
    <transition name="fade">
    <div id="classroom">
        <div class="page-header">
            <div class="container">
                <h1>Your Classroom</h1>
                <router-link to="classroom/create" class="btn btn-default">Create class</router-link>
            </div>
        </div>
        <div class="container">
            <div class="classroom-list" v-for="classroom in classrooms">
                <div><router-link :to="'/classroom/'+classroom.id">{{ classroom.name }}</router-link></div>
            </div>
        </div>
    </div>
    </transition>
</template>

<script>
    export default {
        data(){
            return{
                classrooms: ''
            }
        },
        created(){
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