<template>
    <footer v-if="!hide">
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
        data(){
            return {
                hide: false
            }
        },
        created(){
            this.setStyle(this.$route)
            this.$watch('$route', this.setStyle)
        },
        computed:{
            ...mapGetters([
                'baseUrl'
            ])
        },
        methods:{
            setStyle(route){
                this.transparent = false
                this.hide = false
                if(route.meta.footerstyle.hide){
                    this.hide = route.meta.footerstyle.hide
                }
            }
        }
    }
</script>