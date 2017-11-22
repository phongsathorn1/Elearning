<template>
    <div class="container">
        <div class="card">
            <div class="profile" v-if="profile">

                <!-- profile-picture -->
                <div class="profile-picture profile-picture-large" v-bind:style="{'background-image': `url(${profile.avatar_url})`}">
                    <upload-avatar
                        v-if="showUpload"
                        v-on:uploaded="uploadComplete"
                        :img-src="profile.avatar_url"
                        :callback="'/api/me/avatar/upload'"
                    ></upload-avatar>
                </div>
                <button class="btn btn-default" @click="ToggleShowUpload">Change picture</button>
                <!-- profile-header -->
                <div class="profile-header" v-if="editable">
                    <h1><input type="text" v-model="profile.name"></h1>
                    <p class="text-danger"
                        v-for="error in profile_errors.name"
                        v-if="profile_errors.name"
                    >{{ error }}</p>
                    <p>{{ profile.role.name }}</p>
                </div>
                <div class="profile-header" v-else>
                    <h1>{{ profile.name }}</h1>
                    <p>{{ profile.role.name }}</p>
                </div>

                <!-- profile-info -->
                <div class="profile-info" v-if="editable">
                    <h2>Basic infomation</h2>
                    <p>Username: <input type="text" v-model="profile.username"></p>
                    <p>Email: <input type="text" v-model="profile.email"></p>
                </div>
                <div class="profile-info" v-else>
                    <h2>Basic infomation</h2>
                    <p>Username: {{ profile.username }}</p>
                    <p class="text-danger"
                        v-for="error in profile_errors.username"
                        v-if="profile_errors.username"
                    >{{ error }}</p>

                    <p>Email: {{ profile.email }}</p>
                    <p class="text-danger"
                        v-for="error in profile_errors.email"
                        v-if="profile_errors.email"
                    >{{ error }}</p>
                </div>

                <!-- security -->
                <div class="profile-info" v-if="!editable">
                    <h2>Security</h2>
                    <p>Password: ●●●●●●●●</p>
                    <button class="btn btn-default" @click="ToggleChangePass">Change password</button>
                    <div class="inner-profile-info" v-if="changePass">
                        <form class="form-horizontal" v-on:submit.prevent="changePassword">
                            <div class="form-group">
                                <label for="password" class="col-sm-2 control-label">Old password</label>
                                <div class="col-sm-10">
                                <input type="password" class="form-control" id="password" placeholder="Old password" v-model="security.password">
                                </div>
                                <p class="text-danger" v-for="error in security_errors.password" v-if="security_errors.password">{{ error }}</p>
                            </div>
                            <div class="form-group">
                                <label for="newpassword" class="col-sm-2 control-label">New password</label>
                                <div class="col-sm-10">
                                <input type="password" class="form-control" id="newpassword" placeholder="New password" v-model="security.new_password">
                                </div>
                                <p class="text-danger" v-for="error in security_errors.new_password" v-if="security_errors.new_password">{{ error }}</p>
                            </div>
                            <div class="form-group">
                                <label for="newpassword_confirmation" class="col-sm-2 control-label">Confirm new password</label>
                                <div class="col-sm-10">
                                <input type="password" class="form-control" id="newpassword_confirmation" placeholder="Confirm new password" v-model="security.new_password_confirmation">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-default">Confirm change password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <button class="btn btn-default" @click="ToggleEnableEdit" v-if="!editable">Edit</button>
                <button class="btn btn-default" @click="ToggleEnableEdit" v-if="editable">Cancel</button>
                <button class="btn btn-default" @click="changeProfile" v-if="editable">Update</button>
            </div>
        </div>
    </div>
</template>

<script>
    import uploadAvatar from '../block/uploadAvatar.vue'
    import { mapGetters } from 'vuex'

    export default {
        data(){
            return {
                profile: {},
                security: {
                    password: '',
                    new_password: '',
                    new_password_confirmation: ''
                },
                showUpload: false,
                security_errors: {},
                profile_errors: {},
                editable: false,
                changePass: false
            }
        },
        components: {
            uploadAvatar
        },
        computed:{
            ...mapGetters([
                'getUser'
            ])
        },
        mounted(){
            this.$store.watch(
                state => {
                    return state.user
                },
                user => {
                    this.profile = Object.assign({}, this.getUser)
                }
            )
            this.profile = Object.assign({}, this.getUser)
        },
        methods:{
            uploadComplete(url){
                this.profile.avatar_url = url
                this.$store.dispatch('getPersonal')
            },
            ToggleShowUpload(){
                this.showUpload = !this.showUpload
            },
            ToggleEnableEdit(){
                this.editable = !this.editable
                this.changePass = false
                this.profile = Object.assign({}, this.getUser)
            },
            ToggleChangePass(){
                this.changePass = !this.changePass
                this.editable = false
            },
            changePassword(){
                axios.patch('api/me/password', this.security, {
                    headers:{
                        Authorization: 'Bearer ' + this.$auth.getToken()
                    }
                }).then(response => {
                    console.log('change password successful')
                }).catch(error => {
                    this.security_errors = error.response.data.errors
                })
            },
            changeProfile(){
                var data = {
                    name: this.profile.name,
                    username: this.profile.username,
                    email: this.profile.email
                }
                axios.patch('api/me', data, {
                    headers:{
                        Authorization: 'Bearer ' + this.$auth.getToken()
                    }
                }).then(response => {
                    this.$store.dispatch('getPersonal')
                    this.editable = false
                    console.log('change profile successful')
                }).catch(error => {
                    this.profile_errors = error.response.data.errors
                })
            }
        }
    }
</script>