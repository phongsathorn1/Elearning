<template>
    <transition name="fade">
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
                <button type="submit" class="btn btn-default">Add assignment</button>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        data(){
            return {
                form: {
                    title: '',
                    detail: '',
                    duetime: Date.now()
                }
            }
        }
    }
</script>

