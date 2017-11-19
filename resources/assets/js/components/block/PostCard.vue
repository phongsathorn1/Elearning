<template>
    <div class="post-container">
        <div class="class-meta">
            <div class="class-post-user class-meta-item">
                {{ post.user.name }}
            </div>
            <div class="class-post-time class-meta-item">
                {{ parseTime(post.created_at) }}
            </div>
            <div class="btn-group" v-if="showOption">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="glyphicon glyphicon-option-horizontal" aria-hidden="true"></span>
            </button>
            <ul class="dropdown-menu post-dropdown">
                <li>
                    <router-link
                        :to="`/classroom/${classroomId}/post/${post.id}/edit`"
                        >Edit
                    </router-link>
                </li>
                <li>
                    <a href="javascript:void(0)" @click="removePost(post.id)">Delete</a>
                </li>
            </ul>
            </div>
        </div>

            
            <div class="clearfix"></div>
        
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