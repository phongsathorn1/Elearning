<template>
    <div class="margin-container card">
        <div class="form-group">
            <label for="post">Post</label>
            <textarea class="form-control" rows="3" id="detail" v-model="form.detail"></textarea>
        </div>
        <button type="submit" class="btn btn-default" @click="post">Post</button>
    </div>
</template>

<script>
    export default {
        props: ["detail"],
        data(){
            return {
                form : this.detail
            }
        },
        methods:{
            post(){
                this.$emit('post', this.form)
            }
        }
    }
</script>