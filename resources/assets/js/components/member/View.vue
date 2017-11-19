<template>
    <transition name="fade">
        <div id="members">
            <div class="page-header">
                <div class="container">
                    <h1>{{ classroom.name }} <small>Members</small></h1>
                    <div class="control-area" v-if="isTeacher">
                        <router-link :to="'members/add'" class="btn btn-default">Add member</router-link>
                        <span>Join code: <span style="padding:10px;border:1px solid #e0e0e0">{{ classroom.join_code }}</span></span>
                    </div>
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
                            <button class="btn btn-default" @click="remove(member.id)">Remove</button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
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
            }
        }
    }
</script>
