<template>
    <div class="card">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" placeholder="Tile of assignment" v-model="form.title">
        </div>
        <div class="form-group">
            <label for="detail">Detail of this assignment</label>
            <textarea class="form-control" id="detail" rows="3" v-model="form.detail"></textarea>
        </div>
        <div class="form-group">
            <label for="score">Score</label>
            <input type="text" class="form-control" id="score" placeholder="Score" v-model="form.score">
        </div>
        <div class="form-group">
            <div class="col-md-6">
                <label for="duedate">Date</label>
                <flat-pickr id="duedate" v-model="form.duedate" :config="config"></flat-pickr>
            </div>
            <div class="col-md-6">
                <label for="duetime">Time</label>
                <input type="text" id="duetime" class="form-control" @blur="timecheck" v-model="form.duetime">
            </div>
            <div class="clearfix"></div>
        </div>
        <button type="submit" class="btn btn-default" @click="edit">Update assignment</button>
    </div>
</template>

<script>
    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';
    import moment from 'moment';

    export default {
        data(){
            return {
                form: {
                    title: '',
                    detail: '',
                    duedate: '',
                    duetime: '',
                    score: 0
                },
                config: {
                    altFormat: "F j, Y",
                    altInput: true,
                    dateFormat: "Y-m-d",
                },
                classroom_id: this.$route.params.id,
                token: this.$auth.getToken(),
                post_id: this.$route.params.post_id
            }
        },
        created(){
            axios.get(`api/classroom/${this.classroom_id}/assignment/${this.post_id}/post`, {
                headers:{
                    Authorization: 'Bearer ' + this.token
                }
            }).then(response => {
                this.form.title = response.data.title
                this.form.detail = response.data.detail
                this.form.duedate = response.data.due_time.split(' ')[0]
                this.form.duetime = response.data.due_time.split(' ')[1].substring(0, 5)
                this.form.score = response.data.score
            })
        },
        methods:{
            timecheck(){
                if(!moment(this.form.duetime, "HH:mm", true).isValid() && !this.form.duetime == ''){
                    this.form.duetime = moment().format("HH:mm")
                }
            },
            edit(){
                var data = {
                    title: this.form.title,
                    detail: this.form.detail,
                    due_time: this.form.duedate + ' ' + this.form.duetime,
                    score: this.form.score
                }

                axios.patch(`api/classroom/${this.classroom_id}/assignment/${this.post_id}/post`, data, {
                    headers:{
                        Authorization: 'Bearer ' + this.token
                    }
                })
                .then(response => {
                    this.$router.go(-1)
                })
            }
        },
        components: {
            flatPickr,
        }
    }
</script>