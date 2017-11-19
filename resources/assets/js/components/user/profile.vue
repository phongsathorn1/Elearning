<template>
    <div class="container">
        <div class="card">
            <div class="profile" v-if="profile">
                <div class="profile-header">
                    <h1 v-bind:contenteditable="editable" v-model="profile.name">{{ profile.name }}</h1>
                    <p>{{ profile.role.name }}</p>
                </div>
                <div class="profile-info">
                    <p>Username: {{ profile.username }}</p>
                    <p>Email: {{ profile.email }}</p>
                </div>
                <button class="btn btn-default" @click="enableEdit">Edit</button>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'

    export default {
        data(){
            return {
                profile: this.getUser,
                editable: false
            }
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
                    this.profile = this.getUser
                }
            )
            this.profile = this.getUser
        },
        methods:{
            enableEdit(){
                this.editable = true
            }
        }
    }
</script>