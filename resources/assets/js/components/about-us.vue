<template>
    <div class="container about-us">
        <div class="card">
            <h1>About us</h1>
            <div class="row">
                <div class="col-md-4 about-us-item">
                    <img v-bind:src="`${baseUrl}/images/about-us/fluke.jpg`" class="about-us-thumbnail img-responsive">
                    <p class="about-us-name">Phongsathron Kittiworapanya</p>
                    <p><a href="https://www.facebook.com/Phongsathron.co.th"><img v-bind:src="`${baseUrl}/images/facebook.svg`" height="25px"> Facebook</a></p>
                </div>
                <div class="col-md-4 about-us-item">
                    <img v-bind:src="`${baseUrl}/images/about-us/gun.jpg`" class="about-us-thumbnail img-responsive">
                    <p class="about-us-name">Puttimate Thammasaeng</p>
                    <p><a href="https://www.facebook.com/jusmistic"><img v-bind:src="`${baseUrl}/images/facebook.svg`" height="25px"> Facebook</a></p>
                </div>
                <div class="col-md-4 about-us-item">
                    <img v-bind:src="`${baseUrl}/images/about-us/hunu.jpg`" class="about-us-thumbnail img-responsive">
                    <p class="about-us-name">Hunu</p>
                    <p><a href="https://www.facebook.com/Hnunkungs"><img v-bind:src="`${baseUrl}/images/facebook.svg`" height="25px"> Facebook</a></p>
                </div>
                <div class="col-md-4 about-us-item">
                    <img v-bind:src="`${baseUrl}/images/about-us/poom.jpg`" class="about-us-thumbnail img-responsive">
                    <p class="about-us-name">Poom Netrakom</p>
                    <p><a href="https://www.facebook.com/poom.net"><img v-bind:src="`${baseUrl}/images/facebook.svg`" height="25px"> Facebook</a></p>
                </div>
                <div class="col-md-4 about-us-item">
                    <img v-bind:src="`${baseUrl}/images/about-us/dorn.jpg`" class="about-us-thumbnail img-responsive">
                    <p class="about-us-name">Dorn Nutavej</p>
                    <p><a href="https://www.facebook.com/dorn.kubpom"><img v-bind:src="`${baseUrl}/images/facebook.svg`" height="25px"> Facebook</a></p>
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