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
                <tr v-for="user in users">
                    <th scope="row">{{ key + 1 }}</th>
                    <td>{{ user.name }}</td>
                    <td>{{ user.role.name }}</td>
                    <td><button class="btn btn-danger" style="margin: 4px 15px;" @click="remove(user.id)">X</button></td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>
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
        methods:{
            remove(user_id){
                console.log(user_id)
            }
        }
    }
</script>