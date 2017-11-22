<template>
    <div class="margin-container card post-block">
        <div class="form-group">
            <label for="post">Post</label>
            <textarea class="form-control" rows="3" id="detail" v-model="form.detail"></textarea>
            <p class="text-danger"
                v-for="error in errors.post"
                v-if="errors.post"
            >{{ error }}</p>
        </div>
        <button type="submit" class="btn btn-yel" @click="post">Post</button>
        <div class="clearfix"></div>
    </div>
</template>

<script>
    export default {
        props: ["detail", "errors"],
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