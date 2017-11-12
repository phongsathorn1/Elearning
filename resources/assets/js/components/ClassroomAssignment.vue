<template>
    <transition name="fade" mode="out-in">
        <div class="container">
            <div class="class-post-item">
                <div class="class-meta">
                    <div class="class-post-user class-meta-item">
                        {{ assignment_post.user.name }}
                    </div>
                    <div class="class-post-time class-meta-item">
                        {{ assignment_post.created_at }}
                    </div>
                    <div class="clearfix"></div>
                </div>
                <h3>{{ assignment_post.title }}</h3>
                <p>{{ assignment_post.detail }}</p>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        data(){
            return {
                assignment_post: '',
                classroom_id: this.$route.params.id,
                assignment_id: this.$route.params.assignment_id,
                token: this.$auth.getToken()
            }
        },
        mounted(){
            axios.get(`api/classroom/${this.classroom_id}/assignment/${this.assignment_id}`, {
                headers:{
                    Authorization: 'Bearer ' + this.token
                }
            })
            .then(response => {
                this.assignment_post = response.data
            })
        }
    }
</script>

