<template>
    <div class="container">
        <div class="control-area">
            <button type="button" class="btn btn-link" @click="back">&lt; Back</button>
        </div>
        <div class="class-post-item card">
            <div class="class-meta">
                <div class="class-post-user class-meta-item" v-if="assignment_post.user.name">
                    {{ assignment_post.user.name }}
                </div>
                <div class="class-post-time class-meta-item">
                    {{ assignment_post.created_at }}
                </div>
                <router-link :to="`/classroom/${classroom_id}/assignment/${assignment_post.id}/edit`" class="btn btn-default">Edit</router-link>
                <div class="clearfix"></div>
            </div>
            <h3>{{ assignment_post.title }}</h3>
            <p>{{ assignment_post.detail }}</p>
            <p v-if="timeCheck()">Time up!</p>
        </div>

        <assignment-upload
            v-bind:classroom-id="classroom_id"
            v-bind:assignment-id="assignment_id"
            v-if="getRole == 'is_student'"
        ></assignment-upload>

        <assignment-done 
            v-bind:classroom-id="classroom_id"
            v-bind:assignment-id="assignment_id"
            v-bind:max-score="assignment_post.score"
            v-if="getRole != 'is_student'"
        ></assignment-done>
    </div>
</template>

<script>
    import AssignmentUpload from './AssignmentUpload.vue'
    import AssignmentDone from './AssignmentDone.vue'
    import moment from 'moment';
    import { mapGetters } from 'vuex'

    export default {
        data(){
            return {
                assignment_post: {
                    user: {}
                },
                classroom_id: this.$route.params.id,
                assignment_id: this.$route.params.assignment_id,
                token: this.$auth.getToken(),
            }
        },
        computed: mapGetters([
            'getRole'
        ]),
        components: {
            'assignmentUpload': AssignmentUpload,
            'assignmentDone': AssignmentDone
        },
        created(){
            axios.get(`api/classroom/${this.classroom_id}/assignment/${this.assignment_id}`, {
                headers:{
                    Authorization: 'Bearer ' + this.token
                }
            })
            .then(response => {
                this.assignment_post = response.data.assignment
            })
        },
        methods:{
            timeCheck(){
                return moment().isSameOrAfter(this.assignment_post.due_time, "YYYY-MM-DD HH-mm-ss");
            },
            back(){
                this.$router.go(-1)
            }
        }
    }
</script>

