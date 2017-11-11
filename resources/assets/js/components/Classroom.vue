<template>
    <transition name="fade">
    <div class="classroom">
        <div class="class-header">
            <div class="container">
                <h1>{{ classroom.name }}</h1>
                <div class="class-description">
                    {{ classroom.description }}
                </div>
                <router-link :to="classroom.id + '/post'" class="btn btn-default">New Post</router-link>
                <router-link :to="classroom.id + '/post/assignment'" class="btn btn-default">New Assignment</router-link>
                <router-link :to="classroom.id + '/members'" class="btn btn-default">Members</router-link>
            </div>
        </div>
        <div class="container">
            <div class="class-posts" v-for="post in posts">
                <div class="class-post-item" v-if="post.type === 'post'">
                    <div class="class-meta">
                        <div class="class-post-user class-meta-item">
                            {{ post.user.name }}
                        </div>
                        <div class="class-post-time class-meta-item">
                            {{ post.created_at }}
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="class-post-main">
                        {{ post.detail }}
                    </div>
                    <div class="class-post-comments">
                        <div class="comment-box">
                            <div class="form-group">
                                <input type="text" class="form-control" id="comment" placeholder="Comment..." v-model="comments[post.id]">
                                <button type="submit" class="btn btn-default" @click="comment(post.id)">Comment</button>
                            </div>
                        </div>
                        <div class="comment-list">
                            <div class="comment-list-item" v-for="comment in post.comments">
                                <b>{{ comment.user.name }} : </b> {{ comment.comment }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="class-post-item" v-if="post.type === 'assignment'">
                    <div class="class-meta">
                        <div class="class-post-user class-meta-item">
                            {{ post.user.name }}
                        </div>
                        <div class="class-post-time class-meta-item">
                            {{ post.created_at }}
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <h3><router-link :to="classroom.id +'/assignment/' + post.id">{{ post.title }}</router-link></h3>
                    <p>{{ post.detail }}</p>
                </div>
            </div>
        </div>
    </div>
    </transition>
</template>

<script>
    export default {
        data(){
            return {
                classroom : '',
                posts : [],
                comments : {},
                token : '',
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
            }
        }
    }
</script>