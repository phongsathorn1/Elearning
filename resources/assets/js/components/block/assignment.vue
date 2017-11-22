<template>
    <div class="margin-container card">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" placeholder="Tile of assignment" v-model="form.title">
            <p class="text-danger"
                v-for="error in errors.title"
                v-if="errors.title"
            >{{ error }}</p>
        </div>
        <div class="form-group">
            <label for="detail">Detail of this assignment</label>
            <textarea class="form-control" id="detail" rows="3" v-model="form.detail"></textarea>
        </div>
        <div class="form-group">
            <label for="score">Score</label>
            <input type="text" class="form-control" id="score" placeholder="Score" v-model="form.score">
            <p class="text-danger"
                v-for="error in errors.score"
                v-if="errors.score"
            >{{ error }}</p>
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
            <p class="text-danger"
                v-for="error in errors.duetime"
                v-if="errors.duetime"
            >{{ error }}</p>
            <div class="clearfix"></div>
        </div>
        <button type="submit" class="btn btn-yel pull-right" @click="submit">Add assignment</button>
        <div class="clearfix"></div>
    </div>
</template>

<script>
    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';
    import moment from 'moment';

    export default {
        props: ['detail', 'errors'],
        data(){
            return {
                form: this.detail,
                config: {
                    altFormat: "F j, Y",
                    altInput: true,
                    dateFormat: "Y-m-d",
                }
            }
        },
        methods:{
            timecheck(){
                if(!moment(this.form.duetime, "HH:mm", true).isValid() && !this.form.duetime == ''){
                    this.form.duetime = moment().format("HH:mm")
                }
            },
            submit(){
                this.$emit('submit', this.form)
            }
        },
        components:{
            flatPickr
        }
    }
</script>
