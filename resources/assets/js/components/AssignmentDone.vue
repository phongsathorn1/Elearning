<template>
    <div class="assignment-done-box" v-if="this.$role != 'is_student'">
        <div class="assignment-done-list" v-for="done in all_done   ">
            <div class="assignment-done-meta" @click="activeId(done.id)">
                {{ done.user.name }}, score {{ done.score }}, {{ done.files.length }} files
            </div>
            <div class="assignment-done-files" v-if="done.id == active_id">
                <div class="assignment-done-item" v-for="file in done.files">
                    {{ file.name }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['classroomId', 'assignmentId'],
    data(){
        return {
            active_id: '',
            all_done: [],
            classroom_id: this.classroomId,
            assignment_id: this.assignmentId,
            token: this.$auth.getToken()
        }
    },
    created(){
        axios.get(`api/classroom/${this.classroom_id}/assignment/${this.assignment_id}/done`, {
            headers:{
                Authorization: 'Bearer ' + this.token
            }
        })
        .then(response => {
            this.all_done = response.data
        })
    },
    methods: {
        activeId(id){
            if(this.active_id == id){
                this.active_id = 0
            }else{
                this.active_id = id
            }
        }
    }
}
</script>
