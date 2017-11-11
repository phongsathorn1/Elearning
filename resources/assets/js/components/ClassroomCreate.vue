<template>
    <transition name="fade">
        <div class="container">
            <div class="form-group">
                <label for="name">Classroom name</label>
                <input type="text" class="form-control" id="name" placeholder="Classroom name" v-model="classroom.name">
            </div>
            <div class="form-group">
                <label for="description">description</label>
                <textarea class="form-control" id="description" rows="3" v-model="classroom.description"></textarea>
            </div>
            <button type="submit" class="btn btn-default" @click="create">Submit</button>
        </div>
    </transition>
</template>

<script>
    export default {
        data(){
            return {
                classroom : {
                    name : '',
                    description: ''
                }
            }
        },
        methods : {
            create(){
                var token = this.$auth.getToken()
                var data = {
                    'name': this.classroom.name,
                    'description': this.classroom.description
                }

                axios.post('api/classroom', data, {
                    headers:{
                        Authorization: 'Bearer ' + token
                    }
                })
                .then(response=>{
                    var classroom_id = response.data.id
                    this.$router.push('/classroom/' + classroom_id)
                })
            }
        }
    }
</script>
