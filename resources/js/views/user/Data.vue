<template>
    <user-layout>
        <div class="container">
            <div class="jumbotron col-12">
                <h1 class="display-4">Witaj w panelu użytkownika!</h1>
            </div>
        </div>
    </user-layout>
</template>
<style scoped>

</style>
<script>
import UserLayout from '@views/layout/User'

export default {
    components: {
        UserLayout,
    },
    beforeRouteEnter (to, from, next) {
        if ( ! localStorage.getItem('jwt')) {
            return next('login')
        }
        next()
    }
}
</script>