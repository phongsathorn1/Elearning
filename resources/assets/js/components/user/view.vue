<template>
    <div class="container">
        <div class="card">
            <table class="table member-list">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tr v-for="(user, key) in users">
                    <th scope="row">{{ key + 1 }}</th>
                    <td>{{ user.name }}<span v-if="getUserId == user.id"> (You)</span></td>
                    <td>{{ user.role.name }}</td>
                    <td>
                        <router-link class="btn btn-default" style="margin: 4px 15px" :to="`user/${user.id}/edit`">Edit</router-link>
                        <button class="btn btn-danger" style="margin: 4px 15px;" v-if="getUserId != user.id" @click="remove(user.id)">Delete</button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'

    export default {
        data(){
            return{
                users: [],
                token: this.$auth.getToken()
            }
        },
        created(){
            axios.get('api/user', {
                headers:{
                    Authorization: 'Bearer ' + this.token
                }
            }).then(response => {
                this.users = response.data
            })
        },
        computed:{
            ...mapGetters([
                'getUserId'
            ])
        },
        methods:{
            remove(user_id){
                console.log(user_id)
                axios.delete(`api/user/${user_id}`, {
                    headers:{
                        Authorization: 'Bearer ' + this.token
                    }
                }).then(response => {
                    var index = this.users.findIndex(x => x.id == user_id)
                    this.users.splice(index, 1)
                })
            }
        }
    }
</script>