<template>
    <div id="app">
        <navbar></navbar>
        <transition name="fade">
            <router-view></router-view>
        </transition>
        <footer-component></footer-component>
    </div>
</template>

<script>
    import navbar from './components/NavbarComponent.vue'
    import footerComponent from './components/footer.vue'

    export default {
        data(){
            return {
                transparent : false
            }
        },
        components : {
            'navbar': navbar,
            footerComponent
        }
    }
</script>
