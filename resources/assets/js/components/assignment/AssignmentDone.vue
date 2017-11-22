<template>
    <div class="assignment-done-box card">
    <h4>Assignment Status</h4>
        <div class="assignment-done-list" v-for="done in all_done">
            <div class="assignment-done-meta" @click="activeId(done.id)">
                {{ done.user.name }}, score {{ done.score }}, {{ done.files.length }} files
            </div>
            <div class="assignment-done-files" v-if="done.id == active_id">
                <table class="table">
                    <tbody class="table-striped">
                        <tr class="assignment-done-item" v-for="file in done.files" @click="download(file)">
                            <td>
                                {{ file.name }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <input type="text" name="score" @blur="scoreCheck(done.id)" v-model="done.score"> / {{ maxScore }}
                <textarea class="form-control" rows="3" v-model="done.comment"></textarea>
                <button type="button" class="btn btn-primary"@click="returnWork(done.id)" v-if="!done.returned">Return</button>
                <button type="button" class="btn btn-success" @click="returnWork(done.id)" v-if="done.returned">Update</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['classroomId', 'assignmentId', 'maxScore'],
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
        scoreCheck(done_id){
            var index = this.all_done.findIndex(x => x.id == done_id);
            console.log(index)
            if(!Number.isInteger(this.all_done[index].score)){
                this.all_done[index].score = Math.floor(this.all_done[index].score)
            }
            if(this.all_done[index].score > this.maxScore){
                this.all_done[index].score = this.maxScore
            }
        },
        activeId(id){
            if(this.active_id == id){
                this.active_id = 0
            }else{
                this.active_id = id
            }
        },
        returnWork(id){
            var index = this.all_done.findIndex(x => x.id == id)
            var data = {
                'comment': this.all_done[index].comment,
                'user_id': this.all_done[index].user_id,
                'score': this.all_done[index].score
            }
            axios.put(`api/classroom/${this.classroom_id}/assignment/${this.assignment_id}`, data, {
                headers:{
                    Authorization: 'Bearer ' + this.token
                }
            })
            .then(response => {
                this.all_done[index].returned = 1
                this.active_id = 0
            })
        },
        download(file){
            axios.get(`api/assignment/download/${file.id}`, {
                headers: {
                    Authorization: 'Bearer ' + this.token
                }
            }).then(response => {
                window.open(response.data.download_url, "_self")
            })
        }
    }
}
</script>
