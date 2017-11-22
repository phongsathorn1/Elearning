<template>
    <footer>
        <div class="container giraffe">
            <div class="footer-mountain">
            </div>
        </div>
        <div class="main-footer">
            <div class="container">
                <div class="col-md-9">
                    <div class="footer-logo">
                        <img v-bind:src="`${baseUrl}/images/Med_logo.png`" height="50px;">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="footer-contain">
                        <router-link :to="'about-us'">About us</router-link>
                    </div>
                </div>
            </div>
        </div>
    </footer>
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