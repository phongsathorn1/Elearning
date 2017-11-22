<template>
    <div class="post-container">
        <div class="class-meta">
            <div class="profile-picture profile-picture-small" :style="{backgroundImage : `url(${post.user.avatar_url})`}"></div>
            <div class="class-meta-right">
                <div class="post-tag meta-right-item">
                    <span class="glyphicon glyphicon-list-alt"></span> Assignment
                </div>
                <div class="btn-group post-options 
                meta-right-item" role="group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="glyphicon glyphicon-option-horizontal" aria-hidden="true"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right post-dropdown" aria-labelledby="dropdownMenu1">
                        <li>
                        <router-link
                            :to="`/classroom/${classroomId}/assignment/${post.assignment.id}/edit`"
                            class=""
                            v-if="showOption"
                        >Edit</router-link>
                        </li>
                        <li>
                        <a href="javascript:void(0)" 
                            @click="removePost(post.assignment.id)"
                            v-if="showOption"
                        >Delete</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="class-post-user class-meta-item">
                {{ post.user.name }}
            </div>
            <div class="class-post-time class-meta-item" v-bind:title="parseTime(post.created_at)">
                {{ postTimeFromNow(post.created_at) }}
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="col-md-9">
            <h3><router-link :to="classroomId +'/assignment/' + post.assignment.id">{{ post.assignment.title }}</router-link></h3>
            <p v-html="renderHTML(post.assignment.detail)"></p>
        </div>
        <div class="col-md-3">
            <div class="assignment-time" v-if="!post.assignment.due_time">
                <div class="assignment-timeup"><span class="glyphicon glyphicon-leaf"></span> No expiration</div>
            </div>
            <div class="assignment-time" v-else-if="timeCheck(post.assignment.due_time)">
                <div class="assignment-timeup"><span class="glyphicon glyphicon-exclamation-sign"></span> Time up!</div>
            </div>
            <div class="assignment-time" v-else>
                <div class="assignment-left"><span class="glyphicon glyphicon-time"></span> {{ parseTimeFromNow(post.assignment.due_time) }} left!</div>
                <div class="assignment-datetime">Due {{ parseShortTime(post.assignment.due_time) }}</div>
            </div>
            <router-link class="btn btn-default" :to="classroomId +'/assignment/' + post.assignment.id">Open</router-link>
        </div>
        <div class="clearfix"></div>
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
            removePost(postId){
                this.$emit('removePost', postId)
            },
            timeCheck(due_time){
                return moment().isSameOrAfter(due_time, "YYYY-MM-DD HH-mm-ss");
            }
        }
    }
</script>