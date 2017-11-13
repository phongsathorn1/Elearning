<template>
    <div id="app">
        <navbar></navbar>
        <transition name="fade">
            <router-view></router-view>
        </transition>
    </div>
</template>

<script>
    import navbar from './components/NavbarComponent.vue'

    export default {
        components : {
            'navbar': navbar
        }
    }
</script>
