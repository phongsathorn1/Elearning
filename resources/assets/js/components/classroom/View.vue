<template>
    <div class="classroom" style="min-height: 500px" v-if="classroom">
        <div class="class-header"

            v-bind:style="{'background-image': `linear-gradient(rgba(0,0,0,.3),rgba(0,0,0,.3)), url(${classroom.cover_url})`} "
        >
            <div class="cover-edit" v-if="coverEdit">
                <div class="cover-upload">
                    <upload-cover
                        :classroom-id="classroom.id"
                        v-on:uploaded="coverUploaded"
                    ></upload-cover>
                </div>
                <div class="cover-edit-bottom">
                    <div class="container">
                        <button type="button" class="btn btn-default" @click="toggleCoverEdit">Done</button>
                    </div>
                </div>
            </div>
            <div class="container" v-else>
                <div class="col-md-8">
                    <h1>{{ classroom.name }}</h1>
                    <div class="class-description">
                        
                        {{ classroom.description }}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="class-teacher">
                        <strong>Teachers</strong>
                        <ul>
                            <li v-for="teacher in teachers()">
                                <div class="profile-picture profile-picture-small" :style="{backgroundImage : `url(${teacher.avatar_url})`} "></div>
                                <kbd>{{ teacher.name }}</kbd>
                                <div class="clearfix"></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="container cover-bottom" v-if="!coverEdit">
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
                                    <router-link :to="classroom.id + '/members'">Members</router-link>
                                </li>
                                <li role="separator" class="divider" v-if="isTeacher"></li>
                                <li v-if="isTeacher"><a href="javascript:void(0)" @click="toggleCoverEdit">Change cover photo</a></li>
                                <li v-if="isTeacher">
                                    <router-link
                                        :to="`/classroom/${classroom.id}/edit`"
                                        >Edit this classroom
                                    </router-link>
                                </li>
                                <li role="separator" class="divider" v-if="isTeacher"></li>
                                <li v-if="isTeacher">
                                    <a href="javascript:void(0)"
                                    v-bind:style="{color: '#a94442'}"
                                    @click="deleteClass"
                                    >Delete classroom
                                    </a>
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
                        <div class="comment-meta">
                            <strong>{{ post.comments.length }} Comments</strong>
                        </div>
                        <div class="comment-box">
                            <form v-on:submit.prevent="comment(post.id)">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="comment" placeholder="Comment..." v-model="comments[post.id]">
                                    <p class="text-danger"
                                        v-for="error in comment_errors.comment"
                                        v-if="comment_errors.comment && focus_id == post.id"
                                    >{{ error }}</p>
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
    <div class="spinner" v-else>
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
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
    import uploadCover from '../block/uploadCover.vue'

    export default {
        data(){
            return {
                classroom : '',
                posts : [],
                comments : {},
                token : '',
                comment_errors: [],
                focus_id: '',
                swal_config: {
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                },
                coverEdit: false
            }
        },
        created(){
            var classroom_id = this.$route.params.id
            this.token = this.$auth.getToken()

            axios.get('api/classroom/' + classroom_id, {
                headers:{
                    Authorization: 'Bearer ' + this.token
                }
            }).then(response => {
                this.classroom = response.data.classroom
                this.posts = response.data.posts
            }).catch(error => {
                this.$router.push('/')
            })
        },
        components:{
            attachments,
            PostCard,
            AssignmentCard,
            uploadCover
        },
        computed: {
            ...mapGetters([
                'getUserId',
                'isTeacher'
            ]),
        },
        methods:{
            toggleCoverEdit(){
                this.coverEdit = !this.coverEdit
            },
            teachers(){
                var teachers = this.classroom.members.filter(user => {
                    return user.role.actions === "is_teacher"
                })
                return teachers
            },
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
                .catch(error => {
                    this.comment_errors = error.response.data.errors
                    this.focus_id = post_id
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
            },
            coverUploaded(url){
                this.classroom.cover_url = url
            }
        }
    }
</script>