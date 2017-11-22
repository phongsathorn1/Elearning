<template>
    <div class="container about-us">
        <div class="card">
            <h1>About us</h1>
            <div class="row">
                <div class="col-md-4 about-us-item">
                    <img v-bind:src="`${baseUrl}/images/about-us/fluke.jpg`" class="about-us-thumbnail img-responsive">
                </div>
                <div class="col-md-4 about-us-item">
                    <img v-bind:src="`${baseUrl}/images/about-us/gun.jpg`" class="about-us-thumbnail img-responsive">
                </div>
                <div class="col-md-4 about-us-item">
                    <img v-bind:src="`${baseUrl}/images/about-us/hunu.jpg`" class="about-us-thumbnail img-responsive">
                </div>
                <div class="col-md-4 about-us-item">
                    <img v-bind:src="`${baseUrl}/images/about-us/poom.jpg`" class="about-us-thumbnail img-responsive">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'
    export default {
        computed:{
            ...mapGetters([
                'baseUrl'
            ])
        }
    }
</script>