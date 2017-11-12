<template>
    <transition name="fade" mode="out-in">
        <div id="adduser">
            <div class="page-header">
                <div class="container">
                    <h1>{{ classroom.name }} <small>Add member</small></h1>
                </div>
            </div>
            <div class="container">
                <div class="member-list">
                    <div class="member-list-item" v-for="user in users">
                        <div v-bind:class="{active: added_users.indexOf(user.id) > -1}">
                            <div class="col-xs-6">
                                {{ user.name }}
                            </div>
                            <div class="col-xs-3">
                                {{ user.role.name }}
                            </div>
                            <div class="col-xs-3">
                                <button class="btn btn-default" v-on:click="add(user.id)" v-if="added_users.indexOf(user.id) <= -1">Add</button>
                                <button class="btn btn-default" v-on:click="remove(user.id)" v-if="added_users.indexOf(user.id) > -1">Remove</button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
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

