<template>
    <transition name="fade" mode="out-in">
        <div id="adduser">
            <div class="page-header">
                <div class="container">
                    <h1>{{ classroom.name }}</h1>
                </div>
            </div>
        
            <div class="container">
                    <div class="control-area">
                        <button type="button" class="btn btn-default btn-back" @click="back">Back</button>
                    </div>
                <div class="card">
                    <h5><kbd>Add member</kbd></h5>
                 <table class="table member-list">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tr v-for="user in users">
                        <th scope="row">1</th>
                        <td>{{ user.name }}</td>
                        <td>{{ user.role.name }}</td>
                        <td>
                            <button class="btn btn-success" v-on:click="add(user.id)" v-if="added_users.indexOf(user.id) <= -1">Add</button>
                                <button class="btn btn-danger" v-on:click="remove(user.id)" v-if="added_users.indexOf(user.id) > -1">Remove</button>
                        </td>
                    </tr>
                 </table>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        data(){
            return {
                users: [],
                classroom: '',
                added_users: [],
                classroom_id: this.$route.params.id,
                token: this.$auth.getToken()
            }
        },
        created(){
            axios.get('api/classroom/' + this.classroom_id, {
                headers:{
                    Authorization: 'Bearer ' + this.token
                }
            }).then(response => {
                this.classroom = response.data.classroom
            })

            axios.get('api/members', {
                headers:{
                    Authorization: 'Bearer ' + this.token
                }
            })
            .then(response => {
                this.users = response.data
            })

            axios.get('api/members/' + this.classroom_id, {
                headers:{
                    Authorization: 'Bearer ' + this.token
                }
            })
            .then(response => {
                this.added_users = response.data.map(data => data.id)
            })
        },
        methods: {
            add(user_id){
                if(this.added_users.indexOf(user_id) <= -1){
                    this.added_users.push(user_id)
                }

                var data = {
                    'classroom_id': this.classroom_id,
                    'user_id': user_id
                }
                axios.post('api/members/add', data, {
                    headers:{
                        Authorization: 'Bearer ' + this.token
                    }
                })
            },
            back(){
                this.$router.go(-1)
            },
            remove(user_id){
                var index = this.added_users.indexOf(user_id)
                if(index > -1){
                    this.added_users.splice(index, 1)
                }

                var data = {
                    'classroom_id': this.classroom_id,
                    'user_id': user_id
                }
                axios.post('api/members/remove', data, {
                    headers:{
                        Authorization: 'Bearer ' + this.token
                    }
                })
            }
        }
    }
</script>

