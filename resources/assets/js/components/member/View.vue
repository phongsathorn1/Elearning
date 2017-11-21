<template>
    <transition name="fade">
        <div id="members">
            <div class="page-header">
                <div class="container">
                    <div class="col-md-8 col-md-offset-2">
                    <h1>{{ classroom.name }}</h1>
                    <div class="control-area" v-if="isTeacher">
                        <router-link :to="'members/add'" class="btn btn-default">Add member</router-link>
                        <span>Join code: <span style="padding:10px;border:1px solid #e0e0e0">{{ classroom.join_code }}</span></span>
                    </div>
                    </div>
                </div>
            </div>
            <div class="container">
                    <div class="control-area">
                        <button type="button" class="btn btn-default btn-back" @click="back">Back</button>
                    </div>
                <div class="card">
                    <h5><kbd>Members</kbd></h5>
                 <table class="table member-list">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tr v-for="member in members">
                        <th scope="row">1</th>
                        <td>{{ member.name }}</td>
                        <td>{{ member.role.name }}</td>
                        <td><button class="btn btn-danger" style="margin: 4px 15px;" @click="remove(member.id)">X</button></td>
                    </tr>
                 </table>
                </div>
                
            </div>
        </div>
    </transition>
</template>

<script>
    import { mapGetters } from 'vuex'

    export default {
        data(){
            return {
                members: [],
                classroom: '',
                classroom_id: this.$route.params.id,
                token: this.$auth.getToken()
            }
        },
        computed: mapGetters([
            'isTeacher'
        ]),
        created(){
            axios.get('api/classroom/' + this.classroom_id, {
                headers:{
                    Authorization: 'Bearer ' + this.token
                }
            }).then(response => {
                this.classroom = response.data.classroom
            }).catch(error => {
                this.$router.push('/')
            })

            axios.get('api/members/' + this.classroom_id, {
                headers:{
                    Authorization: 'Bearer ' + this.token
                }
            }).then(response=>{
                this.members = response.data
            }).catch(error => {
                this.$router.push('/')
            })
        },
        methods:{
            remove(user_id){
                var data = {
                    'classroom_id': this.classroom_id,
                    'user_id': user_id
                }
                axios.post('api/members/remove', data, {
                    headers:{
                        Authorization: 'Bearer ' + this.token
                    }
                }).then(response => {
                    var index = this.members.findIndex(x => x.id == user_id);
                    this.members.splice(index, 1)
                })
            },
            back(){
                this.$router.go(-1)
            }
        }
    }
</script>
