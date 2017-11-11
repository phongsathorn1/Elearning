<template>
</template>

<script>
    export default {
        created () {
            this.$auth.revokeToken()
            this.$router.push('/')
        }
    }
</script>