<template>
    <div class="container">
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
            <button type="submit" class="btn btn-default" @click="add">Add assignment</button>
        </div>
        <div class="card">
            <vue-clip ref="vc" 
                :options="options"
                :on-complete="uploadComplete"
            >
                <template slot="clip-uploader-action">
                    <div>
                    <div class="dz-message"><h2> Click or Drag and Drop files here upload </h2></div>
                    </div>
                </template>

                <template slot="clip-uploader-body" slot-scope="props">
                    <div v-for="file in props.files" v-if="file.status != 'success'">
                        <div @click="removeFile(file)">
                            {{ file.name }} {{ file.status }}
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" :aria-valuenow="file.progress" aria-valuemin="0" aria-valuemax="100" v-bind:style="{width: file.progress + '%'}">
                                    <span class="sr-only">{{ file.progress }} Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </vue-clip>
            <div v-for="file in uploaded_files">
                <div @click="download(file)">{{ file.name }}</div>
                <div @click="removeFile(file)">delete</div>
            </div>
        </div>
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
                uploaded_files: [],
                options: {
                    url: 'api/attachment/upload',
                    paramName: 'file',
                    headers: {
                        Authorization: 'Bearer ' + this.$auth.getToken()
                    }
                }
            }
        },
        methods:{
            timecheck(){
                if(!moment(this.form.duetime, "HH:mm", true).isValid() && !this.form.duetime == ''){
                    this.form.duetime = moment().format("HH:mm")
                }
            },
            add(){
                var data = {
                    title: this.form.title,
                    detail: this.form.detail,
                    duetime: this.form.duedate + ' ' + this.form.duetime,
                    classroom_id: this.classroom_id,
                    score: this.form.score,
                    files: this.uploaded_files
                }

                axios.post(`api/classroom/${this.classroom_id}/assignment`, data, {
                    headers:{
                        Authorization: 'Bearer ' + this.token
                    }
                })
                .then(response => {
                    this.$router.go(-1)
                })
            },
            removeFile(file){
                var index = this.uploaded_files.findIndex(x => x.id == file.id)
                this.uploaded_files.splice(index, 1)
            },
            uploadComplete(file, status, xhr){
                this.uploaded_files.push(JSON.parse(xhr.response))
            },
        },
        components: {
            flatPickr,
        }
    }
</script>

