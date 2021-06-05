<template>
    <user-layout>
        <div class="card-body table-responsive p-0">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th>Użytkownik</th>
                        <th>Usuń</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users.data" :key="user.id">
                        <td>{{ user.name }}</td>
                        <td><form @submit.prevent="deleteUser(user.id)"><button type="submit" class="btn btn-danger">Usuń</button></form></td>
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
        },
        beforeRouteEnter (to, from, next) {
        if ( ! localStorage.getItem('jwt')) {
            return next('login')
        }
        next()
        },
    }
</script>
