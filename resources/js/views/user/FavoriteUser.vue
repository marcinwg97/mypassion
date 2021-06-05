<template>
    <user-layout>
        <h2 class="text-3xl text-center">Obserwani użytkownicy</h2>
        <div class="table-responsive">
            <table class="table">
                <thead class="thead-light">
                    <tr class="grid grid-cols-5">
                        <th class="col-span-4">Użytkownik</th>
                        <th>Usuń</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users.data" :key="user.id"  class="grid grid-cols-5">
                        <td class="col-span-4">{{ user.name }}</td>
                        <td><form @submit.prevent="removeUserFromFavorite(user.id)"><button type="submit" class="btn btn-danger">Usuń</button></form></td>
                    </tr>
                    <pagination :data="users" @pagination-change-page="loadUsers"></pagination>
                </tbody>
            </table>
        </div>
    </user-layout>
</template>
<style scoped>

</style>
<script>
    import UserLayout from '@views/layout/User'

    export default {
        data() {
            return {
                users: {},
            }
        },
        mounted(){
            this.loadUsers();
        },
        components: {
            UserLayout,
        },
        methods:{
            loadUsers:function(page){
                if (typeof page === 'undefined') {
                    page = 1;
                }
                axios.get('/api/user/user-favorite?page=' + page).then(res=>{
                    if(res.status==200){
                        this.users=res.data;
                    }
                }).catch(err=>{
                    console.log(err)
                });
            },
            deleteUser(id){
                axios.post('/api/admin/post/delete/' + id).then((response)=>{
                    $('#success').html(response.data.message)
                    this.loadUsers();
                })
            },
            removeUserFromFavorite() {
                axios.post('/api/favorite-remove-user',{favorite_user_id: this.$route.params.id, user_id: this.user_id})
                .then((response)=>{
                    $('#success').css("display", "block");
                    $('#success').html(response.data.message);
                    window.location.reload();
                })
            },
        },
        beforeRouteEnter (to, from, next) {
        if ( ! localStorage.getItem('jwt')) {
            return next('login')
        }
        next()
        },
    }
</script>
