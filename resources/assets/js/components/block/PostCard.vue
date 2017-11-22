<template>
    <div class="post-container">
        <div class="class-meta">
            <div class="class-meta-right">
                <div class="btn-group post-options meta-right-item" v-if="showOption">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="glyphicon glyphicon-option-horizontal" aria-hidden="true"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right post-dropdown">
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
            <div class="profile-picture profile-picture-small" :style="{backgroundImage : `url(${post.user.avatar_url})`}">
            </div>
            <div class="class-post-user class-meta-item">
                {{ post.user.name }}
            </div>
            <div class="class-post-time class-meta-item" v-bind:title="parseTime(post.created_at)">
                {{ parseTimeFromNow(post.created_at) }}
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
            parseTimeFromNow(dateTime){
                var displayTime = moment(dateTime, "YYYY-MM-DD HH-mm-ss").fromNow();
                return `Post on ${displayTime}`
            },
            parseTime(dateTime){
                var displayTime = moment(dateTime, "YYYY-MM-DD HH-mm-ss").format("dddd, MMMM Do YYYY, h:mm:ss a");
                return displayTime
            },
            removePost(postId){
                this.$emit('removePost', postId)
            }
        }
    }
</script>