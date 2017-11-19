<template>
    <div class="post-container">
        <div class="class-meta">
            <div class="class-post-user class-meta-item">
                {{ post.user.name }}
            </div>
            <div class="class-post-time class-meta-item">
                {{ parseTime(post.created_at) }}
            </div>

            <router-link
                :to="`/classroom/${classroomId}/post/${post.id}/edit`"
                class="btn btn-default"
                v-if="showOption"
            >Edit</router-link>

            <button class="btn btn-default"
                @click="removePost(post.id)"
                v-if="showOption"
            >Delete</button>

            <div class="clearfix"></div>
        </div>
        <div class="class-post-main" v-html="renderHTML(post.detail)"></div>
    </div>
</template>

<script>
    import moment from 'moment'

    export default {
        props:['post', 'classroomId', 'showOption'],
        methods:{
            renderHTML(text){
                if(text){
                    return text.replace(/(\r\n|\n)/g, "<br/>")
                }else{
                    return text
                }
            },
            parseTime(dateTime){
                var displayTime = moment(dateTime, "YYYY-MM-DD HH-mm-ss").format("dddd, MMMM Do YYYY, h:mm:ss a");
                return `Post on ${displayTime}`
            },
            removePost(postId){
                this.$emit('removePost', postId)
            }
        }
    }
</script>