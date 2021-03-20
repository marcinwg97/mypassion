<template>
    <admin-layout>
        <div class="container">
            <div class="jumbotron col-12">
                <h1 class="display-4">Witaj w panelu administratora!</h1>
                <p class="lead">Znajdziesz tu wszystkie wszystkie informacje dotyczące systemu zarządzania treścią.</p>
            </div>
        </div>
    </admin-layout>
</template>
<style scoped>

</style>
<script>
import AdminLayout from '@views/layout/Admin'

export default {
    components: {
        AdminLayout,
    },
    beforeRouteEnter (to, from, next) {
        if ( ! localStorage.getItem('jwt')) {
            return next('login')
        }
        next()
    }
}
</script>
