<template>
    <div class="container" v-if="assignment_post">
        <div class="control-area">
            <button type="button" class="btn btn-default btn-back" @click="back">Back</button>
        </div>
        <div class="class-post-item card">
            <div class="class-meta">
                <div class="class-meta-right">
                    <div class="post-tag meta-right-item">
                        <span class="glyphicon glyphicon-list-alt"></span> Assignment
                    </div>
                    <div class="btn-group post-options 
                    meta-right-item" role="group">
                        <button v-if="getRole != 'is_student'" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="glyphicon glyphicon-option-horizontal" aria-hidden="true"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right post-dropdown" aria-labelledby="dropdownMenu1" v-if="getRole != 'is_student'">
                            <li>
                            <router-link
                                :to="`/classroom/${classroom_id}/assignment/${assignment_post.id}/edit`"
                                class=""
                            >Edit</router-link>
                            </li>
                            <li>
                            <a href="javascript:void(0)" 
                                @click="removePost(post.assignment.id)"
                            >Delete</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="class-post-user class-meta-item" v-if="assignment_post.user.name">
                    {{ assignment_post.user.name }}
                </div>
                <div class="class-post-time class-meta-item" v-bind:title="parseTime(assignment_post.created_at)">
                    {{ postTimeFromNow(assignment_post.created_at) }}
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="row">
            <div class="col-md-9">
                <h3>{{ assignment_post.title }}</h3>
                <p v-html="renderHTML(assignment_post.detail)"></p>
            </div>
            <div class="col-md-3">
                <div class="assignment-time" v-if="timeCheck(assignment_post.due_time)">
                    <div class="assignment-timeup"><span class="glyphicon glyphicon-exclamation-sign"></span> Time up!</div>
                </div>
                <div class="assignment-time" v-else>
                    <div class="assignment-left"><span class="glyphicon glyphicon-time"></span> {{ parseTimeFromNow(assignment_post.due_time) }} left!</div>
                    <div class="assignment-datetime">Due {{ parseShortTime(assignment_post.due_time) }}</div>
                </div>
            </div>
            <div class="clearfix"></div>
            </div>
            <attachment :files="attachment"></attachment>
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
    <div class="spinner" v-else>
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>
</template>

<script>
    import AssignmentUpload from './AssignmentUpload.vue'
    import AssignmentDone from './AssignmentDone.vue'
    import attachment from '../block/attachment.vue'
    import moment from 'moment';
    import { mapGetters } from 'vuex'

    export default {
        data(){
            return {
                assignment_post: {
                    user: {}
                },
                attachment: [],
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
            'assignmentDone': AssignmentDone,
            'attachment': attachment
        },
        created(){
            axios.get(`api/classroom/${this.classroom_id}/assignment/${this.assignment_id}`, {
                headers:{
                    Authorization: 'Bearer ' + this.token
                }
            })
            .then(response => {
                this.assignment_post = response.data.assignment
                this.attachment = response.data.attachment
            })
        },
        methods:{
            renderHTML(text){
                if(text){
                    return text.replace(/(\r\n|\n)/g, "<br/>")
                }else{
                    return text
                }
            },
            timeCheck(){
                return moment().isSameOrAfter(this.assignment_post.due_time, "YYYY-MM-DD HH-mm-ss");
            },
            back(){
                this.$router.go(-1)
            },
            postTimeFromNow(dateTime){
                var displayTime = moment(dateTime, "YYYY-MM-DD HH-mm-ss").fromNow();
                return `Post on ${displayTime}`
            },
            parseTimeFromNow(dateTime){
                var displayTime = moment(dateTime, "YYYY-MM-DD HH-mm-ss").fromNow(true);
                return displayTime
            },
            parseTime(dateTime){
                var displayTime = moment(dateTime, "YYYY-MM-DD HH-mm-ss").format("dddd, MMMM Do YYYY, h:mm:ss a");
                return displayTime
            },
            parseShortTime(dateTime){
                var displayTime = moment(dateTime, "YYYY-MM-DD HH-mm-ss").format('llll');
                return displayTime
            },
            removePost(post_id){
                var self = this
                swal(this.swal_config).then(() => {
                    axios.delete(`api/post/${post_id}`, {
                        headers:{
                            Authorization: 'Bearer ' + self.token
                        }
                    }).then(response => {
                        var index = self.posts.findIndex(x => x.id == post_id && x.type == "post")
                        self.posts.splice(index, 1)

                        console.log('remove success')
                    })
                })
            },
        }
    }
</script>

