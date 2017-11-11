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
                    {{ post.detail }}
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
                posts : []
            }
        },
        created(){
            var classroom_id = this.$route.params.id
            var token = this.$auth.getToken()

            axios.get('api/classroom/' + classroom_id, {
                headers:{
                    Authorization: 'Bearer ' + token
                }
            })
            .then(response => {
                this.classroom = response.data.classroom
                this.posts = response.data.posts
            })
        }
    }
</script>