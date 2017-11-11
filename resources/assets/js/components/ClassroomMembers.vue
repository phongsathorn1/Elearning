<template>
    <transition name="fade">
        <div id="members">
            <div class="page-header">
                <div class="container">
                    <h1>{{ classroom.name }} <small>Members</small></h1>
                    <router-link :to="classroom.id + '/members/add'" class="btn btn-default">Add member</router-link>
                </div>
            </div>
            <div class="container">
                <div class="member-list">
                    <div class="member-list-item" v-for="member in members">
                        <div class="col-xs-6">
                            {{ member.name }}
                        </div>
                        <div class="col-xs-3">
                            {{ member.role.name }}
                        </div>
                        <div class="col-xs-3">
                            Delete
                        </div>
                        <div class="clearfix"></div>
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
                members: [],
                classroom: null
            }
        },
        created(){
            var classroom_id = this.$route.params.id
            var token = this.$auth.getToken()

            axios.get('api/classroom/' + classroom_id, {
                headers:{
                    Authorization: 'Bearer ' + token
                }
            }).then(response => {
                this.classroom = response.data.classroom
            })

            axios.get('api/members/' + classroom_id, {
                headers:{
                    Authorization: 'Bearer ' + token
                }
            }).then(response=>{
                console.log(response)
                this.members = response.data
            })
        }
    }
</script>
