<template>
    <div class="classroom" style="min-height: 500px">
        <div class="class-header">
            <div class="container">
                <div class="col-md-12">
                    <h1>{{ classroom.name }}</h1>
                    <div class="class-description">
                        {{ classroom.description }}
                    </div>
                </div>
            </div>
            <div class="container-fluid cover-bottom">
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
                                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                            <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
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
                    </div><!-- End class-action -->
            </div>
        </div>
        <div class="container" v-if="posts">
            <div class="class-posts card" v-for="post in posts">
                <div class="class-post-item" v-if="post.type === 'post'">

                    <post-card
                        :post="post"
                        :classroom-id="classroom.id"
                        :show-option="checkUserPost(post.user.id)"
                        v-on:removePost="removePost"
                    ></post-card>
                    <attachments :files="post.attachments"></attachments>

                    <div class="class-post-comments">
                        <strong>{{ post.comments.length }} Comments</strong>
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
                    
                    <assignment-card
                        :post="post"
                        :classroom-id="classroom.id"
                        :show-option="checkUserPost(post.user.id)"
                        v-on:removePost="removeAssignment"
                    ></assignment-card>
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
    import PostCard from '../block/PostCard.vue'
    import AssignmentCard from '../block/AssignmentCard.vue'

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
            attachments,
            PostCard,
            AssignmentCard
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
            removeAssignment(post_id){
                var self = this
                swal(this.swal_config).then(() => {
                    axios.delete(`api/classroom/${self.classroom.id}/assignment/${post_id}`, {
                        headers:{
                            Authorization: 'Bearer ' + self.token
                        }
                    }).then(response => {
                        var index = self.posts.findIndex(x => x.assignment.id == post_id && x.type == "assignment")
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