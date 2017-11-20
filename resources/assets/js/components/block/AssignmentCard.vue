<template>
    <div class="post-container">
        <div class="class-meta">
            <div class="btn-group post-options" role="group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="glyphicon glyphicon-option-horizontal" aria-hidden="true"></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
                    <li>
                        <router-link
                :to="`/classroom/${classroomId}/assignment/${post.assignment.id}/edit`"
                class="btn btn-default"
                v-if="showOption"
            >Edit</router-link>
                    </li>
                    <li>
                        <button class="btn btn-default"
                @click="removePost(post.assignment.id)"
                v-if="showOption"
            >Delete</button>
                    </li>
                </ul>
            </div>
            <div class="class-post-user class-meta-item">
                {{ post.user.name }}
            </div>
            <div class="class-post-time class-meta-item">
                {{ parseTime(post.created_at) }}
            </div>
        
            
       

            <div class="clearfix"></div>
        </div>
        <h3><router-link :to="classroomId +'/assignment/' + post.assignment.id">{{ post.assignment.title }}</router-link></h3>
        <p v-html="renderHTML(post.assignment.detail)"></p>
        <p v-if="timeCheck(post.assignment.due_time)">Time up!</p>
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
            },
            timeCheck(due_time){
                return moment().isSameOrAfter(due_time, "YYYY-MM-DD HH-mm-ss");
            }
        }
    }
</script>