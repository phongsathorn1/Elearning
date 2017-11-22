<template>
    <div id="classroom" style="min-height: 500px">
        <div class="page-header">
            <div class="container user-profile">
                <div>
                    <div class="col col-xs-6">
                        <div class="profile-picture profile-picture-large" v-bind:style="{'background-image': `url(${getUser.avatar_url})`}"></div>
                    </div>
                    <div class="col col-xs-6">
                        <div class="row">
                            <div class="col-xs-12 profile-info">
                                <div class="profile-name">
                                <router-link
                                to="profile"
                                class="btn btn-link"
                                >
                                <p>
                                {{ getUser.name }}
                                </p>
                                </router-link>
                                
                            </div>
                            <span class="username">@{{ getUser.username }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                            <div class="profile-email">{{ getUser.email }}</div>
                                
                            </div>

                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="container">
                <h1>Your Classroom</h1>
                <router-link
                    to="classroom/create"
                    class="btn btn-default"
                    v-if="isTeacher"
                >Create class</router-link>
                <button class="btn btn-default" @click="showJoin">Join class</button>
            </div>
        </div>
        <classroom-join v-if="show_join"></classroom-join>
        <div class="container">
            <div class="classroom-list col-md-4" v-for="classroom in classrooms">
                <div class="card">

                    
                    <div class="classroom-background" v-bind:style="{'background-image': `url(${classroom.cover_url})`}">
                    </div> 
                    <div class="classroom-list-head">
                        <h3>
                        <router-link :to="'/classroom/'+classroom.id">{{ classroom.name }}</router-link> 
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import swal from 'sweetalert2'
    import 'sweetalert2/dist/sweetalert2.min.css';
    import { mapGetters } from 'vuex'

    export default {
        data(){
            return{
                classrooms: '',
                status: false,
                show_join: false,
                user: this.getUser
            }
        },
        computed: mapGetters([
            'isTeacher',
            'getUser'
        ]),
        methods:{
            showJoin(){
                var self = this
                swal({
                    title: 'Enter code to join class',
                    input: 'text',
                    inputPlaceholder: 'Enter code',
                    customClass: 'test',
                    showCancelButton: true,
                    inputValidator: function (value) {
                        return new Promise(function (resolve, reject) {
                            if (value) {
                                resolve()
                            } else {
                                reject('Please enter the code.')
                            }
                        })
                    }
                })
                .then(function (code) {
                    self.requestJoin(code)
                })
            },
            requestJoin(code){
                var token = this.$auth.getToken()
                var data = {
                    'code': code,
                }
                axios.post('api/classroom/join', data, {
                    headers:{
                        Authorization: 'Bearer '+ token
                    }
                }).then(response => {
                    this.$router.push('classroom/' + response.data.classroom_id);
                })
            }
        },
        mounted(){
            var token = this.$auth.getToken()

            axios.get('api/classroom', {
                headers:{
                    Authorization: 'Bearer '+ token
                }
            }).then(response => {
                this.classrooms = response.data
            })
        }
    }
</script>

<style>
    .test {
        border-radius: 0px;
        font-family: "Nunito", sans-serif;
    }
</style>