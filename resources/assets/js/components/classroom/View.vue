<template>
    <div class="classroom" style="min-height: 500px">
        <div class="class-header">
            <div class="container">
                <div class="col-md-12">
                    <h1>{{ classroom.name }}</h1>
                    <div class="class-description">
                        {{ classroom.description }}
                    </div>
                    
                    <div class="class-action">


                        <div class="btn-group" role="group" aria-label="...">
                        <router-link :to="classroom.id + '/post'" class="btn btn-default">New Post</router-link>
                        <router-link
                            :to="classroom.id + '/post/assignment'"
                            v-if="isTeacher"
                            class="btn btn-default"
                            >New Assignment
                        </router-link>

                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Dropdown
                            <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <li>
                                    <router-link :to="classroom.id + '/members'" class="btn btn-default">Members</router-link>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li>
                                    <router-link
                                        :to="`/classroom/${classroom.id}/edit`"
                                        v-if="isTeacher"
                                        class="btn btn-default"
                                        >Edit this classroom
                                    </router-link>
                                </li>
                                <li>
                                    <button class="btn btn-default"
                                    v-if="isTeacher"
                                    @click="deleteClass"
                                    >Delete classroom
                                    </button>
                                </li>
                            </ul>
                        </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="container" v-if="posts">
            <div class="class-posts card" v-for="post in posts">
                <div class="class-post-item" v-if="post.type === 'post'">
                    <div class="class-meta">
                        <div class="class-post-user class-meta-item">
                            {{ post.user.name }}
                        </div>
                        <div class="class-post-time class-meta-item">
                            {{ parseTime(post.created_at) }}
                        </div>

                        <router-link
                            :to="`/classroom/${classroom.id}/post/${post.id}/edit`"
                            class="btn btn-default"
                            v-if="checkUserPost(post.user.id)"
                        >Edit</router-link>

                        <button class="btn btn-default"
                            @click="removePost(post.id)"
                            v-if="checkUserPost(post.user.id)"
                        >Delete</button>

                        <div class="clearfix"></div>
                    </div>
                    <div class="class-post-main" v-html="renderHTML(post.detail)"></div>

                    <attachments :files="post.attachments"></attachments>

                    <div class="class-post-comments">
                        <div class="comment-box">
                            <form v-on:submit.prevent="comment(post.id)">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="comment" placeholder="Comment..." v-model="comments[post.id]">
                                    <button type="submit" class="btn btn-default">Comment</button>
                                </div>
                            </form>
                        </div>
                        <div class="comment-list">
                            <div class="comment-list-item" v-for="comment in post.comments">
                                <b>{{ comment.user.name }} : </b> {{ comment.comment }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="class-post-item" v-if="post.type == 'assignment' && post.assignment">
                    <div class="class-meta">
                        <div class="class-post-user class-meta-item">
                            {{ post.user.name }}
                        </div>
                        <div class="class-post-time class-meta-item">
                            {{ parseTime(post.created_at) }}
                        </div>

                        <router-link
                            :to="`/classroom/${classroom.id}/assignment/${post.assignment.id}/edit`"
                            class="btn btn-default"
                            v-if="checkUserPost(post.user.id)"
                        >Edit</router-link>

                        <button class="btn btn-default"
                            @click="removeAssignment(post.assignment.id)"
                            v-if="checkUserPost(post.user.id)"
                        >Delete</button>
                        <div class="clearfix"></div>
                    </div>
                    <h3><router-link :to="classroom.id +'/assignment/' + post.assignment.id">{{ post.assignment.title }}</router-link></h3>
                    <p v-html="renderHTML(post.assignment.detail)"></p>
                    <p v-if="timeCheck(post.assignment.due_time)">Time up!</p>

                    <attachments :files="post.attachments"></attachments>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment'
    import swal from 'sweetalert2'
    import 'sweetalert2/dist/sweetalert2.min.css';
    import { mapGetters } from 'vuex'
    import attachments from '../block/attachment.vue'

    export default {
        data(){
            return {
                classroom : '',
                posts : [],
                comments : {},
                token : '',
                swal_config: {
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }
            }
        },
        created(){
            var classroom_id = this.$route.params.id
            this.token = this.$auth.getToken()

            axios.get('api/classroom/' + classroom_id, {
                headers:{
                    Authorization: 'Bearer ' + this.token
                }
            })
            .then(response => {
                this.classroom = response.data.classroom
                this.posts = response.data.posts
            })
        },
        components:{
            attachments
        },
        computed: {
            ...mapGetters([
                'getUserId',
                'isTeacher'
            ]),
        },
        methods:{
            comment(post_id){
                var data = {
                    'post_id' : post_id,
                    'comment' : this.comments[post_id]
                }

                axios.post('api/comments', data, {
                    headers:{
                        Authorization: 'Bearer ' + this.token
                    }
                })
                .then(response => {
                    this.comments[post_id] = ''
                    delete this.comments[post_id]

                    var index = this.posts.findIndex(x => x.id == post_id)
                    this.posts[index].comments.push(response.data)
                })
            },
            checkUserPost(user_id){
                return this.getUserId == user_id
            },
            renderHTML(text){
                if(text){
                    return text.replace(/(\r\n|\n)/g, "<br/>")
                }else{
                    return text
                }
            },
            timeCheck(due_time){
                return moment().isSameOrAfter(due_time, "YYYY-MM-DD HH-mm-ss");
            },
            parseTime(dateTime){
                var displayTime = moment(dateTime, "YYYY-MM-DD HH-mm-ss").format("dddd, MMMM Do YYYY, h:mm:ss a");
                return `Post on ${displayTime}`
            },
            removeAssignment(post_id){
                var self = this
                swal(this.swal_config).then(() => {
                    axios.delete(`api/classroom/${self.classroom.id}/assignment/${post_id}`, {
                        headers:{
                            Authorization: 'Bearer ' + self.token
                        }
                    }).then(response => {
                        var index = self.posts.findIndex(x => x.id == post_id && x.type == "assignment")
                        self.posts.splice(index, 1)

                        console.log('remove success')
                    })
                })
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
            deleteClass(){
                var self = this
                swal(this.swal_config).then(() => {
                    axios.delete(`api/classroom/${self.classroom.id}`, {
                        headers:{
                            Authorization: 'Bearer ' + self.token
                        }
                    }).then(response => {
                        console.log('remove class success')
                        self.$router.push('/')
                    })
                })
            }
        }
    }
</script>